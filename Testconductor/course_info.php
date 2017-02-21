<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
$tcname = $_SESSION['tcname'];
$tcid = $_SESSION['tcid'];
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_POST['add']) == 'Add Course') {
	header('Location: add_course.php');
}
?>
<html>
    <head>
        <title>OES-Course Management</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>

    </head>
    <body>
        <div id="container">
        
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            
            </div>
            <br><br>
  
<?php
if (isset($_SESSION['tcname'])) {
    // Navigations
?>
                       


                 
            <?php
            } 
            
            
            $sql = "select C.cid,C.cname,C.semester,C.year,T.tcname from Course C,Testconductor T where
            C.tcid = T.tcid AND T.tcid = $tcid AND C.status = 'Active'";
            $result = @mysqli_query($dbc, $sql);
            //$num = mysqli_num_rows($r);
            if (mysqli_num_rows($result) == 0) {
            	echo "<h3 style=\"color:#0000cc;text-align:center;\">No Course Yet..!</h3>";
            } else {
            	echo '<h2 style = "color : #0000FF" > you are currently teaching following courses<br><br></h2>';
            	?>
                                <table cellpadding="30" cellspacing="10" class="datatable">
                                    <tr>
                                        
                                        <th>Course ID</th>
                                        <th>Course Name</th>
                                        <th>Semester</th>
                                        <th>Year</th>
                                        
                                    </tr>
            <?php
                                while ($r = mysqli_fetch_array($result)) {
                                    
                                    echo "<td>" . htmlspecialchars_decode($r['cid'], ENT_QUOTES)
                                    ."</td><td>" . htmlspecialchars_decode($r['cname'], ENT_QUOTES)
                                    ."</td><td>" . htmlspecialchars_decode($r['semester'], ENT_QUOTES)
                                    . "</td><td>" . htmlspecialchars_decode($r['year'], ENT_QUOTES) . "</td>
                                    </tr>";
                                }
                                
            ?>
                                </table>
            <?php
                            }
            
            ?>
	</div>
</form>
</html>
