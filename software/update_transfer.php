<?php
    require_once('../dbConfig.php');
    
    $transfer_id = $_POST['transferIdInp'];
    $software_id = $_POST['softwareIdInp'];
    $date_transferred = $_POST['dateTransferredEditInp'];
    $old_owner = $_POST['oldownerEditInp'];
    $new_owner = $_POST['newownerEditInp'];

    if ($old_owner === $new_owner) {
        echo "<script>alert('Current Owner cannot be the New Owner.'); location.href='javascript:history.back()'</script>";
    } else {
        $sql="UPDATE software_tbl SET employee_id=:new WHERE software_id=:sid";
        $query = $conn->prepare($sql);
        $query->bindParam(':sid',$software_id,PDO::PARAM_STR);
        $query->bindParam(':new',$new_owner,PDO::PARAM_STR);
        $query->execute();

        $sql="UPDATE ict_transfer_tbl 
            SET date_transferred = :dt,
                employee_id_new = :new,
                employee_id_old = :old
            WHERE transfer_id=:tid";
        $query = $conn->prepare($sql);
        $query->execute(array(
            'tid' => $transfer_id,
            'dt' => $date_transferred,
            'old' => $old_owner,
            'new' => $new_owner
        ));

        if ($query->rowCount()) {
            echo "<script>alert('Updated Successfully'); location.href='javascript:history.back()'</script>";
        } else {
            echo "<script>alert('An error occured'); location.href='javascript:history.back()'</script>";
        }
    }
?>