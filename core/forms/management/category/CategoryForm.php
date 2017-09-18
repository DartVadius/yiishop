<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 20:42
 */

namespace core\forms\management\category;


use core\entities\category\Category;
use core\forms\management\CompositeForm;
use core\forms\management\MetaForm;
use core\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * Class CategoryForm
 *
 * @property integer  $id
 * @property string   $name
 * @property string   $slug
 * @property string   $title
 * @property string   $description
 * @property MetaForm $meta
 *
 *
 */
class CategoryForm extends CompositeForm {
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;

    private $_category;

    public function __construct(Category $category = null, array $config = []) {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['parentId'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::className()],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null],
        ];
    }

    public function parentCategoriesList(): array {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }

    public function internalForms() {
        return ['meta'];
    }
}