class App {
    constructor(){
        this.$content = $("#content");
        this.$paging = $("#paging");
        this.$viewModal = $("#view-modal");

        this.getFestivals().then(festivals => {
            this.festivals = festivals;
            this.render();
            this.setEvents();
        });
    }

    /**
     * 축제 정보 가져오기
     */
    getFestivals(){
        return fetch("/api/festivals")
            .then(res => res.json())
            .then(res => res.festivals);
    }

    /**
     * DOM 렌더링
     */
    render(){
        // 쿼리스트링 가져오가
        let qs = location.getQueryString();
        let page = parseInt(qs.page);
        page = isNaN(page) || !page || page < 1 ? 1 : page;
        
        let type = qs.searchType;
        type = !['album', 'list'].includes(type) ? 'album' : type;

        // 페이지 계산
        const PAGE__COUNT = type == 'album' ? 6 : 10;
        const PAGE__BCOUNT = 5;

        let totalPage = Math.ceil(this.festivals.length / PAGE__COUNT);
        let currentBlock = Math.ceil(page / PAGE__BCOUNT);
        
        let start = currentBlock * PAGE__BCOUNT - PAGE__BCOUNT + 1;
        start = start < 1 ? 1 : start;
        let end = start + PAGE__BCOUNT - 1;
        end = end > totalPage ? totalPage : end;
        
        let prev = start - 1 > 1;
        let next = end + 1 < totalPage;

        let sp = (page - 1) * PAGE__COUNT;
        let ep = sp + PAGE__COUNT;
        let viewList = this.festivals.slice(sp, ep);

        // DOM 그리기
        let htmlLinks = "";
        for(let i = start; i <= end; i++)
            htmlLinks += `<a href="?page=${i}&searchType=${type}" class="paging__link ${i == page ? 'active' : ''}">${i}</a>`;

        this.$paging.html(`<a href="?page=${start - 1}&searchType=${type}" class="paging__blink" ${!prev ? 'disabled' : ''}><i class="fa fa-angle-left"></i></a>
                    ${htmlLinks}
                    <a href="?page=${end + 1}&searchType=${type}" class="paging__blink" ${!next ? 'disabled' : ''}><i class="fa fa-angle-right"></i></a>`);

        $(".tabs > a").removeClass("active");
        $(".tabs > a[data-type='"+ type +"']").addClass("active");

        if(type === 'album') this.drawAlbum(viewList);
        else this.drawList(viewList);
    }

    drawAlbum(viewList){
        let lastItem = this.festivals[this.festivals.length - 1];
        let htmlItems = viewList.map(item => `<div class="col-lg-4 mb-4">
                                                <div class="position-relative border" data-id="${item.id}" data-toggle="modal" data-target="#view-modal">
                                                    <div class="image-cnt">
                                                        ${item.images.length}
                                                    </div>
                                                    <img src=".${item.imagePath}/${item.images[0]}" alt="축제 이미지" class="hx-200 fit-cover">
                                                    <div class="py-3 px-3">
                                                        <div>${item.name}</div>
                                                        <div class="fx-n2 mt-1 text-muted">${item.period}</div>
                                                    </div>
                                                </div>
                                            </div>`);

        this.$content.html(`<div class="album">
                                <div class="row" data-id="${lastItem.id}" data-toggle="modal" data-target="#view-modal">
                                    <div class="col-lg-5">
                                        <img src="/${lastItem.imagePath}/${lastItem.images[0]}" alt="축제 이미지" class="hx-300 fit-cover">
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="fx-n2 text-muted">대표 축제</div>
                                        <div class="fx-3 mt-2">${lastItem.name}</div>
                                        <div class="mt-4">
                                            <p class="text-muted fx-n2">${lastItem.content}</p>
                                        </div>
                                        <div class="mt-3 d-between">
                                            <div>
                                                <span class="badge badge-danger">기간</span>
                                                <span class="fx-n2 ml-2 text-muted">${lastItem.period}</span>
                                            </div>
                                            <button class="btn-filled fx-n3">자세히 보기</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    ${htmlItems.join("")}
                                </div>
                            </div>`); 
        this.$content.find("img").on("error", e => {
            e.target.src = "/resources/images/no-image.jpg";
            $(e.target).siblings(".image-cnt").remove();
        }); 
    }

    drawList(viewList){
        let htmlItems = viewList.map(item => `<div class="t-row" data-id="${item.id}" data-toggle="modal" data-target="#view-modal">
                                                    <div class="cell-10">${item.no}</div>
                                                    <div class="cell-50 text-left px-2 text-ellipsis">${item.name}</div>
                                                    <div class="cell-30">${item.period}</div>
                                                    <div class="cell-10">${item.area}</div>
                                                </div>`);
        this.$content.html(`<div class="list">
                                <div class="border-top">
                                    <div class="t-head">
                                        <div class="cell-10">번호</div>
                                        <div class="cell-50">제목</div>
                                        <div class="cell-30">기간</div>
                                        <div class="cell-10">장소</div>
                                    </div>
                                    ${htmlItems.join("")}
                                </div>
                            </div>`);
    }

    /**
     * 이벤트 작성
     */
    setEvents(){
        this.$content.on("click", "[data-target='#view-modal']", e => {
            let id = e.currentTarget.dataset.id;
            let festival = this.festivals.find(festival => festival.id == id);
            let imgLen = festival.images.length;

            let htmlImgs = festival.images.map(img => `<img src="${festival.imagePath}/${img}" alt="축제 이미지" style="width: ${100 / imgLen}%">`);

            let htmlBtns = "";
            for(let i = 1; i <= imgLen; i++){
                htmlBtns += `<button class="f-abs ${i == 1 ? 'active' : ''}" data-value="${i-1}">${i}</button>`;
            }
            
            this.$viewModal.data("sno", "0");
            this.$viewModal.html(`<div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-between">
                                            <div class="fx-4 font-weight-bold">축제 상세 정보</div>
                                            <button class="icon fx-3" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <img src="${festival.imagePath}/${festival.images[0]}" alt="축제 이미지" class="fit-cover hx-250">
                                                </div>
                                                <div class="col-lg-8">
                                                    <hr>
                                                    <div class="fx-4">${festival.name}</div>
                                                    <div class="mt-3">
                                                        <div>
                                                            <span class="fx-n2 text-muted">지역</span>
                                                            <span class="ml-3 fx-n1">${festival.area}</span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span class="fx-n2 text-muted">장소</span>
                                                            <span class="ml-3 fx-n1">${festival.location}</span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span class="fx-n2 text-muted">기간</span>
                                                            <span class="ml-3 fx-n1">${festival.period}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <p class="fx-n2 text-muted keep-all">${festival.content}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <hr class="mb-3">
                                                <div class="fx-3 mb-4">축제 사진</div>
                                                <div class="f-slide">
                                                    ${
                                                        imgLen ? 
                                                        `<div class="f-slide__inner" style="width: ${ 100 * imgLen }%">
                                                            ${htmlImgs.join("")}
                                                        </div>`
                                                        : `<img src="/resources/images/no-image.jpg" alt="축제 이미지">`
                                                    }
                                                </div>
                                                <div class="f-control mt-4">
                                                    <button class="f-rel" data-value="-1" disabled>이전</button>
                                                    ${htmlBtns}
                                                    <button class="f-rel" data-value="1" ${imgLen == 0 ? 'disabled' : ''}>다음</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
            this.$viewModal.find("img").on("error", e => {
                e.target.src = "/resources/images/no-image.jpg";
            });
        });
        
        this.$viewModal.on("click", ".f-control > button", e => {
            let value = parseInt(e.currentTarget.dataset.value);
            let imgLen = this.$viewModal.find(".f-slide img").length;
            let cno = this.$viewModal.data("sno");
            let sno;
            
            // 상대 값
            if(e.currentTarget.classList.contains("f-rel")) {
                sno = parseInt(cno + value);
            } 
            // 절대 값
            else {
                sno = parseInt(value);
            }
            console.log(sno, value);

            $(".f-control .f-abs").removeClass("active");
            $(".f-control .f-abs").eq(sno).addClass("active");

            this.$viewModal.find(".f-slide__inner").css("left", sno * -100 + "%");
            this.$viewModal.data("sno", sno);

            $(".f-control .f-rel").removeAttr("disabled", "disabled");

            if(sno + 1 >= imgLen) $(".f-control .f-rel").eq(1).attr("disabled", "disabled");
            else if(sno - 1 < 0) $(".f-control .f-rel").eq(0).attr("disabled", "disabled");

        });
    }
}

$(function(){
    let app = new App();
});