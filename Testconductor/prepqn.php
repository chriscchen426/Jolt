
<?php


session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
error_reporting(E_ALL ^ E_NOTICE);
$errors = array();
$success = array();
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
//if(isset($_GET['id'])){
include '../mysqli_connect.php';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: exam_question_display.php');
}
if(isset($_POST['add'])){
	
include '../mysqli_connect.php';
if (strcmp($_POST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_POST['question']) || empty($_POST['optiona']) || empty($_POST['optionb']) || empty($_POST['optionc']) || empty($_POST['optiond']) || empty($_POST['marks'])) {
	$errors[] = 'Some of the required Fields are Empty';
}else{
if (strcasecmp($_POST['optiona'], $_POST['optionb']) == 0 || strcasecmp($_POST['optiona'], $_POST['optionc']) == 0 || strcasecmp($_POST['optiona'], $_POST['optiond']) == 0 || strcasecmp($_POST['optionb'], $_POST['optionc']) == 0 || strcasecmp($_POST['optionb'], $_POST['optiond']) == 0 || strcasecmp($_POST['optionc'], $_POST['optiond']) == 0) {
	$errors[] = 'Two or more options are representing same answers.Verify Once again.';
}
$r = "select * from Question where testid=" . $_SESSION['testqn'] . " and question='" . htmlspecialchars($_REQUEST['question'], ENT_QUOTES) . "'";
$result = @mysqli_query($dbc, $r);
if ($r1 = mysqli_fetch_array($result)) {
	
	$errors[] = 'Sorry, You trying to enter same question for Same test.';
}
}


if(empty($errors)){
	
$sql = "select max(qnid) as qn from Question where testid=" . $_SESSION['testqn'] . "";
$result = @mysqli_query($dbc, $sql);
$r = mysqli_fetch_array($result);
if(is_null($r['qn'])){
	$newstd = 1;
}else{
	$newstd=$r['qn'] + 1;
}
$qs = $_POST['question'];

$a = $_POST['optiona'];
$b = $_POST['optionb'];
$c = $_POST['optionc'];
$d = $_POST['optiond'];
$marks = $_POST['marks'];
$ans = $_POST['correctans'];
$tid = (int)$_SESSION['testqn'];
	$sql = "Insert into Question values($tid,$newstd,'$qs','$a','$b','$c','$d','$ans',$marks,".$_SESSION['tcid'].")";
	$result = @mysqli_query($dbc, $sql);
	if($result){
		
	$success[] = 'New question has been created. <a href="prepqn.php">Add More Question</a>';
		//exit();
		header('Location: exam_question_display.php');
		
	}else{
		echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
		//exit();
	}
	
	?>
				<html>
	    <head>
	        <title>OES-Manage Questions</title>
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
        <title>OES-Manage Questions</title>
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
            </div><br>
   <div align="center"><br><br>
    <h2 style = "color : #0000FF">Question Preparation Form</h2><br>
    <form action = "prepqn.php" method="post">
    <?php
    
$sql = "select count(*) as q from Question where testid=" . $_SESSION['testqn'] . "";
$result = @mysqli_query($dbc, $sql);
$r1 = mysqli_fetch_array($result);

$r = "select totalquestions from Test where testid=" . $_SESSION['testqn'] . "";
$result = @mysqli_query($dbc, $r);
$r2 = mysqli_fetch_array($result);
if ((int) $r1['q'] == (int) htmlspecialchars_decode($r2['totalquestions'], ENT_QUOTES))
    echo "<div class=\"pmsg\"> Test Name: " . $_SESSION['testname'] . "<br/>Course ID: " . $_SESSION['cid'] . "<br/>Status: All the Questions are Created for this test.</div>";
else
    echo "<div class=\"pmsg\"> Test Name: " . $_SESSION['testname'] . "<br/>Course ID: " . $_SESSION['cid'] . "";
?>
<div class="container">
  <table cellpadding="20" cellspacing="40" style="text-align:left;" >
  <tr><td colspan= "4"> <Font color = "#FF0000">NOTE: ALL * Field Must Required.</Font></td></tr>
                                <tr>
                                    <td><b>Question</b></td>
                                    <td><textarea name="question" placeholder="*" cols="40" rows="5"  ><?php if(isset($_POST['question'])) echo $_POST['question'];?></textarea></td>
                                </tr>
                                <tr>
                                    <td><b>Option A</b></td>
                                    <td><input type="text" name="optiona" placeholder="*" value="<?php if(isset($_POST['optiona'])) echo $_POST['optiona'];?>" size="50"  /></td>
                                </tr>
                                <tr>
                                    <td><b>Option B</b></td>
                                    <td><input type="text" name="optionb" placeholder="*" value="<?php if(isset($_POST['optionb'])) echo $_POST['optionb'];?>" size="50"  /></td>
                                </tr>

                                <tr>
                                    <td><b>Option C</b></td>
                                    <td><input type="text" name="optionc" placeholder="*" value="<?php if(isset($_POST['optionc'])) echo $_POST['optionc'];?>" size="50"  /></td>
                                </tr>
                                <tr>
                                    <td><b>Option D</b></td>
                                    <td><input type="text" name="optiond" placeholder="*" value="<?php if(isset($_POST['optiond'])) echo $_POST['optiond'];?>" size="50"  /></td>
                                </tr>
                                <tr>
                                    <td><b>Correct Answer</b></td>
                                    <td>
                                        <select name="correctans">
                                            <option value="<Choose the Correct Answer>" selected>&lt;Choose the Correct Answer&gt;</option>
                                            <option value="optiona">Option A</option>
                                            <option value="optionb">Option B</option>
                                            <option value="optionc">Option C</option>
                                            <option value="optiond">Option D</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Marks</b></td>
                                    <td><input type="text" name="marks" placeholder="*" size="30" value="<?php if(isset($_POST['marks'])) echo $_POST['marks'];?>" onkeyup="isnum(this)" /></td>

                                </tr>

                            </table>
                            </div>
                            <br>
          <input type="submit" name="add" value="Add Question" class="subbtn"/>
          <input type="submit" value="Cancel" name="cancel" class="subbtn">
             </form>
             </div>
            </body>
            </html>
