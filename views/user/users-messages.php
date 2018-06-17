<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="charge-box">

    <?php

    $messages = \app\models\Message::find()
        ->leftJoin('user_profile', 'message.user_id = user_profile.user_id')
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
