<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.08.17
 * Time: 15:05
 */

namespace core\entities\user;


use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

/**
 * Class Network
 * @package core\entities\user
 *
 * @property integer $user_id
 * @property string $identity
 * @property string $network
 */
class Network extends ActiveRecord {

    public static function tableName() {
        return '{{%user_networks}}';
    }

    public static function create($network, $identity) {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    public function isFor($network, $identity) {
        return $this->identity === $identity && $this->network === $network;
    }
}