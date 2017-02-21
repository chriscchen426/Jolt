
<?php
session_start();
if(isset($_SESSION['stdname'])){
	header('Location: home.php');
}
echo '<pre><h2 align = "right"><a href="index.php"><img src="home.jpg" width="50" height="50"></a></h2></pre>';
if(isset($_POST['submit'])){
	include 'mysqli_connect.php';
	
	$errors = array();
	
	if(!empty($_POST['e-mail']) && !empty($_POST['pass']))
	{
	$uemail = $_POST['e-mail'];
	$cpass = $_POST['pass'];
	$uemail = filter_input(INPUT_POST, 'e-mail', FILTER_VALIDATE_EMAIL);
	if ($uemail == false) {
		$errors[] = 'Submitted email address is invalid';
	}else{
	$sql = "select sname,sid,password from Student where email = '$uemail'";
	
	$r = @mysqli_query($dbc,$sql);
	$num = mysqli_num_rows($r);
	if($num == 0){
		$errors[] = 'You entered wrong e-mail or e-mail does not exit';
		//echo '<h2 style = color:#ff0000;">You entered wrong e-mail or e-mail does not exit.</h2><br>';
	}else{
	$row = mysqli_fetch_assoc($r);
	$c_pass = $row['password'];
	$stdid = (int) $row['sid'];
	$stdname = $row['sname'];
	if($cpass != $c_pass){
		$errors[] = 'You entered wrong password';
		//echo '<h2 style = color:#ff0000;">You entered wrong password.</h2><br>';
	}
	}
	}
	if(empty($errors)){
		
	session_start();
	//$_SESSION['stdname']=$stdname;
	$_SESSION['stdid']=$stdid;
	
	if($stdid = (int)$c_pass){
	//header('Location: home.php');
		//session_start();
		//$_SESSION['stdid']=$stdid;
		header('Location: preset.php');
	}else{
		//session_start();
		//$_SESSION['stdid']= $stdid;
		$_SESSION['stdname']=$stdname;
		header('Location: home.php');
		
	}
	
}else{
	
		echo'<h2 align = "center"><p style = "color:#ff0000;"> Errors!</p><h2>';
		foreach($errors as $msg){
			echo '<h4 align = "center"><p style= "color:#ff0000"> ' .$msg. '<br  /></p><h4>';
}
}
}

}
?>

<html>
  <head>
    <title>Online Examination System</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="pinesh.css">
    <link rel="stylesheet" type="text/css" href="login.css"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <style>

</style>
  <script type="text/javascript">window.history.forward();function noBack(){window.history.forward();}</script>
</HEAD>
<BODY onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">

<div id="container">
 <div class="header">
   <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
 
<br><br><br>
  <div align="center">
 
<form action="student_login.php" method="post">

<div class="login-block">
<table>
<tr><td colspan = "2"><h2 align = "center" style = "color: #0000FF"> Student Login </h2></td></tr>
<tr> <td><b>Username: </b></td><td><input type="text" name="e-mail" placeholder="Enter Your email" size="30" maxlength="50"  required> </td></tr>
<tr> <td><b>Password: </b></td><td><input type="password" name="pass" placeholder="Enter Your password" size="30" maxlength="50"  required> </td></tr>
</table><br>
<input type="submit" name="submit" style = "font-size:15pt; color: #0000FF" value="Login" />
Forgot <a href="send_email.php">password?</a>
  
</div>
</form>
</div>
</div>
</body>
</html>
