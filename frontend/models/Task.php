<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $category_id
 * @property int|null $status_id
 * @property int $cost
 * @property int $customer_id
 * @property int|null $performer_id
 * @property int|null $city_id
 * @property float|null $geo_latitude
 * @property float|null $geo_longitude
 * @property string $date_limit
 * @property string|null $date_published
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 * @property City $city
 * @property User $customer
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Message[] $messages1
 * @property PathFile[] $pathFiles
 * @property User $performer
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property Status $status
 */
class Task extends ActiveRecord
{
    public const ONE_DAY = 'oneDay';
    public const ONE_WEEK = 'oneWeek';
    public const ONE_MONTH = 'oneMonth';
    public const ONE_YEAR = 'oneYear';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'category_id', 'cost', 'customer_id', 'date_limit'], 'required'],
            [['category_id', 'status_id', 'cost', 'customer_id', 'performer_id', 'city_id'], 'integer'],
            [['geo_latitude', 'geo_longitude'], 'number'],
            [['date_limit', 'date_published', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 30],
            [['content'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['performer_id' => 'id']],
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
            'title' => 'Заголовок',
            'content' => 'Описание',
            'category_id' => 'ID категории',
            'status_id' => 'ID статуса',
            'cost' => 'Цена',
            'customer_id' => 'ID заказчика',
            'performer_id' => 'ID исполнителя',
            'city_id' => 'ID города',
            'geo_latitude' => 'Широта',
            'geo_longitude' => 'Долгота',
            'date_limit' => 'Дата выполнения',
            'date_published' => 'Дата публикации',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
        ];
    }

    /**
     * Gets query for Category.
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
     * Gets query for Customer.
     *
     * @return ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for Messages.
     *
     * @return ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for Messages0.
     *
     * @return ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::class, ['user_id' => 'customer_id']);
    }

    /**
     * Gets query for Messages1.
     *
     * @return ActiveQuery
     */
    public function getMessages1()
    {
        return $this->hasMany(Message::class, ['user_id' => 'performer_id']);
    }

    /**
     * Gets query for PathFiles.
     *
     * @return ActiveQuery
     */
    public function getPathFiles()
    {
        return $this->hasMany(PathFile::class, ['task_id' => 'id']);
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
     * Gets query for Responses.
     *
     * @return ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for Reviews.
     *
     * @return ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for Status.
     *
     * @return ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * @return string[]
     */
    public static function getPeriodTime(): array
    {
        return [
            self::ONE_DAY    => 'За день',
            self::ONE_WEEK   => 'За неделю',
            self::ONE_MONTH  => 'За месяц',
            self::ONE_YEAR   => 'За год',
        ];
    }
}
