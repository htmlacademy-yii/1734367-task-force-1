<?php

namespace frontend\controllers;

use frontend\forms\LoginForm;
use frontend\models\Status;
use frontend\models\Task;
use Yii;
use yii\web\Controller;

class LandingController extends Controller
{
    public $layout = 'landing';
    public $landingTasks = [];

    public function actionIndex()
    {
        $tasks = Task::find()
            ->where(['status_id' => Status::STATUS_NEW])
            ->orderBy(['date_published' => SORT_DESC])
            ->limit(4)
            ->all();

        $this->setLandingTasks($tasks);

        return $this->render('/layouts/landing');
    }

    public function setLandingTasks(array $landingTasks): void
    {
        $this->landingTasks = $landingTasks;
    }

    public function getLandingTasks(): array
    {
        return $this->landingTasks;
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->isPost) {
            $loginForm->load(Yii::$app->request->post());

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->redirect(['tasks/index']);
            }

        }

        Yii::$app->session->setFlash('error', 'Неправильный email или пароль');
        return $this->redirect(Yii::$app->request->referrer);
    }
}