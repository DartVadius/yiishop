<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:25
 */

namespace core\forms\management\product;


use core\entities\product\Product;
use core\entities\tag\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TagsForm extends Model {
    public $exist = [];
    public $textNew;

    public function __construct(Product $product = null, array $config = []) {
        if ($product) {
            $this->exist = ArrayHelper::getColumn($product->tagAssigments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            ['exist', 'each', 'rule' => ['integer']],
        ];
    }

    public function tagsList() {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function getNewNames() {
        return array_map('trim', preg_split('#\s*,\s*#i', $this->textNew));
    }

    public function beforeValidate() {
        $this->exist = array_filter((array)$this->exist);
        return parent::beforeValidate();
    }
}