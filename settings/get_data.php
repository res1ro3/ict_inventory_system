<?php 
    require_once('../dbConfig.php');

    if ($_POST['type_of_data'] == 'brand') {
        $brand_id = $_POST['brand_id'];

        $sql = "
            SELECT * FROM brand_tbl WHERE brand_id = :bi
        ";
        $query = $conn->prepare($sql);
        $query->bindParam(':bi',$brand_id,PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);

    } else if ($_POST['type_of_data'] == 'type_of_hardware') {
        $type_of_hardware_id = $_POST['type_of_hardware_id'];

        $sql = "
            SELECT * FROM type_of_hardware_tbl WHERE type_of_hardware_id = :th
        ";
        $query = $conn->prepare($sql);
        $query->bindParam(':th',$type_of_hardware_id,PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);

    } else if ($_POST['type_of_data'] == 'type_of_software') {
        $type_of_software_id = $_POST['type_of_software_id'];

        $sql = "
            SELECT * FROM type_of_software_tbl WHERE type_of_software_id = :ts
        ";
        $query = $conn->prepare($sql);
        $query->bindParam(':ts',$type_of_software_id,PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);

    } else if ($_POST['type_of_data'] == 'type_of_subscription') {
        $type_of_subscription_id = $_POST['type_of_subscription_id'];

        $sql = "
            SELECT * FROM type_of_subscription_tbl WHERE type_of_subscription_id = :ts
        ";
        $query = $conn->prepare($sql);
        $query->bindParam(':ts',$type_of_subscription_id,PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
        
    }  

?>