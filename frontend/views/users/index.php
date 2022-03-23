<?php

use frontend\forms\UserForm;
use frontend\models\Category;
use frontend\models\User;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var View $this */
/* @var string $title */
/* @var UserForm $userForm */
/* @var User[] $users */
/* @var Category[] $categories */

$this->title = $title;

?>

<section class="user__search">

    <?php foreach($users as $user): ?>

    <?php
        $dateNow = date('Y-m-d H:i:s');
        $dataActivity = date('Y-m-d H:i:s', strtotime('+30 minute', strtotime($user->profiles->last_activity)));
        $hasOnline = $dataActivity > $dateNow;
    ?>

        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="<?= Url::to(['users/view', 'id' => $user->id]); ?>"><img src="<?= Html::encode($user->profiles->avatar) ?>" width="65" height="65"></a>
                    <span><?= Html::encode(count($user->profiles->performerTasks)) ?> заданий</span>
                    <span><?= Html::encode(count($user->profiles->performerReviews)) ?> отзывов</span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $user->id]); ?>" class="link-regular"><?= Html::encode($user->name) ?></a></p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b><?= Html::encode($user->profiles->rating) ?></b>
                    <p class="user__search-content"><?= Html::encode($user->profiles->biography) ?></p>
                </div>
                <span class="new-task__time">
                    <?php if ($hasOnline) { ?>
                        Онлайн
                    <?php } else { ?>
                        Был на сайте <?= Html::encode(Yii::$app->formatter->format(strtotime($user->profiles->last_activity), 'relativeTime')) ?>
                    <?php } ?>
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
        <?php $form = ActiveForm::begin([
            'id' => 'filter-performers',
            'options' => ['class' => 'search-task__form', 'enctype' => 'multipart/form-data']
        ]) ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <!-- Фильтр Категории -->
                <?php foreach ($categories as $category): ?>
                    <?= $form->field($userForm, "filterCategories[$category->id]", [
                        'template' => "{input}{label}",
                        'options' => ['tag' => false]
                    ])
                        ->checkbox(['class' => 'visually-hidden checkbox__input'], false)
                        ->label($category->category); ?>
                <?php endforeach; ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <!-- Фильтр Сейчас свободен -->
                <?= $form->field($userForm, 'filterHasFree',[
                    'template' => "{input}{label}",
                    'options' => ['tag' => false]
                ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false); ?>

                <!-- Фильтр Сейчас онлайн -->
                <?= $form->field($userForm, 'filterHasOnline',[
                    'template' => "{input}{label}",
                    'options' => ['tag' => false]
                ])
                    ->checkbox(['class' => 'visually-hidden checkbox__input'], false); ?>

                <!-- Фильтр Наличие отзывов -->
                <?= $form->field($userForm, 'filterHasReviews',[
                    'template' => "{input}{label}",
                    'options' => ['tag' => false]
                ])
                    ->checkbox(['class' => 'visually-hidden checkbox__input'], false); ?>

                <!-- Фильтр Наличие в избранном -->
                <?= $form->field($userForm, 'filterHasFavorites',[
                    'template' => "{input}{label}",
                    'options' => ['tag' => false]
                ])
                    ->checkbox(['class' => 'visually-hidden checkbox__input'], false); ?>
            </fieldset>

            <!-- Фильтр Поиск по имени -->
            <?= $form->field($userForm, 'searchByName', [
                'template' => "{label}{input}",
                'options' => ['tag' => false],
            ])
                ->textInput(['class' => 'input-middle input', 'type' => 'search'])
                ->label($userForm->attributes['searchByName'], ['class' => 'search-task__name']); ?>

            <!-- Кнопка Поиск -->
            <?= Html::submitButton('Искать', ['class' => 'button']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</section>