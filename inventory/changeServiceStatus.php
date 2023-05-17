<?php 

    require_once('../dbConfig.php');

    $ictid = $_POST['ictid'];
    $status = $_POST['status'];

    $sql="UPDATE services_tbl SET service_status=:st WHERE ICT_ID=:ictid";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'ictid' => $ictid,
        'st' => $status
    ));

    if ($query->rowCount()) {
        echo 'Status Changed successfully';
    } else {
        echo 'An error occurred';
    }

?>