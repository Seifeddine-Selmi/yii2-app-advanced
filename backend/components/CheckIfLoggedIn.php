<?php

namespace backend\components;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\web\Application;

class CheckIfLoggedIn extends Behavior{

    /*
     * Handling Component Events
     * Override events function
     */
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'CheckIfLoggedIn',
        ];
    }


    public function CheckIfLoggedIn(){
        
        $url = '';
        if (Yii::$app->user->isGuest) {
            echo "You are a guest";
            //$url = Yii::$app->getResponse()->redirect('http://y2aa-frontend.dev/');
        }else {
            echo "You are logged in";
           // $url = Yii::$app->getResponse()->redirect('http://y2aa-frontend.dev/');
        }

        //return $url;
    }


}