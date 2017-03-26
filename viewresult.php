


<?php
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

    if(isset($_REQUEST['back'])) {
        //redirect to View Result

            header('Location: viewresult.php');

        }
        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>OES-View Result</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="oes.css"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    <body >
        <?php

       
       // }
        ?>
        <div id="container">
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
            <form id="summary" action="viewresult.php" method="post">
                <div class="menubar">
                    <ul id="menu">
                        <?php if(isset($_SESSION['stdname'])) {
                        // Navigations
                        if(isset($_REQUEST['details'])) {
              ?>
                        
                        <li><input type="submit" value="Back" name="back" class="subbtn" title="View Results"/></li>
                        <?php
                        }
                        ?>

                    </ul>


                </div>
                <div class="page">

                        <?php

                        if(isset($_REQUEST['details'])) {
                            $q = "select s.sname,t.testname,sub.cname,sub.cid,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as stime,
                                                  TIMEDIFF(st.endtime,st.starttime) as dur,(select sum(marks) from 
                                                   Question where testid=".$_REQUEST['details'].") as tm,IFNULL((select sum(q.marks) from 
                                                  StudentQuestion as sq, Question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' 
                                                  and sq.stdanswer=q.correctanswer and sq.sid=".$_SESSION['stdid']." 
                                                  and sq.testid=".$_REQUEST['details']."),0) as om from Student as s,Test as t, Course as sub,StudentTest as st 
                                                    where s.sid=st.sid and st.testid=t.testid and 
                                                  t.cid=sub.cid and st.sid=".$_SESSION['stdid']." 
                                                    and st.testid=".$_REQUEST['details']."";
                            //echo $q;
                            $result = @mysqli_query($dbc, $q);
                            if(mysqli_num_rows($result)!=0) {

                                $r=mysqli_fetch_array($result);
                                ?>
                    <table cellpadding="20" cellspacing="30" border="0" style="background:#ffffff url(images/page.gif);text-align:left;line-height:20px;">
                        <tr>
                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Test Summary</h3></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                        </tr>
                        <tr>
                            <td>Student Name</td>
                            <td><?php echo htmlspecialchars_decode($r['sname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Test</td>
                            <td><?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Course Name</td>
                            <td><?php echo $r['cid']." ".htmlspecialchars_decode($r['cname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Date and Time</td>
                            <td><?php echo $r['stime']; ?></td>
                        </tr>
                        <tr>
                            <td>Test Duration</td>
                            <td><?php echo $r['dur']; ?></td>
                        </tr>
                        <tr>
                            <td>Max. Marks</td>
                            <td><?php echo $r['tm']; ?></td>
                        </tr>
                        <tr>
                            <td>Obtained Marks</td>
                            <td><?php echo $r['om']; ?></td>
                        </tr>
                        <tr>
                            <td>Percentage</td>
                            <td><?php echo round((($r['om']/$r['tm'])*100),1)." %"; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><hr style="color:#ff0000;border-width:2px;"/></td>
                        </tr>
                         <tr>
                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Test Information in Detail</h3></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                        </tr>
                    </table>
                                <?php

                                $v = "select q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa 
                                                 from StudentQuestion as sq,Question as q 
                                                where q.qnid=sq.qnid and sq.testid=q.testid and 
                                               sq.testid=".$_REQUEST['details']." and sq.sid=".$_SESSION['stdid']." order by q.qnid";
                                $result1 = @mysqli_query($dbc, $v);
                                $_SESSION['fqn']=0;

                                if(mysqli_num_rows($result1)==0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">1.Sorry because of some problems Individual questions Cannot be displayed.</h3>";
                                }
                                else {
                                    ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Q. No</th>
                            
                            <th>Correct Answer</th>
                            <th>Your Answer</th>
                            <th>Score</th>
                            <th>&nbsp;</th>
                        </tr>
                                        <?php
                                        while($r1=mysqli_fetch_array($result1)) {

                                        if(is_null($r1['sa']))
                                        $r1['sa']="question"; //any valid field of question
                                           $t = "select ".$r1['ca']." as corans,IF('".$r1['status']."'='answered',(select ".$r1['sa']." 
		                                        from Question where qnid=".$r1['questionid']." and testid=".$_REQUEST['details']."),'unanswered') as stdans, IF('".$r1['status']."'='answered',IFNULL((select q.marks 
		                                        from Question as q, StudentQuestion as sq where q.qnid=sq.qnid and q.testid=sq.testid and 
		                                        q.correctanswer=sq.stdanswer and sq.sid=".$_SESSION['stdid']." and q.qnid=".$r1['questionid']." 
            		                              and q.testid=".$_REQUEST['details']."),0),0) as stdmarks from Question 
		                                        where qnid=".$r1['questionid']." and testid=".$_REQUEST['details']."";
                                           $result2 = @mysqli_query($dbc, $t);

                                            if($r2=mysqli_fetch_array($result2)) {
                                                ?>
                        <tr>
                            <td><?php $_SESSION['fqn']=$_SESSION['fqn']+1; echo $_SESSION['fqn']; ?></td>
                            
                            <td><?php echo htmlspecialchars_decode($r2['corans'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($r2['stdans'],ENT_QUOTES); ?></td>
                            <td><?php echo $r2['stdmarks']; ?></td>
                                                    <?php
                                                    if($r2['stdmarks']==0) {
                                                        echo"<td class=\"tddata\"><img src=\"images/wrong.png\" title=\"Wrong Answer\" height=\"30\" width=\"40\" alt=\"Wrong Answer\" /></td>";
                                                    }
                                                    else {
                                                        echo"<td class=\"tddata\"><img src=\"images/correct.png\" title=\"Correct Answer\" height=\"30\" width=\"40\" alt=\"Correct Answer\" /></td>";
                                                    }
                                                    ?>
                        </tr>
                            <?php
                                                }
                                                else {
                                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Sorry because of some problems Individual questions Cannot be displayed.</h3>".mysql_error();
                                                }
                                            }

                                        }

                                        //for open ended question:
                                        $op = "select q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa ,sq.comments as c, sq.grade as g
                                                 from StudentOpQuestion as sq,OpQuestion as q 
                                                where q.qnid=sq.qnid and sq.testid=q.testid and 
                                               sq.testid=".$_REQUEST['details']." and sq.sid=".$_SESSION['stdid']." order by q.qnid";
                                            //echo $op;
                                $resultop = @mysqli_query($dbc, $op);

                                if(mysqli_num_rows($resultop)==0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">1.Sorry because of some problems Individual questions Cannot be displayed.</h3>";
                                }
                                else {
                                    ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Q. No</th>
                            
                            <th>Correct Answer</th>
                            <th>Your Answer</th>
                            <th>Your Grade</th>
                            <th>Comments</th>
                            <th>&nbsp;</th>
                        </tr>
                                        <?php
                                        while($rop=mysqli_fetch_array($resultop)) {

                                       

                                        
                                                ?>
                        <tr>
                            <td><?php echo $rop['questionid']; ?></td>
                            
                            <td><?php echo htmlspecialchars_decode($rop['ca'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($rop['sa'],ENT_QUOTES); ?></td>
                             <td><?php echo htmlspecialchars_decode($rop['g'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($rop['c'],ENT_QUOTES); ?></td>
                            
                        </tr>
                            <?php
                                               
                                            }

                                        }

                                    }
                                    else {
                                        echo"<h3 style=\"color:#0000cc;text-align:center;\">Something went wrong. Please logout and Try again.</h3>".mysql_error();
                                    }
                                    ?>
                    </table>
                                <?php

                        }
                        else {


                            $sql = "select st.*,t.testname,t.testdesc,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt 
		from StudentTest as st,Test as t where t.testid=st.testid and st.sid=".$_SESSION['stdid']." and st.status='over' order by st.testid";
                            $result = @mysqli_query($dbc, $sql);
                            if(mysqli_num_rows($result)==0) {
                                echo"<h3 style=\"color:#0000cc;text-align:center;\">I Think You Haven't Attempted Any Exams Yet..! Please Try Again After Your Attempt.</h3>";
                            }
                            else {
                            //editing components
                                ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Date and Time</th>
                            <th>Test Name</th>
                            <th>Max. Marks</th>
                            <th>Obtained Marks</th>
                            <th>Percentage</th>
                            <th>Details</th>
                        </tr>
            <?php
            while($r=mysqli_fetch_array($result)) {
                                        $i=$i+1;
                                        $om=0;
                                        $tm=0;
                                        $l = "select sum(q.marks) as om from StudentQuestion as sq, Question as q 
		                               where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and 
		                               sq.stdanswer=q.correctanswer and sq.sid=".$_SESSION['stdid']." and 
		                                sq.testid=".$r['testid']." order by sq.testid";
                                        $result1 = @mysqli_query($dbc, $l);
                                        $r1=mysqli_fetch_array($result1);
                                        $m = "select sum(marks) as tm from Question where testid=".$r['testid']."";
                                        $result2 = @mysqli_query($dbc, $m);
                                        $r2=mysqli_fetch_array($result2);
                                        if($i%2==0) {
                                            echo "<tr class=\"alt\">";
                                        }
                                        else { echo "<tr>";}
                                        echo "<td>".$r['startt']."</td><td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)." : ".htmlspecialchars_decode($r['testdesc'],ENT_QUOTES)."</td>";
                                        if(is_null($r2['tm'])) {
                                            $tm=0;
                                            echo "<td>$tm</td>";
                                        }
                                        else {
                                            $tm=$r2['tm'];
                                            echo "<td>$tm</td>";
                                        }
                                        if(is_null($r1['om'])) {
                                            $om=0;
                                            echo "<td>$om</td>";
                                        }
                                        else {
                                            $om=$r1['om'];
                                            echo "<td>$om</td>";
                                        }
                                        if($tm==0) {
                                            echo "<td>0</td>";
                                        }
                                        else {
                                            echo "<td>".round((($om/$tm)*100), 1)." %</td>";
                                        }
                                        echo"<td class=\"tddata\"><a title=\"Details\" href=\"viewresult.php?details=".$r['testid']."\"><img src=\"images/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td></tr>";
                                    }

                                    ?>

                    </table>
        <?php
        }
                        }
                        
                    }
                    ?>

                </div>

            </form>
            
      </div>
  </body>
</html>

