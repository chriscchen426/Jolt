<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
//echo '<pre><h2 align = "right"> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
include '../mysqli_connect.php';
//$tcid = $_SESSION['tcid'];
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
include 'nav.html';
?>

        
        <div class="container">
            

 <br><br><br>
 
 <ul>
 
 <h3><b><li><a href="testconductor_info.php">Add Testconductor</a></li></b></h3><br>
 <h3><b><li><a href="add_course.php">Add Course</a></li></b></h3><br>
 <h3><b><li><a href="course_info.php">Course Management</a></li></b></h3><br>
 </ul>
 
</body>
