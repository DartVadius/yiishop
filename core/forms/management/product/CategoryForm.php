<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:36
 */

namespace core\forms\management\product;


use core\entities\product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoryForm extends Model {
    public $main;
    public $additional = [];

    public function __construct(Product $product = null, array $config = []) {
        if ($product) {
            $this->main = $product->category_id;
            $this->additional = ArrayHelper::getColumn($product->categoryAssigment, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            ['main', 'required'],
            ['main', 'integer'],
            ['additional', 'each', 'rules' => ['integer']],
        ];
    }
}