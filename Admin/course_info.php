<?php
session_start();
if(!isset($_SESSION['aname'])){
	header('Location: ../index.php');
}
include '../mysqli_connect.php';
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Admin ' . $_SESSION['aname'] . '<br></h4>';
if (isset($_POST['register']) == 'Register Course') {
	header('Location: register_course.php');
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
            <form action="course_info.php" method="post">
  <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['aname'])) {
    // Navigations
?>
                       

<li><input type="submit" value="Register Course" name="register" class="subbtn" title="Register"/></li>
                    </ul>

                </div>
            <?php
            } 
            
            
            $sql = "select C.cid,C.cname,C.semester,C.year,T.tcname,C.status from Course C,Testconductor T where
            C.tcid = T.tcid";
            $result = @mysqli_query($dbc, $sql);
            //$num = mysqli_num_rows($r);
            if (mysqli_num_rows($result) == 0) {
            	echo "<h3 style=\"color:#0000cc;text-align:center;\">No Course Yet..!</h3>";
            } else {
            	
            	?>
                                <table cellpadding="30" cellspacing="10" class="datatable">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Course ID</th>
                                        
                                         <th>Course Name</th>
                                        <th>Testconductor</th>
                                        <th>Semester</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
            <?php
                                while ($r = mysqli_fetch_array($result)) {
                                    
                                    echo "<td><a href=delete_course.php?id=".$r['cid']."&semester=". htmlspecialchars_decode($r['semester'], ENT_QUOTES)."&year=". htmlspecialchars_decode($r['year'], ENT_QUOTES)."><strong>DELETE</strong></a></td><td>" . htmlspecialchars_decode($r['cid'], ENT_QUOTES)."
		                           </td><td>" . htmlspecialchars_decode($r['cname'], ENT_QUOTES)
                                   
                                    ."</td><td>" . htmlspecialchars_decode($r['tcname'], ENT_QUOTES)
                                    ."</td><td>" . htmlspecialchars_decode($r['semester'], ENT_QUOTES)
                                    . "</td><td>" . htmlspecialchars_decode($r['year'], ENT_QUOTES) . "</td>"
        		 . "</td><td>" . htmlspecialchars_decode($r['status'], ENT_QUOTES) . "</td>"
                                    . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['cid'], ENT_QUOTES) . "\"href=\"update_course.php?id=" . htmlspecialchars_decode($r['cid'], ENT_QUOTES) . "&cname=" . htmlspecialchars_decode($r['cname'], ENT_QUOTES) . "&tcname=" . htmlspecialchars_decode($r['tcname'], ENT_QUOTES) . "&year=" . htmlspecialchars_decode($r['year'], ENT_QUOTES) . "&semester=" . htmlspecialchars_decode($r['semester'], ENT_QUOTES) . "&status=" . htmlspecialchars_decode($r['status'], ENT_QUOTES) . "\">
                		            <img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
                                }
                                
            ?>
                                </table>
            <?php
                            }
            
            ?>
	</div>
</form>
</html>
