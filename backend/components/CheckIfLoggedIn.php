<?php

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;
use yii\console\Controller;
use yii\web\Application;

class CheckIfLoggedIn extends Behavior{

    /*
     * Handling Component Events
     * Override events function
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'CheckIfLoggedIn',
            Application::EVENT_BEFORE_REQUEST => 'ChangeLanguage',
        ];
    }


    public function CheckIfLoggedIn()
    {


        if (Yii::$app->getUser()->isGuest &&
            Yii::$app->getRequest()->url !== Url::to(Yii::$app->getUser()->loginUrl)
        ) {
            Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }

    }

    public function ChangeLanguage()
    {

        if(Yii::$app->getRequest()->getCookies()->has('lang')){
            Yii::$app->language = Yii::$app->getRequest()->getCookies()->getValue('lang');
        }

    }

}