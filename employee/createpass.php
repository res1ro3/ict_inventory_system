<?php 
        $PASSWORD = "12345678";

        $salt = "94665FAE66173BF677A723E4E38E5";
        $hash_salt = hash_hmac("sha256", $PASSWORD, $salt);
        $pwd_hashed = password_hash($hash_salt, PASSWORD_ARGON2ID);

        echo $pwd_hashed;

?>