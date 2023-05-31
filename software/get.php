<?php 
    require_once('../dbConfig.php');
    session_start();
    $software_id = $_GET['software_id'];
    $_SESSION['selected_sid'] = $software_id;

    $sql = "
        SELECT software_id, type_of_software, software_name, manufacturer, type_of_subscription, date_developed_purchased, software_tbl.employee_id, employee_tbl.lname, employee_tbl.fname, owner_name
        FROM software_tbl
        INNER JOIN employee_tbl ON software_tbl.employee_id=employee_tbl.employee_id
        WHERE software_id = :sid
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':sid',$software_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>