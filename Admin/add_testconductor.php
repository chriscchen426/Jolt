
<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: testconductor_info.php');
}
if(isset($_POST['add_data'])){
include '../mysqli_connect.php';
$errors = array();

if (empty($_POST['pass']) || empty($_POST['f_name']) || empty($_POST['email'])) {
	$errors[] = 'Some of the required Fields are Empty';
}else{
$fname = $_POST['f_name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if ($email === false) {
	$errors[] = 'Submitted email address is invalid';
}
if(!preg_match('/^[a-zA-Z]+$/',$fname)) {
	$errors[] = 'Invalid Testconductor Name.';
	//echo 'Invalid ' .$fileop[1]. '<br>';
}
/*$zip = filter_input(INPUT_POST,FILTER_VALIDATE_INT);
if ($zip === false) {
	print "Submitted zip is invalid.";
}*/
//password must be more than 8 characters which must contain at Least 1 Number , at Least 1 Capital Letter,at Least 1 Capital Letter,at Least 1 Lowercase Letter
$q = "select *from Testconductor where email='" . htmlspecialchars($_POST['email'], ENT_QUOTES) . "'";
$result = @mysqli_query($dbc, $q);
if (mysqli_num_rows($result) > 0) {
	$errors[] = 'Sorry, Email Already Exists. Please check your testconductor information.';
}
}
if(empty($errors)){
$q = "INSERT INTO Testconductor(tcname,email,password) values
('$fname','$email','$pass')";
$r = @mysqli_query($dbc, $q);

if($r){
	header('Location: testconductor_info.php');;
}else{
	echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$q . '</p>';
}
//mysqli_close($dbc);
//exit();
}
}
//echo '<li><a href="home.php">Go to Home</a></li>';
//mysqli_close($dbc);

//echo '<li><a href="home.php">Go to Home</a></li>';
?>
<html>
    <head>
        <title>OES-Manage Testconductor</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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

echo '<br>';
?>
<div id="container">
   <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div><br><br>
            <div align="center"><br><br>
            <body>
<h2 style = "color : #0000FF">Testconductor Registration Form</h2><br>
<form action = "add_testconductor.php" method="post" >
<table border = "1">
<tr><td><p>E-mail: </td><td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td></tr></p>
<tr><td><p>Password: </td><td><input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" /></td></tr></p>
<tr><td><p>Testconductor Name: </td><td><input type="text" name="f_name" value="<?php if (isset($_POST['f_name'])) echo $_POST['f_name']; ?>" /></td></tr></p>

 </table><br>
<input type="submit" name="add_data" value="Add Testconductor" class="subbtn">
<input type="submit" value="Cancel" name="cancel" class="subbtn">
</form>
</div>
</div>
</body>
</html>

