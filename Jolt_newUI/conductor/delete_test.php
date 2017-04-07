<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$testid = $_GET['id'];
$sql = "delete from Test where testid = $testid";
$result = @mysqli_query($dbc, $sql);
if($result){
	header('Location: test_info.php');
}else{
	echo '<h2 style = "color:#ff0000"> To Prevent accidental deletions, system will not allow propagated deletions.</h2>';
			//echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
		
	}
?>
<?php
