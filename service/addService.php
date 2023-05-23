<?php 

    require_once('../dbconfig.php');

    $type_of_services = $_POST['type_of_services'];
    $ICT_ID = $_POST['ICT_ID'];
    $date_received = $_POST['date_received'];
    $date_returned = $_POST['date_returned'];
    $description_of_service = $_POST['description_of_service'];
    $action_done = $_POST['action_done'];
    $remarks = $_POST['remarks'];
    $recommendation = $_POST['recommendation'];
    $type_of_ict = $_POST['type_of_ict'];
    $status = $_POST['status'];
    $processed_by = $_POST['processed_by'];

    $sql="INSERT INTO services_tbl(type_of_services, ICT_ID, date_received, date_returned, description_of_service, action_done, remarks, recommendation, type_of_ict, service_status, processed_by, employee_id) 
        VALUES(:tos, :ictid, :drec, :dret, :desc, :ad, :rm, :rec, :toi, :st, :prb, :eid)";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'tos' => $type_of_services,
        'ictid' => $ICT_ID,
        'drec' => $date_received,
        'dret' => $date_returned,
        'desc' => $description_of_service,
        'ad' => $action_done,
        'rm' => $remarks,
        'rec' => $recommendation,
        'toi' => $type_of_ict,
        'st' => $status,
        'prb' => $processed_by,
        'eid' => 1
    ));

    if($query->rowCount() == 1) {
        echo 'Service Added Successfully';
    } else {
        echo 'An error has occured';
    }
    
?>