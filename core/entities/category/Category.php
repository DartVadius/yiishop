<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 19:50
 */

namespace core\entities\category;


use core\entities\behaviors\MetaBehavior;
use core\entities\meta\Meta;
use core\entities\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

/**
 * Class Category
 *
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 *
 * @property Category $parent
 */

class Category extends ActiveRecord {
    public $id;
    public $name;
    public $slug;
    public $title;
    public $description;
    public $lft;
    public $rgt;
    public $depth;
    public $meta;
    public $parent;

    public static function create($name, $slug, $title, $description, Meta $meta) {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
    }

    public function edit($name, $slug, $title, $description, Meta $meta) {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
    }

    public static function tableName() {
        return '{{%product_category}}';
    }

    public function behaviors() {
        return [
            MetaBehavior::className(),
            NestedSetsBehavior::className(),
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find() {
        return new CategoryQuery(static::class);
    }

}