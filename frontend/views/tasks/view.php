<?php

use frontend\models\Task;
use frontend\models\Response;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var View $this */
/* @var string $title */
/* @var int $userId */
/* @var bool $isCustomerTask */
/* @var bool $isPrePerformer */
/* @var bool $isPerformer */
/* @var Task $task */

$this->title = $title;

$regDate = Yii::$app->formatter->format(strtotime($task->customer->created_at), 'relativeTime');
$regDateList = array_slice(explode(' ', $regDate), 0, -1);
$regDateFormatter = implode(' ', $regDateList);

?>

<head>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=e666f398-c983-4bde-8f14-e3fec900592a&lang=ru_RU" type="text/javascript"></script>
    <script src="/frontend/web/js/messenger.js" type="text/javascript"></script>

    <script type="text/javascript">
        var asd = [ <?= $task->geo_location ?> ];
        // Функция ymaps.ready() будет вызвана, когда
        // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
        ymaps.ready(init);
        function init(){
            // Создание карты.
            var myMap = new ymaps.Map("map", {
                // Координаты центра карты.
                // Порядок по умолчанию: «широта, долгота».
                // Чтобы не определять координаты центра карты вручную,
                // воспользуйтесь инструментом Определение координат.
                center: asd,
                // Уровень масштабирования. Допустимые значения:
                // от 0 (весь мир) до 19.
                zoom: 7
            });
        }
    </script>
</head>

<section class="content-view">
    <div class="content-view__card">
      <div class="content-view__card-wrapper">
        <div class="content-view__header">
          <div class="content-view__headline">
            <h1><?= Html::encode($task->title) ?></h1>
            <span>
                Размещено в категории
                <a href="#" class="link-regular"><?= Html::encode($task->category->category) ?></a>
                <?= Html::encode(Yii::$app->formatter->format(strtotime($task->date_published), 'relativeTime')) ?>
            </span>
          </div>
          <b class="new-task__price new-task__price--clean content-view-price"><?= Html::encode($task->cost) ?><b> ₽</b></b>
          <div class="new-task__icon new-task__icon--clean content-view-icon"></div>
        </div>
        <div class="content-view__description">
          <h3 class="content-view__h3">Общее описание</h3>
          <p><?= Html::encode($task->content) ?></p>
        </div>
        <div class="content-view__attach">
          <?php if ($task->pathFiles) { ?>
              <h3 class="content-view__h3">Вложения</h3>
              <?php foreach($task->pathFiles as $file): ?>
                  <a href="#"><?= Html::encode($file->file_name) ?></a>
              <?php endforeach; ?>
          <?php } ?>
        </div>
        <div class="content-view__location">
          <h3 class="content-view__h3">Расположение</h3>
          <div class="content-view__location-wrapper">
            <div class="content-view__map" id="map"  style="width: 361px; height: 292px"></div>
            <div class="content-view__address">
              <span class="address__town"><?= $task->location ?></span><br>
              <span></span>
              <p></p>
            </div>
          </div>
        </div>
      </div>

      <div class="content-view__action-buttons">
        <?php if ($task->status_id === Task::STATUS_NEW && !$isCustomerTask && !$isPrePerformer) { ?>
            <a href="<?= Url::to(['responses/accept', 'taskId' => $task->id, 'performerId' => $userId]); ?>"
               class=" button button__big-color response-button open-modal"
               type="button" data-for="response-form">Откликнуться
            </a>
        <?php } ?>
        <?php if ($task->status_id === Task::STATUS_ACTIVE && $isPerformer) { ?>
            <a href="<?= Url::to(['responses/failure', 'taskId' => $task->id, 'performerId' => $userId]); ?>"
               class="button button__big-color refusal-button open-modal"
               type="button" data-for="refuse-form">Отказаться
            </a>
        <?php } ?>
        <?php if (!in_array($task->status_id, [Task::STATUS_CANCEL, Task::STATUS_DONE], true) && $isCustomerTask) { ?>
            <a href="<?= Url::to(['responses/complete', 'taskId' => $task->id, 'customerId' => $userId]); ?>"
               class="button button__big-color request-button open-modal"
               type="button" data-for="complete-form">Завершить
            </a>
        <?php } ?>
      </div>

    </div>
    <?php if ($isCustomerTask || $isPrePerformer) { ?>
        <div class="content-view__feedback">
            <h2>Отклики <span><?= Html::encode(count($task->responses)) ?></span></h2>
            <div class="content-view__feedback-wrapper">

                <?php foreach($task->responses as $response): ?>
                    <div class="content-view__feedback-card">
                        <?php if ($isCustomerTask || $response->performer->id === $userId) { ?>
                            <div class="feedback-card__top">
                                <a href="<?= Url::to(['users/view', 'id' => $response->performer->id]); ?>">
                                    <img src="<?= Html::encode($response->performer->profiles->avatar) ?>" width="55" height="55" alt="Аватар исполнителя">
                                </a>
                                <div class="feedback-card__top--name">
                                    <p>
                                        <a href="<?= Url::to(['users/view', 'id' => $response->performer->id]); ?>" class="link-regular">
                                            <?= Html::encode($response->performer->name) ?>
                                        </a>
                                    </p>
                                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                                    <b><?= Html::encode($response->performer->profiles->rating) ?></b>
                                </div>
                                <span class="new-task__time">
                                <?= Html::encode(Yii::$app->formatter->format(strtotime($response->performer->profiles->last_activity), 'relativeTime')) ?>
                            </span>
                            </div>
                            <div class="feedback-card__content">
                                <p><?= Html::encode($response->performer_comment) ?></p>
                                <span><?= Html::encode($response->performer_cost) ?> ₽</span>
                            </div>
                            <?php if ($isCustomerTask && $response->status === Response::STATUS_UNKNOW && $task->performer_id === null) { ?>
                                <div class="feedback-card__actions">
                                    <a href="<?= Url::to(['responses/confirm-performer', 'taskId' => $task->id, 'performerId' => $response->performer->id]); ?>"
                                       class="button__small-color request-button button"
                                       type="button">Подтвердить</a>
                                    <a href="<?= Url::to(['responses/refuse-performer', 'taskId' => $task->id, 'performerId' => $response->performer->id]); ?>"
                                       class="button__small-color refusal-button button"
                                       type="button">Отказать</a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php } ?>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
      <div class="profile-mini__wrapper">
        <h3>Заказчик</h3>
        <div class="profile-mini__top">
          <img src="<?= Html::encode($task->customer->profiles->avatar) ?>" width="62" height="62" alt="Аватар заказчика">
          <div class="profile-mini__name five-stars__rate">
            <p><?= Html::encode($task->customer->name) ?></p>
          </div>
        </div>
        <p class="info-customer">
            <span><?= Html::encode(count($task->customer->profiles->customerTasks)) ?> заданий</span>
            <span class="last-"><?= Html::encode($regDateFormatter) ?> на сайте</span>
        </p>
        <a href="<?= Url::to(['users/view', 'id' => $task->customer->id]); ?>" class="link-regular">Смотреть профиль</a>
      </div>
    </div>
    <div id="chat-container">
      <!-- добавьте сюда атрибут task с указанием в нем id текущего задания -->
      <chat class="connect-desk__chat"><?= Html::encode($task->id); ?></chat>
    </div>
</section>