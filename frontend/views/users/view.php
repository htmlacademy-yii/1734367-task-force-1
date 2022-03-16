<?php

use frontend\models\User;
use yii\helpers\Html;
use yii\web\View;

/* @var View $this */
/* @var User $user */

$this->title = $user->getTitlePage();

$userOld = Yii::$app->formatter->format(strtotime($user->profiles->date_birthday), 'relativeTime');
$userOldList = array_slice(explode(' ', $userOld), 0, -1);
$userOldFormatter = implode(' ', $userOldList);

$address = 'Россия, ' . $user->city->city . ', ' . $userOldFormatter;

?>

<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?= Html::encode($user->profiles->avatar) ?>" width="120" height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?= Html::encode($user->name) ?></h1>
                <p><?= Html::encode($address) ?></p>
                <div class="profile-mini__name five-stars__rate">
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b><?= Html::encode($user->profiles->rating) ?></b>
                </div>
                <b class="done-task">Выполнил <?= Html::encode(count($user->profiles->performerTasks)) ?> заказов</b>
                <b class="done-review">Получил <?= Html::encode(count($user->profiles->performerReviews)) ?> отзывов</b>
            </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span>
                    Был на сайте <?= Html::encode(Yii::$app->formatter->format(strtotime($user->profiles->last_activity), 'relativeTime')) ?>
                </span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="content-view__description">
            <p><?= Html::encode($user->profiles->biography) ?></p>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Специализации</h3>
                <div class="link-specialization">

                    <?php foreach($user->profiles->categories as $category): ?>
                        <a href="#" class="link-regular"><?= Html::encode($category->category) ?></a>
                    <?php endforeach; ?>

                </div>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--tel link-regular" href="#"><?= Html::encode($user->profiles->phone) ?></a>
                    <a class="user__card-link--email link-regular" href="#"><?= Html::encode($user->email) ?></a>
                    <a class="user__card-link--skype link-regular" href="#"><?= Html::encode($user->profiles->skype) ?></a>
                </div>
            </div>
            <div class="user__card-photo">
                <h3 class="content-view__h3">Фото работ</h3> <!-- $user->profiles->performerTasks[0]->pathFiles[0] -->

                <?php foreach($user->profiles->performerTasks as $task): ?>
                    <?php foreach($task->pathFiles as $pathFile): ?>
                        <a href="#">
                            <img src="<?= Html::encode($pathFile->path) ?>" width="85" height="86" alt="Фото работы">
                        </a>
                    <?php endforeach; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="content-view__feedback">
        <h2>Отзывы<span>(<?= Html::encode(count($user->profiles->performerReviews)) ?>)</span></h2>
        <div class="content-view__feedback-wrapper reviews-wrapper">

            <?php foreach($user->profiles->performerReviews as $review): ?>
                <div class="feedback-card__reviews">
                    <p class="link-task link">
                        Задание <a href="#" class="link-regular"><?= Html::encode($review->task->title) ?></a>
                    </p>
                    <div class="card__review">
                        <a href="#"><img src="<?= Html::encode($review->customerProfile->avatar) ?>" width="55" height="54"></a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link">
                                <a href="#" class="link-regular"><?= Html::encode($review->customerProfile->user->name) ?></a>
                            </p>
                            <p class="review-text">
                                <?= Html::encode($review->comment) ?>
                            </p>
                        </div>
                        <div class="card__review-rate">
                            <p class="five-rate big-rate"><?= Html::encode($review->value) ?><span></span></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__chat">

    </div>
</section>
