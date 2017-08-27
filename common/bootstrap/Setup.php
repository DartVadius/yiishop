<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 17.08.17
 * Time: 20:14
 */

namespace common\bootstrap;


use core\services\auth\AuthService;
use core\services\auth\NetworkService;
use core\services\auth\PasswordResetService;
use core\services\contact\ContactService;
use core\services\auth\SignupService;
use core\services\management\UserManagementService;
use yii\base\BootstrapInterface;
use Yii;
use yii\mail\MailerInterface;

class Setup implements BootstrapInterface {
    public function bootstrap($app) {
        $container = Yii::$container;
//        $container->setSingleton(PasswordResetService::class, function () use ($app) {
//            return new PasswordResetService([$app->params['supportEmail'] => Yii::$app->name . ' robot']);
//        });
//        $container->setSingleton('defaultMailer', function () use ($app) {
//            return $app->mailer;
//        });
        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });
        $container->setSingleton(PasswordResetService::class, [], [
            [$app->params['supportEmail'] => Yii::$app->name . ' robot'],
        ]);
//        $container->setSingleton(PasswordResetService::class, [], [
//            [$app->params['supportEmail'] => Yii::$app->name . ' robot'],
//            $app->mailer
//        ]);
        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail'],
        ]);

        $container->setSingleton(SignupService::class, [], []);
        $container->setSingleton(AuthService::class, [], []);
        $container->setSingleton(NetworkService::class, [], []);
        $container->setSingleton(UserManagementService::class, [], []);
    }
}