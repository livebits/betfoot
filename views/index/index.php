<?php
/* @var $this yii\web\View */
?>
<div class="container center-content">

    <div class="col-md-4 leftbar">

        <div class="box">
            <div class="header">پیش بینی های من</div>
            <div class="body">
                <div class="nobet">هنوز هیچ شرطی بسته نشده است. برای پیش بینی بروی ضریب مورد نظر خود کلیک کنید.</div>
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
                                <span class="match_list_date">چهارشنبه ۱۶ خرداد</span>
                            </div>
                            <div class="match_list_count_container">
                                تعداد بازی : <span class="match_list_count" id="match_list_count">۱۶</span>
                            </div>
                        </h1>
                        <div class="pc-container pm-tabs pc-component ui-tabs days">
                            <a href="inplay.aspx" style="color:#eee;" class="sgame"><span>پیشبینی زنده</span></a>
                            <a href="prematch.aspx?dt=6/4/2018" style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important" class="sgame"><span>بازیهای امروز</span></a>
                            <a href="prematch.aspx?dt=6/5/2018" style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important" class="sgame"><span>سه شنبه</span></a>
                            <a href="prematch.aspx?dt=6/6/2018" style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important" class="sgame"><span>چهارشنبه</span></a>
                            <a href="prematch.aspx?dt=6/7/2018" style="color:#eee;padding:5px 0px;margin-left:0px; max-width:90px !important" class="sgame"><span>پنج شنبه</span></a>
                            <a href="history.aspx" class="no-hover" style="padding:5px 10px !important;background:#fc0;border:1px solid #fc0;color:#000;border-radius:4px;"><span>سابقه پیش بینی</span></a>
                        </div>
                    </div>
                </div>


            </div>
            <div class="body">
                <table class="table table-bordered">
                    <?php
                    foreach ($fixtures as $fixture) {
                        ?>

                        <tr class="body even">
                            <td>
                                <span class="live-icon inplayicon"> </span>
                                <span class="home">

                            <?php
                            echo $fixture->localteam_id;
                            ?>

                        </span>
                                <span class="inplayscore">

                            <?php
                            echo $fixture->localteam_score . ' - ' . $fixture->visitorteam_score;
                            ?>

                        </span>
                                <span class="away">

                            <?php
                            echo $fixture->visitorteam_id;
                            ?>

                        </span>
                                <span class="inplaytime">

                            <?php
                            $time = $fixture->minute . ':' . $fixture->second;
                            ?>

                                    <input value="<?=$time?>" type="hidden">
                            <span class="timer"><?=$time?></span>
                        </span>
                            </td>
                            <td colspan="3">
                                <div class="matchodds">
                                    <span class="matchsuspended hidden">غیر فعال</span>
                                    <ul class="results" title="Spain-Switzerland">
                                        <li data-matchid="7322453" data-marketid="274675163" data-resultid="843023102" class="oddsbtn">
                                            <span class="indicator "></span>
                                            <span class="option-text" style="display:none;">Spain</span>
                                            <span class="value_" title="Spain">2.2</span>
                                            <span class="locker-icon fa fa-lock"></span></li>
                                        <li data-matchid="7322453" data-marketid="274675163" data-resultid="843023103" class="oddsbtn">
                                            <span class="indicator "></span>
                                            <span class="option-text" style="display:none;">مساوی</span>
                                            <span class="value_" title="مساوی">1.9</span>
                                            <span class="locker-icon fa fa-lock"></span>
                                        </li>
                                        <li data-matchid="7322453" data-marketid="274675163" data-resultid="843023104" class="oddsbtn">
                                            <span class="indicator "></span>
                                            <span class="option-text" style="display:none;">Switzerland</span>
                                            <span class="value_" title="Switzerland">11</span>
                                            <span class="locker-icon fa fa-lock"></span>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td style="width:30px;padding:0;text-align:center;">
                                <a href="football.aspx?event=7322453">
                                    <span class="fa fa-plus-square" style="width:100%;font-weight:bold;font-size:15px;" title="شرط های بیشتر"> </span>
                                </a>
                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>



    </div>

</div>