<?php 

    require_once('../dbConfig.php');

    if(isset($_POST['email']) && $_POST['pass']) {
        echo $_POST['email'] . ' : ' . $_POST['pass'];
    } else {
        echo 'Failed';
    }

?>