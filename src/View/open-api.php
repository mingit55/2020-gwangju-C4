    <div class="header__sub">
            <div class="container">
                <a href="#">전북 축제 On!</a>
                <span class="mx-2">
                    <i class="fa fa-angle-right"></i>
                </span>
                <a href="#">종합지원센터</a>
                <span class="mx-2">
                    <i class="fa fa-angle-right"></i>
                </span>
                <a href="#">공공 데이터 개방</a>
            </div>
        </div>
    </header>
    <!-- /헤더 영역 -->
    

    <!-- 공공 데이터 개방 -->
    <div class="container padding">
        <div class="title">
            <h1>OPEN <strong>API</strong></h1>
            <p>공공 데이터 개방</p>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>전문명</td>
                    <td colspan="4">전북 대표 축제 조회(JSON)</td>
                </tr>
                <tr>
                    <td>전문주소</td>
                    <td colspan="4">/openAPI/festivalList.php</td>
                </tr>
                <tr>
                    <td>전문설명</td>
                    <td colspan="4">전북의 축제를 조회한다.</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="5">요청 전문 명세서</td>
                </tr>
                <tr>
                    <td>항목명</td>
                    <td>국문명</td>
                    <td>필수</td>
                    <td>샘플</td>
                    <td>항목설명</td>
                </tr>
                <tr>
                    <td>searchType</td>
                    <td>조회 구분</td>
                    <td>필수</td>
                    <td>M</td>
                    <td>M: 월별, Y: 년도별</td>
                </tr>
                <tr>
                    <td>year</td>
                    <td>년도</td>
                    <td>필수</td>
                    <td>2021</td>
                    <td>요청 년도</td>
                </tr>
                <tr>
                    <td>month</td>
                    <td>월</td>
                    <td>가변</td>
                    <td>4</td>
                    <td>요청 월</td>
                </tr>
                <tr>
                    <td>totalCount</td>
                    <td>항목수</td>
                    <td>필수</td>
                    <td>11</td>
                    <td>검색 항목 수</td>
                </tr>
                <tr>
                    <td>items</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>조회 결과 항목 목록(0,1)</td>
                </tr>
                <tr>
                    <td>item</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>축제(0,n)</td>
                </tr>
                <tr>
                    <td>sn</td>
                    <td>순번</td>
                    <td>필수</td>
                    <td>1</td>
                    <td></td>
                </tr>
                <tr>
                    <td>no</td>
                    <td>고유번호</td>
                    <td>필수</td>
                    <td>90001</td>
                    <td></td>
                </tr>
                <tr>
                    <td>nm</td>
                    <td>축제명</td>
                    <td>필수</td>
                    <td>세계태권도</td>
                    <td></td>
                </tr>
                <tr>
                    <td>location</td>
                    <td>주소</td>
                    <td>필수</td>
                    <td>전라북도 무주군 설천면 무설로 1482 국립태권도원 T1경기장</td>
                    <td></td>
                </tr>
                <tr>
                    <td>dt</td>
                    <td>기간</td>
                    <td>필수</td>
                    <td>2020.06.24~06.30</td>
                    <td></td>
                </tr>
                <tr>
                    <td>cn</td>
                    <td>내용</td>
                    <td>필수</td>
                    <td class="text-ellipsis">WTF 세계...</td>
                    <td></td>
                </tr>
                <tr>
                    <td>images</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>사진 목록(0,1)</td>
                </tr>
                <tr>
                    <td>image</td>
                    <td>사진 파일명</td>
                    <td></td>
                    <td>10001_1.jpg</td>
                    <td>사진 주소(0,n)</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /공공 데이터 개방 -->