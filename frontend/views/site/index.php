<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
use yii\helpers\Url;
?>
<div class="site-index">

    <div class="jumbotron-fluid">
        <div class="container">
            <h1 class="title display-3 text-center"><?php echo Yii::t('frontend', 'Online news'); ?></h1>

            <p class="lead text-center"><?php echo Yii::t('frontend', 'Subscribe to get the latest news'); ?></p>

            <p class="text-center">
                <a class="btn btn-lg btn-success" href="<?php echo Url::to(['news/index']); ?>">
                    <?php echo Yii::t('frontend', 'Start the journey'); ?>
                </a>
            </p>
        </div>
    </div>

</div>