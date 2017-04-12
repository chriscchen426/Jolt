
<?php 
error_reporting(E_ALL ^ E_NOTICE)
?>
<select name="sem">
<?php 
if(strcmp($_POST['sem'], "<Choose the Semester>") == 0){ ?>
 <option value="<Choose the Semester>" selected>&lt;Choose the Semester&gt;</option>
  <option value="Spring">Spring</option>
  <option value="Summer1">Summer 1</option>
  <option value="Summer2">Summer 2</option>
  <option value="Fall">Fall</option>
  <option value="Winter">Winter</option>
  <?php }elseif(isset($_POST['sem'])){ ?>
 <option value="<?php echo $_POST['sem']; ?>" selected><?php echo  $_POST['sem']; ?></option>
  <?php }else{?>
  <option value="<Choose the Semester>" selected>&lt;Choose the Semester&gt;</option>
  <option value="Spring">Spring</option>
  <option value="Summer1">Summer 1</option>
  <option value="Summer2">Summer 2</option>
  <option value="Fall">Fall</option>
  <option value="Winter">Winter</option>
<?php } ?>
</select>  
