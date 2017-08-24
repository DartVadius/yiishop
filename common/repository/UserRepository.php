<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 24.08.17
 * Time: 20:35
 */

namespace common\repository;
use common\entities\User;


class UserRepository {
    public function findByPasswordResetToken($token) {
        return $this->getOneBy(['password_reset_token' => $token]);
    }

    public function save(User $user) {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }

    public function findByEmailAndStatus($email, $status) {
        return $this->getOneBy([
            'status' => $status,
            'email' => $email,
        ]);
    }

    public function findByEmailConfirmToken($token) {
        return $this->getOneBy(['email_confirm_token' => $token]);
    }

    private function getOneBy(array $params) {
        if (!$user = User::find()->andWhere($params)->one()) {
            throw new \DomainException('User not found');
        }
        return $user;
    }

    public function exists(array $params) {
        if (User::find()->andWhere($params)->limit(1)->one()){
            return true;
        }
        return false;
    }
}