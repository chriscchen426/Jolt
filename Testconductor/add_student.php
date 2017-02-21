<?php

//USER Story: Client want to search student information from existing student database when register student for the course..
//Version: OES1.2
//Developed by: DIPAKKUMAR PATEL

session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
error_reporting(E_ALL ^ E_NOTICE);
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
//$tcid = (int) $_SESSION['tcid'];
$tcid = (int)$_SESSION['tcid'];
$errors = array();
$success = array();
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: home.php');
}
if(isset($_POST['add_data'])){
	//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
	//$errors = array();
	//$eid = $_POST['e_id'];
	if (empty($_POST['s_id']) || empty($_POST['f_name']) || empty($_POST['email']) || empty($_POST['cid']) || strcmp($_POST['cid'], "<Choose the Course>") == 0) {
		$errors[] = 'Some of the required Fields (*) are Empty.';
	}else{
	
	$sid = (int)$_POST['s_id'];
	$cid = $_POST['cid'];
	$email = $_POST['email'];
	$sname = $_POST['f_name'];
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	if ($email === false) {
		$errors[] = 'Submitted email address is invalid';
	}
	if(!preg_match('/^[a-zA-Z]+$/',$sname)) {
		$errors[] = 'Invalid Student Name.';
		//echo 'Invalid ' .$fileop[1]. '<br>';
	}
	$sql = "select *from Student where sid = $sid AND email='" . htmlspecialchars($_POST['email'], ENT_QUOTES) . "'";
	$t = @mysqli_query($dbc, $sql);
	//$num = @mysqli_num_rows($t);
	if (mysqli_num_rows($t) == 0) {
		//if($num = 0){
		$q = "select *from Student where email='" . htmlspecialchars($_POST['email'], ENT_QUOTES) . "'";
		$result = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($result) > 0) {
			$errors[] = 'Sorry, Email Already Exists. Please check your Student information.';
		}
	}
	}
	if(empty($errors)){
		$pieces = explode('-', $_POST['cid'],2);
		$rcid = $pieces[1];
		$data = explode('-', $rcid ,2);
		$cid = $pieces[0]."-".$data[0];
		$sql = "select *from Student where sid = $sid AND email='" . htmlspecialchars($_POST['email'], ENT_QUOTES) . "'";
		$t = @mysqli_query($dbc, $sql);
		//$num = @mysqli_num_rows($t);
		if (mysqli_num_rows($t) == 0) {
		//if($num = 0){
			
		$s = "INSERT INTO Student values($sid,'$sid','$sname','$email')";
		$r = @mysqli_query($dbc, $s);
			
		if(!$r){
			//echo '<h2 style = "color : #0000FF"> Student Data Added successfully. </h2><br>';
			//echo '<li><a href="home.php">Home</a></li>';
			//exit();
		
			echo '<p>' . mysqli_error($dbc) . '<br /> <br /> query: ' .$s . '</p>';
		}
		}
			
				
		
		$sql1 = "select *from TCS where sid = $sid AND cid = '$cid' AND tcid = $tcid";
		$t1 = @mysqli_query($dbc, $sql1);
		//$num1 = @mysqli_num_rows($t1);
		if (mysqli_num_rows($t1) > 0) {
			$success[] = 'Student already registered for the course.';
		//if($num1 = 0){
		}else{
		$q = "INSERT INTO TCS(cid,tcid,sid) values ('$cid',$tcid,$sid)";
	    $result = @mysqli_query($dbc, $q);
	    if($result){
	    	$msg = 'Student Data Added successfully. <a href="add_student.php"> ADD MORE </a>';
	    	
	    	?>
	    	<html>
    <head>
        <title>OES-Manage Students</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <link rel="stylesheet" type="text/css" href="../pinesh.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
         <style type="text/css">
         
         </style>
    </head>
    <body>
    <?php 
    echo "<div class=\"message\">" .$msg. "</div>";
    ?>
	    	<div id="container">
   <div class="header">
               <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
<h2 style = "color : #0000FF">Add Student Information</h2><br>
<form action = "add_student.php" method="post">
<table border = "1">
<tr> <td>Student ID </td><td><input type ="text" name="s_id" placeholder="*" value="" onkeyup="isnum(this)"/></td><td><input type="submit" value = "SEARCH" name="search" class="subbtn" ></td></tr>
<tr> <td>Student Name: </td><td><input type="text" name="f_name" placeholder="*" value="" /></td></tr>
<tr><td>Select Course ID:</td><td>
                           <?php  
                           error_reporting(E_ALL ^ E_NOTICE);
                           echo '<select name="cid">';
                           
                           include '../mysqli_connect.php';
                           $q ="select cid,cname from Course where tcid = $tcid AND status = 'Active'";
                            //$r = @mysqli_query($dbc, $q);
                            $r = @mysqli_query($dbc, $q);
                           
                           if(strcmp($_POST['cid'], "<Choose the Course>") == 0){
                           	echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
                           	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
                           		$cid = $row['cid']."-".$row['cname'];
                           		echo "<option value=\"$cid\">" . $cid . "</option>";
                           	}
                           }elseif(isset($_POST['cid'])){ ?>
                            <option value="<?php echo $_POST['cid']; ?>" selected><?php echo  $_POST['cid']; ?></option>	
                           <?php 
                           }else{
                           echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
                           while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
                           	$cid = $row['cid']."-".$row['cname'];
                           	echo "<option value=\"$cid\">" . $cid . "</option>";
                           }
                           }
                           ?>
                           </select>
                           <td><input type="submit" value = "VIEW COURSE INFO" name="search_course" class="subbtn" ></td></tr>
         <tr> <td><b>Semester: </b></td><td><input type="text" readonly name="sem" value="" /></td></tr>
		<tr> <td><b>Year: </b></td><td><input type="text" readonly name="year" value=""/></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" placeholder="*" value="" /></td></tr>
</table>
<br>
<input type="submit" name="add_data" value="Add" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</div>
</form>
</div>
</body>
</html>
	    	
	    	<?php 
	    	//echo '<li><a href="home.php">Home</a></li>';
	    	exit();
		}else{
			echo '<p>' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
		}
			//echo '<h3 align = "center"><p style = "color:#ff0000;"> Student already registered for course you have entered. </p></h3>';
		}
		}
	}
	
	//Search Course Information
	
	if(isset($_POST['search_course'])){
include '../mysqli_connect.php';
//echo '<h3><a href="home.php">Home</a></h3>';
//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
if(strcmp($_POST['cid'], "<Choose the Course>") == 0){
	$errors[] = 'Please Select Course ID.';
}
if(empty($errors)){
	$pieces = explode('-', $_POST['cid'],2);
	$rcid = $pieces[1];
	$data = explode('-', $rcid ,2);
	$cid = $pieces[0]."-".$data[0];
	//$sectionid = $pieces[1];
	//$cname = $data[1];
	
	$sql = "select year,semester from Course where cid = '$cid'";
	$result = @mysqli_query($dbc, $sql);
	$r = mysqli_fetch_array($result);
    $sem = $r['semester'];
    $year = $r['year'];
	?>
	<html>
	<head>
	<title>OES-Manage Students</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../oes.css"/>
	<link rel="stylesheet" type="text/css" href="../pinesh.css"/>
	<script type="text/javascript" src="../validate.js" ></script>
	<style type="text/css">
	 
	</style>
	</head>
	<body>
	
		    	<div id="container">
	   <div class="header">
	               <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
	            </div><br><br>
	            <div align="center"><br><br>
	            <body>
	<h2 style = "color : #0000FF">Add Student Information</h2><br>
	<form action = "add_student.php" method="post">
	<table border = "1">
	<tr> <td>Student ID </td><td><input type ="text" name="s_id" placeholder="*" value="<?php echo $_POST['s_id']; ?>" onkeyup="isnum(this)"/></td><td><input type="submit" value = "SEARCH" name="search" class="subbtn" ></td></tr>
	<tr> <td>Student Name: </td><td><input type="text" name="f_name" placeholder="*" value="<?php echo $_POST['f_name']; ?>" /></td></tr>
	<tr><td>Select Course ID:</td><td>
	                           <?php  
	                           error_reporting(E_ALL ^ E_NOTICE);
	                           echo '<select name="cid">';
	                           
	                           include '../mysqli_connect.php';
	                           $q ="select cid,cname from Course where tcid = $tcid AND status = 'Active'";
	                            //$r = @mysqli_query($dbc, $q);
	                            $r = @mysqli_query($dbc, $q);
	                           
	                           if(strcmp($_POST['cid'], "<Choose the Course>") == 0){
	                           	echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
	                           	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	                           		$cid = $row['cid']."-".$row['cname'];
	                           		echo "<option value=\"$cid\">" . $cid . "</option>";
	                           	}
	                           }elseif(isset($_POST['cid'])){ ?>
	                            <option value="<?php echo $_POST['cid']; ?>" selected><?php echo  $_POST['cid']; ?></option>	
	                           <?php 
	                           }else{
	                           echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
	                           while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	                           	$cid = $row['cid']."-".$row['cname'];
	                           	echo "<option value=\"$cid\">" . $cid . "</option>";
	                           }
	                           }
	                           ?>
	                           </select>
	                           <td><input type="submit" value = "VIEW COURSE INFO" name="search_course" class="subbtn" ></td></tr>
	         <tr> <td><b>Semester: </b></td><td><input type="text" readonly name="sem" value="<?php echo $sem ?>" /></td></tr>
			<tr> <td><b>Year: </b></td><td><input type="text" readonly name="year" value="<?php echo $year ?>"/></td></tr>
	<tr> <td>E-mail: </td><td><input type="text" name="email" placeholder="*" value="<?php echo $_POST['email'] ?>" /></td></tr>
	</table>
	<br>
	<input type="submit" name="add_data" value="Add" class="subbtn"/>
	<input type="submit" value="Cancel" name="cancel" class="subbtn">
	</div>
	</form>
	</div>
	</body>
	</html>
	
					
					<?php 
					exit();
				}
				
			}
			

	
	
//Search Existing Student

	if(isset($_POST['search'])){
		
		if(empty($_POST['s_id'])){
			$errors[] = 'Please Enter Your Student ID';
		}else{
			$sid = (int)$_POST['s_id'];
		}
		
		
		if(empty($errors)){
			$s = "select *from Student where sid = $sid";
			$r = @mysqli_query($dbc, $s);
			if (mysqli_num_rows($r) == 0) {
				$success[] = 'Student Does Not Exist.';
			}
$r1 = mysqli_fetch_array($r);
?>
<html>
<head>
<title>OES-Manage Students</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../oes.css"/>
<link rel="stylesheet" type="text/css" href="../pinesh.css"/>
<script type="text/javascript" src="../validate.js" ></script>
<style type="text/css">
 
</style>
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
<h2 style = "color : #0000FF">Add Student Information</h2><br>
<form action = "add_student.php" method="post">
<table border = "1">
<tr> <td>Student ID </td><td><input type ="text" name="s_id" placeholder="*" value="<?php echo $_POST['s_id']; ?>" onkeyup="isnum(this)"/></td><td><input type="submit" value = "SEARCH" name="search" class="subbtn" ></td></tr>
<tr> <td>Student Name: </td><td><input type="text" name="f_name" placeholder="*" value="<?php echo $r1['sname']; ?>" /></td></tr>
<tr><td>Select Course ID:</td><td>
                           <?php  
                           error_reporting(E_ALL ^ E_NOTICE);
                           echo '<select name="cid">';
                           
                           include '../mysqli_connect.php';
                           $q ="select cid,cname from Course where tcid = $tcid AND status = 'Active'";
                            //$r = @mysqli_query($dbc, $q);
                            $r = @mysqli_query($dbc, $q);
                           
                           if(strcmp($_POST['cid'], "<Choose the Course>") == 0){
                           	echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
                           	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
                           		$cid = $row['cid']."-".$row['cname'];
                           		echo "<option value=\"$cid\">" . $cid . "</option>";
                           	}
                           }elseif(isset($_POST['cid'])){ ?>
                            <option value="<?php echo $_POST['cid']; ?>" selected><?php echo  $_POST['cid']; ?></option>	
                           <?php 
                           }else{
                           echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
                           while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
                           	$cid = $row['cid']."-".$row['cname'];
                           	echo "<option value=\"$cid\">" . $cid . "</option>";
                           }
                           }
                           ?>
                           </select>
                           <td><input type="submit" value = "VIEW COURSE INFO" name="search_course" class="subbtn" ></td></tr>
         <tr> <td><b>Semester: </b></td><td><input type="text" readonly name="sem" value="<?php echo $_POST['sem'] ?>" /></td></tr>
		<tr> <td><b>Year: </b></td><td><input type="text" readonly name="year" value="<?php echo $_POST['year'] ?>"/></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" placeholder="*" value="<?php echo $r1['email'] ?>" /></td></tr>
</table>
<br>
<input type="submit" name="add_data" value="Add" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</div>
</form>
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
        <title>OES-Manage Students</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <link rel="stylesheet" type="text/css" href="../pinesh.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
         <style type="text/css">
         
         </style>
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
  //exit(); 
 
}
echo '<br>';
?>
<html>
    <head>
        <title>OES-Manage Students</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <link rel="stylesheet" type="text/css" href="../pinesh.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
         <style type="text/css">
         
         </style>
    </head>
    <body>
    
	    	<div id="container">
   <div class="header">
               <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
<h2 style = "color : #0000FF">Add Student Information</h2><br>
<form action = "add_student.php" method="post">
<table border = "1">
<tr> <td>Student ID </td><td><input type ="text" name="s_id" placeholder="*" value="<?php echo $_POST['s_id'] ?>" onkeyup="isnum(this)"/></td><td><input type="submit" value = "SEARCH" name="search" class="subbtn" ></td></tr>
<tr> <td>Student Name: </td><td><input type="text" name="f_name" placeholder="*" value="<?php echo $_POST['f_name'] ?>" /></td></tr>
<tr><td>Select Course ID:</td><td>
                           <?php  
                           error_reporting(E_ALL ^ E_NOTICE);
                           echo '<select name="cid">';
                           
                           include '../mysqli_connect.php';
                           $q ="select cid,cname from Course where tcid = $tcid AND status = 'Active'";
                            //$r = @mysqli_query($dbc, $q);
                            $r = @mysqli_query($dbc, $q);
                           
                           if(strcmp($_POST['cid'], "<Choose the Course>") == 0){
                           	echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
                           	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
                           		$cid = $row['cid']."-".$row['cname'];
                           		echo "<option value=\"$cid\">" . $cid . "</option>";
                           	}
                           }elseif(isset($_POST['cid'])){ ?>
                            <option value="<?php echo $_POST['cid']; ?>" selected><?php echo  $_POST['cid']; ?></option>	
                           <?php 
                           }else{
                           echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
                           while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
                           	$cid = $row['cid']."-".$row['cname'];
                           	echo "<option value=\"$cid\">" . $cid . "</option>";
                           }
                           }
                           ?>
                           </select>
                           <td><input type="submit" value = "VIEW COURSE INFO" name="search_course" class="subbtn" ></td></tr>
         <tr> <td><b>Semester: </b></td><td><input type="text" readonly name="sem" value="<?php echo $_POST['sem'] ?>" /></td></tr>
		<tr> <td><b>Year: </b></td><td><input type="text" readonly name="year" value="<?php echo $_POST['year'] ?>"/></td></tr>
<tr> <td>E-mail: </td><td><input type="text" name="email" placeholder="*" value="<?php echo $_POST['email'] ?>" /></td></tr>
</table>
<br>
<input type="submit" name="add_data" value="Add" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</div>
</form>
</div>
</body>
</html>