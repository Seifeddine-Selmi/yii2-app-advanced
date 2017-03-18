<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BranchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branches-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Branches', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'branch_id',

           //  'companies_company_id',  // 1- Replace company_id with company_name
           // 'companiesCompany.company_name', // 2- getCompaniesCompany in Departments model
            [
                'attribute' => 'companies_company_id',  //3-  companies_company_id in attributeLbels in Branches.php Models
                'value' => 'companiesCompany.company_name',// Replace companiesCompany.company_name with this array For Searching Related Table Data From the GridView
            ],

            'branch_name',
            'branch_address',
            'branch_created_date',
            // 'branch_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
