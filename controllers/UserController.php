<?php

namespace app\controllers;
use yii\filters\AccessControl;

class UserController extends \yii\web\Controller
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
                        'actions' => ['predict', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($action = '', $params = '')
    {
        return $this->render('dashboard', compact('action', 'params'));
    }

    public function actionPredict()
    {
        return $this->render('predict');
    }

    public function actionSetBets()
    {

    }

}
