<?php
require "database/database.php";

function updateCourseById(
    $departmentId,
    $name,
    $slug,
    $description,
    $status,
    $id
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $checkUpdate = false;   
    $sql = "UPDATE `courses` SET `department_id` = :departmentId, `name` = :nameCourse, `slug` = :slug, `description` = :descriptionCourse, `status` = :statusCourse, `updated_at` = :updated_at WHERE `id` = :id AND `deleted_at` IS NULL";
    $updateTime = date('Y-m-d H:i:s');
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':nameCourse', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':descriptionCourse', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statusCourse', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updateTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkUpdate = true;
        }
    }
    disconnectionDb($db);
    return $checkUpdate;
}

function getDetailCourseById($id = 0){
    $db = connectionDb();
    $sql = "SELECT * FROM `courses` WHERE `id` = :id AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $infoCourse = [];
    if($stmt){
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $infoCourse = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }   
    }
    disconnectionDb($db);
    return $infoCourse;
}

function deleteCourseById($id = 0){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db =  connectionDb();
    $sql = "UPDATE `courses` SET `deleted_at`= :deleted_at WHERE `id`=:id";
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
function getAllDataCoursesByMyPage($keyword=null ,$start =0, $limit =LIMIT_ITEM_PAGE)
{
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT departments.name AS department_name, courses. * 
            FROM departments
            INNER JOIN courses ON departments.id = courses.department_id
            WHERE (courses.`name` LIKE :keyword OR courses.`slug` LIKE :keywordSlug OR departments.`name` LIKE :keywordNameDepartment) AND departments.`deleted_at` IS NULL 
            LIMIT :startData,:limitData";
    $stmt = $db->prepare($sql);
    $dataCourses = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':keywordSlug', $key, PDO::PARAM_STR);
        $stmt->bindParam(':keywordNameDepartment', $key, PDO::PARAM_STR);
        $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limitData', $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $dataCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataCourses;
}

function getAllDataCourses($keyword = null){
    $db = connectionDb();
    $key = "%{$keyword}%";
    $sql = "SELECT departments.name AS department_name, courses.* 
            FROM departments
            INNER JOIN courses ON departments.id = courses.department_id
             WHERE (courses.`name` LIKE :keyword OR courses.`slug` LIKE :keywordSlug OR departments.`name` LIKE :keywordNameDepartment) AND departments.`deleted_at` IS NULL ";
    $stmt = $db->prepare($sql);
    $dataCourses = [];
    if($stmt){
        $stmt->bindParam(':keyword', $key, PDO::PARAM_STR);
        $stmt->bindParam(':keywordSlug', $key, PDO::PARAM_STR);
        $stmt->bindParam(':keywordNameDepartment', $key, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $dataCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataCourses;
}

function insertCourse(
    $departmentId,
    $name,
    $slug,
    $description,
    $status
) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $db = connectionDb();
    $flagInsert = false;
    $sqlInsert = "INSERT INTO `courses`(`department_id`, `name`, `description`, `status`, `created_at`) VALUES(:departmentId, :nameCourse, :descriptionCourse, :statusCourse, :created_at)";
    $stmt = $db->prepare($sqlInsert);
    $currentDate = date('Y-m-d H:i:s');
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $stmt->bindParam(':nameCourse', $name, PDO::PARAM_STR);
        // $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':descriptionCourse', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statusCourse', $status, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $currentDate, PDO::PARAM_STR);
        if($stmt->execute()){
            $flagInsert = true;
        }
        disconnectionDb($db);
    }
    return $flagInsert;
}

function detailName (){
    $db = connectionDb();
    $sql = "SELECT * FROM `departments` WHERE `deleted_at` IS NULL ";
    $stmt = $db->prepare($sql);
    $dataCourses = [];
    if($stmt){
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $dataCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectionDb($db);
    return $dataCourses;
}