<?php

$m = trim($_GET['m'] ?? 'index');
$m = strtolower($m); //chuyển về chữ thường

switch($m){
    case 'index';
        index();
    break;
    default:
        index();
    break;
}

function index(){
    if(!isLoginUser()){
        header("Location:index.php");
        exit();
    }
    //load view
    require APP_PATH_VIEW. 'dashboard/index_view.php';
}