<!--- Developed by Srinivas Y --->
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS 
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>-->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'js/datetimepicker_css.js',0,'R'); ?>"></script>
<!--<link rel="stylesheet" href="cssjs/bootstrap.min.css">-->
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'cssjs/select2.min.css',0,'R'); ?>">
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'cssjs/font-awesome.min.css',0,'R'); ?>">
<!--<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
include("..".getFullURLLevel($_GET['r'],'/common/config/config.php',5,'R'));

$qry_get_product_style = "SELECT id,style FROM $brandix_bts.bundle_creation_data GROUP BY style";
$qery_rejection_resons = "select * from bai_pro3.bai_qms_rejection_reason";
$result_rejections = $link->query($qery_rejection_resons); 
$result = $link->query($qry_get_product_style);
$style= $_POST['style_rej'];
$scheule = $_POST['schedule_rej']?$_POST['schedule_rej']: '0';
$color= $_POST['color_rej']?$_POST['color_rej']: '0';
$cut= $_POST['cut_rej']?$_POST['cut_rej']: '0';
$ops = $_POST['ops_rej']?$_POST['ops_rej']: '0';
$rej_id= $_POST['changed_id']?$_POST['changed_id']: '1000';

$rej_val = $_POST['changed_rej']?$_POST['changed_rej']: '0';

$rec_val = $_POST['changed_rec']?$_POST['changed_rec']: '0';

?>
<form method ='POST' action='<?php $_SERVER["PHP_SELF"]?>'>
<div class='container'>
	<div class="panel panel-primary">
				<div class="panel-heading">Garment receiving</div>
				<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-2">
								<label for="style">Select Style<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>		      
								<select class="form-control" id="style" name="style">
									<option value=''>Select Style No</option>
									<?php				    	
										if ($result->num_rows > 0) {
											while($row = $result->fetch_assoc()) {
												if($style == $row['style'])
												{
													echo "<option value='".$row['style']."' selected>".$row['style']."</option>";
												}
												else
												{
													echo "<option value='".$row['style']."'>".$row['style']."</option>";
												}
											}
										} else {
											echo "<option value=''>No Data Found..</option>";
										}
									?>
								</select>
							</div>
							<div class ='col-md-2'>
								<label for="title">Select Schedule:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="schedule" class="form-control" id='schedule' style="style">
								<option value=''>Select Schedule</option>
								</select>
							</div>
							<div class ='col-md-2'>
								<label for="title">Select Color:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="color" class="form-control" id='color' style="style">
								<option value=''>Select Color</option>
								</select>
							</div>
							<div class ='col-md-2'>
								<label for="title">Select Cut:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="cut_no" class="form-control" id='cut_no' style="cut_no">
								<option value=''>Select Cut No.</option>
								</select>
							</div>
							<div class='col-md-2'>
								<label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="operation" class="form-control" id='operation' style="style" required>
								<option value=''>Select Operation</option>
								</select>
							</div>
							
						</div>
				</div>
						<hr>
	</div>
	<div class="panel panel-primary">
					<div class="panel-heading">Garment Receiving Details</div>
					<div class="panel-body">
						<div class='row'>
		<div class='col-md-2' hidden='true'>
			<label for="title">Search Size:</label>
			<select name="sizes" class="form-control" id='sizes' style="style" onchange='searchfunction()'>
				<option value=''>Select Size</option>
			</select>
		</div>
		<div class = 'col-md-2'>

		</div>
		<div class = 'col-md-2'>

		</div>
		<div class = 'col-md-2'>
		</div>
		<div class="form-group col-md-2">
                        	<label>Shift:<span style="color:red">*</span></label>
                        	<select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                        		<option value="">Select Shift</option>
                        		<option value="A">A</option>
                        		<option value="B">B</option>
                        	</select>
        </div>
		<div class='col-md-2' hidden='true' id='operations_div_save'>
							<br>
									<input type='SUBMIT' value='SAVE' name='SUBMIT' class='btn btn-primary' style="margin-top: 4px;">
		</div>

	</div><br>
						<div id ="dynamic_table1">
							</div>
					</div>
	</div>
</div>
<input type='text' id='parent_id' name='parent_id' hidden='true'>
<input type='text' id='style_rej' name='style_rej' hidden='true'>
<input type='text' id='schedule_rej' name='schedule_rej' hidden='true'>
<input type='text' id='color_rej'  name='color_rej' hidden='true'>
<input type='text' id='cut_rej' name='cut_rej' hidden='true'>
<input type='text' id='size_rej' name='size_rej' hidden='true'>
<input type='text' id='ops_rej' name='ops_rej' hidden='true'>
<input type='text' id='shift_rej' name='shift_rej' hidden='true'>
<input type='text' id='changed_rej' name='changed_rej' hidden='true'>
<input type='text' id='changed_id' name='changed_id' hidden='true'>
<input type='text' id='changed_rec' name='changed_rec' hidden='true'>
<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				  <!-- Modal content-->
				    <div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
						<div class="form-group" id="rej">
                        	<div class="panel panel-info"> 
				            	<div class="panel-heading"><strong>Rejection Reasons</strong></div>				            	
				                <div class="panel-body">
						           	<div class="form-group col-md-4" id="res">
			                            <label>No of Reasons:</label>
					                	<input type="number" name="no_reason" min=0 id="reason" class="form-control" placeholder="Enter no of reasons"/>
					                </div>
		                            <table class="table table-bordered" id='reson_dynamic_table' width="100" style="height: 50px; overflow-y: scroll;">
		                            	<thead>
		                            		<tr>
		                            			<th style="width: 7%;">S.No</th>	                            			
		                            			<th>Reason</th>
		                            			<th style="width: 20%;">Quantity</th>
		                            		</tr>
		                            	</thead>
		                            	<tbody id="tablebody">
											<tr id='repeat_tr' hidden='true'>
												<td>
												<select class="form-control" id="style" name="reason[]">
													<option value=''>Select Reason</option>
													<?php				    	
														if ($result_rejections->num_rows > 0) {
															while($row = $result_rejections->fetch_assoc()) {
																echo "<option value='".$row['sno']."'>".$row['reason_desc']."</option>";
															}
														} else {
															echo "<option value=''>No Data Found..</option>";
														}
													?>
												</select>
												</td>
												<td><input class='form-control input-sm qty' name='quantity[]' onchange='validating_cumulative()'></td>
											</tr>
										</tbody>
		                            </table>
		                        </div>
								 <div class="panel-footer" hidden='true' id='footer'>
									<input type = 'SUBMIT' class='btn btn-primary' value='Save' name='Save'>
								 </div>
                            </div>
                        </div>
						</div>
						<div class="modal-body">
						</div>
					</div>
			</div>
		</div>
</form>
<div class="ajax-loader" id="loading-image" style="margin-left: 688px;margin-top: 35px;border-radius: -80px;width: 150px;">
		<img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
</div>
<?php
if(isset($_POST['Save']))
{
$username_qry = strtoupper($_SERVER['PHP_AUTH_USER']);
$parent_id= $_POST['parent_id'];
$rej_val = $_POST['changed_rej'];
$no_of_rsn= $_POST['no_reason'];
$reson_desc = $_POST['reason'];
$qty = $_POST['quantity'];
$style= $_POST['style_rej'];
$scheule = $_POST['schedule_rej'];
$color= $_POST['color_rej'];
$cut= $_POST['cut_rej'];
$ops = $_POST['ops_rej'];
$size= $_POST['size_rej'];
$shift = $_POST['shift_rej'];
$rec_val = $_POST['changed_rec'];
	$servername = $host_adr;
$username = $host_adr_un;
$password = $host_adr_pw;
$dbname = $database;
	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($link->connect_error) {
		die("Connection failed: " . $link->connect_error);
	}else{
		//echo "Connection Success";
	}
$ref1 = '';
$tot_qty = 0;
$parent_selecing = "select * from tbl_garmet_ops_track where id=$parent_id";
$result_parent_selecing= $link->query($parent_selecing);
if ($result_parent_selecing->num_rows > 0) 
{
	while($row_result_parent_selecing = $result_parent_selecing->fetch_assoc())
	{
		$rejected_pre_qty = $row_result_parent_selecing['rejected_qty'];
		$rec_pre_qty = $row_result_parent_selecing['received_qty'];
	}
}
$actual_rej = $rejected_pre_qty + $rej_val;
$actual_rec = $rec_pre_qty + $rec_val;
$updating_parent = "update tbl_garmet_ops_track set rejected_qty=$actual_rej,received_qty=$actual_rec,rej_status=1 where id=$parent_id";
$link->query($updating_parent);
$checking_main_query = "SELECT id FROM tbl_garmet_ops_track WHERE style='$style' AND SCHEDULE = '$scheule' AND color= $color AND cut_number = $cut AND size_title='$size' AND operation_id=$ops";
$result_checking_main_query= $link->query($checking_main_query);
if ($result_checking_main_query->num_rows > 0) 
{
	while($row_result_checking_main_query = $result_checking_main_query->fetch_assoc())
	{
		$last_id = $row_result_checking_main_query['id'];
		$updating_query = "update tbl_garmet_ops_track set received_qty = $actual_rec,rejected_qty=$actual_rej where id=$last_id";
		$link->query($updating_query);
		
	}
	
}
else
{
	$inserting_parent = "insert into tbl_garmet_ops_track (style,schedule,color,cut_number,received_qty,rejected_qty,sew_out_qty,sendig_qty,operation_id,size_title,shift,rej_status) values ('$style','$scheule',$color,'$cut',$rec_val,$rej_val,'$rec_val',0,$ops,'$size','$shift',0)";
	$link->query($inserting_parent);
	$last_id = mysqli_insert_id($conn);
}
foreach ($reson_desc as $key => $value)
{
	if($key != 0)
	{
		$checking_qry = "select count(*)as cnt from tbl_garment_ops_rej_track where style='$style' and schedule = '$scheule' and color= $color and cut_no = $cut and size='$size'";
		$result1 = $link->query($checking_qry);
		if ($result1->num_rows > 0) 
		{
			while($row1 = $result1->fetch_assoc())
			{
				$count = $row1['cnt'];
			}
		}
		if($count >= 0)
		{
			$inserting_query = "insert into tbl_garment_ops_rej_track (parent_id,no_of_reasons,reason_id,style,schedule,color,cut_no,size,operation_id,quantity,shift) values ($last_id,$no_of_rsn,$reson_desc[$key],'$style','$scheule',$color,'$size',$cut,$ops,$qty[$key],'$shift')";
			$executed = $link->query($inserting_query);
		}
		$tot_qty += $qty[$key];
		$ref1 .= $reson_desc[$key]."-".$qty[$key]."$";
		$sfcs_reason = "select rej_reason_code from bai_pro3.bai_qms_rejection_reason where sno=$reson_desc[$key]";
		//echo $sfcs_reason;
		$result_sfcs_reason = $link->query($sfcs_reason);
		while($row_result_result_sfcs_reason= $result_sfcs_reason->fetch_assoc())
		{
			$reason_code = $row_result_result_sfcs_reason['rej_reason_code'];
		}
		$ops_desc_qry = "select * from tbl_orders_ops_ref where operation_code=$ops";
		$result_ops_desc_qry = $link->query($ops_desc_qry);
		while($row_ops= $result_ops_desc_qry->fetch_assoc())
		{
			$ops_desc = $row_ops['operation_name'];
			$is_m3 = $row_ops['default_operation'];
		}
		$query_bundle_cre_data = "select * from $brandix_bts.bundle_creation_data where style ='$style' and schedule ='$scheule' and color=$color and cut_number=$cut and size_title='$size'";
		$result_query_bundle_cre_data = $link->query($query_bundle_cre_data);
		if ($result_query_bundle_cre_data->num_rows > 0) 
		{
			while($row_result_query_bundle_cre_data = $result_query_bundle_cre_data->fetch_assoc())
			{
				$docket_number = $row_result_query_bundle_cre_data['docket_number'];
				$main_id = $row_result_query_bundle_cre_data['id'];
			}
		}
		$remarks = "0-".$shift."-G";
		if($is_m3 == 'Yes')
		{
			$insert_m3_bulk_ops = "insert into m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) values (NOW(),'$style','$scheule',$color,'$size','$size','$docket_number',$qty[$key],'$reason_code','$remarks','$username_qry',$ops,'','','$shift','$ops_desc','$main_id','srinivas')";
			$link->query($insert_m3_bulk_ops);
		}
	}
	
}
	$insertrejctions = "INSERT INTO bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_user,log_date,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,cut_no,panel_nos,no_of_reasons,bundle_number) VALUES('$style','$scheule',$color,'$username_qry',NOW(),'$size',$tot_qty,'3','$remarks','$ref1','$docket_number','$cut','',$no_of_rsn,'$main_id')";
	$link->query($insertrejctions);
}

if(isset($_POST['SUBMIT']))
{
	$servername = $host_adr;
$username = $host_adr_un;
$password = $host_adr_pw;
$dbname = $database;
$username_qry = strtoupper($_SERVER['PHP_AUTH_USER']);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($link->connect_error) { 
	die("Connection failed: " . $link->connect_error);
}else{
	//echo "Connection Success";
}
	$style = $_POST['style'];
	$schedule = $_POST['schedule'];
	$color = $_POST['color'];
	$cut_no = $_POST['cut_no'];
	$size = $_POST['size'];
	$qty = $_POST['qty'];
	$sending_qty = $_POST['oper_seq2'];
	$operation = $_POST['operation'];
	$updatable_id = $_POST['update_id'];
	$rec_qty = $_POST['rec_qty'];
	$rej_qty = $_POST['rej_qty'];
	$length = sizeof($size);
	$pre_rec_qty  = $_POST['pre_rec_qty'];
	$shift = $_POST['shift'];
	foreach ($updatable_id as $key => $value)
	{
			$parent_selecing = "select * from tbl_garmet_ops_track where id=$updatable_id[$key]";
			$result_parent_selecing= $link->query($parent_selecing);
			if ($result_parent_selecing->num_rows > 0) 
			{
				while($row_result_parent_selecing = $result_parent_selecing->fetch_assoc())
				{
					$rejected_pre_qty = $row_result_parent_selecing['rejected_qty'];
					$rec_pre_qty = $row_result_parent_selecing['received_qty'];
					$rej_status = $row_result_parent_selecing['rej_status'];
				}
			}
			$updated_value = $rec_pre_qty + $rec_qty [$key];
			$update_rej_value = $rejected_pre_qty + $rej_qty[$key];
			$update_query = "update tbl_garmet_ops_track set received_qty = $updated_value , rejected_qty = $update_rej_value where id=$updatable_id[$key]";
			if($rej_status == 0)
			{
				$link->query($update_query);
			}
			$update_query_true = "update tbl_garmet_ops_track set rej_status=0 where id=$updatable_id[$key]";
			$link->query($update_query_true);
			$query_check = "select id,count(*) as cnt from tbl_garmet_ops_track where style ='$style' and schedule ='$schedule' and color ='$color' and cut_number =$cut_no and operation_id=$operation and size_title='$size[$key]'";
			$result1 = $link->query($query_check);
			while($row1 = $result1->fetch_assoc())
			{
				$updatable_id_row = $row1['id'];
				$count = $row1['cnt'];
			}
			if($count <= 0)
			{
				$execution_query = "insert into tbl_garmet_ops_track (style,schedule,color,cut_number,received_qty,rejected_qty,sew_out_qty,sendig_qty,operation_id,size_title,shift) values ('$style','$schedule','$color','$cut_no',$rec_qty[$key],0,'$rec_qty[$key]',0,$operation,'$size[$key]','$shift')";
			}
			else
			{
				$update_value = $updated_value;
				$execution_query = "update tbl_garmet_ops_track set received_qty =$update_value where id = $updatable_id_row";
			}
			//echo $execution_query;
			$data_insert = $link->query($execution_query);
			$edit_next_send_sew_qty = "SELECT ts.id,ts.operation_code,tr.operation_name,ops_dependency FROM tbl_style_ops_master ts LEFT JOIN tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$style' AND color = '$color' AND ts.operation_code > $operation	AND tr.type='Garment' AND ts.operation_code != 200 AND ops_dependency = '' GROUP BY operation_name ORDER BY ts.id DESC LIMIT 0,1";
			$result_edit_next_send_sew_qty = $link->query($edit_next_send_sew_qty);
			while($row1_result_edit_next_send_sew_qty = $result_edit_next_send_sew_qty->fetch_assoc())
			{
				$next_operation_code = $row1_result_edit_next_send_sew_qty['operation_code'];
			}
			$checking_qry_ops_code = "select id,sew_out_qty from tbl_garmet_ops_track where style ='$style' and schedule ='$schedule' and color ='$color' and cut_number =$cut_no and operation_id=$next_operation_code and size_title='$size[$key]'";
			//echo $checking_qry_ops_code;
			$result_checking_qry_ops_code = $link->query($checking_qry_ops_code);
			if($result_checking_qry_ops_code->num_rows > 0)
			{	
				while($row1_result_checking_qry_ops_code = $result_checking_qry_ops_code->fetch_assoc())
				{
					$next_operation_id = $row1_result_checking_qry_ops_code['id'];
					echo $next_operation_id;
					$pre_sew_out_qty = $row1_result_checking_qry_ops_code['sew_out_qty'];
				}
				// echo "pre_sew_qty".$pre_sew_out_qty;
				// echo "<br>";
				// echo "present_rec_qty".$rec_qty[$key];
				
					$act_sew_out_qty = $pre_sew_out_qty + $rec_qty[$key];
					$update_sew_out_qty = "update tbl_garmet_ops_track set sew_out_qty = $act_sew_out_qty where id=$next_operation_id";
					//echo $update_sew_out_qty;
					$link->query($update_sew_out_qty);	
			}
			if($rec_qty[$key] != 0)
			{
				$ops_desc_qry = "select * from tbl_orders_ops_ref where operation_code=$operation";
				$result_ops_desc_qry = $link->query($ops_desc_qry);
				while($row_ops= $result_ops_desc_qry->fetch_assoc())
				{
					$ops_desc = $row_ops['operation_name'];
					$is_m3 = $row_ops['default_operation'];
				}
				$query_bundle_cre_data = "select * from $brandix_bts.bundle_creation_data where style ='$style' and schedule ='$schedule' and color='$color' and cut_number=$cut_no and size_title='$size[$key]'";
				//echo $query_bundle_cre_data;
				$result_query_bundle_cre_data = $link->query($query_bundle_cre_data);
				if ($result_query_bundle_cre_data->num_rows > 0) 
				{
					while($row_result_query_bundle_cre_data = $result_query_bundle_cre_data->fetch_assoc())
					{
						$docket_number = $row_result_query_bundle_cre_data['docket_number'];
						$main_id = $row_result_query_bundle_cre_data['id'];
					}
				}
				$remarks = "0-".$shift."-G";
				if($is_m3 == 'Yes')
				{
					$insert_m3_bulk_ops = "insert into m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) values (NOW(),'$style','$schedule','$color','$size[$key]','$size[$key]','$docket_number',$rec_qty[$key],'','$remarks','$username_qry',$operation,'','','$shift','$ops_desc','$main_id','srinivas')";
					$link->query($insert_m3_bulk_ops);
				}
				
			}

	}
	if($data_insert){
		header("Location:received_quantity_update.php?Message=true");
	}else {
		header("Location:received_quantity_update.php?Message=false");
	}
}


?>
<?php
	if (isset($_GET['Message'])) {
		// echo $_GET['Message'];
		if($_GET['Message'] == 'true'){
			// echo "<p>Data Saved Successfully.....</p>";
			echo '<div class="alert alert-success">
			  <strong>Success!</strong> Data Saved Successfully.....
			</div>';
		}elseif($_GET['Message'] == 'false') {
			// echo "Error! Data Not Saved, Contact IT Team..";
			echo '<div class="alert alert-danger">
			  <strong>Error!</strong> Data Not Saved, Contact IT Team..
			</div>';
		}
	}
?>
<script type="text/javascript">
$(document).ready(function(){
$('#operations_div_save').hide();
$('#loading-image').hide();
my_function = null;
 getschedule();
	function getschedule()
	{
		$('#operations_div_save').hide();
		$("#dynamic_table1").html(" ");
		$('#schedule').empty();
		$('select[name="schedule"]').append('<option value="Select Schedule">Select Schedule</option>');
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select operation">Select operation</option>');
		var style = $('#style option:selected').text();
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions_send.php',0,'R'); ?>?r=getdata&style="+style,
					dataType: 'Json',
					data: {style: $('#style').val()},
					success: function(response)
					{
						// console.log(response);
						$('#loading-image').hide();
						var schedule_php = <?php echo $scheule?>;	
						$.each(response, function(key, value) {
							if(schedule_php == key)
							{
								$('select[name="schedule"]').append('<option value="'+ key +'" selected>'+ value +'</option>');
								
							}
							else
							{
								$('select[name="schedule"]').append('<option value="'+ key +'">'+ value +'</option>');
								
							}
							getcolor();
							
						});
					}
			});
	}
	$("#style").change(function()
	{
		$('#loading-image').show();
		getschedule();
	});
	function getcolor()
	{
		$('#operations_div_save').hide();
		$("#dynamic_table1").html(" ");
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select operation">Select operation</option>');
		var schedule = $('#schedule option:selected').text();
		//alert(schedule);
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions_send.php',0,'R'); ?>?r=getdata&schedule="+schedule,
					dataType: 'Json',
					data: {schedule: $('#schedule').val()},
					success: function(response)
					{
						//alert(response);
						$('#loading-image').hide();
						var color_php = <?php echo $color?>;
						$.each(response, function(key, value) {
							if(color_php == key)
							{
								$('select[name="color"]').append('<option value="'+ key +'" selected>'+ value +'</option>');
							}
							else
							{
								$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
							}
							getcut();
						
						});
					}
			});
	}
	$("#schedule").change(function()
	{
		$('#loading-image').show();
		getcolor();
	});
	function getcut()
	{
		$('#operations_div_save').hide();
		$("#dynamic_table1").html(" ");
		$('#cut_no').empty();
		$('select[name="cut_no"]').append('<option value="Select Color">Select Cut No.</option>');
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select operation">Select operation</option>');
		var color = $('#color option:selected').text();
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions_send.php',0,'R'); ?>?r=getdata&colors="+color,
					dataType: 'Json',
					data: {schedule: $('#color').val()},
					success: function(response)
					{
						//alert(response);
						$('#loading-image').hide();
						var cut_php = <?php echo $cut?>;
						$.each(response, function(key, value) {
							if(cut_php == key)
							{
								$('select[name="cut_no"]').append('<option value="'+ key +'" selected>'+ value +'</option>');
							}
							else
							{
								$('select[name="cut_no"]').append('<option value="'+ key +'">'+ value +'</option>');
							}
						});
					getops();
					}
			});
	}
	$("#color").change(function()
	{
		$('#loading-image').show();
		getcut();
	});
	function getops()
	{
		$('#operations_div_save').hide();
		$("#dynamic_table1").html(" ");
		$('#operation').empty();
		$('select[name="operation"]').append('<option value="Select operation">Select operation</option>');
		$('#sizes').empty();
		$('select[name="sizes"]').append('<option value="Select operation">Select Size</option>');
		var color = $('#color option:selected').text();
		var style = $('#style option:selected').text();
		var schedule = $('#schedule option:selected').text();
		var cut_no = $('#cut_no option:selected').text();
		color = "'"+color+"'";
		var params = [style,schedule,color,cut_no];
		//alert(schedule);
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions_send.php',0,'R'); ?>?r=getdata&params1="+params,
					dataType: 'Json',
					data: {params: $('#params').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						var ops_php = <?php echo $ops?>;
						$.each(response, function(key, value) {
							if(ops_php == key)
							{
								$('select[name="operation"]').append('<option value="'+ key +'" selected>'+ value +'</option>');
							}
							else
							{
								$('select[name="operation"]').append('<option value="'+ key +'">'+ value +'</option>');
							}
						});
						get_full_data();
						//$('#loading-image').show();
					}
			});
	}
	$("#cut_no").change(function()
	{
		$('#loading-image').show();
		getops();
	});
	function get_full_data()
	{
		$('#operations_div_save').hide();
		//$('#loading-image').show();
		$("#dynamic_table1").html(" ");
		var color = $('#color option:selected').text();
		var style = $('#style option:selected').text();
		var schedule = $('#schedule option:selected').text();
		var cut_no = $('#cut_no option:selected').text();
		color = "'"+color+"'";
		var operation = $('#operation').val();
		var act_params = [style,schedule,color,cut_no,operation];
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions_send.php',0,'R'); ?>?r=getdata&act_params="+act_params,
					dataType: 'Json',
					data: {act_params: $('#act_params').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						var data = response.table_data;
						var sizes_data = response.sizes_data;
						$.each(sizes_data, function(key, value) {
							$('select[name="sizes"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
						if(data != null)
						{
							var markup = "<table class = 'table table-striped' id='dynamic_table'><tbody><thead><tr><th>Sizes</th><th class='none'>Sewing Out Quantity</th><th>Sent Quantity</th><th>Previously Received Quantity</th><th>To be Received</th><th style='text-align:center;'>Receiving</th><th>Previous rejected qty</th><th>Rejected Quantity</th></tr></thead><tbody>";
							$("#dynamic_table1").append(markup);
							for(var i=0;i<data.length;i++)
							{
								var value_act = data[i]['rejected_qty'];
								var act_rec = data[i]['to_be_rec'];
								var act = <?php echo $rec_val; ?>;
								if(act != 0)
								{
									var act_now = act;
								}
								else
								{
									var act_now = 0;
								}
								console.log("value_act"+value_act);
								//console.log(data[i]['received_qty'] + data[i]['rejected_qty']);
								if(Number(data[i]['received_qty']) + Number(data[i]['rejected_qty']) == Number(data[i]['sendig_qty']))
								{
									var readonly = "readonly";
								}
								else
								{
									var readonly="";
								}
								var markup1 = "<tr><td class='none'><input type='hidden' name='update_id["+i+"]' id='update_id["+i+"]' value='"+data[i]['updatable_id']+"'></td><td class='none'><input type='hidden' name='size["+i+"]' id='size["+i+"]' value='"+data[i]['size_title']+"'></td><td id='"+i+"size'>"+data[i]['size_title']+"</td><td class='none'><input type='hidden' name='qty["+i+"]' id='"+i+"sew_qty' value='"+data[i]['sew_out_qty']+"'></td><td class='none'>"+data[i]['sew_out_qty']+"</td><td class='none'><input type='hidden' name='send_qty["+i+"]' id='send_qty["+i+"]' value='"+data[i]['sendig_qty']+"'></td><td>"+data[i]['sendig_qty']+"</td><td class='none'><input type='hidden' name='pre_rec_qty["+i+"]' id='pre_rec_qty' value='"+data[i]['received_qty']+"'></td><td>"+data[i]['received_qty']+"</td><td>"+act_rec+"</td><td><center><input class='form-control input-md' id='"+i+"rec_qty' name = 'rec_qty["+i+"]' type='Number' value = '"+act_now+"' style='width: 32%;' onchange='myfunction("+act_rec+","+i+")' "+readonly+"></center></td><td class='none'><input type='hidden' id='"+i+"pre_rejections' name='pre_rej["+i+"]' value='"+value_act+"'></td><td>"+value_act+"</td><td><center><input class='form-control input-md' id='"+i+"rejections' name = 'rej_qty["+i+"]' type='Number' value = '0' style='width: 32%;' onchange = 'rejections_capture("+i+","+data[i]['updatable_id']+","+act_rec+")' "+readonly+"></center></td></tr>";
								$("#dynamic_table").append(markup1);
								$('#operations_div_save').show();
							}
							
						}
						else
						{
							var markupus = "<h1 style='color:red;'>Sorry!!! No data Found<h1>";
							$("#dynamic_table1").append(markupus);
						}
					}
					
			});
			//document.getElementById('0rejections').value = '2';
	}
	$('#operation').change(function()
	{
			get_full_data();
	});
$(function() { 

        function my_fun()
		{ 
               $('#myModal').modal('show');
        }  
        my_function = my_fun;
 })

$("#reason").change(function(){
		var color = $('#color option:selected').text();
		var style = $('#style option:selected').text();
		var schedule = $('#schedule option:selected').text();
		var cut_no = $('#cut_no option:selected').text();
		color = "'"+color+"'";
		var operation = $('#operation').val();
		var res = $("#reason").val();
		var shift = $('#shift').val();
		$('#style_rej').val(style);
		$('#schedule_rej').val(schedule);
		$('#color_rej').val(color);
		$('#cut_rej').val(cut_no);
		$('#ops_rej').val(operation);
		for(var i=1;i<=res;i++)
		{
			html_markup = "<tr><td>"+i+"</td>"+$('#repeat_tr').html()+"</tr>";
			console.log(html_markup);
			$("#tablebody").append(html_markup);
		}
	}); 
// getcolor();
// $.when(getschedule()).done(function()
// {
	// getcolor();
// });
});


</script>

<style>	
.table
{
	text-align:center;
}
.none
{
	display:none;
}
</style>
<script>
function myfunction(btn,id)
	{
		var val = id;
		//alert("working");
		seq = id+"rec_qty";
		// var pre_rej = val+"pre_rejections";
		// var rej = val+"rejections";
		// var present_value = document.getElementById(seq).value; 
		// if(Number(btn) < Number(present_value))
		// {
			// alert("You cant send more than Sewing Out Quantity");
			// document.getElementById(seq).value = btn;
		// }
		var rej = val+"rejections";
		var size = val+"size";
		var rec = val+"rec_qty";
		var to_can_rec = val+"sew_qty";
		var pre_rej = val+"pre_rejections";
		var changed_rec_elem = val+"rec_qty";
		var changed_rec_val = document.getElementById(changed_rec_elem).value;
		var to_can_rec_val = document.getElementById(to_can_rec).value;
		var tot_rec = document.getElementById(rec).value;
		var tot_rejections = document.getElementById(rej).value;
		var pre_rejections = document.getElementById(pre_rej).value;
		//alert(btn);
		if((Number(tot_rejections)+Number(tot_rec)) > Number(btn))
		{
			alert("You are exceeding Max received quantity");
			document.getElementById(rej).value=0;
			document.getElementById(seq).value=0;
		
		}
		
	}
function searchfunction()
{
	var input, filter, table, tr, td, i;
	input = document.getElementById("sizes");
	filter = input.value.toUpperCase();
	//alert(filter);
	table = document.getElementById("dynamic_table1");
	tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function rejections_capture(val,update_id,btn)
{
	var rej = val+"rejections";
	if(document.getElementById('shift').value != '')
	{
		var size = val+"size";
		var rec = val+"rec_qty";
		var to_can_rec = val+"sew_qty";
		var pre_rej = val+"pre_rejections";
		var changed_rec_elem = val+"rec_qty";
		var changed_rec_val = document.getElementById(changed_rec_elem).value;
		var to_can_rec_val = document.getElementById(to_can_rec).value;
		var tot_rec = document.getElementById(rec).value;
		var tot_rejections = document.getElementById(rej).value;
		var pre_rejections = document.getElementById(pre_rej).value;
		//alert(btn);
		if((Number(tot_rejections)+Number(tot_rec)) > Number(btn))
		{
			alert("You are exceeding Max received quantity");
			document.getElementById(rej).value=0;
		}
		else
		{
			size = document.getElementById(size).innerText;
			document.getElementById('size_rej').value=size;
			if(val == 0)
			{	
				document.getElementById('changed_id').value='2000';
			}
			else
			{
				document.getElementById('changed_id').value=val;
			}
			document.getElementById('changed_rej').value=tot_rejections;
			document.getElementById('shift_rej').value = document.getElementById('shift').value;
			document.getElementById('changed_rec').value = changed_rec_val;
			document.getElementById('parent_id').value = update_id;
			my_function();
		}
	}
	else
	{
		alert("plsease Select Shift");	
		document.getElementById(rej).value=0;
	}
}
	
function validating_cumulative()
{
	//console.log($('.qty').val());
	var result = 0;
	$('input[name="quantity[]"]').each(function(){
		//alert($(this).val());
		result += Number($(this).val());
	});
	var  tot = $('#changed_rej').val();
	if(Number(tot) == Number(result))
	{
		$('#footer').show();
	}
	else
	{
		$('#footer').hide();
	}
}
</script>
		
		
		