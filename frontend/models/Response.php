<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property int $task_id
 * @property int|null $performer_id
 * @property int|null status
 * @property int|null $performer_cost
 * @property string|null $performer_comment
 * @property string|null $created_at
 *
 * @property User $performer
 * @property Task $task
 */
class Response extends ActiveRecord
{
    /** Статус отклика: не выбран */
    const STATUS_UNKNOW = 0;
    /** Статус отклика: отказать претенденту (заказчик) */
    const STATUS_REFUSE = 10;
    /** Статус отклика: выбрать претендента (заказчик) */
    const STATUS_CONFIRM = 11;
    /** Статус отклика: отказаться от задания (исполнитель) */
    const STATUS_REFUSED = 12;
    /** Статус отклика: завершил задание (исполнитель) */
    const STATUS_COMPLETED = 13;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'performer_id', 'status', 'performer_cost'], 'integer'],
            [['created_at'], 'safe'],
            [['performer_comment'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['performer_id' => 'id']],
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
            'performer_id' => 'ID исполнителя',
            'status' => 'Статус исполнителя',
            'performer_cost' => 'Цена исполнителя',
            'performer_comment' => 'Комментарий исполнителя',
            'created_at' => 'Время создания',
        ];
    }

    /**
     * Gets query for Performer.
     *
     * @return ActiveQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(User::class, ['id' => 'performer_id']);
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
}
