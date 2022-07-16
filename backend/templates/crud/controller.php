<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?php echo StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?php echo ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?php echo ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?php echo ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * <?php echo $controllerClass ?> implements the CRUD actions for <?php echo $modelClass ?> model.
 */
class <?php echo $controllerClass ?> extends <?php echo StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all <?php echo $modelClass ?> models.
     *
     * @return string
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?php echo isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?php echo $modelClass ?>::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
<?php foreach ($pks as $pk): ?>
                    <?php echo "'$pk' => SORT_DESC,\n" ?>
<?php endforeach; ?>
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Creates a new <?php echo $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new <?php echo $modelClass ?>();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index', <?php echo $urlParams ?>]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing <?php echo $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(<?php echo $actionParams ?>)
    {
        $model = $this->findModel(<?php echo $actionParams ?>);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index', <?php echo $urlParams ?>]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing <?php echo $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(<?php echo $actionParams ?>)
    {
        $this->findModel(<?php echo $actionParams ?>)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?php echo $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?php echo implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?php echo $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?php echo $actionParams ?>)
    {
<?php
$condition = [];
foreach ($pks as $pk) {
    $condition[] = "'$pk' => \$$pk";
}
$condition = '[' . implode(', ', $condition) . ']';
?>
        if (($model = <?php echo $modelClass ?>::findOne(<?php echo $condition ?>)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(<?php echo $generator->generateString('The requested page does not exist.') ?>);
    }
}
