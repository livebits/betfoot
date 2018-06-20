<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="account-box" >

    <div class="row">

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">موجودی حساب</div>
            <div class="panel-body">
                <?php
                $myProfile = \app\models\UserProfile::find()
                    ->where('user_id=' . Yii::$app->user->id)
                    ->one();
                $wallet = $myProfile->wallet;
                if(!$wallet){
                    $wallet = 0;
                }
                echo number_format($wallet);
                ?>  تومان
            </div>
        </div>
        <div class="col-md-1"></div>

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">شناسه کاربری</div>
            <div class="panel-body" style="word-wrap: break-word;">
                <?php
                    echo Yii::$app->user->username;
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>

    <div class="row">

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">تعداد پیش بینی ها</div>
            <div class="panel-body">
                <?php
                $predictions = \app\models\Prediction::find()
                    ->where('user_id=' . Yii::$app->user->id)
                    ->count();

                echo $predictions;
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">مجموع پیش بینی ها</div>
            <div class="panel-body">

                <?php
                $predictions = \app\models\Prediction::find()
                    ->select('SUM(user_price) as sum')
                    ->where('user_id=' . Yii::$app->user->id)
                    ->asArray()
                    ->all();

                echo $predictions[0]['sum'];
                ?>
                تومان

            </div>
        </div>
        <div class="col-md-1"></div>

    </div>

    <div class="row">

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">مجموع برداشت ها</div>
            <div class="panel-body">
                <?php
                $price = 0;
                echo number_format($price);
                ?> تومان
            </div>
        </div>
        <div class="col-md-1"></div>

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">مجموع واریز ها</div>
            <div class="panel-body">
                <?php
                $price = 0;
                echo number_format($price);
                ?> تومان
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>


    <div class="row">

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">کد معرف من</div>
            <div class="panel-body">
                <?php
                $myProfile = \app\models\UserProfile::find()
                    ->where('user_id=' . Yii::$app->user->id)
                    ->one();
                $reagent_code = $myProfile->reagent_code;
                if(!$reagent_code){
                    $reagent_code = Yii::$app->user->id + 30000;

                    \app\models\UserProfile::updateAll(['reagent_code' => $reagent_code], ['user_id' => Yii::$app->user->id]);
                }
                echo $reagent_code;
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center"> معرف من</div>
            <div class="panel-body">
                <?php
                $myProfile = \app\models\UserProfile::find()
                    ->where('user_id=' . Yii::$app->user->id)
                    ->one();
                $reagent_user = $myProfile->reagent_id;
                if($reagent_user){
                    $reagentProfile = \app\models\UserProfile::find()
                        ->where('user_id=' . $reagent_user)
                        ->one();

                    echo $reagentProfile->firstName . ' ' . $reagentProfile->lastName;
                }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>
</div>
