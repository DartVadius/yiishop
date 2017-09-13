<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 10.09.17
 * Time: 19:59
 */

namespace core\entities\product;


use yii\db\ActiveRecord;

class CategoryAssignment extends ActiveRecord {
    public $category_id;
    public static function create($categoryId) {
        $assignment = new self();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    public function isForCategory($id) {
        return $this->category_id == $id;
    }

    public static function tableName() {
        return '{{%shop_category_assignment}}';
    }
}