<?php
//error_reporting(E_ALL ^ E_NOTICE);
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: ../index.php');
}
include '../mysqli_connect.php';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Admin ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: course_info.php');
}
//" . htmlspecialchars($_POST['cid'], ENT_QUOTES) . empty($_POST['cname']) ||"
$errors = array();
$success = array();
	if(isset($_POST['add'])){
		
	 //$errors = array();
		//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
		if (strcmp($_POST['sem'], "<Choose the Semester>") == 0 || 
				strcmp($_POST['cid'], "<Choose the Course>") == 0 || strcmp($_POST['cstatus'], "<Choose the Status>") == 0 || 
				strcmp($_POST['year'], "<Choose the Year>") == 0 || strcmp($_POST['tcid'], "<Choose the Testconductor>") == 0) {
			$errors[] = 'Some of the required Fields (*) are Empty.';
		}
		
		
		//$cname = $_POST['cname'];
		$sem = $_POST['sem'];
		$year = (int) $_POST['year'];
		$tcid = $_POST['tcid'];
		$status = $_POST['cstatus'];
		
		if(empty($errors)){
		$pieces = explode('-', $_POST['cid'],2);
		$rcid = $pieces[1];
		$data = explode('-', $rcid ,2);
		$cid = $pieces[0]."-".$data[0];
		//$sectionid = $pieces[1];
		$cname = $data[1];
		//$cid = $pieces[1];
		//echo $cid;
		//echo $cname .'<br>';
		//echo $cid;
			$sql = "INSERT INTO Course(cid,cname,semester,year,tcid,status) values('$cid','$cname','$sem',$year,'$tcid','$status')";
			$r = @mysqli_query($dbc, $sql);
			if(!$r){
                   if (mysqli_errno ($dbc) == 1062) //duplicate value
						$success[] = 'Given Course Already Registered for given semester and year.';
					else
						$success[] = mysqli_error ($dbc);
				}else{
				$success[] = 'Course Information successfuly Added.';
				header('Location: course_info.php');
				//exit();
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
		<h2 style = "color : #0000FF">Register Course Information</h2><br>
		<form action = "register_course.php" method="post">
		<table class="table" border = "1">
		<tr> <td><b>Select Course ID </b></td><td><?php  include 'cs.php' ?></td></tr>
		
		<tr> <td><b>Select Semester: </b></td><td><?php  include 'stdsemester.php' ?></td></tr>
		<tr> <td><b>Select Year: </b></td><td><?php  include 'stdyear.php' ?></td></tr>
		<tr> <td><b>Select Testconductor: </b></td><td><?php  include 'tcid.php' ?></td></tr>
		<tr><td><b>Select Status:</b></td><td><select name="cstatus">
		 <option value="<Choose the Status>" selected>&lt;Choose the Status&gt;</option>
		  <option value="Active">Active</option>
		  <option value="Inactive">Inactive</option></select>
		</table>
		<br>
		<input type="submit" name="add" value="Add" class="subbtn"/>
		<input type="submit" value="Cancel" name="cancel" class="subbtn">
		</form>
		</div>
		</div>
		</body>
		</html>
		<?php 
		exit();
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
<h2 style = "color : #0000FF">Register Course Information</h2><br>
<form action = "register_course.php" method="post">
<table class="table" border = "1">
<tr> <td><b>Select Course ID </b></td><td><?php  include 'cs.php' ?></td></tr>

<tr> <td><b>Select Semester: </b></td><td><?php  include 'stdsemester.php' ?></td></tr>
<tr> <td><b>Select Year: </b></td><td><?php  include 'stdyear.php' ?></td></tr>
<tr> <td><b>Select Testconductor: </b></td><td><?php  include 'tcid.php' ?></td></tr>
<tr><td><b>Select Status:</b></td><td><select name="cstatus">
 <option value="<Choose the Status>" selected>&lt;Choose the Status&gt;</option>
  <option value="Active">Active</option>
  <option value="Inactive">Inactive</option></select>
</table>
<br>
<input type="submit" name="add" value="Add" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>

