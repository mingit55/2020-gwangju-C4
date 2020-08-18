    <div class="header__sub">
        <div class="container">
            <a href="#">전북 축제 On!</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#">축제 일정</a>
        </div>
    </div>
</header>
<!-- /헤더 영역 -->

<!-- 축제 일정 -->
<div class="container padding">
    <div class="title text-center">
        <h1>SCHEDULES</h1>
        <p>축제일정</p>
    </div>
    <hr class="mx-auto">
    <div id="calender" class="calender">
        <div class="calender-header">
            <a href="/schedules?year=<?=date("Y")?>&month=<?=date("m")?>" class="btn-filled">이번달</a>
            <div class="calender-title">
                <a href="/schedules?year=<?=date("Y", $t_prev)?>&month=<?=date("m", $t_prev)?>">이전달</a>
                <h1><?=$year?>년 <?=$month?>일</h1>
                <a href="/schedules?year=<?=date("Y", $t_next)?>&month=<?=date("m", $t_next)?>">다음달</a>
            </div>
            <a href="/festivals" class="btn-bordered">축제관리</a>
        </div>
        <div class="calender-body">
            <div class="calender__hitem">SUN</div>
            <div class="calender__hitem">MON</div>
            <div class="calender__hitem">TUE</div>
            <div class="calender__hitem">WED</div>
            <div class="calender__hitem">THU</div>
            <div class="calender__hitem">FRI</div>
            <div class="calender__hitem">SAT</div>
            <?php for($i = 0; $i < date("w", $t_firstDay); $i++):?>
                <div class="calender__item calender__item--empty"></div>
            <?php endfor;?>
            <?php 
                global $day;
                $prev = [];
                for($day = 1; $day <= date("d", $t_lastDay); $day++):
                    $sch = [null, null, null];
                    foreach($prev as $idx => $item){
                        if($item && $item->startDay <= $day && $day <= $item->endDay)
                            $sch[$idx] = $item;
                    }
                    $started = array_filter($data, function($item){
                        global $day;
                        return $item->startDay == $day;
                    });
                    foreach($started as $item){
                        for($i = 0; $i < 3; $i++){
                            if($sch[$i] === null) {
                                $sch[$i] = $item;
                                break;
                            }
                        }
                    }
            ?>
            <div class="calender__item <?= date("Y-m-d") == "$year-$month-$day" ? "active" : "" ?>">
                <span class="calender-day"><?=$day?></span>
                <div class="schedule">
                    <?php foreach($sch as $item):?>
                        <?php if($item == false): ?>
                            <div class="schedule__item schedule__item--empty"></div>
                        <?php else:?>
                            <a href="/festivals/<?=$item->id?>" class="schedule__item <?= $item->periodDay <= 1 ? 'text-ellipsis' : '' ?>" title="<?=$item->name?>(<?=$item->period?>)"><?=array_search($item, $prev) === false ? "$item->name($item->period)" : ""?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
            <?php 
                $prev = $sch;
                endfor;
            ?>
            <?php for($i = 0; $i < 6 - date("w", $t_lastDay); $i++):?>
                <div class="calender__item calender__item--empty"></div>
            <?php endfor;?>
        </div>
    </div>
</div>
<!-- /축제 일정 -->