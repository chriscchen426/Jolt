<?php

//USER Story: Client Requested to see exam details for each student for each student.
//USER Story: Print the exam details for each student for each exam.
//Version: OES1.2
//Developed by: DIPAKKUMAR PATEL

session_start();
if(!isset($_SESSION['tcname'])){
    header('Location: index.php');
}
//include 'header.html';
include '../mysqli_connect.php';
if(isset($_REQUEST['back'])) {
    //redirect to View Result

    header('Location: rsltmng.php');

}
?>
<div id="container">
            <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="250" src="../images/logo.JPG" alt="OES"/><h3 class="headtext"> &nbsp;Online Examination System </h3><h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i></i></h4>
            </div>
            <form id="summary" action="graderesult.php" method="post">
            <div class="menubar">
                    <ul id="menu">
            <?php 
// Navigations
if(isset($_REQUEST['details']) && isset($_REQUEST['stdid'])) {
    ?>
   <li><input type="submit" value="Back" name="back" class="subbtn" title="Manage Results"></li>
   <li><input type="button" value="Print Preview" class="subbtn" onClick="printPage(printsection.innerHTML)"></li>
  </ul>
    </div>
    <div id="printsection"> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>OES-View Result</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ROBOTS" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="../oes.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
        <script language="javascript">
function printPage(printContent) {
var display_setting="toolbar=yes,menubar=yes,";
display_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";


var printpage=window.open("","",display_setting);
printpage.document.open();
printpage.document.write('<html><head><title>Exam Report</title><link rel="stylesheet" type="text/css" href="../oes.css" /></head>');
printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>');
printpage.document.close();
printpage.focus();
}
</script> 
    </head>
    <body >
       
       
       
                  

                   
                <div class="page">

                        
                    
                                <?php

                                $v = "select q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa 
                                       from StudentQuestion as sq,Question as q 
                                        where q.qnid=sq.qnid and sq.testid=q.testid and 
                                         sq.testid=".$_REQUEST['details']." and sq.sid=".$_REQUEST['stdid']." order by q.qnid";
                                $result1 = @mysqli_query($dbc, $v);

                                if(mysqli_num_rows($result1)==0) {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">1.Sorry because of some problems Individual questions Cannot be displayed.</h3>";
                                }
                                else {
                                    ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>Q. No</th>
                            
                            <th>Correct Answer</th>
                            <th>Student's Answer</th>
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
                                                q.correctanswer=sq.stdanswer and sq.sid=".$_REQUEST['stdid']." and q.qnid=".$r1['questionid']." 
                                                  and q.testid=".$_REQUEST['details']."),0),0) as stdmarks from Question 
                                                where qnid=".$r1['questionid']." and testid=".$_REQUEST['details']."";
                                           $result2 = @mysqli_query($dbc, $t);

                                            if($r2=mysqli_fetch_array($result2)) {
                                                ?>
                        <tr>
                            <td><?php echo $r1['questionid']; ?></td>
                            
                            <td><?php echo htmlspecialchars_decode($r2['corans'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($r2['stdans'],ENT_QUOTES); ?></td>
                            <td><?php echo $r2['stdmarks']; ?></td>
                                                    <?php
                                                    if($r2['stdmarks']==0) {
                                                        echo"<td class=\"tddata\"><img src=\"../images/wrong.png\" title=\"Wrong Answer\" height=\"30\" width=\"40\" alt=\"Wrong Answer\" /></td>";
                                                    }
                                                    else {
                                                        echo"<td class=\"tddata\"><img src=\"../images/correct.png\" title=\"Correct Answer\" height=\"30\" width=\"40\" alt=\"Correct Answer\" /></td>";
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

                                        //for open ended questions result
                                        $op = "select q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa ,sq.comments as c, sq.grade as g
                                                 from StudentOpQuestion as sq,OpQuestion as q 
                                                where q.qnid=sq.qnid and sq.testid=q.testid and 
                                               sq.testid=".$_REQUEST['details']." and sq.sid=".$_REQUEST['stdid']." order by q.qnid";
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
                            <th>Student's Answer</th>
                            <th>Comment</th>
                            <th>Grade</th>
                            <th>&nbsp;</th>
                        </tr>
                                        <?php
                                        while($rop=mysqli_fetch_array($resultop)) {

                                       

                                        
                                                ?>
                        <tr>
                            <td><?php echo $rop['questionid']; ?>
                            <input type='hidden' name='questionid[]' value='<?php echo $rop['questionid']; ?>'>
                            <input type='hidden' name='testid[]' value='<?php echo $_REQUEST['details']; ?>'>
                            <input type='hidden' name='stdid[]' value='<?php echo $_REQUEST['stdid']; ?>'>
                            </td>
                            <?php $_SESSION['questionid'] = $rop['questionid']; ?>
                            <td><?php echo htmlspecialchars_decode($rop['ca'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($rop['sa'],ENT_QUOTES); ?></td>
                            <td>
                                <input type='text' size=15 name='comments[]' value='<?php echo htmlspecialchars_decode($rop['c'],ENT_QUOTES); ?>'>
                            </td>
                            <td>
                                <input type='text' size=15 name='grades[]' value='<?php echo htmlspecialchars_decode($rop['g'],ENT_QUOTES); ?>'>
                            </td>
                            
                        </tr>
                            <?php
                                               
                                            }

                                        }
                                        ?>
                            <tr>
                                <th style="width:8%;text-align:right;"><h4><input type="submit" name="submit" value="Submit" class="subbtn"/></h4></th>      
                            </tr>
                                        <?php

}
if(isset($_POST['submit'])){
    

    $questionid =$_POST['questionid'];
    $testid =$_POST['testid'];
    $stdid = $_POST['stdid'];
    $comments = $_POST['comments'];
    $grades = $_POST['grades'];



    for($i=0; $i<count($questionid); $i++){


            $query[$i] = "UPDATE StudentOpQuestion set comments = '$comments[$i]', grade = $grades[$i] where sid='$stdid[$i]' and testid='$testid[$i]' and qnid=$questionid[$i]";    
           // echo  $query[$i];
            $result[$i] =  @mysqli_query($dbc, $query[$i]);
            if(!$result)
            {
                echo '<p style = "color:#ff0000;">' . mysqli_error($dbc) . '<br /> <br /> query: ' .$query . '</p>';
                // to do

            }
            
                
            

        
    }

    header('Location: rsltmng.php');

}
else{
    echo "Error! can't get the information form post method.";
}

                    
                                    ?>
                    </table>

                    
                    </div>
                    </div>
                    
           

                                               
              