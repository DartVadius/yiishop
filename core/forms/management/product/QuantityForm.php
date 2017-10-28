<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.09.17
 * Time: 20:16
 */

namespace core\forms\management\product;


use core\entities\product\Product;
use yii\base\Model;

class QuantityForm extends Model {
    public $quantity;

    public function __construct(Product $product = null, $config = []) {
        if ($product) {
            $this->quantity = $product->quantity;
        }
        parent::__construct($config);
    }

    public function rules(): array {
        return [
            [['quantity'], 'required'],
            [['quantity'], 'integer', 'min' => 0],
        ];
    }
}