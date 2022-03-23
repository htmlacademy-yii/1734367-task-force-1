<?php

namespace frontend\forms;

use frontend\models\User;
use yii\base\Model;


class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $city_id;

    public $titlePage = 'TaskForce';

    public function rules()
    {
        return [
            [['name', 'email', 'password', 'city_id'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],
            [['name'], 'string', 'min' => 2, 'max' => 30],
            [['password'], 'string', 'min' => 8, 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
            'city_id' => 'ID города',
        ];
    }
}