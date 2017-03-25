<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii2fullcalendar\yii2fullcalendar;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    Modal::begin([
        'header'=>'<h4>Event</h4>',
        'id' => 'modal',
        'size'=>'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>


    <?= yii2fullcalendar::widget(array(
        'events'=> $events,
        'options' => [
            //'lang' => 'en',
            //... more options to be defined here!
        ],
        // 'ajaxEvents' => Url::to(['/timetrack/default/jsoncalendar']),
    ));
    ?>



    <?php
   /* echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/
     ?>
</div>
