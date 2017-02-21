<?php

error_reporting(E_ALL ^ E_NOTICE);
$errors = array();

include 'mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a></h2></pre>';
if (isset($_POST['submit'])) {
	
	
	
	
		$student_email = $_POST['e_mail'];
		$sql = "select password from Student where email = '$student_email'";
		$result = @mysqli_query($dbc, $sql);
		if (mysqli_num_rows($result) == 0) {
			$errors[] = 'Please Enter Valid Email or Email Does Not Exist';
		}else{
			$r = mysqli_fetch_array($result);
			$email_message = "Your password is ".$r['password'];
			$subject = "Password Reset";
			$email_header= "From: padipakk@kean.edu" . "\r\n" .
					"Reply-To: padipakk@kean.edu" . "\r\n";
			
			$retval = mail("$student_email", "$subject", $email_message,$email_header);

       if( $retval == true ) {
            $msg = "Email sent successfully...Please Check Your Email.";
            echo "<div class=\"message\">" .$msg. "</div>";
         }else {
            $msg = "Email could not be sent...";
            echo "<div class=\"message\">" .$msg. "</div>";
         }
				
		
	}
	
}



?>

<html>
  <head>
    <title>Online Examination System</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="pinesh.css"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <style>


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

?>
<br>
 <div id="container">
 <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
  <div align="center">

<form action="send_email.php" method="post">

<table>
<tr> <td><b>Enter Your Email: </b></td><td><input type="text" name="e_mail" placeholder="Enter Your email" value = "<?php echo $_POST['e_mail']; ?>" required> </td></tr>
</table><br>
<input type="submit" name="submit" style = "font-size:15pt; color: #0000FF" value="Submit" />


</form>
</div>
</body>
</html>