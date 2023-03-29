<?php
    require_once('../dbConfig.php');

    $employeeId = $_POST['employeeId'];
    $lname = $_POST['lnameInp'];
    $fname = $_POST['fnameInp'];
    $username = $_POST['usernameInp'];
    $password = $_POST['passwordInp'];
    $sex = $_POST['sexInp'];
    $office = $_POST['officeInp'];
    $position = $_POST['positionInp'];
    $typeofemployment = $_POST['typeOfEmploymentInp'];
    $typeofaccount = $_POST['typeOfAccountInp'];

    $sql="UPDATE employee_tbl SET lname=:ln, fname=:fn, username=:un, password=:ps, sex=:sx, unitOffice=:of, position=:pst, type_of_employment=:toe, type_of_account=:toa WHERE employee_id=:eid";
    $query = $conn->prepare($sql);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->bindParam(':ln',$lname,PDO::PARAM_STR);
    $query->bindParam(':fn',$fname,PDO::PARAM_STR);
    $query->bindParam(':un',$username,PDO::PARAM_STR);
    $query->bindParam(':ps',$password,PDO::PARAM_STR);
    $query->bindParam(':sx',$sex,PDO::PARAM_STR);
    $query->bindParam(':of',$office,PDO::PARAM_STR);
    $query->bindParam(':pst',$position,PDO::PARAM_STR);
    $query->bindParam(':toe',$typeofemployment,PDO::PARAM_STR);
    $query->bindParam(':toa',$typeofaccount,PDO::PARAM_STR);
    $query->execute();

    echo $query->rowCount();
?>