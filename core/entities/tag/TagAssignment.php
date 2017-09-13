<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 12.09.17
 * Time: 16:55
 */

namespace core\entities\tag;


use yii\db\ActiveRecord;

/**
 * @property integer $product_id;
 * @property integer $tag_id    ;
 */
class TagAssignment extends ActiveRecord {
    public static function create($tagId): self {
        $assignment = new static();
        $assignment->tag_id = $tagId;
        return $assignment;
    }

    public function isForTag($id): bool {
        return $this->tag_id == $id;
    }

    public static function tableName(): string {
        return '{{%shop_tag_assignment}}';
    }
}