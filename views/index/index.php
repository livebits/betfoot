<?php
/* @var $this yii\web\View */
?>
    <div class="container center-content">

        <div class="col-md-4 leftbar">

            <div class="box">
                <div class="header">پیش بینی های من</div>
                <div class="body">
                    <div class="nobet">
                    <span>
                    هنوز هیچ شرطی بسته نشده است. برای پیش بینی بروی ضریب مورد نظر خود کلیک کنید.
                    </span>
                    </div>
                    <div class="betlist"></div>
                </div>
            </div>
            <div class="place_message"><span></span></div>
        </div>
        <div class="col-md-8 rightbar">

            <div class="box">
                <div class="header">

                    <div class="header-container">
                        <div id="sport-header" class="sports-header">
                            <h1 class="sports-info-header">
                                <div>
                                <span class="match_list_date">
                                    <?php
                                    if (isset($date)) {
                                        echo \app\components\Jdf::jdate('Y/m/d', strtotime($date));
                                    } else {
                                        echo 'پخش زنده';
                                    }
                                    ?>
                                </span>
                                </div>
                                <div class="match_list_count_container">
                                    تعداد بازی : <span class="match_list_count"
                                                       id="match_list_count"><?= count($fixtures) ?></span>
                                </div>
                            </h1>
                            <div class="pc-container pm-tabs pc-component ui-tabs days">
                                <a href="?r=index/inplay" style="color:#eee;"
                                   class="sgame"><span>پیشبینی زنده</span></a>
                                <a href="?r=index/match-list&date=<?= (new \DateTime('now'))->format('Y-m-d') ?>"
                                   style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important"
                                   class="sgame"><span>بازیهای امروز</span></a>

                                <a href="?r=index/match-list&date=<?= (new \DateTime('now + 1day'))->format('Y-m-d') ?>"
                                   style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important"
                                   class="sgame"><span>بازیهای فردا</span></a>

                                <!--                            <a href="?r=index/match-list&date=-->
                                <? //= (new \DateTime('now + 2day'))->format('Y-m-d')?><!--"-->
                                <!--                               style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important"-->
                                <!--                               class="sgame"><span>چهارشنبه</span></a>-->

                                <a href="" class="no-hover"
                                   style="padding:5px 10px !important;background:#fc0;border:1px solid #fc0;color:#000;border-radius:4px;"><span>سابقه پیش بینی</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="body">

                    <table class="table match_list">
                        <?php
                        $league_id = 0;
                        foreach ($fixtures as $fixture) {

                            //detect game status
                            if (!$is_inplay && $fixture->status == "LIVE") {
                                continue;
                            }

                            //league name
                            $league_name = "";
                            if (isset($fixture->league)) {

                                $league_name = $fixture->league->name;
                            } else {
                                $league = \app\models\League::find()
                                    ->where('league_id=' . $fixture->league_id)
                                    ->one();

                                if ($league) {
                                    $league_name = $league->name;
                                } else {
                                    continue;
                                }
                            }

                            //local team
                            $localTeam_name = '';
                            if (isset($fixture->localTeam)) {
                                $localTeam_name = $fixture->localTeam->name;
                                $league_country_id = $fixture->localTeam->country_id;
                            } else {
                                $team = \app\models\Team::find()
                                    ->where('team_id=' . $fixture->localteam_id)
                                    ->one();

                                if ($team) {
                                    $localTeam_name = $team->name;
                                    $league_country_id = $team->country_id;
                                } else {
                                    continue;
                                }

                            }

                            //visitor team
                            $visitorTeam_name = '';
                            if (isset($fixture->visitorTeam)) {
                                $visitorTeam_name = $fixture->visitorTeam->name;

                            } else {
                                $team = \app\models\Team::find()
                                    ->where('team_id=' . $fixture->visitorteam_id)
                                    ->one();

                                if ($team) {
                                    $visitorTeam_name = $team->name;
                                } else {
                                    continue;
                                }

                            }

                            ?>

                            <?php
                            if ($league_id != $fixture->league_id) {
                                ?>
                                <tr class="match_group_header">

                                    <td style="width:65%;text-align: right;">
                                        <img src="image/countries/<?= $league_country_id ?>.svg"
                                             style="width: 15px;height: 15px;">
                                        <span class="match_group_name">
                                            <?= $league_name ?>
                                    </span>
                                        </span>
                                    </td>
                                    <td style="width:10%;">
                                        <span>میزبان</span>
                                    </td>
                                    <td style="width:10%;">
                                        <span>مساوی</span>
                                    </td>
                                    <td style="width:10%;">
                                        <span>میهمان</span>
                                    </td>
                                    <td style="width:5%;">
                                        <span></span>
                                    </td>

                                </tr>

                                <?php
                            }
                            $league_id = $fixture->league_id;
                            ?>

                            <tr class="match_group_item">

                                <td style="width:65%;text-align: right;" class="teams_title">

                                    <table class="teams">
                                        <tr>
                                            <td class="">
                                                <span class="fa fa-eye"></span>
                                            </td>
                                            <td class="match_home">
                                                <?php
                                                echo $localTeam_name;
                                                ?>
                                            </td>
                                            <td class="match_score">
                                                <?php
                                                if ($fixture->status != "NS" && $fixture->status != "CANCL") {
                                                    echo $fixture->visitorteam_score . ' - ' . $fixture->localteam_score;
                                                } else {
                                                    echo ' - ';
                                                }
                                                ?>
                                            </td>
                                            <td class="match_away">
                                                <?php
                                                echo $visitorTeam_name;
                                                ?>
                                            </td>
                                            <td class="start_time">
                                                <?php
                                                if ($fixture->status == "NS") {
                                                    echo date('H:i', $fixture->starting_at_ts);

                                                } else if ($fixture->status == "HT") {
                                                    echo 'نیمه اول';

                                                } else if ($fixture->status == "FT") {
                                                    echo 'پایان بازی';

                                                } else if ($fixture->status == "LIVE" || $fixture->status == "ET") {
                                                    echo $fixture->minute . ':' . $fixture->second;

                                                } else if ($fixture->status == "CANCL") {
                                                    echo 'کنسل شده';

                                                } else {
                                                    echo $fixture->status;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>

                                </td>

                                <?php

                                //get fixture odds
                                $odds = \app\models\Odds::find()
                                    ->where('fixture_id=' . $fixture->fixture_id)
                                    ->all();

                                $home_odds = 0;
                                $X_odds = 0;
                                $away_odds = 0;
                                foreach ($odds as $odd) {
                                    if ($odd->odds_id == 1) {
                                        $bookmaker = json_decode($odd->bookmaker);
                                        $game_odds = $bookmaker->data[0]->odds->data;

                                        foreach ($game_odds as $game_odd) {
                                            if ($game_odd->label == '1') {
                                                $home_odds = $game_odd->value;

                                            } else if ($game_odd->label == 'X') {
                                                $X_odds = $game_odd->value;

                                            } else if ($game_odd->label == '2') {
                                                $away_odds = $game_odd->value;
                                            }
                                        }

                                        break;
                                    }
                                }

                                ?>

                                <td style="width:10%;">
                                    <div class="btn-odds game_odds" data-odds-id="<?= $fixture->fixture_id . '1' ?>"
                                         data-odds="<?= $home_odds ?>" data-fixture="<?= $fixture->fixture_id ?>">
                                        <?php
                                        if ($home_odds == 0) {
                                            echo '<span class="fa fa-lock"></span>';
                                        } else {
                                            echo $home_odds;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td style="width:10%;">
                                    <div class="btn-odds game_odds" data-odds-id="<?= $fixture->fixture_id . 'X' ?>"
                                         data-odds="<?= $X_odds ?>" data-fixture="<?= $fixture->fixture_id ?>">
                                        <?php
                                        if ($X_odds == 0) {
                                            echo '<span class="fa fa-lock"></span>';
                                        } else {
                                            echo $X_odds;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td style="width:10%;">
                                    <div class="btn-odds game_odds" data-odds-id="<?= $fixture->fixture_id . '2' ?>"
                                         data-odds="<?= $away_odds ?>" data-fixture="<?= $fixture->fixture_id ?>">
                                        <?php
                                        if ($away_odds == 0) {
                                            echo '<span class="fa fa-lock"></span>';
                                        } else {
                                            echo $away_odds;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td style="width:5%;">
                                    <div class="btn-odds btn-odds-more" title="شرط های بیشتر">+</div>
                                </td>

                            </tr>


                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>


        </div>

        <ul class="bet" style="visibility: hidden;">
            <li>
                <span class="fa fa-times-circle delete has-tip" title="حذف"></span>
                <b class="player1"></b>
                <br>
                <b class="player2"></b>
            </li>
            <li>نتیجه مسابقه</li>
            <li>
                <span class="pick">انتخاب : <span></span></span>
                <span class="odds"></span>
            </li>
            <li>
                <input class="input stake" autocomplete="off" type="text">
                <span>مبلغ برد&nbsp;
                <span class="ToWin"></span>
            </span>
            </li>
            <li class="overlay" style="width: 285px; display: none;">
                <div>غیر فعال</div>
            </li>
        </ul>
    </div>
<?php
$this->registerJs(<<<JS

    selected_ids = [];
    $('.game_odds').click(function () {
        
        item_index = $.inArray( $(this).attr("data-odds-id"), selected_ids);
        if(item_index == -1){
            data_odds_id = $(this).attr("data-odds-id");
            selected_ids.push(data_odds_id);
            $(this).css({
                backgroundColor: '#fc0',
                color: '#000'
            });
            
            $(".nobet").css({
                display: 'none'
            });
            
            // $(".bet").appendTo('.betlist').css({
            //     visibility: 'visible'
            // });
            data = '<span data-id="' + data_odds_id + '">Hello World!</span>';
            $(data).appendTo(".betlist");
            
        } else {
            data_odds_id = selected_ids[item_index];
            selected_ids.splice(item_index, 1);
            $(this).css({
                backgroundColor: '#4b4b4b',
                color: '#fff',
            });
            
            if(selected_ids.length == 0){
                $(".nobet").css({display: 'table'})
            }
            
            $("span[data-id=" + data_odds_id + "]").remove();
        }
        
    })
JS
);
?>