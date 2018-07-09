<!--
Code Module:Sample remarks will update in this interface.

Description:Sample remarks of each schedule will update here.

Changes Log:
//Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.
-->
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/functions.php',4,'R')); ?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/header_scripts.php',4,'R')); ?>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<div class="panel panel-primary">
	<div class="panel-heading">Update Binding Consumption</div>
	<div class="panel-body">
	<?php echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURL($_GET['r'], "main_interface.php", "N")."&color=".$_GET['color']."&style=".$_GET['style']."&schedule=".$_GET['schedule']."\"><<<< Click here to Go Back</a>"; ?>
	<?php //include("../menu_content.php");
	?>
		<form name="test" method="post" action="<?php echo getFullURL($_GET['r'], "edit_remarks.php", "N"); ?>">
			<div class="row">
				<div class="col-sm-4" style="display:none;"><label>Remarks : </label>
					<input type="textarea" class="form-control" rows="1" name="rem" value="<?= $_GET['remarks_x']?>" required></textarea >
				</div>
				<div class="col-sm-5"><label>Binding/Rib Consumption (If no item code is available) :</label> 
					<input type="text" step="any"  title="Enter only numbers and decimals" class="form-control float" id='rib' required name="bind_con" value="<?php echo $_GET['bind_con']; ?>"></div>
					<input type="submit" class="btn btn-sm btn-success" name="submit" value="Update" style="margin-top:22px;">
				</div>
			<input type="hidden" name="style_x" value="<?php echo $_GET['style']; ?>"> 
			<input type="hidden" name="schedule_x" value="<?php echo $_GET['schedule']; ?>"> 
			<input type="hidden" name="color_x" value="<?php echo $_GET['color']; ?>"> 
			<input type="hidden" name="o_tid" value="<?php echo $_GET['tran_order_tid']; ?>"> 
		</form>
	</div>
</div>

<?php

if(isset($_POST['submit']))
{
	$rem=$_POST['rem'];
	$style_x=$_POST['style_x'];
	$schedule_x=$_POST['schedule_x'];
	$color_x=$_POST['color_x'];
	$o_tid=$_POST['o_tid'];
	$bind_con=$_POST['bind_con'];
	

	$sql="insert ignore into $bai_pro3.bai_orders_db_remarks (order_tid) values (\"$o_tid\")";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="update $bai_pro3.bai_orders_db_remarks set remarks=\"$rem\", binding_con=\"$bind_con\" where order_tid=\"$o_tid\"";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if($sql_result){
		echo "<script>sweetAlert('Order remarks Updated Successfully','','success')</script>";
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=$color_x&style=$style_x&schedule=$schedule_x\"; }</script>";
	}else{
		echo "<script>sweetAlert('Order remarks Updation Failed','Please try again','error')</script>";
	}
}

?>
