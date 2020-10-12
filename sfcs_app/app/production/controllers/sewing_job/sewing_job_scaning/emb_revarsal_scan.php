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
    // $has_permission=haspermission($_GET['r']);
    // if (in_array($override_sewing_limitation,$has_permission))
    // {
        $value = 'authorized';
    // } 
    // else
    // {
    //     $value = 'not_authorized';
	// }
	
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
						<input type="submit" name="showdetails" id="showdetails" class="btn btn-primary" value="Show Details" style="margin-top: 23px;">
					</div>
				</div>
			</div>
	</div>
</form>
<?php
                if(isset($_POST['showdetails']))
				{
					// $barcode=$_POST['barcode'];
					// $barcodeno=explode('-', $barcode)[0];
					// $operation=explode('-', $barcode)[1];
				    
				    echo "<div class='panel panel-primary'>";
				    echo "<div class='panel-body'>";
				    echo "<form name='test2' method='POST' action='?r=".$_GET['r']."'>";
				    $barcode=$_POST['barcode'];
					$barcodeno=explode('-', $barcode)[0];
					$operation=explode('-', $barcode)[1];

					
					
					echo "<table class='table table-bordered'>";
					echo "<tr class='success'>
					      <th>Style</th>
					      <th>Schedule</th>
					      <th>Color</th>
					      <th>Size</th>
					      <th>Docket</th>
					      <th>Original Qty</th>
					      <th>Good Qty</th>
					      <th>Operation</th></tr>";
						//getting data from bundle_creation_data
						$getbundledata1="Select * From $bai_pro3.emb_bundles where barcode = '$barcode' and good_qty>0";
						$check_data_qry_result1=mysqli_query($link,$getbundledata1) or exit("while retriving data from bundle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						if(mysqli_num_rows($check_data_qry_result1)>0)
						{							
							while($row2=mysqli_fetch_array($check_data_qry_result1))
							{
								$size_title = $row2['size'];
								$b_op_id = $row2['ops_code'];
								$clubstatus=$row2['club_status'];
							}
							
														
							if($clubstatus==1)
							{
								//getting child dockets from plandoc_stat_log
								$get_doc_no_qry="select doc_no from bai_pro3.plandoc_stat_log where org_doc_no=$barcodeno";
								$docno_qry_result=mysqli_query($link,$get_doc_no_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($docno_qry_result_row=mysqli_fetch_array($docno_qry_result))
								{
									$clubdocnoorg=$docno_qry_result_row['doc_no'];
								}
								
								$getbundledata="Select style,schedule,color From $brandix_bts.bundle_creation_data where docket_number = $clubdocnoorg limit 1";
								$check_data_qry_result=mysqli_query($link,$getbundledata) or exit("while retriving data from bundle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));							
								while($row=mysqli_fetch_array($check_data_qry_result))
								{
									$b_style = $row['style'];
									$b_schedule = $row['schedule'];								
									$color = $row['color'];								
								}
								
								//getting clubbed schedule number
								$get_sch_qry="select order_joins from $bai_pro3.bai_orders_db WHERE order_style_no='$b_style' AND order_col_des='$color' AND order_del_no='$b_schedule'";
								$sch_res=mysqli_query($link,$get_sch_qry) or exit("error getting clubbed schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($result_rows=mysqli_fetch_array($sch_res))
								{
									$sch = $result_rows['order_joins'];
								}
								$b_schedule = substr($sch, 1);
							}
							else
							{
								$getbundledata="Select style,schedule,color From $brandix_bts.bundle_creation_data where docket_number = $barcodeno limit 1";
								$check_data_qry_result=mysqli_query($link,$getbundledata) or exit("while retriving data from bundle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));							
								while($row=mysqli_fetch_array($check_data_qry_result))
								{
									$b_style = $row['style'];
									$b_schedule = $row['schedule'];								
									$color = $row['color'];								
								}
							}
							
							$get_emb_details="select quantity,good_qty,doc_no from $bai_pro3.emb_bundles where barcode = '$barcode'";
                            $check_emb_details_result=mysqli_query($link,$get_emb_details) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($row1=mysqli_fetch_array($check_emb_details_result))
                            {
                            	$b_in_job_qty = $row1['quantity'];
                                $recevied_qty = $row1['good_qty'];
                                $b_doc_num = $row1['doc_no'];

                               echo "<tr><td>".$b_style."</td><td>".$b_schedule."</td><td>".$color."</td><td>".$size_title."</td><td>".$b_doc_num."</td><td>".$b_in_job_qty."</td><td>".$recevied_qty."</td><td>".$b_op_id."</td></tr>";
                            }

							
							// echo "<div class='row'>";
							 echo "<input type='hidden' name='barcode1' id='barcode1' value='".$barcode."'>";
					        echo "<input type='submit' name='reverse' id='reverse' class='btn btn-primary' value='Click To Reverse' style='float:right;'>";
					       
					        echo "</table></div></div></div>";
						     echo "</form></div>";
					      //   echo "</div>";
						}
                        else
                        {
                           echo "<script>swal('No Records Are Found','','warning')</script>";
                        }	
				}
				?>
<?php
if(isset($_POST['reverse']))
{
	$barcode=$_POST['barcode1'];
	$docno=explode('-', $barcode)[0];
	$op_no=explode('-', $barcode)[1];
	$seqno=explode('-', $barcode)[2];

	$access_report = $op_no.'-G';
	$access_qry=" select * from $central_administration_sfcs.rbac_permission where (permission_name = '$access_report' or permission_name = '$access_reject') and status='active'";
	$result = $link->query($access_qry);
	if($result->num_rows > 0){
		
		if (in_array($$access_report,$has_permission))
		{
			$good_report = '';
		}
		else
		{
			$good_report = 'readonly';
		}
		
	} else {
		$good_report = '';
	}
	
	$normdoc[]=explode('-', $barcode)[0];
	
	
	function updatedata($updatedoc,$updatequant,$sizes,$op_no,$seqno,$barcode,$clubstatus)
	{
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		// include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
		
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
			$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query send error');
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
		
		$update_qry_cps_log_qunt = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$updatequant where doc_no = '".$updatedoc."' and size_title='". $sizes."' AND operation_code = $pre_ops_code";
		$update_qry_cps_log_res_quant = $link->query($update_qry_cps_log_qunt);
		
		
		$updating = updateM3TransactionsReversal($bundle_no,$updatequant,$op_no);
		
		echo "<script>swal('Embellishment Bundle Reversed','Successfully','success');</script>";
		
	}
	
	
	
	//getting status of the bundle
	$check_status_qry="select status,size,good_qty,club_status,tid,reject_qty from $bai_pro3.emb_bundles where barcode='$barcode'";
	$check_qry_result=mysqli_query($link,$check_status_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($qry_row=mysqli_fetch_array($check_qry_result))
	{
		$bundstaus=$qry_row['status'];
		$sizes=$qry_row['size'];
		$reverseqty=$qry_row['good_qty'];
		$clubstatus=$qry_row['club_status'];
		$tid=$qry_row['tid'];
		$rejqty=$qry_row['reject_qty'];
	}
	if($good_report == 'readonly'){
		echo "<script>swal('UnAuthorized','to reverse Embleshment bundle','warning')</script>";
	}
	else if($rejqty==0)
	{
			
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
					
					$get_quant_qry="select sum(recevied_qty) as remaining_qty from $brandix_bts.bundle_creation_data where docket_number IN (".implode(',',$clubdocno).") and operation_id=$op_no and size_title='$sizes'";
					$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
					{
						$remqty=$quant_qry_result_row['remaining_qty'];
					}
					
					$selecting_style_schedule_color_qry = "select style,schedule,color,bundle_number from $brandix_bts.bundle_creation_data WHERE docket_number IN (".implode(',',$clubdocno).") and operation_id=$op_no and size_title='$sizes' order by bundle_number";
					$result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
					if($result_selecting_style_schedule_color_qry->num_rows > 0)
					{
						while($row = $result_selecting_style_schedule_color_qry->fetch_assoc())
						{
							$style= $row['style'];
							$schedule= $row['schedule'];
							$color= $row['color'];
						}
					}
					
					$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$op_no";
					$result_ops_seq_check = $link->query($ops_seq_check);
					while($row = $result_ops_seq_check->fetch_assoc())
					{
						$ops_seq = $row['ops_sequence'];
						$seq_id = $row['id'];
						$ops_order = $row['operation_order'];
					}
					
					$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order ASC LIMIT 1";
					$result_post_ops_check = $link->query($post_ops_check);
					if($result_post_ops_check->num_rows > 0)
					{
						while($row = $result_post_ops_check->fetch_assoc())
						{
							$post_ops_code = $row['operation_code'];
						}
					}
					
					$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
					$result_pre_ops_check = $link->query($pre_ops_check);
					while($row = $result_pre_ops_check->fetch_assoc())
					{
						$pre_ops_code = $row['operation_code'];
					}
					
					//getting previous and next operations
					$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = '$op_no'";
					$result_prev_ops_check = $link->query($prev_ops_check);
					if($result_prev_ops_check->num_rows > 0)
					{
						while($rows = $result_prev_ops_check->fetch_assoc())
						{
							$prev_operation = $rows['previous_operation'];
						}
					}
					else
					{
						$prev_operation = '';
					}

					$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = '$op_no'";
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
					
					
					if($next_operation>0 || $prev_operation>0)
					{
						if($next_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $next_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						if($prev_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and previous_operation = $prev_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						$flag='parallel_scanning';
					}
					
				   if($flag == 'parallel_scanning')
				   {
					   //getting next operation from emb_bundles
					   if($prev_operation>0)
					   {
							$get_next_op_qry="SELECT good_qty+reject_qty as good_qty FROM bai_pro3.`emb_bundles` WHERE doc_no=$docno AND size='$sizes' AND tran_id=$seqno  and ops_code=$post_ops_code";
							$get_qry_result=mysqli_query($link,$get_next_op_qry) or exit("error while retriving next ops qty from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row=mysqli_fetch_array($get_qry_result))
							{
								$nextopgoodqty=$row['good_qty'];
							}
					   }
					   else
					   {
						$nextopgoodqty=='';   
					   }
					   
						if($nextopgoodqty==0 || $nextopgoodqty=='')
						{
							if($remqty>=$reverseqty)
							{
								foreach($clubdocno as $child_doc)
								{
									$get_quant_qry="select id,recevied_qty from $brandix_bts.bundle_creation_data where docket_number='".$child_doc."' and operation_id=$op_no and size_title='$sizes'";
									$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
									{
										$chdocno=$child_doc;
										$bundleno=$quant_qry_result_row['id'];
										$reaminqty=$quant_qry_result_row['recevied_qty'];
									}
									if($reverseqty>=$reaminqty)
									{
										if($reverseqty>0)
										{
											$dockdet[$child_doc]=$reaminqty;
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
										// break;
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
							echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
						}
				   }
				   else
				   {
					   //getting next operation from emb_bundles
						$get_next_op_qry="SELECT good_qty+reject_qty as good_qty FROM bai_pro3.`emb_bundles` WHERE doc_no=$docno AND size='$sizes' AND tran_id=$seqno  and ops_code=$post_ops_code";

						$get_qry_result=mysqli_query($link,$get_next_op_qry) or exit("error while retriving next ops qty from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($get_qry_result))
						{
							$nextopgoodqty=$row['good_qty'];
						}
						if($nextopgoodqty==0 || $nextopgoodqty=='')
						{
							if($remqty>=$reverseqty)
							{
								foreach($clubdocno as $child_doc)
								{
									$get_quant_qry="select id,recevied_qty from $brandix_bts.bundle_creation_data where docket_number='".$child_doc."' and operation_id=$op_no and size_title='$sizes'";
									$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
									{
										$chdocno=$child_doc;
										$bundleno=$quant_qry_result_row['id'];
										$reaminqty=$quant_qry_result_row['recevied_qty'];
									}							
									if($reverseqty>=$reaminqty)
									{
										if($reverseqty>0)
										{
											// echo $reaminqty."rema qty";
											$dockdet[$child_doc]=$reaminqty;
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
										// break;
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
							echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
						}
				   }	
				}
				else
				{
					
					$selecting_style_schedule_color_qry = "select style,schedule,color,bundle_number from $brandix_bts.bundle_creation_data WHERE docket_number =$docno and operation_id=$op_no and size_title='$sizes' order by bundle_number";
					$result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
					if($result_selecting_style_schedule_color_qry->num_rows > 0)
					{
						while($row = $result_selecting_style_schedule_color_qry->fetch_assoc())
						{
							$style= $row['style'];
							$schedule= $row['schedule'];
							$color= $row['color'];
						}
					}
					
					$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$op_no";
					$result_ops_seq_check = $link->query($ops_seq_check);
					while($row = $result_ops_seq_check->fetch_assoc())
					{
						$ops_seq = $row['ops_sequence'];
						$seq_id = $row['id'];
						$ops_order = $row['operation_order'];
					}
					
					$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order ASC LIMIT 1";
					$result_post_ops_check = $link->query($post_ops_check);
					if($result_post_ops_check->num_rows > 0)
					{
						while($row = $result_post_ops_check->fetch_assoc())
						{
							$post_ops_code = $row['operation_code'];
						}
					}
					
					$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
					$result_pre_ops_check = $link->query($pre_ops_check);
					while($row = $result_pre_ops_check->fetch_assoc())
					{
						$pre_ops_code = $row['operation_code'];
					}
					
					//getting previous and next operations
					$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = '$op_no'";
					$result_prev_ops_check = $link->query($prev_ops_check);
					if($result_prev_ops_check->num_rows > 0)
					{
						while($rows = $result_prev_ops_check->fetch_assoc())
						{
							$prev_operation = $rows['previous_operation'];
						}
					}
					else
					{
						$prev_operation = '';
					}

					$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = '$op_no'";
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
					
					
					if($next_operation>0 || $prev_operation>0)
					{
						if($next_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $next_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						if($prev_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and previous_operation = $prev_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						$flag='parallel_scanning';
					}
					
				   if($flag == 'parallel_scanning')
				   {
					   //getting next operation from emb_bundles
					   if($prev_operation>0)
					   {
							$get_next_op_qry="SELECT good_qty+reject_qty as good_qty FROM bai_pro3.`emb_bundles` WHERE doc_no=$docno AND size='$sizes' AND tran_id=$seqno  and ops_code=$post_ops_code";
							$get_qry_result=mysqli_query($link,$get_next_op_qry) or exit("error while retriving next ops qty from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row=mysqli_fetch_array($get_qry_result))
							{
								$nextopgoodqty=$row['good_qty'];
							}
					   }
					   else
					   {
						$nextopgoodqty=='';   
					   }
					   // else
					   // {
						// $get_next_op_qry="SELECT good_qty+reject_qty as good_qty FROM bai_pro3.`emb_bundles` WHERE doc_no=$docno AND size='$sizes' AND tran_id=$seqno  and ops_code=$$op_no";   
					   // }

						
						
						if($nextopgoodqty==0 || $nextopgoodqty=='')
						{
						
								$get_quant_qry="select sum(recevied_qty) as remaining_qty from $brandix_bts.bundle_creation_data where docket_number IN (".implode(',',$normdoc).") and operation_id=$op_no and size_title='$sizes'";
								$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
								{
									$remqty=$quant_qry_result_row['remaining_qty'];
								}
								if($remqty>=$reverseqty)
								{
									foreach($normdoc as $child_doc)
									{
										$get_quant_qry="select id,recevied_qty as remaining_qty from $brandix_bts.bundle_creation_data where docket_number='".$child_doc."' and operation_id=$op_no and size_title='$sizes'";
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
								else
								{
									echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
								}
						}
						else
						{
							echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
						}
				   }
				   else
				   {
					   //getting next operation from emb_bundles
						$get_next_op_qry="SELECT good_qty+reject_qty as good_qty FROM bai_pro3.`emb_bundles` WHERE doc_no=$docno AND size='$sizes' AND tran_id=$seqno  and ops_code=$post_ops_code";

						$get_qry_result=mysqli_query($link,$get_next_op_qry) or exit("error while retriving next ops qty from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($get_qry_result))
						{
							$nextopgoodqty=$row['good_qty'];
						}
						if($nextopgoodqty==0 || $nextopgoodqty=='')
						{
						
								$get_quant_qry="select sum(recevied_qty) as remaining_qty from $brandix_bts.bundle_creation_data where docket_number IN (".implode(',',$normdoc).") and operation_id=$op_no and size_title='$sizes'";
								$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
								{
									$remqty=$quant_qry_result_row['remaining_qty'];
								}
								if($remqty>=$reverseqty)
								{
									foreach($normdoc as $child_doc)
									{
										$get_quant_qry="select id,recevied_qty as remaining_qty from $brandix_bts.bundle_creation_data where docket_number='".$child_doc."' and operation_id=$op_no and size_title='$sizes'";
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
								else
								{
									echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
								}
						}
						else
						{
							echo "<script>swal('Next Operation Already Scanned','','warning');</script>";
						}
				   }
				}
				
				foreach($dockdet as $x => $x_value) 
				{
					$updatedoc=$x;
					$updatequant=$x_value;
					if($updatequant>0)
					{
						updatedata($updatedoc,$updatequant,$sizes,$op_no,$seqno,$barcode,$clubstatus);
					}
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
	else
	{
		echo "<script>swal('Rejection Revarsal Not Possible','','warning');</script>";
	}
}
?>	
