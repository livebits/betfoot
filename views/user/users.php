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

        $users = (new \yii\db\Query())
            ->select(['user.*', 'user_profile.*'])
            ->from('user')
            ->leftJoin('user_profile', 'user_profile.user_id = user.id')
//            ->where('isAdmin != 1')
            ->orderBy('user.id DESC');

    $dataProvider = new ActiveDataProvider([
        'query' => $users,
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'username',
                'label' => 'ایمیل',
                'value' => function ($data) {
                    return $data['username'];
                }
            ],
            [
                'label' => 'نام کاربر',
                'value' => function ($data) {
                    return $data['firstName'] . ' ' . $data['lastName'];
                }
            ],
            [
                'label' => 'شماره موبایل',
                'value' => function ($data) {
                    return $data['mobile'];
                }
            ],
            [
                'label' => 'کیف پول (پول)',
                'value' => function ($data) {
                    return isset($data['wallet']) ? number_format($data['wallet']) : 0;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \app\components\Jdf::jdate('Y/m/d', $data['created_at']);
                },
            ],
        ],
    ]);
    ?>

</div>
