<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
//$tid = $_SESSION['testqn'];
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: home.php');
}
include '../mysqli_connect.php';
$errors = array();
$success = array();
if(isset($_POST['upload'])){
	
	//echo '<h3><a href="home.php">Home</a></h3>';
	//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
	if(empty($_FILES['file'])){
		$errors[] = 'Some of the required Fields are Empty.';
	}
	//if(empty($errors)){
	if (isset($_FILES['file'])){
		$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		if(in_array($_FILES['file']['type'],$mimes)){
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file,"r");
			fgets($handle);
			while(($fileop = fgetcsv($handle,1000,",")) !== false){
				if(!preg_match('/^\d+$/',$fileop[7])) {
					$errors[] = 'Invalid Marks for the question: ' .$fileop[0]. '. Please Check your CSV file.';
				}elseif($fileop[7]>3 || $fileop[7]<1){
					$errors[] = 'Difficulty should only between 1 and 3';
				}
				elseif(empty($fileop[0]) || empty($fileop[1]) || empty($fileop[2]) || empty($fileop[3]) || empty($fileop[4]) || empty($fileop[5])|| empty($fileop[6])|| empty($fileop[7])){
					$errors[] = 'Some of the fields of the question are empty. Please Check your CSV file.';
			}
			}
					/*
				}elseif(!preg_match('/^[a-zA-Z]+$/',$fileop[1])) {
					$errors[] = 'Invalid Student Name: ' .$fileop[1]. '. Please Check your CSV file.';
					//echo 'Invalid ' .$fileop[1]. '<br>';
				}elseif(!filter_var($fileop[2], FILTER_VALIDATE_EMAIL)) {
					//$b = $fileop[2];
					$errors[] = 'Invalid Student Email: ' .$fileop[2]. '. Please Check your CSV file.';
				}
			}*/
		}else{
			$errors[] = 'Invalid File. Please select only .CSV file';
		}
		if(empty($errors)){
			//$tid = (int) $_POST['tid'];
			
			//$v = "select totalquestions from Test where testid=" . $_SESSION['testqn'] . "";
		//$result1 = @mysqli_query($dbc, $v);
		//$r1 = mysqli_fetch_array($result1);
			//echo $r1['totalquestions'];
			$tid = (int)$_SESSION['testqn'];
			//$q = "delete from Question where testid=" . $_SESSION['testqn'] . "";
		    //$w = @mysqli_query($dbc, $q);
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file,"r");
			fgets($handle);
			
				while(($fileop = fgetcsv($handle,1000,",")) !== false){
				$sql = "select max(qnid) as qn from Question where testid=" . $_SESSION['testqn'] . "";
                $result = @mysqli_query($dbc, $sql);
                $r = mysqli_fetch_array($result);
               if(is_null($r['qn'])){
	           $newstd = 1;
               }else{
	           $newstd=$r['qn'] + 1;
               }
               //echo $newstd;
					//if($newstd <= $r1['totalquestions']){
					$v = "INSERT INTO Question values
					($tid,$newstd,'$fileop[0]','$fileop[1]','$fileop[2]','$fileop[3]','$fileop[4]','$fileop[5]','$fileop[6]',".$_SESSION['tcid'].",'$fileop[7]')"; 
					$t = @mysqli_query($dbc, $v);
					if(!$t){
						echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$t . '</p>';
					}
					//}
					}
					header('Location: exam_question_display.php');
					
				}
					
			}
}

?>
<html>
    <head>
        <title>OES-Manage Questions</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>
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
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>
            </div>
            <div align="center"><br><br>
            <body>

<h2 style = "color : #0000FF">Test Questions Upload Form</h2><br>
<form action="upload_questions.php" method="post" enctype="multipart/form-data">
<table border = "1">
<tr> <td>Test ID </td><td><input type="text" name="tid" readonly size = "34" value="<?php echo $_SESSION['testqn'] ?>" /></td></tr>
<tr> <td>Course ID </td><td><input type="text" name="tid" readonly size = "34" value="<?php echo $_SESSION['course_id']." ".$_SESSION['course_name'] ?>" /></td></tr>
<tr> <td>Select File:</td><td><input type="file" name="file" accept=".csv"/></td> <td><font style = "color:#ff0000;">Please select only .CSV file</td><td><a href="download.php">download template</a></td</tr>
</table>
<br>
<input type="submit" name="upload" value="Upload" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>

