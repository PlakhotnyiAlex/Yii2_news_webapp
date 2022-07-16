<?php

namespace frontend\controllers;

use frontend\models\News;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class NewsController extends \yii\web\Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {

        $title = 'You are on News/Index page';

        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->innerJoinWith('category'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'title' => $title,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
    */
    public function actionView($id)
    {
         $model = News::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Page not found');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
