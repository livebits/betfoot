<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<style>
    .input-group {
        margin-top: 10px !important;
    }
</style>

<div class="charge-box">

    <?php
    if ($params == "ok") {
        ?>

        <div class="alert alert-success" role="alert">درخواست شما با موفقیت برای مدیر ارسال شد.</div>

        <?php
    } else if ($params == "nok") {
        ?>

        <div class="alert alert-danger" role="alert">مشکلی در ثبت درخواست پیش آمد، لطفا مجددا تلاش بفرمایید.</div>

        <?php
    }
    ?>
    <p>
        حداقل مبلغ قابل برداشت ۵۰,۰۰۰ تومان می باشد.
    </p>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'id'      => 'payment-form',
        'action'  => Yii::$app->getUrlManager()->createUrl('user/withdraw'),
        'validateOnBlur'=>false,
    ]) ?>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2" style="width: 125px;">
            مبلغ به تومان
        </span>
        <input type="number" name="price" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2">
            نام صاحب حساب
        </span>
        <input type="text" name="account_owner" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2" style="width: 125px;">
            نام بانک
        </span>
        <input type="text" name="bank_name" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2" style="width: 125px;">
            شماره حساب
        </span>
        <input type="text" name="account_number" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2" style="width: 125px;">
            شماره کارت
        </span>
        <input type="text" name="card_number" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2" style="width: 125px;">
            شماره شبا
        </span>
        <input type="text" name="shaba_number" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div style="margin: 10px auto; width: 400px;">
        <button type="submit" class="btn btn-block btn-success">ثبت درخواست</button>
    </div>

    <?php ActiveForm::end() ?>

</div>
