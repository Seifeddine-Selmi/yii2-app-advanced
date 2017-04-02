<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Departments', ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::button('Create Departments', ['value'=>Url::toRoute('departments/create'),'class' => 'btn btn-success','id'=>'modalButton']) ?>
    </p>

    <?php
    Modal::begin([
        'header'=>'<h4>Departments</h4>',
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

          //  'department_id',

            // 'companies_company_id',// 1- Replace company_id with company_name
           // 'companiesCompany.company_name', // 2- getCompaniesCompany in Departments model
            [
                'attribute' => 'companies_company_id',  // 3-  companies_company_id in attributeLbels in Branches.php Models
                'value' => 'companiesCompany.company_name',// Replace companiesCompany.company_name with this array For Searching Related Table Data From the GridView
            ],



            // 'branches_branch_id', // 1- Replace branch_id with branch_name
            //'branchesBranch.branch_name',  // 2- getBranchesBranch in Departments model
            [
                'attribute' => 'branches_branch_id',  // 3-  branches_branch_id in attributeLbels in Departments.php Models
                'value' => 'branchesBranch.branch_name',// Replace branchesBranch.branch_name with this array For Searching Related Table Data From the GridView
            ],

            'department_name',
            'department_created_date',
            // 'department_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
