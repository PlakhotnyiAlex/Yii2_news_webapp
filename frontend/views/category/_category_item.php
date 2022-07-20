<?php
/** @var \frontend\models\Category $model */

use yii\helpers\Html;

echo Html::a(
    $model->title . Html::tag('span', $model->getNews()->count(), ['class' =>'badge badge-primary badge-pill']),
    ['category/view', 'id' => $model->id],
    ['class' => 'list-group-item d-flex justify-content-between align-items-center']
);
