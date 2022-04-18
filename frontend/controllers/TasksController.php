<?php

namespace frontend\controllers;

use frontend\forms\CreateTaskForm;
use frontend\forms\TaskForm;
use frontend\models\Category;
use frontend\models\PathFile;
use frontend\models\Profile;
use frontend\models\Status;
use frontend\models\Task;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    /** @var UploadedFile[] */
    private $uploadFiles;
    /** @var string[] */
    private $pathFile;
    /** @var string[] */
    private $fileName;

    public function behaviors()
    {
        $rules = parent::behaviors();

        $rule = [
            'actions' => ['create'],
            'allow' => true,
            'matchCallback' => function ($rule, $action) {
                $id = Yii::$app->user->id;
                $profile = Profile::findOne(['user_id' => $id]);

                return $profile->role === Profile::ROLE_CUSTOMER;
            }
        ];

        $rules['access']['only'][] = 'create';
        $rules['access']['rules'][] = $rule;

        return $rules;
    }

    public function actionIndex()
    {
        $taskForm = new TaskForm();

        $taskForm->load(Yii::$app->request->post());
        $taskForm->validate();

        $tasks = $taskForm->search();
        $categories = Category::getCategories();
        $periodTime = Task::getPeriodTime();

        return $this->render('index', [
            'title' => 'Задания',
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

        return $this->render('view', [
            'title' => 'Задание',
            'task' => $task,
        ]);
    }

    public function actionCreate()
    {
        // возможно придется добавить метод behavior

        $createTaskForm = new CreateTaskForm();
        $categories = Category::getCategoriesList();

        if (Yii::$app->request->getIsPost()) {

            $createTaskForm->load(Yii::$app->request->post());
            $createTaskForm->files = UploadedFile::getInstances($createTaskForm, 'files');

            if ($createTaskForm->validate()) {
                $task = new Task();
                $task->title = $createTaskForm->title;
                $task->content = $createTaskForm->content;
                $task->category_id = $createTaskForm->category_id;
                $task->status_id = Status::STATUS_NEW;
                $task->cost = $createTaskForm->cost;
                $task->icon = Category::getIconByCategoryId((int) $createTaskForm->category_id);
                $task->customer_id = Yii::$app->user->id;
                $task->city_id = Yii::$app->user->identity->city_id;
                $task->date_limit = $createTaskForm->date_limit;
                $task->date_published = date("Y-m-d H:i:s");

                $this->uploadFiles = $createTaskForm->files;

                if ($task->save()) {
                    $this->saveFiles($task);

                    return $this->redirect(['tasks/index']);
                }
            }
        }

        return $this->render('create', [
            'title' => 'Создать задание',
            'createTaskForm' => $createTaskForm,
            'categories' => $categories,
        ]);
    }

    private function saveFiles(Task $task): void
    {
        if ($this->uploadFiles) {
            foreach ($this->uploadFiles as $uploadFile) {
                $this->upload($uploadFile);

                $pathFile = new PathFile();
                $pathFile->task_id = $task->id;
                $pathFile->path = $this->pathFile;
                $pathFile->file_name = $this->fileName;
                $pathFile->save();
            }
        }
    }

    private function upload(UploadedFile $uploadFile): void
    {
        $newname = uniqid('upload') . '.' . $uploadFile->getExtension();
        $uploadFile->saveAs('@webroot/uploads/' . $newname);

        $this->pathFile = ('/uploads/' . $newname);
        $this->fileName = $newname;
    }
}
