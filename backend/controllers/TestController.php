<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->MyComponent->hello();


    }

    public function actionMoney($money)
    {


        $cad_to_tnd = Yii::$app->MyComponent->currencyConvert('CAD','TND',$money);

        $tnd_to_cad = Yii::$app->MyComponent->currencyConvert('TND','CAD',$money);


        $usd_to_tnd = Yii::$app->MyComponent->currencyConvert('USD','TND',$money);

        $tnd_to_usd = Yii::$app->MyComponent->currencyConvert('TND','USD',$money);


        $tnd_to_eur = Yii::$app->MyComponent->currencyConvert('TND','EUR',$money);

        $eur_to_tnd = Yii::$app->MyComponent->currencyConvert('EUR','TND',$money);


        $usd_to_cad = Yii::$app->MyComponent->currencyConvert('USD','CAD',$money);

        $cad_to_usd = Yii::$app->MyComponent->currencyConvert('CAD','USD',$money);


        $cad_to_eur = Yii::$app->MyComponent->currencyConvert('CAD','EUR',$money);

        $eur_to_cad = Yii::$app->MyComponent->currencyConvert('EUR','CAD',$money);



        print_r("Money : ".$money);
        print_r('<br/><br/>');
        print_r('$$$$$$$$$$$$$$$$$$$$$$');
        print_r('<br/><br/>');


        print_r("CAD TO TND : ".$cad_to_tnd);
        print_r('<br/><br/>');
        print_r("TND TO CAD : ".$tnd_to_cad);

        print_r('<br/><br/>');
        print_r('$$$$$$$$$$$$$$$$$$$$$$');
        print_r('<br/><br/>');

        print_r("USD TO TND : ".$usd_to_tnd);
        print_r('<br/><br/>');
        print_r("TND TO USD : ".$tnd_to_usd);

        print_r('<br/><br/>');
        print_r('$$$$$$$$$$$$$$$$$$$$$$');
        print_r('<br/><br/>');


        print_r("EUR TO TND : ".$eur_to_tnd);
        print_r('<br/><br/>');
        print_r("TND TO EUR : ".$tnd_to_eur);


        print_r('<br/><br/>');
        print_r('$$$$$$$$$$$$$$$$$$$$$$');
        print_r('<br/><br/>');


        print_r("USD TO CAD : ".$usd_to_cad);
        print_r('<br/><br/>');
        print_r("CAD TO USD : ".$cad_to_usd);


        print_r('<br/><br/>');
        print_r('$$$$$$$$$$$$$$$$$$$$$$');
        print_r('<br/><br/>');

        print_r("CAD TO EUR : ".$cad_to_eur);
        print_r('<br/><br/>');
        print_r("EUR TO CAD : ".$eur_to_cad);


        die;
    }
}