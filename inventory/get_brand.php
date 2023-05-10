<?php 
    require_once('../dbConfig.php');

    $brand_id = $_POST['brand_id'];

    $sql = "
        SELECT * FROM brand_tbl WHERE brand_id = :bi
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':bi',$brand_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>