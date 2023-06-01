<?php
    require_once('../dbConfig.php');

    $type_of_hardware = $_POST['type_of_hardware_id'];
    $name = $_POST['name'];

    $sql="UPDATE type_of_hardware_tbl SET name=:nm WHERE type_of_hardware_id=:thid";
    $query = $conn->prepare($sql);
    $query->bindParam(':thid',$type_of_hardware,PDO::PARAM_STR);
    $query->bindParam(':nm',$name,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
?>