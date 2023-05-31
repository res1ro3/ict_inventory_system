<?php 
    require_once('../dbConfig.php');

    $type_of_hardware_id = $_POST['type_of_hardware_id'];

    $sql = "
        SELECT * FROM type_of_hardware_tbl WHERE type_of_hardware_id = :th
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':th',$type_of_hardware_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>