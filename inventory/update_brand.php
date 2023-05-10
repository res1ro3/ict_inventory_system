<?php
    require_once('../dbConfig.php');

    $brand_id = $_POST['brand_id'];
    $name = $_POST['name'];

    $sql="UPDATE brand_tbl SET name=:nm WHERE brand_id=:bi";
    $query = $conn->prepare($sql);
    $query->bindParam(':bi',$brand_id,PDO::PARAM_STR);
    $query->bindParam(':nm',$name,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
?>