<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.09.17
 * Time: 20:20
 */

namespace core\helpers;


class WeightHelper {
    public static function format($weight): string {
        return $weight / 1000 . ' kg';
    }
}