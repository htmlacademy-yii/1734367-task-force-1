<?php

namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\Profile;
use frontend\models\ProfileCategory;
use frontend\models\Task;
use frontend\models\User;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()
            ->innerJoin('{{%profile}}', '{{%users}}.id = {{%profile}}.user_id')
            ->where(['{{%profile}}.role' => 'performer'])
            ->orderBy(['{{%users}}.created_at' => SORT_ASC])
            ->all();

        return $this->render('index', compact('users'));
    }
}
