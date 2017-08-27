<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 20.08.17
 * Time: 18:08
 */

namespace core\services\auth;

use core\entities\user\User;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;
use core\repository\UserRepository;


class PasswordResetService {
    private $supportEmail;
    private $mailer;
    private $users;

    public function __construct($supportEmail, MailerInterface $mailer, UserRepository $users) {
        $this->supportEmail = $supportEmail;
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function request(\core\forms\auth\PasswordResetRequestForm $form) {
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
        return true;
    }

    public function validateToken($token) {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Empty reset token');
        }
        $this->users->findByPasswordResetToken($token);
    }

    public function reset($token, \core\forms\auth\ResetPasswordForm $form) {
        $user = $this->users->findByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }


}