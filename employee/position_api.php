<?php 
    require_once('../dbConfig.php');

    $api_type = $_POST['api_type'];

    if ($api_type == 'get') {
        $position_id = $_POST['position_id'];

        $sql = "
            SELECT * FROM positions_tbl WHERE position_id = :pos
        ";
        $query = $conn->prepare($sql);
        $query->bindParam(':pos',$position_id,PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
    else if ($api_type == 'add') {
        
    }

?>