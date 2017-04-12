<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: testconductor_info.php');
}
$errors = array();
$success = array();
if(isset($_POST['save'])){
	$tcid = $_POST['t_id'];
	if (empty($_POST['f_name']) || empty($_POST['email']) || empty($_POST['pass'])) {
		$errors[] = 'Some of the required Fields are Empty.</h3><br>';
		//$_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
	}else{
	/*
	if (empty($_POST['f_name'])){
		$errors[] = 'You forgot to enter your testconductor name';
	}elseif (empty($_POST['email'])){
		$errors[] = 'You forgot to enter your email address';
	}elseif (empty($_POST['pass'])){
		$errors[] = 'You forgot to enter your password';
	}else{
	*/
		$fname = $_POST['f_name'];
		$uemail = $_POST['email'];
		$pass = $_POST['pass'];
		$uemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		if ($uemail === false) {
			$errors[] = 'Submitted email address is invalid';
		}
		if(!preg_match('/^[a-zA-Z]+$/',$fname)) {
			$errors[] = 'Invalid Testconductor Name.';
			//echo 'Invalid ' .$fileop[1]. '<br>';
		}
		
	}
		if(empty($errors)){

			$q = "update Testconductor set tcname = '$fname',email = '$uemail',password = '$pass' where tcid = $tcid";
			$r = @mysqli_query($dbc, $q);
			if(!$r){
				if(mysqli_errno ($dbc) == 1062) //duplicate value
					$success[] = 'Given Email ID voilates some constraints, please try with some other Email ID. OR Email ID already exists.';
				else
					$success[] = ' To Prevent accidental updations, system will not allow propagated updations.';
			}else{
				header('Location: testconductor_info.php');
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
   
<h2 style = "color : #0000FF">Update Testconductor Information</h2><br>
<form action = "update_testconductor.php" method="post">
<table class="table" border = "1">
<tr> <td>Testconductor ID </td><td><input readonly type="text" name="t_id" value="<?php if (isset($_POST['t_id'])) echo $_POST['t_id']; ?>" /></td></tr>
<tr> <td>Testconductor Name: </td><td><input type="text" name="f_name" value="<?php if (isset($_POST['f_name'])) echo $_POST['f_name']; ?>" /></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /></td></tr>
<tr> <td>Password: </td><td><input type="text" name="pass" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>"  /></td></tr>
</table>
<br>
<input type="submit" name="save" value="Save" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</table>
</form>
</div>
</div>
</body>
</html>

		<?php 
	}

if(isset($_GET['id'])){
include '../mysqli_connect.php';
$tcid = $_GET['id'];
$q = "SELECT *FROM Testconductor where tcid = $tcid";
$r = @mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r);
include 'nav.html';
?>
<div class="container">
        <h4>&nbsp;</h4>
        <h4>&nbsp;</h4>
<h2 style = "color : #0000FF">Update Testconductor Information</h2><br>
<form action = "update_testconductor.php" method="post">
<table class="table" border = "1">
<tr> <td>Testconductor ID </td><td><input readonly type="text" name="t_id" value="<?php echo $row['tcid']; ?>" /></td></tr>
<tr> <td>Testconductor Name: </td><td><input type="text" name="f_name" value="<?php echo $row['tcname']; ?>" /></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" value="<?php echo $row['email']; ?>"  /></td></tr>
<tr> <td>Password: </td><td><input type="text" name="pass" value="<?php echo $row['password']; ?>"  /></td></tr>
</table>
<br>
<input type="submit" name="save" value="Save" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>
<?php 
}
?>
