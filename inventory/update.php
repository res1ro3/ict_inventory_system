<?php
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
    $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    $query->bindParam(':toh',$type_of_hardware,PDO::PARAM_STR);
    $query->bindParam(':br',$brand,PDO::PARAM_STR);
    $query->bindParam(':md',$model,PDO::PARAM_STR);
    $query->bindParam(':sn',$serial_number,PDO::PARAM_STR);
    $query->bindParam(':dop',$date_of_purchase,PDO::PARAM_STR);
    $query->bindParam(':wt',$warranty,PDO::PARAM_STR);
    $query->bindParam(':eid',$employee_id,PDO::PARAM_STR);
    $query->bindParam(':st',$status,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
?>