<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="charge-box">

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
