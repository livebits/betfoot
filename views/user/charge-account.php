<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="charge-box">

    <?php
        if ($params == "ok") {
            ?>

            <div class="alert alert-success" role="alert">پرداخت شما با موفقیت انجام شد و به شارژ شما افزوده شد.</div>

            <?php
        } else if ($params == "nok") {
            ?>

            <div class="alert alert-danger" role="alert">پرداخت با خطا رو به رو شد، لطفا مجددا تلاش بفرمایید.</div>

            <?php
        } else if ($params == "charge") {
            ?>

            <div class="alert alert-danger" role="alert">اعتبار کیف پول کافی نیست، ابتدا حساب خود را شارژ کنید. </div>

            <?php
        }
    ?>
    <p>
        برای شارژ حساب مبلغ مورد نظر خود را در فرم زیر وارد کنید و کلید پرداخت را بزنید.
    </p>

    <?php $form = ActiveForm::begin([
        'action' => '/payment/request',
        'method' => 'post',
        'id'      => 'payment-form',
        'action'  => Yii::$app->getUrlManager()->createUrl('payment/request'),
        'validateOnBlur'=>false,
    ]) ?>

    <div class="input-group">
        <span class="input-group-addon" id="sizing-addon2">
            مبلغ به تومان
        </span>
        <input type="number" name="amount" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div style="margin: 10px auto; width: 400px;">
        <button type="submit" class="btn btn-block btn-success">شارژ حساب</button>
    </div>

    <?php ActiveForm::end() ?>

</div>
