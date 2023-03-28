<?php 
    require_once('../dbConfig.php');
    $username = $_POST['usernameInp'];

    $sql="SELECT * FROM employee_tbl WHERE username = :uname";
    $query = $conn->prepare($sql);
    $query->bindParam(':uname',$username,PDO::PARAM_STR);
    $query->execute();
    $row=$query->rowCount();

    if ($row > 0) {
        echo "taken";
    } else {
        echo "available";
    }
?>