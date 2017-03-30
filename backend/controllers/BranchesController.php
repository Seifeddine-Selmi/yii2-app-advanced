<?php

namespace backend\controllers;

use Yii;
use backend\models\Branches;
use backend\models\BranchesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\helpers\Json;
use yii\base\Exception;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

/**
 * BranchesController implements the CRUD actions for Branches model.
 */
class BranchesController extends Controller
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
     * Lists all Branches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BranchesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Used by Kartik Grid
        if (Yii::$app->request->post('hasEditable')) {

            $branchId = Yii::$app->request->post('editableKey');
            $branch = Branches::findOne($branchId);

            $out = Json::encode(['output' => '','message' => '']);
            $post = [];
            $posted = current($_POST['Branches']);
            $post['Branches'] = $posted;

            if ($branch->load($post)) {

                if ($branch->save()) {
                    $output = $branch->branch_name;

                }else {
                    $output = $branch->getErrors();
                }

               $out = Json::encode(['output' => $output,'message' => '']);
            }

            return  $out;

        }





        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Importing Excel Sheet
     * Read Excel file and save into database.
     */
    public function actionImportExcel()
    {
        $inputFile = "uploads/branches_file.xlsx";

        try {
            // Load the excel file
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);
        } catch (Exception $e) {
           // throw new NotFoundHttpException();
            die('Error');
        }

        // Read the excel file and insert data in the database
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();


        for ($row = 1; $row <= $highestRow; $row++) {

            $rowData = $sheet ->rangeToArray('A'.$row. ':' .$highestColumn.$row, NULL, TRUE, FALSE);
            if ($row == 1) {
                continue;
            }

            $branch = new Branches();
            $branch ->branch_id            = $rowData[0][0];
            $branch ->companies_company_id = $rowData[0][1];
            $branch ->branch_name          = $rowData[0][2];
            $branch ->branch_address       = $rowData[0][3];
            $branch ->branch_created_date  = $rowData[0][4];
            $branch ->branch_status        = $rowData[0][5];
            if ($branch->save()) {
                Yii::$app->session->setFlash('success', 'The branch was successfully created.');

            }else {
                return $branch->getErrors();
            }


        }
        return 'Success';
    }

    /**
     * Displays a single Branches model.
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
     * Creates a new Branches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-branch')) {
            $model = new Branches();

            // Validate with enableAjaxValidation is true in _form
            // Remove this if use 'validationUrl' => Url::toRoute('branches/validation') in _form
         /*   if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
            {
                Yii::$app->response->format = 'json';
                return ActiveForm::validate($model);
            }*/

            if ($model->load(Yii::$app->request->post())) {

                $model->branch_created_date = date('Y-m-d h:m:s');

                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if($model->save()){
                        // Yii::$app->session->setFlash('success', 'The branch was successfully created.');
                       //  echo 'Success';
                        return [
                            'message' => 'Success',
                        ];

                    }else{
                        // Yii::$app->session->setFlash('error', 'There was an error creating the branch.');
                         // echo 'Error';
                       return [
                            'message' => 'Error',
                        ];
                    }


               // return $this->redirect(['index']);

            } else {
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new ForbiddenHttpException;
        }

    }

    /*
     * Call this validation funtion if use validationUrl in _form
     */
    public function actionValidation()
    {
        $model = new Branches();
        // Validate with custom rule checkDate
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);

        }else{
            throw new ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Branches model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->branch_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Branches model.
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
     * Finds the Branches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branches::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Creating a Dependent Drop Down Lists
     */
    public function actionLists($id)
    {

        $branches = Branches::find()
            ->where(['companies_company_id' => $id])
            ->all();

        if (!empty($branches)) {
            foreach($branches as $branch){
                echo "<option value='".$branch->branch_id."'>".$branch->branch_name."</option>";
            }
        }
        else{
            echo "<option value='0'>-</option>";
        }

    }

    /*
     * Uploading Multiple Files With DropZone
     *
     */
    public function actionUpload()
    {
        $fileName = 'file';
        $uploadPath = './files';

        if (isset($_FILES[$fileName])) {
            $file = UploadedFile::getInstanceByName($fileName);

            //Print file data
            //print_r($file);

            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                //Now save file data to database
                echo Json::encode($file);
            }
        }else{
            return $this->render('upload');
        }


        return false;
    }
}
