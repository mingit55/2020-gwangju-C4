<?php
namespace App;

class Router {
    static $pages = [];
    static function __callStatic($name, $args){
        if($name === strtolower($_SERVER['REQUEST_METHOD'])){
            self::$pages[] = $args;
        }
    }

    static function start(){
        $current_url = explode("?", $_SERVER['REQUEST_URI'])[0];
        foreach(self::$pages as $page) {
            $regex = preg_replace("/{[^\/]+}/", "([^/]+)", $page[0]);
            $regex = preg_replace("/\//", "\\/", $regex);
            if(preg_match("/^".$regex."$/", $current_url, $matches)){
                if(isset($page[2]) && $page[2] === "user" && !user()) go("/", "로그인 후 이용하실 수 있습니다.");
                unset($matches[0]);
                $action = explode("@", $page[1]);
                $conName = "Controller\\{$action[0]}";
                $con = new $conName();
                $con->{$action[1]}(...$matches);
                exit;
            }
        }
        http_response_code(404);
    }
}