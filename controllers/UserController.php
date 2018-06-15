<?php

namespace app\controllers;
use app\models\Fixture;
use app\models\Prediction;
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

        $fixtures_ids = "";
        for ($i=0; $i < count($fixture_ids); $i++) {
            if($i == count($fixture_ids) - 1){
                $fixtures_ids .= $fixture_ids[$i];
            } else {

                $fixtures_ids .= $fixture_ids[$i] . ',';
            }
        }

        foreach ($data as $predict) {
            $fixture_id = substr($predict->id,0,-1);
            $type = substr($predict->id,-1);

            $fixture = Fixture::find()
                ->with('localTeam')
                ->with('visitorTeam')
                ->where('fixture_id=' . $fixture_id)
                ->one();

            if($type == 1){
                $selected_team_id = $fixture->localTeam->team_id;
            } else if($type == 1){
                $selected_team_id = $fixture->visitorTeam->team_id;
            } else {
                $selected_team_id = 0;
            }

            $user_price = $predict->data[0];
            $win_price = $predict->data[1];

            $prediction = new Prediction();
            $prediction->user_id = Yii::$app->user->id;
            $prediction->selected_team_id = $selected_team_id;
            $prediction->fixture_id = $fixture_id;
            $prediction->user_price = $user_price;
            $prediction->win_price = $win_price;
            $prediction->status = 'notCalc';
            $prediction->created_at = time();

            $prediction->save();
        }

        return $this->redirect(Yii::$app->getUrlManager()->createUrl('user').'?action=history');
    }

    public function actionSetBets()
    {

    }

}
