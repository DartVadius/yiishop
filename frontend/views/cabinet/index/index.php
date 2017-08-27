<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Hello</p>

    <h3>Add new social network</h3>
    <?= AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]);
    ?>
</div>

