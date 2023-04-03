<?php
    require_once('../dbConfig.php');

    if (!isset($_POST['mac_address'], $_POST['current_owner'], $_POST['new_owner'])) {
        echo "Invalid Input";
        exit;
    }

    $mac_address = $_POST['mac_address'];
    $current_owner = $_POST['current_owner'];
    $new_owner = $_POST['new_owner'];
    
    $sql="UPDATE ict_network_hardware_tbl SET employee_id=:new WHERE mac_address=:mac";
    $query = $conn->prepare($sql);
    $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Transfered Successfully";
    } else {
        echo "No rows were affected";
    }
?>