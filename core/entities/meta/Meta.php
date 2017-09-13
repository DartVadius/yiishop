<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 15:35
 */

namespace core\entities\meta;

use yii\db\ActiveRecord;

class Meta extends ActiveRecord {
    public $title;
    public $description;
    public $keywords;

    public function __construct($title, $description, $keywords) {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }
}