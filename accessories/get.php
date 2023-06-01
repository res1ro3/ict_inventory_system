<?php 
    require_once('../dbConfig.php');
    session_start();
    $accessories_id = $_GET['accessories_id'];
    $_SESSION['selected_aid'] = $accessories_id;

    $sql = "
        SELECT accessories_id, generic_name, brand, quantity, specifications, unit, accessories_tbl.employee_id, employee_tbl.lname, employee_tbl.fname
        FROM accessories_tbl
        INNER JOIN employee_tbl ON accessories_tbl.employee_id=employee_tbl.employee_id
        WHERE accessories_id = :aid
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':aid',$accessories_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>