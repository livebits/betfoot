<?php

namespace app\controllers;

use app\components\SportMonks;
use app\models\Bookmaker;
use app\models\Continent;
use app\models\Country;
use app\models\Fixture;
use app\models\League;
use app\models\LiveScore;
use app\models\Odds;
use app\models\Team;
use GuzzleHttp\Exception\ClientException;
use Yii;
use SportMonks\API\HTTPClient as SportMonksAPI;
use SportMonks\API\Utilities\Auth;

class IndexController extends \yii\web\Controller
{

    public function actionMatchList($date)
    {

//        $date = yii::$app->request->get('date');

        $client = SportMonks::init();

        $date = new \DateTime($date);

        $games = $client->fixtures()->date()->day($date);

        $fixtures_ids = '';
        $games_size = count($games);
        for ($i = 0; $i < $games_size; $i++) {
            if ($i == $games_size - 1) {
                $fixtures_ids .= $games[$i]->id;
            } else {

                $fixtures_ids .= $games[$i]->id . ',';
            }
        }

        if ($fixtures_ids == "") {
            return $this->Show($date);
        }

        $fixtures = Fixture::find()
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->all();

        foreach ($games as $game) {

            $fixture = null;
            foreach ($fixtures as $fixture_item) {
                if ($fixture_item->fixture_id == $game->id) {
                    $fixture = $fixture_item;
                    break;
                }
            }

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

        return $this->Show($date);
    }

    public function Show($date)
    {

        $date = $date->format('Y-m-d');
        $start_day = strtotime($date . ' 00:00:00');
        $end_day = strtotime($date . ' 23:59:59');

        $client = SportMonks::init();

        $fixtures = Fixture::find()
            ->with('localTeam')
            ->with('visitorTeam')
            ->with('odds')
            ->where('starting_at_ts BETWEEN ' . $start_day . ' AND ' . $end_day)
            ->andWhere('fixture.status = "NS"')
            ->orderBy('fixture.league_id')
            ->all();

        foreach ($fixtures as $fixture) {

            if (!isset($fixture->localTeam)) {
                try {
                    $team = $client->teams()->find($fixture->localteam_id);

                    $my_team = new Team();
                    $my_team->team_id = $team->id;
                    $my_team->legacy_id = $team->legacy_id;
                    $my_team->name = $team->name;
                    $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                    $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                    $my_team->country_id = $team->country_id;
                    $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                    $my_team->founded = $team->founded;
                    $my_team->logo_path = $team->logo_path;
                    $my_team->venue_id = $team->venue_id;

                    $my_team->save();
                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->visitorTeam)) {
                try {
                    $team = $client->teams()->find($fixture->visitorteam_id);

                    $my_team = new Team();
                    $my_team->team_id = $team->id;
                    $my_team->legacy_id = $team->legacy_id;
                    $my_team->name = $team->name;
                    $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                    $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                    $my_team->country_id = $team->country_id;
                    $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                    $my_team->founded = $team->founded;
                    $my_team->logo_path = $team->logo_path;
                    $my_team->venue_id = $team->venue_id;

                    $my_team->save();
                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->league)) {
                try {
                    $league = $client->leagues()->find($fixture->league_id);

                    $my_league = new League();
                    $my_league->league_id = $league->id;
                    $my_league->legacy_id = $league->legacy_id;
                    $my_league->country_id = $league->country_id;
                    $my_league->name = $league->name;
                    $my_league->is_cup = $league->is_cup == 'true' ? 1 : 0;
                    $my_league->current_season_id = $league->current_season_id;
                    $my_league->current_round_id = $league->current_round_id;
                    $my_league->current_stage_id = $league->current_stage_id;
                    $my_league->live_standings = $league->live_standings == "true" ? 1 : 0;

                    if (isset($league->coverage)) {
                        $my_league->topscorer_goals = $league->coverage->topscorer_goals == "true" ? 1 : 0;
                        $my_league->topscorer_assists = $league->coverage->topscorer_assists == "true" ? 1 : 0;
                        $my_league->topscorer_cards = $league->coverage->topscorer_cards == "true" ? 1 : 0;
                    }

                    $my_league->save();

                } catch (ClientException $ce) {

                }

            }

//            if(!isset($fixture->odds) || (isset($fixture->odds) && count($fixture->odds) == 0)) {
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

//            }
        }

        $is_inplay = false;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('index_partial', compact('fixtures', 'date', 'is_inplay'));

        } else {
            return $this->render('index', compact('fixtures', 'date', 'is_inplay'));
        }
    }

    public function actionInplay()
    {

        $client = SportMonks::init();
        $games = $client->liveScores()->inPlay();

        $fixtures_ids = '';
        $games_size = count($games);
        for ($i = 0; $i < $games_size; $i++) {
            if ($i == $games_size - 1) {
                $fixtures_ids .= $games[$i]->id;
            } else {

                $fixtures_ids .= $games[$i]->id . ',';
            }
        }

//                $fixtures_ids = '10320412,10300974,9039918,10300976,10300978,10300980,10325823,10325825,10303562,9947466,9947468,9947470,10303571,10303573,8773524,10331318,10303928,10303930,10303931,10333142,9039575,9039576,9637388,10318050,10318052,10318053,10318054,10286566,9637386,9637387,9637389,10303561,9853515,10303568,10303569,10334224,9903161,9903162,10331194,9903163,9903164,10331196,9903165,10331345,5111561,5111565,10302748,4794142,4794145,10304040,10304042,10331211,10331212,10331213,9947469,10331214,8636011,5111673,10331319,10331320,10331321,9039577,10318047,10328564,10328566,10328568,10328569';

        if ($fixtures_ids == "") {

            $is_inplay = true;
            $fixtures = [];
            return $this->render('index', compact('fixtures', 'is_inplay'));
        }

        $fixtures = Fixture::find()
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->all();

        foreach ($games as $game) {

            $fixture = null;
            foreach ($fixtures as $fixture_item) {
                if ($fixture_item->fixture_id == $game->id) {
                    $fixture = $fixture_item;
                    break;
                }
            }

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


        $fixtures = Fixture::find()
            ->with('localTeam')
            ->with('visitorTeam')
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->andWhere('fixture.status IN ("LIVE","HT","HT_PEN","FT_PEN","ET")')
            ->orderBy('fixture.league_id')
            ->all();

        foreach ($fixtures as $fixture) {

            if (!isset($fixture->localTeam)) {
                try {
                    $team = $client->teams()->find($fixture->localteam_id);

                    $my_team = new Team();
                    $my_team->team_id = $team->id;
                    $my_team->legacy_id = $team->legacy_id;
                    $my_team->name = $team->name;
                    $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                    $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                    $my_team->country_id = $team->country_id;
                    $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                    $my_team->founded = $team->founded;
                    $my_team->logo_path = $team->logo_path;
                    $my_team->venue_id = $team->venue_id;

                    $my_team->save();
                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->visitorTeam)) {
                try {
                    $team = $client->teams()->find($fixture->visitorteam_id);

                    $my_team = new Team();
                    $my_team->team_id = $team->id;
                    $my_team->legacy_id = $team->legacy_id;
                    $my_team->name = $team->name;
                    $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                    $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                    $my_team->country_id = $team->country_id;
                    $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                    $my_team->founded = $team->founded;
                    $my_team->logo_path = $team->logo_path;
                    $my_team->venue_id = $team->venue_id;

                    $my_team->save();
                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->league)) {
                try {
                    $league = $client->leagues()->find($fixture->league_id);

                    $my_league = new League();
                    $my_league->league_id = $league->id;
                    $my_league->legacy_id = $league->legacy_id;
                    $my_league->country_id = $league->country_id;
                    $my_league->name = $league->name;
                    $my_league->is_cup = $league->is_cup == 'true' ? 1 : 0;
                    $my_league->current_season_id = $league->current_season_id;
                    $my_league->current_round_id = $league->current_round_id;
                    $my_league->current_stage_id = $league->current_stage_id;
                    $my_league->live_standings = $league->live_standings == "true" ? 1 : 0;

                    if (isset($league->coverage)) {
                        $my_league->topscorer_goals = $league->coverage->topscorer_goals == "true" ? 1 : 0;
                        $my_league->topscorer_assists = $league->coverage->topscorer_assists == "true" ? 1 : 0;
                        $my_league->topscorer_cards = $league->coverage->topscorer_cards == "true" ? 1 : 0;
                    }

                    $my_league->save();

                } catch (ClientException $ce) {

                }

            }
//            if(!isset($fixture->odds) || (isset($fixture->odds) && count($fixture->odds) == 0)) {
            try {
//                $fixture_odds = $client->fixtures()->oddsInPlay($fixture->fixture_id);
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

//            }
        }

        if(Yii::$app->request->isAjax){
            $is_inplay = true;
            return $this->renderAjax('index_partial', compact('fixtures', 'is_inplay'));

        } else {

            $is_inplay = true;
            return $this->render('index', compact('fixtures', 'is_inplay'));
        }
    }

    public function actionInplay2()
    {

        $client = SportMonks::init();
//        $games = $client->liveScores()->inPlay();
//
//        $fixtures_ids = '';
//        $games_size = count($games);
//        for ($i=0; $i < $games_size; $i++) {
//            if($i == $games_size - 1){
//                $fixtures_ids .= $games[$i]->id;
//            } else {
//
//                $fixtures_ids .= $games[$i]->id . ',';
//            }
//        }
//        if ($fixtures_ids == ""){
//            die('no');
//        }
        $fixtures_ids = "9566499,10327959,8938349,8938351,8938353,9117063,10327960,8938411,8938413,8938415,8938417,9566501,9566502,9548233";


        $fixtures = Fixture::find()
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->all();

//        foreach ($games as $game) {
//
//            $fixture = null;
//            foreach ($fixtures as $fixture_item){
//                if($fixture_item->fixture_id == $game->id){
//                    $fixture = $fixture_item;
//                    break;
//                }
//            }
//
//            if (!$fixture) {
//                $fixture = new Fixture();
//                $fixture->fixture_id = $game->id;
//                $fixture->league_id = $game->league_id;
//                $fixture->season_id = $game->season_id;
//                $fixture->stage_id = $game->stage_id;
//                $fixture->round_id = $game->round_id;
//                $fixture->group_id = $game->group_id;
//                $fixture->aggregate_id = $game->aggregate_id;
//                $fixture->venue_id = $game->venue_id;
//                $fixture->referee_id = $game->referee_id;
//                $fixture->localteam_id = $game->localteam_id;
//                $fixture->visitorteam_id = $game->visitorteam_id;
//                $fixture->commentaries = $game->commentaries;
//
//                if (isset($game->formations)) {
//                    $fixture->localteam_formation = $game->formations->localteam_formation;
//                    $fixture->visitorteam_formation = $game->formations->visitorteam_formation;
//                }
//
//                if (isset($game->coaches)) {
//                    $fixture->localteam_coach_id = $game->coaches->localteam_coach_id;
//                    $fixture->visitorteam_coach_id = $game->coaches->visitorteam_coach_id;
//                }
//
//                if (isset($game->standings)) {
//                    $fixture->localteam_position = $game->standings->localteam_position;
//                    $fixture->visitorteam_position = $game->standings->visitorteam_position;
//                }
//            }
//
//            $fixture->winning_odds_calculated = $game->winning_odds_calculated == "true" ? 1 : 0;
//
//            if (isset($game->scores)) {
//                $fixture->localteam_score = $game->scores->localteam_score . '';
//                $fixture->visitorteam_score = $game->scores->visitorteam_score . '';
//                $fixture->localteam_pen_score = $game->scores->localteam_pen_score . '';
//                $fixture->visitorteam_pen_score = $game->scores->visitorteam_pen_score . '';
//                $fixture->ht_score = $game->scores->ht_score;
//                $fixture->ft_score = $game->scores->ft_score;
//                $fixture->et_score = $game->scores->et_score;
//            }
//
//            if (isset($game->time)) {
//                $fixture->status = $game->time->status;
//                $fixture->minute = $game->time->minute;
//                $fixture->second = $game->time->second;
//                $fixture->added_time = $game->time->added_time;
//                $fixture->extra_minute = $game->time->extra_minute;
//                $fixture->injury_time = $game->time->injury_time;
//
//                if (isset($game->time->starting_at)) {
//                    $time = strtotime($game->time->starting_at->date_time);
//                    $fixture->starting_at = date('Y-m-d H:i:s', $time);
//                    $fixture->starting_at_timezone = $game->time->starting_at->timezone;
//                    $fixture->starting_at_ts = $game->time->starting_at->timestamp;
//                }
//            }
//
//            $fixture->deleted = $game->deleted == "true" ? 1 : 0;
//
//            $fixture->save();
//        }


        $fixtures = Fixture::find()
            ->with('localTeam')
            ->with('visitorTeam')
            ->with('odds')
            ->where('fixture_id IN (' . $fixtures_ids . ')')
            ->andWhere('fixture.status IN ("LIVE","HT","HT_PEN","FT_PEN","ET")')
            ->orderBy('fixture.league_id')
            ->all();

        foreach ($fixtures as $fixture) {

            if (!isset($fixture->localTeam)) {
                try {
                    $team = $client->teams()->find($fixture->localteam_id);

                    $my_team = new Team();
                    $my_team->team_id = $team->id;
                    $my_team->legacy_id = $team->legacy_id;
                    $my_team->name = $team->name;
                    $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                    $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                    $my_team->country_id = $team->country_id;
                    $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                    $my_team->founded = $team->founded;
                    $my_team->logo_path = $team->logo_path;
                    $my_team->venue_id = $team->venue_id;

                    $my_team->save();
                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->visitorTeam)) {
                try {
                    $team = $client->teams()->find($fixture->visitorteam_id);

                    $my_team = new Team();
                    $my_team->team_id = $team->id;
                    $my_team->legacy_id = $team->legacy_id;
                    $my_team->name = $team->name;
                    $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                    $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                    $my_team->country_id = $team->country_id;
                    $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                    $my_team->founded = $team->founded;
                    $my_team->logo_path = $team->logo_path;
                    $my_team->venue_id = $team->venue_id;

                    $my_team->save();
                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->league)) {
                try {
                    $league = $client->leagues()->find($fixture->league_id);

                    $my_league = new League();
                    $my_league->league_id = $league->id;
                    $my_league->legacy_id = $league->legacy_id;
                    $my_league->country_id = $league->country_id;
                    $my_league->name = $league->name;
                    $my_league->is_cup = $league->is_cup == 'true' ? 1 : 0;
                    $my_league->current_season_id = $league->current_season_id;
                    $my_league->current_round_id = $league->current_round_id;
                    $my_league->current_stage_id = $league->current_stage_id;
                    $my_league->live_standings = $league->live_standings == "true" ? 1 : 0;

                    if (isset($league->coverage)) {
                        $my_league->topscorer_goals = $league->coverage->topscorer_goals == "true" ? 1 : 0;
                        $my_league->topscorer_assists = $league->coverage->topscorer_assists == "true" ? 1 : 0;
                        $my_league->topscorer_cards = $league->coverage->topscorer_cards == "true" ? 1 : 0;
                    }

                    $my_league->save();

                } catch (ClientException $ce) {

                }

            }

            if (!isset($fixture->odds) || (isset($fixture->odds) && count($fixture->odds) == 0)) {
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
        }

        $is_inplay = true;
        return $this->render('index', compact('fixtures', 'is_inplay'));
    }

    public function actionEvents($id)
    {
        $client = SportMonks::init();

        $game = $client->fixtures()->find($id);

        if ($game == null) {

            $is_inplay = true;
            $fixtures = [];
            return $this->render('index', compact('fixtures', 'is_inplay'));
        }

        $fixture = Fixture::find()
            ->with('odds')
            ->where('fixture_id=' . $id)
            ->one();

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


        $fixture = Fixture::find()
            ->with('localTeam')
            ->with('visitorTeam')
            ->with('odds')
            ->where('fixture_id=' . $id)
            ->one();

        if (!isset($fixture->localTeam)) {
            try {
                $team = $client->teams()->find($fixture->localteam_id);

                $my_team = new Team();
                $my_team->team_id = $team->id;
                $my_team->legacy_id = $team->legacy_id;
                $my_team->name = $team->name;
                $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                $my_team->country_id = $team->country_id;
                $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                $my_team->founded = $team->founded;
                $my_team->logo_path = $team->logo_path;
                $my_team->venue_id = $team->venue_id;

                $my_team->save();
            } catch (ClientException $ce) {

            }

        }

        if (!isset($fixture->visitorTeam)) {
            try {
                $team = $client->teams()->find($fixture->visitorteam_id);

                $my_team = new Team();
                $my_team->team_id = $team->id;
                $my_team->legacy_id = $team->legacy_id;
                $my_team->name = $team->name;
                $my_team->short_code = isset($team->short_code) ? $team->short_code : '';
                $my_team->twitter = isset($team->twitter) ? $team->twitter : '';
                $my_team->country_id = $team->country_id;
                $my_team->national_team = $team->national_team == "true" ? 1 : 0;
                $my_team->founded = $team->founded;
                $my_team->logo_path = $team->logo_path;
                $my_team->venue_id = $team->venue_id;

                $my_team->save();
            } catch (ClientException $ce) {

            }

        }

        if (!isset($fixture->league)) {
            try {
                $league = $client->leagues()->find($fixture->league_id);

                $my_league = new League();
                $my_league->league_id = $league->id;
                $my_league->legacy_id = $league->legacy_id;
                $my_league->country_id = $league->country_id;
                $my_league->name = $league->name;
                $my_league->is_cup = $league->is_cup == 'true' ? 1 : 0;
                $my_league->current_season_id = $league->current_season_id;
                $my_league->current_round_id = $league->current_round_id;
                $my_league->current_stage_id = $league->current_stage_id;
                $my_league->live_standings = $league->live_standings == "true" ? 1 : 0;

                if (isset($league->coverage)) {
                    $my_league->topscorer_goals = $league->coverage->topscorer_goals == "true" ? 1 : 0;
                    $my_league->topscorer_assists = $league->coverage->topscorer_assists == "true" ? 1 : 0;
                    $my_league->topscorer_cards = $league->coverage->topscorer_cards == "true" ? 1 : 0;
                }

                $my_league->save();

            } catch (ClientException $ce) {

            }

        }

//            if(!isset($fixture->odds) || (isset($fixture->odds) && count($fixture->odds) == 0)) {
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

//            }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('events_partial', compact('fixture'));

        } else {
            return $this->render('events', compact('fixture'));
        }
    }
}
