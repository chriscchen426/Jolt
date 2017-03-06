

<?php

//USER Story: Client requested a summary after each exam is taken.
//Version: OES1.2
//Developed by: DIPAKKUMAR PATEL

$i = 0;
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
date_default_timezone_set("America/New_York");
 if(isset($_REQUEST['change']))
    {
        //redirect to testconducter
       
       $_SESSION['qn']=substr($_REQUEST['change'],7);
       header('Location: testopconducter.php');

    }else if(isset($_REQUEST['finalsubmit'])){
    //redirect to dashboard
    //
     header('Location: testopack.php');

    }elseif(isset($_REQUEST['fs']))
    	{
    		//Final Submission
    		//header('Location: testconducter.php');
    		header('Location: testopack.php');
    	}
    
   
   
?>
 <html>
         <head>
    <title>OES-Test Conducter</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>
        <link rel="stylesheet" type="text/css" href="oes.css"/>
        <script type="text/javascript" src="validate.js" ></script>
        <script type="text/javascript" src="cdtimer.js" ></script>
        <script type="text/javascript" >
    
         <?php
if (!isset($_REQUEST['finalsumbit']) && isset($_SESSION['starttime'])) {
            $elapsed=time()-strtotime($_SESSION['starttime']);
if(((int)$elapsed/60)<(int)$_SESSION['duration'])
{
	$q = "select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,
		TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,
		TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from StudentTest 
		where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']."";
	$result = @mysqli_query($dbc, $q);

	if($rslt=mysqli_fetch_array($result))
	{
		echo "var hour=".$rslt['hour'].";";
		echo "var min=".$rslt['min'].";";
		echo "var sec=".$rslt['sec'].";";
	}
	else
	{
		echo "Try Again";
	}
	
}
else
{
	echo "var sec=01;var min=00;var hour=00;";
	//unset($_SESSION['starttime']);
}
        }
        ?>

    -->
    </script>

        <form action="summaryop.php" method="post">
          
         <table border="0" width="100%" class="ntab">
                  <tr>
                      <th style="width:40%;"><h3><span id="timer" class="timerclass"></span></h3></th>
                      
                  </tr>
              </table>
          <?php

                        $q = "select * from StudentOpQuestion where testid=".$_SESSION['testid']." and sid=".$_SESSION['stdid']." order by qnid ";
                        $result = @mysqli_query($dbc, $q);
                        echo $q;
                        if(mysqli_num_rows($result)==0) {
                          echo "<h3 style=\"color:#0000cc;text-align:center;\">Please Try Again.</h3>";
                        }
                        else
                        {
                           //editing components
                 ?>
          <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Question No</th>
                            <th>Status</th>
                            <th>Change Your Answer</th>
                       </tr>
        <?php
                        while($r=mysqli_fetch_array($result)) {
                                    $i=$i+1;
                                    if($i%2==0)
                                    {
                                    echo "<tr class=\"alt\">";
                                    }
                                    else{ echo "<tr>";}
                                    echo "<td>".$r['qnid']."</td>";
                                    if(strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"unanswered")==0 ||strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"review")==0)
                                    {
                                        echo "<td style=\"color:#ff0000\">".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                                    }
                                    else
                                    {
                                        echo "<td>".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                                    }
                                    echo"<td><input type=\"submit\" value=\"Change ".$r['qnid']."\" name=\"change\" class=\"ssubbtn\"/></td></tr>";
                                }

                                ?>
              <tr>
                  <td colspan="3" style="text-align:center;"><input type="submit" name="finalsubmit" value="Final Submit" class="subbtn"/></td>
              </tr>
                    </table>
                            <?php
                            }
                            
         
                    
                    ?>

     
              
           </form>
     
     
  </body>
</html>

