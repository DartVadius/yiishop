<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 04.09.17
 * Time: 21:10
 */

namespace core\repository;


use core\entities\category\Category;

class CategoryRepository {
    /**
     * @param $id
     *
     * @return Category
     */
    public function getById($id) {
        if (!$category = Category::findOne($id)) {
            throw new \PDOException('Brand not found');
        }
        return $category;
    }

    public function save(Category $category) {
        if (!$category->save()) {
            throw new \DomainException('Brand is not saved');
        }
    }

    public function delete(Category $category) {
        if (!$category->delete()) {
            throw new \DomainException('Remove error');
        }
    }
}