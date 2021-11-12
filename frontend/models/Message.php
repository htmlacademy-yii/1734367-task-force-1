<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string|null $message
 * @property string|null $created_at
 *
 * @property Task $task
 * @property Task $user
 * @property Task $user0
 */
class Message extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'required'],
            [['task_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['user_id' => 'customer_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['user_id' => 'performer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'ID задания',
            'user_id' => 'ID пользователя',
            'message' => 'Сообщение',
            'created_at' => 'Время создания',
        ];
    }

    /**
     * Gets query for Task.
     *
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for User.
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Task::class, ['customer_id' => 'user_id']);
    }

    /**
     * Gets query for User0.
     *
     * @return ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(Task::class, ['performer_id' => 'user_id']);
    }
}
