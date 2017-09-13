<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 12.09.17
 * Time: 18:55
 */

namespace core\forms\management\product;


use core\entities\brand\Brand;
use core\entities\characteristic\Characteristic;
use core\entities\product\Product;
use core\forms\management\characteristic\CharacteristicForm;
use core\forms\management\CompositeForm;
use core\forms\management\MetaForm;
use yii\helpers\ArrayHelper;

class ProductEditForm extends CompositeForm {

    public $brandId;
    public $code;
    public $name;
    public $description;
    public $weight;

    private $_product;

    public function __construct(Product $product, $config = []) {
        $this->brandId = $product->brand_id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->weight = $product->weight;
        $this->meta = new MetaForm($product->meta);
        $this->categories = new CategoryForm($product);
        $this->tags = new TagsForm($product);
        $this->values = array_map(function (CharacteristicForm $characteristic) use ($product) {
            return new CharacteristicsForm($characteristic, $product->getValue($characteristic->id));
        }, Characteristic::find()->orderBy('sort')->all());
        $this->_product = $product;
        parent::__construct($config);
    }

    public function rules(): array {
        return [
            [['brandId', 'code', 'name', 'weight'], 'required'],
            [['brandId'], 'integer'],
            [['code', 'name'], 'string', 'max' => 255],
            [['code'], 'unique', 'targetClass' => Product::class, 'filter' => $this->_product ? ['<>', 'id', $this->_product->id] : null],
            ['description', 'string'],
            ['weight', 'integer', 'min' => 0],
        ];
    }

    public function brandsList(): array {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array {
        return ['meta', 'category', 'tags', 'characteristics'];
    }

}