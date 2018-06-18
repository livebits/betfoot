<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="charge-box">

    <?php

    $messages = (new \yii\db\Query())
        ->select(['message.subject as subject', 'message.message as message', 'message.created_at as created_at',
            'user_profile.firstName as firstName', 'user_profile.lastName as lastName'])
        ->from('message')
        ->leftJoin('user_profile', 'message.user_id = user_profile.user_id')
        ->orderBy('message.id DESC');

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
