<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 14:40
 */

namespace core\repository;

use core\entities\tag\Tag;


class TagRepository {
    /**
     * @param $id
     *
     * @return Tag
     */
    public function getById($id) {
        if (!$tag = Tag::findOne($id)) {
            throw new \PDOException('Tag not found');
        }
        return $tag;
    }

    public function save(Tag $tag) {
        if (!$tag->save()) {
            throw new \DomainException('Tag is not saved');
        }
    }

    public function delete(Tag $tag) {
        if (!$tag->delete()) {
            throw new \DomainException('Remove error');
        }
    }
}