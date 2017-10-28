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
use yii\helpers\ArrayHelper;

class CharacteristicsForm extends Model {

    public $value;

    private $_characteristic;

    public function __construct(Characteristic $characteristic, Value $value = null, $config = []) {
        if ($value) {
            $this->value = $value->value;
        }
        $this->_characteristic = $characteristic;
        parent::__construct($config);
    }

    public function rules(): array {
        return array_filter([
            $this->_characteristic->required ? ['value', 'required'] : false,
            $this->_characteristic->isString() ? ['value', 'string', 'max' => 255] : false,
            $this->_characteristic->isInteger() ? ['value', 'integer'] : false,
            $this->_characteristic->isFloat() ? ['value', 'number'] : false,
            ['value', 'safe'],
        ]);
    }

    public function attributeLabels(): array {
        return [
            'value' => $this->_characteristic->name,
        ];
    }

    public function variantsList(): array {
        return $this->_characteristic->variants ? array_combine($this->_characteristic->variants, $this->_characteristic->variants) : [];
    }

    public function getId(): int {
        return $this->_characteristic->id;
    }

}