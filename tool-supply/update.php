<?php
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }

    require_once('../dbConfig.php');

    $supply_tools_id = $_POST['supply_tools_id'];
    $type_of_supply_tools = $_POST['type_of_supply_tools'];
    $quantity = $_POST['quantity'];
    $specifications = $_POST['specifications'];
    $unit = $_POST['unit'];
    $employee_id = $_POST['employee_id'];

    $sql="UPDATE supplies_tools_tbl SET type_of_supply_tools=:type, quantity=:qty, specifications_remarks=:specs, unit=:unit, employee_id=:eid WHERE supply_tools_id=:stid";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'stid' => $supply_tools_id,
        'type' => $type_of_supply_tools,
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