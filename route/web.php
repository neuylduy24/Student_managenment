<?php
//routing : đường dẫn truy cập vào ứng dụng
//http://localhost/students/index.php?c=login&m=index
//c: tên của controller nằm trong thư mục controller
$c =  trim($_GET['c']??'login');
$c = ucfirst($c); //Viết hoa chữ cái đầu tiên
// vd : LoginController

switch($c){
    case'Login';
        require APP_PATH_CONTROLLER . 'LoginController.php';
    break;
    case 'Dashboard':
        require APP_PATH_CONTROLLER. 'DashboardController.php';
    break;
    case 'Department':
        require APP_PATH_CONTROLLER. 'DepartmentController.php';
        break;
    case 'Course':
        require APP_PATH_CONTROLLER. 'CourseController.php';
        break;
    default:
        echo 'Not found request';
    break;
}