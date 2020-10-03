<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$exp_mod_week_data_old = getFullURL($_GET["r"],"exp_mod_week_data_old.php","N");
$exp_mod_shift_data = getFullURL($_GET["r"],"exp_mod_shift_data.php","N");
$view_access=user_acl("SFCS_0072",$username,1,$group_id_sfcs); 
?>

<script>
function verify(){
		var from = document.getElementById('dat1').value;
		var to = document.getElementById('dat2').value;
		if( from > to){
			sweetAlert('End date must not be greater than start date','','warning');
			return false;
		}
		return true;

<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;

	}
}
</script>

<!-- <style type="text/css">
	body{ 
		margin:15px; padding:15px; border:0px solid #666;
		font-family:Arial, Helvetica, sans-serif; font-size:12px; 
	}
	a {
		margin:0px; padding:0px;
	}
	caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
	pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
	.mytable1{
		font-size:12px;
	}
	th{ background-color:#EEEEEE; padding:2px; border:0px solid #ccc; }
	td{ background-color:#EEEEEE; padding:2px; border-bottom:0px solid #ccc; border-right:0px solid #ccc; white-space:nowrap;}
</style> -->

<div class="panel panel-primary">
	<div class="panel-heading">Weekly Style Progress</div>
	<div class="panel-body">
		<form method="post" class="form_inline" action=<?php getFullURLLevel($_GET['r'],'exp_mod_main.php',0,'N') ?>>
		<div class="row">
			<div class="col-md-3"><label>Start Date </label><input type="text" data-toggle='datepicker' class="form-control" id="dat1" name="dat1" size=8  value="<?php  if(isset($_GET['dat1'])) { echo $_GET['dat1']; } else { echo date("Y-m-d"); } ?>"/></div>
			<div class="col-md-3"><label>End Date </label><input type="text" data-toggle='datepicker'class="form-control" id="dat2" name="dat2" size=8 value="<?php  if(isset($_GET['dat2'])) { echo $_GET['dat2']; } else { echo date("Y-m-d"); } ?>"/></div>
			<div class="col-md-1"><label>Section</label>
				<?php
					echo "<select name=\"sec\" class='form-control'>";
					$sql="SELECT sec_id as secid FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
					$result17=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($result17))
					{
						$sql_sec=$sql_row["secid"];
						if($_GET['sec'] == $sql_sec){
							echo "<option value=\"".$sql_sec."\" selected>".$sql_sec."</option>";
						} else {
							echo "<option value=\"".$sql_sec."\" >".$sql_sec."</option>";
						}
							
					}
					echo "</select>";
				?>
			</div>
			<div class="col-md-2"><label>Category</label><select name="cat" class="form-control">
				<?php
					$categories = ['Weekly', 'Shift'];
					foreach ($categories as $key => $value) {
						if($_GET['cat'] == $value){
							echo "<option value=\"".$value."\" selected>".$value."</option>";
						}else {
							echo "<option value=\"".$value."\" >".$value."</option>";
						}
					}
				?>
				</select>
			</div>
			<div class="col-md-1"><br/><input type="submit" onclick='return verify_date()' class="btn btn-primary" NAME="submit" value="Show" /></div>
		</div>
		<br/><hr/>
		</form>

<!-- <span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span> -->
<?php

if(isset($_POST["submit"]))
{
	$start=$_POST['dat1'];
	$end=$_POST['dat2'];
	$sec=$_POST['sec'];
	$cat=$_POST['cat'];
	// echo $_POST['cat'];
	// echo $start;
	if($cat == "Weekly")
	{
		// header("Location:exp_mod_week_data_old.php?dat1=$start&dat2=$end&sec=$sec&cat=$cat");
		echo '<script>
				window.location.href="'.$exp_mod_week_data_old.'&dat1='.$start.'&dat2='.$end.'&sec='.$sec.'&cat='.$cat.'";
		</script>';
		

	}
	elseif($cat == "Shift")
	{
		// header("Location:exp_mod_shift_data.php?dat1=$start&dat2=$end&sec=$sec&cat=$cat");	
		echo '<script>
			window.location.href="'.$exp_mod_shift_data.'&dat1='.$start.'&dat2='.$end.'&sec='.$sec.'&cat='.$cat.'";
		</script>';
		// header("Location:'.$exp_mod_shift_data.'?dat1='.$start.'&dat2='.$end.'&sec='.$sec.'&cat='.$cat.'");
	}
	else
	{
		header("Location:http://bainet");
	}
}

?>
</div>

