<?php
session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
include '../mysqli_connect.php';
$tcname = $_SESSION['tcname'];
$tcid = $_SESSION['tcid'];
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
if (isset($_REQUEST['manageqn']) && isset($_REQUEST['course_id']) && isset($_REQUEST['course_name'])) {
$_SESSION['testqn'] = $_REQUEST['manageqn'];
$_SESSION['course_id'] = $_REQUEST['course_id'];
$_SESSION['course_name'] = $_REQUEST['course_name'];
$t = "select testname,cid from Test where testid =" . $_SESSION['testqn'] . " and tcid=" . $_SESSION['tcid'] . "";
$result = @mysqli_query($dbc, $t);
if ($r = mysqli_fetch_array($result)) {
	$_SESSION['cid'] = $r['cid'];
        $_SESSION['testname'] = $r['testname'];
        //$_SESSION['testqn'] = $r['testid'];
        // $_GLOBALS['message']=$_SESSION['testname'];
       header('Location: exam_question_display.php');
    }
	}else if (isset($_POST['add']) == 'Add Test') {
	header('Location: testmng.php');
}

$r = "select t.testid,s.cid,t.testname,t.testdesc,s.cname,t.testcode as tcode,DATE_FORMAT(t.testfrom,'%d-%M-%Y') as testfrom,DATE_FORMAT(t.testto,'%d-%M-%Y %H:%i:%s %p') as testto 
		from Test as t,Course as s where t.cid=s.cid and s.status = 'Active' and t.tcid=" . $_SESSION['tcid'] . " order by t.testdate desc,t.testtime desc";
$result = @mysqli_query($dbc, $r);
$num = mysqli_num_rows($result);
include 'nav.html';
?>
<h4>&nbsp;</h4>
<h4>&nbsp;</h4>
        <div class="container">
        
           
            <form action="test_info.php" method="post">
        


                
<?php

if (isset($_SESSION['tcname'])) {
    // Navigations
?>
                       


                  

                
            <?php
            } 
if($num > 0){
	//$i = 0;
	//echo '<h3 style = "color : #0000FF" > List Of All Test Available<br><br></h3>';
	echo '<table cellpadding="30" cellspacing="10" class="table table-striped">
                                        <tr>
                                            <th>&nbsp;</th>
		                                     <th>Test ID</th>
		                                     <th>Course ID</th>
                                            <th>Test Description</th>
                                            <th>Course Name</th>
                                            <th>Test Secret Code</th>
                                            <th>Validity</th>
                                            <th>Edit</th>
                                            <th style="text-align:center;">Manage<br/>Questions</th>
		                                     
                                        </tr>
			';
	
	while ($r = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td><a href=delete_test.php?id=".$r['testid']."><strong>DELETE</strong></a></td><td>" . htmlspecialchars_decode($r['testid'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['cid'], ENT_QUOTES) . "</td><td> " . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . " : " . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES)
		. "</td><td>" . htmlspecialchars_decode($r['cname'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['tcode'], ENT_QUOTES) . "</td><td>" . $r['testfrom'] . " To " . $r['testto'] . "</td>"
		. "<td class=\"tddata\"><a title=\"Edit \"href=\"update_test.php?id=" . htmlspecialchars_decode($r['testid'], ENT_QUOTES) . "\"><img src=\"../img/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td>"
		 . "<td class=\"tddata\"><a title=\"Manage Questions of " . htmlspecialchars_decode($r['testid'], ENT_QUOTES) . "\"href=\"test_info.php?manageqn=" . htmlspecialchars_decode($r['testid'], ENT_QUOTES) . "&course_id=".$r['cid']."&course_name=".$r['cname']."\"><img src=\"../img/mngqn.png\" height=\"30\" width=\"40\" alt=\"Manage Questions\" /></a></td></tr>";
        
	}
			/*
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
			 
			echo '<tr>
				<td><a href=delete_test.php?id='.$row['testid'].'><strong>DELETE</strong></a></td>
				<td align="left">' . $row['testid'] . '</td>
				<td align="left">' . $row['cid'] . '</td>
				<td align="left">' . $row['testname'] . '</td>
				<td align="left">' . $row['testdesc'] . '</td>
                <td align="left">' . $row['testfrom'] . '</td>
                <td align="left">' . $row['testto'] . '</td>
                <td align="left">' . $row['duration'] . '</td>
                <td align="left">' . $row['totalquestions'] . '</td>
                <td align="left">' . $row['testcode'] . '</td>
		        <td><a href=update_test.php?id='.$row['testid'].'><strong>EDIT</strong></a></td>
                		</tr>
			';	
			
		}*/
		echo '</table><br><br>';
	
		}else{
		echo '<h3 style = "color:#ff0000;"> There is no Test information available for Test Conductor.</h3><br>';
		echo '<li><input type="submit" value="Add Test" name="add" class="subbtn" title="Add"/></li>';
		//echo '<input type="submit" name = "add" value="Add Course">';
		exit();
	}
	
	
	
	?>
	<li><input type="submit" value="Add Test" name="add" class="subbtn" title="Add"/></li>
	</form>
	</div>
	</body>
    </html>

