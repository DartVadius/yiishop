<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 27.08.17
 * Time: 13:43
 */

namespace core\helpers;

use core\entities\user\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper {
    public static function userStatusList() {
        return [
            User::STATUS_ACTIVE => 'Active',
            User::STATUS_WAIT => 'Wait',
        ];
    }

    public static function statusName($status) {
        return ArrayHelper::getValue(self::userStatusList(), $status);
    }

    public static function statusLabel($status) {
        switch ($status) {
            case User::STATUS_WAIT:
                $class = 'label label-default';
                break;
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::userStatusList(), $status), [
            'class' => $class,
        ]);
    }

}