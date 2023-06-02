<?php 
    require_once('../dbConfig.php');
    session_start();
    $supply_tool_id = $_GET['supply_tool_id'];
    $_SESSION['selected_stid'] = $supply_tool_id;

    $sql = "
        SELECT supply_tools_id, type_of_supply_tools, quantity, specifications_remarks, unit, supplies_tools_tbl.employee_id, employee_tbl.lname, employee_tbl.fname
        FROM supplies_tools_tbl
        INNER JOIN employee_tbl ON supplies_tools_tbl.employee_id=employee_tbl.employee_id
        WHERE supply_tools_id = :stid
    ";
    $query = $conn->prepare($sql);
    $query->bindParam(':stid',$supply_tool_id,PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
?>