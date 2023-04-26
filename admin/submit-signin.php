<?php 

    require_once('../dbConfig.php');
    
    if(isset($_POST['username']) && $_POST['password']) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT password FROM employee_tbl WHERE username = :un";
        $query = $conn->prepare($sql);
        $query->bindParam(':un',$username,PDO::PARAM_STR);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_ASSOC);

        $pwd_hashed = $res['password'];

        $salt = "94665FAE66173BF677A723E4E38E5";
        $hash_salt = hash_hmac("sha256", $password, $salt);
        $new_pwd_hashed = password_hash($hash_salt, PASSWORD_ARGON2ID);

        if (password_verify($hash_salt, $pwd_hashed)) {
        // //CONFIRMED - CORRECT PASSWORD
            session_start();
            $_SESSION['status'] = 'valid';
            $_SESSION['username'] = $username;
            echo 1;
        } else {
        //INCORRECT
            $_SESSION['status'] = 'invalid';
            echo 0;
        }

    } else {
        echo 'Please fill all the fields';
    }

?>