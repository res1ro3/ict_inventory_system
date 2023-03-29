<?php 
    require_once('../dbConfig.php');

    $employeeId = $_GET['eid'];

    $sql = "SELECT * FROM employee_tbl WHERE employee_id = :eid";
    $query = $conn->prepare($sql);
    $query->bindParam(':eid',$employeeId,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>