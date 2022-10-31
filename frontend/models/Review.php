<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $task_id
 * @property int $customer_id
 * @property int $performer_id
 * @property int $value
 * @property string|null $comment
 * @property string|null $created_at
 *
 * @property Task $task
 */
class Review extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'value'], 'required'],
            [['task_id', 'value', 'customer_id', 'performer_id'], 'integer'],
            [['created_at'], 'safe'],
            [['comment'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
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
            'customer_id' => 'ID заказчика',
            'performer_id' => 'ID исполнителя',
            'value' => 'Оценка',
            'comment' => 'Отзыв',
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
     * Gets query for Customer Profile.
     *
     * @return ActiveQuery
     */
    public function getCustomerProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'customer_id']);
    }
}
