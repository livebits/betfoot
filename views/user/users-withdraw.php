<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="charge-box">

    <?php

    $withdraws = (new \yii\db\Query())
        ->select(['withdraw.*', 'user_profile.firstName as firstName', 'user_profile.lastName as lastName'])
        ->from('withdraw')
        ->leftJoin('user_profile', 'withdraw.user_id = user_profile.user_id')
        ->orderBy('withdraw.id DESC');

    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => $withdraws,
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

    echo ListView::widget( [
        'dataProvider' => $dataProvider,
        'itemView' => 'withdraw_item',
    ] );
    ?>

</div>
