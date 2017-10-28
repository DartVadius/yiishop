<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 18.09.17
 * Time: 21:24
 */

namespace core\helpers;


use core\entities\characteristic\Characteristic;
use yii\helpers\ArrayHelper;

class CharacteristicHelper {
    public static function typeList() {
        return [
            Characteristic::TYPE_STRING => 'String',
            Characteristic::TYPE_INTEGER => 'Integer number',
            Characteristic::TYPE_FLOAT => 'Float number',
        ];
    }

    public static function typeName($type) {
        return ArrayHelper::getValue(self::typeList(), $type);
    }
}