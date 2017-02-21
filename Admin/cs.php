<?php 
error_reporting(E_ALL ^ E_NOTICE)
?>
<select name="cid">
<?php 
include '../mysqli_connect.php';
$q ="select cid,section_id,cname from Course_Info";
//$r = @mysqli_query($dbc, $q);
$r = @mysqli_query($dbc, $q);

if(strcmp($_POST['cid'], "<Choose the Course>") == 0){ 
	echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
		$cid = $row['cid']."-".$row['section_id']."-".$row['cname'];
		echo "<option value=\"$cid\">" . $cid . "</option>";
	}
}elseif(isset($_POST['cid'])){ ?>
 <option value="<?php echo $_POST['cid']; ?>" selected><?php echo  $_POST['cid']; ?></option>	
<?php 
}else{
echo '<option value="<Choose the Course>" selected>&lt;Choose the Course&gt;</option>';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))	{
	$cid = $row['cid']."-".$row['section_id']."-".$row['cname'];
	echo "<option value=\"$cid\">" . $cid . "</option>";
}
}
?>
</select>
