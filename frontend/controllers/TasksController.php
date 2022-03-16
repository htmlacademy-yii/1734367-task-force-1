<?php

namespace frontend\controllers;

use frontend\forms\TaskForm;
use frontend\models\Category;
use frontend\models\Task;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/*
 * Tasks controller
 */
class TasksController extends Controller
{
    public function actionIndex()
    {
        $taskForm = new TaskForm();
        $taskForm->setTitlePage('Задания');

        $taskForm->load(Yii::$app->request->post());
        $taskForm->validate();

        $tasks = $taskForm->search();
        $categories = Category::getCategories();
        $periodTime = Task::getPeriodTime();

        return $this->render('index', [
            'taskForm' => $taskForm,
            'tasks' => $tasks,
            'categories' => $categories,
            'periodTime' => $periodTime,
        ]);
    }

    public function actionView(int $id)
    {
        $task = Task::findOne($id);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        $task->setTitlePage('Задание');

        return $this->render('view', [
            'task' => $task,
        ]);
    }
}
