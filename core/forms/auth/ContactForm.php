<?php

namespace core\forms\auth;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model {
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'captchaAction'=>'contact/captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }
}
