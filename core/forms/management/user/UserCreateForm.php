<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 27.08.17
 * Time: 15:58
 */
namespace core\forms\management\user;

use core\entities\user\User;
use yii\base\Model;

class UserCreateForm extends  Model {
    public $username;
    public $password;
    public $email;

    public function rules() {
        return [
            [['username', 'password', 'email'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
        ];
    }

}