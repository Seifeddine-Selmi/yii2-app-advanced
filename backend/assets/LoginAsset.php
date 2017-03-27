<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'plugins/iCheck/flat/blue.css',
      //  'plugins/iCheck/square/blue.css',
       // 'css/site.css',
    ];
    public $js = [
        'plugins/jQuery/jquery-2.2.3.min.js',
        '//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        'js/bootstrap/bootstrap.min.js',
        'plugins/iCheck/icheck.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];
}
