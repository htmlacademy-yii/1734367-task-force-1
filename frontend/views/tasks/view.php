<?php

use frontend\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var View $this */
/* @var Task $task */

$this->title = $task->getTitlePage();

$regDate = Yii::$app->formatter->format(strtotime($task->customer->created_at), 'relativeTime');
$regDateList = array_slice(explode(' ', $regDate), 0, -1);
$regDateFormatter = implode(' ', $regDateList);

?>

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
            <div class="content-view__map">
              <a href="#"><img src="./img/map.jpg" width="361" height="292" alt="Москва, Новый арбат, 23 к. 1"></a>
            </div>
            <div class="content-view__address">
              <span class="address__town">Москва</span><br>
              <span>Новый арбат, 23 к. 1</span>
              <p>Вход под арку, код домофона 1122</p>
            </div>
          </div>
        </div>
      </div>
      <div class="content-view__action-buttons">
        <button class=" button button__big-color response-button open-modal"
                type="button" data-for="response-form">Откликнуться
        </button>
        <button class="button button__big-color refusal-button open-modal"
                type="button" data-for="refuse-form">Отказаться
        </button>
        <button class="button button__big-color request-button open-modal"
                type="button" data-for="complete-form">Завершить
        </button>
      </div>
    </div>
    <div class="content-view__feedback">
      <h2>Отклики <span><?= Html::encode(count($task->responses)) ?></span></h2>
      <div class="content-view__feedback-wrapper">

        <?php foreach($task->responses as $response): ?>
            <div class="content-view__feedback-card">
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
              <div class="feedback-card__actions">
                <a class="button__small-color request-button button"
                   type="button">Подтвердить</a>
                <a class="button__small-color refusal-button button"
                   type="button">Отказать</a>
              </div>
            </div>
        <?php endforeach; ?>

      </div>
    </div>
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
      <chat class="connect-desk__chat"></chat>
    </div>
</section>