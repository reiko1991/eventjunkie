<?php

namespace app\controllers;

use app\models\SearchEventForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CreateEventForm;
use yii\data\Pagination;
use app\models\Event;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
 /*       $query = Event::find();

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $eventList = $query->orderBy('start_date')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        $searchModel = new SearchEventForm();

        return $this->render('index', ['searchModel' => $searchModel,
            'eventList' => $eventList,
            'pagination' => $pagination,]); */
	$this->redirect(\Yii::$app->request->BaseUrl.'/index.php?r=event/index');
    }

    public function actionEvent($id)
    {
        $query = Event::findOne($id);

        return $this->render('event', [
            'event' => $query]);
    }

    /*public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
*/
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

/*
    public function actionCreateEvent()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new CreateEventForm();
        $event = new Event();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $event->user_id = Yii::$app->user->id;
            $event->name = $model->name;
            $event->description = $model->description;
            $event->creation_date = time();
            $event->start_date = date('Y-m-d H:i:s', strtotime($model->start_date));
            if ($model->address !== "") {
                $parsed_address = str_replace(" ", "+", $model->address);
                $jsonData = file_get_contents("http://maps.googleapis.com/maps/apis/geocode/json?address=" .
                    $parsed_address . "&sensor=true");
                $data = json_decode($jsonData);
                if ($data->{'status'} != "OK") {
                    Yii::$app->session->setFlash('error', 'Address doesn\'t exist.');
                    return $this->render("createEvent", ["model" => $model]);
                }
                $event->address = $model->address;
                $event->latitude = $data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $event->longitude = $data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            }
            $event->save();
            return $this->render('createEvent-confirm', ['model' => $model]);
        } else {
            return $this->render("createEvent", ["model" => $model]);
        }

    }
*/
}
