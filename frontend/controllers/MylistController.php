<?php

namespace frontend\controllers;

use frontend\models\Profile;
use frontend\models\Task;
use frontend\models\User;
use Yii;

class MylistController extends SecuredController
{
    public function actionIndex()
    {
        $userProfile = Profile::findOne(['user_id' => Yii::$app->user->id]);

        $data = Yii::$app->request->get();
        $taskStatus = Task::STATUSES[$data['status']] ?: Task::STATUS_NEW;

        $tasks = Task::find()
            ->where(["{$userProfile->role}_id" => Yii::$app->user->id])
            ->andWhere(['status_id' => $taskStatus])
            ->all();

        return $this->render('index', [
            'title' => 'Мои задания',
            'tasks' => $tasks
        ]);
    }
}