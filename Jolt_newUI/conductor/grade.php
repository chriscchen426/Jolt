
<?php

session_start();
if(!isset($_SESSION['tcname'])){
    header('Location: index.php');
}
//include 'header.html';
include '../mysqli_connect.php';
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
  if(isset($_REQUEST['back'])) {
    /************************** Step 2 - Case 3 *************************/
            //redirect to Result Management Section
                header('Location: rsltmng.php');

            }
include 'nav.html';
	echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>'; 
?>

        <?php

        
        ?>
        <div class="container">
            
            <form name="rsltmng" action="rsltmng.php" method="post">
                <div class="menubar">


                    <ul id="menu">
                        <?php if(isset($_SESSION['tcname'])) {
                        // Navigations

                            ?>
                        
                            <?php  if(isset($_REQUEST['testid'])) { ?>
                        
                            <?php }else { ?>
                        
                            <?php } ?>
                    </ul>
                </div>
                <div class="page">
                        <?php
                        if(isset($_REQUEST['testid'])) {
                    /************************** Step 3 - Case 2 *************************/
                        // Displays the Existing Test Results in detail, If any.
                            $q = "select t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,
        DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.cid,sub.cname,IFNULL((select sum(marks) from Question where testid=".$_REQUEST['testid']."),0) as maxmarks 
        from Test as t, Course as sub where sub.cid=t.cid and t.testid=".$_REQUEST['testid']."" ;
                            $result = @mysqli_query($dbc, $q);
                            if(mysqli_num_rows($result)!=0) {

                                $r=mysqli_fetch_array($result);
                                ?>
                    
    
     <table class="table table-striped">
                        <tr><td colspan="2"><hr style="color:#ff0000;border-width:2px;"/></td></tr>
                        <tr>
                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Attempted Students</h3></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                        </tr>
        </table>

                                <?php
/*
                                $t = "select s.sname,s.email,IFNULL((select sum(q.marks) from 
        StudentQuestion as sq,Question as q where q.qnid=sq.qnid and sq.testid=".$_REQUEST['testid']." and 
        sq.sid=st.sid and sq.stdanswer=q.correctanswer),0) as om from StudentTest as st, Student as s where 
        s.sid=st.sid and st.testid=".$_REQUEST['testid']."";
        */
                           $t = "select s.sid,s.sname,s.email,IFNULL((select sum(q.marks) from StudentQuestion as sq, Question as q 
                         where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and 
                            sq.stdanswer=q.correctanswer and sq.sid=st.sid and 
                   sq.testid=".$_REQUEST['testid']." order by sq.testid),0) as om from StudentTest as st, Student as s where 
        s.sid=st.sid and st.testid=".$_REQUEST['testid']."";
                                $result1 = @mysqli_query($dbc, $t);

                                if(mysqli_num_rows($result1)==0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">No Students Yet Attempted this Test!</h3>";
                                }
                                else {
                                    ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Student Name</th>
                            <th>Email-ID</th>
                            <th>Obtained Marks</th>
                            <th>Result(%)</th>
                            <th>Details</th>


                        </tr>
                                        <?php
                                        while($r1=mysqli_fetch_array($result1)) {

                                            ?>
                        <tr>
                            <td><?php echo htmlspecialchars_decode($r1['sname'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($r1['email'],ENT_QUOTES); ?></td>
                            <td><?php echo $r1['om']; ?></td>
                            <td><?php echo round((($r1['om']/$r['maxmarks'])*100),1)." %"; ?></td>
                          <?php echo "<td class=\"tddata\"><a title=\"Details\" href=\"graderesult.php?details=".$_REQUEST['testid']."&stdid=".$r1['sid']."\"><img src=\"../img/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td>";?>


                        </tr>
                                        <?php
                                        
                                        }

                                    }
                                }
                                else {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Something went wrong. Please logout and Try again.</h3>";
                                }
                                ?>
                    </table>
<li><input type="submit" value="Back" name="back" class="subbtn" title="Manage Results"/></li>

                        <?php

                        }
                        else {

                        /************************** Step 3 - Case 2 *************************/
                        // Defualt Mode: Displays the Existing Test Results, If any.
                            $v = "select t.testid,t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,
        DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.cid,sub.cname,(select count(sid) from StudentTest 
        where testid=t.testid) as attemptedstudents from Test as t, Course as sub where sub.cid=t.cid and sub.status = 'Active' and t.tcid=".$_SESSION['tcid']."";
                            $result = @mysqli_query($dbc, $v);
                            if(mysqli_num_rows($result)==0) {
                                echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet...!</h3>";
                            }
                            else {
                                $i=0;

                                ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Test Name</th>
                            <th>Validity</th>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Attempted Students</th>
                            <th>Details</th>
                            <th>Grades</th>
                        </tr>
            <?php
                                    while($r=mysqli_fetch_array($result)) {
                                        $i=$i+1;
                                        if($i%2==0) {
                                            echo "<tr class=\"alt\">";
                                        }
                                        else { echo "<tr>";}
                                        echo "<td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".$r['fromdate']." To ".$r['todate']." PM </td><td>".htmlspecialchars_decode($r['cid'],ENT_QUOTES)."</td><td>"
                                            .htmlspecialchars_decode($r['cname'],ENT_QUOTES)."</td><td>".$r['attemptedstudents']."</td>"
                                            ."<td class=\"tddata\"><a title=\"Details\" href=\"grade.php?testid=".$r['testid']."\"><img src=\"../img/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td>"
                                            ."<td class=\"tddata\"><a title=\"Details\" href=\"grade.php?testid=".$r['testid']."\"><img src=\"../img/detail.png\" height=\"30\" width=\"40\" alt=\"Details\" /></a></td></tr>";
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
