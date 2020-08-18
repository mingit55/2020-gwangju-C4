location.getQueryString = function(){
    let search = this.search.substr(1);
    return search.split("&").reduce((obj, item) => {
        let [key, value] = item.split("=");
        obj[key] = value;
        return obj;
    }, {});
};

$(function(){
    $("[data-target='#road-modal']").on("click", e => {
        e.preventDefault();
        e.stopPropagation();

        let timeout = false;

        setTimeout(() => {
            if(timeout === false){
                alert("찾아오시는 길을 표시할 수 없습니다.");
                timeout = true;
            }
        }, 1000);

        fetch("/location.php")
        .then(res => res.text())
        .then(html => {
            if(timeout == false){
                $("#road-modal .modal-body").html($(html));
                $("#road-modal").modal("show");
                timeout = true;
            }
        });
    });

    $(".custom-file-input").on("change", e => {
        let files = e.target.files;
        let $label = $(e.target).siblings(".custom-file-label");
        if(files.length == 1) $label.text(files[0].name);
        else if(files.length > 1) $label.text(`${files[0].name} 외 ${files.length-1}개의 파일`);
        else $label.text("업로드 할 파일을 선택하세요");
    });
});