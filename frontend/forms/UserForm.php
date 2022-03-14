<?php

namespace frontend\forms;

use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class UserForm extends User
{
    /** @var array */
    public $filterCategories;
    /** @var string */
    public $filterHasFree;
    /** @var string */
    public $filterHasReviews;
    /** @var string */
    public $filterHasFavorites;
    /** @var string */
    public $filterHasOnline;
    /** @var string */
    public $searchByName;

    public function rules()
    {
        return [
            [['filterCategories', 'filterHasFree', 'filterHasReviews', 'filterHasFavorites', 'filterHasOnline', 'searchByName'], 'safe'],
            [['filterCategories'], 'default', 'value' => []],
            [['filterHasFree', 'filterHasReviews', 'filterHasFavorites', 'searchByName'], 'string'],
            [['searchByName'], 'filter', 'filter' => 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'filterCategories' => 'Фильтр категорий',
            'filterHasFree' => 'Сейчас свободен',
            'filterHasOnline' => 'Сейчас онлайн',
            'filterHasReviews' => 'Есть отзывы',
            'filterHasFavorites' => 'В избранном',
            'searchByName' => 'Поиск по имени',
        ];
    }

    public function search(): array
    {
        $query = User::find()
            ->innerJoin('{{%profile}}', '{{%users}}.id = {{%profile}}.user_id')
            ->where(['{{%profile}}.role' => 'performer']);

        // Фильтр по категориям
        if ($this->filterCategories) {
            $categories = [];
            foreach ($this->filterCategories as $id => $value) {
                if ($value) {
                    $categories[] = $id;
                }
            }

            if ($categories) {
                $query->innerJoin('{{%profile_category}}', '{{%profile}}.id = {{%profile_category}}.profile_id')
                    ->andWhere(['in', '{{%profile_category}}.category_id', $categories])
                    ->groupBy('{{%profile}}.id');
            }
        }

        // Фильтр отсутствию задач у исполнителя (Сейчас свободен)
        if ($this->filterHasFree) {
            $query->leftJoin('{{%tasks}}', '{{%users}}.id = {{%tasks}}.performer_id')
                ->andFilterWhere(['is', '{{%tasks}}.performer_id', new Expression('null')]);
        }

        // Фильтр наличия исполнителя в сети (Сейчас онлайн)
        if ($this->filterHasOnline) {
            $query->andFilterWhere(['>', 'last_activity', new Expression('DATE_SUB(NOW(), INTERVAL 30 MINUTE)')]);
        }

        // Фильтр наличия отзывов у исполнителя
        if ($this->filterHasReviews) {
            $query->innerJoin('{{%reviews}}', '{{%profile}}.id = {{%reviews}}.performer_id')
                ->groupBy('{{%profile}}.id');
        }

        // Фильтр наличия исполнителя в избранном
        if ($this->filterHasFavorites) {
            $query->innerJoin('{{%favorites}}', '{{%profile}}.id = {{%favorites}}.performer_id')
                ->groupBy('{{%profile}}.id');
        }

        // Поиск по имени
        if ($this->searchByName) {
            $query->andFilterWhere(['like', '{{%users}}.name', $this->searchByName]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $users = $provider->getModels();

        return $users;
    }

}