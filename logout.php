

<?php
    session_start();
    unset($_SESSION['stdname']);
    unset($_SESSION['stdid']);
    header('Location: index.php');
?>