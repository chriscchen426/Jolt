<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
date_default_timezone_set("America/New_York");
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: test_info.php');
}
$errors = array();
$success = array();
if(isset($_POST['save'])){
	include '../mysqli_connect.php';
	//$cid = $_POST['c_id'];
	
	if (empty($_POST['c_id']) || empty($_POST['t_name']) || empty($_POST['t_desc'])|| empty($_POST['d_test'])
	|| empty($_POST['t_question'])|| empty($_POST['t_code'])) {
		$errors[] = 'Some of the required Fields are Empty.';
		//$_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
	}
	
	$fromtime = $_POST['testfrom'] . " " . date("H:i:s");
	$totime = $_POST['testto'] . " 23:59:59";
	$desc = $_POST['t_desc'];
	$tqn = $_POST['t_question'];
	$tqn2 = $_POST['t_question2'];
	$duration = $_POST['d_test'];
	$duration2 = $_POST['d_test2'];
	$tcode = $_POST['t_code'];
	$cid = $_POST['c_id'];
	$tname = $_POST['t_name'];
	$tid = $_POST['t_id'];
	$tcid = $_SESSION['tcid'];
	if (strtotime($fromtime) > strtotime($totime) || strtotime($totime) < time()){
		//$noerror = false;
		$errors[] = 'Start date of test is either less than todays date or greater than last date of test.';
	}
	if(empty($errors)){

		$q = "update Test set cid = '$cid',testname = '$tname',testdesc = '$desc',testfrom = '$fromtime',
		testto = '$totime',duration = $duration,opduration = $duration2,totalquestions = $tqn,totalopquestion = $tqn2,testcode = '$tcode',tcid = $tcid
		where testid = $tid";
		$r = @mysqli_query($dbc, $q);
		if($r){
			header('Location: test_info.php');
			//echo '<h2> Thank You. Course Information Saved. </h2><br>';
			//echo '<li><a href="home.php">Home</a></li>';
			//exit();
		}else{
			
			$success[] = 'To Prevent accidental updations, system will not allow propagated updations.';
			//echo '<p style = "color:#ff0000">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
			//exit();
		}

	}
include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>'; 
	?>

        <link rel="stylesheet" type="text/css" media="all" href="../calendar/jsDatePick.css" />
        <script type="text/javascript" src="../calendar/jsDatePick.full.1.1.js"></script>
        <script type="text/javascript">
            window.onload = function(){
               new JsDatePick({
                   useMode:2,
                   target:"testfrom"
                    //limitToToday:true <-- Add this should you want to limit the calendar until today.
               });

                new JsDatePick({
                    useMode:2,
                    target:"testto"
                    //limitToToday:true <-- Add this should you want to limit the calendar until today.
                });
            };
        </script>

        <script type="text/javascript" src="../validate.js" ></script>

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
    
<div class="container">
    
<h2 style = "color : #0000FF">Update Test Information</h2><br>
<form action = "update_test.php" method="post">
<table class="table table-striped" >
<tr> <td>Test ID </td><td><input type="text" readonly name="t_id" value="<?php if (isset($_POST['t_id'])) echo $_POST['t_id']; ?>" /></td></tr>
<tr> <td>Course ID: </td><td><input type="text" readonly name="c_id" value="<?php if (isset($_POST['c_id'])) echo $_POST['c_id']; ?>"/></td></tr>
<td>Testname: </td><td><input type="text" name="t_name"  value="<?php if (isset($_POST['t_name'])) echo $_POST['t_name']; ?>"/></td></tr>
<td>Test Decription: </td><td><input type="text" name="t_desc"  value="<?php if (isset($_POST['t_desc'])) echo $_POST['t_desc']; ?>"  /></td></tr>
<td>Test From: </td><td><input id="testfrom" type="text" readonly name="testfrom" value="<?php if (isset($_POST['testfrom'])) echo $_POST['testfrom']; ?>"/></td></tr>
<td>Test To: </td><td><input id="testto" type="text" readonly name="testto" value="<?php if (isset($_POST['testto'])) echo $_POST['testto']; ?>"/></td></tr>
<td>Multi-Questions Duration: </td><td><input type="text" name="d_test"  value="<?php if (isset($_POST['d_test'])) echo $_POST['d_test']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Open-ended Questions Duration: </td><td><input type="text" name="d_test2"  value="<?php if (isset($_POST['d_test2'])) echo $_POST['d_test2']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Multi-Questions: </td><td><input type="text" name="t_question" value="<?php if (isset($_POST['t_question'])) echo $_POST['t_question']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Open-ended Questions: </td><td><input type="text" name="t_question2" value="<?php if (isset($_POST['t_question2'])) echo $_POST['t_question2']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Test Code: </td><td><input type="text" name="t_code" value="<?php if (isset($_POST['t_code'])) echo $_POST['t_code']; ?>"/></td></tr>

</table><br>
<input type="submit" name="save" value="Save" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</html>
		<?php 	
	}

if(isset($_GET['id'])){
	//include '../mysqli_connect.php';
	//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
	//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
	$tid = $_GET['id'];
	//echo $id;
	$q = "SELECT *FROM Test where testid = $tid";
	$r = @mysqli_query($dbc, $q);
	$row = mysqli_fetch_array($r);
	$tf = Date('20y-m-d',strtotime($row['testfrom']));
	$tt = Date('20y-m-d',strtotime($row['testto']));
	//echo $tf;
	 	include 'nav.html'; 
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';
	?>

        <link rel="stylesheet" type="text/css" media="all" href="../calendar/jsDatePick.css" />
        <script type="text/javascript" src="../calendar/jsDatePick.full.1.1.js"></script>
        <script type="text/javascript">
            window.onload = function(){
                new JsDatePick({
                    useMode:2,
                    target:"testfrom"
                    //limitToToday:true <-- Add this should you want to limit the calendar until today.
                });

                new JsDatePick({
                    useMode:2,
                    target:"testto"
                    //limitToToday:true <-- Add this should you want to limit the calendar until today.
                });
            };
        </script>

        <script type="text/javascript" src="../validate.js" ></script>
        
<div class="container">
    
<h2 style = "color : #0000FF">Update Test Information</h2><br>
<form action = "update_test.php" method="post">
<table class="table table-striped">
<tr> <td>Test ID </td><td><input type="text" readonly name="t_id" value="<?php echo $row['testid']; ?>" /></td></tr>
<tr> <td>Course ID: </td><td><input type="text" readonly name="c_id" value="<?php echo $row['cid']; ?>"/></td></tr>
<td>Testname: </td><td><input type="text" name="t_name"  value="<?php echo $row['testname']; ?>"/></td></tr>
<td>Test Decription: </td><td><input type="text" name="t_desc"  value="<?php echo $row['testdesc']; ?>"  /></td></tr>
<td>Test Begin: </td><td><input id="testfrom" type="text" readonly name="testfrom" value="<?php echo $tf; ?>"/></td></tr>
<td>Test End: </td><td><input id="testto" type="text" readonly name="testto" value="<?php echo $tt; ?>"/></td></tr>
<td>Muti-Questions Duration: </td><td><input type="text" name="d_test"  value="<?php echo $row['duration']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Open-ended Question Duration: </td><td><input type="text" name="d_test2"  value="<?php echo $row['opduration']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Muti-Questions: </td><td><input type="text" name="t_question" value="<?php echo $row['totalquestions']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Open-ended Question: </td><td><input type="text" name="t_question2" value="<?php echo $row['totalopquestion']; ?>" onkeyup="isnum(this)"/></td></tr>
<td>Test Code: </td><td><input type="text" name="t_code" value="<?php echo $row['testcode']; ?>"/></td></tr>
</table><br>
<input type="submit" name="save" value="Save" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</ul>
</form>
</div>
</html>
<?php 
}
?>


