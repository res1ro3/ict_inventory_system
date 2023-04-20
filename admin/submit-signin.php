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
        //CONFIRMED - CORRECT PASSWORD
            echo "Correct";
        } else {
        //INCORRECT
            echo $password . "\n" . $pwd_hashed . "\n" . $new_pwd_hashed;
        }

        // $sql = "SELECT * FROM employee_tbl WHERE username = :un AND password = :hs";
        // $query = $conn->prepare($sql);
        // $query->bindParam(':un',$username,PDO::PARAM_STR);
        // $query->bindParam(':hs',$hashed,PDO::PARAM_STR);
        // $query->execute();

        // if ($query->rowCount()) {
        //     echo "Logged in successfully";
        // } else {
        //     echo 'Incorrect username or password';
        // }

    } else {
        echo 'Please fill all the fields';
    }

?>