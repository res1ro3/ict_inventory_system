<?php 

    require_once('../dbConfig.php');

    $ictid = $_POST['ictid'];
    $status = $_POST['status'];
    $services_id = $_POST['services_id'];

    $sql="UPDATE services_tbl SET service_status=:st WHERE ICT_ID=:ictid AND services_id=:sid";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'ictid' => $ictid,
        'sid' => $services_id,
        'st' => $status
    ));

    if ($query->rowCount()) {
        echo 'Status Changed successfully';
    } else {
        echo 'An error occurred';
    }

?>