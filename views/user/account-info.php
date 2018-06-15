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
                $wallet = Yii::$app->session->get('userInfo')['wallet'];
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
            <div class="panel-body">
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
                $price = 0;
                echo $price;
                ?> بار
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
</div>
