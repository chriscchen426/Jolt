<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include 'logout.html';


echo '<pre><h2 align = "right"> <a href="#" onClick="return confirmLogout()"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<a href="logout.php"><img src="logout.jpg" width="40" height="40" align = "right"></a><br>';
//echo '<h3 align = "right"><a href="logout.php">LOGOUT</a></h3>';
include '../mysqli_connect.php';
$tcid = $_SESSION['tcid'];
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';

?>
<html>
    <head>
        <title>OES-Testconductor Home</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        
    </head>
    <body>
        
        <div id="container">
            <div class="header">
               <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br>
            <?php 
include 'header.html';
?>
 
</body>
</html>
