<?php

namespace frontend\controllers;

use frontend\models\Task;
use yii\helpers\VarDumper;
use yii\web\Controller;

/*
 * Tasks controller
 */
class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()
            ->where(['status_id' => 1])
            ->orderBy(['date_published' => SORT_ASC])
            ->all();

        return $this->render('index', compact('tasks'));
    }
}
