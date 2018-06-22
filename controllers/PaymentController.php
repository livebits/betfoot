<?php

namespace app\controllers;
use app\models\Transaction;
use app\models\UserProfile;
use app\models\UserWallet;
use Yii;

class PaymentController extends \yii\web\Controller
{

    public function actionCharge() {

        $request = yii::$app->request;

        $username = $request->post('user_name');
        $amount = $request->post('amount');

        $data = (new \yii\db\Query())
            ->select(['id'])
            ->from('user')
            ->where('username="' . $username . '"')
            ->one();

        if($data) {

            $userWallet = new UserWallet();
            $userWallet->amount = $amount;
            $userWallet->user_id = $data['id'];
            $userWallet->comment = "شارژ حساب";
            $userWallet->type = "1";
            $userWallet->created_at = time();

            $userWallet->save();

            $myProfile = UserProfile::find()
                ->where('user_id=' . $data['id'])
                ->one();

            if ($myProfile->wallet){

                $newAmount = $myProfile->wallet + $amount;
            } else {
                $newAmount = $amount;
            }

            UserProfile::updateAll(['wallet' => $newAmount], 'user_id=' . $data['id']);

            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=user-charge&params=ok'));
        } else {

            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=user-charge&params=nok'));
        }

    }

    public function actionRequest()
    {
        $request = yii::$app->request;
        $amount = $request->post('amount');

        /** @var Zarinpal $zarinpal */
        $zarinpal = \Yii::$app->zarinpal;

        if($zarinpal->request($amount, 'افزایش اعتبار حساب کاربری', Yii::$app->user->username, null)->getStatus() == '100'){

            $authCode = $zarinpal->getAuthority();

            $transaction = new Transaction();
            $transaction->user_id = Yii::$app->user->id;
            $transaction->amount = $amount;
            $transaction->status = "started";
            $transaction->authority = $authCode;
            $transaction->created_at = time();

            $transaction->save();

            return $this->redirect($zarinpal->getRedirectUrl());
        }
    }

    public function actionVerify($Authority, $Status)
    {
        $transaction = Transaction::find()->where('authority=' . $Authority)->one();
        $amount = $transaction->amount;

        //Payment canceled by user
        if($Status != "OK") {
            $this->failure($Authority);

            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=charge&params=nok'));
        }

        /** @var Zarinpal $zarinpal */
        $zarinpal = Yii::$app->zarinpal ;

        if($zarinpal->verify($Authority, $amount)->getStatus() == '100'){
            //User payment successfully verified!
            $this->success($Authority);

            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=charge&params=ok'));
        }
        elseif($zarinpal->getStatus() == '101') {
            //User payment successfuly verified but user try to verified more than one
            $this->success($Authority);

            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=charge&params=ok'));
        }
        else{
            $this->failure($Authority);

            return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/index?action=charge&params=nok'));
        }
    }

    public function success($auth) {

        $transaction = Transaction::find()->where('authority=' . $auth)->one();
        if($transaction) {
            $transaction->status = 'ok';
            $transaction->updated_at = time();
            $transaction->save();

            $userWallet = new UserWallet();
            $userWallet->amount = $transaction->amount;
            $userWallet->user_id = Yii::$app->user->id;
            $userWallet->comment = "شارژ حساب";
            $userWallet->type = "1";
            $userWallet->created_at = time();

            $userWallet->save();

            UserProfile::updateUserWallet($transaction->amount);
        }
    }

    public function failure($auth) {

        $transaction = Transaction::find()->where('authority=' . $auth)->one();
        if($transaction) {
            $transaction->status = 'nok';
            $transaction->updated_at = time();
            $transaction->save();
        }
    }
}
