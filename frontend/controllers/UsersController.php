<?php

namespace frontend\controllers;

use frontend\forms\UserForm;
use frontend\models\Category;
use frontend\models\Profile;
use frontend\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $userForm = new UserForm();
        $userForm->setTitlePage('Исполнители');

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

    public function actionView(int $id)
    {
        // !!!!! автаркам указать другой путь !!!!!!!!!

        $user = User::findOne($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException();
        }

        /** @var Profile $profile */
        $profile = $user->profiles;
        if ($profile->isCustomer()) {
            throw new NotFoundHttpException();
        }

        $user->setTitlePage('Пользователь');

        return $this->render('view', [
            'user' => $user,
        ]);
    }
}
