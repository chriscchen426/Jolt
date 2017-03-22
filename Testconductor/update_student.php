<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$errors = array();
$success = array();
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: home.php');
}
if(isset($_POST['save'])){
	
	$sid = $_POST['s_id'];
	if (empty($_POST['f_name']) || empty($_POST['email']) || empty($_POST['pass'])) {
		$errors[] = 'Some of the required Fields are Empty.</h3><br>';
		//$_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
	}else{
	/*
	if (empty($_POST['f_name'])){
		$errors[] = 'You forgot to enter your student name';
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
			$errors[] = 'Invalid Student Name.';
			//echo 'Invalid ' .$fileop[1]. '<br>';
		}
	}
		if(empty($errors)){
			
			$q = "update Student set sname = '$fname',email = '$uemail',password = '$pass' where sid = $sid";
			$r = @mysqli_query($dbc, $q);
			if(!$r){
				if(mysqli_errno ($dbc) == 1062) //duplicate value
					$success[] = 'Given Email ID voilates some constraints, please try with some other Email ID. OR Email ID already exists.';
				else
					$success[] = ' To Prevent accidental updations, system will not allow propagated updations.';
			}else{
				$cid = $_SESSION['cid'];
				$tcid = $_SESSION['tcid'];
				$v = "select cname from Course where cid = '$cid'";
				$t = @mysqli_query($dbc, $v);
				$row1 = mysqli_fetch_assoc($t);
				//echo '<h2 style = "color : #0000FF" align="left">Student Information Saved. </h2><br>';
				$q ="select S.sid,S.sname,S.email,C.cid,C.cname,S.password from
				Student S,Testconductor T,Course C,TCS D where
				S.sid = D.sid And
				D.tcid = T.tcid AND
				D.cid = C.cid AND
				T.tcid = $tcid AND
				C.cid = '$cid'";
				
				?>
				<html>
				    <head>
				        <title>OES-Manage Student</title>
				        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
				        <link rel="stylesheet" type="text/css" href="../oes.css"/>
				
				    </head>
				    <body>
				        
				        <div id="container">
				            <div class="header">
				                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.gif" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>
				            </div>
				
				 <br><br><br>
				 <?php 
				
				$r = @mysqli_query($dbc, $q);
				$num = mysqli_num_rows($r);
				if($num > 0){
					echo '<h3 style = "color : #0000FF" > List Of All Student Currently registered For Following Course<br><br></h3>';
					echo '<h3 style = "color : #0000FF"> Course ID: ' . $cid . '<br></h3>';
					echo '<h3 style = "color : #0000FF"> Course Name: ' . $row1['cname'] . '<br><br></h3>';
					echo '<table align= "center" cellspacing="5" cellpadding="5" width="70%" class="datatable">
							<tr>
							<td align="left"><img src="delete.jpg" width="40" height="40"></td>
							<td align="left"><b>Student Id</b></td>
							<td align="left"><b>Student Name</b></td>
							<td align="left"><b>Email</b></td>
							<td align="left"><b>Password</b></td>
							<td align="left"><img src="update.jpg" width="50" height="50"></td>
				
							</tr>
							';
					
					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
						 
						echo '<tr>
							<td><a href=delete_student.php?id='.$row['sid'].'><strong>DELETE</strong></a></td>
							<td align="left">' . $row['sid'] . '</td>
							<td align="left">' . $row['sname'] . '</td>
							<td align="left">' . $row['email'] . '</td>
							<td align="left">' . $row['password'] . '</td>
							<td><a href=update_student.php?id='.$row['sid'].'><strong>EDIT</strong></a></td>
						
							';
					}
					echo '</table><br>';
				
					}else{
					$success[] = ' There are no students registered.';
					//exit();
				}
				
				//echo '<li><a href="home.php">Home</a></li>';
				exit();
			}

		}
		

		?>
		<html>
    <head>
        <title>OES-Manage Student</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
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
   <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center">
		<h2 style = "color : #0000FF">Update Student Information</h2><br>
<form action = "update_student.php" method="post">
<table border = "1">
<tr> <td>Student ID: </td><td>  <input readonly type="text" name="s_id" value="<?php if (isset($_POST['s_id'])) echo $_POST['s_id']; ?>" /></td></tr>
<tr> <td>Student Name: </td><td><input type="text" name="f_name" value="<?php if (isset($_POST['f_name'])) echo $_POST['f_name']; ?>" /></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /></td></tr>
<tr> <td>Password: </td><td><input type="text" name="pass" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>"  /></td></tr>
</table><br>
<input type="submit" name="save" value="Save" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</body>
</html>
		<?php 
	}
if(isset($_GET['id'])){
include '../mysqli_connect.php';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$sid = $_GET['id'];
$q = "SELECT *FROM Student where sid = $sid";
$r = @mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r);
?>
<html>
    <head>
        <title>OES-Manage Student</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
    </head>
    <body>
   <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center">
<h2 style = "color : #0000FF">Update Student Information</h2><br>
<form action = "update_student.php" method="post">
<table border = "1">
<tr> <td>Student ID: </td><td>  <input readonly type="text" name="s_id" value="<?php echo $row['sid']; ?>" /></td></tr>
<tr> <td>Student Name: </td><td><input type="text" name="f_name" value="<?php echo $row['sname']; ?>" /></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" value="<?php echo $row['email']; ?>"  /></td></tr>
<tr> <td>Password: </td><td><input type="text" name="pass" value="<?php echo $row['password']; ?>"  /></td></tr>
</table>
<br>
<input type="submit" name="save" value="Save" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</body>
</html>
<?php 
}
?>
