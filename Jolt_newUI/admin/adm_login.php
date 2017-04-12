<?php
session_start();

if(isset($_POST['submit'])){
	include '../mysqli_connect.php';
	
	$errors = array();
	
	if(!empty($_POST['aname']) && !empty($_POST['pass']))
	{
	$aname = $_POST['aname'];
	$apass = $_POST['pass'];
	
		$sql = "select password from Admin where name = '$aname'";
		//echo $sql;
		
		$r = @mysqli_query($dbc,$sql);
		$num = mysqli_num_rows($r);
		if($num == 0){
			$errors[] = 'Invalid Login Credentials';
			//echo '<h2 style = color:#ff0000;">You entered wrong e-mail or e-mail does not exit.</h2><br>';
		}else{
		$row = mysqli_fetch_assoc($r);
		$a_pass = $row['password'];
		echo $a_pass;
		if($apass != $a_pass){
			$errors[] = 'Invalid Login Credentials';
			//echo '<h2 style = color:#ff0000;">You entered wrong password.</h2><br>';
		}
		}
	
//}
	if(empty($errors)){

		session_start();
		$_SESSION['aname'] = $aname;
		
		header('Location: home.php');

	}else{

		echo'<h2 align = "center"><p style = "color:#ff0000;"> Errors!</p><h2>';
		foreach($errors as $msg){
			echo '<h4 align = "center"><p style= "color:#ff0000"> ' .$msg. '<br  /></p><h4>';
			//echo "<h2 align = "center"><p style=\"color:#ff0000;\">" .$msg. "<br  />\n</p><h2>";
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
        <title>Jolt Admin Login Form</title>

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
                            <a href="../student/std_login.php">Student</a>
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
                            <h1><strong>Administrator</strong> Login Form</h1>
                            <div class="description">
                            	<p>
	                            	This is only for Administrator to manage the whole Jolt
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login to Jolt</h3>
                            		<p>Enter your email and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="adm_login.php" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="aname" placeholder="E-mail..." class="form-username form-control" id="aname">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="pass" placeholder="Password..." class="form-password form-control" id="pass">
			                        </div>
			                        <button type="submit" name="submit" class="btn">Sign in!</button>
			                    </form>
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