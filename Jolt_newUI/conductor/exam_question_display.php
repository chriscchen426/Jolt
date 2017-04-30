<?php

session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
//echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
//echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
//if(isset($_POST['submit'])){
	
include '../mysqli_connect.php';
/*
$tcid = $_SESSION['tcid'];
$cid = $_POST['cid'];
//$_SESSION['cid'] = $cid;
$tid = $_POST['tid'];
//$year = (int)$_POST['year'];
$v = "select cname from Course where cid = '$cid'";
$t = @mysqli_query($dbc, $v);
$row1 = mysqli_fetch_assoc($t);
*/
if (isset($_POST['add']) == 'Add Question') {
	header('Location: prepqn.php');
}
if (isset($_POST['cancel']) == 'Cancel') {
	header('Location: test_info.php');
}
if (isset($_POST['upload']) == 'Upload Question') {
	header('Location: upload_questions.php');
}

if (isset($_POST['addOp']) == 'Add Question') {
    header('Location: prepOpqn.php');
}
if (isset($_POST['uploadOp']) == 'Upload Question') {
    header('Location: upload_Opquestions.php');
}
if (isset($_POST['addbank']) == 'Choose Questions from Bank') {
    header('Location: select_from_bank.php');
}


$q = "select * from Question where testid=" . $_SESSION['testqn'] . " order by qnid";

$result = @mysqli_query($dbc, $q);

$q2 = "select * from OpQuestion where testid=" . $_SESSION['testqn'] . " order by qnid";
$result2 = @mysqli_query($dbc, $q2);

include 'nav.html';
echo '<h4>&nbsp;</h4>';
echo '<h4>&nbsp;</h4>';
?>
<div class="container">
<form action="exam_question_display.php" method="post">

<?php
if (isset($_SESSION['tcname'])) {
    // Navigations
?>

   
<input type="submit" value="Upload M.C.Question" name="upload" class="btn btn-primary">
<input type="submit" value="Add M.C.Question" name="add" class="btn btn-primary">


<input type="submit" value="Upload Open_ended Question" name="uploadOp" class="btn btn-primary">
<input type="submit" value="Add Open_ended Question" name="addOp" class="btn btn-primary">

<input type="submit" value="Choose Questions from Bank" name="addbank" class="btn btn-primary">                  
</tr>

<?php
            } 
 if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 ) {
   

 	echo "<h3 style=\"color:#0000cc;text-align:center;\">No Questions Yet..!</h3>";
 	
 	
 } else {
 	//$i = 0;
    //$q = "SELECT *FROM OpQuestion where qnid = $qid AND testid=" . $_SESSION['testqn'] . "";
    $q3 = "SELECT * from Test where testid=" . $_SESSION['testqn'] . "";
    //echo $q3;
    $result3 = @mysqli_query($dbc, $q3);    
    $r3 = mysqli_fetch_array($result3);

 	?>
                                 <table class="table table-striped">
                                    <tr style="background-color: #e0e0e0">
                                        
                                        <th colspan="3">Total Multiple Questions in this test:</th>
                                        <th><?php echo $r3['totalquestions']; ?></th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        
                                    </tr>

                                     <tr style="color: #245580">
                                         <th>&nbsp;</th>
                                         <th>Qn.No</th>
                                         <th>Multiple Choice Question</th>
                                         <th>Difficulty</th>
                                         <th>Correct Answer</th>
                                         <th>Score</th>
                                         <th>Edit</th>
                                     </tr>
 <?php
                                 while ($r = mysqli_fetch_array($result)) {
                                     
                                         echo "<tr>";
                                      echo "<td><a href=delete_question.php?qid=".$r['qnid']."><strong>DELETE</strong></a></td><td>" . htmlspecialchars_decode($r['qnid'], ENT_QUOTES) 
                                    . "</td><td>" . htmlspecialchars_decode($r['question'], ENT_QUOTES) . "</td>";
                                    
                                    if(htmlspecialchars_decode($r['difficulty'], ENT_QUOTES) == 1)
                                        echo "<td>Easy</td>";
                                    elseif(htmlspecialchars_decode($r['difficulty'], ENT_QUOTES) == 2)
                                        echo "<td>Medium</td>";
                                    else
                                        echo "<td>Hard</td>";
                                    echo "<td>" 
                                    . htmlspecialchars_decode($r[htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES)], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['marks'], ENT_QUOTES) . "</td>"
                                   . "<td class=\"tddata\"><a title=\"Edit " . $r['qnid'] . "\"href=\"update_question.php?qid=" . $r['qnid'] . "\"><img src=\"../img/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>"
                                    . "</td></tr>";
                                 }
?>      
                                <tr style="background-color: #e0e0e0">
                                        
                                        <th colspan="3">Total Open ended Questions in this test:</th>
                                        <th><?php echo $r3['totalopquestion']; ?></th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        
                                    </tr>
                                 <tr style="color: #265a88">
                                         <th>&nbsp;</th>
                                         <th>Qn.No</th>
                                         <th>Open ended Question</th>
                                         <th>Difficulty</th>
                                         <th>Correct Answer</th>
                                         <th>Score</th>
                                         <th>Edit</th>
                                     </tr>
                                     <?php

                                  while ($r2 = mysqli_fetch_array($result2)) {
                                     
                                         echo "<tr>";
                                      echo "<td><a href=delete_Opquestion.php?qid=".$r2['qnid']."><strong>DELETE</strong></a></td><td>" . htmlspecialchars_decode($r2['qnid'], ENT_QUOTES) 
                                    . "</td><td>" . htmlspecialchars_decode($r2['question'], ENT_QUOTES) . "</td>";
                                    
                                    if(htmlspecialchars_decode($r2['difficulty'], ENT_QUOTES) == 1)
                                        echo "<td>Easy</td>";
                                    elseif(htmlspecialchars_decode($r2['difficulty'], ENT_QUOTES) == 2)
                                        echo "<td>Medium</td>";
                                    else
                                        echo "<td>Hard</td>";
                                    echo "<td>" . htmlspecialchars_decode($r2['correctanswer'], ENT_QUOTES). "</td><td>" . htmlspecialchars_decode($r2['marks'], ENT_QUOTES) . "</td>"
                                   . "<td class=\"tddata\"><a title=\"Edit " . $r['qnid'] . "\"href=\"update_Opquestion.php?qid=" . $r2['qnid'] . "\"><img src=\"../img/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>"
                                    . "</td></tr>";
                                 }
 ?>
                             </table>

                             <?php 
                             }
 
?>
</div>
<html>
<head>
    
    </head>
</html>