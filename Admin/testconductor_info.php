<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
$aname = $_SESSION['aname'];
//$tcid = $_SESSION['tcid'];
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['add']) == 'Add Testconductor') {
	header('Location: add_testconductor.php');
}

$sql = "select *from Testconductor";
$r = @mysqli_query($dbc, $sql);
$num = mysqli_num_rows($r);
?>
<html>
    <head>
        <title>OES-Testconductor Management</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../oes.css"/>
		<link rel="stylesheet" type="text/css" href="../pinesh.css"/>
		<script type="text/javascript" src="../validate.js" ></script>
    </head>
    <body>
        <div id="container">
        
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            
            </div>
            <form action="testconductor_info.php" method="post">
  <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['aname'])) {
    // Navigations
?>
                       

<li><input type="submit" value="Add Testconductor" name="add" class="subbtn" title="Add"/></li>

                    </ul>

                </div>
            <?php
            }
            ?> 
            </body>
            </html>
            <?php 

if($num > 0){
	echo '<table align= "center" width="70%" class="datatable">
			<tr>
			<th><b></th>
			<th><b>Testconductor ID</th>
			<th><b>Testconductor Name</th>
			<th><b>Email</th>
			
			<th><b></th>
			
			</tr>
			';
	
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
			 
			echo '<tr>
				<td><a href=delete_testconductor.php?id='.$row['tcid'].'><strong>DELETE</strong></a></td>
				<td align="left">' . $row['tcid'] . '</td>
				<td align="left">' . $row['tcname'] . '</td>
				<td align="left">' . $row['email'] . '</td>
               
		         <td><a href=update_testconductor.php?id='.$row['tcid'].'><strong>EDIT</strong></a></td>
			';	
			
		}
		echo '</table><br>';
	
		}else{
		echo '<h3 style = "color:#ff0000;"> There are no Course information available for instructor.</h3><br>';
		//echo '<input type="submit" name = "add" value="Add Course">';
		exit();
	}
	
	
	
	?>
	</form>
		</div>
		</div>
		</body>
		</html>

