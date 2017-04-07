<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if(isset($_GET['qid'])){
	include '../mysqli_connect.php';
	$count = 1;
	//$_SESSION['tid'] = $_GET['tid'];
	//$tid = $_GET['tid'];
    $qnid = $_GET['qid'];
$sql = "delete from Question where testid=" . $_SESSION['testqn'] . " AND qnid = $qnid";
$result = @mysqli_query($dbc, $sql);
if($result){
	$q = "select qnid from Question where testid=" . $_SESSION['testqn'] . " order by qnid";
	$result = @mysqli_query($dbc, $q);
	while ($r = mysqli_fetch_array($result)){
		$qn = $r['qnid'];
		$t = "update Question set qnid = $count where testid=" . $_SESSION['testqn'] . " AND qnid = $qn";
		$s = @mysqli_query($dbc, $t);
		$count++;
		if(!$s){
			echo mysqli_error($dbc);
		}
	}
	header('Location: exam_question_display.php');
	/*
	$v = "select T.cid,C.cname from Test T,Course C where T.cid = C.cid AND T.testid = $tid";
	$t = @mysqli_query($dbc, $v);
	$row1 = mysqli_fetch_assoc($t);
	//echo '<h2 style = "color : #0000FF" align="left">Question Information Saved. </h2><br>';
	$q ="select Q.testid,Q.qnid,Q.question,Q.optiona,Q.optionb,Q.optionc,Q.optiond,Q.correctanswer,Q.marks
	from Question Q where
	Q.testid = $tid";
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
					                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.gif" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>
					            </div>
					
					 <br><br><br>
					 <?php 
					$r = @mysqli_query($dbc, $q);
					$num = mysqli_num_rows($r);
					if($num > 0){
						echo '<h3 style = "color : #0000FF" > List Of All Questions For Test ID ' . $tid . '<br></h3>';
						echo '<h3 style = "color : #0000FF"> Course ID: ' . $row1['cid'] . '<br></h3>';
						echo '<h3 style = "color : #0000FF"> Course Name: ' . $row1['cname'] . '<br><br></h3>';
						echo '<table align= "center" cellspacing="5" cellpadding="5" width="70%" class="datatable">
								<tr>
								<td align="left"><img src="delete.jpg" width="40" height="40"></td>
								<td align="left"><b>Question Id</b></td>
								<td align="left"><b>Test Id</b></td>
								<td align="left"><b>Question</b></td>
								<td align="left"><b>Option A</b></td>
								<td align="left"><b>Option B</b></td>
								<td align="left"><b>Option C</b></td>
								<td align="left"><b>Option D</b></td>
								<td align="left"><b>Correcr Answer</b></td>
								<td align="left"><b>Marks</b></td>
								
								<td align="left"><img src="update.jpg" width="50" height="50"></td>
					
								</tr>
								';
						
						while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
							 
							echo '<tr>
								<td><a href=delete_question.php?id='.$row['qnid'].'&tid='.$row['testid'].'><strong>DELETE</strong></a></td>
								<td align="left">' . $row['qnid'] . '</td>
								<td align="left">' . $row['testid'] . '</td>
								<td align="left">' . $row['question'] . '</td>
								<td align="left">' . $row['optiona'] . '</td>
								<td align="left">' . $row['optionb'] . '</td>
								<td align="left">' . $row['optionc'] . '</td>
								<td align="left">' . $row['optiond'] . '</td>
								<td align="left">' . $row['correctanswer'] . '</td>
								<td align="left">' . $row['marks'] . '</td>
								<td><a href=update_question.php?id='.$row['qnid'].'&tid='.$row['testid'].'><strong>EDIT</strong></a></td>
							
								';
						}
						echo '</table><br>';
					
						}else{
						echo '<h3 style = "color:#ff0000;"> There are no Questions Available.</h3>';
						exit();
					}
	//echo '<h2 style = "color : #0000FF"> Test Data Updated </h2><br>';
*/	
}else{
	echo '<h2 style = "color:#ff0000"> To Prevent accidental deletions, system will not allow propagated deletions.';
			//echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
		
	}
}
?>
