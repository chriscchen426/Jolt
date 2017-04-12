<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: ../index.php');
}
include '../mysqli_connect.php';
error_reporting(E_ALL ^ E_NOTICE);
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Admin ' . $_SESSION['aname'] . '<br></h4>';
$errors = array();
$success = array();
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: course_info.php');
}
if(isset($_POST['save'])){
	include '../mysqli_connect.php';
	//$cid = $_POST['c_id'];
	$errors = array();
	if (empty($_POST['c_id']) || empty($_POST['c_name']) || empty($_POST['sem']) || empty($_POST['year']) || empty($_POST['tcid']) || empty($_POST['c_status'])) {
		$errors[] = 'Some of the required Fields are Empty.';
		//$_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
	}
	/*
	if (empty($_POST['c_id'])){
		$errors[] = 'You forgot to enter your course ID';
	}elseif (empty($_POST['c_name'])){
		$errors[] = 'You forgot to enter your course name';
	}elseif(empty($_POST['sem'])){
		$errors[] = 'You forgot to enter semester';
		}elseif(empty($_POST['year'])){
			$errors[] = 'You forgot to enter year';
			}elseif(empty($_POST['I_name'])){
				$errors[] = 'You forgot to enter Instructor name';
		}else{
		*/
		$cid = $_POST['c_id'];
		$cname = $_POST['c_name'];
		$sem = $_POST['sem'];
		$year = $_POST['year'];
		$tcid = $_POST['tcid'];
		$status = $_POST['c_status'];
		if(empty($errors)){
			$v = "select status from Course where cid = '$cid'";
			$result1 = @mysqli_query($dbc, $v);
			$r1 = mysqli_fetch_array($result1);
          //$sql = "SELECT *FROM Course where cid = '$cid' AND year = $year AND semester = '$sem'";
          //$result = @mysqli_query($dbc, $sql);
          //$r = mysqli_fetch_array($result);
          //if (mysqli_errno ($dbc) == 1062){ //duplicate value
						//$success[] = 'Given Course Already Registered for given semester and year.';
          if($r1['status'] == $status){
          	$success[] = 'Given Course Already Have Active Status.';
          }else{
			$q = "update Course set tcid = $tcid,status = '$status'
			where cid = '$cid' AND semester = '$sem' AND year = $year";
			$r = @mysqli_query($dbc, $q);
			if($r){
				header('Location: course_info.php');
				//echo '<h2> Thank You. Course Information Saved. </h2><br>';
				//echo '<li><a href="home.php">Home</a></li>';
				//exit();
			}else{
				//$success[] = 'To Prevent accidental updations, system will not allow propagated updations.';
				$success[] = mysqli_error ($dbc);
				//echo '<p style = "color:#ff0000">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
				//exit();
			}
          }
		
		}
		?>
		
		
		<?php
		include 'nav.html';
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
<h2 style = "color : #0000FF">Update Course Information</h2><br>
<form action = "update_course.php" method="post">
<table class="table" border = "1">
<tr> <td>Course ID </td><td><input type="text" readonly name="c_id" value="<?php echo $cid; ?>" /></td></tr>
<tr> <td>Course Name: </td><td><input type="text" readonly name="c_name" value="<?php echo $cname; ?>"/></td></tr>
<tr> <td>Select Testconductor Name: </td><td>
<select name="tcid">
<?php 
include '../mysqli_connect.php';
$t = "select tcid from Testconductor where tcname = '$tcname'";
$v = @mysqli_query($dbc, $t);
$z = mysqli_fetch_array($v);
$q ="select tcid,tcname from Testconductor";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q); ?>
<option value="<?php echo $z['tcid']; ?>" selected><?php echo $tcname; ?></option>
<?php 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$tcid = $row['tcid'];
	echo "<option value=\"$tcid\">" . $row['tcname'] . "</option>";
}
?>
</select>
<tr> <td>Semester </td><td><input type="text" readonly name="sem" value="<?php echo $sem; ?>" /></td></tr>

<tr> <td>Year </td><td><input type="text" readonly name="year" value="<?php echo $year; ?>" /></td></tr>

<tr><td>Select Status</td><td>
<select name="c_status">
<option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
<option value="Active">Active</option>
  <option value="Inactive">Inactive</option>
  
</select> </td></tr>
</table><br>
<input type="submit" name="save" value="Save" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
				            
				            </div>
                          </form>
                           </div>
                           </body>
                          </html>
				            <?php 
	}
//if((isset($_GET['id'])) && (isset($_GET['cname'])) && (isset($_GET['cname'])) && (isset($_GET['tcname'])) && (isset($_GET['year'])) && (isset($_GET['semester']))){
	if(isset($_GET['id']) && isset($_GET['cname']) && isset($_GET['tcname']) && isset($_GET['year']) && isset($_GET['semester']) && isset($_GET['status'])){
	include '../mysqli_connect.php';

$cid = $_GET['id'];
$cname = $_GET['cname'];
$tcname = $_GET['tcname'];
$year = $_GET['year'];
$semester = $_GET['semester'];
$status = $_GET['status'];
//echo $id;
//$q = "SELECT *FROM Course where cid = '$cid' AND cname = '$cname' AND year = $year AND semester = '$semester'";
//$r = @mysqli_query($dbc, $q);
//$row = mysqli_fetch_array($r);
 include 'nav.html';
?>
<div class="container">
        <h4>&nbsp;</h4>
        <h4>&nbsp;</h4>
<h2 style = "color : #0000FF">Update Course Information</h2><br>
<form action = "update_course.php" method="post">
<table class="table" border = "1">
<tr> <td>Course ID </td><td><input type="text" readonly name="c_id" value="<?php echo $cid; ?>" /></td></tr>
<tr> <td>Course Name: </td><td><input type="text" readonly name="c_name" value="<?php echo $cname; ?>"/></td></tr>
<tr> <td>Select Testconductor Name: </td><td>
<select name="tcid">
<?php 
include '../mysqli_connect.php';
$t = "select tcid from Testconductor where tcname = '$tcname'";
$v = @mysqli_query($dbc, $t);
$z = mysqli_fetch_array($v);
$q ="select tcid,tcname from Testconductor";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q); ?>
<option value="<?php echo $z['tcid']; ?>" selected><?php echo $tcname; ?></option>
<?php 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$tcid = $row['tcid'];
	echo "<option value=\"$tcid\">" . $row['tcname'] . "</option>";
}
?>
</select>
<tr> <td>Semester </td><td><input type="text" readonly name="sem" value="<?php echo $semester; ?>" /></td></tr>

<tr> <td>Year </td><td><input type="text" readonly name="year" value="<?php echo $year; ?>" /></td></tr>

<tr><td>Select Status</td><td>
<select name="c_status">
<option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
<option value="Active">Active</option>
  <option value="Inactive">Inactive</option>
  
</select> </td></tr>
</table><br>
<input type="submit" name="save" value="Save" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>
<?php 
}
?>