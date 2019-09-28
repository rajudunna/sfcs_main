<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3Updations.php',5,'R')); 
	$shift = $_POST['shift'];
	$op_code=$_POST['operation_code'];
	$gate_id=$_POST['gate_id'];	
	if($gate_id=='')
	{
		$gate_id=0;
	}
	//echo $gate_id."--".$op_code."--".$shift."<br>";
    $has_permission=haspermission($_GET['r']);
    if (in_array($override_sewing_limitation,$has_permission))
    {
        $value = 'authorized';
    } 
    else
    {
        $value = 'not_authorized';
    }
?>

<form  method="POST">
	<div class="panel panel-primary">
		<div class="panel-heading">Emblishment Reversal</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-group col-md-3">
						<label>Barcode Number:</label>
						<input type="text"  id="barcode" name="barcode" class="form-control" required placeholder="Scan the Barcode..."/>
					</div>
					<div class="form-group col-md-3">
						<input type="submit" name="reverse" id="reverse" class="btn btn-primary" value="Reverse" style="margin-top: 23px;">
					</div>
				</div>
			</div>
	</div>
</form>
<?php
if(isset($_POST['reverse']))
{
	$barcode=$_POST['barcode'];
	$docno=explode('-', $barcode)[0];
	$op_no=explode('-', $barcode)[1];
	$seqno=explode('-', $barcode)[2];

	$normdoc[]=explode('-', $barcode)[0];
	
	
	function updatedata($updatedoc,$updatequant,$sizes,$op_no,$seqno,$barcode,$clubstatus)
	{
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
		
		//getting bundle number from bundle_creation_data
		$selct_qry = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data  WHERE docket_number =$updatedoc AND operation_id='$op_no' AND size_title='$sizes'";
		$selct_qry_res=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($selct_qry_res->num_rows > 0)
		{
	   
			while($selct_qry_result_rows=mysqli_fetch_array($selct_qry_res))
			{
				$bundle_no = $selct_qry_result_rows['bundle_number'];
			}
		}
		
		$selecting_style_schedule_color_qry = "select style,schedule,color,bundle_number from $brandix_bts.bundle_creation_data WHERE docket_number =$updatedoc and operation_id=$op_no and size_title='$sizes' order by bundle_number";
		$result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
		if($result_selecting_style_schedule_color_qry->num_rows > 0)
		{
			while($row = $result_selecting_style_schedule_color_qry->fetch_assoc())
			{
				$style= $row['style'];
				$schedule= $row['schedule'];
				$color= $row['color'];
				$b_tid[]=$row['bundle_number'];
			}
		}
		$maped_color = $color;
		
		$ops_sequence_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' and operation_code=$op_no";
		$result_ops_sequence_check = $link->query($ops_sequence_check);
		while($row2 = $result_ops_sequence_check->fetch_assoc())
		{
			$ops_seq = $row2['ops_sequence'];
			$seq_id = $row2['id'];
			$ops_order = $row2['operation_order'];

		}
		
		$pre_operation_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
		//echo $pre_operation_check;
		$result_pre_operation_check = $link->query($pre_operation_check);
		if($result_pre_operation_check->num_rows > 0)
		{
			while($row23 = $result_pre_operation_check->fetch_assoc())
			{
				$pre_ops_code = $row23['operation_code'];
			}
		}
		
		$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' AND operation_code = '$pre_ops_code'";
		//echo $dep_ops_check;
		$result_dep_ops_check = $link->query($dep_ops_check);
		if($result_dep_ops_check->num_rows > 0)
		{
			while($row22 = $result_dep_ops_check->fetch_assoc())
			{
				$next_operation = $row22['ops_dependency'];
			}
		}
		else
		{
			$next_operation = '';
		}
		
		if($ops_dep)
		{
			$dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$mapped_color' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
			$result_dep_ops_array_qry_seq = $link->query($dep_ops_array_qry_seq);
			while($row = $result_dep_ops_array_qry_seq->fetch_assoc())
			{
				$ops_dep_ary[] = $row['ops_dependency'];
			}
		}
		else
		{
			$ops_dep_ary[] = null;
		}
		
		if($ops_dep_ary[0] != null)
		{
			$ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$mapped_color' AND operation_code in (".implode(',',$ops_dep_ary).")";
			$result_ops_seq_qrs = $link->query($ops_seq_qrs);
			while($row = $result_ops_seq_qrs->fetch_assoc())
			{
				$ops_seq_dep[] = $row['ops_sequence'];
			}
		}
		else
		{
			$ops_seq_dep[] = $ops_seq;
		}
		
		
		$pre_ops_check = "SELECT tm.operation_code as operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN brandix_bts.`tbl_orders_ops_ref` tr ON tr.id=tm.operation_name WHERE style='$style' AND color = '$mapped_color' and (ops_sequence = '$ops_seq' or ops_sequence in  (".implode(',',$ops_seq_dep).")) AND  tr.category  IN ('sewing') AND tm.operation_code != 200";
		//echo $pre_ops_check;
		$result_pre_ops_check = $link->query($pre_ops_check);
		if($result_pre_ops_check->num_rows > 0)
			{
			while($row_ops = $result_pre_ops_check->fetch_assoc())
			 {
				$pre_ops_code_temp[] = $row_ops['operation_code'];
			}
		}
		$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order ASC LIMIT 1";
		$result_post_ops_check = $link->query($post_ops_check);
		if($result_post_ops_check->num_rows > 0)
		{
			while($row = $result_post_ops_check->fetch_assoc())
			{
				$post_ops_code = $row['operation_code'];
			}
		}
		
		$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$post_ops_code'";
		$result_checking_qry = $link->query($checking_qry);
		while($row_cat = $result_checking_qry->fetch_assoc())
		{
			$category_act = $row_cat['category'];
		}
		
		//updating data in bundle_creation_data
		$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty-'".$updatequant."', `scanned_date`='". date('Y-m-d')."' where docket_number =$updatedoc and size_title='$sizes' and operation_id = ".$op_no;
		$result_query = $link->query($query) or exit('query error in updating receive qty  bundle_creation_data');
		
		if($category_act=='Send PF' || $category_act=='Receive PF')
		{
			//update send qty in bundle_creation_data
			$send_update="UPDATE $brandix_bts.bundle_creation_data SET `send_qty`= send_qty-'".$updatequant."', `scanned_date`='". date('Y-m-d')."' where docket_number =$updatedoc and size_title='$sizes' and operation_id = ".$post_ops_code;
			$result_send_query = $link->query($send_update) or exit('query error in updating send qty bundle_creation_data');
		}
		
		//insert into bundle_creation_data_temp
		$insert_bcd_temp="INSERT INTO $brandix_bts.bundle_creation_data_temp (cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,  recevied_qty,  missing_qty,  rejected_qty,  left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,    scanned_date,         shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status) SELECT cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,  recevied_qty,  missing_qty,  rejected_qty,  left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,    scanned_date,         shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status FROM $brandix_bts.bundle_creation_data where docket_number =$updatedoc and size_title='$sizes' and operation_id = ".$op_no;
		$result_query_bcd_temp = $link->query($insert_bcd_temp) or exit('error insert into bundle_creation_data_temp');
		$last_id = $link->insert_id;
		
		//update bundle_creation_data_temp quantity
		$negqty='-'.$updatequant;
		$query_update = "UPDATE $brandix_bts.bundle_creation_data_temp SET `recevied_qty`= '".$negqty."', `scanned_date`='". date('Y-m-d')."' where id=$last_id ";
		$result_query_update = $link->query($query_update) or exit('query error in updating bundle_creation_data');
		
		//getting data form embellishment_plan_dashboard
		$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$updatedoc and send_op_code=$op_no";
		$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($qry_row=mysqli_fetch_array($check_qry_result))
		{
			$sendop_code=$qry_row['send_op_code'];
		}
		$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$updatedoc and receive_op_code=$op_no";
		$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
		{
			$recop_code=$qry_rec_row['receive_op_code'];
		}
		if($sendop_code==$op_no)
		{
			//update in emblishment dashboard
			$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty-$updatequant where doc_no =$updatedoc and send_op_code=$op_no";
			$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
		}
		if($recop_code==$op_no)
		{
			//update in emblishment dashboard
			$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty-$updatequant where doc_no =$updatedoc and receive_op_code=$op_no";
			$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
		}
		
		//checking data exist in emb_bundles or not
		$check_data_qry="select * from $bai_pro3.emb_bundles where barcode='$barcode'";
		//echo $check_data_qry;
		$check_data_qry_result=mysqli_query($link,$check_data_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($check_data_qry_result->num_rows > 0)
		{
			while($qry_result_row=mysqli_fetch_array($check_data_qry_result))
			{
			$tid=$qry_result_row['tid'];
			$barcodeno=$qry_result_row['barcode'];
			$clubstatus=$qry_result_row['club_status'];
			$orgqty=$qry_result_row['quantity'];
			$goodqty=$qry_result_row['good_qty'];
			$rejectqty=$qry_result_row['reject_qty'];
			$tranid=$qry_result_row['tran_id'];
			$status=$qry_result_row['status'];

			//if data exists update emb_bundles
			$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty=good_qty-$updatequant,status=2,update_time='". date('Y-m-d')."' where barcode='$barcode'";
													//echo $update_emb_bundles;
			$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

			//insert data into emb_bundles_temp
			$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$updatedoc."','".$sizes."','".$op_no."','".$barcodeno."','".$orgqty."','".$negqty."','".$rejctedqty."','".date('Y-m-d')."','','".$clubstatus."','".$username."','".$tranid."','".$status."')";
			$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
			}
		}
		
		//update cps_log
		$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$updatequant where doc_no = '".$updatedoc."' and size_title='". $sizes."' AND operation_code = $op_no";
		$update_qry_cps_log_res = $link->query($update_qry_cps_log);
		
		$updating = updateM3TransactionsReversal($bundle_no,$updatequant,$op_no);
		
		echo "<script>swal('Embellishment Bundle Recersed','Successfully','success');</script>";
		
	}
	
	
	
	
	
	
	
	
	//getting status of the bundle
	$check_status_qry="select status,size,good_qty,club_status from $bai_pro3.emb_bundles where barcode='$barcode'";
	$check_qry_result=mysqli_query($link,$check_status_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($qry_row=mysqli_fetch_array($check_qry_result))
	{
		$bundstaus=$qry_row['status'];
		$sizes=$qry_row['size'];
		$reverseqty=$qry_row['good_qty'];
		$clubstatus=$qry_row['club_status'];
	}

	if($bundstaus==1)
	{		
		if($clubstatus==1)
		{
			//getting child dockets from plandoc_stat_log
			$get_doc_no_qry="select doc_no from $bai_pro3.plandoc_stat_log where org_doc_no=$docno"; 
			$docno_qry_result=mysqli_query($link,$get_doc_no_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($docno_qry_result_row=mysqli_fetch_array($docno_qry_result))
			{
				$clubdocno[]=$docno_qry_result_row['doc_no'];
			}
			
			$get_quant_qry="select sum(remaining_qty) as remaining_qty from $bai_pro3.cps_log where doc_no IN (".implode(',',$clubdocno).") and operation_code=$op_no and size_title='$sizes'";
			$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
			{
				$remqty=$quant_qry_result_row['remaining_qty'];
			}
			
			if($remqty>$reverseqty)
			{
				foreach($clubdocno as $child_doc)
				{
					$get_quant_qry="select id,remaining_qty from $bai_pro3.cps_log where doc_no='".$child_doc."' and operation_code=$op_no and size_title='$sizes'";
					$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
					{
						$chdocno=$child_doc;
						$bundleno=$quant_qry_result_row['id'];
						$reaminqty=$quant_qry_result_row['remaining_qty'];
					}
					
					if($reverseqty>=$reaminqty)
					{
						if($reverseqty>0)
						{
							$dockdet[$child_doc]=$quant_qry_result_row['remaining_qty'];
							// $dockdet[$child_doc]['rem_qty']=$quant_qry_result_row['remaining_qty'];
							$reverseqty-=$reaminqty;
						}
						else
						{
							break;
						}
						
					}
					else
					{
						$dockdet[$child_doc]=$reverseqty;
						// $dockdet[$child_doc]['rem_qty']=$quant_qry_result_row['remaining_qty'];
						break;
					}
					
				}
				
			}
			else
			{
				echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
			}
				
		}
		else
		{
			$get_quant_qry="select sum(remaining_qty) as remaining_qty from $bai_pro3.cps_log where doc_no IN (".implode(',',$normdoc).") and operation_code=$op_no and size_title='$sizes'";
			$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
			{
				$remqty=$quant_qry_result_row['remaining_qty'];
			}
			if($remqty>$reverseqty)
			{
				foreach($normdoc as $child_doc)
				{
					$get_quant_qry="select id,remaining_qty from $bai_pro3.cps_log where doc_no='".$child_doc."' and operation_code=$op_no and size_title='$sizes'";
					$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
					{
						$chdocno=$child_doc;
						$bundleno=$quant_qry_result_row['id'];
						$reaminqty=$quant_qry_result_row['remaining_qty'];
					}
					if($reverseqty>0)
					{
						$dockdet[$child_doc]=$reverseqty;
						// $dockdet[$child_doc]['rem_qty']=$quant_qry_result_row['remaining_qty'];
					}
					else
					{
						break;
					}
					
				}
			}
		}
		
		foreach($dockdet as $x => $x_value) 
		{
			$updatedoc=$x;
			$updatequant=$x_value;
			updatedata($updatedoc,$updatequant,$sizes,$op_no,$seqno,$barcode,$clubstatus);
		}
		
	}
	else
	{
		if($bundstaus==0)
		{
			echo "<script>swal('This Operation Not Yet Reported','','warning');</script>";
		}
		else
		{
			echo "<script>swal('Revarsal Already Done','','warning');</script>";
		}
	}
}
?>	