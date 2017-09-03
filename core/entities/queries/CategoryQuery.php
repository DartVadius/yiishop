<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 20:32
 */

namespace core\entities\queries;


use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery {
    use NestedSetsQueryTrait;
}