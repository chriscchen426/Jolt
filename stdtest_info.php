<?php

session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: student_login.php');
}
error_reporting(E_ALL ^ E_NOTICE);
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br></h4>';
include 'mysqli_connect.php';
$sid = $_SESSION['stdid'];
if (isset($_GET['id'])) {
$_SESSION['testid'] = $_GET['id'];
}
$errors = array();
//$flag = true;
if (isset($_POST['starttest'])) {
	if (empty($_POST['tcode'])) {
		$errors[] = 'Some of the required Fields are Empty';
	}else{
	//$_SESSION['testid'] = $_POST['tid'];
	$t_id = (int)$_SESSION['testid'];
	$sql = "select testcode as tcode from Test where testid = " . $_SESSION['testid'] . "";
	$result = @mysqli_query($dbc, $sql);
	//$num = mysqli_num_rows($result);
	//if($num > 0){
	if ($r = mysqli_fetch_array($result)) {
		if (strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_POST['tcode'], ENT_QUOTES)) != 0) {
			//$display = true;
			$errors[] = 'You have entered an Invalid Test Code.Try again.';
		}
	}
	//if($flag){
$q = "select *from Test T,TCS TS where
T.cid = TS.cid AND
T.tcid = TS.tcid AND
TS.sid = $sid AND
T.testid = $t_id";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);
if($num == 0){
	$errors[] = 'You are not authorized to take test. Please Contact your testconductor.';
}else{
	//Prepare the parameters needed for Test Conducter and redirect to test conducter
	//if (!empty($_POST['tcode']) && !empty($_POST['tid'])) {
		
}
	}
	
	
	if(empty($errors)){
		//echo  'Take Test';
		$seq = 0;
		//$q = "select * from Question where testid=" . $_SESSION['testid'] . " order by qnid";
		$sql1 = "select totalquestions from Test where testid=" . $_SESSION['testid'] . "";
		$result1 = @mysqli_query($dbc, $sql1);
		$r1 = mysqli_fetch_array($result1);
		$_SESSION['tqn'] = htmlspecialchars_decode($r1['totalquestions'], ENT_QUOTES);
		$tq = (int)$_SESSION['tqn'];
		$q = "SELECT * FROM Question where testid=" . $_SESSION['testid'] . " ORDER BY RAND() LIMIT $tq";
		$q2 = "SELECT * FROM OpQuestion where testid=" . $_SESSION['testid'] . "";
		$result = @mysqli_query($dbc, $q);
		$result2 = @mysqli_query($dbc, $q2);
		if (mysqli_num_rows($result) == 0) {
			echo "Tests questions cannot be selected.Please Try after some time!";
		}else{
			$t = "insert into StudentTest values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from Test where testid=" . $_SESSION['testid'] . ") MINUTE),(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select opduration from Test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress')";
			$k = @mysqli_query($dbc, $t);
			if(!$k){
				echo "error" . mysqli_error();
			}else {
				while ($r = mysqli_fetch_array($result)){
					$seq++;
					$qn = $r[qnid];
					$v = "insert into StudentQuestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",$qn,'unanswered',NULL,$seq)";
					$l = @mysqli_query($dbc, $v);
					if(!$l){
						echo  "Failure while preparing questions for you.Try again";
						echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$v . '</p>';
						echo "error" . mysqli_error();
						//$error = true;
					}
				}
				while ($r2 = mysqli_fetch_array($result2)){
					$qn = $r2[qnid];
					$v = "insert into StudentOpQuestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",$qn,'unanswered',NULL,0,'Comments')";
					$l = @mysqli_query($dbc, $v);
					if(!$l){
						echo  "Failure while preparing questions for you.Try again";
						echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$v . '</p>';
						echo "error" . mysqli_error();
						//$error = true;
					}
				}
		$sql = "select duration,opduration from Test where testid=" . $_SESSION['testid'] . "";
		$result = @mysqli_query($dbc, $sql);
		$r = mysqli_fetch_array($result);
		//$_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
		$_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
		$_SESSION['opduration'] = htmlspecialchars_decode($r['opduration'], ENT_QUOTES);

		$q = "select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt, DATE_FORMAT(opstarttime,'%Y-%m-%d %H:%i:%s') as opstartt,DATE_FORMAT(opendtime,'%Y-%m-%d %H:%i:%s') as opendt from StudentTest where testid=" . $_SESSION['testid'] . " and sid=" . $_SESSION['stdid'] . "";
		$result = @mysqli_query($dbc, $q);
		$r = mysqli_fetch_array($result);
		$_SESSION['starttime'] = $r['startt'];
		$_SESSION['endtime'] = $r['endt'];
		$_SESSION['opstarttime'] = $r['opstartt'];
		$_SESSION['opendtime'] = $r['opendt'];
		$_SESSION['qn'] = 1;
		header('Location: testconducter.php');
		}
		}
	
		
	}
}
		




   ?>                             
<html>
    <head>
        <title>Java Online Learning and Testing System</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <script type="text/javascript" src="validate.js" ></script>
</head>
<body>
<?php
if (!empty($errors)) {
echo'<h2 align = "center"><p style = "color:#ff0000;"> Errors!</p></h2>';
foreach($errors as $msg){
	echo "<div class=\"message\">" .$msg. "</div>";
	//echo "<h2 align = "center"><p style=\"color:#ff0000;\">" .$msg. "<br  />\n</p><h2>";
}
    //echo "<div class=\"message\">" . $errors . "</div>";
}
?>
<div id="container">
 <div class="header">
   <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
<br><br><br>
<form action="stdtest_info.php" method="post">
<table cellpadding="5" cellspacing="3">
<tr>
<td><b>Enter Test Code<b></b></td><td><input type="text" name="tcode" size="30" /></td>
<td><b><p style = "color:#ff0000">Note:</b><br/>Once you press start test<br/>button timer will be started</p></td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="Start Test" name="starttest" class="subbtn"/>
</td>
</tr>
</table>
</form>
</div>
</body>
</html>