<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="charge-box">


    <?php
    if ($params == "ok") {
        ?>

        <div class="alert alert-success" role="alert">پیام شما با موفقیت برای مدیریت ارسال شد.</div>

        <?php
    } else if ($params == "nok") {
        ?>

        <div class="alert alert-danger" role="alert">اشکالی در ارسال پیام پیش آمد، لطفا مجددا تلاش کنید.</div>

        <?php
    }
    ?>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => Yii::$app->getUrlManager()->createUrl('/user/send-message'),
        'validateOnBlur' => false,
    ]) ?>

    <div class="form-group">
        <div class="input-group" style="margin-top: 10px;">
            <span class="input-group-addon"  style="width: 100px;"><label for="amount">موضوع پیام</label></span>
            <input required style="width: 300px;" name="subject" id="subject" class="form-control" type="text">
        </div>
    </div>

    <div class="form-group">
        <div class="input-group" style="margin-top: 10px;">
            <span class="input-group-addon" style="width: 100px;"><label for="amount">متن پیام</label></span>
            <textarea required name="message" rows="2" cols="20" id="message" class="form-control"
                      style="height:200px; width:300px"></textarea>
        </div>
    </div>

    <div style="width: 400px;margin: 5px auto;">

    <input value="ارسال پیام" class="btn btn-block btn-success" type="submit">
    </div>

    <?php ActiveForm::end() ?>

</div>
