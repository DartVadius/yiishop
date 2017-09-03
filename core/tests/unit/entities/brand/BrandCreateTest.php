<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 15:31
 */

namespace unit\entities\brand;

use Codeception\Test\Unit;
use core\entities\brand\Brand;
use core\entities\meta\Meta;

class BrandCreateTest extends Unit {
    public function testSuccess() {
        $brand = Brand::create(
            $name = 'name',
            $slug = 'slug',
            $meta = new Meta('Title', 'Description', 'keywords')
        );
        $this->assertEquals($name, $brand->name);
        $this->assertEquals($slug, $brand->slug);
        $this->assertEquals($meta, $brand->meta);
    }
}