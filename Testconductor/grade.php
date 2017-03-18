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
            <form id="summary" action="viewresult.php" method="post">
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
       
       
       
                  <?php
                        }
                        ?>

                   
                <div class="page">

                        <?php

                        if(isset($_REQUEST['details'])) {
                            $q = "select s.sname,t.testname,sub.cname,sub.cid,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as stime,
                                                  TIMEDIFF(st.endtime,st.starttime) as dur,(select sum(marks) from 
                                                   Question where testid=".$_REQUEST['details'].") as tm,IFNULL((select sum(q.marks) from 
                                                  StudentQuestion as sq, Question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' 
                                                  and sq.stdanswer=q.correctanswer and sq.sid=".$_REQUEST['stdid']." 
                                                  and sq.testid=".$_REQUEST['details']."),0) as om from Student as s,Test as t, Course as sub,StudentTest as st 
                                                    where s.sid=st.sid and st.testid=t.testid and 
                                                  t.cid=sub.cid and st.sid=".$_REQUEST['stdid']." 
                                                    and st.testid=".$_REQUEST['details']."";
                            $result = @mysqli_query($dbc, $q);
                            if(mysqli_num_rows($result)!=0) {

                                $r=mysqli_fetch_array($result);
                                ?>
 

                                               
              