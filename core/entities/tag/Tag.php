<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 31.08.17
 * Time: 21:00
 */


namespace core\entities\tag;

use yii\db\ActiveRecord;

/**
 * Class Tag
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Tag extends ActiveRecord {

    public static function create($name, $slug) {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug) {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName() {
        return '{{%shop_tag}}';
    }
}