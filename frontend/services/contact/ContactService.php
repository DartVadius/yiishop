<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 22.08.17
 * Time: 19:48
 */

namespace frontend\services\contact;

use frontend\forms\ContactForm;
use yii\mail\MailerInterface;

class ContactService {

    private $mailer;
    private $adminEmail;

    public function __construct($adminEmail, MailerInterface $mailer) {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function send(ContactForm $form) {
        $result = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setFrom($form->email)
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();
        if (!$result) {
            throw new \RuntimeException('Sending error');
        }
        return $result;
    }
}