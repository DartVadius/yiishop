<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 15:33
 */
namespace core\entities\brand;

use core\entities\behaviors\MetaBehavior;
use core\entities\meta\Meta;
use yii\db\ActiveRecord;

/**
 * Class Brand
 * @package core\entities\brand
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Meta $meta
 */
class Brand extends ActiveRecord {
    public $id;
    public $name;
    public $slug;
    public $meta;

    public static function create($name, $slug, Meta $meta) {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $slug, Meta $meta) {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }

    public static function tableName() {
        return '{{%brands}}';
    }

    public function behaviors() {
        return [
            MetaBehavior::className(),
        ];
    }
}