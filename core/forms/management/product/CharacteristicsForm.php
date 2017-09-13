<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:47
 */

namespace core\forms\management\product;


use core\entities\characteristic\Characteristic;
use core\entities\characteristic\Value;
use yii\base\Model;

class CharacteristicsForm extends Model {

    public $value;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, Value $value = null, array $config = []) {
        if ($value) {
            $this->value = $value->value;
        }
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    public function rules() {
        return array_filter([
            $this->_characteristic->required ? ['value', 'required'] : false,
            $this->_characteristic->isString() ? ['value', 'string', 'max' => 255] : false,
            $this->_characteristic->isInteger() ? ['value', 'integer'] : false,
            $this->_characteristic->isFloat() ? ['value', 'number'] : false,
            ['value', 'safe'],
        ]);
    }

    public function attributeLabels() {
        return [
            'value' => $this->_characteristic->name,
        ];
    }

    public function getId() {
        return $this->_characteristic->id;
    }

}