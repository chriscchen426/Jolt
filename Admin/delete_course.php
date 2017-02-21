<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: ../index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Admin ' . $_SESSION['aname'] . '<br></h4>';
$cid = $_GET['id'];
$semester = $_GET['semester'];
$year = $_GET['year'];
$sql = "delete from Course where cid = '$cid' AND semester = '$semester' AND year = '$year' AND status = 'Inactive'";
$result = @mysqli_query($dbc, $sql);
if(mysqli_affected_rows($dbc) == 0){
	echo '<h2 style = "color:#ff0000"> You can not delete active course.<br>';
	echo '<a href = "course_info.php"> Go Back To Course Information </a>';
}elseif(!$result){
	echo '<h2 style = "color:#ff0000"> Too Prevent accidental deletions, system will not allow propagated deletions.<br>';
	echo '<a href = "course_info.php"> Go Back To Course Information </a>';
			//echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
		
	}else{
	header('Location: course_info.php');
	}
?>
