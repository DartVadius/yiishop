<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.09.17
 * Time: 21:04
 */

namespace core\entities\product\events;


use core\entities\product\Product;

class ProductAppearedInStock {
    public $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }
}