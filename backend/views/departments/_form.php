<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Companies;
use backend\models\Branches;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'companies_company_id')->dropdownList(Companies::getCompanies()) ?>
    <?=
    $form->field($model, 'companies_company_id')->dropdownList(
        ArrayHelper::map(Companies::find()->all(), 'company_id', 'company_name'),
        [
            'prompt' => 'Select Company',
            'onchange'=>'
                $.post( "index.php?r=branches/lists&id='.'"+$(this).val(), function( data ) {

                  $( "select#departments-branches_branch_id" ).html( data );
                });'
        ]
    )
    ?>


    <?php //echo $form->field($model, 'branches_branch_id')->dropdownList(Branches::getBranches()) ?>
    <?=
    $form->field($model, 'branches_branch_id')->dropdownList(
        ArrayHelper::map(Branches::find()->all(), 'branch_id', 'branch_name'),
        ['prompt' => 'Select Branch']
    )
    ?>

    <?= $form->field($model, 'department_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
