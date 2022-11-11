<?php

namespace frontend\forms;

use frontend\models\User;
use yii\base\Model;

class AccountForm extends Model
{
    public $name;
    public $email;
    public $city;
    public $date;
    public $biography;
    public $category;
    public $password;
    public $phone;
    public $skype;
    public $telegram;

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
}