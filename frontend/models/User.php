<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
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
class User extends ActiveRecord implements IdentityInterface
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
            [['name', 'email', 'password', 'city_id'], 'required'],
            [['city_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
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
            'password' => 'Пароль',
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

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @param string|int $id
     * @return User|null
     */
    public static function findIdentity($id): ?User
    {
        return self::findOne($id);
    }

    /**
     * @return string|int
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }


}
