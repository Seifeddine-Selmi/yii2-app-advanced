<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\User as UserBackend;
use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'language'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'set-cookie', 'get-cookie'],
                        'allow' => true,
                        'roles' => ['@'],
                       /* 'matchCallback' => function ($rule, $action) {
                            return UserBackend::isAdmin(Yii::$app->user->identity->username);
                        }*/
                    ],
                ]/*,
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('You are not allowed to access this page');
                },*/
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                 //   'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // Create custom login layout
        $this->layout = 'loginLayout';


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
       // if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Setting Cookies
     *
     * @return string
     */
    public function actionSetCookie()
    {
        $cookie = new Cookie([
            'name' => 'test',
            'value' => 'test cookie value',
        ]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
        print_r($cookie);

    }

    /**
     * Getting Cookies
     *
     * @return string
     */
    public function actionGetCookie()
    {
        if(Yii::$app->getRequest()->getCookies()->has('test')){
            print_r(Yii::$app->getRequest()->getCookies()->getValue('test'));
        }

    }

    /**
     * Update site language
     *
     * @return string
     */
    public function actionLanguage()
    {
        if (isset($_POST["lang"])) {
            Yii::$app->language = $_POST["lang"];
            $cookie = new Cookie([
                'name' => 'lang',
                'value' => $_POST["lang"],
            ]);

            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

    }
}
