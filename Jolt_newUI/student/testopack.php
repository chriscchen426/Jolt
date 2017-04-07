
<?php

session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: student_login.php');
}
//$errors = array();
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br><br><br></h4>';
//$final=false;
include 'mysqli_connect.php';
include 'nav.html';

    unset($_SESSION['starttime']);
    unset($_SESSION['endtime']);
    unset($_SESSION['tqn']);
    unset($_SESSION['qn']);
    unset($_SESSION['duration']);
    $q = "update StudentTest set status='over' where testid=".$_SESSION['testid']." and sid=".$_SESSION['stdid']."";
    $result = @mysqli_query($dbc, $q);

?>
      <h4>&nbsp;</h4>
<h4>&nbsp;</h4> 
       <?php

       
        ?>
     
      <div class="page">
          <h3 style="text-align:center;">You have finished all test <b><a href="home.php">Click Here to Back</a></b> </h3>
          <?php
                        //}
          ?>
      </div>

           </form>
     
      </div>
  </body>
</html>

