<?php

namespace frontend\controllers;

use frontend\forms\UserForm;
use frontend\models\Category;
use Yii;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {

        $userForm = new UserForm();
        $userForm->load(Yii::$app->request->post());
        $userForm->validate();

        $users = $userForm->search();
        $categories = Category::getCategories();

        return $this->render('index', [
            'userForm' => $userForm,
            'users' => $users,
            'categories' => $categories,
        ]);
    }
}
