
	<title>Add New Operation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<!-- <link rel="stylesheet" href="cssjs/bootstrap.min.css"> -->
	<!-- <script src="js/jquery-3.2.1.min.js"></script> -->
	<!-- <script src="js/bootstrap.min.js"></script> -->
  	<script type="text/javascript">
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
	<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

  <!--<link rel="stylesheet" href="cssjs/bootstrap.min.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>-->
<body>
<!--Added 	(1)Delete button for every operation 
			(2)semi-garment form
	by Theja on 07-02-2018
-->     
<?php 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);
?>
<?php
if (isset($_GET['del_id'])) 
	    {
		    echo "<h3 style='color:red;text-align:center;'>Please Wait!!!  While Redirecting to page !!!</h3>";
			$id = $_GET['del_id'];
			$deleteQuery = "DELETE FROM $brandix_bts.tbl_ims_ops WHERE id=".$id;
			$deleteReply = mysqli_query($link,$deleteQuery);
			// mysql_query($deleteQuery, $link) or exit("Problem Deleting the Operation/".mysql_error());
			if ($deleteReply==1) {?>
				<script type="text/javascript">
					sweetAlert("Sucessfully Deleted the Operation","","success");
					window.location.href="<?= getFullURLLevel($_GET['r'],'master.php',0,'N'); ?>";
					exit();
				</script>
			<?php	}else{	?>
				<script type="text/javascript">
					alert("Falied to delete the Operation");
					window.location.href="<?= getFullURLLevel($_GET['r'],'master.php',0,'N'); ?>";						
				</script>
			<?php }
	    }
?>
<?php
if(isset($_POST['submit']))
{
	
	//var_dump($_POST['opn']);
	$details=explode('|',$_POST['opn']);
	//var_dump($details);
	$operation_name=$details[1];
	$operation_code=$details[0];
	$application=$_POST['apn'];
	$log_time=date('Y-m-d H:i:s');

	$is_valid = 1;

	if($application=='IMS'){
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
	if($application=='IMS_OUT'){
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
	
	if($application=='IMS' || $application=='IMS_OUT'){
		$is_valid = 0;
		if(strlen($ims) > strlen($ims_out)){
			$is_valid = 0;
			echo "<script>sweetAlert('Operation Code is not valid','IMS operation is greater than IMS OUT','error');$('#opn').val('');</script>";
		} else {
			$is_valid = 1;
		}
	}
	
	if($application=='IPS'){
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
	if($is_valid == '1'){
		$already_query = "select * from $brandix_bts.tbl_ims_ops where appilication = '$application'";
		$already_result = mysqli_query($link,$already_query);
		if(mysqli_num_rows($already_result)>0){
			$insert_query = "UPDATE $brandix_bts.tbl_ims_ops set operation_name = '$operation_name',operation_code = '$operation_code'
							 where appilication = '$application' ";
		}else{
		   $insert_query = "INSERT INTO $brandix_bts.tbl_ims_ops (operation_name,operation_code,appilication) VALUES('$operation_name','$operation_code','$application')";
	   }
	   $res_do_num = mysqli_query($link,$insert_query);
   
	   echo "<script>sweetAlert('Saved Successfully','','success')</script>";
	}
}

?>

<div class="container">

			<div class="panel panel-primary">
				<div class="panel-heading">
					 Add Bundle Operation Routing
				</div>
				<div class="panel-body">
					<div class="alert alert-danger" style="display:none;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Info! </strong><span class="sql_message"></span>
					</div>
					<div class="form-group">
						<form name="test" class="form-inline" action="index.php?r=<?php echo $_GET['r']; ?>" method="POST" id='form_submt'>
							<!-- <div class="row"> -->
								
								<div class="form-group">
                                    <b>Application<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
									<select class="form-control" id="apn" name="apn" required>
										<option value="">Select</option>
										<option value="IPS">IPS</option>
										<option value="IMS">IMS</option>
										<option value="IMS_OUT">IMS_OUT</option>
										<option value="Down_Time">Down_Time</option>
										<option value="Carton_Ready">Carton Ready</option>
									</select>

									<b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
									<select class="form-control" id="opn" name="opn" required>
										<option value="">Select</option>
										<option value="Auto|Auto" class="hide_auto">Auto</option>
									<?php
										$get_operations="SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref where operation_code not in (10,15) group by operation_code order by operation_code*1";
										$result=mysqli_query($link,$get_operations);
										while ($test = mysqli_fetch_array($result))
										{
											echo '<option value="'.$test['operation_code'].'|'.$test['operation_name'].'">'.$test['operation_name'].' - '.$test['operation_code'].'</option>';
										}
									?>
									</select>
									<!-- <input type="text" class="form-control" id="opn" name="opn" required> -->
								</div> 
								<!-- <div class="col-sm-2">
									<b>Operation code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'></font></span></b>
									<input type="text" onkeypress="return validateQty(event);" class="form-control integer" id="opc" name="opc" required>
								</div> -->
								<div class="form-group">
									<!-- <br> -->
									<input type="submit" name="submit" id="submit" class="btn btn-success" value="Save">
								</div>		
							<!-- </div> -->
						</form>
					</div>	
				</div>
			</div>	
</div>
<?php


	$query_select = "select * from $brandix_bts.tbl_ims_ops";
	$res_do_num=mysqli_query($link,$query_select);
	echo "<div class='container'><div class='panel panel-primary'><div class='panel-heading'>Operations List</div><div class='panel-body'>";
	echo "<div class='table-responsive'><table class='table table-bordered' id='table_one'>";
	echo "<thead><tr><th style='text-align:  center;'>S.No</th><th style='text-align:  center;'>Application Name</th><th style='text-align:  center;'>Operation Name</th><th style='text-align:  center;'>Operation Code</th><th style='text-align:  center;'>Controllers</th></tr></thead><tbody>";
	$i=1;
	while($res_result = mysqli_fetch_array($res_do_num))
	{
		//var_dump($res_result);
		//checking the operation scanned or not
		// $ops_code = $res_result['operation_code'];
		// $query_check = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where operation_code = $ops_code";
		// $res_query_check=mysqli_query($link,$query_check);
		// while($result = mysqli_fetch_array($res_query_check))
		// {
		// 	$count = $result['cnt'];
		// }
		
		echo "<tr>
			<td>".$i++."</td>
			<td>".$res_result['appilication']."</td>
			<td>".$res_result['operation_name']."</td>
			<td>".$res_result['operation_code']."</td>";

				$eurl = getFullURLLevel($_GET['r'],'edit_delete.php',0,'N');
				$url_delete = getFullURLLevel($_GET['r'],'master.php',0,'N').'&del_id='.$res_result['id'];
				if(in_array($edit,$has_permission)){ echo "<td><a href='$eurl&id=".$res_result['appilication']."' class='btn btn-info'>Edit</a></td>"; } 
				// if(in_array($delete,$has_permission)){ 
				// 	echo "<td><a href='$url_delete' class='btn btn-danger confirm-submit' id='del' >Delete</a></td>";
				// }
			
		echo "</tr>";
	}
	echo "</tbody></table></div></div></div></div>";
?>
</body>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#opn').on('click',function(e){
		var apn = $('#apn').val();
		if(apn == ''){
			sweetAlert('Please Select Application','','warning');
		}
	});
	$('#apn').on('change',function(e){
		var apn = $('#apn').val();
		if(apn == 'IPS'){
			$('.hide_auto').show();
		}else {
			$('.hide_auto').hide();
			$('#opn').val('');
		}
	});
});

</script>


