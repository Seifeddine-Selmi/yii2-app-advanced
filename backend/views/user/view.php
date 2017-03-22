<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
          //  'id',
            'username',
            'first_name',
            'last_name',

            'email:email',
            //    'role',
            [
                'attribute' => 'role',
                'value'=> function ($model) {
                    if($model->role == 10) {
                        return 'User';
                    }else if($model->role == 20){
                        return 'Moderator';
                    } else{
                        return 'Admin';
                    }
                },
            ],
            // 'status',
            [
                'attribute' => 'status',
                'value' => $model->status == 10 ? 'Active' : 'Inactive',
            ],
            'created_at:datetime',
            'updated_at:datetime',

            //  'auth_key',
            //   'password_hash',
            //  'password_reset_token',


        ],
    ]) ?>

</div>
