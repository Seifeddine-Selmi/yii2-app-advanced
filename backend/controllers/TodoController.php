<?php

namespace backend\controllers;
use Yii;
use yii\rest\ActiveController;
use backend\models\Todo;

class TodoController extends ActiveController
{
    public $modelClass = 'backend\models\Todo';

    public function actions()
    {
        $actions = parent::actions();
        // disable the "create", "view", "update" and "delete" actions
        unset( $actions['create'], $actions['view'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionCreate()
    {

        $model = new Todo();
        $model->load(Yii::$app->request->post(),'');
        $model->status = 10;
        $model->save();

        return $model;

    }

    public function actionView($id)
    {
        $model = Todo::findOne($id);
        return $model;
    }

    public function actionUpdate($id)
    {
        $model = Todo::findOne($id);

        $model->load(Yii::$app->request->post(),'');
        $model->status = 20;
        $model->save();

        return $model;
    }

    public function actionDelete($id)
    {
        $model = Todo::findOne($id)->delete();
        return $model;
    }
}