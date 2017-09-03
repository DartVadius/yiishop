<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 12:51
 */

namespace core\repository;

use core\entities\brand\Brand;

class BrandRepository {
    /**
     * @param $id
     *
     * @return Brand
     */
    public function getById($id) {
        if (!$brand = Brand::findOne($id)) {
            throw new \PDOException('Brand not found');
        }
        return $brand;
    }

    public function save(Brand $brand) {
        if (!$brand->save()) {
            throw new \DomainException('Brand is not saved');
        }
    }

    public function delete(Brand $brand) {
        if (!$brand->delete()) {
            throw new \DomainException('Remove error');
        }
    }
}