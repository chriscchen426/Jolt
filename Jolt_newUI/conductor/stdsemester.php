
<?php 

?>
<select name="sem">
<?php 
if(isset($_POST['sem'])){ ?>
<option value="<?php echo $_POST['sem']; ?>" selected><?php echo $_POST['sem']; ?></option>
<?php 
}else{ ?>
 <option value="<Choose the Semester>" selected>&lt;Choose the Semester&gt;</option>
  <option value="Spring">Spring</option>
  <option value="Summer 1">Summer 1</option>
  <option value="Summer 2">Summer 2</option>
  <option value="Fall">Fall</option>
  <option value="Winter">Winter</option>
</select> 
<?php 
}
?>