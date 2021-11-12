<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $role
 * @property float|null $rating
 * @property string|null $date_birthday
 * @property string|null $biography
 * @property string|null $avatar
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property string|null $last_activity
 * @property string|null $updated_at
 *
 * @property ProfileCategory[] $profileCategories
 * @property User $user
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['role'], 'string'],
            [['rating'], 'number'],
            [['date_birthday', 'last_activity', 'updated_at'], 'safe'],
            [['biography', 'avatar'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['skype', 'telegram'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'role' => 'Роль',
            'rating' => 'Рейтинг',
            'date_birthday' => 'Дата Рождения',
            'biography' => 'Биография',
            'avatar' => 'Аватар',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'last_activity' => 'Последняя активность',
            'updated_at' => 'Время обновления',
        ];
    }

    /**
     * Gets query for ProfileCategories.
     *
     * @return ActiveQuery
     */
    public function getProfileCategories()
    {
        return $this->hasMany(ProfileCategory::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for User.
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
