<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.08.17
 * Time: 16:47
 */

namespace frontend\controllers;


use core\services\auth\NetworkService;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;

class NetworkController extends Controller {
    public function actions() {
        return [
            'auth' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'onAuthSuccess'],
                'successUrl' => Url::to(['index'])
            ],
        ];
    }
    public function onAuthSuccess(ClientInterface $client) {
        $service = Yii::$container->get(NetworkService::class);
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');
        try {
            $user = $service->auth($network, $identity);
            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}