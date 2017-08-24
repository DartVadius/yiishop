<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 20.08.17
 * Time: 18:08
 */

namespace frontend\services\auth;

use common\entities\User;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;
use common\repository\UserRepository;


class PasswordResetService {
    private $supportEmail;
    private $mailer;
    private $users;

    public function __construct($supportEmail, MailerInterface $mailer, UserRepository $users) {
        $this->supportEmail = $supportEmail;
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function request(PasswordResetRequestForm $form) {
        $user = $this->users->findByEmailAndStatus($form->email, User::STATUS_ACTIVE);
        $user->requestPasswordReset();
        $this->users->save($user);

        $send = $this->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        if (!$send) {
            throw new \RuntimeException('Sending error');
        }

    }

    public function validateToken($token) {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Empty reset token');
        }
        $this->users->findByPasswordResetToken($token);
    }

    public function reset($token, ResetPasswordForm $form) {
        $user = $this->users->findByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }


}