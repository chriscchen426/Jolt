<select name="tcid">
<?php 
include '../mysqli_connect.php';
$q ="select tcid,tcname from Testconductor";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$tcid = $row['tcid'];
	echo "<option value=\"$tcid\">" . $row['tcname'] . "</option>";
}
?>
</select>
