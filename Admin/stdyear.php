
<?php 
error_reporting(E_ALL ^ E_NOTICE)
?>
<select name="year">
<?php 
if(strcmp($_POST['year'], "<Choose the Year>") == 0){ ?>
<option value="<Choose the Year>" selected>&lt;Choose the Year&gt;</option>
  <option value="2016">2016</option>
  <option value="2017">2017</option>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
<?php }elseif(isset($_POST['year'])){ ?>
 <option value="<?php echo $_POST['year']; ?>" selected><?php echo  $_POST['year']; ?></option>
<?php }else{?>
  <option value="<Choose the Year>" selected>&lt;Choose the Year&gt;</option>
  	<option value="2016">2016</option>
  	<option value="2017">2017</option>
  	<option value="2018">2018</option>
  	<option value="2019">2019</option>
  	<option value="2020">2020</option><?php 
  } ?>
</select> 


