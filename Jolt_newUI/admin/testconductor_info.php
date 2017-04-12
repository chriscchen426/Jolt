<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
$aname = $_SESSION['aname'];
//$tcid = $_SESSION['tcid'];
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Administrator ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['add']) == 'Add Testconductor') {
	header('Location: add_testconductor.php');
}

$sql = "select *from Testconductor";
$r = @mysqli_query($dbc, $sql);
$num = mysqli_num_rows($r);
include 'nav.html';
?>

        <div class="container">
        <h4>&nbsp;</h4>
        <h4>&nbsp;</h4>
            
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
	echo '<table class="table">
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

