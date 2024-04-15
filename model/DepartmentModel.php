<?php
require "database/database.php";

function updateDepartmentById($name, $slug, $leader, $status, $beginDate, $logo, $id){
    // cập nhật lại múi giờ việt nam
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $db = connectionDb();
    $checkUpdate = false;
    $sql = "UPDATE `departments` SET `name`= :nameDepartment,`slug`= :slug,`leader`= :leader, `beginning_date`= :beginning_date,`status`= :statusDepartment,`logo`= :logo,`updated_at`= :updated_at WHERE `id`=:id AND `deleted_at`IS NULL";
    $updateTime = date('Y-m-d H:i:s');
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':nameDepartment', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':leader', $leader, PDO::PARAM_STR);
        $stmt->bindParam(':beginning_date', $beginDate, PDO::PARAM_STR);
        $stmt->bindParam(':statusDepartment', $status, PDO::PARAM_INT);
        $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updateTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkUpdate = true;
        }
    }
    disconnectionDb($db);
    return $checkUpdate;
}
function getDetailDepartmentById($id = 0){
    $db = connectionDb();
    $sql = "SELECT*FROM `departments`WHERE `id` = :id AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $infoDepartment = [];
    if($stmt){
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $infoDepartment = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    disconnectionDb($db);
    return $infoDepartment;
}

function deleteDepartmentById($id = 0){
    // cập nhật lại múi giờ việt nam
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db =  connectionDb();
    $sql = "UPDATE `departments` SET `deleted_at`= :deleted_at WHERE `id`=:id";
    $deletedAd = date("Y-m-d H:i:s");
    $stmt = $db->prepare($sql);
    $checkDelete = false;
    if($stmt){
        $stmt->bindParam(':deleted_at', $deletedAd, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkDelete = true;
        }
    }
    disconnectionDb($db);
    return $checkDelete;
}

function getAllDataDepartments($keyword = null){
    $db = connectionDb();
    $sql = "SELECT * FROM `departments` WHERE (`name` LIKE :keyword OR `leader` LIKE :leader) AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $key = "%{$keyword}%";
    $data = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':leader', $key, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() >0){
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $data;

}
function getAllDataDepartmentsByPage($keyword = null, $start = 0, $limit = LIMIT_ITEM_PAGE){
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT * FROM `departments` WHERE (`name` LIKE :keyword OR `leader` LIKE :leader) AND `deleted_at` IS NULL LIMIT :startData, :limitData";
    $stmt = $db->prepare($sql);
    $dataDepartments = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':leader', $key, PDO::PARAM_STR);
        $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limitData', $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() >0){
                $dataDepartments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataDepartments;
}
function insertDepartment($name, $leader, $status, $beginDate, $logo = null){
    $db = connectionDb();
    $flagInsert = false;
    $sqlInsert = "INSERT INTO `departments`(`name`, `slug`, `leader`, `beginning_date`, `status`, `logo`, `created_at`) VALUES(:nameDepartment, :slug, :leader, :beginning_date, :statusDepartment, :logo, :created_at)";
    $stmt = $db->prepare($sqlInsert);
    $currentDat = date('Y-m-d H:i:s');
    if ($stmt){
        $stmt->bindParam(':nameDepartment', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $name, PDO::PARAM_STR);
        $stmt->bindParam(':leader', $leader, PDO::PARAM_STR);
        $stmt->bindParam(':beginning_date', $beginDate, PDO::PARAM_STR);
        $stmt->bindParam(':statusDepartment', $status, PDO::PARAM_INT);
        $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $currentDat, PDO::PARAM_STR);
        if($stmt->execute()){
            $flagInsert=true;
        }
        disconnectionDb($db); // ngắt kết nối database
    }
    // $flagInsert là true : insert thành công và ngược lại
    return $flagInsert;
}