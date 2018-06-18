<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

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

    <?php

    $messages = \app\models\Message::find()
        ->where('user_id='. Yii::$app->user->id)
        ->orderBy('id DESC');

    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => $messages,
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

    echo ListView::widget( [
        'dataProvider' => $dataProvider,
        'itemView' => 'message_item',
    ] );
    ?>

</div>
