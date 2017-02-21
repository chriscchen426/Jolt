<?php
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{

	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];

	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);

	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}

	include_once 'mysqli_connect.php';
    //$s_id = (int)($_POST['sid']);
	$q = "INSERT INTO Upload (name, size, type, content ) ".
			"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

	$r = @mysqli_query($dbc, $q) or die('Error, query failed');
	//include 'library/closedb.php';
 if($r){
 	echo "<br>File $fileName uploaded into Database<br>";
 	}else{
 		echo '<p style = "color:#ff0000;"> ' . $fileName . 'upload failed';
 	}
}

?>

<form action = "upload_file.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
<input name="userfile" type="file" id="userfile">
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>