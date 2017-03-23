<?php

namespace backend\controllers;

use Yii;
use backend\models\Companies;
use backend\models\CompaniesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use yii\widgets\ActiveForm;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompaniesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompaniesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Companies model.
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
     * Creates a new Companies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-company')) {
            $model = new Companies();

            // Validate with custom rule checkDate
            if (Yii::$app->request->isAjax && $model->load($_POST))
            {
                Yii::$app->response->format = 'json';
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post())) {

                // get the instance of the upload file
                $imageFile = UploadedFile::getInstance($model, 'imageFile');

                $imageName = $model->company_name;
                if (!empty($imageFile)){
                    $imageFile->saveAs('uploads/' . $imageName . '.' . $imageFile->extension);  // create uploads folder in advanced backend web folder

                    //save the path in the logo column in database
                    $model->company_logo = 'uploads/'. $imageName . '.' . $imageFile->extension;

                }

                $model->company_created_date = date('Y-m-d h:m:s');

                if($model->save()){
                    Yii::$app->session->setFlash('success', 'The company was successfully created.');
                }else{
                    Yii::$app->session->setFlash('error', 'There was an error creating the company.');
                }

                return $this->redirect(['index']);
                //return $this->redirect(['view', 'id' => $model->company_id]);

            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new ForbiddenHttpException;
        }


    }

    /**
     * Updates an existing Companies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // get the instance of the upload file
            $imageFile = UploadedFile::getInstance($model, 'imageFile');

            $imageName = $model->company_name;
            if (!empty($imageFile)){
                $imageFile->saveAs('uploads/' . $imageName . '.' . $imageFile->extension);  // create uploads folder in advanced backend web folder

                //save the path in the logo column in database
                $model->company_logo = 'uploads/'. $imageName . '.' . $imageFile->extension;

            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->company_id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Companies model.
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
     * Finds the Companies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Companies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Companies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
