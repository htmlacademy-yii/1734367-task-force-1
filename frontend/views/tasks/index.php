<?php

use frontend\forms\TaskForm;
use frontend\models\Category;
use frontend\models\Task;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var View $this */
/* @var Task[] $tasks */
/* @var TaskForm $taskForm */
/* @var Category[] $categories */
/* @var array $periodTime */

$this->title = 'TaskForce';
?>

<section class="new-task">

    <div class="new-task__wrapper">
        <h1>Новые задания</h1>

        <?php foreach($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="#" class="link-regular"><h2><?= Html::encode($task->title) ?></h2></a>
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

        <!--
            1) Для формы нужно создать новый контроллер:
                - /frontend/froms/TaskForm.php
            2) В новом контроллере прописать логику работы формы, как в примерах
            3) В шаблоне работать с новый контроллером, а также:
                - добавить публичные свойства фильтров формы
                - в rules указать наименования фильтров формы
            4) Вынести форму из шалона в новый шаблон, к примеру: _form.php

            https://www.yiiframework.com/doc/guide/2.0/ru/input-forms

            https://www.yiiframework.com/doc/guide/2.0/en/output-data-widgets#filtering-data

            https://ru.stackoverflow.com/questions/708985/%D0%9A%D0%B0%D0%BA-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-%D1%81%D0%B4%D0%B5%D0%BB%D0%B0%D1%82%D1%8C-%D1%84%D0%B8%D0%BB%D1%8C%D1%82%D1%80-%D1%82%D0%BE%D0%B2%D0%B0%D1%80%D0%BE%D0%B2-%D1%81-%D1%87%D0%B5%D0%BA%D0%B1%D0%BE%D0%BA%D1%81%D0%B0%D0%BC%D0%B8-model-search

            https://qna.habr.com/q/521850

            //
            https://elisdn.ru/blog/111/yii2-composite-forms
            https://elisdn.ru/blog/76/seo-service-on-yii2-admin-and-sef
            https://yiiframework.ru/forum/viewtopic.php?t=29160
            // new
            https://yiiframework.ru/forum/viewtopic.php?t=37281
        -->

        <!-- Форма START -->
        <div class="index-form">
            <?php $form = ActiveForm::begin([
                'id' => 'filter-categories',
                'options' => ['class' => 'search-task__form'],
//                'fieldConfig' => [
//                    'template' => "{label}\n{input}",
////                    'options' => ['class' => 'search-task__form'],
////                    'inputOptions' => ['class' => 'visually-hidden checkbox__input']
//                ],

            ]); ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <!-- Фильтр Категорий -->
                <?= $form->field($taskForm, 'filterCategories')->checkboxList(ArrayHelper::map($categories, 'id', 'category')); ?>
            </fieldset>

            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <!-- Фильтр Наличие отклика -->
                <?= $form->field($taskForm, 'filterHasResponse')->checkbox(); ?>
                <!-- Фильтр Удаленная работа -->
                <?= $form->field($taskForm, 'filterHasRemoteWork')->checkbox(); ?>
            </fieldset>

            <!-- Фильтр Период -->
            <?= $form->field($taskForm, 'filterPeriodTime', [
                'template' => "{label}\n{input}",
                'labelOptions' => ['class' => 'search-task__name'],
                'inputOptions' => ['class' => 'multiple-select input'],
            ])->dropDownList($periodTime, [
                    'options' => [Task::ONE_WEEK => ['Selected' => true]],
            ]); ?>

            <!-- Фильтр Поиск по названию -->
            <?= $form->field($taskForm, 'searchByTitle')->textInput(['placeholder' => 'Название задания']); ?>

            <div class="form-group">
                <?= Html::submitButton('Искать', ['class' => 'button']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <!-- Форма END -->

<!--        <form class="search-task__form" name="test" method="post" action="#">-->
<!--            <fieldset class="search-task__categories">-->
<!--                <legend>Категории</legend>-->
<!--                <input class="visually-hidden checkbox__input" id="1" type="checkbox" name="" value="" checked>-->
<!--                <label for="1">Курьерские услуги </label>-->
<!--                <input class="visually-hidden checkbox__input" id="2" type="checkbox" name="" value="" checked>-->
<!--                <label  for="2">Грузоперевозки </label>-->
<!--                <input class="visually-hidden checkbox__input" id="3" type="checkbox" name="" value="">-->
<!--                <label  for="3">Переводы </label>-->
<!--                <input class="visually-hidden checkbox__input" id="4" type="checkbox" name="" value="">-->
<!--                <label  for="4">Строительство и ремонт </label>-->
<!--                <input class="visually-hidden checkbox__input" id="5" type="checkbox" name="" value="">-->
<!--                <label  for="5">Выгул животных </label>-->
<!--            </fieldset>-->
<!--            <fieldset class="search-task__categories">-->
<!--                <legend>Дополнительно</legend>-->
<!--                <input class="visually-hidden checkbox__input" id="6" type="checkbox" name="" value="">-->
<!--                <label for="6">Без откликов</label>-->
<!--                <input class="visually-hidden checkbox__input" id="7" type="checkbox" name="" value="" checked>-->
<!--                <label for="7">Удаленная работа </label>-->
<!--            </fieldset>-->
<!--            <label class="search-task__name" for="8">Период</label>-->
<!--            <select class="multiple-select input" id="8"size="1" name="time[]">-->
<!--                <option value="day">За день</option>-->
<!--                <option selected value="week">За неделю</option>-->
<!--                <option value="month">За месяц</option>-->
<!--            </select>-->
<!--            <label class="search-task__name" for="9">Поиск по названию</label>-->
<!--            <input class="input-middle input" id="9" type="search" name="q" placeholder="">-->
<!--            <button class="button" type="submit">Искать</button>-->
<!--        </form>-->
    </div>
</section>