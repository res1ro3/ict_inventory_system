<?php
    require_once('../dbConfig.php');

    $eid = $_POST['employee_id'];
    $pass = "12345678";

    $sql="UPDATE employee_tbl SET password=:ps WHERE employee_id=:eid";
    $query = $conn->prepare($sql);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->bindParam(':ps',$pass,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Password reset successful";
    } else {
        echo "An error occured";
    }
?>