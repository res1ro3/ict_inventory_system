<?php 

    require_once('../dbconfig.php');

    $type_of_services = $_POST['type_of_services'];
    $ICT_ID = $_POST['ICT_ID'];
    $date_received = $_POST['date_received'];
    $date_returned = $_POST['date_returned'];
    $description_of_service = $_POST['description_of_service'];
    $action_done = $_POST['action_done'];
    $recommendation = $_POST['recommendation'];
    $type_of_ict = $_POST['type_of_ict'];
    $processed_by = $_POST['processed_by'];

    $sql="INSERT INTO services_tbl(type_of_services, ICT_ID, date_received, date_returned, description_of_service, action_done, recommendation, type_of_ict, processed_by, employee_id) 
        VALUES(:tos, :ictid, :drec, :dret, :desc, :ad, :rec, :toi, :prb, :eid)";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'tos' => $type_of_services,
        'ictid' => $ICT_ID,
        'drec' => $date_received,
        'dret' => $date_returned,
        'desc' => $description_of_service,
        'ad' => $action_done,
        'rec' => $recommendation,
        'toi' => $type_of_ict,
        'prb' => $processed_by,
        'eid' => 'id1'
    ));

    if($query->rowCount() == 1) {
        echo 'Service Added Successfully';
    } else {
        echo 'An error has occured';
    }
    
?>