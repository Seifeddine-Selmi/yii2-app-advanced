<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-item-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'product_item_no',
            'quantity',
           // 'product_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'product-item'
            ],
        ],
    ]); ?>
</div>
