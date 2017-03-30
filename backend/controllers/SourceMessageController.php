<?php

namespace backend\controllers;

use Yii;
use backend\models\SourceMessage;
use backend\models\SourceMessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\Message;

/**
 * SourceMessageController implements the CRUD actions for SourceMessage model.
 */
class SourceMessageController extends Controller
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
     * Lists all SourceMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SourceMessage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'message' => Message::findOne($id)
        ]);
    }

    /**
     * Creates a new SourceMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SourceMessage();

        $message = new Message();

        if ($model->load(Yii::$app->request->post())) {

            $model->category = 'app';
            $model->save(false);

            // Include message form
            if ($message->load(Yii::$app->request->post()))
            {
                $message->id = $model->id;
                $message->save();
            }


            if($model->save()){
                Yii::$app->session->setFlash('success', 'The message was successfully created.');
            }else{
                Yii::$app->session->setFlash('error', 'There was an error creating the message.');
            }

            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'message' => $message,
            ]);
        }
    }

    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $message = Message::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            // Include message form
            if ($message->load(Yii::$app->request->post()))
            {
                $message->save();
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', 'The message was successfully updated.');
            }else{
                Yii::$app->session->setFlash('error', 'There was an error updating the message.');
            }

            return $this->redirect(['index']);

        } else {
            return $this->render('update', [
                'model' => $model,
                'message' => $message,
            ]);
        }
    }

    /**
     * Deletes an existing SourceMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $messages = $model->messages;

        if (!empty($messages)){
            foreach ($messages as $msg)
            {
                $msg->delete();
            }
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'The message was deleted successfully.');
        }else{
            Yii::$app->session->setFlash('error', 'There was an error deleting the message.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SourceMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
