<?php

namespace frontend\forms;

use yii\base\Model;

class CreateTaskForm extends Model
{
    public $title;
    public $content;
    public $category_id;
    public $files;
    public $location;
    public $cost;
    public $date_limit;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Кратко опишите суть работы'],
            [['content'], 'required', 'message' => 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться'],
            [['location'], 'required', 'message' => 'Укажите адрес исполнения'],
            [['cost'], 'required', 'message' => 'Не заполняйте для оценки исполнителем'],
            [['date_limit'], 'required', 'message' => 'Укажите крайний срок исполнения'],
            [['category_id'], 'required', 'message' => 'Укажите категорию задания'],
            [['title', 'content'], 'string', 'min' => 5],
            [
                ['files'], 'file', 'extensions' => ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'png', 'jpg', 'jpeg', 'gif'],
                'maxFiles' => 2,
                'message' => 'Данный формат файла не поддерживается.'
            ],
            [['cost'], 'number'],
            [['date_limit'], 'date', 'format' => 'yyyy-mm-dd'],
        ];
    }
}