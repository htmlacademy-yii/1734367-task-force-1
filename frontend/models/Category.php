<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $category
 *
 * @property Task[] $tasks
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
        ];
    }

    /**
     * Gets query for Tasks.
     *
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['category_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getCategories(): array
    {
        return self::find()->all();
    }

    /**
     * @return array
     */
    public static function getCategoriesList(): array
    {
        $cities = self::find()->asArray()->all();
        return ArrayHelper::map($cities, 'id', 'category');
    }

    /**
     * @param int $category_id
     * @return string
     */
    public static function getIconByCategoryId(int $category_id): string
    {
        switch ($category_id) {
            case 1:
            case 2:
            $icon = 'cargo';
                break;
            case 3:
                $icon = 'translation';
                break;
            case 5:
            case 6:
                $icon = 'clean';
                break;
            default:
                $icon = 'cargo';
                break;
        }

        return $icon;
    }
}
