<?php

namespace backend\controllers;

use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
       print_r("Test");
        die;
    }
}