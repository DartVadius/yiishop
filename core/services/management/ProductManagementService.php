<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 10.09.17
 * Time: 18:59
 */

namespace core\services\management;


use core\entities\category\Category;
use core\entities\meta\Meta;
use core\entities\product\Product;
use core\entities\tag\Tag;
use core\forms\management\product\CategoryForm;
use core\forms\management\product\PhotoForm;
use core\forms\management\product\ProductCreateForm;
use core\forms\management\product\ProductEditForm;
use core\repository\BrandRepository;
use core\repository\CategoryRepository;
use core\repository\ProductRepository;
use core\repository\TagRepository;
use core\services\TransactionManager;

class ProductManagementService {
    private $product;
    private $brand;
    private $category;
    private $tag;
    private $transaction;

    public function __construct(ProductRepository $productRepository,
                                BrandRepository $brandRepository,
                                CategoryRepository $categoryRepository,
                                TagRepository $tagRepository,
                                TransactionManager $manager) {
        $this->product = $productRepository;
        $this->brand = $brandRepository;
        $this->category = $categoryRepository;
        $this->tag = $tagRepository;
        $this->transaction = $manager;
    }

    public function create(ProductCreateForm $productCreateForm) {
        $brand = $this->brand->getById($productCreateForm->brandId);
        $category = $this->category->getById($productCreateForm->categories->main);
        $product = Product::create(
            $brand->id,
            $category->id,
            $productCreateForm->code,
            $productCreateForm->name,
            $productCreateForm->description,
            $productCreateForm->weight,
            $productCreateForm->quantity,
            new Meta(
                $productCreateForm->meta->title,
                $productCreateForm->meta->description,
                $productCreateForm->meta->keywords
            )
        );
        $product->setPrice($productCreateForm->price->new, $productCreateForm->price->old);

        foreach ($productCreateForm->categories->additional as $otherId) {
            $category = $this->category->getById($otherId);
            $product->assignCategory($category->id);
        }

        foreach ($productCreateForm->characteristicsValues as $value) {
            $product->setValue($value->id, $value->value);
        }

        foreach ($productCreateForm->photos->files as $file) {
            $product->addPhoto($file);
        }

        foreach ($productCreateForm->tags->exist as $tagId) {
            $tag = $this->tag->getById($tagId);
            $product->assignTag($tag->id);
        }

        $this->transaction->wrap(function () use ($product, $productCreateForm) {
            foreach ($productCreateForm->tags->newNames as $tagName) {
                if (!$tag = $this->tag->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tag->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->product->save($product);
        });
        return $product;
    }

    public function edit($id, ProductEditForm $form) {
        /**@var Product $product*/
        $product = $this->product->getById($id);
        $brand = $this->brand->getById($form->brandId);
        $category = $this->category->getById($form->categories->main);

        $product->edit(
            $brand->id,
            $form->code,
            $form->name,
            $form->description,
            $form->weight,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->changeMainCategory($category->id);

        $this->transaction->wrap(function () use ($product, $form) {

            $product->revokeCategories();
            $product->revokeTags();
            $this->product->save($product);

            foreach ($form->categories->others as $otherId) {
                $category = $this->category->getById($otherId);
                $product->assignCategory($category->id);
            }

            foreach ($form->values as $value) {
                $product->setValue($value->id, $value->value);
            }

            foreach ($form->tags->existing as $tagId) {
                $tag = $this->tag->getById($tagId);
                $product->assignTag($tag->id);
            }
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tag->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tag->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->product->save($product);
        });
    }

    public function changeCategories($id, CategoryForm $form) {
        /** @var Product $product */
        /** @var Category $category */
        $product = $this->product->getById($id);
        $category = $this->category->getById($form->main);
        $product->changeMainCategory($category->id);
        $product->revokeCategories();
        foreach ($form->additional as $otherId) {
            $category = $this->category->getById($otherId);
            $product->assignCategory($category->id);
        }
        $this->product->save($product);
    }

    public function addPhotos($id, PhotoForm $form) {
        /** @var Product $product */
        $product = $this->product->getById($id);
        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }
        $this->product->save($product);
    }

    public function movePhotoUp($id, $photoId) {
        /** @var Product $product */
        $product = $this->product->getById($id);
        $product->movePhotoUp($photoId);
        $this->product->save($product);
    }

    public function movePhotoDown($id, $photoId) {
        /** @var Product $product */
        $product = $this->product->getById($id);
        $product->movePhotoDown($photoId);
        $this->product->save($product);
    }

    public function removePhoto($id, $photoId) {
        /** @var Product $product */
        $product = $this->product->getById($id);
        $product->removePhoto($photoId);
        $this->product->save($product);
    }

    public function remove($id) {
        /** @var Product $product */
        $product = $this->product->getById($id);
        $this->product->delete($product);
    }
}