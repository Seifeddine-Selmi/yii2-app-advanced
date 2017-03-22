<?php

namespace backend\controllers;

use Yii;
use backend\models\Email;
use backend\models\EmailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EmailController implements the CRUD actions for Email model.
 */
class EmailController extends Controller
{
    public $email;
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
     * Lists all Email models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Email model.
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
     * Creates a new Email model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Email();

        if ($model->load(Yii::$app->request->post())) {

            // upload the attachment
            $model->attachment = UploadedFile::getInstance($model, 'attachment');

            if ( $model->attachment )
            {
                $time = time();
                $model->attachment->saveAs('attachments/' .$time. '.' . $model->attachment->extension);
                $model->attachment='attachments/' .$time. '.' . $model->attachment->extension;
            }
            if( $model->attachment )
            {
                $send = Yii::$app->mailer->compose()
                    ->setFrom([$model->email => $model->name])
                    ->setTo($model->email)
                    ->setSubject($model->subject)
                    ->setHtmlBody($model->content )
                    ->attach($model->attachment)
                    ->send();

            }else
            {
                $send = Yii::$app->mailer->compose()
                    ->setFrom([$model->email => $model->name])
                    ->setTo($model->email)
                    ->setSubject($model->subject)
                    ->setHtmlBody($model->content)
                    ->send();
            }

            $model->save();

            if($send){
                Yii::$app->session->setFlash('success', 'Your email was sent successfully.');
            }else{
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->redirect(['index']);
            // return $this->refresh();
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Email model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Email model.
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
     * Finds the Email model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Email the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Email::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
