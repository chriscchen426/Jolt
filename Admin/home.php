<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
echo '<pre><h2 align = "right"> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
include '../mysqli_connect.php';
//$tcid = $_SESSION['tcid'];
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';

?>
<html>
    <head>
        <title>OES-Admin Home</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>

    </head>
    <body>
        
        <div id="container">
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>

 <br><br><br>
 
 <ul>
 
 <h3><b><li><a href="testconductor_info.php">Add Testconductor</a></li></b></h3><br>
 <h3><b><li><a href="add_course.php">Add Course</a></li></b></h3><br>
 <h3><b><li><a href="course_info.php">Course Management</a></li></b></h3><br>
 </ul>
 
</body>
