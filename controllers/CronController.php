<?php

namespace app\controllers;

use app\components\SportMonks;
use app\models\Fixture;
use app\models\Odds;
use app\models\Prediction;
use app\models\UserProfile;
use app\models\UserWallet;
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
                $fixtures_ids .= $predictions[$i]->fixture_id;
            } else {

                $fixtures_ids .= $predictions[$i]->fixture_id . ',';
            }
        }

        foreach ($predictions as $prediction) {
            $game = $client->fixtures()->find($prediction->fixture_id);

            $fixture = Fixture::find()->where('fixture_id=' . $prediction->fixture_id)->one();

            if (!$fixture) {
                $fixture = new Fixture();
                $fixture->fixture_id = $game->id;
                $fixture->league_id = $game->league_id;
                $fixture->season_id = $game->season_id;
                $fixture->stage_id = $game->stage_id;
                $fixture->round_id = $game->round_id;
                $fixture->group_id = $game->group_id;
                $fixture->aggregate_id = $game->aggregate_id;
                $fixture->venue_id = $game->venue_id;
                $fixture->referee_id = $game->referee_id;
                $fixture->localteam_id = $game->localteam_id;
                $fixture->visitorteam_id = $game->visitorteam_id;
                $fixture->commentaries = $game->commentaries;

                if (isset($game->formations)) {
                    $fixture->localteam_formation = $game->formations->localteam_formation;
                    $fixture->visitorteam_formation = $game->formations->visitorteam_formation;
                }

                if (isset($game->coaches)) {
                    $fixture->localteam_coach_id = $game->coaches->localteam_coach_id;
                    $fixture->visitorteam_coach_id = $game->coaches->visitorteam_coach_id;
                }

                if (isset($game->standings)) {
                    $fixture->localteam_position = $game->standings->localteam_position;
                    $fixture->visitorteam_position = $game->standings->visitorteam_position;
                }
            }

            $fixture->winning_odds_calculated = $game->winning_odds_calculated == "true" ? 1 : 0;

            if (isset($game->scores)) {
                $fixture->localteam_score = $game->scores->localteam_score . '';
                $fixture->visitorteam_score = $game->scores->visitorteam_score . '';
                $fixture->localteam_pen_score = $game->scores->localteam_pen_score . '';
                $fixture->visitorteam_pen_score = $game->scores->visitorteam_pen_score . '';
                $fixture->ht_score = $game->scores->ht_score;
                $fixture->ft_score = $game->scores->ft_score;
                $fixture->et_score = $game->scores->et_score;
            }

            if (isset($game->time)) {
                $fixture->status = $game->time->status;
                $fixture->minute = $game->time->minute;
                $fixture->second = $game->time->second;
                $fixture->added_time = $game->time->added_time;
                $fixture->extra_minute = $game->time->extra_minute;
                $fixture->injury_time = $game->time->injury_time;

                if (isset($game->time->starting_at)) {
                    $time = strtotime($game->time->starting_at->date_time);
                    $fixture->starting_at = date('Y-m-d H:i:s', $time);
                    $fixture->starting_at_timezone = $game->time->starting_at->timezone;
                    $fixture->starting_at_ts = $game->time->starting_at->timestamp;
                }
            }

            $fixture->deleted = $game->deleted == "true" ? 1 : 0;

            $fixture->save();
        }

        if($fixtures_ids == "") {
            return;
        }

        $fixtures = Fixture::find()
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->andWhere('status="FT"')
            ->andWhere('winning_odds_calculated=1')
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

            if($fixture->status != "FT"){
                continue;
            }

            if($prediction->more_desc == null){
                $selected_team_id = $prediction->selected_team_id;

                $label = "0";
                if($fixture->localteam_id == $selected_team_id){
                    $label = "1";
                } if($fixture->visitorteam_id == $selected_team_id){
                    $label = "2";
                } else {
                    $label = "X";
                }

                $fixture_odds = null;
                foreach ($fixture->odds as $odd) {
                    if($odd->odds_id == 1){
                        $fixture_odds = $odd;
                        break;
                    }
                }

                $winning = false;

                if($fixture_odds) {
                    $bookmaker = json_decode($fixture_odds->bookmaker);
                    $game_odds = $bookmaker->data[0]->odds->data;

                    foreach ($game_odds as $game_odd) {
                        if($game_odd->label == $label) {
                            if($game_odd->winning) {
                                $winning = $game_odd->winning;
                            }
                            break;
                        }
                    }

                    if($winning) {

                        $userWallet = new UserWallet();
                        $userWallet->amount = $prediction->win_price;
                        $userWallet->user_id = $prediction->user_id;
                        $userWallet->comment = "WIN_" . $prediction->id;
                        $userWallet->type = "WIN";
                        $userWallet->created_at = time();

                        $userWallet->save();

                        $myProfile = UserProfile::find()->where('user_id=' . $prediction->user_id)->one();

                        if ($myProfile->wallet){

                            $newAmount = $myProfile->wallet + $prediction->win_price;
                        } else {
                            $newAmount = $prediction->win_price;
                        }

                        UserProfile::updateAll(['wallet' => $newAmount], 'user_id=' . $prediction->user_id);
                    }

                    Prediction::updateAll(['status' => 'Calc', 'updated_at' => time()], 'id=' . $prediction->id);
                }

            }

            else {

                $desc = $prediction->more_desc;
                $odds_id = explode('_', $desc)[1];
                $sub_odds_id = explode('_', $desc)[2];

                $fixture_odds = null;
                foreach ($fixture->odds as $odd) {
                    if($odd->odds_id == $odds_id){
                        $fixture_odds = $odd;
                        break;
                    }
                }

                $winning = false;

                if($fixture_odds) {
                    $bookmaker = json_decode($fixture_odds->bookmaker);
                    $game_odds = $bookmaker->data[0]->odds->data;

                    $game_odd = $game_odds[$sub_odds_id];
                    if($game_odd->winning) {
                        $winning = $game_odd->winning;
                    }

                    if($winning) {

                        $userWallet = new UserWallet();
                        $userWallet->amount = $prediction->win_price;
                        $userWallet->user_id = $prediction->user_id;
                        $userWallet->comment = "WIN_" . $prediction->id;
                        $userWallet->type = "WIN";
                        $userWallet->created_at = time();

                        $userWallet->save();

                        $myProfile = UserProfile::find()->where('user_id=' . $prediction->user_id)->one();

                        if ($myProfile->wallet){

                            $newAmount = $myProfile->wallet + $prediction->win_price;
                        } else {
                            $newAmount = $prediction->win_price;
                        }

                        UserProfile::updateAll(['wallet' => $newAmount], 'user_id=' . $prediction->user_id);
                    }

                    Prediction::updateAll(['status' => 'Calc', 'updated_at' => time()], 'id=' . $prediction->id);
                }

            }

            
        }
    }
}
