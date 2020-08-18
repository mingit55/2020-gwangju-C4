    <div class="header__sub">
        <div class="container">
            <a href="#">전북 축제 On!</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#">축제 정보</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#"><?= $festival->name ?></a>
        </div>
    </div>
</header>
<!-- /헤더 영역 -->

<!-- 축제 상세보기 -->
<div class="container padding">
    <hr class="mt-4 mb-3">
    <div class="pb-3 mb-4 border-bottom">
        <div class="fx-4 font-weight-bold">축제 상세 정보</div>
    </div>
    <div class="row">
        <div class="col-lg-4">  
            <?php if(count($images) == 0  || !is_file(ROOT. $festival->imagePath."/".$images[0]->local_name)):?>
                <img src="/resources/images/no-image.jpg" alt="축제 이미지" class="fit-cover hx-300">
            <?php else: ?>
                <img src="<?=$festival->imagePath?>/<?=$images[0]->local_name?>" alt="축제 이미지" class="fit-cover hx-300">
            <?php endif;?>
        </div>
        <div class="col-lg-8">
            <div class="fx-5 font-weight-lighter"><?=htmlentities($festival->name)?></div>
            <div class="mt-3">
                <p class="fx-n2 text-muted"><?=htmlentities($festival->content)?></p>
            </div>
            <div class="mt-4">
                <div class="mt-2">
                    <span class="fx-n2 text-muted">지역</span>
                    <span class="fx-n1 ml-2"><?=htmlentities($festival->area)?></span>
                </div>
                <div class="mt-2">
                    <span class="fx-n2 text-muted">장소</span>
                    <span class="fx-n1 ml-2"><?=htmlentities($festival->location)?></span>
                </div>
                <div class="mt-2">
                    <span class="fx-n2 text-muted">기간</span>
                    <span class="fx-n1 ml-2"><?=$festival->period?></span>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-4 mb-3">
    <div class="fx-4 font-weight-bold pb-3 mb-4 border-bottom">축제 사진</div>
    <div class="row">
        <?php if(count($images) > 0):?>
            <?php foreach($images as $image): ?>
                <div class="col-lg-4 mb-4">
                    <?php if(!is_file(ROOT. $festival->imagePath."/".$image->local_name)):?>
                        <img src="/resources/images/no-image.jpg" alt="축제 이미지" class="fit-cover hx-300">
                    <?php else:?>
                        <img src="<?=$festival->imagePath?>/<?=$image->local_name?>" alt="축제 이미지" class='fit-cover hx-300'>
                    <?php endif;?>
                </div>
            <?php endforeach;?>
        <?php else:?>
            <div class="col-12 text-center py-4 fx-n1 text-muted">등록된 사진이 없습니다.</div>
        <?php endif;?>
    </div>
    <hr class="mt-4 mb-3">
    <div class="d-between pb-3 mb-4 border-bottom">
        <div class="fx-4 font-weight-bold">축제 후기</div>
        <button class="btn-filled" data-target="#review-modal" data-toggle="modal">후기 등록</button>
    </div>
    <?php foreach($comments as $comment):?>
        <div class="py-2 px-3">
            <div class="d-between border-bottom py-2">
                <div>
                    <span class="fx-3 font-weight-lighter"><?=htmlentities($comment->user_name)?></span>
                    <span class="ml-2 text-red">
                        <?= str_repeat('<i class="fa fa-star mr-1"></i>', $comment->score) ?>
                    </span>
                </div>
                <?php if(user()):?>
                <a href="/delete/festivals/<?=$festival->id?>/comments/<?=$comment->id?>" class="btn-bordered">삭제</a>
                <?php endif;?>
            </div>
            <div class="mt-3">
                <p class="fx-n1 text-muted"><?= htmlentities($comment->content) ?></p>
            </div>
        </div>
    <?php endforeach;?>
    <?php if(count($comments) === 0):?>
        <div class="py-4 px-3 text-center fx-n1 text-muted">
            등록된 후기가 없습니다.
        </div>
    <?php endif;?>
</div>
<!-- /축제 상세보기 -->

<!-- 후기 작성 -->
<form id="review-modal" class="modal fade" action="/insert/festivals/<?=$festival->id?>/comments" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-between">
                <span class="fx-5 font-weight-lighter">후기등록</span>
                <button type="button" class="fx-5 text-muted">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="user_name">이름</label>
                    <input type="text" id="user_name" class="form-control" name="user_name">
                </div>
                <div class="form-group">
                    <label for="score">별점</label>
                    <select name="score" id="score" class="form-control">
                        <option value="1">1점</option>
                        <option value="2">2점</option>
                        <option value="3">3점</option>
                        <option value="4">4점</option>
                        <option value="5">5점</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="content">후기</label>
                    <input type="text" id="content" class="form-control" name="content">
                </div>
            </div>
            <div class="modal-footer text-right">
                <button class="btn-filled">후기 등록</button>
            </div>
        </div>
    </div>
</form>
<!-- /후기 작성 -->