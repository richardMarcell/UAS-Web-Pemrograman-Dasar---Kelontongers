<?php
    session_start();

    if(!isset($_SESSION['login'])) {
        header('Location:../public/login.php');
        exit;
    }

?>