<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>
<style>
    table th {
        color: #ffffff;
    }
</style>
<div class="transaction-box">

    <?php

        $transactions = (new \yii\db\Query())
            ->select(['transaction.*', 'user_profile.*'])
            ->from('transaction')
            ->leftJoin('user_profile', 'transaction.user_id = user_profile.user_id')
            ->orderBy('transaction.id DESC');

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
                'label' => 'نام کاربر',
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data['firstName'] . ' ' . $data['lastName'];
                },
            ],
            [
                'label' => 'مقدار (تومان)',
                'attribute' => 'amount',
                'value' => function ($data) {
                    return number_format($data['amount']);
                },
            ],
            [
                'label' => 'وضعیت',
                'attribute' => 'status',
                'value' => function ($data) {
                    if ($data['status'] == "started") {
                        return 'در حال بررسی';

                    } else if ($data['status'] == "ok") {
                        return 'تایید شده';

                    } else if ($data['status'] == "nok") {
                        return 'رد شده';

                    }
                },
            ],
            [
                'label' => 'تاریخ',
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \app\components\Jdf::jdate('Y/m/d', $data['created_at']);
                },
            ],
        ],
    ]);
    ?>

</div>
