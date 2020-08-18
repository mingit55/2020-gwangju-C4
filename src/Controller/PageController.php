<?php
namespace Controller;

use App\DB;

class PageController {
    // 메인
    function main(){
        view("main");
    }

    // 전북 대표 축제
    function mainFestival(){
        view("main-festival");
    }
    
    // 공지사항
    function notice(){
        view("notice");
    }

    // 찾아오시는 길
    function location(){
        require VIEW."/location.php";
    }

    // 환율 안내
    function exchangeGuide(){
        view("exchange-guide");
    }

    // 로그인 페이지
    function login(){
        view("login");
    }

    // 축제 현황 페이지
    function festivalList(){
        view("festival-list", [
            "festivals" => pager(
                DB::fetchAll("SELECT DISTINCT F.*, IFNULL(I.cnt, 0) cnt 
                                FROM festivals F
                                LEFT JOIN (SELECT COUNT(*) cnt, fid FROM images GROUP BY fid) I ON I.fid = F.id
                                ORDER BY F.id DESC")
            )
        ]);
    }

    // 축제 상세 보기
    function festivalDetail($id){
        $festival = DB::find("festivals", $id);
        if(!$festival) back("존재하지 않는 축제입니다.");
        $images = DB::fetchAll("SELECT * FROM images WHERE fid = ?", [$festival->id]);
        $comments = DB::fetchAll("SELECT * FROM comments WHERE fid = ?", [$festival->id]);
        
        view("festival-detail", compact("festival", "images", "comments"));
    }

    // 축제 등록 페이지
    function insertForm(){
        view("insert-form");
    }

    // 축제 수정 페이지
    function updateForm($id){
        $festival = DB::find("festivals", $id);
        $images = DB::fetchAll("SELECT * FROM images WHERE fid = ?", [$festival->id]);
        if(!$festival) back("존재하지 않는 축제입니다.");

        view("update-form", compact("festival", "images"));
    }

    // 일정 페이지
    function schedules(){
        $year = isset($_GET['year']) && is_numeric($_GET['year']) ? $_GET['year'] : date("Y");
        $month = isset($_GET['month']) && is_numeric($_GET['month']) ? $_GET['month'] : date("m");
        if(strtotime($year."-".$month."-1") === false){
            $year = date("Y");
            $month = date("m");
        }
        
        $t_firstDay = strtotime("$year-$month-1");
        $t_lastDay = strtotime("-1 Day", strtotime("+1 Month", $t_firstDay));
        
        $firstDay = date("Y-m-d", $t_firstDay);
        $lastDay = date("Y-m-d", $t_lastDay);

        $t_next = strtotime("+1 Month", $t_firstDay);
        $t_prev = strtotime("-1 Month", $t_firstDay);

        $data = DB::fetchAll("SELECT 
                                id, name, period,
                                IF(start_date < ?, 1, DATE_FORMAT(start_date, '%d')) startDay,
                                IF(end_date > ?, ?, DATE_FORMAT(end_date, '%d')) endDay,
                                (end_date - start_date) periodDay
                            FROM festivals
                            WHERE (? BETWEEN start_date AND end_date)
                            OR (? BETWEEN start_date AND end_date)
                            OR (start_date BETWEEN ? AND ?)
                            OR (end_date BETWEEN ? AND ?)", [
                                $firstDay, 
                                $lastDay, date("d", $t_lastDay),
                                $firstDay,
                                $lastDay,
                                $firstDay, $lastDay,
                                $firstDay, $lastDay
                            ]);
        view("schedules", compact("data", "year", "month", "t_firstDay", "t_lastDay", "firstDay", "lastDay", "t_next", "t_prev"));
    }

    function openApi(){
        view("open-api");
    }
}