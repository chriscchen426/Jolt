<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';
echo '<div class="container">';
$tcname = $_SESSION['tcname'];
$tcid = $_SESSION['tcid'];
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_POST['add']) == 'Add Course') {
	header('Location: add_course.php');
}
?>
            
  
<?php
include 'nav.html';

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
            	echo '<h2> you are currently teaching following courses<br><br></h2>';
            	?>

                                
                                  <h2>Course information</h2>
                                            
                                  <table class="table table-striped">
                                    <thead class="">
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
</div>
</div>
</html>
