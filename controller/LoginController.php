<?php
require "model/LoginModel.php";//import model

//http://localhost/students/index.php?c=login&m=index
// m : tên hàm nằm trong controller
// vd : index
$m = trim($_GET['m'] ?? 'index');
$m = strtolower($m); //chuyển về chữ thường

switch($m){
    case'index':
        index();
    break;
    case'handle':
        handleLogin();
    break;
    case 'logout':
        handleLogout();
        break;
    default:
        echo 'Not found request';
    break;
}

function handleLogout(){
    if(isset($_POST['btnLogout'])){
        //nguoi dung muon logout ra ngoài
        // xóa hết các session đã tạo ra ở login
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['phone']);
        unset($_SESSION['idAccount']);
        unset($_SESSION['idUser']);
        unset($_SESSION['idRole']);
        // quay về lại trang đăng nhập
        header("Location:index.php");
    }
}
function index(){
    if(isLoginUser()){
        header("Location:index.php?c=dashboard");
        exit();
    }
    //Load view
    require APP_PATH_VIEW . 'login/index_view.php';
}
function handleLogin(){
    //kiểm tra người dùng đã login chưa
    if(isset($_POST['btnLogin'])){
        //lấy thông tin tài khoản
        $username = trim($_POST['username'] ?? null);
        $username = strip_tags($username);

        //lấy thông tin mật khẩu
        $password = trim($_POST['password'] ?? null);
        $password = strip_tags($password);

        if(empty($username) || empty($password)){
            // người dùng ko nhập đủ thông tin
            //quay về lại trang login
            header("Location:index.php?state=error");
        }else{
            //người dùng có nhập đủ thông tin
            $userInfo = checkLoginUser($username, $password);
            if(empty($userInfo)){
                // tài khoản ko tồn tại trong db
                header("Location:index.php?state=fail");
            }else{
                //tài khoản có tồn tại trong db
                //lưu các thông tin người dùng vào mảng session
                $_SESSION['username'] = $userInfo['username'];
                $_SESSION['email'] = $userInfo['email'];
                $_SESSION['phone'] = $userInfo['phone'];
                $_SESSION['idAccount'] = $userInfo['id'];
                $_SESSION['idUser'] = $userInfo['user_id'];
                $_SESSION['idRole'] = $userInfo['role_id'];
                header("Location:index.php?c=dashboard");
            }  
        }
    }
}
