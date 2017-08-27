<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 25.08.17
 * Time: 21:24
 */

namespace frontend\controllers;


use yii\web\Controller;
use Yii;
use core\services\auth\PasswordResetService;
use core\services\auth\AuthService;
use core\services\auth\SignupService;
use yii\web\BadRequestHttpException;
use core\forms\auth\LoginForm;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use core\forms\auth\SignupForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AuthController extends Controller {


    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        $authService = Yii::$container->get(AuthService::class);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $form = new SignupForm();
        $signupService = Yii::$container->get(SignupService::class);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {
                $user = $signupService->signup($form);
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', 'Check your email for confirmation');
                    return $this->goHome();
                }
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }
    /*@var $service SignupService */
    public function actionConfirm($token) {
        $service = Yii::$container->get(SignupService::class);
        try {
            $service->confirm($token);
            Yii::$app->session->setFlash('success', 'Email confirmed');
            return $this->redirect(['login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->goHome();
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $service = Yii::$container->get(PasswordResetService::class);

        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {
                $service->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {

//        $service = new PasswordResetService();
        $service = Yii::$container->get(PasswordResetService::class);

        try {
            $service->validateToken($token);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->goHome();
        }

        $form = new ResetPasswordForm($token);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'New password saved.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }
}