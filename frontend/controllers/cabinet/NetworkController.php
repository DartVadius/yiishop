<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 27.08.17
 * Time: 12:39
 */

namespace frontend\controllers\cabinet;


use yii\helpers\Url;
use yii\web\Controller;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use core\services\auth\NetworkService;
use Yii;
use yii\helpers\ArrayHelper;

class NetworkController extends Controller {
    public function actions() {
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
                'successUrl' => Url::to(['cabinet/index/index'])
            ],
        ];
    }
    public function onAuthSuccess(ClientInterface $client) {
        $service = Yii::$container->get(NetworkService::class);
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');
        try {
            $user = $service->attach(Yii::$app->user->id, $network, $identity);
            Yii::$app->session->setFlash('success', 'Network attached');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}