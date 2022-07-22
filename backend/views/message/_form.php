<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'id')->textInput() ?>

    <?php echo $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

    <div class="form-group pull-right">
        <?php echo Html::a(Yii::t('app', 'Cancel'), ['message/index'], ['class' => ['btn','btn-danger']]) ?>
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
