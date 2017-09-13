<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 04.09.17
 * Time: 21:09
 */

namespace core\services\management;


use core\entities\category\Category;
use core\entities\meta\Meta;
use core\forms\management\category\CategoryForm;
use core\repository\CategoryRepository;

class CategoryManagmentService {
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CategoryForm $categoryForm) {
        $parent = $this->categoryRepository->getById($categoryForm->parentId);
        $category = Category::create(
            $categoryForm->name,
            $categoryForm->slug,
            $categoryForm->title,
            $categoryForm->description,
            new Meta($categoryForm->meta->title, $categoryForm->meta->description, $categoryForm->meta->keywords)
        );
        $category->appendTo($parent);
        $this->categoryRepository->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $categoryForm) {
        $category = $this->categoryRepository->getById($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $categoryForm->name,
            $categoryForm->slug,
            $categoryForm->title,
            $categoryForm->description,
            new Meta($categoryForm->meta->title, $categoryForm->meta->description, $categoryForm->meta->keywords)
        );
        if ($categoryForm->parentId !== $category->parent->id) {
            $parent = $this->categoryRepository->getById($categoryForm->parentId);
            $category->appendTo($parent);
        }
        $this->categoryRepository->save($category);
    }

    public function remove($id) {
        $category = $this->categoryRepository->getById($id);
        $this->assertIsNotRoot($category);
        $this->categoryRepository->delete($category);
    }

    private function assertIsNotRoot(Category $category) {
        if ($category->isRoot()) {
            throw new \DomainException('Unable to change the root directory');
        }
    }
}