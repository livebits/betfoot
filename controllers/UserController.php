<?php

namespace app\controllers;
use Yii;
use app\models\UserProfile;
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
        $request = Yii::$app->request;
        $data = $request->post('userPredicts');
        $data = json_decode($data);

        $sumPrices = 0;
        $fixture_ids = [];
        foreach ($data as $predict) {
            $fixture_ids[] = substr($predict->id,0,-1);

            $sumPrices += $predict->data[0];
        }

        $userInfo = UserProfile::find()->where('user_id=' . Yii::$app->user->id)->one();

        if($sumPrices < $userInfo->wallet) {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user?action=charge$params=charge'));
        }

        foreach ($data as $predict) {
            $fixture_ids[] = substr($predict->id,0,-1);
            $type = substr($predict->id,-1);

            $sumPrices += $predict->data[0];
        }

        return $this->render('predict');
    }

    public function actionSetBets()
    {

    }

}
