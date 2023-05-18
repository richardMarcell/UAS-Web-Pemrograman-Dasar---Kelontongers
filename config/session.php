<?php
    session_start();

    if(!isset($_SESSION['login'])) {
        header('Location:../404.html');
        exit;
    }

?>