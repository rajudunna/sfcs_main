<html lang="en">
<head>
	<title>Edit Bundle Operation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<style>
		.pull{    
			float: right!important;
			margin-top: -7px;
		}
	</style>
	 <script>
function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script>
</head>
<?php

	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));	
	
	if(isset($_GET['id']))
	{
		
		$operation_name = "";
		$operation_code = "";
		$id = $_GET['id'];
	
		$qry = "select * from $brandix_bts.tbl_ims_ops where appilication='".$id."'";
		$res_do_num = mysqli_query($link,$qry);
		while($res_result = mysqli_fetch_array($res_do_num))
		{
			$row[] = $res_result;
	    }
 	}		
	if(isset($_POST['submit']))
	{
		$details=explode('|',$_POST['opn']);
		$operation_name=$details[1];
		$operation_code=$details[0];
		$id = $_POST['app'];
		$is_valid = 1;

		if($id=='IMS'){
			$ims_operation="select operation_order from $brandix_bts.default_operation_workflow where operation_code =$operation_code";
			$ress_ims = mysqli_query($link,$ims_operation);
			while ($ims_row = mysqli_fetch_array($ress_ims))
			{
				$ims = $ims_row['operation_order'];
			}
		} else {
			$ims_operation="select operation_order from $brandix_bts.default_operation_workflow where operation_code =(select operation_code from  $brandix_bts.tbl_ims_ops where appilication = 'IMS')";
			$ress_ims = mysqli_query($link,$ims_operation);
			while ($ims_row = mysqli_fetch_array($ress_ims))
			{
				$ims = $ims_row['operation_order'];
			}
		}
		if($id=='IMS_OUT'){
			$ims_out_operation="select operation_order from $brandix_bts.default_operation_workflow where operation_code =$operation_code";
			$ress_ims_out = mysqli_query($link,$ims_out_operation);
			while ($ims_out_row = mysqli_fetch_array($ress_ims_out))
			{
				$ims_out = $ims_out_row['operation_order'];
			}
		} else {
			$ims_out_operation="select operation_order from $brandix_bts.default_operation_workflow where operation_code =(select operation_code from  $brandix_bts.tbl_ims_ops where appilication = 'IMS_OUT')";
			$ress_ims_out = mysqli_query($link,$ims_out_operation);
			while ($ims_out_row = mysqli_fetch_array($ress_ims_out))
			{
				$ims_out = $ims_out_row['operation_order'];
			}
		}
		// echo $ims.'<br/>';
		// echo $ims_out.'<br/>';
		// echo $id.'<br/>';
		
		if($id=='IMS' || $id=='IMS_OUT'){
			$is_valid = 0;
			if(strlen($ims) > strlen($ims_out)){
				$is_valid = 0;
				$hurl = getFullURLLevel($_GET['r'],'master.php',0,'N');
				echo "<script type=\"text/javascript\"> 
					setTimeout(\"Redirect()\",1000); 
					function Redirect() {  
						sweetAlert('Operation Code is not valid','IMS operation is greater than IMS OUT','error');
						location.href = '$hurl'; 
					}
				</script>";
			} else {
				$is_valid = 1;
			}
		}
		if($id=='IPS'){
			$get_count_ims_log="select * from $bai_pro3.ims_log";
			$res_ims_log_count = mysqli_query($link,$get_count_ims_log);
			$get_count_ims_log_bkp="select * from $bai_pro3.ims_log_backup";
			$res_ims_log_bkp_count = mysqli_query($link,$get_count_ims_log_bkp);
			if(mysqli_num_rows($res_ims_log_count)==0 && mysqli_num_rows($res_ims_log_bkp_count)==0){
				$is_valid= 1;
			}
			else {
				$is_valid= 0;
				echo "<script>sweetAlert('Cant edit for IPS Application','','error')</script>";
			}
		}
		// echo $is_valid.'<br/>';
		// die();
		if($is_valid=='1'){
			$qry_insert1 = "update $brandix_bts.tbl_ims_ops set operation_name='$operation_name',operation_code='$operation_code' where appilication='$id'";
			$res_do_num1 = mysqli_query($link,$qry_insert1);
			echo "<h3 style='color:red;text-align:center;'>Please Wait!!!  While Redirecting to page !!!</h3>";
			$hurl = getFullURLLevel($_GET['r'],'master.php',0,'N');
			echo "<script type=\"text/javascript\"> 
				setTimeout(\"Redirect()\",0); 
				function Redirect() {  
					sweetAlert('Operation Updated Successfully','','success');
					location.href = '$hurl'; 
				}
			</script>";
		}

	}	
		?>
		
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">Update Operation for application =  <?php echo "<b>".$id."</b>"; ?>
						<a href='<?= getFullURLLevel($_GET['r'],'master.php',0,'N'); ?>' class='pull btn btn-warning'>Back</a>
					</div>
					<div class="panel-body">
						<div class="alert alert-danger" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
						<div class="panel-body">
					<div class="alert alert-danger" style="display:none;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Info! </strong><span class="sql_message"></span>
					</div>
					<div class="form-group">
						<form name="test" class="form-inline" action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" id='form_submt'>
								
								<div class="form-group">

									<b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
									<select class="form-control" id="opn" name="opn" required>
										<option value="">Select</option>
										<?php
										if($_GET['id'] == 'IPS'){
											echo '<option value="Auto|Auto">Auto</option>';
										}
										?>
									<?php
										$get_operations="SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref where operation_code not in (10,15) group by operation_code order by operation_code*1";
										$result=mysqli_query($link,$get_operations);
										while ($test = mysqli_fetch_array($result))
										{
											echo '<option value="'.$test['operation_code'].'|'.$test['operation_name'].'">'.$test['operation_name'].' - '.$test['operation_code'].'</option>';
										}
									?>
									</select>
									<input type="hidden" class="form-control" id="app" name="app" value="<?=$_GET['id']?>">
								</div> 
								<div class="form-group">
									<input type="submit" name="submit" id="submit" class="btn btn-success" value="Update">
								</div>		
						</form>
					</div>	
				</div>
				</div>
			</div>
		<?php
		
 ?>
