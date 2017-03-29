<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

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
        <?php //echo Html::a('Create Branches', ['create'], ['class' => 'btn btn-success']) ?>
        <?php echo Html::button('Create Branches', ['value'=>Url::to('index.php?r=branches/create'),'class' => 'btn btn-success','id'=>'modalButton']) ?>
    </p>


    <?php
    Modal::begin([
        'header'=>'<h4>Branches</h4>',
        'id' => 'modal',
        'size'=>'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
    ?>

    <?php
// Exporting Excel Sheet using Kartik Export Menu Widget
    $gridColumns = [
       // 'branch_id',
        'branch_name',
        'branch_address',
        'branch_created_date',
        'branch_status',
    ];

    // Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
       /* 'exportConfig' => [
            'HTML' => false,
            'CSV' => false,
            'TXT' => false,
            'PDF' => false,
            'Excel5' => false,
            'Excel2007'  => false,
        ],*/
    ]);
    ?>

    <?php //Pjax::begin(['id'=>'branchesGrid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        //'export' => false,
        'rowOptions'=>function($model){
            if($model->branch_status == 'inactive')
            {
                return ['class'=>'danger'];
            }else
            {
                return ['class'=>'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'branch_id',

           //  'companies_company_id',  // 1- Replace company_id with company_name
           // 'companiesCompany.company_name', // 2- getCompaniesCompany in Departments model
            [
                'attribute' => 'companies_company_id',  //3-  companies_company_id in attributeLbels in Branches.php Models
                'value' => 'companiesCompany.company_name',// Replace companiesCompany.company_name with this array For Searching Related Table Data From the GridView
            ],

            //'branch_name',
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'BRANCH',
                'attribute' => 'branch_name',

            ],
            'branch_address',
            'branch_created_date',
            // 'branch_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>

<?php

$script = <<< JS
// Fixed kartik export buttons with dropdown bootstrap adminLTE
 $(".dropdown-toggle").dropdown();

JS;
$this->registerJs($script);

?>
