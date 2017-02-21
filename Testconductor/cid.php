<select name="cid">
<?php 
include '../mysqli_connect.php';
$q ="select cid,cname from Course";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q);
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$cid = $row['cid'];
	echo "<option value=\"$cid\">" . $row['cname'] . "</option>";
}
?>
</select>
