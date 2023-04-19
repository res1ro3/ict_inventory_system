<?php
    require_once('../dbConfig.php');

    if (!isset($_POST['mac_address'], $_POST['current_owner'], $_POST['new_owner'])) {
        echo "Invalid Input";
        exit;
    }

    $mac_address = $_POST['mac_address'];
    $current_owner = $_POST['current_owner'];
    $new_owner = $_POST['new_owner'];

    date_default_timezone_set("Asia/Hong_Kong");
    // $date = date('h:i:sa');
    $date = date('m/d/Y');

    $sql="INSERT INTO ict_transfer_tbl (employee_id_new, employee_id_old, date_transferred, mac_address) VALUES (:new, :old, '".$date."', :mac)";
    $query = $conn->prepare($sql);
    $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    $query->bindParam(':old',$current_owner,PDO::PARAM_STR);
    $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    $query->execute();

    $sql="UPDATE ict_network_hardware_tbl SET employee_id=:new WHERE mac_address=:mac";
    $query = $conn->prepare($sql);
    $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {

        $response = 1;
    } else {
        $response = 0;
    }
    
    echo $response;
?>