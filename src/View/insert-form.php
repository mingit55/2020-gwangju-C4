<div class="header__sub">
        <div class="container">
            <a href="#">전북 축제 On!</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#">축제 등록</a>
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
    <form action="/insert/festivals" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">축제명</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="area">지역</label>
            <input type="text" id="arae" name="area" class="form-control">
        </div>
        <div class="form-group">
            <label for="period">기간</label>
            <input type="text" id="period" name="period" class="form-control" placeholder="ex) 2020-01-01 ~ 2020-01-02">
        </div>
        <div class="form-group">
            <label for="location">장소</label>
            <input type="text" id="location" name="location" class="form-control">
        </div>
        <div class="form-group">
            <label for="images">축제 사진</label>
            <small class="text-muted ml-1">※ [Ctrl + 좌클릭]을 통해 여러 이미지를 선택할 수 있습니다.</small>
            <div class="custom-file">
                <label for="images" class="custom-file-label">업로드 할 파일을 선택하세요</label>
                <input type="file" id="images" name="images[]" class="custom-file-input" accept="image/*" multiple>
            </div>
        </div>
        <div class="form-group mt-4 text-right">
            <button class="btn-filled">저장</button>
        </div>
    </form>
</div>