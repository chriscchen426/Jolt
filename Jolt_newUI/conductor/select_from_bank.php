
<?php


session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';
error_reporting(E_ALL ^ E_NOTICE);
$errors = array();
$success = array();
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
//if(isset($_GET['id'])){
include '../mysqli_connect.php';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: exam_question_display.php');
}
if(isset($_POST['addOp'])){
	
$sqle = "select max(Q.qnid) as qne, max(OP.qnid) as opqne from QuestionBank Q, OpQuestionBank OP where Q.difficulty = 1 and OP.difficulty = 1";
$resulte = @mysqli_query($dbc, $sqle);
$re = mysqli_fetch_array($resulte);
$sqlm = "select max(Q.qnid) as qne, max(OP.qnid) as opqne from QuestionBank Q, OpQuestionBank OP where Q.difficulty = 1 and OP.difficulty = 2";
$resultm = @mysqli_query($dbc, $sqlm);
$rm = mysqli_fetch_array($resultm);
$sqlh = "select max(Q.qnid) as qne, max(OP.qnid) as opqne from QuestionBank Q, OpQuestionBank OP where Q.difficulty = 1 and OP.difficulty = 3";
$resulte = @mysqli_query($dbc, $sqlh);
$rh = mysqli_fetch_array($resulte);

if (empty($_POST['easy']) || empty($_POST['medium'])  || empty($_POST['hard']) || empty($_POST['easyop']) || empty($_POST['mediumop'])  || empty($_POST['hardop'])) {
	$errors[] = 'Some of the required Fields are Empty';
}
if($re['qne'] < $_POST['easy'] || $re['opqne'] < $_POST['easyop'] || $rm['qne'] < $_POST['medium']|| $rm['opqne'] < $_POST['opmedium']|| $rh['qne'] < $_POST['hard']|| $rh['qne'] < $_POST['ophard']){
	$errors[] = 'Some of the Number typed is more than total questions in Bank';
}

if(empty($errors)){
	
$easy = $_POST['easy'];
$medium = $_POST['medium'];
$hard = $_POST['hard'];
$easyop = $_POST['easyop'];
$mediumop = $_POST['mediumop'];
$hardop = $_POST['hardop'];
$tid = (int)$_SESSION['testqn'];

	$sqle = "Insert into Question (select $tid,qnid,question,optiona,optionb,optionc,optiond,correctanswer,marks,uploader,1 from QuestionBank where difficulty = 1 order by rand() limit $easy)";  //need to modify
	$resulte = @mysqli_query($dbc, $sqle);
	$sqlm = "Insert into Question (select $tid,qnid,question,optiona,optionb,optionc,optiond,correctanswer,marks,uploader,2 from QuestionBank where difficulty = 2 order by rand() limit $medium)";  //need to modify
	$resultm = @mysqli_query($dbc, $sqlm);
	$sqlh = "Insert into Question (select $tid,qnid,question,optiona,optionb,optionc,optiond,correctanswer,marks,uploader,3 from QuestionBank where difficulty = 3 order by rand() limit $hard)";  //need to modify
	$resulth = @mysqli_query($dbc, $sqlh);
	$sqlope = "Insert into OpQuestion (select $tid,qnid,question,correctanswer,marks,uploader,1 from OpQuestionBank where difficulty = 1 order by rand() limit $easyop)";  //need to modify
	$resultope = @mysqli_query($dbc, $sqlope);
	$sqlopm = "Insert into OpQuestion (select $tid,qnid,question,correctanswer,marks,uploader,2 from OpQuestionBank where difficulty = 2 order by rand() limit $mediumop)";  //need to modify
	$resultopm = @mysqli_query($dbc, $sqlopm);
	$sqloph = "Insert into OpQuestion (select $tid,qnid,question,correctanswer,marks,uploader,3 from OpQuestionBank where difficulty = 3 order by rand() limit $hardop)";  //need to modify
	$resultoph = @mysqli_query($dbc, $sqloph); 
	if($resulte && $resultm && $resulth && $resultope && $resultopm && $resultoph ){
		
	$success[] = 'New question has been created. <a href="prepqn.php">Add More Question</a><a href="exam_question_display.php">Click to see</a>';
		//exit();
		header('Location: exam_question_display.php');
		
	}else{
		echo '<div class="container">';
		echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sqle .$sqlm.$sqlh.$sqlope.$sqlopm.$sqloph. '</p>';
		//exit();
	}
	
	?>

	     <?php
		  include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';   
echo '<div class="container">';	
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

	            </body>
	            </html>
	            
				<?php 
				exit();
}

}
    ?>
    

     <?php
	  	include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';   
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
            
    <h2 style = "color : #0000FF">Select Questions From Bank</h2><br>
    <form action = "select_from_bank.php" method="post">
    <?php
    
$sql = "select count(*) as q from OpQuestion where testid=" . $_SESSION['testqn'] . "";
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

  <table class="table table-striped">
  <tr><td colspan= "4"> <Font color = "#FF0000">NOTE: ALL * Field Must Required.</Font></td></tr>
                                <tr>
                                    <td><b>No. of Easy Multi-Choice Question</b></td>
                                    <td><input type="text" name="easy" placeholder="*" value="<?php ?>" size="50"  /></td>
                                </tr>
                                <tr>
                                    <td><b>No. of Medium  Multi-Choice Question</b></td>
                                    <td><input type="text" name="medium" placeholder="*" value="<?php ?>" size="50"  /></td>
                                </tr>
								<tr>
                                    <td><b>No. of Hard  Multi-Choice Question</b></td>
                                    <td><input type="text" name="hard" placeholder="*" value="<?php ?>" size="50"  /></td>
                                </tr>
								<tr>
                                    <td><b>No. of Easy Open-ended Question</b></td>
                                    <td><input type="text" name="easyop" placeholder="*" value="<?php ?>" size="50"  /></td>
                                </tr>
                                <tr>
                                    <td><b>No. of Medium Open-ended Question</b></td>
                                    <td><input type="text" name="mediumop" placeholder="*" value="<?php ?>" size="50"  /></td>
                                </tr>
								<tr>
                                    <td><b>No. of Hard Open-ended Question</b></td>
                                    <td><input type="text" name="hardop" placeholder="*" value="<?php ?>" size="50"  /></td>
                                </tr>
                                

                            </table>
                            </div>
                            <br>
          <input type="submit" name="addOp" value="Add Question" class="subbtn"/>
          <input type="submit" value="Cancel" name="cancel" class="subbtn">
             </form>
             </div>
            </body>
            </html>
