<?php

namespace frontend\forms;

use frontend\models\User;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'email',
            'password' => 'пароль',
        ];
    }

    public function validatePassword($attribute, $params)
    {

        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (is_null($this->user)) {
            $this->user = User::findOne(['email' => $this->email]);
        }
        return $this->user;
    }
}