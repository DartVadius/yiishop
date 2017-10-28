<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.09.17
 * Time: 20:08
 */

namespace core\helpers;


class PriceHelper {
    public static function format($price) {
        return number_format($price, 0, '.', ' ');
    }
}