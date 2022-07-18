<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\helpers\EnabledHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\News */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <?php echo Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success float-right']) ?>

    <h1><?php echo Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [


            'id',
            [
                'label' => 'Category',
                'attribute' => 'category_id',
                'value' => 'category.title',
            ],
            'title',
            // example of callable function for value
           /* [
                'attribute' => 'description',
                'value' => function ($model, $key, $index, $column) {
                    return StringHelper::truncateWords($model->description, 40);
                },
            ],*/
            'description',
            // example of filter and custom helper
           /* [
                'attribute' => 'enabled',
                'format' => 'boolean',
                'value' => 'news.enabled',
            ], */
           [
                'attribute' => 'enabled',
                'filter' => EnabledHelper::getEnabledFilter(),
                'value' => function ($model) {
                    return EnabledHelper::getEnabledView($model->enabled);
                },
            ],

           // 'enabled',
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
