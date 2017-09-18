<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 19:49
 */

namespace core\forms\management\brand;


use core\entities\brand\Brand;
use core\forms\management\CompositeForm;
use core\forms\management\MetaForm;
use core\validators\SlugValidator;

/**
 * Class BrandForm
 * @package core\forms\management\brand
 *
 * @property MetaForm $meta
 */
class BrandForm extends CompositeForm {
    public $name;
    public $slug;

    private $_brand;

    public function __construct(Brand $brand = null, array $config = []) {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function internalForms() {
        return ['meta'];
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::className()],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null],
        ];
    }
}