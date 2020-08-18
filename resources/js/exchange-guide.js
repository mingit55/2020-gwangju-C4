class App {
    constructor(){
        this.$content = $("#content");

        let result = this.loadData();
        if(result) {
            this.render();
            this.setEvents();
        } else {
            this.getExchangeData().then(({statusMsg, statusCd, dt, items}) => {
                if(statusCd != 200){
                    this.$content.text(statusMsg);
                    return;
                }

                this.standard = dt;
                this.viewItems = items.splice(0, 10);
                this.hasItems = items;

                this.render();
                this.setEvents();
                this.saveData();
            });
        }
        
    }

    render(){
        $("#standard").text(this.standard);

        let htmlItems = this.viewItems.map(item => `<div class="exchange-item p-5 ${item.result != 1 ? 'active' : ''}">
                                                        <hr>
                                                        <div class="exchange-item__title fx-5">${item.cur_nm}</div>
                                                        <div class="border-top mt-4">
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">통화코드</div>
                                                                <div class="cell-70 text-left">${item.cur_unit}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">송금 시</div>
                                                                <div class="cell-70 text-left">${item.ttb}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">수금 시</div>
                                                                <div class="cell-70 text-left">${item.tts}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">매매 기준율</div>
                                                                <div class="cell-70 text-left">${item.deal_bas_r}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">장부가격</div>
                                                                <div class="cell-70 text-left">${item.bkpr}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">년환가료율</div>
                                                                <div class="cell-70 text-left">${item.yy_efee_r}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">10일환가료율</div>
                                                                <div class="cell-70 text-left">${item.ten_dd_efee_r}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">매매 기준율</div>
                                                                <div class="cell-70 text-left">${item.kftc_bkpr}</div>
                                                            </div>
                                                            <div class="t-row">
                                                                <div class="cell-30 fx-n2 text-muted">장부가격</div>
                                                                <div class="cell-70 text-left">${item.kftc_deal_bas_r}</div>
                                                            </div>
                                                        </div>
                                                    </div>`);

        this.$content.html(`${htmlItems.join("")}
                            ${this.hasItems.length > 0 ? `<button class="btn-filled readmore mt-5">더 보기</button>` : ""}`);

    }

    getExchangeData(){
        return fetch("/restAPI/currentExchangeRate.php")
            .then(res => res.json());
    }

    loadData(){
        let ls_data = localStorage.getItem("exchangeData");
        
        if(ls_data){
            let {standard, viewItems, hasItems, scrollY} = JSON.parse(ls_data);
            this.standard = standard;
            this.viewItems = viewItems;
            this.hasItems = hasItems;
            
            setTimeout(() => {
                window.scrollTo(0, parseInt(scrollY));
            });

            return true;
        }
        return false;
    }

    saveData(){
        localStorage.setItem("exchangeData", JSON.stringify({
            scrollY: window.scrollY,
            standard: this.standard,
            hasItems: this.hasItems,
            viewItems: this.viewItems
        }));
    }

    setEvents(){
        $(window).on("scroll", e => {
            if(document.body.offsetHeight === window.scrollY + window.innerHeight) {
                this.viewItems.push(...this.hasItems.splice(0, 5));
                this.render();
            }
            this.saveData();
        });
        
        this.$content.on("click", ".readmore", e => {
            this.viewItems.push(...this.hasItems.splice(0, 5));
            this.render();
            this.saveData();
        });
    }
}

$(function(){
    let app = new App();
});