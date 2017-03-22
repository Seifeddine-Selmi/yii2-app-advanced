<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::button('Create Post', ['value'=>Url::to('index.php?r=post/create'),'class' => 'btn btn-success','id'=>'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'header'=>'<h4>Post</h4>',
        'id' => 'modal',
        'size'=>'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
          //  'author_id',
          //  'author.username',
            [
                'attribute'=>'author_id',
                'label' => 'Author Name',
                'value'=>'author.username'
            ],
            'title',
            'body:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
