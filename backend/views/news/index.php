<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <?php echo Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success float-right']) ?>

    <h1><?php echo Html::encode($this->title) ?></h1>



    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [


            'id',
            'category_id',
            'slug',
            'title',
            'description:ntext',
            //'enabled',
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, \backend\models\News $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
