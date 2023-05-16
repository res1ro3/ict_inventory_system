<?php
    require_once('../dbConfig.php');

    $eid = $_POST['employee_id'];
    $def = "12345678";

    $salt = "94665FAE66173BF677A723E4E38E5";
    $hash_salt = hash_hmac("sha256", $def, $salt);
    $pass = password_hash($hash_salt, PASSWORD_ARGON2ID);

    $sql="UPDATE employee_tbl SET password=:ps WHERE employee_id=:eid";
    $query = $conn->prepare($sql);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->bindParam(':ps',$pass,PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount()) {
        echo "Password reset successful";
    } else {
        echo "An error occured";
    }
?>