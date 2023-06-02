<?php
    require_once('../dbConfig.php');

    if ($_POST['type_of_data'] == 'brand') {
        $brand_id = $_POST['brand_id'];
        $name = $_POST['name'];

        $sql="UPDATE brand_tbl SET name=:nm WHERE brand_id=:bi";
        $query = $conn->prepare($sql);
        $query->bindParam(':bi',$brand_id,PDO::PARAM_STR);
        $query->bindParam(':nm',$name,PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount()) {
            echo "Updated Successfully";
        } else {
            echo "An error occured";
        }
        
    } else if ($_POST['type_of_data'] == 'type_of_hardware') {
        $type_of_hardware = $_POST['type_of_hardware_id'];
        $name = $_POST['name'];
    
        $sql="UPDATE type_of_hardware_tbl SET name=:nm WHERE type_of_hardware_id=:thid";
        $query = $conn->prepare($sql);
        $query->bindParam(':thid',$type_of_hardware,PDO::PARAM_STR);
        $query->bindParam(':nm',$name,PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount()) {
            echo "Updated Successfully";
        } else {
            echo "An error occured";
        }
        
    } else if ($_POST['type_of_data'] == 'type_of_software') {
        $type_of_software = $_POST['type_of_software_id'];
        $name = $_POST['name'];
    
        $sql="UPDATE type_of_software_tbl SET name=:nm WHERE type_of_software_id=:tsid";
        $query = $conn->prepare($sql);
        $query->bindParam(':tsid',$type_of_software,PDO::PARAM_STR);
        $query->bindParam(':nm',$name,PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount()) {
            echo "Updated Successfully";
        } else {
            echo "An error occured";
        }

    } else if ($_POST['type_of_data'] == 'type_of_subscription') {
        $type_of_subscription = $_POST['type_of_subscription_id'];
        $name = $_POST['name'];
    
        $sql="UPDATE type_of_subscription_tbl SET name=:nm WHERE type_of_subscription_id=:tsid";
        $query = $conn->prepare($sql);
        $query->bindParam(':tsid',$type_of_subscription,PDO::PARAM_STR);
        $query->bindParam(':nm',$name,PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount()) {
            echo "Updated Successfully";
        } else {
            echo "An error occured";
        }
    }

?>