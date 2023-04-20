<?php 

    require_once('../dbConfig.php');

    if(isset($_POST['username']) && $_POST['password']) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM employee_tbl WHERE username = :un AND password = :ps";
        $query = $conn->prepare($sql);
        $query->bindParam(':un',$username,PDO::PARAM_STR);
        $query->bindParam(':ps',$password,PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount()) {
            echo 
        } else {
            echo 'An error occurred';
        }

    } else {
        echo 'Please fill all the fields';
    }

?>