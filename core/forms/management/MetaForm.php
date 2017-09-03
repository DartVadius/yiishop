<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 20:05
 */

namespace core\forms\management;


use core\entities\meta\Meta;
use yii\base\Model;

class MetaForm extends Model {
    public $title;
    public $description;
    public $keywords;
    public function __construct(Meta $meta = null, array $config = []) {
        if($meta) {
            $this->title = $meta->title;
            $this->description = $meta->description;
            $this->keywords = $meta->keywords;
        }
        parent::__construct($config);
    }
    public function rules() {
        return [
            [['title'], 'string', 'max' => 255],
            [['description', 'keywords'], 'string'],
        ];
    }
}