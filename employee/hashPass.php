<?php 
    $pass = $_POST['password'];
    //Set the hash
    $PASSWORD = $pass;
    $input = "mypassword";

    $salt = "94665FAE66173BF677A723E4E38E5";
    $hash_salt = hash_hmac("sha256", $PASSWORD, $salt);
    $pwd_hashed = password_hash($hash_salt, PASSWORD_ARGON2ID); //save to database

    //validating password
    $salt = "94665FAE66173BF677A723E4E38E5";
    $hash_salt = hash_hmac("sha256", $input, $salt);
    if (password_verify($hash_salt, $pwd_hashed)) {
    //CONFIRMED - CORRECT PASSWORD
        echo "Correct";
    } else {
    //INCORRECT
        echo "INCORRECT";
    }

?>