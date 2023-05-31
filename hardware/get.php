<?php 
    require_once('../dbConfig.php');
    session_start();
    $hardware_id = $_GET['hardware_id'];
    $_SESSION['selected_hid'] = $hardware_id;

    $sql = "
        SELECT hardware_id, mac_address, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, employee_tbl.employee_id, ict_network_hardware_tbl.status, ict_network_hardware_tbl.owner_name
        FROM ict_network_hardware_tbl
        INNER JOIN employee_tbl ON ict_network_hardware_tbl.employee_id=employee_tbl.employee_id
        WHERE hardware_id = :hid
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':hid',$hardware_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>