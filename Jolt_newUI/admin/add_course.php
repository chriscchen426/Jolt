<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: ../index.php');
}
include '../mysqli_connect.php';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Admin ' . $_SESSION['aname'] . '<br></h4>';
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
		
    <?php
    include 'nav.html';
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
  <div class="container">
        <h4>&nbsp;</h4>
        <h4>&nbsp;</h4>
<h2 style = "color : #0000FF">Add Course Information</h2><br>
<form action = "add_course.php" method="post">
<table class="table" border = "1">
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

    <?php
    include 'nav.html';
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
   <div class="container">
        <h4>&nbsp;</h4>
        <h4>&nbsp;</h4>
<h2 style = "color : #0000FF">Add Course Information</h2><br>
<form action = "add_course.php" method="post">
<table class="table" border = "1">
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

