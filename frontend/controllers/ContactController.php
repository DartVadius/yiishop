<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 25.08.17
 * Time: 21:38
 */

namespace frontend\controllers;


use yii\web\Controller;
use Yii;
use core\services\contact\ContactService;
use core\forms\auth\ContactForm;

class ContactController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $form = new ContactForm();
        $service = Yii::$container->get(ContactService::class);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $service->send($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $form,
        ]);
    }
}