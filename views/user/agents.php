<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$myProfile = \app\models\UserProfile::find()
    ->where('user_id=' . Yii::$app->user->id)
    ->one();
?>

<div class="account-box" style="height: 700px;">

    <div class="row">

        <div class="col-md-12">

            <p style="color: white;">
                کسانی که علاقمند هستند به عنوان نماینده سایت فعالیت کنند و کاربران جدیدی را به سایت جذب کنند میتوانند از طرح نمایندگی سایت استفاده کنند. برای استفاده از این طرح شما میتوانید با استفاده از لینک ثبت نام و کد های HTML که برای قرار دادن بنر های سایت در وبسایت های دیگر در نظر گرفته شده است استفاده کنید. هر کاربری که با کلیک بروی این لینک ها در سایت ثبت نام کند زیر مجموعه شما خواهد بود و شما بابت فعایت او در سایت کمیسیون دریافت خواهید کرد.
            </p>

            <h3 style="color: #f7cc00;">نحوه محاسبه کمیسیون نماینده:</h3>
            <ul style="color: white;">
                <li>هر نماینده 20 درصد از سود سایت از هر زیر مجموعه را به عنوان کمیسیون دریافت میکند.</li>
                <li> کمیسیون نماینده بصورت مادام العمر به نماینده پرداخت میشود.</li>
                <li> سایت حق تغییر درصد کمیسیون را در آینده برای خود محفوظ نگه میدارد.</li>
            </ul>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div id="link_box" style="border: 2px dashed rgb(255, 204, 0); width: 55%; margin: 10px auto 30px; padding: 10px;">
                <div style="background:#222;padding:10px;font-size:16px;">
                    <p style="color:#fff;text-align: center;margin-bottom: 10px;">
                        لینک ثبت نام
                    </p>
                    <p style="color:#fff;text-align: center;">
                        <?php echo 'http://afraa.tk/web/user-management/auth/registration?uid=' . $myProfile->reagent_code; ?>
                    </p>
                </div>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">کد معرف من</div>
            <div class="panel-body">
                <?php
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
                } else {
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>

    <div class="row">

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">تعداد کاربران زیر مجموعه</div>
            <div class="panel-body">
                <?php
                $reagent_users = \app\models\UserProfile::find()
                    ->where('reagent_id=' . Yii::$app->user->id)
                    ->count();
                echo $reagent_users;
                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

        <div class="col-md-1"></div>
        <div class="panel panel-default col-md-4">
            <div class="panel-heading text-center">مجموع کمیسیون پرداخت شده</div>
            <div class="panel-body">
                <?php
                $myAgentsCommissions = (new \yii\db\Query())
                    ->select('SUM(amount) as sum')
                    ->from('user_wallet')
                    ->where('user_id=' . Yii::$app->user->id)
                    ->andWhere('type="AGENT"')
                    ->one();

                $myAgentsCommissions = $myAgentsCommissions['sum'];

                $myAgentsCommissionsPrice = $myAgentsCommissions != null ? $myAgentsCommissions : 0;

                echo number_format($myAgentsCommissions);

                ?>
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>
</div>
