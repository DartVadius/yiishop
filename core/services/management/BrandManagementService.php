<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 03.09.17
 * Time: 12:58
 */

namespace core\services\management;


use core\entities\brand\Brand;
use core\entities\meta\Meta;
use core\forms\management\brand\BrandForm;
use core\repository\BrandRepository;
use core\repository\ProductRepository;

class BrandManagementService {
    private $brandRepository;
    private $productRepository;

    public function __construct(BrandRepository $brandRepository, ProductRepository $productRepository) {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
    }

    public function create(BrandForm $form) {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brandRepository->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form) {
        $brand = $this->brandRepository->getById($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brandRepository->save($brand);
        return $brand;
    }

    public function remove($id) {
        $brand = $this->brandRepository->getById($id);
        if ($this->productRepository->existsByBrand($brand->id)) {
            throw new \DomainException('Unable to remove brand with products');
        }
        $this->brandRepository->delete($brand);
    }
}