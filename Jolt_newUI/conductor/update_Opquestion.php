<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: exam_question_display.php');
}
$errors = array();
$success = array();
if(isset($_POST['save'])){
	
	$tid = $_POST['t_id'];
	$qid = $_POST['q_id'];
if (empty($_POST['question']) || empty($_POST['optiona']) || empty($_POST['marks'])) {
	$errors[] = 'Some of the required Fields are Empty';
}else{

}

	/*
	if (empty($_POST['f_name'])){
		$errors[] = 'You forgot to enter your student name';
	}else{
	*/
$qs = $_POST['question'];
$a = $_POST['optiona'];
$dif = $_POST['difficulty'];
$marks = $_POST['marks'];

		if(empty($errors)){

			$q = "update OpQuestion set question = '$qs',difficulty = '$dif',correctanswer = '$a',marks = '$marks' where testid = $tid AND qnid = $qid";
			$r = @mysqli_query($dbc, $q);
			if($r){
				header('Location: exam_question_display.php');
				/*
				$v = "select T.cid,C.cname from Test T,Course C where T.cid = C.cid AND T.testid = $tid";
				$t = @mysqli_query($dbc, $v);
				$row1 = mysqli_fetch_assoc($t);
				//echo '<h2 style = "color : #0000FF" align="left">Question Information Saved. </h2><br>';
				$q ="select Q.testid,Q.qnid,Q.question,Q.optiona,Q.optionb,Q.optionc,Q.optiond,Q.correctanswer,Q.marks
				from Question Q where
				Q.testid = $tid";
				?>
				<html>
				    <head>
				        <title>OES-Test Questions</title>
				        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
				        <link rel="stylesheet" type="text/css" href="../oes.css"/>
				
				    </head>
				    <body>
				        
				        <div id="container">
				            <div class="header">
				                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.gif" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>
				            </div>
				
				 <br><br><br>
				 <?php 
				$r = @mysqli_query($dbc, $q);
				$num = mysqli_num_rows($r);
				if($num > 0){
					echo '<h3 style = "color : #0000FF" > List Of All Questions For Test ID ' . $tid . '<br></h3>';
					echo '<h3 style = "color : #0000FF"> Course ID: ' . $row1['cid'] . '<br></h3>';
					echo '<h3 style = "color : #0000FF"> Course Name: ' . $row1['cname'] . '<br><br></h3>';
					echo '<table align= "center" cellspacing="5" cellpadding="5" width="70%" class="datatable">
							<tr>
							<td align="left"><img src="delete.jpg" width="40" height="40"></td>
							<td align="left"><b>Question Id</b></td>
							<td align="left"><b>Test Id</b></td>
							<td align="left"><b>Question</b></td>
							<td align="left"><b>Option A</b></td>
							<td align="left"><b>Option B</b></td>
							<td align="left"><b>Option C</b></td>
							<td align="left"><b>Option D</b></td>
							<td align="left"><b>Correcr Answer</b></td>
							<td align="left"><b>Marks</b></td>
							
							<td align="left"><img src="update.jpg" width="50" height="50"></td>
				
							</tr>
							';
					
					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
						 
						echo '<tr>
							<td><a href=delete_question.php?id='.$row['qnid'].'&tid='.$row['testid'].'><strong>DELETE</strong></a></td>
							<td align="left">' . $row['qnid'] . '</td>
							<td align="left">' . $row['testid'] . '</td>
							<td align="left">' . $row['question'] . '</td>
							<td align="left">' . $row['optiona'] . '</td>
							<td align="left">' . $row['optionb'] . '</td>
							<td align="left">' . $row['optionc'] . '</td>
							<td align="left">' . $row['optiond'] . '</td>
							<td align="left">' . $row['correctanswer'] . '</td>
							<td align="left">' . $row['marks'] . '</td>
							<td><a href=update_question.php?id='.$row['qnid'].'&tid='.$row['testid'].'><strong>EDIT</strong></a></td>
						
							';
					}
					echo '</table><br>';
				
					}else{
					echo '<h3 style = "color:#ff0000;"> There are no Test Available.</h3>';
					exit();
				}
								
				
				//echo '<li><a href="home.php">Home</a></li>';
				exit();
				*/
			}else{
				$success[] = 'To Prevent accidental updations, system will not allow propagated updations.';
				//echo '<p style = "color:#ff0000">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
				//exit();
			}
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
<div class="container">
		<h2 style = "color : #0000FF">Update Question Information</h2><br>
<form action = "update_Opquestion.php" method="post">
<table class="table table-striped">
<tr> <td>Test ID: </td><td>  <input readonly type="text" name="t_id" size = "50" value="<?php if (isset($_POST['t_id'])) echo $_POST['t_id']; ?>" /></td></tr>
<tr> <td>Question ID: </td><td>  <input readonly type="text" name="q_id" size = "50" value="<?php if (isset($_POST['q_id'])) echo $_POST['q_id']; ?>" /></td></tr>
<tr> <td>Question </td><td>  <textarea name="question" cols="40" rows="5"  > <?php if (isset($_POST['question'])) echo $_POST['question']; ?></textarea></td></tr>
<tr> <td>Difficulty </td><td>
<select name="difficulty">
                                            <option value="<?php if (isset($_POST['difficulty'])) echo $_POST['difficulty']; ?>" selected><?php if (isset($_POST['difficulty'])) echo $_POST['difficulty']; echo "~~"; ?></option>
                                            <option value="1">Easy</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Hard</option>
                                         
                                        </select></td></tr>
<tr> <td>Correct Answer: </td><td>  <input type="text" name="optiona" size = "50" maxlength = "150" value="<?php if (isset($_POST['optiona'])) echo $_POST['optiona']; ?>" /></td></tr>

<tr> <td>Marks: </td><td><input type="text" name="marks" size = "50" value="<?php if (isset($_POST['marks'])) echo $_POST['marks']; ?>" onkeyup="isnum(this)" /></td></tr>
</table><br>
<input type="submit" name="save" value="Save" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</body>
</html>
		<?php 
	}
	if(isset($_GET['qid'])){

$qid = $_GET['qid'];
//$tid = $_GET['tid'];
$q = "SELECT *FROM OpQuestion where qnid = $qid AND testid=" . $_SESSION['testqn'] . "";
$r = @mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r);
include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';
?>

<div class="container">
<h2 style = "color : #0000FF">Update Question Information</h2><br>
<form action = "update_Opquestion.php" method="post">
<table class="table table-striped">
<tr> <td>Test ID: </td><td>  <input readonly type="text" name="t_id" size = "50" value="<?php echo $row['testid']; ?>" /></td></tr>
<tr> <td>Question ID: </td><td>  <input readonly type="text" name="q_id" size = "50" value="<?php echo $row['qnid']; ?>" /></td></tr>
<tr> <td>Question </td><td>  <textarea name="question" cols="40" rows="5"  > <?php echo $row['question']; ?></textarea></td></tr>
<tr> <td>Difficulty </td><td>  
<select name="difficulty">	
										<?php if($row['difficulty'] == 1){?>
                                            <option value="<?php echo $row['difficulty']; ?>" selected><?php echo "Easy"; ?></option>
                                          
                                            <option value="2">Medium</option>
                                            <option value="3">Hard</option>
                                        <?php }
                                        elseif($row['difficulty'] == 2){?>
                                        	<option value="<?php echo $row['difficulty']; ?>" selected><?php echo "Medium"; ?></option>
                                          
                                            <option value="1">Easy</option>
                                            <option value="3">Hard</option>
                                    <?php }else {?>
                                    		<option value="<?php echo $row['difficulty']; ?>" selected><?php echo "Hard"; ?></option>
                                          
                                            <option value="1">Easy</option>
                                            <option value="2">Medium</option>

                                    <?php }?>
                                            
                                        </select></td></tr>
<tr> <td>Correct Answer: </td><td>  <input type="text" name="optiona" size = "50" maxlength = "150" value="<?php echo $row['correctanswer']; ?>" /></td></tr>

<tr> <td>Marks: </td><td><input type="text" name="marks" size = "50" value="<?php echo $row['marks']; ?>" onkeyup="isnum(this)" /></td></tr>

</table>
<br>
<input type="submit" name="save" value="Save" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</body>
</html>
<?php 
}
?>
