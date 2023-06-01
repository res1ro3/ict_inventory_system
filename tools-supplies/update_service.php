<?php
    require_once('../dbConfig.php');
    
    $services_id = $_POST['servicesIdEditInp'];
    $type_of_services = $_POST['typeofserviceEditInp'];
    $date_received = $_POST['datereceivedEditInp'];
    $date_returned = $_POST['datereturnedEditInp'];
    $description_of_service = $_POST['descriptionEditInp'];
    $remarks = $_POST['remarksEditInp'];
    $recommendation = $_POST['recommendationEditInp'];
    $service_status = $_POST['statusEditInp'];
    $processed_by = $_POST['processedbyEditInp'];

    $sql="UPDATE services_tbl 
        SET type_of_services = :tos,
            date_received = :drec,
            date_returned = :dret,
            description_of_service = :descr,
            remarks = :rem,
            recommendation = :rec,
            service_status = :st,
            processed_by = :pb
        WHERE services_id=:sid";
    $query = $conn->prepare($sql);
    $query->execute(array(
        'sid' => $services_id,
        'tos' => $type_of_services,
        'drec' => $date_received,
        'dret' => $date_returned,
        'descr' => $description_of_service,
        'rem' => $remarks,
        'rec' => $recommendation,
        'st' => $service_status,
        'pb' => $processed_by
    ));

    if ($query->rowCount()) {
        echo "<script>alert('Updated Successfully'); location.href='javascript:history.back()'</script>";
    } else {
        echo "<script>alert('An error occured'); location.href='javascript:history.back()'</script>";
    }
?>