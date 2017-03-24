<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
         //   'id',
            'product_no',
            'description:ntext',
        ],
    ]) ?>



        <!-- Dynamic Forms -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Product Items</h4></div>
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                       // 'limit' => 10, // the maximum times, an element can be cloned (default 999)
                      //  'min' => 1, // 0 or 1 (default 1)
                       // 'insertButton' => '.add-item', // css class
                       // 'deleteButton' => '.remove-item', // css class
                        'model' => $modelsProductItem[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'product_item_no',
                            'quantity',
                        ],
                    ]); ?>

                    <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($modelsProductItem as $i => $modelProductItem): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Product Item</h3>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php

                                            echo 'Product Item No: ' .$modelProductItem->product_item_no;
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo 'Quantity: '.$modelProductItem->quantity;
                                            ?>
                                        </div>
                                    </div><!-- .row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
        </div>


</div>
