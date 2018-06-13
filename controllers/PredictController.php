<?php

namespace app\controllers;
use yii\filters\AccessControl;

class PredictController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'predict', 'set-bets'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['predict'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPredict()
    {
        return $this->render('predict');
    }

    public function actionSetBets()
    {

    }

}
