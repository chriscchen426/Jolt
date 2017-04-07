<?php

$username = 'chechao';
$password = '990950';
$hostname = 'imc.kean.edu'; 
$dbname = '2016F_chechao';
// $username = 'root';
// $password = '123456';
// $hostname = '127.0.0.1';
// $dbname = 'oes';

//connection to the database
$dbc = @mysqli_connect($hostname, $username, $password,$dbname)
or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";
?>
