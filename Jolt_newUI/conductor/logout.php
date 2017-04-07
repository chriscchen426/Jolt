<?php
    session_start();
    
    unset($_SESSION['tcname']);
    unset($_SESSION['tcid']);
    header('Location: cdt_login.php');
?>