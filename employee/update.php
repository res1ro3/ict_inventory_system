<?php
    require_once('../dbConfig.php');

    $eid = $_POST['employee_id'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $username = $_POST['username'];
    $sex = $_POST['sex'];
    $office = $_POST['unitOffice'];
    $position = $_POST['position'];
    $typeofemployment = $_POST['type_of_employment'];

    $sql="UPDATE employee_tbl SET lname=:ln, fname=:fn, username=:un, sex=:sx, unitOffice=:of, position=:pst, type_of_employment=:toe WHERE employee_id=:eid";
    $query = $conn->prepare($sql);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->bindParam(':ln',$lname,PDO::PARAM_STR);
    $query->bindParam(':fn',$fname,PDO::PARAM_STR);
    $query->bindParam(':un',$username,PDO::PARAM_STR);
    $query->bindParam(':sx',$sex,PDO::PARAM_STR);
    $query->bindParam(':of',$office,PDO::PARAM_STR);
    $query->bindParam(':pst',$position,PDO::PARAM_STR);
    $query->bindParam(':toe',$typeofemployment,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
    // if ($query->rowCount()) {
    //     echo "<script>
    //         alert('Updated Successfully');
    //         window.location.href='./manageAccounts.php';
    //     </script>";
    // } else {
    //     echo "<script>
    //         alert('An error occured');
    //         window.location.href='./manageAccounts.php';
    //     </script>";
    // }
?>