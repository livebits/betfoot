<?php

use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */

$this->title = "پیش بینی فوتبال";
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

            <div class="box ajax">
                <div class="header" style="height: 120%;">

                    <?php

                    $myPredictions = [];
                    if (!Yii::$app->user->isGuest) {
                        $myPredictions = \app\models\Prediction::find()
                            ->where('user_id=' . Yii::$app->user->id)
                            ->all();
                    }

                    $league_id = 0;

                    $is_predicted = false;
                    foreach ($myPredictions as $myPrediction) {

                        if ($myPrediction->fixture_id == $fixture->fixture_id) {
                            $is_predicted = true;
                            break;
                        }
                    }

                    //detect game status
                    //                            if (!$is_inplay && $fixture->status == "LIVE") {
                    //                                continue;
                    //                            }

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

                        }

                    }

                    ?>

                    <div class="header-container">
                        <div id="sport-header" class="sports-header">

                            <table class="teams" style="width: 100%;height: 100px;overflow: hidden;">
                                <tr>
                                    <td class="" style="padding-bottom: 10px;">
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
                                    <td style="width: 100px;" class="start_time <?php
                                    if ($fixture->status == "LIVE" || $fixture->status == "ET") {
                                        echo 'live-clock';
                                    }
                                    ?>"

                                        <?php

                                        if ($fixture->status == "LIVE" || $fixture->status == "ET") {
                                            echo 'minute="' . $fixture->minute . '" second="' . $fixture->second . '"';
                                        }
                                        ?>
                                    >
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

                        </div>
                    </div>
                </div>
                <div class="body">

                    <table class="table match_list table-responsive">


                        <?php

                        //get fixture odds
                        $odds = \app\models\Odds::find()
                            ->where('fixture_id=' . $fixture->fixture_id)
                            ->all();

                        foreach ($odds as $odd) {

                            $bookmaker = json_decode($odd->bookmaker);
                            $game_odds = $bookmaker->data[0]->odds->data;

                            if ($odd->odds_id == 1) {

                                continue;
                            }
                            ?>

                            <tr class="match_group_header">

                                <td style="width:65%;text-align: right;">
                                        <span class="match_group_name">
                                                    <?php
                                                    if ($odd->odds_id == 12) {
                                                        echo 'تعداد گل بالا/پایین';

                                                    } else if ($odd->odds_id == 38) {
                                                        echo 'تعداد گل بالا/پایین نیمه اول';

                                                    } else if ($odd->odds_id == 47) {
                                                        echo 'تعداد گل بالا/پایین نیمه دوم';

                                                    } else if ($odd->odds_id == 37) {
                                                        echo 'نتیجه بازی در نیمه اول';

                                                    } else if ($odd->odds_id == 80) {
                                                        echo 'نتیجه بازی در نیمه دوم';

                                                    } else if ($odd->odds_id == 10) {
                                                        echo 'رفت/برگشت';

                                                    } else if ($odd->odds_id == 975909) {
                                                        echo 'نتیجه دقیق';

                                                    } else if ($odd->odds_id == 975916) {
                                                        echo 'نتیجه دقیق نیمه اول';

                                                    } else if ($odd->odds_id == 83) {
                                                        echo 'هندیکپ سه تایی';

                                                    } else if ($odd->odds_id == 63) {
                                                        echo 'شانس دو برابر';

                                                    } else if ($odd->odds_id == 28) {
                                                        echo 'هندیکپ';

                                                    } else if ($odd->odds_id == 63) {
                                                        echo 'شانس دو برابر';

                                                    } else if ($odd->odds_id == 975930) {
                                                        echo 'زوج/فرد';

                                                    } else if ($odd->odds_id == 975932) {
                                                        echo 'زوج/فرد نیمه اول';

                                                    }  else {
                                                        echo $odd->name;
                                                    }

                                                    //                                                    echo ' // ' . $odd->odds_id;
                                                    ?>
                                            </span>
                                    </span>
                                </td>

                            </tr>

                            <tr class="match_group_item">

                                <td>

                                    <?php
                                    if ($odd->odds_id == 1) {

                                        continue;
                                    }

                                    if ($odd->odds_id == 12 || $odd->odds_id == 38 || $odd->odds_id == 47) {

                                        $index = 0;
                                        foreach ($game_odds as $game_odd) {


                                            $label = $game_odd->label;
                                            if ($label == "Under") {
                                                $label = 'زیر';
                                            } else if ($label == "Over") {
                                                $label = 'بالای';
                                            }
                                            ?>

                                            <div class="btn-odds game_odds col-md-5" style="width: 100%;"
                                                 data-odds-id="<?= $fixture->fixture_id . '_' . $odd->odds_id . '_' . $index++ ?>"
                                                 data-odd-label="<?= $odd->name . ' / ' . $label . ' ' . $game_odd->total ?>"
                                                 data-odds="<?= $game_odd->value ?>"
                                                 data-fixture="<?= $fixture->fixture_id ?>"
                                                 data-home="<?= $localTeam_name ?>"
                                                 data-away="<?= $visitorTeam_name ?>">
                                            <span class="text-center">
                                            <?php
                                            if ($game_odd->label == "Under") {
                                                echo 'زیر ' . $game_odd->total;
                                            } else if ($game_odd->label == "Over") {
                                                echo 'بالای ' . $game_odd->total;
                                            }
                                            ?>
                                            </span>
                                                <span class="text-left" style="float: left;margin-left: 5px;">
                                                <?= $game_odd->value ?>
                                            </span>
                                            </div>

                                            <?php
                                        }
                                    } else if ($odd->odds_id == 37 || $odd->odds_id == 80) {

                                        $index = 0;
                                        foreach ($game_odds as $game_odd) {

                                            $label = $game_odd->label;
                                            if ($label == "1") {
                                                $label = 'میزبان';
                                            } else if ($label == "2") {
                                                $label = 'میهمان';
                                            } else if ($label == "X") {
                                                $label = 'مساوی';
                                            }
                                            ?>

                                            <div class="btn-odds game_odds col-md-5" style="width: 100%;"
                                                 data-odds-id="<?= $fixture->fixture_id . '_' . $odd->odds_id . '_' . $index++ ?>"
                                                 data-odd-label="<?= $odd->name . ' / ' . $label ?>"
                                                 data-odds="<?= $game_odd->value ?>"
                                                 data-fixture="<?= $fixture->fixture_id ?>"
                                                 data-home="<?= $localTeam_name ?>"
                                                 data-away="<?= $visitorTeam_name ?>">
                                            <span class="text-center">
                                            <?php
                                            if ($game_odd->label == "1") {
                                                echo 'برد میزبان';
                                            } else if ($game_odd->label == "2") {
                                                echo 'برد میهمان';
                                            } else if ($game_odd->label == "X") {
                                                echo 'مساوی';
                                            }
                                            ?>
                                            </span>
                                                <span class="text-left" style="float: left;margin-left: 5px;">
                                                <?= $game_odd->value ?>
                                            </span>
                                            </div>

                                            <?php
                                        }

                                    } else if ($odd->odds_id == 10) {

                                        $index = 0;
                                        foreach ($game_odds as $game_odd) {

                                            $label = $game_odd->label;
                                            if ($label == "1") {
                                                $label = 'میزبان';
                                            } else if ($label == "2") {
                                                $label = 'میهمان';
                                            } else if ($label == "X") {
                                                $label = 'مساوی';
                                            }
                                            ?>

                                            <div class="btn-odds game_odds col-md-5" style="width: 100%;"
                                                 data-odds-id="<?= $fixture->fixture_id . '_' . $odd->odds_id . '_' . $index++ ?>"
                                                 data-odd-label="<?= $odd->name . ' / ' . $label ?>"
                                                 data-odds="<?= $game_odd->value ?>"
                                                 data-fixture="<?= $fixture->fixture_id ?>"
                                                 data-home="<?= $localTeam_name ?>"
                                                 data-away="<?= $visitorTeam_name ?>">
                                            <span class="text-center">
                                            <?php
                                            if ($game_odd->label == "1") {
                                                echo 'میزبان';
                                            } else if ($game_odd->label == "2") {
                                                echo 'میهمان';
                                            }
                                            ?>
                                            </span>
                                                <span class="text-left" style="float: left;margin-left: 5px;">
                                                <?= $game_odd->value ?>
                                            </span>
                                            </div>

                                            <?php
                                        }

                                    } else if ($odd->odds_id == 975923 ||
                                        $odd->odds_id == 83 || $odd->odds_id == 976209
                                        || $odd->odds_id == 976373 || $odd->odds_id == 975925 || $odd->odds_id == 28) {

                                        $index = 0;
                                        foreach ($game_odds as $game_odd) {

                                            $label = $game_odd->label;
                                            if ($label == "1") {
                                                $label = 'میزبان';
                                            } else if ($label == "2") {
                                                $label = 'میهمان';
                                            } else if ($label == "X") {
                                                $label = 'مساوی';
                                            }
                                            ?>

                                            <div class="btn-odds game_odds col-md-5" style="width: 100%;"
                                                 data-odds-id="<?= $fixture->fixture_id . '_' . $odd->odds_id . '_' . $index++ ?>"
                                                 data-odd-label="<?= $odd->name . ' / ' . $label ?>"
                                                 data-odds="<?= $game_odd->value ?>"
                                                 data-fixture="<?= $fixture->fixture_id ?>"
                                                 data-home="<?= $localTeam_name ?>"
                                                 data-away="<?= $visitorTeam_name ?>">
                                            <span class="text-center">
                                            <?php
                                            if ($game_odd->label == "1") {
                                                echo 'میزبان';
                                            } else if ($game_odd->label == "2") {
                                                echo 'میهمان';
                                            } else if ($game_odd->label == "X") {
                                                echo 'مساوی';
                                            }
                                            ?>
                                            </span>
                                                <span class="text-left" style="float: left;margin-left: 5px;">
                                                <?= $game_odd->value ?>
                                            </span>
                                            </div>

                                            <?php
                                        }

                                    } else {
                                        $index = 0;
                                        foreach ($game_odds as $game_odd) {
                                            ?>

                                            <div class="btn-odds game_odds col-md-5" style="width: 100%;"
                                                 data-odds-id="<?= $fixture->fixture_id . '_' . $odd->odds_id . '_' . $index++ ?>"
                                                 data-odd-label="<?= $odd->name . ' / ' . $game_odd->label ?>"
                                                 data-odds="<?= $game_odd->value ?>"
                                                 data-fixture="<?= $fixture->fixture_id ?>"
                                                 data-home="<?= $localTeam_name ?>"
                                                 data-away="<?= $visitorTeam_name ?>">
                                            <span class="text-center">
                                            <?php
                                            echo $game_odd->label;
                                            ?>
                                            </span>
                                                <span class="text-left" style="float: left;margin-left: 5px;">
                                                <?= $game_odd->value ?>
                                                </span>
                                            </div>

                                            <?php
                                        }
                                    }

                                    ?>


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
                <form action="<?= Yii::$app->getUrlManager()->createUrl('user/more-predicts') ?>"
                      method="post">
                    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
                    <input type="hidden" class="userPredicts" name="userPredicts" value="">

                    <input class="btn btn-block placebet" value="ثبت شرط" type="submit">
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        _csrf = "<?=\Yii::$app->request->csrfToken?>";
        _url = "<?=Yii::$app->request->url?>";

        selected_ids = [];
        sumPrice = 0;
        sumOddsPrice = 0;
        pricesObject = [];
    </script>

<?php
$this->registerJs(<<<JS
    
    (function worker() {
            $.ajax({
                url: _url,
                success: function(data) {
                    $('.ajax').html(data);
                },
                complete: function() {
                    // Schedule the next request when the current one's complete
                    setTimeout(worker, 5000);
                }
            });
        })();
    
    $(document).ready(function(){
        
        function startTime() {
        
        $('td.live-clock').each(function(i, clock) {
        
            // console.log(i + ", " + clock);
            m = parseInt($(clock).attr('minute'));
            s = parseInt($(clock).attr('second'));
            
            s = s + 1;
            if(s == 60) {
                s = 0;
                m = m + 1;
            }
            
            $(clock).attr('minute', m);
            $(clock).attr('second', s);
            
            $(clock).text( m + ":" + s);
        
        });
        
        setTimeout(startTime, 1000);
    }
    
    startTime();    
        
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
            // $("ul[data-id=" + data_odds_id + "] .odds").text($(this).attr("data-odd-label"));
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
            
            // lastChar = data_odds_id.substr(data_odds_id.length - 1);
            // if(lastChar == "1"){
            //     $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text($(this).attr("data-home"));
            // } else if(lastChar == "2"){
            //     $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text($(this).attr("data-away"));
            // } else {
            //     $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text('مساوی');
            // }
            $("ul[data-id=" + data_odds_id + "] .selected-odd-title").text($(this).attr("data-odd-label"));
            
            if(selected_ids.length == 1){
                
                totalData = $('.bettotal-smaple').clone()
                    .css('visibility', 'visible')
                    .removeClass('bettotal-smaple').addClass('bettotal');
                $(".bettotal-detail").append(totalData);
                
                $(".bettotal span.totalstake").text(0);
                $(".bettotal span.totalwin").text(0);
                $('.bettotal input.placebet').click(function() {
                    
                    $('input[name=userPredicts]').attr('value', JSON.stringify(pricesObject));
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