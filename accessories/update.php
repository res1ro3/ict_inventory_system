<?php
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    require_once('../dbConfig.php');

    $accessories_id = $_POST['accessories_id'];
    $generic_name = $_POST['generic_name'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $specifications = $_POST['specifications'];
    $unit = $_POST['unit'];
    $employee_id = $_POST['employee_id'];

    $sql="UPDATE accessories_tbl SET generic_name=:gn, brand=:brand, quantity=:qty, specifications=:specs, unit=:unit, employee_id=:eid WHERE accessories_id=:aid";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'aid' => $accessories_id,
        'gn' => $generic_name,
        'brand' => $brand,
        'qty' => $quantity,
        'specs' => $specifications,
        'unit' => $unit,
        'eid' => $employee_id
    ));

    if ($query->rowCount()) {
        echo "Updated Successfully";
    } else {
        echo "An error occured";
    }
?>