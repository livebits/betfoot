<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<div class="transaction-box">

    <?php

        $transactions = \app\models\Transaction::find()
            ->where('user_id='. Yii::$app->user->id)
            ->orderBy('id DESC');

    $dataProvider = new ActiveDataProvider([
        'query' => $transactions,
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'amount',
                'value' => function ($data) {
                    return number_format($data->amount);
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    if ($data->status == "started") {
                        return 'در حال بررسی';

                    } else if ($data->status == "ok") {
                        return 'تایید شده';

                    } else if ($data->status == "nok") {
                        return 'رد شده';

                    }
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \app\components\Jdf::jdate('Y/m/d', $data->created_at);
                },
            ],
        ],
    ]);
    ?>

</div>
