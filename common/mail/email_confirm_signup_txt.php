<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 24.08.17
 * Time: 19:26
 */

use yii\helpers\Html;

/* @var $user \common\entities\User */
/* @var $this yii\web\View */

$confirm = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>


Hi <?= Html::encode($user->username) ?>
you must confirm email
Click on link below <?= $confirm ?>
