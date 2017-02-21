<?php
session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: student_login.php');
}
include 'logout.html';

echo '<pre><h2 align = "right"> <a href="#" onClick="return confirmLogout()"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="logout.php">Logout</a></h2>';
//echo '<h3 align = "right"><a href="logout.php">LOGOUT</a></h3>';
include 'mysqli_connect.php';
$sid = $_SESSION['stdid'];
//echo $sid;
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br></h4>';
//echo 'Welcome ' . $_SESSION['stdname'] . '<br><br>';
//echo '<h2 style = "color : #0000FF">Welcome Online Examination System</h2><br>';

?>
<html>
<head>
<title>Online Examination System</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
     <link rel="stylesheet" type="text/css" href="pinesh.css"/>
    <script type="text/javascript" src="validate.js" ></script>
     <style>
a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

a:active {
    text-decoration: underline;
}
</style>
</head>
<body>
<div id="container">
 <div class="header">
   <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
 
<br><br><br>
 
<?php 
$q ="select C.cid,C.cname,TS.tcname,T.tcid,C.year,C.semester from Course C, TCS T,Testconductor TS
where C.cid = T.cid AND T.tcid = TS.tcid AND T.sid = $sid AND C.status = 'Active'";
$result = @mysqli_query($dbc,$q);
if($result){
$num = mysqli_num_rows($result);
if($num > 0){
echo '<h2 style = "color : #0000FF" > you are currently registered for<br><br></h2>';
echo '<table cellpadding="30" cellspacing="10" class="datatable">
			<tr>

			<th>Course ID</th>
			<th><b>Course Name</th>
			<th>Instructor Name</th>
			<th>Year</th>
			<th>Semester</th>
			<th></th>

			</tr>
			';
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	echo '<tr>

				<td align="left">' . $row['cid'] . '</td>
				<td align="left">' . $row['cname'] . '</td>
				<td align="left">' . $row['tcname'] . '</td>
		        <td align="left">' . $row['year'] . '</td>
		         <td align="left">' . $row['semester'] . '</td>
		        <td><a href=stdtest.php?id='.$row['cid'].'><strong>View Test</strong></a></td>
			';

}
echo '</table><br>';

  }else{
	echo '<h3><class = error style = "color:#ff0000"> Currently, You are not registered for any classes.</h3>';
}
}
?>

 
 <br>
<h3><a href="viewresult.php">View Result</a></h3>
<h3><a href="practicetest.php">Practice Test</a></h3>

 

</div>
</body>
</html>
