<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전북 축제 On!</title>
    <script src="/resources/js/jquery-3.5.0.min.js"></script>
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css">
    <script src="/resources/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">
    <script src="/resources/js/common.js"></script>
</head>
<body>

    <!-- 찾아오시는 길 -->
    <div id="road-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body fx-4 fy-5"></div>
            </div>
        </div>
    </div>
    <!-- /찾아오시는 길 -->

    <!-- 헤더 영역 -->
    <input type="checkbox" id="open-aside" hidden>
    <header>
        <div class="header__top d-none d-lg-block">
            <div class="container d-between h-100">
                <div class="header-search">
                    <div class="icon">
                        <i class="fa fa-search"></i>
                    </div>
                    <input type="text" placeholder="Search">
                </div>
                <div class="header-util">
                    <select>
                        <option value="한국어">한국어</option>
                        <option value="English">English</option>
                        <option value="中文(简体)">中文(简体)</option>
                    </select>
                    <a href="#">전라북도청</a>
                    <?php if(user()):?>
                        <a href="/logout">로그아웃</a>
                    <?php else:?>
                        <a href="/login">로그인</a>
                    <?php endif;?>
                    <a href="#">회원가입</a>
                </div>
            </div>
        </div>
        <div class="header__bottom">
            <div class="container d-between h-100">
                <a href="/">
                    <img src="/resources/images/logo.svg" alt="전북 축제 On!" title="전북 축제 On!" height="45">
                </a>
                <nav class="nav d-none d-lg-flex">
                    <div class="nav__item">
                        <a href="/">HOME</a>
                    </div>
                    <div class="nav__item">
                        <a href="/main-festival">전북 대표 축제</a>
                    </div>
                    <div class="nav__item">
                        <a href="/festivals">축제 정보</a>
                    </div>
                    <div class="nav__item">
                        <a href="/schedules">축제 일정</a>
                    </div>
                    <div class="nav__item">
                        <a href="/exchange-guide">환율안내</a>
                    </div>
                    <div class="nav__item">
                        <a href="#">종합지원센터</a>
                        <div class="nav__list">
                            <a href="/notice">공지사항</a>
                            <a href="#">센터 소개</a>
                            <a href="#">관광정보 문의</a>
                            <a href="/open-api">공공 데이터 개방</a>
                            <a href="#" data-target="#road-modal" data-toggle="modal">찾아오시는 길</a>
                        </div>
                    </div>
                </nav>
                <label for="open-aside" class="icon d-lg-none">
                    <i class="fa fa-bars"></i>
                </label>
                <aside class="header-aside d-lg-none">
                    <div class="header-search header-search--mobile">
                        <div class="icon">
                            <i class="fa fa-search"></i>
                        </div>
                        <input type="text" placeholder="Search">
                    </div>    
                    <div class="header-util header-util--mobile">
                        <select>
                            <option value="한국어">한국어</option>
                            <option value="English">English</option>
                            <option value="中文(简体)">中文(简体)</option>
                        </select>
                        <a href="#">전라북도청</a>
                        <?php if(user()):?>
                            <a href="/logout">로그아웃</a>
                        <?php else:?>
                            <a href="/login">로그인</a>
                        <?php endif;?>
                        <a href="#">회원가입</a>
                    </div>             
                    <nav class="nav nav--mobile">
                        <div class="nav__item">
                            <a href="#">HOME</a>
                        </div>
                        <div class="nav__item">
                            <a href="/main-festival">전북 대표 축제</a>
                        </div>
                        <div class="nav__item">
                            <a href="/festivals">축제 정보</a>
                        </div>
                        <div class="nav__item">
                            <a href="/schedules">축제 일정</a>
                        </div>
                        <div class="nav__item">
                            <a href="/exchange-guide">환율안내</a>
                        </div>
                        <div class="nav__item">
                            <a href="#">종합지원센터</a>
                            <div class="nav__list">
                                <a href="/notice">공지사항</a>
                                <a href="#">센터 소개</a>
                                <a href="#">관광정보 문의</a>
                                <a href="/open-api">공공 데이터 개방</a>
                                <a href="#" data-target="#road-modal" data-toggle="modal">찾아오시는 길</a>
                            </div>
                        </div>
                    </nav>
                </aside>
            </div>
        </div>