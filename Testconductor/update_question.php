<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: exam_question_display.php');
}
$errors = array();
$success = array();
if(isset($_POST['save'])){
	
	$tid = $_POST['t_id'];
	$qid = $_POST['q_id'];
if (empty($_POST['question']) || empty($_POST['optiona']) || empty($_POST['optionb']) || empty($_POST['optionc']) || empty($_POST['optiond']) || empty($_POST['marks'])) {
	$errors[] = 'Some of the required Fields are Empty';
}else{
if (strcasecmp($_POST['optiona'], $_POST['optionb']) == 0 || strcasecmp($_POST['optiona'], $_POST['optionc']) == 0 || strcasecmp($_POST['optiona'], $_POST['optiond']) == 0 || strcasecmp($_POST['optionb'], $_POST['optionc']) == 0 || strcasecmp($_POST['optionb'], $_POST['optiond']) == 0 || strcasecmp($_POST['optionc'], $_POST['optiond']) == 0) {
	$errors[] = 'Two or more options are representing same answers.Verify Once again.';
}
}

	/*
	if (empty($_POST['f_name'])){
		$errors[] = 'You forgot to enter your student name';
	}else{
	*/
$qs = $_POST['question'];
$a = $_POST['optiona'];
$b = $_POST['optionb'];
$c = $_POST['optionc'];
$d = $_POST['optiond'];
$marks = $_POST['marks'];
$ans = $_POST['correctans'];
		if(empty($errors)){

			$check = "select belong from Question where testid = $tid AND qnid = $qid";
			$rcheck = @mysqli_query($dbc, $rcheck);
			if($_SESSION['tcid'] == $rcheck['belong']){

				$q = "update Question set question = '$qs',optiona = '$a',optionb = '$b',optionc = '$c',
				optiond = '$d',correctanswer = '$ans',marks = '$marks' where testid = $tid AND qnid = $qid";
				$r = @mysqli_query($dbc, $q);
				if($r){
					header('Location: exam_question_display.php');
					
				}else{
					$success[] = 'To Prevent accidental updations, system will not allow propagated updations.';
					//echo '<p style = "color:#ff0000">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
					//exit();
				}
			}
			else{
				echo "You can't modify other conductor uploaded questions";
			}
		}
		
		
		?>
		<html>
    <head>
        <title>OES-Manage Test</title>
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
		<h2 style = "color : #0000FF">Update Question Information</h2><br>
<form action = "update_question.php" method="post">
<table border = "1">
<tr> <td>Test ID: </td><td>  <input readonly type="text" name="t_id" size = "50" value="<?php if (isset($_POST['t_id'])) echo $_POST['t_id']; ?>" /></td></tr>
<tr> <td>Question ID: </td><td>  <input readonly type="text" name="q_id" size = "50" value="<?php if (isset($_POST['q_id'])) echo $_POST['q_id']; ?>" /></td></tr>
<tr> <td>Question </td><td>  <textarea name="question" cols="40" rows="5"  > <?php if (isset($_POST['question'])) echo $_POST['question']; ?></textarea></td></tr>
<tr> <td>Option A </td><td>  <input type="text" name="optiona" size = "50" maxlength = "150" value="<?php if (isset($_POST['optiona'])) echo $_POST['optiona']; ?>" /></td></tr>
<tr> <td>Option B </td><td>  <input type="text" name="optionb" size = "50" maxlength = "150" value="<?php if (isset($_POST['optionb'])) echo $_POST['optionb']; ?>" /></td></tr>
<tr> <td>Option C </td><td>  <input type="text" name="optionc" size = "50" maxlength = "150" value="<?php if (isset($_POST['optionc'])) echo $_POST['optionc']; ?>" /></td></tr>
<tr> <td>Option D </td><td>  <input type="text" name="optiond" size = "50" maxlength = "150" value="<?php if (isset($_POST['optiond'])) echo $_POST['optiond']; ?>" /></td></tr>
<tr> <td>Correct Option </td><td>  
<select name="correctans">
                                            <option value="<?php if (isset($_POST['correctans'])) echo $_POST['correctans']; ?>" selected><?php if (isset($_POST['correctans'])) echo $_POST['correctans']; ?></option>
                                            <option value="optiona">Option A</option>
                                            <option value="optionb">Option B</option>
                                            <option value="optionc">Option C</option>
                                            <option value="optiond">Option D</option>
                                        </select></td></tr>

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
$q = "SELECT *FROM Question where qnid = $qid AND testid=" . $_SESSION['testqn'] . "";
$r = @mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r);
?>
<html>
    <head>
        <title>OES-Manage Test</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
         <script type="text/javascript" src="../validate.js" ></script>
    </head>
    <body>
   <div class="header">
               <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center">
<h2 style = "color : #0000FF">Update Question Information</h2><br>
<form action = "update_question.php" method="post">
<table border = "1">
<tr> <td>Test ID: </td><td>  <input readonly type="text" name="t_id" size = "50" value="<?php echo $row['testid']; ?>" /></td></tr>
<tr> <td>Question ID: </td><td>  <input readonly type="text" name="q_id" size = "50" value="<?php echo $row['qnid']; ?>" /></td></tr>
<tr> <td>Question </td><td>  <textarea name="question" cols="40" rows="5"  > <?php echo $row['question']; ?></textarea></td></tr>
<tr> <td>Option A </td><td>  <input type="text" name="optiona" size = "50" maxlength = "150" value="<?php echo $row['optiona']; ?>" /></td></tr>
<tr> <td>Option B </td><td>  <input type="text" name="optionb" size = "50" maxlength = "150" value="<?php echo $row['optionb']; ?>" /></td></tr>
<tr> <td>Option C </td><td>  <input type="text" name="optionc" size = "50" maxlength = "150" value="<?php echo $row['optionc']; ?>" /></td></tr>
<tr> <td>Option D </td><td>  <input type="text" name="optiond" size = "50" maxlength = "150" value="<?php echo $row['optiond']; ?>" /></td></tr>
<tr> <td>Correct Option </td><td>  
<select name="correctans">
                                            <option value="<?php echo $row['correctanswer']; ?>" selected><?php echo $row['correctanswer']; ?></option>
                                            <option value="optiona">Option A</option>
                                            <option value="optionb">Option B</option>
                                            <option value="optionc">Option C</option>
                                            <option value="optiond">Option D</option>
                                        </select></td></tr>

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
