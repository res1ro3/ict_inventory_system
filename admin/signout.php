<?php 
    session_start();
    if ($_SESSION['status'] == 'valid') {
        session_unset();
        $_SESSION['status'] = 'invalid';
        echo 1;
    } else {
        echo 0;
    }
?>