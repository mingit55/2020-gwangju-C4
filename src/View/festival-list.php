<div class="header__sub">
        <div class="container">
            <a href="#">전북 축제 On!</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#">축제 정보</a>
        </div>
    </div>
</header>
<!-- /헤더 영역 -->

<!-- 축제 정보 -->
<div class="container padding">
    <div class="d-between">
        <div class="title">
            <hr>
            <h1>FESTIVAL <strong>ON!</strong></h1>
            <p>전북 축제</p>
        </div>
        <?php if(user()):?>
            <a href="/festivals/insert-form" class="btn-filled">축제 등록</a>
        <?php endif;?>
    </div>
    <div class="t-head">
        <div class="cell-10">번호</div>
        <div class="cell-40">축제명(사진)</div>
        <div class="cell-20">다운로드</div>
        <div class="cell-20">기간</div>
        <div class="cell-10">장소</div>
    </div>
    <?php foreach($festivals->data as $item):?>
        <div class="t-row">
            <?php if(user()):?>
                <a href="/festivals/update-form/<?=$item->id?>" class="cell-10"><?=$item->no?></a>
            <?php else:?>
                <div class="cell-10"><?=$item->no?></div>
            <?php endif;?>
            <a href="/festivals/<?=$item->id?>" class="cell-40 text-left text-ellipsis px-2">
                <?=htmlentities($item->name)?>
                <span class="badge badge-danger ml-1"><?=$item->cnt?></span>
            </a>
            <div class="cell-20">
                <a href="/download/tar/<?= $item->id ?>" class="btn-filled">tar</a>
                <a href="/download/zip/<?= $item->id ?>" class="btn-filled">zip</a>
            </div>
            <div class="cell-20"><?=$item->period?></div>
            <div class="cell-10"><?=htmlentities($item->area)?></div>
        </div>
    <?php endforeach;?>
    <div class="paging">
        <a href="/festivals?page=<?=$festivals->prevPage?>" class="paging__blink">
            <i class="fa fa-angle-left"></i>
        </a>
        <?php for($i = $festivals->start; $i <= $festivals->end; $i++):?>
            <a href="/festivals?page=<?=$i?>" class="paging__link <?= $i == $festivals->page ? 'active' : '' ?>"><?=$i?></a>
        <?php endfor;?>
        <a href="/festivals?page=<?=$festivals->nextPage?>" class="paging__blink">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
<!-- /축제 정보 -->