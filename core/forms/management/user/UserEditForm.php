<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 27.08.17
 * Time: 16:26
 */

namespace core\forms\management\user;


use core\entities\user\User;
use yii\base\Model;

class UserEditForm extends Model {
    public $username;
    public $email;

    private $_user;

    public function __construct(User $user, array $config = []) {
        $this->_user = $user;
        $this->username = $user->username;
        $this->email = $user->email;
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }
}