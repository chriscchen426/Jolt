<?php
session_start();
if(!isset($_SESSION['stdid'])){
	header('Location: student_login.php');
	//$sid = $_SESSION['stdid'];
}
//echo '<pre><h2 align = "right"> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
$sid = $_SESSION['stdid'];
//echo '<h3 align = "right"><a href="logout.php">LOGOUT</a></h3>';
$errors = array();
$success = array();
include 'mysqli_connect.php';
if(isset($_POST['submit'])){
	//include 'mysqli_connect.php';
	//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
	//$errors = array();
	if (empty($_POST['npass'])){
		$errors[] = 'You forgot to enter your new password.';
	}
	if (empty($_POST['rpass'])){
		$errors[] = 'You forgot to re-enter your password.';
	}
	$npass = $_POST['npass'];
	$rpass = $_POST['rpass'];
	if($rpass != $npass){
		$errors[] = 'Your password does not match.';
		//echo '<h2 style = color:#ff0000;">You entered wrong password.</h2><br>';
	}
	if(empty($errors)){
		$sql = "update Student set password = '$npass' where sid = $sid";
		$result = @mysqli_query($dbc, $sql);
		if($result){
			$success[] = 'Password successfully updated.';
			$success[] = 'Click Here To <a href="logout.php">Login.</a>';
			//exit();
		}
	}
}
//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
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
            
<h2 style = "color : #0000FF">Password Reset</h2><br>
<form action="preset.php" method="post">
<font color = "#FF0000">Note: Password must contain combination of alphabets and number.</font><br><br>
<table>

<tr> <td>Enter New Password: </td><td><input type="password" name="npass" placeholder="Password" size="30" maxlength="50" /></td></tr>
<tr> <td>Re-Enter New Password: </td><td><input type="password" name="rpass" placeholder="Reenter password" size="30" maxlength="50" /></td></tr>
</table><br>
<input type="submit" name="submit" value="Change Password" class="subbtn"  />


</form>
</div>
</body>
</html>
