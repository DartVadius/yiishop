<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 25.08.17
 * Time: 14:26
 */

namespace core\services\auth;


use core\forms\auth\LoginForm;
use core\repository\UserRepository;

class AuthService {

    private $users;

    public function __construct(UserRepository $users) {
        $this->users = $users;
    }

    public function auth(LoginForm $form) {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password');
        }
        return $user;
    }

}