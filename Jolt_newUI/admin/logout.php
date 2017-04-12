<?php
    session_start();
   
    unset($_SESSION['aname']);
     header('Location: adm_login.php');
?>