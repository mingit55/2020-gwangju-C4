<?php
namespace Controller;

use App\DB;
use \ZipArchive;
USE \PharData;

class ActionController {
    /**
     * 축제 정보 초기화
     * 
     * ※ 주의 할 점
     * 1. 데이터 중 dt와 location이 뒤바뀐 데이터가 있다.
     * 2. 데이터 중 dt의 양식이 혼자 다른 데이터가 있다. (Y.m.d ~ Y.m.d) 
     * 3. 시작일은 연말인데 종료일이 다음 연도로 넘어가는 경우가 있다.
     * 
     * */ 
    function initFestivals(){
        DB::query("DELETE FROM festivals");

        $xml = simplexml_load_file(ROOT."/resources/xml/festivalList.xml");
        foreach($xml->items->item as $item){
            $split = explode("~", $item->dt);
            $start_date = str_replace(".", "-", $split[0]);
            $end_date = substr($start_date, 0, 4)  . "-" . str_replace(".", "-", $split[1]);
            if(strtotime($start_date) > strtotime($end_date)){
                $year = (int)substr($start_date, 0, 4) + 1;
                $end_date = $year . "-" . str_replace(".", "-", $split[1]);
            }

            $imagePath = "/festivalImages/" . str_pad($item->sn, 3, '0', STR_PAD_LEFT) . "_". $item->no;

            DB::query("INSERT INTO festivals(
                id, no, name, area, location, period, start_date, end_date, content, imagePath
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $item->sn, $item->no, $item->nm, $item->area, $item->location, $item->dt, $start_date, $end_date, $item->cn, $imagePath
            ]);

            foreach($item->images->image as $image){
                DB::query("INSERT INTO images (fid, local_name, origin_name) VALUES (?, ?, ?)", [$item->sn, $image, $image]);
            }

            echo $item->nm . " 업로드 완료<br>";
        }
    }

    // 축제 이미지 보여주기
    function festivalImage($dirname, $filename){
        header("Content-Type: image/jpg");
        $filePath = FIMAGE."/$dirname/$filename";
        if(is_file($filePath)){
            readfile($filePath);
        }
    }

    
    // 로그인
    function login(){
        checkEmpty();
        extract($_POST);

        if($user_id !== "admin" || $password !== "admin") 
            back("아이디 또는 비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = true;
        go("/", "로그인 되었습니다.");
    }

    function logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    // 축제 추가
    function insertFestival(){
        checkEmpty();
        extract($_POST);
        $images = $_FILES['images'];
        $no = substr(time(), -5);

        // 입력 정보 확인
        if(!preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} ~ [0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $period)) 
            back("입력 형식에 맞춰 축제 기간을 작성해 주세요.\n(ex: 2020-01-01 ~ 2020-01-02)");
        $split = explode(" ~ ", $period);
        $start_date = date("Y-m-d", strtotime($split[0]));
        $end_date = date("Y-m-d", strtotime($split[1]));
        $period = str_replace("-", ".", $start_date) . "~"  . date("m.d", strtotime($end_date));
        if(strtotime($start_date) === false || strtotime($end_date) === false) back("올바른 축제 기간을 입력하세요.");

        for($i = 0; $i < count($images['name']); $i++){
            if(!$images['name'][$i]) continue;
            $extname = extname($images['name'][$i]);

            if(array_search($extname, [".jpg", ".gif", ".png"]) === false){
                back("jpg, png, gif 확장자 이미지만 업로드 가능합니다.");
            }
        }


        // 데이터 입력
        DB::query("INSERT INTO festivals(no, name, location, area, period, start_date, end_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?)", [$no, $name, $location, $area, $period, $start_date, $end_date]);
        $fid = DB::lastInsertId();
        $imagePath = "/festivalImages/". str_pad($fid, 3, "0", STR_PAD_LEFT) . "_" . $no;
        if(!is_dir(dirname(ROOT).$imagePath)){
            mkdir(dirname(ROOT).$imagePath);
        }
        
        DB::query("UPDATE festivals SET imagePath = ? WHERE id = ?", [$imagePath, $fid]);

        
        // 이미지 업로드
        for($i = 0; $i < count($images['name']); $i++){
            if(!$images['name'][$i]) continue;
            $name = $images['name'][$i];
            $extname = extname($name);
            $tmpname = $images['tmp_name'][$i];
            $filename = $i. "_". time() . $extname;
            
            move_uploaded_file($tmpname, dirname(ROOT).$imagePath."/$filename");
            DB::query("INSERT INTO images(fid, local_name, origin_name) VALUES (?, ?, ?)", [$fid, $filename, $name]);
        }

        exit;
        go("/festivals", "축제가 등록되었습니다.");
    }

    // 축제 수정
    function updateFestival($id){
        $festival = DB::find("festivals", $id);
        if(!$festival) back("존재하지 않는 축제입니다.");

        checkEmpty();
        extract($_POST);
        $images = $_FILES['add_images'];

        // 입력 정보 확인
        if(!preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} ~ [0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $period)) 
            back("입력 형식에 맞춰 축제 기간을 작성해 주세요.\n(ex: 2020-01-01 ~ 2020-01-02)");
        $split = explode(" ~ ", $period);
        $start_date = date("Y-m-d", strtotime($split[0]));
        $end_date = date("Y-m-d", strtotime($split[1]));
        $period = str_replace("-", ".", $start_date) . "~"  . date("m.d", strtotime($end_date));
        if(strtotime($start_date) === false || strtotime($end_date) === false) back("올바른 축제 기간을 입력하세요.");

        for($i = 0; $i < count($images['name']); $i++){
            if(!$images['name'][$i]) continue;
            $extname = extname($images['name'][$i]);

            if(array_search($extname, [".jpg", ".gif", ".png"]) === false){
                back("jpg, png, gif 확장자 이미지만 업로드 가능합니다.");
            }
        }
        
        // 데이터 수정
        DB::query("UPDATE festivals SET name = ?, area = ?, location = ?, period = ?, start_date = ?, end_date = ? WHERE id = ?", [$name, $area, $location, $period, $start_date, $end_date, $id]);
    
        // 기존 이미지 삭제
        if(isset($remove_images)){
            foreach($remove_images as $iid) {
                $image = DB::find("images", $iid);
                $filePath = ROOT.$festival->imagePath."/{$image->local_name}";
                if(is_file($filePath))
                    unlink($filePath);
                DB::query("DELETE FROM images WHERE id = ?", [$iid]);
            }
        }

        // 추가 이미지 업로드
        for($i = 0; $i < count($images['name']); $i++){
            if(!$images['name'][$i]) continue;
            $name = $images['name'][$i];
            $extname = extname($name);
            $tmpname = $images['tmp_name'][$i];
            $filename = $i. "_". time() . $extname;
            
            move_uploaded_file($tmpname, dirname(ROOT).$festival->imagePath."/$filename");
            DB::query("INSERT INTO images(fid, local_name, origin_name) VALUES (?, ?, ?)", [$festival->id, $filename, $name]);
        }

        go("/festivals", "축제가 수정되었습니다.");
    }

    function deleteFestival($id){
        $festival = DB::find("festivals", $id);
        if(!$festival) back("존재하지 않는 축제입니다.");

        $images = DB::fetchAll("SELECT * FROM images WHERE fid = ?", [$festival->id]);
        
        DB::query("DELETE FROM festivals WHERE id = ?", [$id]);

        foreach($images as $image)
            unlink(ROOT."{$festival->imagePath}/{$image->local_name}");

        if(is_dir(ROOT.$festival->imagePath))
            rmdir(ROOT.$festival->imagePath);
        
        
        go("/festivals", "축제가 삭제되었습니다.");
    }

    // 이미지 다운로드
    function downloadFestival($type, $id){
        $festival = DB::find("festivals", $id);
        if(!$festival) back("존재하지 않는 축제입니다.");
        if(array_search($type, ['tar', 'zip']) === false) back("올바른 압축 방식을 명시해 주세요.");
       
        $images = DB::fetchAll("SELECT local_name, origin_name, CONCAT(imagePath, '/', local_name) filePath
                                FROM images I
                                LEFT JOIN festivals F ON F.id = I.fid
                                WHERE i.fid = ?", [$festival->id]);
        if(count($images) == 0) back("압축할 이미지를 찾을 수 없습니다.");
        
        $filePath = ROOT.$festival->imagePath."/". time() . ".$type";

        if($type === "zip") {
            $zip = new ZipArchive();
            $zip->open($filePath, ZipArchive::CREATE);
            foreach($images as $image){
                if(is_file(ROOT.$image->filePath))
                    $zip->addFile(ROOT.$image->filePath, $image->origin_name);
            }
            $zip->close();
        }
        if($type === "tar") {
            $tar = new PharData($filePath);
            foreach($images as $image){
                if(is_file(ROOT.$image->filePath))
                    $tar->addFile(ROOT.$image->filePath, $image->origin_name);
            }
        }

        header("Content-Disposition: attachment; filename={$festival->name}.{$type}");
        readfile($filePath);
        sleep(1);
        unlink($filePath);
    }

    // 후기 등록
    function insertComment($fid){
        $festival = DB::find("festivals", $fid);
        if(!$festival) back("존재하지 않는 축제입니다.");
        checkEmpty();
        extract($_POST);
        
        DB::query("INSERT INTO comments(fid, user_name, score, content) VALUES (?, ?, ?, ?)", [$fid, $user_name, $score, $content]);
        go("/festivals/$fid", "후기를 등록했습니다.");
    }

    // 후기 삭제
    function deleteComment($fid, $id){
        $festival = DB::find("festivals", $fid);
        if(!$festival) back("존재하지 않는 축제입니다.");
        $comment = DB::find("comments", $id);
        if(!$comment) back("존재하지 않는 후기입니다.");

        DB::query("DELETE FROM comments WHERE id = ?", [$id]);
        go("/festivals/$fid", "후기를 삭제했습니다");
    }
}