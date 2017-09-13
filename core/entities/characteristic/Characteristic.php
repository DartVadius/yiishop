<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 06.09.17
 * Time: 19:43
 */

namespace core\entities\characteristic;


use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Characteristic
 *
 */
class Characteristic extends ActiveRecord {

    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';

    public $variants;
    public $name;
    public $type;
    public $required;
    public $default;
    public $sort;
    public $id;

    public static function create($name, $type, $required, $default, array $variants, $sort) {
        $characteristic = new static();
        $characteristic->name = $name;
        $characteristic->type = $type;
        $characteristic->required = $required;
        $characteristic->default = $default;
        $characteristic->variants = $variants;
        $characteristic->sort = $sort;
        return $characteristic;
    }

    public function edit($name, $type, $required, $default, array $variants, $sort) {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->default = $default;
        $this->variants = $variants;
        $this->sort = $sort;
    }

    public static function tableName() {
        return '{{%product_characteristic}}';
    }

    public function isSelect() {
        return (empty($this->variants)) ? false : true;
    }

    public function isString() {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger() {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat() {
        return $this->type === self::TYPE_FLOAT;
    }

    public function afterFind() {
        $this->variants = Json::decode($this->getAttribute('variants_json'));
        parent::afterFind();
    }

    public function beforeSave($insert) {
        $this->setAttribute('variants_json', Json::encode($this->variants));
        return parent::beforeSave($insert);
    }

}