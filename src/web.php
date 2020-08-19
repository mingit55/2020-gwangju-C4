<?php
use App\Router;

/**
 * 페이지
 */

Router::get("/", "PageController@main");
Router::get("/main-festival", "PageController@mainFestival");
Router::get("/notice", "PageController@notice");
Router::get("/location.php", "PageController@location");
Router::get("/exchange-guide", "PageController@exchangeGuide");
Router::get("/login", "PageController@login");
Router::get("/festivals/insert-form", "PageController@insertForm", "user");
Router::get("/festivals/update-form/{id}", "PageController@updateForm", "user");
Router::get("/festivals", "PageController@festivalList");
Router::get("/festivals/{id}", "PageController@festivalDetail");
Router::get("/schedules", "PageController@schedules");
Router::get("/open-api", "PageController@openApi");

/**
 * 동작
 */
Router::get("/init/festivals", "ActionController@initFestivals", "user");
Router::get("/festivalImages/{dirname}/{filename}", "ActionController@festivalImage");
Router::post("/login", "ActionController@login");
Router::get("/logout", "ActionController@logout", "user");
Router::post("/insert/festivals", "ActionController@insertFestival", "user");
Router::post("/update/festivals/{id}", "ActionController@updateFestival", "user");
Router::get("/delete/festivals/{id}", "ActionController@deleteFestival", "user");
Router::get("/download/{type}/{id}", "ActionController@downloadFestival");
Router::post("/insert/festivals/{fid}/comments", "ActionController@insertComment");
Router::get("/delete/festivals/{id}/comments/{id}", "ActionController@deleteComment", "user");

/**
* API
*/
Router::get("/api/festivals", "ApiController@getFestivalList");
Router::get("/restAPI/currentExchangeRate.php", "ApiController@getExchangeRate");
Router::get("/openAPI/festivalList.php", "ApiController@getFestivalListByDate");


Router::start();