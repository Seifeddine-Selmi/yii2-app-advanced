<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Companies;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branches-form">

    <?php $form = ActiveForm::begin([
                                      'id'=>$model->formName(),
                                      'enableAjaxValidation'=>true,
                                      'validationUrl' => Url::toRoute('branches/validation'),
                                    ]); ?>

    <?php //echo $form->field($model, 'companies_company_id')->dropdownList(Companies::getCompanies()) ?>
    <?php
   /* echo $form->field($model, 'companies_company_id')->dropdownList(
        ArrayHelper::map(Companies::find()->all(), 'company_id', 'company_name'),
        ['prompt' => 'Select Company']
    )*/
    ?>
    <?= $form->field($model, 'companies_company_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Companies::find()->all(), 'company_id', 'company_name'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select a company ...'],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                ]);
    ?>

    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$script = <<< JS

$('form#{$model->formName()}').on('beforeSubmit', function(e)
{
   var \$form = $(this);
    $.post(
        \$form.attr("action"), // serialize Yii2 form
        \$form.serialize()
    )
        .done(function(result) {
        if(result.message == 'Success')
        {
            $(\$form).trigger("reset");
            $.pjax.reload({container:'#branchesGrid'});
        }else
        {
            $("#message").html(result.message);
        }
        }).fail(function()
        {
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
?>
