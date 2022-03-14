<?php

namespace frontend\forms;

use frontend\models\Task;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class TaskForm extends Task
{
    /** @var array */
    public $filterCategories;
    /** @var string */
    public $filterHasResponse;
    /** @var string */
    public $filterHasRemoteWork;
    /** @var string */
    public $filterPeriodTime;
    /** @var string */
    public $searchByTitle;

    public function rules()
    {
        return [
            [['filterPeriodTime'], 'required'],
            [['filterCategories', 'filterHasResponse', 'filterHasRemoteWork', 'searchByTitle', 'filterPeriodTime'], 'safe'],
            [['filterCategories'], 'default', 'value' => []],
            [['filterHasResponse', 'filterHasRemoteWork', 'searchByTitle', 'filterPeriodTime'], 'string'],
            [['searchByTitle'], 'filter', 'filter' => 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'filterCategories' => 'Фильтр категорий',
            'filterHasResponse' => 'Без откликов',
            'filterHasRemoteWork' => 'Удаленная работа',
            'filterPeriodTime' => 'Период',
            'searchByTitle' => 'Поиск по названию',
        ];
    }

    /**
     * @return Task[]
     */
    public function search(): array
    {
        $query = Task::find();

        // Фильтр по категориям
        if ($this->filterCategories) {
            $categories = [];
            foreach ($this->filterCategories as $id => $value) {
                if ($value) {
                    $categories[] = $id;
                }
            }
            if ($categories) {
                $query->andWhere(['in', 'category_id', $categories]);
            }
        }

        // Фильтр по наличию отклика
        if ($this->filterHasResponse) {
            $query->andFilterWhere(['is', 'performer_id', new Expression('null')]);
        }

        // Фильтр по наличию удаленной работы
        if ($this->filterHasRemoteWork) {
            // 1 - Москва // ($user->city_id) // $user - performer (исполнитель)
            $query->andFilterWhere(['<>', 'city_id', '1']);
        }

        // Фильтр по периоду публикации задания
        if ($this->filterPeriodTime === self::ONE_DAY) {
            $query->andFilterWhere(['>', 'date_published', new Expression('DATE_SUB(NOW(), INTERVAL 1 DAY)')]);
        } elseif ($this->filterPeriodTime === self::ONE_WEEK) {
            $query->andFilterWhere(['>', 'date_published', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')]);
        } elseif ($this->filterPeriodTime === self::ONE_MONTH) {
            $query->andFilterWhere(['>', 'date_published', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')]);
        } elseif ($this->filterPeriodTime === self::ONE_YEAR) {
            $query->andFilterWhere(['>', 'date_published', new Expression('DATE_SUB(NOW(), INTERVAL 1 YEAR)')]);
        }

        // Поиск по названию
        if ($this->searchByTitle) {
            $query->andFilterWhere(['like', 'title', $this->searchByTitle]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $tasks = $provider->getModels();

        return $tasks;
    }
}