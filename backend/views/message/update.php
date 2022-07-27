<?php

use yii\helpers\Html;
use backend\models\SourceMessage;
/* @var $this yii\web\View */
/* @var $model backend\models\Message */

$this->title = Yii::t('app', 'Update Message: {name}', [
    'name' => $model->source->message,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="message-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
