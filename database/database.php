<?php
// dung thu vien PDO cua PHP de lam viec voi data base(MySQL)

//viet ham ket noi voi so so du lieu
function connectionDb(){
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=student_management1', 'root', '');
        return $dbh;
    } catch (PDOException $e) {
        // attempt to retry the connection after some timeout for example
        echo "Can not connect to database";
        echo "<br/>";
        echo "<pre>";
        print_r($e);
        die();
    }
}

// ngắt kết nối database
function disconnectionDb($connection){
    $connection = null;
}