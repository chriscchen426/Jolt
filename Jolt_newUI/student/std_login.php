
<?php
session_start();

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
		header('Location: home.php');
	}else{
		session_start();
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

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Jolt Student Login</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
            <div class="container topnav">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
					<a class="navbar-brand" href="http://www.kean.edu"><img style="width: 64px;" src="../img/logo.JPG" alt="Dispute Bills">
        </a>
                    <a class="navbar-brand topnav" href="http://www.kean.edu/">Kean University</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="../index.html">Home</a>
                        </li>
                        <li>
                            <a href="../conductor/cdt_login.php">Conductor</a>
                        </li>
                        <li>
                            <a href="../admin/adm_login.php">Admin</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Students</strong> Login Form</h1>
                            <div class="description">
                            	<p>
	                            	Please login with your Kean email.
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login to Jolt</h3>
                            		<p>Enter your Kean email and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="std_login.php" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Email Address</label>
			                        	<input type="text" name="e-mail" placeholder="Email..." class="form-username form-control" id="e-mail">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="pass">Password</label>
			                        	<input type="password" name="pass" placeholder="Password..." class="form-password form-control" id="pass">
			                        </div>
			                        <button type="submit" name="submit" class="btn">Sign in!</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>