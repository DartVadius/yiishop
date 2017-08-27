<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.08.17
 * Time: 13:49
 */

namespace backend\controllers;


use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use core\forms\auth\LoginForm;
use core\services\auth\AuthService;

class AuthController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $form = new LoginForm();
        $service = Yii::$container->get(AuthService::class);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $service->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
            }
        }
        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}