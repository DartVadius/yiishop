<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 06.09.17
 * Time: 20:00
 */

namespace core\forms\management\characteristic;


use core\entities\characteristic\Characteristic;
use yii\base\Model;

class CharacteristicForm extends Model {

    public $name;
    public $type;
    public $required;
    public $default;
    public $sort;
    public $variants;

    private $_characteristic;

    public function __construct(Characteristic $characteristic = null, array $config = []) {
        if ($characteristic) {
            $this->name = $characteristic->name;
            $this->type = $characteristic->type;
            $this->required = $characteristic->required;
            $this->default = $characteristic->default;
            $this->variants = implode(PHP_EOL, $characteristic->variants);
            $this->sort = $characteristic->sort;
            $this->_characteristic = $characteristic;
        } else {
            $this->sort = Characteristic::find()->max('sort') +1;
        }
        parent::__construct($config);
    }
    public function rules() {
        return [
            [['name', 'type', 'sort'], 'required'],
            [['required'], 'boolean'],
            [['default'], 'string', 'max' => 255],
            [['variants'], 'string'],
            [['sort'], 'integer'],
            [['name'], 'unique', 'targetClass' => Characteristic::class, 'filter' => $this->_characteristic ? ['<>', 'id', $this->_characteristic->id] : null],
        ];
    }
    public function getVariants() {
        return preg_split('#[\r\n]+#i', $this->variants);
    }
}