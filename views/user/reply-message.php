<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="charge-box">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => Yii::$app->getUrlManager()->createUrl('/user/reply-message') . '?mid=' . $_GET['mid'],
        'validateOnBlur' => false,
    ]) ?>

    <div class="form-group">
        <div class="input-group" style="margin-top: 10px;">
            <span class="input-group-addon" style="width: 100px;"><label for="amount">متن پیام کاربر</label></span>
            <textarea readonly="readonly" name="message" rows="2" cols="20" id="message" class="form-control"
                      style="height:200px; width:300px">
                <?php
                echo $params->message;
                ?>
            </textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group" style="margin-top: 10px;">
            <span class="input-group-addon" style="width: 100px;"><label for="amount">متن پاسخ</label></span>
            <textarea required name="message" rows="2" cols="20" id="message" class="form-control"
                      style="height:200px; width:300px"></textarea>
        </div>
    </div>

    <div style="width: 400px;margin: 5px auto;">

    <input value="ارسال پیام" class="btn btn-block btn-success" type="submit">
    </div>

    <?php ActiveForm::end() ?>

</div>
