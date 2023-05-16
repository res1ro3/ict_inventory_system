<?php 
    require_once('../dbConfig.php');

    $mac_address = $_GET['mac_address'];

    session_start();
    $_SESSION['selected_mac'] = $mac_address;

    $sql = "
        SELECT mac_address, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, employee_tbl.employee_id, ict_network_hardware_tbl.status, ict_network_hardware_tbl.owner_name
        FROM ict_network_hardware_tbl
        INNER JOIN employee_tbl ON ict_network_hardware_tbl.employee_id=employee_tbl.employee_id
        WHERE mac_address = :mac
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>