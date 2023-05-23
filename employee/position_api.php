<?php 
    require_once('../dbConfig.php');

    $api_type = $_POST['api_type'];
    $position_id = $_POST['position_id'];

    if ($api_type == 'get') {
        $sql = "
            SELECT * FROM positions_tbl WHERE position_id = :pos
        ";
        $query = $conn->prepare($sql);
        $query->bindParam(':pos',$position_id,PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
    else if ($api_type == 'update') {
        $title = $_POST['title'];

        $sql="UPDATE positions_tbl SET title=:tl WHERE position_id=:pos";
        $query = $conn->prepare($sql);
        $query->execute(array(
            'tl' => $title,
            'pos' => $position_id
        ));

        if ($query->rowCount()) {
            echo "Updated Successfully";
        } else {
            echo "An error occured";
        }
    }

?>