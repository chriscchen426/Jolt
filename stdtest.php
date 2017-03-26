<?php
session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: student_login.php');
}
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br></h4>';
include 'mysqli_connect.php';
date_default_timezone_set("America/New_York");
if(isset($_GET['id'])){
	$cid = $_GET['id'];
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
<div id="container">
 <div class="header">
   <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
 
<br><br><br>
<?php 
$sid = $_SESSION['stdid'];
//$q = "select t.*,s.cname from Test as t, Course as s 
		//where s.cid=t.cid and NOW() < t.testto and 
		//t.totalquestions = (select count(*) from Question where testid=t.testid) and 
		//NOT EXISTS(select sid,testid from StudentTest where testid=t.testid and sid=" . $_SESSION['stdid'] . ")";
		
$q = "select t.*,s.cname from Test as t, Course as s,TCS TS
		where TS.cid = s.cid and s.status = 'Active' and s.cid=t.cid and TS.tcid = t.tcid and t.cid = '$cid' 
		and TS.sid = " . $_SESSION['stdid'] . " and t.testfrom < NOW() and
		NOW() < t.testto  and 
		NOT EXISTS(select sid,testid from StudentTest where testid=t.testid and sid=" . $_SESSION['stdid'] . ")";
		//echo $q;
$result = @mysqli_query($dbc, $q);

//echo $q;
if(!$result){
	echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
}
if (mysqli_num_rows($result) == 0) {
echo '<h2><p style = "color:#ff0000;">Sorry...! For this moment, You have not Offered to take any tests.</p></h2>';
	//exit();
}else{

	echo '<h2 style = "color : #0000FF" > List Of All Test Available<br><br></h2>';
	echo '<table align= "center" cellspacing="5" cellpadding="3" width="70%" class="datatable">
			<tr>
		     
			<th>Test ID</th>
			<th>Test Name</th>
			<th>Test Description</th>
			<th>Subject Name</th>
			<th>Duration</th>
			<th>Total Questions</th>
			<th>Take Test</th>
		
			</tr>
			';
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))	{
		$dur = $row['duration']+$row['opduration'];
		$tolq = $row['totalquestions']+$row['totalopquestion'];
		echo '<tr>

				<td align="left">' . $row['testid'] . '</td>
				<td align="left">' . $row['testname'] . '</td>
				<td align="left">' . $row['testdesc'] . '</td>
		        <td align="left">' . $row['cname'] . '</td>
		         <td align="left">' . $dur . '</td>
		        <td align="left">' . $tolq . '</td>
		        <td><a href=stdtest_info.php?id='.$row['testid'].'><strong>Take Test</strong></a></td>
			';

	}
	echo '</table><br>';

}
?>
</div>
</body>
</html>

