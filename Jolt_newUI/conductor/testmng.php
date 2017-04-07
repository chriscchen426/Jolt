<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
$tcid = $_SESSION['tcid'];
$errors = array();
$success = array();
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
date_default_timezone_set("America/New_York");
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: test_info.php');
}
if(isset($_POST['add'])){
include '../mysqli_connect.php';
if (empty($_POST['testname']) || empty($_POST['testdesc']) || empty($_POST['totalqn']) || empty($_POST['duration']) || empty($_POST['testfrom']) || empty($_POST['testto']) || empty($_POST['testcode'])) {
	$errors[] = 'Some of the required Fields are Empty.</h3><br>';
	//$_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
}
	$fromtime = $_POST['testfrom'] . " " . date("H:i:s");
	$totime = $_POST['testto'] . " 23:59:59";
	$desc = $_POST['testdesc'];
	$tqn = $_POST['totalqn'];
  $tqn2 = $_POST['totalqn2'];
	$duration = $_POST['duration'];
  $duration2 = $_POST['duration2'];
	$tcode = $_POST['testcode'];
	//$cid = $_POST['cid'];
	$tname = $_POST['testname'];
	$tcid = $_SESSION['tcid'];
	

if (strtotime($fromtime) > strtotime($totime) || strtotime($fromtime) < (time() - 3600)) {
	//$noerror = false;
	$errors[] = 'Start date of test is either less than todays date or greater than last date of test.';
}

if(empty($errors)){
	$pieces = explode('-', $_POST['cid'],2);
	$rcid = $pieces[1];
	$data = explode('-', $rcid ,2);
	$cid = $pieces[0]."-".$data[0];


	
	$q = "select max(testid) as tst from Test";
	$r = @mysqli_query($dbc, $q);
	$row = @mysqli_fetch_array($r);
	if (is_null($row['tst'])){
		$newstd = 1;
	}else{
		$newstd=$row['tst'] + 1;
	}
	$sql = "Insert into Test values($newstd,'$cid','$tname','$desc',curDate(),curTime(),'$fromtime','$totime',$duration,$duration2,$tqn,$tqn2,0,'$tcode',$tcid)";
  //echo $sql;
	$result = @mysqli_query($dbc, $sql);
	if(!$result){
		if(mysqli_errno ($dbc) == 1062) //duplicate value
			$success[] = 'Given Test Name voilates some constraints, please try with some other name.';
		else
			echo mysqli_error($dbc);
		}else{
		$success[] = 'New test has been created.';
		header('Location: test_info.php');
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

    <h2 style = "color : #0000FF">Test Preparation Form</h2><br>
    <form action = "testmng.php" method="post">
<table class="table table-striped">
                        <tr>
                           <td>Select Course ID:</td><td>
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
                         </tr>
                        <tr>
                            <td><b>Test Name</b></td><td><input type="text" name="testname" value="<?php if (isset($_POST['testname'])) echo $_POST['testname']; ?>" size="16" onkeyup="isalphanum(this)" /></td>
                            <td style = "color:#ff0000"><b>Note:</b><br/>Test Name must be Unique<br/> in order to identify different<br/> tests on same subject.</td>
                        </tr>
                        <tr>
                            <td><b>Test Description</b></td><td><textarea name="testdesc" cols="20" rows="3" ></textarea></td>
                            <td style = "color:#ff0000"><b>Describe here:</b><br/>What the test is all about?</td>
                        </tr>
                        <tr>
                            <td><b>Total Multi-Questions</b></td><td><input type="text" name="totalqn" value="<?php if (isset($_POST['totalqn'])) echo $_POST['totalqn']; ?>" size="16" onkeyup="isnum(this)" /></td>

                        </tr>
                        <tr>
                            <td><b>Total Open-ended Questions</b></td><td><input type="text" name="totalqn2" value="<?php if (isset($_POST['totalqn2'])) echo $_POST['totalqn2']; ?>" size="16" onkeyup="isnum(this)" /></td>

                        </tr>
                        <tr><td><b>Multi-Questions Duration(Mins)</b></td><td><input type="text" name="duration" value="<?php if (isset($_POST['duration'])) echo $_POST['duration']; ?>" size="16" onkeyup="isnum(this)" /></td>
                            </tr>
                        <tr>
                        <tr><td><b>Open-ended Questions Duration(Mins)</b></td><td><input type="text" name="duration2" value="<?php if (isset($_POST['duration2'])) echo $_POST['duration2']; ?>" size="16" onkeyup="isnum(this)" /></td>
                            </tr>
                        <tr>
                            <td><b>Test Begin</b> </td><td><input id="testfrom" type="text" name="testfrom" value="<?php if (isset($_POST['testfrom'])) echo $_POST['testfrom']; ?>" size="16" readonly /></td>
                        </tr>
                        <tr>
                            <td><b>Test End</b> </td><td><input id="testto" type="text" name="testto" value="<?php if (isset($_POST['testto'])) echo $_POST['testto']; ?>" size="16" readonly /></td>
                        </tr>
                         <tr>
                            <td><b>Test Secret Code</b></td><td><input type="text" name="testcode" value="<?php if (isset($_POST['testcode'])) echo $_POST['testcode']; ?>" size="16" onkeyup="isalphanum(this)" /></td>
                            <td style = "color:#ff0000"><b>Note:</b><br/>Candidates must enter<br/>this code in order to <br/> take the test</td>
                        </tr>
                      </table><br>
                    <input type="submit" name="add" value="Add Test" class="subbtn"/>
                    <input type="submit" value="Cancel" name="cancel" class="subbtn">
                      </form>
</div>

</body>
</html>
<?php 
exit();
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
   
  <div class="container">

    <h2 style = "color : #0000FF">Test Preparation Form</h2><br>
    <form action = "testmng.php" method="post">
<table class="table table-striped">
                        <tr>
                           <td>Select Course ID:</td><td>
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
                         </tr>
                        <tr>
                            <td><b>Test Name</b></td><td><input type="text" name="testname" value="" size="16" onkeyup="isalphanum(this)" /></td>
                            <td style = "color:#ff0000"><b>Note:</b><br/>Test Name must be Unique<br/> in order to identify different<br/> tests on same subject.</td>
                        </tr>
                        <tr>
                            <td><b>Test Description</b></td><td><textarea name="testdesc" cols="20" rows="3" ></textarea></td>
                            <td style = "color:#ff0000"><b>Describe here:</b><br/>What the test is all about?</td>
                        </tr>
                        <tr>
                            <td><b>Total Multi-Questions</b></td><td><input type="text" name="totalqn" value="" size="16" onkeyup="isnum(this)" /></td>

                        </tr>
                        <tr>
                            <td><b>Total Open-ended Questions</b></td><td><input type="text" name="totalqn2" value="" size="16" onkeyup="isnum(this)" /></td>

                        </tr>
                        <tr><td><b>Multi-Questions Duration(Mins)</b></td><td><input type="text" name="duration" value="" size="16" onkeyup="isnum(this)" /></td>
                            </tr>
                        <tr><td><b>Open-ended Questions Duration(Mins)</b></td><td><input type="text" name="duration2" value="" size="16" onkeyup="isnum(this)" /></td>
                            </tr>
                        <tr>
                            <td><b>Test Begin</b> </td><td><input id="testfrom" type="text" name="testfrom" value="" size="16" readonly /></td>
                        </tr>
                        <tr>
                            <td><b>Test End</b> </td><td><input id="testto" type="text" name="testto" value="" size="16" readonly /></td>
                        </tr>
                         <tr>
                            <td><b>Test Secret Code</b></td><td><input type="text" name="testcode" value="" size="16" onkeyup="isalphanum(this)" /></td>
                            <td style = "color:#ff0000"><b>Note:</b><br/>Candidates must enter<br/>this code in order to <br/> take the test</td>
                        </tr>
                      </table><br>
                    <input type="submit" name="add" value="Add Test" class="subbtn"/>
                    <input type="submit" value="Cancel" name="cancel" class="subbtn">
                    </form>
</div>

</body>
</html>