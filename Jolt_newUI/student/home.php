<?php
session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: sdt_login.php');
}

include 'mysqli_connect.php';
$sid = $_SESSION['stdid'];

echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br></h4>';


?>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jolt_studenthome</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
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
                        <a href="home.php">Testing Module</a>
                    </li>
                    <li>
                        <a href="#contact">Learning Module</a>
                    </li>
                    <li>
                        <a href="logout.php">Log out</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <?php 
		$q ="select C.cid,C.cname,TS.tcname,T.tcid,C.year,C.semester from Course C, TCS T,Testconductor TS
		where C.cid = T.cid AND T.tcid = TS.tcid AND T.sid = $sid AND C.status = 'Active'";
		$result = @mysqli_query($dbc,$q);
		if($result){
		$num = mysqli_num_rows($result);
		if($num > 0){
	?>

    <div class="container">
	  <h2>Test information</h2>
	  <p>All your test is below:</p>            
	  <table class="table table-striped">
	    <thead class="">
	      <tr>
	        <th>Course ID</th>
			<th>Course Name</th>
			<th>Instructor Name</th>
			<th>Year</th>
			<th>Semester</th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php 
	      		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo '<tr>
								<td align="left">' . $row['cid'] . '</td>
								<td align="left">' . $row['cname'] . '</td>
								<td align="left">' . $row['tcname'] . '</td>
						        <td align="left">' . $row['year'] . '</td>
						         <td align="left">' . $row['semester'] . '</td>
						        <td><a href=stdtest.php?id='.$row['cid'].'><strong>View Test</strong></a></td>
						  </tr>';
						  }
	      ?>
	    </tbody>
	  </table>
	  <?php
	  }else{
		echo '<h3><class = error style = "color:#ff0000"> Currently, You are not registered for any classes.</h3>';
		}
	}
?>
	</div>
    
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="viewresult.php">View Test Result</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    

</body>
</html>
