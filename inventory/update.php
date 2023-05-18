<?php
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    require_once('../dbConfig.php');

    $mac_address = $_POST['mac_address'];
    $type_of_hardware = $_POST['type_of_hardware'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $date_of_purchase = $_POST['date_of_purchase'];
    $warranty = $_POST['warranty'];
    $employee_id = $_POST['employee_id'];
    $status = $_POST['status'];

    $sql="UPDATE ict_network_hardware_tbl SET mac_address=:mac, type_of_hardware=:toh, brand=:br, model=:md, serial_number=:sn, date_of_purchase=:dop, warranty=:wt, employee_id=:eid, status=:st WHERE mac_address=:mac";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'mac' => $mac_address,
        'toh' => $type_of_hardware,
        'br' => $brand,
        'md' => $model,
        'sn' => $serial_number,
        'dop' => $date_of_purchase,
        'wt' => $warranty,
        'eid' => $employee_id,
        'st' => $status
    ));

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
?>