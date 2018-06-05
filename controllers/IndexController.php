<?php

namespace app\controllers;

use app\models\Bookmaker;
use app\models\Continent;
use app\models\Country;
use app\models\Fixture;
use app\models\League;
use app\models\LiveScore;
use app\models\Odds;
use app\models\Team;
use Yii;
use SportMonks\API\HTTPClient as SportMonksAPI;
use SportMonks\API\Utilities\Auth;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // Default values. Can be initialized without arguments.
        $scheme = 'https';
        $hostname = 'sportmonks.com';
        $subDomain = 'soccer';
        $port = 443;

        // Auth.
        $token = Yii::$app->params['betfoot_token'];

        $client = new SportMonksAPI();
        // or
        //$client = new SportMonksAPI($scheme, $hostname, $subDomain, $port);

        // Set auth.
        $client->setAuth(Auth::BASIC, [
            'token' => $token
        ]);


//        do {
        $date = new \DateTime('now');
        $games = $client->fixtures()->date()->day($date);
//            $games = $client->teams()->find($games[0]->visitorteam_id, true);
        $id = $games[1]->id;
        $games = $client->fixtures()->odds($id);

        foreach ($games as $game) {

            $odds_obj = new Odds();
            $odds_obj->odds_id = $game->id;
            $odds_obj->fixture_id = $id;
            $odds_obj->name = $game->name;
            $odds_obj->bookmaker = json_encode($game->bookmaker);

//                var_export($odds_obj);die();
//                $odds_obj->save();

//                var_export($live_score_obj);die();
//                $live_score_obj->save();
        }


//        } while ($client->leagues()->nextPage());

        return $this->render('index');
    }

    public function actionToday()
    {

        // Auth.
        $token = Yii::$app->params['betfoot_token'];

        $client = new SportMonksAPI();
        // or
        //$client = new SportMonksAPI($scheme, $hostname, $subDomain, $port);

        // Set auth.
        $client->setAuth(Auth::BASIC, [
            'token' => $token
        ]);

        $date = new \DateTime('now');
        $games = $client->fixtures()->date()->day($date, [
            'query' => [
                'include' => 'odds'
            ]
        ]);

        foreach ($games as $game) {

            $fixture = Fixture::find()->where('fixture_id=' . $game->id)->one();

            if (!$fixture) {
                $fixture = new Fixture();
            }

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
            $fixture->winning_odds_calculated = $game->winning_odds_calculated == "true" ? 1 : 0;

            if (isset($game->formations)) {
                $fixture->localteam_formation = $game->formations->localteam_formation;
                $fixture->visitorteam_formation = $game->formations->visitorteam_formation;
            }

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

            if (isset($game->coaches)) {
                $fixture->localteam_coach_id = $game->coaches->localteam_coach_id;
                $fixture->visitorteam_coach_id = $game->coaches->visitorteam_coach_id;
            }

            if (isset($game->standings)) {
                $fixture->localteam_position = $game->standings->localteam_position;
                $fixture->visitorteam_position = $game->standings->visitorteam_position;
            }

            $fixture->deleted = $game->deleted == "true" ? 1 : 0;

            $fixture->save();

            //Add fixture odds
            $odds_objects = $game->odds->data;
            foreach ($odds_objects as $odds_obj){

                $odds = Odds::find()
                    ->where('odds_id='.$odds_obj->id)
                    ->andWhere('fixture_id='.$fixture->fixture_id)
                    ->one();

                if(!$odds){
                    $odds = new Odds();
                }

                $odds->odds_id = $odds_obj->id;
                $odds->fixture_id = $fixture->fixture_id;
                $odds->name = $odds_obj->name;
                $odds->bookmaker = json_encode($odds_obj->bookmaker);

                $odds->save();
            }
        }
    }

    public function actionShow(){

        // Auth.
        $token = Yii::$app->params['betfoot_token'];

        $client = new SportMonksAPI();
        // or
        //$client = new SportMonksAPI($scheme, $hostname, $subDomain, $port);

        // Set auth.
        $client->setAuth(Auth::BASIC, [
            'token' => $token
        ]);

        $fixtures = Fixture::find()
            ->with('localTeam')
            ->with('visitorTeam')
            ->all();

//        foreach ($fixtures as $fixture){
//            if ($fixture->localTeam == null){
//
//                $team_obj = $client->teams()->find($fixture->localteam_id);
//
//                $team = new Team();
//                $team->team_id = $team_obj->id;
//                $team->legacy_id = $team_obj->legacy_id;
//                $team->name = $team_obj->name;
//                $team->short_code = $team_obj->short_code;
//                $team->twitter = isset($team_obj->twitter);
//                $team->country_id = $team_obj->country_id;
//                $team->national_team = $team_obj->national_team == "true" ? 1 : 0;
//                $team->founded = $team_obj->founded;
//                $team->logo_path = $team_obj->logo_path;
//                $team->venue_id = $team_obj->venue_id;
//
//                $team->save();
//
//                $fixture->localTeam = $team;
//            }
//        }

        return $this->render('index', compact('fixtures'));
    }
}
