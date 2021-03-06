<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 11.09.17
 * Time: 23:36
 */

namespace core\entities\product;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Photo extends ActiveRecord {
    public $file;
    public $sort;
    public $id;

    public static function create(UploadedFile $file) {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort) {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id) {
        return $this->id == $id;
    }

    public static function tableName() {
        return '{{%shop_photos}}';
    }

    public function behaviors(): array {
        return [
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'cart_list' => ['width' => 150, 'height' => 150],
                    'cart_widget_list' => ['width' => 57, 'height' => 57],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_product_main' => ['processor' => [new WaterMarker(750, 1000, '@frontend/web/image/logo.png'), 'process']],
                    'catalog_product_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['processor' => [new WaterMarker(1024, 768, '@frontend/web/image/logo.png'), 'process']],
                ],
            ],
        ];
    }
}