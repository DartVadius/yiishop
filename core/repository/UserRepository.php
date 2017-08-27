<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 24.08.17
 * Time: 20:35
 */

namespace core\repository;

use core\entities\user\User;


class UserRepository {

    public function findByNetworkId($network, $identity) {
        return User::find()->joinWith('networks n')
            ->andWhere(['n.network' => $network, 'n.identity' => $identity])
            ->one();
    }

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

    public function findById($id) {
        return $this->getOneBy(['id' => $id]);
    }

    private function getOneBy(array $params) {
        if (!$user = User::find()->andWhere($params)->limit(1)->one()) {
            throw new \DomainException('User not found');
        }
        return $user;
    }

    public function findByUsernameOrEmail($needle) {
        if (!$user = User::find()
            ->where(['username' => $needle])
            ->orWhere(['email' => $needle])
            ->limit(1)
            ->one()) {
            return false;
        }
        return $user;
    }

    public function exists($params) {
        if (User::find()->andWhere($params)->limit(1)->one()) {
            return true;
        }
        return false;
    }
}