<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property int $city_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property City $city
 * @property Favorite[] $favorites
 * @property Favorite[] $favorites0
 * @property Profile[] $profiles
 * @property Response[] $responses
 */
class User extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password_hash', 'city_id'], 'required'],
            [['city_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'password_hash' => 'Пароль',
            'city_id' => 'ID города',
            'status' => 'Статус',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
        ];
    }

    /**
     * Gets query for City.
     *
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for Favorites.
     *
     * @return ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for Favorites0.
     *
     * @return ActiveQuery
     */
    public function getFavorites0()
    {
        return $this->hasMany(Favorite::class, ['performer_id' => 'id']);
    }

    /**
     * Gets query for Profiles.
     *
     * @return ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for Responses.
     *
     * @return ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['performer_id' => 'id']);
    }
}
