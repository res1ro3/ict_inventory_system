<?php 
    require_once('../dbConfig.php');
    session_start();
    $services_id = $_GET['services_id'];

    $sql = "
        SELECT * FROM services_tbl WHERE services_id = :sid
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':sid',$services_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>