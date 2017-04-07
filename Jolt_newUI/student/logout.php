<?php
    session_start();
    unset($_SESSION['stdname']);
    unset($_SESSION['stdid']);
    header('Location: std_login.php');
?>