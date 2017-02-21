<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h3><a href="home.php">Home</a></h3>';
//echo '<h3 align = "right"><a href="logout.php">LOGOUT</a></h3>';
//echo 'Welcome ' . $_SESSION['tcname'] . '<br>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$tcid = $_SESSION['tcid'];
?>
<html>
<head>
        <title>OES-Test Questions Information</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>

    </head>
<body>
 <div id="container">
            <div class="header">
               <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
<h2 style = "color : #0000FF">Test Questions Information Form</h2><br>
<form action="exam_question_display.php" method="post">
<table border = "1">
<tr><td>Select Course ID:</td><td> <?php  
include '../mysqli_connect.php';
echo '<select name="cid">';
$q ="select cid from Test where tcid = $tcid";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$cid = $row['cid'];
	echo "<option value=\"$cid\">" . $row['cid'] . "</option>";
	}
	echo '</select>';

 ?></td></tr>
<tr><td>Select Test ID:</td><td> <?php  
include '../mysqli_connect.php';
echo '<select name="tid">';
$q ="select testid from Test where tcid = $tcid";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$tid = $row['testid'];
	echo "<option value=\"$tid\">" . $row['testid'] . "</option>";
	}
	echo '</select>';
?></td></tr>
</table>
<br>
<input type="submit" name="submit" value="submit" class="subbtn"/>
</form>
</div>
</body>
</html>