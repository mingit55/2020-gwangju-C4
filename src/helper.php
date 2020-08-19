<?php
function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}

function user(){
    return isset($_SESSION['user']);
}

function go($url, $msg = ""){
    echo "<script>";
    if($msg !== "") echo "alert(`$msg`);";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($msg = ""){
    echo "<script>";
    if($msg !== "") echo "alert(`$msg`);";
    echo "history.back();";
    echo "</script>";
    exit;
}

function json_response($data = []){
    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function view($viewName, $data = []){
    extract($data);
    $filePath = VIEW."/$viewName.php";
    if(is_file($filePath)){
        require VIEW."/header.php";
        require $filePath;
        require VIEW."/footer.php";
    }
    exit;
}

function extname($filename){
    return strtolower(substr($filename, strrpos($filename, ".")));
}

function checkEmpty(){
    foreach($_POST as $input){
        if(!is_array($input) && trim($input) === "")    
            back("모든 정보를 입력해 주세요");
    }
}

function pager($data){
    define("PAGE__COUNT",  10);
    define("PAGE__BCOUNT",  5);

    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;
    
    $totalPage = ceil(count($data) / PAGE__COUNT);
    $currentBlock = ceil($page / PAGE__BCOUNT);

    $start = $currentBlock * PAGE__BCOUNT - PAGE__BCOUNT + 1;
    $start = $start < 1 ? 1 : $start;
    $end = $start + PAGE__BCOUNT - 1;
    $end = $end > $totalPage ? $totalPage : $end;

    $prevPage = $start - 1;
    $prev = $prevPage >= 1;
    
    $nextPage = $end + 1;
    $next = $nextPage <= $totalPage;
    
    $data = array_splice($data, ($page - 1) * PAGE__COUNT, PAGE__COUNT);

    return (object)compact("data", "page", "start", "end", "prev", "prevPage", "next", "nextPage");
}

function is_fimage($dirname, $filename){
    $filePath = dirname(ROOT)."$dirname/$filename";
    return is_file($filePath);
}