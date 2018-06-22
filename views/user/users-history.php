<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>

<div class="transaction-box">

    <?php

        $predictions = \app\models\Prediction::find()
            ->with('fixture')
            ->leftJoin('user_profile', 'prediction.user_id = user_profile.user_id')
            ->orderBy('id DESC');

    $dataProvider = new ActiveDataProvider([
        'query' => $predictions,
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
                'value' => function ($model) {
                    $profile = \app\models\UserProfile::find()->where('user_id='.$model->user_id)->one();
                    return $profile->firstName . ' ' . $profile->lastName;
                }
            ],
            [
                'label' => '',
                'value' => function ($model) {
                    $visitor_team = \app\models\Team::find()->where('team_id='.$model->fixture->visitorteam_id)->one();
                    $local_team = \app\models\Team::find()->where('team_id='.$model->fixture->localteam_id)->one();

                    $text = 'میزبان: ' . $local_team->name;
                    $text .= "\r\n" . 'مهمان: ' . $visitor_team->name;

                    return $text;
                }
            ],
            [
                'attribute' => 'selected_team_id',
                'value' => function ($data) {

                    if($data->more_desc == "") {
                        if ($data->fixture->localteam_id == $data->selected_team_id) {
                            return 'برد میزبان';

                        } else if ($data->fixture->visitorteam_id == $data->selected_team_id) {
                            return 'برد مهمان';

                        } else {
                            return 'مساوی';
                        }
                    } else {
                        $more_desc = $data->more_desc;
                        $fixture_id = explode("_", $more_desc)[0];
                        $odds_id = explode("_", $more_desc)[1];
                        $odds_index = explode("_", $more_desc)[2];

                        $odds = \app\models\Odds::find()
                            ->where('fixture_id='.$fixture_id . ' AND odds_id=' . $odds_id)
                            ->one();

                        return $odds->name;
                    }
                }
            ],
            [
                'attribute' => 'user_price',
                'value' => function ($data) {
                    return number_format($data->user_price);
                },
            ],
            [
                'attribute' => 'win_price',
                'value' => function ($data) {
                    return number_format($data->win_price);
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    if ($data->status == "notCalc") {
                        return 'محاسبه نشده';

                    } else if ($data->status == "Calc") {
                        return 'محاسبه شده';

                    }
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return \app\components\Jdf::jdate('Y/m/d H:i:s', $data->created_at);
                },
            ],
        ],
    ]);
    ?>

</div>
