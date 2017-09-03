<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 14:26
 */

namespace core\forms\management\user;

use core\entities\tag\Tag;
use core\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model {
    public $name;
    public $slug;

    private $_tag;

    public function __construct(Tag $tag = null, array $config = []) {
        if ($tag) {
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::className()],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class],
        ];
    }
}