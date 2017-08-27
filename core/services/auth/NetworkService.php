<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.08.17
 * Time: 16:18
 */

namespace core\services\auth;


use core\entities\user\User;
use core\repository\UserRepository;

/**
 * Class NetworkService
 * @package core\services\auth
 *
 * @property $users core\repository\UserRepository
 */
class NetworkService {
    private $users;
    public function __construct(UserRepository $users) {
        $this->users = $users;
    }

    public function auth($network, $identity) {
        if ($user = $this->users->findByNetworkId($network, $identity)) {
            return $user;
        }
        $user = User::signupByNetwork($network, $identity);
        $this->users->save($user);
        return $user;
    }

    public function attach($id, $network, $identity) {
        if($this->users->findByNetworkId($network, $identity)) {
            throw new \DomainException('Network is already attach');
        }
        $user = $this->users->findById($id);
        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }

}