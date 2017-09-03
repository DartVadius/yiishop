<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 13:51
 */

namespace core\validators;


use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator {
    public $pattern = '/^[a-z0-9_-]*$/s';
    public $message = 'Only a-z0-9_- allowed';
}