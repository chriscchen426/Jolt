


<?php
session_start();
if(!isset($_SESSION['stdname'])){
	header('Location: student_login.php');
}
error_reporting(E_ALL ^ E_NOTICE);
//$errors = array();
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, ' . $_SESSION['stdname'] . '<br><br><br></h4>';
$final=false;
include 'mysqli_connect.php';
date_default_timezone_set("America/New_York");
$b = date('Y-m-d h:i:s');
/*
$q = "select NOW() as cur";
$result = @mysqli_query($dbc, $q);
$r = mysqli_fetch_array($result);
//if(Time() < strtotime($_SESSION['endtime']))
 * 
 
	$a = $_SESSION['endtime'];
	//$b = $r['cur'];
      echo $a;
      echo '<br>';
     // date_default_timezone_set("America/New_York");
		// $b = date('Y-m-d h:i:s');
		 echo $b;
		 if($a > $b){
		 	//$c = strtotime($_SESSION['endtime']) - strtotime($b);
		 	echo 'endtime greater';
		 }else{
		 	echo 'endtime less';
		 }
		//echo '<br>';
		//echo $_SESSION['endtime'];
		 * 
		 
		 $date = strtotime($_SESSION['endtime']);
		 $remaining = $date - time();
		 $hours = floor(($remaining % 86400) / 3600);
		 $minutes = floor(($remaining % 3600) / 60);
		 $secs = ($remaining % 60);
		 echo '<p style = "color:#ff0000;">Time Remaining </p>';
		 echo '<h2 style = "color : #0000FF"> hour : ' .$hours. ' min : ' .$minutes. ' sec : ' .$secs. '</h2>' ;
		// echo '<h2 style = "color : #0000FF"> min : ' .$minutes. ' </h2>';
		 //echo '<color:#ff0000> sec : ' .$secs. ' ' ;
//echo '<br>';
		 //echo $minute_remaining;
		  *
		  */

		  
// if(isset($_POST['next']) || isset($_POST['summary']) || isset($_POST['viewsummary']))
// {
	
// 	//next question
	
// 	$answer='unanswered';

// 		//echo $_SESSION['endtime'];
// 		if(isset($_POST['markreview']))
// 		{
// 			$answer='review';
// 		}
// 		else if(isset($_POST['answer']))
// 		{
// 			$answer='answered';
// 		}
// 		else
// 		{
// 			$answer='unanswered';
// 		}
		
// 		if(strcmp($answer,"unanswered")!=0)
// 		{
// 			if(strcmp($answer,"answered")==0)
// 			{
// 				$query="update StudentOpQuestion set answered='answered',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid =  ".$_SESSION['qn']."";
// 				echo $query;
// 			}
// 			else
// 			{
// 				$query="update StudentOpQuestion set answered='review',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid =  ".$_SESSION['qn']."";
// 			}
// 			$result = @mysqli_query($dbc, $query);
// 			if(!$result)
// 			{
// 				echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$query . '</p>';
// 				// to do
// 				echo 'Your previous answer is not updated.Please answer once again';
// 			}
			
// 		}
// 		if(isset($_POST['viewsummary']))
// 		{
// 			header('Location: summaryop.php');
// 		}
		
// 		if(isset($_POST['summary']))
// 		{
// 			//summary page
// 			header('Location: summaryop.php');
// 		}
	
// 	if((int)$_SESSION['qn']<(int)$_SESSION['tqn'])
// 	{
// 		$_SESSION['qn'] = $_SESSION['qn']+1;
// 		echo $_SESSION['qn'];
		 
// 	}
// 	if((int)$_SESSION['qn']==(int)$_SESSION['tqn'])
// 	{
// 		$final=true;
// 	}

// }
// else if(isset($_POST['previous']))
// {
// 	// Perform the changes for current question
// 	$answer='unanswered';
// 	// if($b < $_SESSION['endtime'])
// 	// {
// 		if(isset($_POST['markreview']))
// 		{
// 			$answer='review';
// 		}
// 		else if(isset($_POST['answer']))
// 		{
// 			$answer='answered';
// 		}
// 		else
// 		{
// 			$answer='unanswered';
// 		}
// 		if(strcmp($answer,"unanswered")!=0)
// 		{
// 			if(strcmp($answer,"answered")==0)
// 			{
// 				$query="update StudentOpQuestion set answered='answered',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid =  ".$_SESSION['qn']."";
// 				echo $query;
// 			}
// 			else
// 			{
// 				$query="update StudentOpQuestion set answered='review',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid =  ".$_SESSION['qn']."";
// 				echo $query;
// 			}
// 			$result = @mysqli_query($dbc, $query);
// 			if(!$result)
// 			{
// 				echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$query . '</p>';
// 				// to do
// 				echo 'Your previous answer is not updated.Please answer once again';
// 			}
			
// 		}
// 	//}
// 	//previous question
// 	if((int)$_SESSION['qn']>1)
// 	{
// 		$_SESSION['qn']=$_SESSION['qn']-1;
// 	}

// }
//  if(isset($_REQUEST['fs']))
//    {
//         //Final Submission
//     	//header('Location: testconducter.php');
//        header('Location: testopack.php');
//     }
         
//    if(isset($_SESSION['stdname'])){
//    //$sql = "select stdanswer,answered from StudentOpQuestion where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']."";
//    $sql = "select stdanswer,answered from StudentQuestion where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
//    $r = @mysqli_query($dbc, $sql);
//    $r1 = mysqli_fetch_array($r);
//    if(!$r){
   
//    	echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
//    }
//    //$q = "SELECT * FROM Question ORDER BY RAND() LIMIT 5";
//    $q = "select *from OpQuestion Q,StudentOpQuestion SQ where Q.testid = SQ.testid and Q.qnid = SQ.qnid and Q.testid=".$_SESSION['testid']." 
// 		and sid=".$_SESSION['stdid']."";
// 	echo $q;
// 	$qq = "select max(Q.qnid) as max from OpQuestion Q,StudentOpQuestion SQ where Q.testid = SQ.testid and Q.qnid = SQ.qnid and Q.testid=".$_SESSION['testid']." 
// 		and sid=".$_SESSION['stdid']."";
// 	//echo $qq;
// 	$resultqq = @mysqli_query($dbc, $qq);
// 	$rqq = mysqli_fetch_array($resultqq);
//    //$q = "select * from Question where testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
//    $result = @mysqli_query($dbc, $q);
//    $r=mysqli_fetch_array($result);
//    $_SESSION['qn'] = $r['qnid'];
//    $_SESSION['tqn'] = $rqq['max'];
   
//    }
	if(isset($_POST['next']) || isset($_POST['summary']) || isset($_POST['viewsummary']))
{
	
	//next question
	
	$answer='unanswered';
	// if($b < $_SESSION['endtime'])
	// {
		//echo $_SESSION['endtime'];
		if(isset($_POST['markreview']))
		{
			$answer='review';
		}
		else if(isset($_POST['answer']))
		{
			$answer='answered';
		}
		else
		{
			$answer='unanswered';
		}
		if(strcmp($answer,"unanswered")!=0)
		{
			if(strcmp($answer,"answered")==0)
			{
				$query="update StudentOpQuestion set answered='answered',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
				echo $query;
			}
			else
			{
				$query="update StudentOpQuestion set answered='review',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
			}
			$result = @mysqli_query($dbc, $query);
			if(!$result)
			{
				echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$query . '</p>';
				// to do
				echo 'Your previous answer is not updated.Please answer once again';
			}
			
		}
		if(isset($_POST['viewsummary']))
		{
			header('Location: summaryop.php');
		}
		
		if(isset($_POST['summary']))
		{
			//summary page
			header('Location: summaryop.php');
		}
	//}
	if((int)$_SESSION['qn']<(int)$_SESSION['tqn'])
	{
		$_SESSION['qn']=$_SESSION['qn']+1;
		//echo "~~~";
		 
	}
	if((int)$_SESSION['qn']==(int)$_SESSION['tqn'])
	{
		$final=true;
	}

}
else if(isset($_POST['previous']))
{
	// Perform the changes for current question
	//$answer='unanswered';
	// if($b < $_SESSION['endtime'])
	// {
		if(isset($_POST['markreview']))
		{
			$answer='review';
		}
		else if(isset($_POST['answer']))
		{
			$answer='answered';
		}
		else
		{
			$answer='unanswered';
		}
		if(strcmp($answer,"unanswered")!=0)
		{
			if(strcmp($answer,"answered")==0)
			{
				$query="update StudentOpQuestion set answered='answered',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
			}
			else
			{
				$query="update StudentOpQuestion set answered='review',stdanswer='".htmlspecialchars($_POST['answer'],ENT_QUOTES)."' where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
			}
			$result = @mysqli_query($dbc, $query);
			if(!$result)
			{
				echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$query . '</p>';
				// to do
				echo 'Your previous answer is not updated.Please answer once again';
			}
			
		}
	//}
	//previous question
	if((int)$_SESSION['qn']>1)
	{
		$_SESSION['qn']=$_SESSION['qn']-1;
	}

}
 if(isset($_REQUEST['fs']))
   {
        //Final Submission
    	//header('Location: testconducter.php');
       header('Location: testopack.php');
    }
         
 ?>

   <?php 
   if(isset($_SESSION['stdname'])){
   $sql = "select stdanswer,answered from StudentOpQuestion where sid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
   $r = @mysqli_query($dbc, $sql);
   $r1 = mysqli_fetch_array($r);
   if(!$r){
   
   	echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$sql . '</p>';
   }
   $q = "select * from OpQuestion where testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
   //echo $q;
   $result = @mysqli_query($dbc, $q);
   //echo $q;
   $r=mysqli_fetch_array($result);
   }

	$qq = "select max(Q.qnid) as max from OpQuestion Q,StudentOpQuestion SQ where Q.testid = SQ.testid and Q.qnid = SQ.qnid and Q.testid=".$_SESSION['testid']." 
		and sid=".$_SESSION['stdid']."";
	//echo $qq;
	$resultqq = @mysqli_query($dbc, $qq);
	$rqq = mysqli_fetch_array($resultqq);
   //$q = "select * from Question where testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn']."";
   
	$qqq = "select * from StudentOpQuestion where testid=".$_SESSION['testid']." and sid=".$_SESSION['stdid']." and qnid=".$_SESSION['qn']."";
	//echo $qqq;
	$resultqqq = @mysqli_query($dbc, $qqq);
	$rqqq = mysqli_fetch_array($resultqqq);

   $_SESSION['tqn'] = $rqq['max'];

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
            </script>
            <form action="testopconducter.php" method="post">
              <table border="0" width="100%" class="ntab">
                  <tr>
                      <th style="width:40%;"><h3><span id="timer" class="timerclass"></span></h3></th>
                      <th style="width:40%;"><h4 style="color: #af0a36;">Question No: <?php echo $_SESSION['qn']; ?> </h4></th>
                      <th style="width:20%;"><h4 style="color: #af0a36;"><input type="checkbox" name="markreview" value="mark"> Mark for Review</input></h4></th>
                  </tr>
              </table>
             <textarea cols="100" rows="8" name="question" readonly style="width:96.8%;text-align:left;margin-left:2%;margin-top:2px;font-size:120%;font-weight:bold;margin-bottom:0;color:#0000ff;padding:2px 2px 2px 2px;"><?php echo htmlspecialchars_decode($r['question'],ENT_QUOTES); ?></textarea>
             
              <table border="0" width="100%" class="ntab">
                  <tr><td>&nbsp;</td></tr>
                  <textarea cols="100" rows="8" name="answer"  style="width:96.8%;text-align:left;margin-left:2%;margin-top:2px;font-size:120%;font-weight:bold;margin-bottom:0;color:#0000ff;padding:2px 2px 2px 2px;"><?php echo htmlspecialchars_decode($rqqq['stdanswer'],ENT_QUOTES); ?></textarea>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                      <th style="width:80%;"><h4><input type="submit" name="<?php if($final==true){ echo "viewsummary" ;}else{ echo "next";} ?>" value="<?php if($final==true){ echo "View Summary" ;}else{ echo "Next";} ?>" class="subbtn"/></h4></th>
                      <th style="width:12%;text-align:right;"><h4><input type="submit" name="previous" value="Previous" class="subbtn"/></h4></th>
                      <th style="width:8%;text-align:right;"><h4><input type="submit" name="summary" value="Summary" class="subbtn"/></h4></th>
                  </tr>
                  
              </table>
              
           </form>
     
     
  </body>
</html>

