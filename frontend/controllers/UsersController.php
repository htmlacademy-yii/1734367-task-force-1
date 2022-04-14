<?php

namespace frontend\controllers;

use frontend\forms\UserForm;
use frontend\models\Category;
use frontend\models\Profile;
use frontend\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class UsersController extends SecuredController
{
    public function actionIndex()
    {
        $userForm = new UserForm();

        $userForm->load(Yii::$app->request->post());
        $userForm->validate();

        $users = $userForm->search();
        $categories = Category::getCategories();

        return $this->render('index', [
            'title' => 'Исполнители',
            'userForm' => $userForm,
            'users' => $users,
            'categories' => $categories,
        ]);
    }

    public function actionView(int $id)
    {
        $user = User::findOne($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException();
        }

        /** @var Profile $profile */
        $profile = $user->profiles;
        if ($profile->isCustomer()) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'title' => 'Пользователь',
            'user' => $user,
        ]);
    }
}
