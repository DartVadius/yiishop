<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:15
 */

namespace core\forms\management\product;


use core\entities\product\Product;
use yii\base\Model;

class PriceForm extends Model {
    public $old;
    public $new;

    public function __construct(Product $product= null, array $config = []) {
        if ($product) {
            $this->old = $product->price_old;
            $this->new = $product->price_new;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['new'], 'required'],
            [['old', 'new'], 'integer', 'min' => 0],
        ];
    }
}