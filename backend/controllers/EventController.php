<?php

namespace backend\controllers;

use Yii;
use backend\models\Event;
use backend\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
      //  $searchModel = new EventSearch();
      // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $events = Event::find()->all();

        $events_calendar = [];
        foreach ($events as $event)
        {
            $event_calendar = new \yii2fullcalendar\models\Event();
            $event_calendar->id = $event->id;
            // $event_calendar->backgroundColor = 'red';
            $event_calendar->title = $event->title;
            $event_calendar->start = $event->created_date;
            //  $event_calendar->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
            $events_calendar[] = $event_calendar;
        }

        return $this->render('index', [
            'events' => $events_calendar,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date)
    {
        $model = new Event();
        $model->created_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateByTitle($title)
    {

       // $model = Event::findByTitle($title);
       $model = Event::find()->where(['title'=>$title])->one();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Deletes an existing Event model.
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
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL){

      //  \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $times = Event::find()->all();

        $events = array();

        foreach ($times AS $time){
            //Testing
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->id;
            $Event->title = $time->title;
            $Event->start = $time->created_date;
           // $Event->end = $time->end_time;
            $events[] = $Event;
        }

        return json_encode($events);

    }
}
