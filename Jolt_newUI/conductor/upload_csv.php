<?php

//USER Story: Client wants to be able to register students into a class for exams thorugh uploading .CSV file.
//Version: OES1.2
//Developed by: DIPAKKUMAR PATEL


session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
error_reporting(E_ALL ^ E_NOTICE);
$errors = array();
$success = array();
include '../mysqli_connect.php';
$tcid = (int) $_SESSION['tcid'];
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h3><a href="home.php">Home</a></h3>';
//echo 'Welcome ' . $_SESSION['tcname'] . '<br>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_POST['Cancel']) == 'Cancel') {
	header('Location: home.php');
}



if(isset($_POST['upload'])){
	include '../mysqli_connect.php';
	//echo '<h3><a href="home.php">Home</a></h3>';
	//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
	if(strcmp($_POST['data_update'], "<Choose the Action>") == 0 || strcmp($_POST['cid'], "<Choose the Course>") == 0 || empty($_FILES['file'])){
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
				if(!preg_match('/^\d+$/',$fileop[0])) {
					$errors[] = 'Invalid Student ID: ' .$fileop[0]. '. Please Check your CSV file.';
			
				}elseif(!preg_match('/^[a-zA-Z]+$/',$fileop[1])) {
					$errors[] = 'Invalid Student Name: ' .$fileop[1]. '. Please Check your CSV file.';
					//echo 'Invalid ' .$fileop[1]. '<br>';
				}elseif(!filter_var($fileop[2], FILTER_VALIDATE_EMAIL)) {
					//$b = $fileop[2];
					$errors[] = 'Invalid Student Email: ' .$fileop[2]. '. Please Check your CSV file.';
				}
			}
		}else{
				$errors[] = 'Invalid File. Please select only .CSV file';
			}
			if(empty($errors)){
			//$tcid = (int) $_POST['tcid'];
			$tcid = (int) $_SESSION['tcid'];
			//$cid = $_POST['cid'];
			$pieces = explode('-', $_POST['cid'],2);
			$rcid = $pieces[1];
			$data = explode('-', $rcid ,2);
			$cid = $pieces[0]."-".$data[0];
			//$sectionid = $pieces[1];
			//$cname = $data[1];
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file,"r");
			fgets($handle);
			$sql = "select sid from Student";
			$r = @mysqli_query($dbc, $sql);
			$num = @mysqli_num_rows($r);
			if ($num == 0){
				while(($fileop = fgetcsv($handle,1000,",")) !== false){
					$v = "INSERT INTO Student(sid,password,sname,email)values
					($fileop[0],'$fileop[0]','$fileop[1]','$fileop[2]')";
					$t = @mysqli_query($dbc, $v);
					$q = "INSERT INTO TCS(cid,tcid,sid) values ('$cid',$tcid,$fileop[0])";
					$result = @mysqli_query($dbc, $q);
				}
				if($result || $t){
					$success[] = 'Data Uploaded Successfully.<br>';
					echo 'Course ID: ' . $cid . '<br>';
					echo 'File uploaded information shown below: <br>';
					echo 'File Name: ' . $_FILES['file']['name'] . '<br>';
					echo 'File Size: ' . $_FILES['file']['size'] . ' KB <br>';
					echo 'File Type: ' . $_FILES['file']['type'] . '<br>';
                   // exit();
					//echo '<li><a href="login.php">Click here to Login</a></li>';
				}else{
					echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
					echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$v . '</p>';
				}
					
			}else{
					
				$status = $_POST['data_update'];
				if($status = 'UPDATE'){
					$h = "delete from TCS where tcid = $tcid AND cid ='$cid'";
					$z = @mysqli_query($dbc, $h);
				}
				//$k ="select *from TCS where tcid = $tcid AND cid ='$cid'";
				//$l = @mysqli_query($dbc, $k);
				//$num1 = @mysqli_num_rows($l);
				while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{

					//echo $fileop[0];
					while(($fileop = fgetcsv($handle,1000,",")) !== false){

						if($row['sid'] == $fileop[0]){
							$q = "INSERT INTO TCS(cid,tcid,sid) values ('$cid',$tcid,$fileop[0])";
							$result = @mysqli_query($dbc, $q);
						}else{
							$v = "INSERT INTO Student(sid,password,sname,email)values
							($fileop[0],'$fileop[0]','$fileop[1]','$fileop[2]')";
							$t = @mysqli_query($dbc, $v);
								
							$q = "INSERT INTO TCS(cid,tcid,sid) values ('$cid',$tcid,$fileop[0])";
							$result = @mysqli_query($dbc, $q);
								
						}
					}
					
				}
				if($result || $t){
                    $success[] = 'Data Uploaded Successfully.<br>';
                    echo 'File uploaded information shown below: <br>';
                    echo 'Course ID: ' . $cid . '<br>';
                    echo 'File Name: ' . $_FILES['file']['name'] . '<br>';
                    echo 'File Size: ' . $_FILES['file']['size'] . ' KB <br>';
                    echo 'File Type: ' . $_FILES['file']['type'] . '<br>';
                    //exit();
                }else{
                     echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
                      echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$v . '</p>';
                  }
			}
			
		
	
}
}
}

if(isset($_POST['search'])){
	include '../mysqli_connect.php';
	//echo '<h3><a href="home.php">Home</a></h3>';
	//echo '<h3 align = "right"><li><a href="logout.php">LOGOUT</a></li></h3>';
	if(strcmp($_POST['cid'], "<Choose the Course>") == 0){
		$errors[] = 'Please Select Course ID.';
	}
	if(strcmp($_POST['data_update'], "<Choose the Action>") == 0 || empty($_FILES['file'])){
		$errors[] = 'Some of the required Fields are Empty.';
	}
	if(empty($errors)){
		$pieces = explode('-', $_POST['cid'],2);
		$rcid = $pieces[1];
		$data = explode('-', $rcid ,2);
		$cid = $pieces[0]."-".$data[0];
		//$sectionid = $pieces[1];
		$cname = $data[1];
		//echo $cid;
		$sql = "select year,semester from Course where cid = '$cid'";
		$result = @mysqli_query($dbc, $sql);
		$r = mysqli_fetch_array($result);
		
		

//}
?>
		<?php include 'nav.html';?>
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
		<h4>&nbsp;</h4>
		<h4>&nbsp;</h4>
		 <div class="container">
		  
		          
		<h2 style = "color : #0000FF">Student Data Upload Form</h2><br>

<form action="upload_csv.php" method="post" enctype="multipart/form-data">
<table class="table table-striped">
<tr> <td>Select Action </td><td><select name = "data_update">
<?php if(strcmp($_POST['data_update'], "<Choose the Action>") == 0){?>
<option value="<Choose the Action>" selected>&lt;Choose the Action&gt;</option>
<option value = "ADD"> ADD </option>
<option value = "UPDATE"> UPDATE </option>
<?php 
}elseif(isset($_POST['data_update'])){ ?>
 <option value="<?php echo $_POST['data_update']; ?>" selected><?php echo  $_POST['data_update']; ?></option>
 <?php }else{
 ?>
 <option value="<Choose the Action>" selected>&lt;Choose the Action&gt;</option>
<option value = "ADD"> ADD </option>
<option value = "UPDATE"> UPDATE </option>
 <?php }
 ?>


</select></td></tr>
		<tr> <td><b>Course ID: </b></td><td><input type="text" readonly name="cid" value="<?php echo $cid ?>" /></td></tr>
		<tr> <td><b>Semester: </b></td><td><input type="text" readonly name="sem" value="<?php echo $r['semester'] ?>" /></td></tr>
		<tr> <td><b>Year: </b></td><td><input type="text" readonly name="year" value="<?php echo $r['year'] ?>" /></td></tr>
		<tr> <td>Select File:</td><td><input type="file" name="file" accept=".csv"/></td> <td><font style = "color:#ff0000;">Please select only .CSV file</td></tr>
</table>
<br>
<input type="submit" name="upload" value="Upload" class="subbtn"/>
<input type="submit" name="Cancel" value="Cancel" class="subbtn"/>
</div>
</form>
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
<h4>&nbsp;</h4>
		<h4>&nbsp;</h4>
<div class="container">
   

<h2 style = "color : #0000FF">Student Data Upload Form</h2><br>

<form action="upload_csv.php" method="post" enctype="multipart/form-data">
<table class="table table-striped">
<tr> <td>Select Action </td><td><select name = "data_update">
<?php 
error_reporting(E_ALL ^ E_NOTICE);
if(strcmp($_POST['data_update'], "<Choose the Action>") == 0){?>
<option value="<Choose the Action>" selected>&lt;Choose the Action&gt;</option>
<option value = "ADD"> ADD </option>
<option value = "UPDATE"> UPDATE </option>
<?php 
}elseif(isset($_POST['data_update'])){ ?>
 <option value="<?php echo $_POST['data_update']; ?>" selected><?php echo  $_POST['data_update']; ?></option>
 <?php }else{
 ?>
 <option value="<Choose the Action>" selected>&lt;Choose the Action&gt;</option>
<option value = "ADD"> ADD </option>
<option value = "UPDATE"> UPDATE </option>
 <?php }
 ?>


</select></td></tr>
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
                           </select>
                           <td><input type="submit" value = "VIEW COURSE INFO" name="search" class="subbtn" ></td></tr>
         <tr> <td><b>Semester: </b></td><td><input type="text" readonly name="sem" value="<?php echo $_POST['sem'] ?>" /></td></tr>
		<tr> <td><b>Year: </b></td><td><input type="text" readonly name="year" value="<?php echo $_POST['year'] ?>"/></td></tr>
                           
<tr> <td>Select File:</td><td><input type="file" name="file" accept=".csv"/></td> <td><font style = "color:#ff0000;">Please select only .CSV file</td></tr>
</table>
<br>
<input type="submit" name="upload" value="Upload" class="subbtn"/>
<input type="submit" name="Cancel" value="Cancel" class="subbtn"/>
</div>
</form>
</div>
</body>
</html>

