<?php

namespace backend\controllers;

use Yii;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AccessRule;
//use common\models\User as UserCommon;
use backend\models\User;
use backend\models\AuthAssignment;
use backend\models\AuthItem;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * Example rules with rbac
     * @inheritdoc
     */
    public function behaviors()
    {
        return [


            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [
                            'sysadmin',
                            'admin',
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [
                            'sysadmin',
                            'admin',

                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [
                            'sysadmin'
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Example rules without rbac
     * @inheritdoc
     */
  /*  public function behaviorsWithoutRbac()
    {
        return [


            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_USER,
                            User::ROLE_MODERATOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        // Allow moderators and admins to update
                        'roles' => [
                            User::ROLE_MODERATOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        // Allow admins to delete
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
  */

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $authItems = AuthItem::find()->where(['type' => 1])->all();

        if ($model->load(Yii::$app->request->post())) {


            $POST_VARIABLE=Yii::$app->request->post('User');

            $password = $POST_VARIABLE['password'];

            $model->setPassword($password);
            $model->generateAuthKey();

            $model->save(false);

          /*  // the following three lines were added:
            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('author');
            $auth->assign($authorRole, $model->getId());
         */

            // lets add the permissions
            $permissionList = $_POST['User']['permissions'];
            if(!empty($permissionList)){

                foreach ($permissionList as $permission)
                {
                    $newPermission = new AuthAssignment;
                    $newPermission->user_id = (string)$model->getId();
                    $newPermission->item_name = $permission;
                    $newPermission->created_at = time();
                    $newPermission->save();

                }
            }


            if($model->save()){
                Yii::$app->session->setFlash('success', 'The user was successfully created.');
            }else{
                Yii::$app->session->setFlash('error', 'There was an error creating the user.');
            }

            return $this->redirect(['index']);


           // return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'authItems'=> $authItems,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $authItems = AuthItem::find()->where(['type' => 1])->all();

        if ($model->load(Yii::$app->request->post())) {


            $POST_VARIABLE=Yii::$app->request->post('User');

            $password = $POST_VARIABLE['password'];

            $model->setPassword($password);
            $model->generateAuthKey();

            $model->save(false);

            // lets add the permissions
            $permissionList = $_POST['User']['permissions'];

            if(!empty($permissionList)){
                foreach ($permissionList as $permission)
                {
                    $newPermission = new AuthAssignment;
                    $newPermission->user_id = (string)$model->getId();
                    $newPermission->item_name = $permission;
                    $newPermission->created_at = time();
                    $newPermission->save();

                }
            }



            if($model->save()){
                Yii::$app->session->setFlash('success', 'The user was successfully updated.');
            }else{
                Yii::$app->session->setFlash('error', 'There was an error updating the user.');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'authItems'=> $authItems,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
