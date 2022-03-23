<?php

use frontend\forms\TaskForm;
use frontend\models\Category;
use frontend\models\Task;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var View $this */
/* @var string $title */
/* @var TaskForm $taskForm */
/* @var Task[] $tasks */
/* @var Category[] $categories */
/* @var array $periodTime */

$this->title = $title;

?>

<section class="new-task">

    <div class="new-task__wrapper">
        <h1>Новые задания</h1>

        <?php foreach($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="<?= Url::to(['tasks/view', 'id' => $task->id]); ?>" class="link-regular"><h2><?= Html::encode($task->title) ?></h2></a>
                    <a  class="new-task__type link-regular" href="#"><p><?= Html::encode($task->category->category) ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= Html::encode($task->icon) ?>"></div>
                <p class="new-task_description">
                    <?= Html::encode($task->content) ?>
                </p>
                <b class="new-task__price new-task__price--<?= Html::encode($task->icon) ?>">
                    <?= Html::encode($task->cost) ?><b> ₽</b>
                </b>
                <p class="new-task__place"><?= Html::encode($task->city->city) ?></p>
                <span class="new-task__time">
                    <?= Html::encode(Yii::$app->formatter->format(strtotime($task->date_published), 'relativeTime')) ?>
                </span>
            </div>
        <?php endforeach; ?>

    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
</section>
<section  class="search-task">
    <div class="search-task__wrapper">
        <!-- Форма Фильтров -->
        <?php $form = ActiveForm::begin([
            'id' => 'filter-tasks',
            'options' => ['class' => 'search-task__form', 'enctype' => 'multipart/form-data'],
        ]); ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <!-- Фильтр Категории -->
                <?php foreach ($categories as $category): ?>
                    <?= $form->field($taskForm, "filterCategories[$category->id]", [
                            'template' => "{input}{label}",
                            'options' => ['tag' => false]
                        ])
                        ->checkbox(['class' => 'visually-hidden checkbox__input'], false)
                        ->label($category->category); ?>
                <?php endforeach; ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <!-- Фильтр Наличие отклика -->
                <?= $form->field($taskForm, 'filterHasResponse', [
                        'template' => "{input}{label}",
                        'options' => ['tag' => false]
                    ])
                    ->checkbox(['class' => 'visually-hidden checkbox__input'], false); ?>

                <!-- Фильтр Удаленная работа -->
                <?= $form->field($taskForm, 'filterHasRemoteWork', [
                        'template' => "{input}{label}",
                        'options' => ['tag' => false]
                    ])
                    ->checkbox(['class' => 'visually-hidden checkbox__input'], false); ?>
            </fieldset>

            <!-- Фильтр Период -->
            <?= $form->field($taskForm, 'filterPeriodTime', [
                    'template' => "{label}{input}",
                    'options' => ['tag' => false]
                ])
                ->dropDownList($periodTime, ['class' => 'multiple-select input'])
                ->label($taskForm->attributes['filterPeriodTime'], [
                        'options' => [Task::ONE_YEAR => ['Selected' => true]],
                        'class' => 'search-task__name'
                ]); ?>

            <!-- Фильтр Поиск по названию -->
            <?= $form->field($taskForm, 'searchByTitle', [
                    'template' => "{label}{input}",
                    'options' => ['tag' => false],
                ])
                ->textInput(['class' => 'input-middle input', 'type' => 'search'])
                ->label($taskForm->attributes['searchByTitle'], ['class' => 'search-task__name']); ?>

            <!-- Кнопка Поиск -->
            <?= Html::submitButton('Искать', ['class' => 'button']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</section>