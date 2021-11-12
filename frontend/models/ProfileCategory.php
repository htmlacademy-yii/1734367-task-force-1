<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile_category".
 *
 * @property int|null $profile_id
 * @property int|null $category_id
 *
 * @property Profile $category
 * @property Category $profile
 */
class ProfileCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['category_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'ID профиля',
            'category_id' => 'ID категории',
        ];
    }

    /**
     * Gets query for Category.
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Profile::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for Profile.
     *
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Category::class, ['id' => 'profile_id']);
    }
}
