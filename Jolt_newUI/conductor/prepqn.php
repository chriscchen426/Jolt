
<?php


session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
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
if(isset($_POST['add'])){
	
include '../mysqli_connect.php';
if (strcmp($_POST['difficulty'], "<Choose the Difficulty>") == 0 || strcmp($_POST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_POST['question']) || empty($_POST['optiona']) || empty($_POST['optionb']) || empty($_POST['optionc']) || empty($_POST['optiond']) || empty($_POST['marks'])) {
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
include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';   
echo '<div class="container">';

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
$dif = $_POST['difficulty'];
$tid = (int)$_SESSION['testqn'];
	$sql = "Insert into Question values($tid,$newstd,'$qs','$a','$b','$c','$d','$ans',$marks,".$_SESSION['tcid'].",$dif)";
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
	           </div>
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
           
    <h2 style = "color : #0000FF">Create a M.C. Question</h2><br>
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

  <table class="table table-striped" >
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
          <input type="submit" name="add" value="Add Question" class="btn btn-primary"/>
          <input type="submit" value="Cancel" name="cancel" class="btn btn-primary">
             </form>
             </div>
            </body>
            </html>
