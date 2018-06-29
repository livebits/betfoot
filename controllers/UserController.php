<?php

namespace app\controllers;
use app\models\Fixture;
use app\models\Message;
use app\models\Prediction;
use app\models\UserWallet;
use app\models\Withdraw;
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

        if(!isset($userInfo->wallet) || $sumPrices > $userInfo->wallet) {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user?action=charge&params=charge'));
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
            } else if($type == 2){
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


            //dec it from wallet
            $userWallet = new UserWallet();
            $userWallet->user_id = Yii::$app->user->id;
            $userWallet->amount = -$user_price;
            $userWallet->type = UserWallet::$PREDICT;
            $userWallet->comment = '';
            $userWallet->created_at = time();
            $userWallet->save();

            UserProfile::updateUserWallet(-$user_price);

            if(isset($userInfo->reagent_id)){

                $userWallet = new UserWallet();
                $userWallet->user_id = $userInfo->reagent_id;
                $userWallet->amount = floor((20/100) * $user_price);
                $userWallet->type = UserWallet::$AGENT;
                $userWallet->comment = UserWallet::$AGENT . '_' . Yii::$app->user->id;
                $userWallet->created_at = time();
                $userWallet->save();

                $agentProfile = UserProfile::find()
                    ->where('user_id='.$userInfo->reagent_id)
                    ->one();

                if ($agentProfile->wallet){

                    $newAmount = floor($agentProfile->wallet + (20/100) * $user_price);
                } else {
                    $newAmount = floor((20/100) * $user_price);
                }
                UserProfile::updateAll(['wallet' => $newAmount], 'user_id=' . $userInfo->reagent_id);
            }
        }

        return $this->redirect(Yii::$app->getUrlManager()->createUrl('user').'?action=history');
    }

    public function actionMorePredicts()
    {
        $request = Yii::$app->request;
        $data = $request->post('userPredicts');
        $data = json_decode($data);

        $sumPrices = 0;
        $fixture_ids = [];
        foreach ($data as $predict) {
            $fixture_ids[] = explode("_",$predict->id)[0];

            $sumPrices += $predict->data[0];
        }

        $userInfo = UserProfile::find()->where('user_id=' . Yii::$app->user->id)->one();

        if(!isset($userInfo->wallet) || $sumPrices > $userInfo->wallet) {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user?action=charge&params=charge'));
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
            $fixture_id = explode("_",$predict->id)[0];;
//            $type = substr($predict->id,-1);

//            $fixture = Fixture::find()
//                ->with('localTeam')
//                ->with('visitorTeam')
//                ->where('fixture_id=' . $fixture_id)
//                ->one();

//            if($type == 1){
//                $selected_team_id = $fixture->localTeam->team_id;
//            } else if($type == 1){
//                $selected_team_id = $fixture->visitorTeam->team_id;
//            } else {
//                $selected_team_id = 0;
//            }

            $user_price = $predict->data[0];
            $win_price = $predict->data[1];

            $prediction = new Prediction();
            $prediction->user_id = Yii::$app->user->id;
            $prediction->selected_team_id = 0;
            $prediction->fixture_id = $fixture_id;
            $prediction->user_price = $user_price;
            $prediction->win_price = $win_price;
            $prediction->more_desc = $predict->id;
            $prediction->status = 'notCalc';
            $prediction->created_at = time();

            $prediction->save();

            //dec it from wallet
            $userWallet = new UserWallet();
            $userWallet->user_id = Yii::$app->user->id;
            $userWallet->amount = -$user_price;
            $userWallet->type = UserWallet::$PREDICT;
            $userWallet->comment = '';
            $userWallet->created_at = time();
            $userWallet->save();

            UserProfile::updateUserWallet(-$user_price);

            if(isset($userInfo->reagent_id)){

                $userWallet = new UserWallet();
                $userWallet->user_id = $userInfo->reagent_id;
                $userWallet->amount = floor((20/100) * $user_price);
                $userWallet->type = UserWallet::$AGENT;
                $userWallet->comment = UserWallet::$AGENT . '_' . Yii::$app->user->id;
                $userWallet->created_at = time();
                $userWallet->save();

                $agentProfile = UserProfile::find()
                    ->where('user_id='.$userInfo->reagent_id)
                    ->one();

                if ($agentProfile->wallet){

                    $newAmount = floor($agentProfile->wallet + (20/100) * $user_price);
                } else {
                    $newAmount = floor((20/100) * $user_price);
                }
                UserProfile::updateAll(['wallet' => $newAmount], 'user_id=' . $userInfo->reagent_id);
            }
        }

        return $this->redirect(Yii::$app->getUrlManager()->createUrl('user').'?action=history');
    }

    public function actionSendMessage()
    {

        $request = Yii::$app->request;
        $subject = $request->post('subject');
        $message = $request->post('message');

        $new_message = new Message();
        $new_message->user_id = Yii::$app->user->id;
        $new_message->subject = $subject;
        $new_message->message = $message;
        $new_message->created_at = time();

        if($new_message->save()) {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=messages&params=ok'));

        } else {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=message&params=nok'));
        }
    }

    public function actionWithdraw(){

        $request = Yii::$app->request;

        $price = $request->post('price');
        $account_owner = $request->post('account_owner');
        $bank_name = $request->post('bank_name');
        $account_number = $request->post('account_number');
        $card_number = $request->post('card_number');
        $shaba_number = $request->post('shaba_number');

        $withdraw = new Withdraw();
        $withdraw->user_id = Yii::$app->user->id;
        $withdraw->price = $price;
        $withdraw->account_owner = $account_owner;
        $withdraw->account_number = $account_number;
        $withdraw->bank_name = $bank_name;
        $withdraw->card_number = $card_number;
        $withdraw->shaba_number = $shaba_number;

        $withdraw->status = "requested";
        $withdraw->created_at = time();

        if($withdraw->save()) {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=withdraw&params=ok'));

        } else {
            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=withdraw&params=nok'));
        }
    }

    public function actionReplyMessage($mid) {

        if(!isset($mid)){
            return;
        }
        $message = Message::find()->where('id='.$mid)->one();
        $request = Yii::$app->request;

        if($request->isPost) {

            $new_message = new Message();
            $new_message->user_id = Yii::$app->user->id;
            $new_message->parent_id = $mid;
            $new_message->subject = 'پاسخ';
            $new_message->message = $request->post('message');
            $new_message->created_at = time();

            Message::updateAll(['status' => '1'], ['id' => $mid]);

            if($new_message->save()) {
                return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=users-messages&params=ok'));

            }
        }

        $action = 'reply-message';
        $params = $message;
        return $this->render('dashboard', compact('action', 'params'));
    }

}
