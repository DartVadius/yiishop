<?php
namespace core\forms\auth;

use yii\base\Model;
use yii\base\InvalidParamException;
use core\entities\user\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

}
