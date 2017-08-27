<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 19.08.17
 * Time: 18:17
 */

namespace core\tests\unit\entities\user;

use Codeception\Test\Unit;
use core\entities\user\User;


class CreateUserTest extends Unit {
    public function testCreateSuccess() {
        $user = User::signupUser(
            $username = 'user', $email = 'mail@mail.com', $password = 'password'
        );
        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertFalse($user->isActive());
    }

    public function testConfirmSignup() {
        $user = new User([
            'status' => User::STATUS_WAIT,
            'email_confirm_token' => 'token'
        ]);
        $user->confirmSignup();
        $this->assertEquals(null, $user->email_confirm_token);
        $this->assertFalse($user->isWait());
        $this->assertTrue($user->isActive());
    }

    public function testAlreadyActive() {
        $user = new User([
            'status' => User::STATUS_ACTIVE,
            'email_confirm_token' => null
        ]);
        $this->expectExceptionMessage('User is already active');
        $user->confirmSignup();
    }
}
