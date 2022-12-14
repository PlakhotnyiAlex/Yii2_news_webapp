<?php
/**
 * @var \frontend\models\News $model
 */

use yii\helpers\Html;

echo Html::tag('h1', Html::encode($model->title));

echo Html::a($model->category->title, ['category/view', 'id' => $model->category->id], ['class' => 'badge badge-success']), ' ';

foreach ($model->getTags()->each() as $tag) {
    echo Html::a($tag->title, ['tag/view', 'id' => $tag->id], ['class' => 'badge badge-secondary']), ' ';
}

echo Html::tag('div', \yii\helpers\HtmlPurifier::process($model->description));

echo Html::tag(
    'p',
    Html::a(Yii::t('frontend', 'Go back'), ['news/index'], ['class' => 'btn btn-default']),
    ['class' => 'text-right']

);

