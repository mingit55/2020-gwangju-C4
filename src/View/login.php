    <div class="header__sub">
        <div class="container">
            <a href="#">전북 축제 On!</a>
            <span class="mx-2">
                <i class="fa fa-angle-right"></i>
            </span>
            <a href="#">로그인</a>
        </div>
    </div>
</header>

<!-- 로그인 -->
<form id="login-modal" class="container padding" action="/login" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-end">
                <span class="fx-5">전북 축제 On!</span>
                <span class="fx-n2 text-muted">전북 축제 On! 사이트 로그인 페이지 입니다.</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="login_id">Username</label>
                    <input type="text" id="login_id" class="form-control" name="user_id">
                </div>
                <div class="form-group">
                    <label for="login_pw">Password</label>
                    <input type="password" id="login_pw" class="form-control" name="password">
                </div>
                <div class="d-between mt-3 fx-n2 text-muted">
                    <div>
                        <input type="checkbox">
                        <span class="ml-2">Rememeber Me</span>
                    </div>
                    <a href="#" class="text-muted">Forgot Password</a>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button class="btn-filled">로그인</button>
                <button class="btn-bordered" type="button">회원가입</button>
            </div>
        </div>
    </div>
</form>
<!-- /로그인 -->