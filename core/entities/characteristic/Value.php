<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:50
 */

namespace core\entities\characteristic;


use yii\db\ActiveRecord;

class Value extends ActiveRecord {
    public $value;
    public $characteristic_id;

    public static function create($characteristicId, $value) {
        $val = new static();
        $val->characteristic_id = $characteristicId;
        $val->value = $value;
        return $val;
    }

    public static function blank($characteristicId) {
        $val = new static();
        $val->characteristic_id = $characteristicId;
        return $val;
    }


    public function isForCharacteristic($id) {
        return $this->characteristic_id == $id;
    }

    public function change($value) {
        $this->value = $value;
    }

    public function getCharacteristic() {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }

    public static function tableName() {
        return '{{%shop_value}}';
    }
}