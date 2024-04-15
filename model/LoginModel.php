<?php
// nơi xử lý truy vấn dữ liệu
require "database/database.php";

// viết hàm kiểm tra tài khoản của người dùng đăng nhập có tồn tại trong database hay không
 function checkLoginUser($username, $password){
    //$username và $password : dữ liệu người dùng đăng nhập từ form login
    $db = connectionDb(); // biến kết nối cơ sở dữ liệu 
    $userInfo = []; // mảng dùng để chứa thông tin tài khoản người dùng
    $sql = "SELECT a.*, u.`full_name`, u.`email`, u.`phone`, u.`extra_code` FROM `accounts` AS a INNER JOIN `users` AS u ON a.`user_id` = u.`id` WHERE a.`username` = :user AND a.`password` = :pass AND a.`status` = 1 LIMIT 1 ";
    $statement = $db->prepare($sql); //kiểm tra câu lệnh sql(chuỗi)
    if($statement){
        // kiểm tra tham số truyền câu lệnh sql
        $statement->bindParam(':user', $username, PDO::PARAM_STR);
        $statement->bindParam(':pass', $password, PDO::PARAM_STR);

        //thực thi sql
        if($statement->execute()){
            //kiểm tra xem có dữ liệu trả về không
            if($statement->rowCount() > 0){
                $userInfo = $statement->fetch(PDO::FETCH_ASSOC);
            }
        }
     }
     //ngắt kết nối tới CSDL
     disconnectionDb($db);
     return $userInfo; 
     // $userInfo : trả về là mảng rỗng thì tại khoản đăng nhập ko tồn tại và ngược lại
 }
 