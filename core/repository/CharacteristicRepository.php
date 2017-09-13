<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 06.09.17
 * Time: 20:19
 */

namespace core\repository;


use core\entities\characteristic\Characteristic;

class CharacteristicRepository {
    /**
     * @param $id
     *
     * @return Category
     */
    public function getById($id) {
        if (!$characteristic = Characteristic::findOne($id)) {
            throw new \PDOException('Brand not found');
        }
        return $characteristic;
    }

    public function save(Characteristic $characteristic) {
        if (!$characteristic->save()) {
            throw new \DomainException('Brand is not saved');
        }
    }

    public function delete(Characteristic $characteristic) {
        if (!$characteristic->delete()) {
            throw new \DomainException('Remove error');
        }
    }
}