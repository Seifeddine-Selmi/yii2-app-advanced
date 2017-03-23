<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Password')  ?>

    <?php // echo $form->field($model, 'role')->dropDownList([ 10 => 'User', 20 => 'Moderator', 30 => 'Admin'], ['prompt' => 'Role']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 10 => 'Active', 0 => 'Inactive', ], ['prompt' => 'Status']) ?>

    <?php $authItems = ArrayHelper::map($authItems,'name','name'); ?>
    <?= $form->field($model,'permissions')->checkboxList($authItems,['class'=>'form-inline'])->label(false); ?>




    <?php //echo  $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
