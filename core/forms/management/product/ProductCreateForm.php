<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 10.09.17
 * Time: 18:32
 */

namespace core\forms\management\product;

use core\entities\brand\Brand;
use core\entities\characteristic\Characteristic;
use core\entities\product\Product;
use core\forms\management\CompositeForm;
use core\forms\management\MetaForm;
use yii\helpers\ArrayHelper;

/**
 * @property PriceForm $price
 * @property QuantityForm $quantity
 * @property MetaForm $meta
 * @property CategoryForm $categories
 * @property PhotoForm $photos
 * @property TagsForm $tags
 * @property CharacteristicsForm[] $characteristicsValues
 */
class ProductCreateForm extends CompositeForm {
    public $brandId;
    public $code;
    public $name;
    public $description;
    public $weight;
    public $quantity;

    public function __construct(array $config = []) {
        $this->price = new PriceForm();
//        $this->quantity = new QuantityForm();
        $this->meta = new MetaForm();
        $this->categories = new CategoryForm();
        $this->photos = new PhotoForm();
        $this->tags = new TagsForm();
        $this->characteristicsValues = array_map(function (Characteristic $characteristic) {
            return new CharacteristicsForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['brandId', 'code', 'name', 'weight'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brandId', 'quantity'], 'integer'],
            [['code'], 'unique', 'targetClass' => Product::class],
            ['description', 'string'],
            ['weight', 'integer', 'min' => 0],
        ];
    }

    public function brandsList() {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms() {
        return [
            'price',
            'meta',
            'photos',
            'categories',
            'tags',
            'characteristicsValues',
//            'quantity',
        ];
    }
}