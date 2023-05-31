<?php
    require_once('../dbConfig.php');

    if (!isset($_POST['software_id'], $_POST['current_owner'], $_POST['new_owner'])) {
        echo "Invalid Input";
        exit;
    }

    $software_id = $_POST['software_id'];
    $current_owner = $_POST['current_owner'];
    $new_owner = $_POST['new_owner'];

    // $response = [$mac_address, $current_owner, $new_owner];

    date_default_timezone_set("Asia/Hong_Kong");
    // $date = date('h:i:sa');
    $date = date('Y-m-d');

    // $sql="INSERT INTO ict_transfer_tbl (employee_id_old, employee_id_new, date_transferred, mac_address, new_owner, old_owner) VALUES (1,1,'".$date."', :mac, :new, :old)";
    // $query = $conn->prepare($sql);
    // $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    // $query->bindParam(':old',$current_owner,PDO::PARAM_STR);
    // $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    // $res = $query->execute();

    $sql="INSERT INTO ict_transfer_tbl (employee_id_new, employee_id_old, date_transferred, software_id) VALUES (:new, :old, '".$date."', :sid)";
    $query = $conn->prepare($sql);
    $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    $query->bindParam(':old',$current_owner,PDO::PARAM_STR);
    $query->bindParam(':sid',$software_id,PDO::PARAM_STR);
    $query->execute();

    // $sql="UPDATE ict_network_hardware_tbl SET owner_name = :new WHERE mac_address=:mac";
    // $query = $conn->prepare($sql);
    // $query->bindParam(':mac',$mac_address,PDO::PARAM_STR);
    // $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    // $query->execute();

    $sql="UPDATE software_tbl SET employee_id=:new WHERE software_id=:sid";
    $query = $conn->prepare($sql);
    $query->bindParam(':sid',$software_id,PDO::PARAM_STR);
    $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        $response = 1;
    } else {
        $response = 0;
    }
    
    echo json_encode($response);
?>