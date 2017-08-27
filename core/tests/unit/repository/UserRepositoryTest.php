<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 19.08.17
 * Time: 18:17
 */

namespace core\tests\unit\repository\user;

use Codeception\Test\Unit;
use core\entities\user\User;
use core\repository\UserRepository;


class UserRepositoryTest extends Unit {

    private $users;
    private $user;

    public function _before() {
        $this->users = new UserRepository();
        $this->user = User::signupUser(
            $username = 'user', $email = 'mail@mail.com', $password = 'password'
        );
        $this->user->save();
    }

    public function _after() {
        $this->user->delete();
    }

    public function testResetToken() {
        $this->expectExceptionMessage('User not found');
        $this->users->findByPasswordResetToken('wrong_token');
    }

    public function testFindByEmailAndStatusFail() {
        $this->expectExceptionMessage('User not found');
        $this->users->findByEmailAndStatus('wrong@email.com', User::STATUS_ACTIVE);
        $this->expectExceptionMessage('User not found');
        $this->users->findByEmailAndStatus('mail@mail.com', User::STATUS_WAIT);
    }

    public function testFindByEmailAndStatusCorrect() {
        $this->assertInstanceOf(User::className(), $this->users->findByEmailAndStatus('mail@mail.com', User::STATUS_WAIT));
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->save();
        $this->assertInstanceOf(User::className(), $this->users->findByEmailAndStatus('mail@mail.com', User::STATUS_ACTIVE));
    }

    public function testExists() {
        $this->assertTrue($this->users->exists(['email' => 'mail@mail.com']));
        $this->assertTrue($this->users->exists(['username' => 'user']));
        $this->assertTrue($this->users->exists(['username' => 'user', 'email' => 'mail@mail.com']));
        $this->assertFalse($this->users->exists(['email' => 'wrong@mail.com']));
    }
}
