<?php

namespace frontend\controllers;

use frontend\models\User;
use Yii;

class ProfileController extends SecuredController
{
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['landing/index']);
    }

    public function actionProfile()
    {
        $id = Yii::$app->user->getId();
        if ($id) {
            $user = User::findOne($id);

            print($user->email);
        }
    }
}