<?php
if(!function_exists('isLoginUser')){
    function isLoginUser(){
        $sessionUsername = getSessionUsername();
        $sessionIdUser = getSessionIdUser();
        if(empty($sessionUsername) || empty($sessionIdUser)){
            return false;
        }
        return true;
    }
}