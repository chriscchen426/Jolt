<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
$errors = array();
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$tcid = $_SESSION['tcid'];
$v = "select curDate() As date2";
$t = @mysqli_query($dbc, $v);
$r1 = mysqli_fetch_array($t);
$date1 = $r1['date2'];
$q = "select *from Test where tcid = $tcid";
$result = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($result);
?>
<html>
    <head>
        <title>OES-Test Questions</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>

    </head>
    <body>
        
        <div id="container">
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>

 <br><br><br>
 <?php 
if($num > 0){
	echo '<h3 style = "color : #0000FF" > List Of All Test Available<br><br></h3>';
	echo '<table align= "center" cellspacing="5" cellpadding="3" width="70%" class = "datatable">
			<tr>
			<td align="left"><b>Test ID</b></td>
			<td align="left"><b>Course ID</b></td>
			<td align="left"><b>Test Name</b></td>
			<td align="left"><b>Description</b></td>
			
			</tr>
			';
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	
	
	$date2 = Date($row['testto']);
	if(strtotime($date1) < strtotime($date2)){
		
		echo '<tr>
		<td align="left">' . $row['testid'] . '</td>
		<td align="left">' . $row['cid'] . '</td>
		<td align="left">' . $row['testname'] . '</td>
		<td align="left">' . $row['testdesc'] . '</td>
		<td><a href=prepqn.php?id='.$row['testid'].'><strong>Prepare Questions</strong></a></td>
	
	';
}
}
echo '</table><br>';
}else{
	echo '<h3 style = "color:#ff0000;"> There are no test information available for instructor.</h3><br>';
	//echo '<input type="submit" name = "add" value="Add Course">';
	//exit();
}

