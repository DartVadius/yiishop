<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 10.09.17
 * Time: 19:00
 */

namespace core\repository;


use core\entities\product\Product;

class ProductRepository {
    /**
     * @param $id
     *
     * @return Product
     */
    public function getById($id) {
        if (!$product = Product::findOne($id)) {
            throw new \PDOException('Product not found');
        }
        return $product;
    }

    public function save(Product $product) {
        if (!$product->save()) {
            throw new \DomainException('Product is not saved');
        }
    }

    public function delete(Product $product) {
        if (!$product->delete()) {
            throw new \DomainException('Remove error');
        }
    }
}