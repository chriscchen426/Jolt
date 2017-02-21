<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: ../index.php');
}
include '../mysqli_connect.php';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Admin ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: home.php');
}
$errors = array();
$success = array();
	if(isset($_POST['add'])){
		//$errors = array();
		//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
		if (empty($_POST['cid']) || empty($_POST['cname']) || empty($_POST['sectionid'])) {
			$errors[] = 'Some of the required Fields (*) are Empty.';
		}
		
		$cid = $_POST['cid'];
		$cname = $_POST['cname'];
		$section_id = $_POST['sectionid'];
		if(empty($errors)){
			$sql = "INSERT INTO Course_Info(cid,section_id,cname) values('$cid','$section_id','$cname')";
			$r = @mysqli_query($dbc, $sql);
			if(!$r){
                   $success[] = 'The Course ID and Section ID already assign to other Course Name.';
				}else{
				$success[] = 'Course Information successfuly Added.';
				//header('Location: add_course.php');
				
				}
			
		//}
		?>
		<html>
    <head>
        <title>OES-Manage Course</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <link rel="stylesheet" type="text/css" href="../pinesh.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
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
if(!empty($success)) {
foreach($success as $msg){
	echo "<div class=\"message\">" .$msg. "</div>";
	//echo "<h2 align = "center"><p style=\"color:#ff0000;\">" .$msg. "<br  />\n</p><h2>";
}
    //echo "<div class=\"message\">" . $errors . "</div>";
}
echo '<br>';
?>
 <div id="container">
   <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
<h2 style = "color : #0000FF">Add Course Information</h2><br>
<form action = "add_course.php" method="post">
<table border = "1">
<tr> <td><b>Enter Course ID </b></td><td><input type ="text" name="cid" placeholder= "*" value="<?php echo $_POST['cid']; ?>"  /></td></tr>
<tr> <td><b>Enter Course Section: </b></td><td><input type="text" name="sectionid" placeholder= "*" value="<?php echo $_POST['sectionid']; ?>" onkeyup="isnum(this)"/></td></tr>
<tr> <td><b>Enter Course Name: </b></td><td><input type="text" name="cname" placeholder= "*" value="<?php echo $_POST['cname']; ?>" onkeyup="isalphanum(this)"/></td></tr>

</table>
<br>
<input type="submit" name="add" value="Add Course" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>

		
		<?php 
		exit();
		}
		}
	
	
	
?>
<html>
    <head>
        <title>OES-Manage Course</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <link rel="stylesheet" type="text/css" href="../pinesh.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
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
if(!empty($success)) {
foreach($success as $msg){
	echo "<div class=\"message\">" .$msg. "</div>";
	//echo "<h2 align = "center"><p style=\"color:#ff0000;\">" .$msg. "<br  />\n</p><h2>";
}
    //echo "<div class=\"message\">" . $errors . "</div>";
}
echo '<br>';
?>
 <div id="container">
   <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
<h2 style = "color : #0000FF">Add Course Information</h2><br>
<form action = "add_course.php" method="post">
<table border = "1">
<tr> <td><b>Enter Course ID </b></td><td><input type ="text" name="cid" placeholder= "*" size="25" maxlength="30"  /></td></tr>
<tr> <td><b>Enter Course Section: </b></td><td><input type="text" name="sectionid" placeholder= "*" onkeyup="isnum(this)"/></td></tr>
<tr> <td><b>Enter Course Name: </b></td><td><input type="text" name="cname" placeholder= "*" onkeyup="isalphanum(this)"/></td></tr>

</table>
<br>
<input type="submit" name="add" value="Add Course" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>

