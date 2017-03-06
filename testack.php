


<?php

session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: student_login.php');
}
//$errors = array();
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br><br><br></h4>';
//$final=false;
include 'mysqli_connect.php';


    unset($_SESSION['starttime']);
    unset($_SESSION['endtime']);
    unset($_SESSION['tqn']);
    unset($_SESSION['qn']);
    unset($_SESSION['duration']);
    $q = "update StudentTest set status='over' where testid=".$_SESSION['testid']." and sid=".$_SESSION['stdid']."";
    $result = @mysqli_query($dbc, $q);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OES-Test Acknowledgement</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    </head>
  <body >
       <?php

       
        ?>
     
      <div class="page">
          <h3 style="color:#0000cc;text-align:center;">Your have finished and submitted Multiple Choice part<b>
          <h3 style="color:#0000cc;text-align:center;">Next part is open ended questions <b><a href="testopconducter.php">Click Here to start</a></b> </h3>
          <?php
                        //}
          ?>
      </div>

           </form>
     
      </div>
  </body>
</html>

