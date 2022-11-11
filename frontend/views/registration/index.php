<?php

use frontend\forms\RegistrationForm;
use yii\bootstrap4\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var View $this */
/* @var string $title */
/* @var RegistrationForm $registrationForm */
/* @var array $cities */

$this->title = $title;

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">
        <!-- Форма Регистрации -->
        <?php $form = ActiveForm::begin([
            'id' => 'registration',
            'options' => ['class' => 'registration__user-form form-create'],
            'fieldConfig' =>[
                'options' => ['tag' => false],
            ]

        ]); ?>

            <!-- Электронная почта -->
            <?= $form->field($registrationForm, 'email', [
                    'template' => "{label}{input}<span class='field-registrationform-email required has-error'>{error}</span>",
                ])
                ->textInput(['class' => 'input textarea', 'rows' => '1', 'placeholder' => 'Укажите Email'])
                ->label('ЭЛЕКТРОННАЯ ПОЧТА', ['style' => 'margin-top: 0px;']) ?>

            <!-- Имя -->
            <?= $form->field($registrationForm, 'name', [
                'template' => "{label}{input}<span class='field-registrationform-name required has-error'>{error}</span>",
            ])
                ->textarea(['class' => 'input textarea', 'rows' => '1', 'placeholder' => 'Укажите имя'])
                ->label('Ваше имя'); ?>

            <!-- Город проживания -->
            <?= $form->field($registrationForm, 'city_id', [
                'template' => "{label}{input}<span class='field-registrationform-city required has-error'>{error}</span>",
            ])
                ->dropDownList($cities, ['class' => 'multiple-select input town-select registration-town', 'size' => '1'])
                ->label('Город проживания'); ?>

            <!-- Пароль -->
            <?= $form->field($registrationForm, 'password', [
                'template' => "{label}{input}<span class='field-registrationform-password required has-error'>{error}</span>",
            ])
                ->textInput(['class' => 'input textarea', 'type' => 'password', 'placeholder' => 'Введите пароль'])
                ->label('Пароль'); ?>

            <!-- Кнопка Создать аккаунт -->
            <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</section>