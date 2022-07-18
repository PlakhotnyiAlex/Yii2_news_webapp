<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'category_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'enabled')->radioList([
        0 => 'No',
        1 => 'Yes',
    ]) ?>

    <div class="form-group pull-right">
        <?php echo Html::a(Yii::t('app', 'Cancel'), ['news/index'], ['class' => ['btn','btn-danger']]) ?>
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
