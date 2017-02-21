<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$sid = $_GET['id'];
$cid = $_SESSION['cid'];
$sql = "delete from TCS where sid = $sid AND cid = '$cid'";
$result = @mysqli_query($dbc, $sql);
if($result){
	$cid = $_SESSION['cid'];
	$tcid = $_SESSION['tcid'];
	$v = "select cname from Course where cid = '$cid'";
	$t = @mysqli_query($dbc, $v);
	$row1 = mysqli_fetch_assoc($t);
	//echo '<h2 style = "color : #0000FF" align="left">Student Information Saved. </h2><br>';
	$q ="select S.sid,S.sname,S.email,C.cid,C.cname,S.password from
	Student S,Testconductor T,Course C,TCS D where
	S.sid = D.sid And
	D.tcid = T.tcid AND
	D.cid = C.cid AND
	T.tcid = $tcid AND
	C.cid = '$cid'";
	
	?>
					<html>
					    <head>
					        <title>OES-Manage Student</title>
					        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
					        <link rel="stylesheet" type="text/css" href="../oes.css"/>
					
					    </head>
					    <body>
					        
					        <div id="container">
					            <div class="header">
					                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.gif" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>
					            </div>
					
					 <br><br><br>
					 <?php 
					
					$r = @mysqli_query($dbc, $q);
					$num = mysqli_num_rows($r);
					if($num > 0){
						echo '<h3 style = "color : #0000FF" > List Of All Student Currently registered For Following Course<br><br></h3>';
						echo '<h3 style = "color : #0000FF"> Course ID: ' . $cid . '<br></h3>';
						echo '<h3 style = "color : #0000FF"> Course Name: ' . $row1['cname'] . '<br><br></h3>';
						echo '<table align= "center" cellspacing="5" cellpadding="5" width="70%" class="datatable">
								<tr>
								<td align="left"><img src="delete.jpg" width="40" height="40"></td>
								<td align="left"><b>Student Id</b></td>
								<td align="left"><b>Student Name</b></td>
								<td align="left"><b>Email</b></td>
								<td align="left"><b>Password</b></td>
								<td align="left"><img src="update.jpg" width="50" height="50"></td>
					
								</tr>
								';
						
						while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
							 
							echo '<tr>
								<td><a href=delete_student.php?id='.$row['sid'].'><strong>DELETE</strong></a></td>
								<td align="left">' . $row['sid'] . '</td>
								<td align="left">' . $row['sname'] . '</td>
								<td align="left">' . $row['email'] . '</td>
								<td align="left">' . $row['password'] . '</td>
								<td><a href=update_student.php?id='.$row['sid'].'><strong>EDIT</strong></a></td>
							
								';
						}
						echo '</table><br>';
					
						}else{
						echo '<h3 style = "color:#ff0000;"> There are no students registered.</h3>';
						exit();
					}
	//header('Location: .php');
	//echo '<h2 style = "color : #0000FF"> Student Data Updated </h2><br>';
}else{
	echo '<h2 style = "color:#ff0000"> Too Prevent accidental deletions, system will not allow propagated deletions.';
	//echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';

}
