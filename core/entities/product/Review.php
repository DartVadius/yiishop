<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 13.09.17
 * Time: 18:41
 */

namespace core\entities\product;


use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $vote
 * @property string $text
 * @property bool $active
 */
class Review extends ActiveRecord {
    public static function create($userId, $vote, $text) {
        $review = new static();
        $review->user_id = $userId;
        $review->vote = $vote;
        $review->text = $text;
        $review->created_at = time();
        $review->active = false;
        return $review;
    }

    public function edit($vote, $text) {
        $this->vote = $vote;
        $this->text = $text;
    }

    public function activate() {
        $this->active = true;
    }

    public function draft() {
//        !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!??????? true ????
        $this->active = false;
    }

    public function isActive() {
        return $this->active === true;
    }

    public function getRating() {
        return $this->vote;
    }

    public function isIdEqualTo($id) {
        return $this->id == $id;
    }

    public static function tableName() {
        return '{{%shop_reviews}}';
    }
}