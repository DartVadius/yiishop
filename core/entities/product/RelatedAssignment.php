<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 12.09.17
 * Time: 18:47
 */

namespace core\entities\product;


use yii\db\ActiveRecord;

/**
 * @property integer $product_id;
 * @property integer $related_id;
 */
class RelatedAssignment extends ActiveRecord {
    public static function create($productId): self {
        $assignment = new static();
        $assignment->related_id = $productId;
        return $assignment;
    }

    public function isForProduct($id): bool {
        return $this->related_id == $id;
    }

    public static function tableName(): string {
        return '{{%shop_related_assignments}}';
    }
}