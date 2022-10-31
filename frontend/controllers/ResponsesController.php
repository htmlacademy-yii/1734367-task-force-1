<?php

namespace frontend\controllers;

use frontend\models\Response;
use frontend\models\Review;
use frontend\models\Task;
use yii\web\NotFoundHttpException;

class ResponsesController extends SecuredController
{
    public function actionRefusePerformer(int $taskId, int $performerId)
    {
        $response = Response::findOne(['task_id' => $taskId, 'performer_id' => $performerId]);

        if (!$response instanceof Response) {
            throw new NotFoundHttpException();
        }

        $response->status = Response::STATUS_REFUSE;

        if ($response->save()) {
            return $this->redirect(['tasks/view', 'id' => $taskId]);
        }

        throw new NotFoundHttpException();
    }

    /**
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionConfirmPerformer(int $taskId, int $performerId)
    {
        $response = Response::findOne(['task_id' => $taskId, 'performer_id' => $performerId]);

        if (!$response instanceof Response) {
            throw new NotFoundHttpException();
        }

        $task = Task::findOne($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        $response->status = Response::STATUS_CONFIRM;

        $task->status_id = Task::STATUS_ACTIVE;
        $task->performer_id = $performerId;

        try {
            $response->save();
            $task->save();
            return $this->redirect(['tasks/view', 'id' => $taskId]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Принять задание (исполнитель)
     */
    public function actionAccept(int $taskId, int $performerId)
    {
        $response = new Response();
        $response->task_id = $taskId;
        $response->performer_id = $performerId;
        $response->status = Response::STATUS_UNKNOW;
        $response->performer_cost = 5900; // Указываю здесь, потому что не вызывается модальное окно
        $response->performer_comment = 'Помогу чем смогу'; // Указываю здесь, потому что не вызывается модальное окно

        if ($response->save()) {
            return $this->redirect(['tasks/view', 'id' => $taskId]);
        }

        throw new NotFoundHttpException();
    }

    /**
     * Отказаться от задания (исполнитель)
     */
    public function actionFailure(int $taskId, int $performerId)
    {
        $response = Response::findOne(['task_id' => $taskId, 'performer_id' => $performerId]);

        if (!$response instanceof Response) {
            throw new NotFoundHttpException();
        }

        $task = Task::findOne($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        $response->status = Response::STATUS_REFUSED;
        $task->status_id = Task::STATUS_FAIL;

        try {
            $response->save();
            $task->save();
            return $this->redirect(['tasks/view', 'id' => $taskId]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Завершить задание (заказчик)
     */
    public function actionComplete(int $taskId, int $customerId)
    {
        $task = Task::findOne($taskId);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException();
        }

        $response = Response::findOne(['task_id' => $taskId, 'performer_id' => $task->performer_id]);

        if (!$response instanceof Response) {
            throw new NotFoundHttpException();
        }

        $response->status = Response::STATUS_COMPLETED;
        $task->status_id = Task::STATUS_DONE;

        try {
            $response->save();
            $task->save();
        } catch (\Exception $e) {
            throw $e;
        }

        $review = new Review();
        $review->task_id = $taskId;
        $review->customer_id = $customerId;
        $review->performer_id = $task->performer_id;
        $review->value = 5; // Указываю здесь, потому что не вызывается модальное окно
        $review->comment = 'Все отлично!'; // Указываю здесь, потому что не вызывается модальное окно

        if ($review->save()) {
            return $this->redirect(['tasks/view', 'id' => $taskId]);
        }

        throw new NotFoundHttpException();
    }
}