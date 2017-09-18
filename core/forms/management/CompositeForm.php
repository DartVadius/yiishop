<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 13:04
 */

namespace core\forms\management;


use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class CompositeForm extends Model {
    /**
     * @var Model[]
     */
    private $forms = [];

    abstract protected function internalForms();

    public function load($data, $formName = null) {
        $ok = parent::load($data, $formName);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $ok = Model::loadMultiple($form, $data, $formName ? null : $name) && $ok;
            } else {
                $ok = $form->load($data, $formName !== '' ? null : $name) && $ok;
            }

        }
        return $ok;
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        $parentNames = $attributeNames !== null ? array_filter($attributeNames, 'is_string') : null;
        $ok = parent::validate($parentNames, $clearErrors);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $ok = Model::validateMultiple($form) && $ok;
            } else {
                $childNames = $attributeNames !== null ? ArrayHelper::getValue($attributeNames, $name) : null;
                $ok = $form->validate($childNames, $clearErrors) && $ok;
            }

        }
        return $ok;
    }

    public function __get($name) {
        if (isset($this->forms[$name])) {
            return $this->forms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value) {
        if (in_array($name, $this->internalForms(), true)) {
            $this->forms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name) {
        return isset($this->forms[$name]) || parent::__isset($name);
    }
}