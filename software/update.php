<?php
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    require_once('../dbConfig.php');

    $software_id = $_POST['software_id'];
    $type_of_software = $_POST['type_of_software'];
    $software_name = $_POST['software_name'];
    $manufacturer = $_POST['manufacturer'];
    $type_of_subscription = $_POST['type_of_subscription'];
    $date_developed_purchased = $_POST['date_developed_purchased'];
    $employee_id = $_POST['employee_id'];

    $sql="UPDATE software_tbl SET type_of_software=:tosoft, software_name=:sn, manufacturer=:man, type_of_subscription=:tosubs, date_developed_purchased=:dt, employee_id=:eid WHERE software_id=:sid";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'sid' => $software_id,
        'tosoft' => $type_of_software,
        'sn' => $software_name,
        'man' => $manufacturer,
        'tosubs' => $type_of_subscription,
        'dt' => $date_developed_purchased,
        'eid' => $employee_id
    ));

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
?>