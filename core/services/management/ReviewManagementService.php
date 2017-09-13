<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 13.09.17
 * Time: 18:47
 */

namespace core\services\management;


use core\forms\management\product\ReviewEditForm;
use core\repository\ProductRepository;

class ReviewManagementService {
    private $products;

    public function __construct(ProductRepository $products) {
        $this->products = $products;
    }

    public function edit($id, $reviewId, ReviewEditForm $form) {
        $product = $this->products->getById($id);
        $product->editReview(
            $reviewId,
            $form->vote,
            $form->text
        );
        $this->products->save($product);
    }

    public function activate($id, $reviewId) {
        $product = $this->products->getById($id);
        $product->activateReview($reviewId);
        $this->products->save($product);
    }

    public function draft($id, $reviewId) {
        $product = $this->products->getById($id);
        $product->draftReview($reviewId);
        $this->products->save($product);
    }

    public function remove($id, $reviewId) {
        $product = $this->products->getById($id);
        $product->removeReview($reviewId);
        $this->products->save($product);
    }
}