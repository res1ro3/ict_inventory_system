<?php 
    require_once('../dbConfig.php');
    session_start();
    $hardware_id = $_GET['hardware_id'];
    $_SESSION['selected_hid'] = $hardware_id;
    
    $sql="SELECT * FROM ict_transfer_tbl WHERE hardware_id = :hid";
    $query = $conn->prepare($sql);
    $query->bindParam(':hid',$hardware_id,PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $count=1;

        if($query->rowCount() > 0) {
        //In case that the query returned at least one record, we can echo the records within a foreach loop:
        foreach($results as $result)
        {
            $get_old_owner = $conn->prepare("SELECT * FROM `employee_tbl` WHERE employee_id = :id");
            $get_old_owner->execute(array(':id' => $result->employee_id_old));
            $old_owner=$get_old_owner->fetch(PDO::FETCH_ASSOC);

            $get_new_owner = $conn->prepare("SELECT * FROM `employee_tbl` WHERE employee_id = :id");
            $get_new_owner->execute(array(':id' => $result->employee_id_new));
            $new_owner=$get_new_owner->fetch(PDO::FETCH_ASSOC);

            $row = array(
                "transfer_id" => $result->transfer_id,
                "date_transferred" => $result->date_transferred,
                "old_owner" => $result->employee_id_old,
                "new_owner" => $result->employee_id_new
            );
        }}

        echo json_encode($row);

    // $sql = "
    //     SELECT hardware_id, mac_address, type_of_hardware, brand, model, serial_number, date_of_purchase, warranty, employee_tbl.employee_id, ict_network_hardware_tbl.status, ict_network_hardware_tbl.owner_name
    //     FROM ict_network_hardware_tbl
    //     INNER JOIN employee_tbl ON ict_network_hardware_tbl.employee_id=employee_tbl.employee_id
    //     WHERE hardware_id = :hid
    // ";
    // $query = $conn->prepare($sql);
    // $query->bindParam(':hid',$hardware_id,PDO::PARAM_STR);
    // $query->execute();
    // $row = $query->fetch(PDO::FETCH_ASSOC);
    // echo json_encode($row);
?>