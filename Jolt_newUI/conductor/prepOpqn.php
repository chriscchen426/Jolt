
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
	
include '../mysqli_connect.php';
if (strcmp($_POST['difficulty'], "<Choose the Difficulty>") == 0 || empty($_POST['question']) || empty($_POST['optiona'])  || empty($_POST['marks'])) {
	$errors[] = 'Some of the required Fields are Empty';
}else{

$r = "select * from OpQuestion where testid=" . $_SESSION['testqn'] . " and question='" . htmlspecialchars($_REQUEST['question'], ENT_QUOTES) . "'";
$result = @mysqli_query($dbc, $r);
if ($r1 = mysqli_fetch_array($result)) {
	
	$errors[] = 'Sorry, You trying to enter same question for Same test.';
}
}
include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';   
echo '<div class="container">';

if(empty($errors)){
	
$sql = "select max(qnid) as qn from OpQuestion where testid=" . $_SESSION['testqn'] . "";
$result = @mysqli_query($dbc, $sql);
$r = mysqli_fetch_array($result);
if(is_null($r['qn'])){
	$newstd = 1;
}else{
	$newstd=$r['qn'] + 1;
}
$qs = $_POST['question'];

$a = $_POST['optiona'];

$dif = $_POST['difficulty'];

$marks = $_POST['marks'];

$tid = (int)$_SESSION['testqn'];
	$sql = "Insert into OpQuestion values($tid,$newstd,'$qs','$a',$marks,".$_SESSION['tcid'].",$dif)";  //need to modify
	$result = @mysqli_query($dbc, $sql);
	if($result){
		
	$success[] = '<h2>New question has been created. </h2>
		<h2><a href="prepOpqn.php">Add More Question.</a></h2>
		<h2><a href="exam_question_display.php">Click to view all questions.</a></h>';
		//exit();
		header('Location: exam_question_display.php');
		
	}else{
		echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
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
            
    <h2 style = "color : #0000FF">Create an Open_ended Question</h2><br>
    <form action = "prepOpqn.php" method="post">
    <?php
    
$sql = "select count(*) as q from OpQuestion where testid=" . $_SESSION['testqn'] . "";
$result = @mysqli_query($dbc, $sql);
$r1 = mysqli_fetch_array($result);

$r = "select totalopquestion from Test where testid=" . $_SESSION['testqn'] . "";
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
                                    <td><b>Question</b></td>
                                    <td><textarea name="question" placeholder="*" cols="40" rows="5"  ><?php if(isset($_POST['question'])) echo $_POST['question'];?></textarea></td>
                                </tr>
                                <tr>
                                    <td><b>Correct Answer</b></td>
                                    <td><input type="text" name="optiona" placeholder="*" value="<?php if(isset($_POST['optiona'])) echo $_POST['optiona'];?>" size="50"  /></td>
                                </tr>
                                <tr>
                                    <td><b>Difficulty</b></td>
                                    <td>
                                        <select name="difficulty">
                                            <option value="<Choose the Difficulty>" selected>&lt;Choose the Difficulty&gt;</option>
                                            <option value="1">Easy</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Hard</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Score</b></td>
                                    <td><input type="text" name="marks" placeholder="*" size="30" value="<?php if(isset($_POST['marks'])) echo $_POST['marks'];?>" onkeyup="isnum(this)" /></td>

                                </tr>

                            </table>
                           
                            <br>
          <input type="submit" name="addOp" value="Add Question" class="btn btn-primary"/>
          <input type="submit" value="Cancel" name="cancel" class="btn btn-primary">
             </form>
             </div>
            </body>
            </html>
