<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 24.08.17
 * Time: 19:26
 */
use yii\helpers\Html;
/* @var $user \core\entities\user\User */
/* @var $this yii\web\View */

$confirm = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>

<div>
    <p>Hi <?= Html::encode($user->username) ?></p>
    <p>you must confirm email</p>
    <p>Click on <a href="<?=$confirm?>">link</a> below</p>
</div>

