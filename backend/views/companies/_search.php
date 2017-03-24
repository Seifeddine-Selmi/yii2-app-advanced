<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CompaniesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="companies-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?php  echo $form->field($model, 'globalSearch') ?>
    <?php
      /*
        echo  $form->field($model, 'company_id');

        echo  $form->field($model, 'company_name');

        echo  $form->field($model, 'company_email');

        echo  $form->field($model, 'company_address');

        echo  $form->field($model, 'company_created_date');

        echo $form->field($model, 'company_status');

        //echo $form->field($model, 'company_start_date');
      */

    ?>



    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
