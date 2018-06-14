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
                    <div class="betlist">
                    </div>
                    <div class="bettotal-detail">
                    </div>
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
                                            <td class="" style="padding-bottom: 10px;">
                                                <span class="fa fa-star"></span>
                                            </td>
                                            <td class="match_home">
                                                <?php
                                                echo $localTeam_name;
                                                ?>
                                            </td>
                                            <td class="match_score">
                                                <?php
                                                if ($fixture->status != "NS" && $fixture->status != "CANCL") {
                                                    echo $fixture->localteam_score . ' - ' . $fixture->visitorteam_score;
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
                                         data-odds="<?= $home_odds ?>" data-fixture="<?= $fixture->fixture_id ?>"
                                            data-home="<?=$localTeam_name?>" data-away="<?=$visitorTeam_name?>">
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
                                         data-odds="<?= $X_odds ?>" data-fixture="<?= $fixture->fixture_id ?>"
                                         data-home="<?=$localTeam_name?>" data-away="<?=$visitorTeam_name?>">
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
                                         data-odds="<?= $away_odds ?>" data-fixture="<?= $fixture->fixture_id ?>"
                                         data-home="<?=$localTeam_name?>" data-away="<?=$visitorTeam_name?>">
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

        <ul class="bet-sample" style="visibility: hidden;">
            <li>
                <div class="delete">
                    <span class="fa fa-times-circle" title="حذف"></span>
                </div>
                <b class="home-team"></b>
                <br>
                <b class="away-team"></b>
            </li>
            <li>نتیجه مسابقه</li>
            <li>
                <span class="pick">انتخاب : <span class="selected-odd-title"></span></span>
                <span class="odds">0</span>
            </li>
            <li>
                <input class="input stake" autocomplete="off" type="text">
                <span class="win-price">مبلغ برد&nbsp;
                    <span class="ToWin">0</span>
                </span>
            </li>
            <li class="overlay" style="width: 285px; display: none;">
                <div>غیر فعال</div>
            </li>
        </ul>

        <div class="bettotal-smaple" style="visibility: hidden;">
            <ul class="bettotal">
                <li>
                    <span style="font-weight:400;">مجموع مبالغ</span>
                    <span class="totalstake" style="font-weight:400;">0</span>
                </li>
                <li>
                    <span>برد احتمالی
                        <span style="font-size:90% !important;padding:0 3px;">(تومان)</span>
                    </span>
                    <span class="totalwin">0</span>
                </li>
            </ul>
            <div style="padding:30px 0 10px 0;text-align:center;">
                <input class="btn btn-block placebet" value="ثبت شرط" type="button">
            </div>
        </div>
    </div>

<script type="text/javascript">
    _csrf = "<?=\Yii::$app->request->csrfToken?>";
</script>

<?php
$this->registerJs(<<<JS

    selected_ids = [];
    sumPrice = 0;
    sumOddsPrice = 0;
    pricesObject = [];
    
    $(document).ready(function(){
        
    $('.game_odds').click(function () {
        
        item_index = $.inArray( $(this).attr("data-odds-id"), selected_ids);
        if(item_index == -1){
            data_odds_id = $(this).attr("data-odds-id");
            
            oddsValue = $(this).attr("data-odds");
            if(oddsValue == 0){
                return;
            }
            
            selected_ids.push(data_odds_id);
            $(this).css({
                backgroundColor: '#fc0',
                color: '#000'
            });
            
            $(".nobet").css({
                display: 'none'
            });
            
            data = $('.bet-sample').clone()
                .attr('data-id', data_odds_id).css('visibility', 'visible')
                .removeClass('bet-sample').addClass('bet');
            
            $(".betlist").append(data);
            $("ul[data-id=" + data_odds_id + "] .home-team").text($(this).attr("data-home"));
            $("ul[data-id=" + data_odds_id + "] .away-team").text($(this).attr("data-away"));
            $("ul[data-id=" + data_odds_id + "] .odds").text($(this).attr("data-odds"));
            $("ul[data-id=" + data_odds_id + "] div.delete").attr('data-id', data_odds_id);
            
                $(".delete").click(function() {
                    
                    item_index = $.inArray( $(this).attr("data-id"), selected_ids);
                    if(item_index != -1){
                        
                        data_odds_id = selected_ids[item_index];
                        selected_ids.splice(item_index, 1);
                        
                        $('.game_odds[data-odds-id=' + data_odds_id + ']').css({
                            backgroundColor: '#4b4b4b',
                            color: '#fff'
                        });
                        
                        if(selected_ids.length == 0){
                            $(".nobet").css({display: 'table'})
                        }
                        
                        odds = $("ul[data-id=" + data_odds_id + "] .odds").text();
                        myPrice = $('ul[data-id=' + data_odds_id + '] input.input').val();
                        priceWithOdds = Math.floor(myPrice * odds);
                        
                        sumPrice = 0;
                        sumOddsPrice = 0;
                        
                        foundID = 0;
                        for(i=0; i<pricesObject.length; i++){
                            
                            prevAdded = pricesObject[i].id == data_odds_id;
                            
                            if(prevAdded){
                                foundID = i;
                                break;
                            }
                        }
                        pricesObject.splice(foundID, 1);
                        
                        sumPrice = 0;
                        sumOddsPrice = 0;
                        for(i=0; i<pricesObject.length; i++){
                            
                            array = pricesObject[i].data;
                            sumPrice += array[0];
                            sumOddsPrice += array[1];
                        }
                        
                        $("ul[data-id=" + data_odds_id + "]").remove();
                        
                        if(selected_ids.length == 0){
                            
                            $('div.bettotal').remove();
                        } else {
                        
                            $('ul.bettotal span.totalstake').text(sumPrice.toLocaleString());
                            $('ul.bettotal span.totalwin').text(sumOddsPrice.toLocaleString());
                        }
                    }
                });

            
            
            $("ul[data-id=" + data_odds_id + "] input.input").attr('data-odd-value', $(this).attr("data-odds"));
            $("ul[data-id=" + data_odds_id + "] input.input").attr('data-odd-id', data_odds_id);
            
            lastChar = data_odds_id.substr(data_odds_id.length - 1);
            if(lastChar == "1"){
                $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text($(this).attr("data-home"));
            } else if(lastChar == "2"){
                $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text($(this).attr("data-away"));
            } else {
                $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text('مساوی');
            }
            
            if(selected_ids.length == 1){
                
                totalData = $('.bettotal-smaple').clone()
                    .css('visibility', 'visible')
                    .removeClass('bettotal-smaple').addClass('bettotal');
                $(".bettotal-detail").append(totalData);
                
                $(".bettotal span.totalstake").text(0);
                $(".bettotal span.totalwin").text(0);
                $('.bettotal input.placebet').click(function() {
        
                    $.post("?r=predict/set-bets", 
                        {"data": JSON.stringify(pricesObject), '_csrf': _csrf}, 
                        function(result){
                            
                    })
                });
            }
            
            $('ul.bet input.input').on('input', function() {
                myPrice = parseInt($(this).val());
                oldValue = $(this).attr('data-value');
                if(isNaN(oldValue)){
                    oldValue = 0;
                }
                if(myPrice == oldValue && oldValue != 0){
                    return;
                }
                
                $('ul.bet input.input').attr('data-value', myPrice);
                
                myDataOddsId = $(this).attr('data-odd-id');
                odds = $("ul[data-id=" + myDataOddsId + "] .odds").text();
                
                priceWithOdds = Math.floor(myPrice * odds);
                // oldPriceWithOdds = Math.floor(oldValue * odds);
                
                prevAdded = false;
                for(i=0; i<pricesObject.length; i++){
                    
                    prevAdded = pricesObject[i].id == myDataOddsId;
                    
                    if(prevAdded){
                        console.log('here2');
                        pricesObject[i] = {'id': myDataOddsId, 'data': [myPrice, priceWithOdds]};
                        break;
                    }
                }
                
                if(pricesObject.length == 0) {
                    console.log('here0');
                    pricesObject.push({'id': myDataOddsId, 'data': [myPrice, priceWithOdds]});
                } else {
                    if(!prevAdded){
                        console.log('here1');
                        pricesObject.push({'id': myDataOddsId, 'data': [myPrice, priceWithOdds]});
                    }
                }
                
                sumPrice = 0;
                sumOddsPrice = 0;
                for(i=0; i<pricesObject.length; i++){
                    
                    array = pricesObject[i].data;
                    sumPrice += array[0];
                    sumOddsPrice += array[1];
                }
                
                $('ul[data-id=' + myDataOddsId + '] span.ToWin').text(priceWithOdds.toLocaleString());
                $('ul.bettotal span.totalstake').text(sumPrice.toLocaleString());
                $('ul.bettotal span.totalwin').text(sumOddsPrice.toLocaleString());
            });
            
        } else {
            data_odds_id = selected_ids[item_index];
            selected_ids.splice(item_index, 1);
            
            $(this).css({
                backgroundColor: '#4b4b4b',
                color: '#fff'
            });
            
            if(selected_ids.length == 0){
                $(".nobet").css({display: 'table'})
            }
            
            odds = $("ul[data-id=" + data_odds_id + "] .odds").text();
            myPrice = $('ul[data-id=' + data_odds_id + '] input.input').val();
            priceWithOdds = Math.floor(myPrice * odds);
            
            sumPrice = 0;
            sumOddsPrice = 0;
            
            foundID = 0;
            for(i=0; i<pricesObject.length; i++){
                
                prevAdded = pricesObject[i].id == data_odds_id;
                
                if(prevAdded){
                    foundID = i;
                    break;
                }
            }
            pricesObject.splice(foundID, 1);
            
            sumPrice = 0;
            sumOddsPrice = 0;
            for(i=0; i<pricesObject.length; i++){
                
                array = pricesObject[i].data;
                sumPrice += array[0];
                sumOddsPrice += array[1];
            }
            
            // for(i=0; i<selected_ids.length; i++){
            //  
            //     array = pricesObject['I'+selected_ids[i]];
            //     sumPrice += array[0];
            //     sumOddsPrice += array[1];
            // }
            
            $("ul[data-id=" + data_odds_id + "]").remove();
            
            if(selected_ids.length == 0){
                
                $('div.bettotal').remove();
            } else {
            
                $('ul.bettotal span.totalstake').text(sumPrice.toLocaleString());
                $('ul.bettotal span.totalwin').text(sumOddsPrice.toLocaleString());
            }
        }
    });
    
    });
JS
);
?>