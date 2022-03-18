<?php

namespace frontend\controllers;

use frontend\models\Status;
use frontend\models\Task;
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
}