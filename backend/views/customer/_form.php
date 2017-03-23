<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Location;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'zip_code')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Location::find()->all(),'zip_code','zip_code'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select a Zip Code','id'=>'zipCode'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php // Include javascript in file yii2 ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/customer-location.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<?php

/*
 $script = <<< JS
// here you right all your javascript stuff


JS;
$this->registerJs($script);
*/
?>
