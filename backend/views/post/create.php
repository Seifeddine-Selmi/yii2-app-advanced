<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/plugins/jQuery/jquery-2.2.3.min.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
