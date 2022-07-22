<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?php echo Html::encode($this->title) ?></h1>



    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'source.category',
            'source.message:ntext',
            'id',
            'language',
            'translation:ntext',
            [
                'class' => ActionColumn::class,
                'template' => '{update}',
                'urlCreator' => function ($action, \backend\models\Message $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'language' => $model->language]);
                 }
            ],
        ],
    ]); ?>


</div>
