<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 12.09.17
 * Time: 19:18
 */

namespace core\entities\product;


use yii\db\ActiveRecord;

class Modification extends ActiveRecord {
    public static function create($code, $name, $price, $quantity) {
        $modification = new static();
        $modification->code = $code;
        $modification->name = $name;
        $modification->price = $price;
        $modification->quantity = $quantity;
        return $modification;
    }

    public function edit($code, $name, $price, $quantity) {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function checkout($quantity) {
        if ($quantity > $this->quantity) {
            throw new \DomainException('Only ' . $this->quantity . ' items are available.');
        }
        $this->quantity -= $quantity;
    }

    public function isIdEqualTo($id) {
        return $this->id == $id;
    }

    public function isCodeEqualTo($code) {
        return $this->code === $code;
    }

    public static function tableName(): string {
        return '{{%shop_modifications}}';
    }
}