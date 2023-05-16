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
    $employee_id = $_POST['employee_id'];
    $processed_by = $_POST['processed_by'];

    $sql="INSERT INTO services_tbl(type_of_services, ICT_ID, date_received, date_returned, description_of_service, action_done, recommendation, type_of_ict, employee_id, processed_by) 
        VALUES(:tos, :ictid, :drec, :dret, :desc, :ad, :rec, :toi, :eid, :prb)";
    $query = $conn->prepare($sql);

    $query->bindParam(':tos',$type_of_services,PDO::PARAM_STR);
    $query->bindParam(':ictid',$ICT_ID,PDO::PARAM_STR);
    $query->bindParam(':drec',$date_received,PDO::PARAM_STR);
    $query->bindParam(':dret',$date_returned,PDO::PARAM_STR);
    $query->bindParam(':desc',$description_of_service,PDO::PARAM_STR);
    $query->bindParam(':ad',$action_done,PDO::PARAM_STR);
    $query->bindParam(':rec',$recommendation,PDO::PARAM_STR);
    $query->bindParam(':toi',$type_of_ict,PDO::PARAM_STR);
    $query->bindParam(':eid',$employee_id,PDO::PARAM_STR);
    $query->bindParam(':prb',$processed_by,PDO::PARAM_STR);

    $query->execute();

    if($query->rowCount() == 1) {
        echo '<script>alert("Service Added Successfully")</script>';
    } else {
        echo '<script>alert("An error has occured")</script>';
    }

?>