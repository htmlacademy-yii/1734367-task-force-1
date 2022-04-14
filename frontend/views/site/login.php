<?php

use yii\web\View;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use frontend\forms\LoginForm;

/* @var View $this */
/* @var string $title */

$this->title = 'Логин';

$loginForm = new LoginForm();

?>

<section class="form-modal" id="enter-form">
    <?php $form = ActiveForm::begin([
        'id' => 'login',
        'fieldConfig' =>[
            'template' => "{label}\n{input}",
            'options' => ['tag' => false],
            'inputOptions' => ['class' => 'enter-form-email input input-middle'],
            'labelOptions' => ['class' => 'form-modal-description'],
        ],
    ]); ?>
    <p><?= $form->field($loginForm, 'email')->textInput(['type' => 'email']); ?></p>
    <p><?= $form->field($loginForm, 'password')->textInput(['type' => 'password']); ?></p>
    <?= Html::submitButton('Войти', ['class' => 'button']); ?>
    <?php ActiveForm::end(); ?>
</section>
