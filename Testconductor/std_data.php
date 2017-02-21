<?php

//USER Story: Client request for a print feature to be able to print out list of students in each course.
//Version: OES1.2
//Developed by: DIPAKKUMAR PATEL

session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
$tcid = $_SESSION['tcid'];
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
$errors = array();
$success = array();
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: home.php');
}
if(isset($_POST['submit'])){
	//include '../mysqli_connect.php';
	include '../mysqli_connect.php';
	if(strcmp($_POST['cid'], "<Choose the Course>") == 0 || strcmp($_POST['sem'], "<Choose the Semester>") == 0 || strcmp($_POST['year'], "<Choose the Year>") == 0){
		$errors[] = 'Some of the required Fields are Empty.';
	}
	if(empty($errors)){
		//$cid = $_POST['cid'];
		//$_SESSION['cid'] = $cid;
		$pieces = explode('-', $_POST['cid'],2);
		$rcid = $pieces[1];
		$data = explode('-', $rcid ,2);
		$cid = $pieces[0]."-".$data[0];
		$sem = $_POST['sem'];
		$year = (int)$_POST['year'];
		$v = "select cname from Course where cid = '$cid'";
		$t = @mysqli_query($dbc, $v);
		$row1 = mysqli_fetch_assoc($t);

		$q ="select S.sid,S.sname,S.email,C.cid,C.cname,S.password from
		Student S,Testconductor T,Course C,TCS D where
		S.sid = D.sid And
		D.tcid = T.tcid AND
		D.cid = C.cid AND
		T.tcid = $tcid AND
		C.cid = '$cid' AND
		C.year = $year AND
		C.semester = '$sem' AND
		C.status = 'Active'";
		
		$r = @mysqli_query($dbc, $q);
		$num = mysqli_num_rows($r);
		if($num > 0){
			?>
							<html>
							    <head>
							        <title>OES-Manage Student</title>
							        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
							        <link rel="stylesheet" type="text/css" href="../oes.css"/>
							<link rel="stylesheet" type="text/css" href="../anju.css"/>
							<script language="javascript">
function printPage(printContent) {
var display_setting="toolbar=yes,menubar=yes,";
display_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";


var printpage=window.open("","",display_setting);
printpage.document.open();
printpage.document.write('<html><head><title>Exam Report</title><link rel="stylesheet" type="text/css" href="../oes.css" /></head>');
printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>');
printpage.document.close();
printpage.focus();
}
</script> 
							    </head>
							    <body>
					    
					                <div id="printsection">
							        <div id="container">
							         
							            <div class="header">
							                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
							            </div>
							
							 <br><br><br>
							 <?php 
			echo '<h3 style = "color : #0000FF" > List Of All Student Currently registered For Following Course<br><br></h3>';
			echo '<h3 style = "color : #0000FF"> Course ID: ' . $cid . '<br></h3>';
			echo '<h3 style = "color : #0000FF"> Course Name: ' . $row1['cname'] . '<br></h3>';
			echo '<h3 style = "color : #0000FF"> Semester: ' . $sem . '<br></h3>';
			echo '<h3 style = "color : #0000FF"> Year: ' . $year . '<br><br></h3>';
			echo '<table align= "center" cellspacing="5" cellpadding="5" width="70%" class="datatable">
			<tr>
			<th>DELETE</th>
			<th>Student Id</th>
			<th>Student Name</th>
			<th>Email</th>
			
			<th>EDIT</th>
		
			</tr>
			';
		
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
					
				echo '<tr>
			<td><a href=delete_student.php?id='.$row['sid'].'><strong>DELETE</strong></a></td>
			<td align="left">' . $row['sid'] . '</td>
			<td align="left">' . $row['sname'] . '</td>
			<td align="left">' . $row['email'] . '</td>
			
			<td><a href=update_student.php?id='.$row['sid'].'><strong>EDIT</strong></a></td>
		
			';
			}
			echo '</table><br>';
			echo '</div>';
			echo '</div>';
			echo '<input type="button" value="Print Preview" class="subbtn" onClick="printPage(printsection.innerHTML)">';
			?>
			
			<?php 
			exit();
		}else{
			$success[] = 'There are no students registered.';
			//exit();
		}
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
		}
		echo '<br>';
		?>
		<div id="container">
   <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
            
<h2 style = "color : #0000FF">Student Data Information Form</h2><br>
<form action="std_data.php" method="post">
<table border = "1">
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
                           </select></td></tr>
<tr> <td>Select Semester:</td><td> <?php  include 'stdsemester.php' ?></td></tr>
<tr> <td>Select Year:</td><td> <?php  include 'stdyear.php' ?></td></tr>
</table>
<br>
<input type="submit" name="submit" value="submit" class="subbtn"/>
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</div>
</form>
</div>

</body>
</html>