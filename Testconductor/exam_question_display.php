<?php

session_start();
if(!isset($_SESSION['tcname'])){
	header('Location: index.php');
}
echo '<pre><h2 align = "right"><a href="home.php"><img src="home.jpg" width="50" height="50"></a> <a href="logout.php"><img src="logout.jpg" width="50" height="50"></a></h2></pre> ';
//echo '<h2 align = "right" style="font-family:tempus sans itc;"><a href="home.php">Home</a> <a href="logout.php">Logout</a></h2>';
echo '<h4 align = "right" style = "color : #0000FF"> Welcome, Professor ' . $_SESSION['tcname'] . '<br></h4>';
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


$q = "select * from Question where testid=" . $_SESSION['testqn'] . " order by qnid";
$result = @mysqli_query($dbc, $q);

$q2 = "select * from OpQuestion where testid=" . $_SESSION['testqn'] . " order by qnid";
$result2 = @mysqli_query($dbc, $q2);
?>
<html>
    <head>
        <title>OES-Test Questions</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../oes.css"/>

    </head>
    <body>
        
        <div id="container">
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Java Online Learning and Testing System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
<form action="exam_question_display.php" method="post">
  <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['tcname'])) {
    // Navigations
?>
                       
<li><input type="submit" value="Cancel" name="cancel" class="subbtn"></li>
<li><input type="submit" value="Upload MtQuestion" name="upload" class="subbtn"></li>
<li><input type="submit" value="Add MtQuestion" name="add" class="subbtn"></li>


<li><input type="submit" value="Upload OpQuestion" name="uploadOp" class="subbtn"></li>
<li><input type="submit" value="Add OpQuestion" name="addOp" class="subbtn"></li>


<?php
            } 
 if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 ) {
   
    echo '</ul>';
    echo '</div>';
 	echo "<h3 style=\"color:#0000cc;text-align:center;\">No Questions Yet..!</h3>";
 	
 	
 } else {
 	//$i = 0;
 	?>
                                 <table cellpadding="30" cellspacing="10" class="datatable">
                                     <tr>
                                         <th>&nbsp;</th>
                                         <th>Qn.No</th>
                                         <th>Question</th>
                                         <th>Correct Answer</th>
                                         <th>Marks</th>
                                         <th>Edit</th>
                                     </tr>
 <?php
                                 while ($r = mysqli_fetch_array($result)) {
                                     
                                         echo "<tr>";
                                      echo "<td><a href=delete_question.php?qid=".$r['qnid']."><strong>DELETE</strong></a></td><td>" . htmlspecialchars_decode($r['qnid'], ENT_QUOTES) 
                                    . "</td><td>" . htmlspecialchars_decode($r['question'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r[htmlspecialchars_decode($r['correctanswer'], ENT_QUOTES)], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['marks'], ENT_QUOTES) . "</td>"
                                   . "<td class=\"tddata\"><a title=\"Edit " . $r['qnid'] . "\"href=\"update_question.php?qid=" . $r['qnid'] . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>"
                                    . "</td></tr>";
                                 }

                                  while ($r2 = mysqli_fetch_array($result2)) {
                                     
                                         echo "<tr>";
                                      echo "<td><a href=delete_Opquestion.php?qid=".$r2['qnid']."><strong>DELETE</strong></a></td><td>" . htmlspecialchars_decode($r2['qnid'], ENT_QUOTES) 
                                    . "</td><td>" . htmlspecialchars_decode($r2['question'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r2['correctanswer'], ENT_QUOTES). "</td><td>" . htmlspecialchars_decode($r2['marks'], ENT_QUOTES) . "</td>"
                                   . "<td class=\"tddata\"><a title=\"Edit " . $r['qnid'] . "\"href=\"update_Opquestion.php?qid=" . $r2['qnid'] . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>"
                                    . "</td></tr>";
                                 }
 ?>
                             </table>

                             <?php 
                             }
 
?>
<html>
<head>
    
    </head>
</html>