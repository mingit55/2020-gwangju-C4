<div class="header__sub">
        <div class="container">
            <a href="#">전북 축제 On!</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#">축제 수정</a>
        </div>
    </div>
</header>
<!-- /헤더 영역 -->

<div class="container padding">
    <hr>
    <div class="title">
        <h1>FESTIVAL</h1>
        <p>축제 관리</p>
    </div>
    <form action="/update/festivals/<?=$festival->id?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">축제명</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= $festival->name ?>">
        </div>
        <div class="form-group">
            <label for="area">지역</label>
            <input type="text" id="arae" name="area" class="form-control" value="<?= $festival->area ?>">
        </div>
        <div class="form-group">
            <label for="period">기간</label>
            <input type="text" id="period" name="period" class="form-control" placeholder="ex) 2020-01-01 ~ 2020-01-02" value="<?= date("Y-m-d", strtotime($festival->start_date)) ?> ~ <?= date("Y-m-d", strtotime($festival->end_date)) ?>">
        </div>
        <div class="form-group">
            <label for="location">장소</label>
            <input type="text" id="location" name="location" class="form-control" value="<?= $festival->location ?>">
        </div>
        <div class="form-group">
            <label>이미지 관리</label>
            <small class="text-muted ml-1">※ 업로드한 이미지 중 삭제할 이미지를 선택하세요.</small>
            <div class="mt-2 rounded bg-light d-flex flex-wrap p-3 border">
                <?php foreach ($images as $image):?>
                <div class="m-2">
                    <input type="checkbox" name="remove_images[]" value="<?=$image->id?>">
                    <span><?=$image->origin_name?></span>
                </div>
                <?php endforeach;?>
            </div>        
        </div>
        <div class="form-group">
            <label for="add_images">추가 업로드</label>
            <small class="text-muted ml-1">※ [Ctrl + 좌클릭]을 통해 여러 이미지를 선택할 수 있습니다.</small>
            <div class="custom-file">
                <label for="add_images" class="custom-file-label">업로드 할 파일을 선택하세요</label>
                <input type="file" id="add_images" name="add_images[]" class="custom-file-input" accept="image/*" multiple>
            </div>
        </div>
        <div class="form-group mt-4 text-right">
            <button class="btn-filled">저장</button>
            <a href="/delete/festivals/<?=$festival->id?>" class="btn-bordered">삭제</a>
        </div>
    </form>
</div>