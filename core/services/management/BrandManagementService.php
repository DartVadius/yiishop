<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 12:58
 */

namespace core\services\management;


use core\repository\BrandRepository;

class BrandManagementService {
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository) {
        $this->brandRepository = $brandRepository;
    }
}