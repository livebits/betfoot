<?php

namespace app\controllers;

use app\components\SportMonks;
use app\models\Prediction;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class CronController extends BaseController
{
    public $freeAccess = true;

    public function actionCalculate(){

        $client = SportMonks::init();

        $predictions = Prediction::find()
                    ->where('status="notCalc"')
                    ->all();

        $fixtures_ids = '';
        $predictions_size = count($predictions);
        for ($i = 0; $i < $predictions_size; $i++) {
            if ($i == $predictions_size - 1) {
                $fixtures_ids .= $predictions[$i]->id;
            } else {

                $fixtures_ids .= $predictions[$i]->id . ',';
            }
        }

        $fixtures = Fixture::find()
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->all();

        foreach ($fixtures as $fixture) {

            try {
                $fixture_odds = $client->fixtures()->oddsByBookmaker($fixture->fixture_id, 2);

                foreach ($fixture_odds as $odds_obj) {

                    $odds = null;
                    foreach ($fixture->odds as $savedOdds) {
                        if ($savedOdds->odds_id == $odds_obj->id) {

                            $odds = $savedOdds;
                            break;
                        }
                    }

                    if (!$odds) {
                        $odds = new Odds();
                        $odds->odds_id = $odds_obj->id;
                        $odds->fixture_id = $fixture->fixture_id;
                        $odds->name = $odds_obj->name;
                    }

                    $odds->bookmaker = json_encode($odds_obj->bookmaker);

                    $odds->save();

                }

            } catch (ClientException $ce) {

            }
        }

        foreach ($predictions as $prediction) {

            $fixture = Fixture::find()
                ->with('odds')
                ->where('fixture_id=' . $prediction->fixture_id)
                ->one();

            
        }
    }
}
