<?php

/* @var $this yii\web\View */
/* @var User $users */

use frontend\models\User;
use yii\bootstrap4\Html;

$this->title = 'Users';
?>

<section class="user__search">

    <?php foreach($users as $user): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="#"><img src="<?= Html::encode($user->profiles->avatar) ?>" width="65" height="65"></a>
                    <span><?= Html::encode(count($user->profiles->performerTasks)) ?> заданий</span>
                    <span><?= Html::encode(count($user->profiles->performerReviews)) ?> отзывов</span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="#" class="link-regular"><?= Html::encode($user->name) ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b><?= Html::encode($user->profiles->rating) ?></b>
                    <p class="user__search-content"><?= Html::encode($user->profiles->biography) ?></p>
                </div>
                <span class="new-task__time">
                    Был на сайте <?= Html::encode(Yii::$app->formatter->format(strtotime($user->profiles->last_activity), 'relativeTime')) ?>
                </span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <?php foreach($user->profiles->categories as $category): ?>
                    <a href="#" class="link-regular"><?= Html::encode($category->category) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <form class="search-task__form" name="users" method="post" action="#">
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <input class="visually-hidden checkbox__input" id="101" type="checkbox" name="" value="" checked disabled>
                <label for="101">Курьерские услуги </label>
                <input class="visually-hidden checkbox__input" id="102" type="checkbox" name="" value="" checked>
                <label  for="102">Грузоперевозки </label>
                <input class="visually-hidden checkbox__input" id="103" type="checkbox" name="" value="">
                <label  for="103">Переводы </label>
                <input class="visually-hidden checkbox__input" id="104" type="checkbox" name="" value="">
                <label  for="104">Строительство и ремонт </label>
                <input class="visually-hidden checkbox__input" id="105" type="checkbox" name="" value="">
                <label  for="105">Выгул животных </label>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <input class="visually-hidden checkbox__input" id="106" type="checkbox" name="" value="" disabled>
                <label for="106">Сейчас свободен</label>
                <input class="visually-hidden checkbox__input" id="107" type="checkbox" name="" value="" checked>
                <label for="107">Сейчас онлайн</label>
                <input class="visually-hidden checkbox__input" id="108" type="checkbox" name="" value="" checked>
                <label for="108">Есть отзывы</label>
                <input class="visually-hidden checkbox__input" id="109" type="checkbox" name="" value="" checked>
                <label for="109">В избранном</label>
            </fieldset>
            <label class="search-task__name" for="110">Поиск по имени</label>
            <input class="input-middle input" id="110" type="search" name="q" placeholder="">
            <button class="button" type="submit">Искать</button>
        </form>
    </div>
</section>