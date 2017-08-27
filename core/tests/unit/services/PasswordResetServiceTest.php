<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 25.08.17
 * Time: 13:14
 */

namespace core\tests\unit\services;

use core\entities\user\User;
use core\forms\auth\PasswordResetRequestForm;
use core\services\auth\PasswordResetService;
use Codeception\Test\Unit;
use ReflectionClass;

class PasswordResetServiceTest extends Unit {
    private $service;
    private $user;

    public function _before() {
        $this->service = \Yii::$container->get(PasswordResetService::class);
        $user = new User();
        $user->username = 'username';
        $user->email = 'test@email.com';
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword('password');
        $user->generateAuthKey();
        $user->created_at = time();
        $user->save();
        $this->user = $user;
    }

    public function _after() {
        $this->user->delete();
    }

    public function testRequest() {
        $form = new PasswordResetRequestForm();
        $form->email = 'test@email.com';
        $this->assertEquals($this->user->email, $form->email);

        $reflector = new ReflectionClass($this->service);
        $request = $reflector->getMethod('request');
        $supportEmail = $reflector->getProperty( 'supportEmail' );
        $supportEmail->setAccessible(true);

        $this->assertTrue($request->invokeArgs( $this->service, [$form]));
//        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey($this->user->email);
        expect($emailMessage->getFrom())->hasKey('support@example.com');
        $user = User::find()->where(['username' => 'username'])->limit(1)->one();
        $this->assertNotEmpty($user['password_reset_token']);
    }
}
