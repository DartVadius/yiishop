<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:17
 */

namespace core\entities\product;


use core\entities\behaviors\MetaBehavior;
use core\entities\brand\Brand;
use core\entities\category\Category;
use core\entities\characteristic\Value;
use core\entities\meta\Meta;
use core\entities\tag\Tag;
use core\entities\tag\TagAssignment;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property integer              $id
 * @property integer              $created_at
 * @property string               $code
 * @property string               $name
 * @property string               $description
 * @property integer              $category_id
 * @property integer              $brand_id
 * @property integer              $price_old
 * @property integer              $price_new
 * @property integer              $rating
 * @property integer              $main_photo_id
 * @property integer              $status
 * @property integer              $weight
 * @property integer              $quantity
 *
 * @property Meta                 $meta
 * @property Brand                $brand
 * @property Category             $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[]           $categories
 * @property TagAssignment[]      $tagAssignments
 * @property Tag[]                $tags
 * @property RelatedAssignment[]  $relatedAssignments
 * @property Modification[]       $modifications
 * @property Value[]              $values
 * @property Photo[]              $photos
 * @property Photo                $mainPhoto
 * @property Review[]             $reviews
 */
class Product extends ActiveRecord {

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $price_new;
    public $price_old;
    public $category_id;
    public $brand_id;
    public $code;
    public $name;
    public $description;
    public $weight;
    public $quantity;
    public $meta;
    public $status;
    public $created_at;

    public static function create($brandId, $categoryId, $code, $name, $description, $weight, $quantity, Meta $meta) {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->description = $description;
        $product->weight = $weight;
        $product->quantity = $quantity;
        $product->meta = $meta;
        $product->status = self::STATUS_DRAFT;
        $product->created_at = time();
        return $product;
    }

    public function edit($brandId, $code, $name, $description, $weight, Meta $meta) {
        $this->brand_id = $brandId;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->weight = $weight;
        $this->meta = $meta;
    }

    public function setPrice($new, $old) {
        $this->price_new = $new;
        $this->price_old = $old;
    }

    public function changeMainCategory($id) {
        $this->category_id = $id;
    }

    public function setValue($id, $value) {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return;
            }
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }

    public function getValue($id) {
        $values = $this->values;
        foreach ($values as $val) {
            if ($val->isForCharacteristic($id)) {
                return $val;
            }
        }
        return Value::blank($id);
    }

    public function assignCategory($categoryId) {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategory($categoryId)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($categoryId);
        $this->categoryAssignments = $assignments;
    }

    public function revokeCategory($id) {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $key => $assignment) {
            if ($assignment->isForCategory($id)) {
                unset($assignments[$key]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment not found');
    }

    public function revokeCategories() {
        $this->categoryAssignments = [];
    }

    public function addPhoto(UploadedFile $file) {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->setPhotos($photos);
    }

    public function removePhoto($id) {
        $photos = $this->photos;
        /** @var Photo $photo */
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$id]);
                return;
            }
        }
        throw new \DomainException('Photo is not found');
    }

    public function removePhotos() {
        $this->setPhotos([]);
    }

    public function movePhotoUp($id) {
        $photos = $this->photos;
        /** @var Photo $photo */
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id) && $prev = $photos[$i - 1] ? $photos[$i - 1] : null) {
                $photos[$i] = $prev;
                $photos[$i - 1] = $photo;
                $this->setPhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found');
    }

    public function movePhotoDown($id) {
        $photos = $this->photos;
        /** @var Photo $photo */
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id) && $next = $photos[$i + 1] ? $photos[$i + 1] : null) {
                $photos[$i] = $next;
                $photos[$i + 1] = $photo;
                $this->setPhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found');
    }

    private function setPhotos(array $photos) {
        /** @var Photo $photo */
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        $this->photos = $photos;
    }

    public function assignTag($id) {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id) {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found');
    }

    public function revokeTags() {
        $this->tagAssignments = [];
    }

    public function assignRelatedProduct($id) {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForProduct($id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->relatedAssignments = $assignments;
    }

    public function revokeRelatedProduct($id) {
        $assignments = $this->relatedAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForProduct($id)) {
                unset($assignments[$i]);
                $this->relatedAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found');
    }


    public function getModification($id) {
        foreach ($this->modifications as $modification) {
            if ($modification->isIdEqualTo($id)) {
                return $modification;
            }
        }
        throw new \DomainException('Modification is not found');
    }

    public function getModificationPrice($id) {
        foreach ($this->modifications as $modification) {
            if ($modification->isIdEqualTo($id)) {
                return $modification->price ? $modification->price : $this->price_new;
            }
        }
        throw new \DomainException('Modification is not found');
    }

    public function addModification($code, $name, $price, $quantity) {
        $modifications = $this->modifications;
        foreach ($modifications as $modification) {
            if ($modification->isCodeEqualTo($code)) {
                throw new \DomainException('Modification already exists');
            }
        }
        $modifications[] = Modification::create($code, $name, $price, $quantity);
        $this->updateModifications($modifications);
    }

    public function editModification($id, $code, $name, $price, $quantity) {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                $modification->edit($code, $name, $price, $quantity);
                $this->updateModifications($modifications);
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    public function removeModification($id) {
        $modifications = $this->modifications;
        foreach ($modifications as $i => $modification) {
            if ($modification->isIdEqualTo($id)) {
                unset($modifications[$i]);
                $this->updateModifications($modifications);
                return;
            }
        }
        throw new \DomainException('Modification is not found.');
    }

    private function updateModifications(array $modifications) {
        $this->modifications = $modifications;
        $this->setQuantity(array_sum(array_map(function (Modification $modification) {
            return $modification->quantity;
        }, $this->modifications)));
    }

    public function addReview($userId, $vote, $text) {
        $reviews = $this->reviews;
        $reviews[] = Review::create($userId, $vote, $text);
        $this->updateReviews($reviews);
    }

    public function editReview($id, $vote, $text) {
        $this->doWithReview($id, function (Review $review) use ($vote, $text) {
            $review->edit($vote, $text);
        });
    }

    public function activateReview($id) {
        $this->doWithReview($id, function (Review $review) {
            $review->activate();
        });
    }

    public function draftReview($id) {
        $this->doWithReview($id, function (Review $review) {
            $review->draft();
        });
    }

    private function doWithReview($id, callable $callback) {
        $reviews = $this->reviews;
        foreach ($reviews as $review) {
            if ($review->isIdEqualTo($id)) {
                $callback($review);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    public function removeReview($id) {
        $reviews = $this->reviews;
        foreach ($reviews as $i => $review) {
            if ($review->isIdEqualTo($id)) {
                unset($reviews[$i]);
                $this->updateReviews($reviews);
                return;
            }
        }
        throw new \DomainException('Review is not found.');
    }

    private function updateReviews(array $reviews) {
        $amount = 0;
        $total = 0;

        foreach ($reviews as $review) {
            if ($review->isActive()) {
                $amount++;
                $total += $review->getRating();
            }
        }

        $this->reviews = $reviews;
        $this->rating = $amount ? $total / $amount : null;
    }

    private function setQuantity($quantity) {
//        if ($this->quantity == 0 && $quantity > 0) {
//            $this->recordEvent(new ProductAppearedInStock($this));
//        }
        $this->quantity = $quantity;
    }


    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCategoryAssignments() {
        return $this->hasOne(CategoryAssignment::className(), ['product_id' => 'id']);
    }

    public function getValues() {
        return $this->hasOne(Value::className(), ['product_id' => 'id']);
    }

    public function getPhotos() {
        return $this->hasOne(Photo::className(), ['product_id' => 'id'])->orderBy('sort');
    }

    public function getTagAssignments() {
        return $this->hasMany(TagAssignment::class, ['product_id' => 'id']);
    }

    public function getTags() {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function getRelatedAssignments() {
        return $this->hasMany(RelatedAssignment::class, ['product_id' => 'id']);
    }

    public function getRelateds() {
        return $this->hasMany(Product::class, ['id' => 'related_id'])->via('relatedAssignments');
    }

    public function getModifications() {
        return $this->hasMany(Modification::class, ['product_id' => 'id']);
    }

    public function getReviews() {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    public static function tableName() {
        return '{{%shop_product}}';
    }

    public function behaviors() {
        return [
            MetaBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['categoryAssignments', 'values', 'photos', 'tagAssignments', 'relatedAssignments', 'modifications', 'reviews']
            ],
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}