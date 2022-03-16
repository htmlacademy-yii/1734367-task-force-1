<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string $status
 *
 * @property Task[] $tasks
 */
class Status extends ActiveRecord
{
    /** @var int Новое (заказчик) */
    public const STATUS_NEW = 1;
    /** @var int Отменено (заказчик) */
    public const STATUS_CANCEL = 2;
    /** @var int Выполнено (заказчик) */
    public const STATUS_DONE = 3;
    /** @var int В работе (исполнитель) */
    public const STATUS_ACTIVE = 4;
    /** @var int Провалено (исполнитель) */
    public const STATUS_FAIL = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for Tasks.
     *
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['status_id' => 'id']);
    }
}
