<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // echo Html::a('Create Companies', ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::button('Create Companies', ['value'=>Url::to('index.php?r=companies/create'),'class' => 'btn btn-success','id'=>'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'header'=>'<h4>Companies</h4>',
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

           // 'company_id',
            'company_name',
            'company_email:email',
            'company_address',

           // 'company_start_date',
            [
                'attribute' => 'company_start_date',
                'value' => 'company_start_date',
                'format' => 'raw',
                'filter' => DatePicker::widget([
							'model' => $searchModel,
							'attribute' => 'company_start_date',
							//'template' => '{addon}{input}',
								'clientOptions' => [
									'autoclose' => true,
									'format' => 'yyyy-mm-dd'
								]
						]),
            ],

            // 'company_created_date',
            // 'company_status',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
