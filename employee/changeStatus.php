<?php 

    require_once('../dbConfig.php');

    $eid = $_POST['employee_id'];
    $userStatus = $_POST['status'];

    $userStatus == "Active" ? $status = "Inactive" : $status = "Active";

    $sql="UPDATE employee_tbl SET status=:st WHERE employee_id=:eid";
    $query = $conn->prepare($sql);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->bindParam(':st',$status,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo $userStatus == 'Active' ? 'Deactivated Successfully' : 'Activated Successfully';
    } else {
        echo 'An error occurred';
    }

?>