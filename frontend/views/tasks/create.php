<?php

use frontend\forms\CreateTaskForm;
use frontend\models\Category;
use yii\bootstrap4\Html;
use yii\jui\DatePicker;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var View $this */
/* @var string $title */
/* @var CreateTaskForm $createTaskForm */
/* @var Category[] $categories */

$this->title = $title;

?>

<section class="create__task">
    <h1>Публикация нового задания</h1>
    <div class="create__task-main">

        <?php $form = ActiveForm::begin([
//            'enableClientValidation' => true,
//            'enableAjaxValidation' => true,
            'id' => 'task-form',
            'action' => 'create',
            'options' => ['class' => 'create__task-form form-create', 'enctype' => 'multipart/form-data'],
            'fieldConfig' =>[
                'options' => ['tag' => false],
            ]
        ]); ?>

            <?=
                $form->field($createTaskForm, 'title', [
                    'template' => "{label}{input}<span class='field-createtaskform-title required has-error'>{error}</span>",
                ])->textarea(['class' => 'input textarea', 'rows' => 1])
                    ->label('Мне нужно');
            ?>

            <?=
                $form->field($createTaskForm, 'content', [
                    'template' => "{label}{input}<span class='field-createtaskform-content required has-error'>{error}</span>"
                ])->textarea(['class' => 'input textarea', 'rows' => 7])
                    ->label('Подробности задания');
            ?>

            <?=
                $form->field($createTaskForm, 'category_id', [
                    'template' => "{label}{input}<span class='field-createtaskform-category required has-error'>{error}</span>"
                ])
                    ->dropDownList($categories, ['class' => 'multiple-select input multiple-select-big', 'size' => '1'])
                    ->label('Категория');
            ?>

            <?=
                $form->field($createTaskForm, 'files[]', [
                    'template' => "
                        {label}
                        <span>Загрузите не более 2х файлов</span>
                        <span class='field-createtaskform-files required has-error'>{error}</span>
                        <div class='create__file'>
                            {input}
                        </div>
                    "
                ])->fileInput(['class' => 'dropzone', 'multiple' => true])
                    ->label('Файлы');
            ?>

            <?=
                $form->field($createTaskForm, 'location', [
                    'template' => "{label}{input}<span class='field-createtaskform-location required has-error'>{error}</span>"
                ])->widget(\yii\jui\AutoComplete::className(), [
                    'name'=>'name',
                    'options' => ['placeholder' => 'Поиск по АП...'],
                    'clientOptions' => [
                        'source' => new JsExpression("function(request, response) {
                            $.getJSON('".Url::to(['ajax/location'])."', {
                                term: request.term
                            }, response);
                        }"),
                    ],
                ])->textInput([
                    'class' => 'input-navigation input-middle input',
                    'type' => 'search',
                    'placeholder' => 'Укажите адрес',
                ])->label('Локация');
            ?>

            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?=
                        $form->field($createTaskForm, 'cost', [
                            'template' => "{label}{input}<span class='field-createtaskform-cost required has-error'>{error}</span>"
                        ])->textarea(['class' => 'input textarea input-money', 'rows' => 1])
                            ->label('Бюджет');
                    ?>
                </div>
                <div class="create__price-time--wrapper">
                    <?=
                        $form->field($createTaskForm,'date_limit', [
                            'template' => "{label}{input}<span class='field-createtaskform-date_limit required has-error'>{error}</span>"
                        ])->widget(DatePicker::class, [
                            'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                            'options' => [
                                'class'=> 'input-middle input input-date',
                                'autocomplete'=>'off'
                            ],
                            'clientOptions' => [
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '2022:2050',
                            ]])->label('Срок исполнения');
                    ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>
                    контент – ни наш, ни чей-либо еще. Заполняйте свои
                    макеты, вайрфреймы, мокапы и прототипы реальным
                    содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь,
                    что всё в фокусе, а фото показывает объект со всех
                    ракурсов.</p>
            </div>
        </div>
    </div>

    <?= Html::submitButton('Опубликовать', ['class' => 'button', 'form' => 'task-form']); ?>

</section>
