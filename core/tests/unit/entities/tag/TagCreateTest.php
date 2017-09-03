<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 31.08.17
 * Time: 20:30
 */

namespace unit\entities\tag;

use Codeception\Test\Unit;
use core\entities\tag\Tag;

class TagCreateTest extends Unit {
    public function testSuccess() {
        $tag = Tag::create(
            $name = 'name',
            $slug = 'slug'
        );

        $this->assertEquals($name, $tag->name);
        $this->assertEquals($slug, $tag->slug);
    }

}
