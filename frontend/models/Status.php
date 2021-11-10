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
