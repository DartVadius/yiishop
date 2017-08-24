<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 20.08.17
 * Time: 17:38
 */

namespace frontend\services\auth;

use common\entities\User;
use frontend\forms\SignupForm;
use SebastianBergmann\GlobalState\RuntimeException;
use yii\mail\MailerInterface;
use common\repository\UserRepository;

class SignupService {

    private $mailer;
    private $users;

    public function __construct(MailerInterface $mailer, UserRepository $users) {
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function signup(SignupForm $form) {
        if ($this->users->exists(['username' => $form->username])) {
            throw new \DomainException('Username is already exists');
        }
        if ($this->users->exists(['email' => $form->email])) {
            throw new \DomainException('Email is already exists');
        }

        $user = User::signupUser($form->username, $form->email, $form->password);
        $this->users->save($user);

        $sent = $this->mailer->compose([
            ['user' => $user],
            ['html' => 'email_confirm_signup_html', 'text' => 'email_confirm_signup_text'],
        ])
            ->setTo($form->email)
            ->setSubject('Signup confirm for ' . \Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new RuntimeException('Email sending error');
        }

        return $user;
    }

    public function confirm($token) {
        if (empty($token)) {
            throw new \DomainException('Empty token');
        }

        $user = $this->users->findByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }
}