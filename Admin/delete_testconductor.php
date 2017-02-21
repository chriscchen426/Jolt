<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
$tcid = $_GET['id'];
//$cid = $_SESSION['cid'];
$sql = "delete from Testconductor where tcid = $tcid";
$result = @mysqli_query($dbc, $sql);
if($result){
	header('Location: testconductor_info.php');
	//echo '<h2 style = "color : #0000FF"> Testconductor Data Updated </h2><br>';
}else{
	echo '<h2 style = "color:#ff0000"> Foreign Key Constraint violation. You can not delete or update this child record';
	//echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';

}
