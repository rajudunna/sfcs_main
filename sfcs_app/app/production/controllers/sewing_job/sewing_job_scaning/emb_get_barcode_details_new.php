<?php
    error_reporting(0);
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    include 'functions_scanning_ij.php';

    $barcode = $_POST['barcode'];
	//$rejqty=$_POST['rej_id'];
	$has_permission = json_decode($_POST['has_permission'],true);

	$rej_data=$_POST['rej_data'];
	// $rejqty=array_sum($rej_data);
	// if($rejqty!='' || $rejqty!=0)
	// {
		// $rejctedqty=$rejqty;
	// }
	// else
	// {
		// $rejctedqty=0;
	// }
	
		if($rej_data!=''){
				$rejctedqty=array_sum($rej_data);		
			}else{
				$rejctedqty=0;
		}
    $shift = $_POST['shift'];
    $gate_id = $_POST['gate_id'];
	$user_permission = $_POST['auth'];
    $b_shift = $shift;
    //changing for #978 cr
    $docket_no = explode('-', $barcode)[0];
	$op_no = explode('-', $barcode)[1];
	$seqno = explode('-', $barcode)[2];
	//auth
    $good_report = 0;

    if($op_no != '') {
        $access_report = $op_no.'-G';
        $access_reject = $op_no.'-R';

        $access_qry=" select * from $central_administration_sfcs.rbac_permission where permission_name = '$access_report' and status='active'";

        $result = $link->query($access_qry);
        
	    if($result->num_rows > 0){
		
            if (in_array($$access_report,$has_permission))
            {
                $good_report = 0;
            }
            else
            {
                // good cant be report as it opcode-Good is assigned in user permission for this screen
                $good_report = 1;
			}
			if (in_array($$access_reject,$has_permission))
            {
                $reject_report = 0;
            }
            else
            {
                // reject cant be report as it opcode-Reject is assigned in user permission for this screen
                $reject_report = 1;
            }
        } else {
            $good_report = 0;
            $reject_report = 0;
        }
    } else {
        $good_report = 0;
        $reject_report = 0;
	}
	
//getting child dockets from plandoc_stat_log
$get_doc_no_qry="select doc_no from bai_pro3.plandoc_stat_log where org_doc_no=$docket_no";
$docno_qry_result=mysqli_query($link,$get_doc_no_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
while($docno_qry_result_row=mysqli_fetch_array($docno_qry_result))
{
	$clubdocno[]=$docno_qry_result_row['doc_no'];
}
if(count($clubdocno)>0){	
$child_docs=implode(',',$clubdocno);
}else{
	$clubdocno='';
}	
if($child_docs!='')
{
	$docket_no=$child_docs;
}
else
{
	$docket_no=explode('-', $barcode)[0];
}	




if($good_report == 1 && $reject_report == 1) {
	$result_array['status'] = 'You are Not Authorized to report Good and Rejection Qty';
	echo json_encode($result_array);
	die();
} else if($good_report == 1) {
	$result_array['status'] = 'You are Not Authorized to report Good Qty';
	echo json_encode($result_array);
	die();
} else if($good_report == 0 && $rejctedqty > 0 && $reject_report == 1) {
	$result_array['status'] = 'You are Not Authorized to report Rejection Qty';
	echo json_encode($result_array);
	die();
}

// else if($reject_report == 1){
// 	$result_array['status'] = 'You are Not Authorized to report Rejected Qty';
// 	echo json_encode($result_array);
// 	die();
// }
//checking for emblishment Planning done or not
$check_plan_qry="select doc_no from $bai_pro3.embellishment_plan_dashboard where doc_no in ($docket_no)";
$check_qry_result=mysqli_query($link,$check_plan_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
if($check_qry_result->num_rows > 0)
{
	
			//getting details from emb_bundles
			$get_data_qry="select size,club_status,quantity,status from $bai_pro3.emb_bundles where barcode='$barcode'";	
			$selct_qry_result=mysqli_query($link,$get_data_qry) or exit("error while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($selct_qry_result->num_rows > 0)
			{
				while($selct_qry_result_row=mysqli_fetch_array($selct_qry_result))
				{
					$sizes = $selct_qry_result_row['size'];
					$clubstatus=$selct_qry_result_row['club_status'];
					$embquantity=$selct_qry_result_row['quantity'];
					$gdqty=$selct_qry_result_row['good_qty'];
					$docstatus=$selct_qry_result_row['status'];
				}
			}
			$embquantity=$embquantity-$rejctedqty;

	if($clubstatus==1)
	{

	function getdet($quantity,$docno,$op_no,$sizes,$docstatus,$seqno,$barcode,$rejctedqty,$rej_data)
	{
		if($rej_data!=''){
			$total_rej_qty=array_sum($rej_data);   
		}else{
			$total_rej_qty=0;
		}
		$orgdoc=explode('-', $barcode)[0];

		if($docstatus==0 || $docstatus==2 || $docstatus=='')
		{
			include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
			include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
			$b_op_id=$op_no;
			$b_doc_num=$docno;
			$diffqty=$quantity;			
			
			//getting bundle number from bundle_creation_data
			$selct_qry = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data  WHERE docket_number =$docno AND operation_id='$op_no' AND size_title='$sizes'";
			$selct_qry_res=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($selct_qry_res->num_rows > 0)
			{
		   
				while($selct_qry_result_rows=mysqli_fetch_array($selct_qry_res))
				{
					$bundle_no = $selct_qry_result_rows['bundle_number'];
				}
			}
			
			$string = $bundle_no.','.$op_no.','.'0';
			
			$selecting_style_schedule_color_qry = "select style,schedule,color,bundle_number from $brandix_bts.bundle_creation_data WHERE docket_number =$docno and operation_id=$op_no and size_title='$sizes' order by bundle_number";
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
			
			//getting clubbed schedule number
			$get_sch_qry="select order_joins from $bai_pro3.bai_orders_db WHERE order_style_no='$style' AND order_col_des='$color' AND order_del_no='$schedule'";
			$sch_res=mysqli_query($link,$get_sch_qry) or exit("error getting clubbed schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($result_rows=mysqli_fetch_array($sch_res))
			{
				$sch = $result_rows['order_joins'];
			}
			$clubsch = substr($sch, 1);
			
						
			//*To check Parallel Operations
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
					
					$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv,manual_smv from $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$mapped_color' and operation_code=$b_op_id";
					$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
					while($row = $result_dep_ops_array_qry->fetch_assoc())
					{
						$sequnce = $row['ops_sequence'];
						$is_m3 = $row['default_operration'];
						$sfcs_smv = $row['smv'];
						if($sfcs_smv=='0.0000')
						{
						$sfcs_smv = $row_ops['manual_smv'];
						}
					}
				   
					$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
					$result_ops_dep_qry = $link->query($ops_dep_qry);
					while($row = $result_ops_dep_qry->fetch_assoc())
					{
						$ops_dep = $row['ops_dependency'];
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
					
					
					//getting previous and next operations
					$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' AND operation_code = '$b_op_id'";
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

					$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' AND operation_code = '$b_op_id'";
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
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' and ops_dependency = $next_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						if($prev_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$maped_color' and previous_operation = $prev_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						$flag='parallel_scanning';
					}
					
					if($flag=='parallel_scanning')
					{
						
							$category=['cutting','Send PF','Receive PF'];
							$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$op_no'";
							$result_checking_qry = $link->query($checking_qry);
							while($row_cat = $result_checking_qry->fetch_assoc())
							{
								$category_act = $row_cat['category'];
							}

						if($category_act=='Send PF')
						{
							$cehck_status_qry="select recevied_qty as good_qty from $brandix_bts.bundle_creation_data where docket_number=$docno and operation_id=$prev_operation and size_title='$sizes'";
						}
						else
						{
							$cehck_status_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$orgdoc and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
						}

						$check_qty_qry_result=mysqli_query($link,$cehck_status_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rowss=mysqli_fetch_array($check_qty_qry_result))
						{
							$statusopqty=$rowss['good_qty'];
						}
						
						if($category_act=='Send PF')
						{
							$check_googd_qty_qry="select good_qty from $bai_pro3.emb_bundles where barcode='$barcode'";
						}
						else
						{
							$check_googd_qty_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$orgdoc and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
						}
						$check_googd_qty_qry_rslt=mysqli_query($link,$check_googd_qty_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rowss=mysqli_fetch_array($check_googd_qty_qry_rslt))
						{
							$goodqty=$rowss['good_qty'];
						}
						if($goodqty>0)
						{
							$diffqty=$goodqty-$rejctedqty;
						}
						else
						{
							$diffqty=$diffqty;
						}
						
						
		
						if($statusopqty>0)
						{					
						
						
						 //get min qty of previous operations
						$qry_min_prevops="SELECT MIN(recevied_qty) AS min_recieved_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number = $docno AND size_title = '$sizes' AND operation_id in ($emb_operations)";
						$result_qry_min_prevops = $link->query($qry_min_prevops);
						while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc())
						{
							$previous_minqty=$row_result_min_prevops['min_recieved_qty'];
						}
						
						$schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,sum(recevied_qty) AS current_recieved_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'parallel_scanning' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number = $docno AND operation_id = $b_op_id and size_title='$sizes' order by tid";
						$result_style_data = $link->query($schedule_query);
						$select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$string'";
						$result_select_modudle_qry = $link->query($select_modudle_qry);
						while($row = $result_select_modudle_qry->fetch_assoc())
						{
							$module = $row['input_module'];
						}
						
						while($row = $result_style_data->fetch_assoc())
						{
							$size = $sizes;
						   
							$b_job_no = $row['input_job_no_random'];
							$b_style= $row['order_style_no'];
							$b_schedule=$row['order_del_no'];
							$b_colors[]=$row['order_col_des'];
							$b_sizes[] = $row['size_code'];
							$b_size_code[] = $row['old_size'];
							$size_ims = $row['size_code'];
							$b_doc_num[]=$row['doc_no'];
							$doc_value = $row['doc_no'];
							$b_in_job_qty[]=$row['carton_act_qty'];

							if($flag == 'parallel_scanning')
							{
								$current_ops_qty=$row['balance_to_report'];
								$parallel_balance_report=($previous_minqty-$current_ops_qty);
								
								if($parallel_balance_report>0)
								{
								   
								  $b_rep_qty[]=$parallel_balance_report;
						   
								}
							}  
							$b_rep_qty[]=$row['balance_to_report'];
							$b_rej_qty[]=0;
							$b_op_id = $op_no;
							$b_tid[] = $row['tid'];
							$b_inp_job_ref[] = $row['input_job_no'];
							$b_a_cut_no[] = $row['acutno'];
							$b_shift = $shift;
							$mapped_color = $row['order_col_des'];
							$b_module[] = $module;
							$result_array['table_data'][] = $row;
						}
						
						$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id =$b_op_id";
								$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
							   
								if($schedule_count_query->num_rows > 0)
								{
									$schedule_count = true;
								}else{
									$schedule_count = false;
								}
							   
								 foreach ($b_tid as $key => $tid)
								{
									if($b_tid[$key] == $bundle_no)
									{
										
									  $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and operation_code = $b_op_id";
											$result_smv_query = $link->query($smv_query);
											while($row_ops = $result_smv_query->fetch_assoc())
											{
												$sfcs_smv = $row_ops['smv'];
												if($sfcs_smv=='0.0000')
												{
												$sfcs_smv = $row_ops['manual_smv'];
												}
											}
											$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

											$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`) VALUES";
										   
											$remarks_code = "";                            
											$select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty, left_over FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
											$result_select_send_qty = $link->query($select_send_qty);
											if($result_select_send_qty->num_rows >0)
											{
												while($row = $result_select_send_qty->fetch_assoc())
												{
													$b_old_rep_qty_new = $row['recevied_qty'];
													$b_old_rej_qty_new = $row['rejected_qty'];
													$b_left_over_qty = $row['left_over'];
													$b_send_qty = $row['send_qty'];

												}
											}
												$final_rep_qty = $parallel_balance_report;

												$final_rej_qty = $b_old_rej_qty_new;

												$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
												// LAST STEP MODIFIED
												$left_over_qty_update = $b_send_qty - $final_rep_qty;

												$previously_scanned = $parallel_balance_report;
																		  
												if($schedule_count){
													$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+'".$diffqty."',`rejected_qty`=rejected_qty+'".$rejctedqty."' ,`left_over`= '".$left_over_qty_update."' , `scanned_date`='".date("Y-m-d H:i:s")."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
												   
													$result_query = $link->query($query) or exit('query error in updating');
												}else{
													   
													$bulk_insert_post .= '("'.$style.'","'. $schedule.'","'.$mapped_color.'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$diffqty.'","'.$rejctedqty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num.'","'.date("Y-m-d H:i:s").'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';  
													$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
												}
												
												//getting data form embellishment_plan_dashboard
												$quanforembdash=$diffqty+$rejctedqty;
												$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num and send_op_code=$b_op_id";
												
												$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
												while($qry_row=mysqli_fetch_array($check_qry_result))
												{
													$sendop_code=$qry_row['send_op_code'];
												}
												$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num and receive_op_code=$b_op_id";
												$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
												while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
												{
													$recop_code=$qry_rec_row['receive_op_code'];
												}
												if($sendop_code==$b_op_id)
												{
													//update in emblishment dashboard
													$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$quanforembdash where doc_no =$b_doc_num and send_op_code=$b_op_id";
													$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
												}
												if($recop_code==$b_op_id)
												{
													//update in emblishment dashboard
													$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$quanforembdash where doc_no =$b_doc_num and receive_op_code=$b_op_id";
													$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
												}
												
												//checking data exist in emb_bundles or not
												$check_data_qry="select * from $bai_pro3.emb_bundles where  barcode='$barcode'";
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
													$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty='$diffqty',status=1,reject_qty='$rejctedqty',update_time='". date("Y-m-d H:i:s")."' where  barcode='$barcode'";
													$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

													//insert data into emb_bundles_temp
													$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$b_doc_num."','".$b_sizes[$key]."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$diffqty."','".$rejctedqty."','".date("Y-m-d H:i:s")."','','".$clubstatus."','".$username."','".$tranid."','".$status."')";
													$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
													}
												}
												// else
												// {
												// insert data into emb_bundles

												// }

												if($result_query)
												{
													if($b_rep_qty[$key] > 0)
													{
														$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_send_qty.'","'.$diffqty .'","'.$rejctedqty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';  
														$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
														
														
													}
												}
												
												$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$previous_minqty where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code=$b_op_id";
														$update_qry_cps_log_res = $link->query($update_qry_cps_log);
													   
														$update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previous_minqty where doc_no = '".$b_doc_num."' and size_title='". $b_sizes[$key]."' AND operation_code = $pre_ops_code";   
														$update_cps_log_res = $link->query($update_pre_qty);
												
													//update cps_log
						// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$diffqty+$rejctedqty where doc_no = '".$docno."' and size_title='". $sizes."' AND operation_code = $b_op_id";
						// $update_qry_cps_log_res = $link->query($update_qry_cps_log);
						
						// $update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$diffqty+$rejctedqty where doc_no = '".$docno."' and size_title='". $sizes."' AND operation_code = $pre_ops_code";   
						// $update_cps_log_res = $link->query($update_pre_qty);
													//update send qty to next operation if available
													if($post_ops_code != null)
													{
														$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+'".$diffqty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$docno and size_title='$sizes' and operation_id = ".$post_ops_code;
														$result_query = $link->query($query_post) or exit('query error in updating');
													}
													if($ops_dep)
													{
														$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
														$result_pre_send_qty = $link->query($pre_send_qty_qry);
														while($row = $result_pre_send_qty->fetch_assoc())
														{
															$pre_recieved_qty = $row['recieved_qty'];
														}

														$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` =send_qty+ '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num and size_title='$sizes' and operation_id = ".$ops_dep;

														$result_query = $link->query($query_post_dep) or exit('query error in updating');
											   
													}                
											   

																   
									}
								   
								}
								
								
								
								if($rejctedqty>0)
								{
								
												$b_remarks  = '';
											
										$actual_rejection_reason_array_string = array();
										foreach($rej_data as $reason_key=>$reason_value)
										{   
											//to get form type
											$rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
											$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
											while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
											{
												$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
												$type = $rowresult_rejection_code_fetech_qry['form_type'];
											}
											$bundle_individual_number=$bundle_no;
											$remain_qty_key=$reason_key;
											$remain_qty_value=$reason_value;
											if($reason_value > 0)
											{   
												$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
												$remarks_code = $reason_code.'-'.$reason_value;
												$remarks_var = $module.'-'.$shift.'-'.$type;
												$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
												$bulk_insert_rej .= '("'.$style.'","'.$schedule.'","'.$maped_color.'","'.$username.'","'.date('Y-m-d').'","'.$sizes.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$docno.'","'.$input_job_no_random.'","'. $b_op_id.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
												$rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
												//updating BCD
												
												
											}
										}


										//update rejections to M3 trasactions
										if(sizeof($actual_rejection_reason_array_string) > 0)
										{
											for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
												{
													$r_qty = array();
													$r_reasons = array();
													$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
													$r_qty[] = $implode_next[2];
													$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
													$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
														while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
														{
															$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
														}
													//$r_reasons[] = $m3_reason_code;
													$b_tid = $implode_next[0];
													//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
													$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $b_op_id";
													$bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
														while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
														{
															$bcd_id = $bcd_id_row['id'];
															$style = $bcd_id_row['style'];
															$schedule = $bcd_id_row['schedule'];
															$color = $bcd_id_row['color'];
															$doc_no = $bcd_id_row['docket_number'];
															$size_title = $bcd_id_row['size_title'];
															$size_id = $bcd_id_row['size_id'];
															$assigned_module = $bcd_id_row['assigned_module'];
															$input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
															$doc_value = $bcd_id_row['docket_number'];
														}
													//searching the bcd_id in rejection log child or not
													$bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
													$bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
													if($bcd_id_searching_qry_result->num_rows > 0)
													{
														while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
														{
															$parent_id = $bcd_id_searching_qry_result_row['parent_id'];
														}
														$update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
														mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
														$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$style' and schedule='$schedule' and color='$maped_color'";
														$update_qry_rej_lg = $link->query($update_qry_rej_lg);
													}
													else
													{
														$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$maped_color'";
														// echo $search_qry;
														$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
														if($result_search_qry->num_rows > 0)
														{
															while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
															{
																$rejection_log_id = $row_result_search_qry['id'];
																$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
																// echo $update_qry_rej_lg;
																$update_qry_rej_lg = $link->query($update_qry_rej_lg);
																$parent_id = $rejection_log_id;
															}

														}
														else
														{
															$insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$style','$schedule','$maped_color',$implode_next[2],'0',$implode_next[2])";
															$res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
															$parent_id=mysqli_insert_id($link);
														}
														$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$b_op_id)";
														$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
													}
													//inserting into rejections_reason_track'
													if($implode_next[2] > 0)
													{
														$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
														$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
														//updating this to cps log
														// if($b_op_id)
														// {
															//getting dependency operation
															// $parellel_ops=array();
															// $qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$maped_color' and ops_dependency='$b_op_id'";
															// $qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
															// if($qry_parellel_ops_result->num_rows > 0){
																// while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
																// { 
																	// $parellel_ops[] = $row_prellel['operation_code'];
																// }
															// }
															// if($ops_cps_updat>0){
																// if(sizeof($parellel_ops)>0){
																	// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code in (".implode(',',$parellel_ops).")";
																// }else{
																	// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code = $ops_cps_updat";
																// }
																// $update_qry_cps_log_res = $link->query($update_qry_cps_log);
															// }	
															
														// }
													}
													updateM3TransactionsRejections($b_tid,$b_op_id,$r_qty,$m3_reason_code);
													updateM3Transactions($b_tid,$b_op_id,$diffqty);
												}
										}
								}
								else
								{
									updateM3Transactions($b_tid[0],$b_op_id,$diffqty);
								}
						
										// for($i=0;$i<sizeof($b_tid);$i++)
										// {
										// $updation_m3 = updateM3Transactions($b_tid[$i],$b_op_id,$diffqty);
										// }
										$result_array['bundle_no'] = $orgdoc;
										$result_array['op_no'] = $op_no;
										$result_array['style'] = $style;
										$result_array['schedule'] = $clubsch;
										$result_array['color_dis'] = $color;
										$result_array['size'] = $sizes;
										$result_array['reported_qty'] = $diffqty;
										$result_array['rejected_qty'] = $rejctedqty;
										$result_array['bunno'] = $seqno;
										$result_array['date_n'] = date("Y-m-d H:i:s");
										echo json_encode($result_array);
										die();
						
						}
				
							else
							{
								$result_array['status'] = 'Previous Operation Not Done';
								echo json_encode($result_array);
								die();
							}
					}
					
					else
					{
						$category=['cutting','Send PF','Receive PF'];
						$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
						$result_checking_qry = $link->query($checking_qry);
						while($row_cat = $result_checking_qry->fetch_assoc())
						{
							$category_act = $row_cat['category'];
						}
						
						if($category_act=='Send PF' || $category_act=='Receive PF')
						{
							$cehck_status_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$orgdoc and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
						}
						else
						{
							$cehck_status_qry="select send_qty as good_qty from $brandix_bts.bundle_creation_data where docket_number=$docno and operation_id=$b_op_id and size_title='$sizes'";
						}
						
						$check_qty_qry_result=mysqli_query($link,$cehck_status_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rowss=mysqli_fetch_array($check_qty_qry_result))
						{
							$statusopqty=$rowss['good_qty'];
						}
						
						$check_googd_qty_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$orgdoc and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
						$check_googd_qty_qry_rslt=mysqli_query($link,$check_googd_qty_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rowss=mysqli_fetch_array($check_googd_qty_qry_rslt))
						{
							$goodqty=$rowss['good_qty'];
						}
						if($goodqty>0)
						{
							$diffqty=$goodqty-$rejctedqty;
						}
						else
						{
							$diffqty=$diffqty;
						}
					if($statusopqty>0)
					{						
						//updating data in bundle_creation_data
						$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+'".$diffqty."',`rejected_qty`=rejected_qty+'".$rejctedqty."', `scanned_date`='". date('Y-m-d')."' where bundle_number =$bundle_no and operation_id = ".$b_op_id;
						$result_query = $link->query($query) or exit('query error in updating bundle_creation_data');
						
						//insert into bundle_creation_data_temp
						$insert_bcd_temp="INSERT INTO $brandix_bts.bundle_creation_data_temp (cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,  recevied_qty,  missing_qty,  rejected_qty,  left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,    scanned_date,         shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status) SELECT cut_number,  style,            schedule,  color,                           size_id,  size_title,  sfcs_smv,  bundle_number,  original_qty,  send_qty,  recevied_qty,  missing_qty,  rejected_qty,  left_over,  operation_id,  operation_sequence,  ops_dependency,  docket_number,  bundle_status,  split_status,  sewing_order_status,  is_sewing_order,  sewing_order,  assigned_module,  remarks,    scanned_date,         shift,    scanned_user,     sync_status,  shade,   input_job_no,  input_job_no_random_ref,  bundle_qty_status FROM $brandix_bts.bundle_creation_data where bundle_number =$bundle_no and operation_id = ".$b_op_id;

						$result_query_bcd_temp = $link->query($insert_bcd_temp) or exit('error insert into bundle_creation_data_temp');
						$last_id = $link->insert_id;
						
						//update bundle_creation_data_temp quantity
						$query_update = "UPDATE $brandix_bts.bundle_creation_data_temp SET `recevied_qty`= '".$diffqty."', `scanned_date`='". date('Y-m-d')."' where id=$last_id ";
						$result_query_update = $link->query($query_update) or exit('query error in updating bundle_creation_data');
						
						//getting data form embellishment_plan_dashboard
						$quanforembdash=$diffqty+$rejctedqty;
						$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$docno and send_op_code=$b_op_id";
						$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($qry_row=mysqli_fetch_array($check_qry_result))
						{
							$sendop_code=$qry_row['send_op_code'];
						}
						$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$docno and receive_op_code=$b_op_id";
						$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
						{
							$recop_code=$qry_rec_row['receive_op_code'];
						}
						if($sendop_code==$b_op_id)
						{
							//update in emblishment dashboard
							$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$quanforembdash where doc_no =$docno and send_op_code=$b_op_id";
							$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
						}
						if($recop_code==$b_op_id)
						{
							//update in emblishment dashboard
							$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$quanforembdash where doc_no =$docno and receive_op_code=$b_op_id";
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
							$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty=$diffqty,reject_qty=$rejctedqty,status=1,update_time='".date("Y-m-d H:i:s")."' where barcode='$barcode'";
																	//echo $update_emb_bundles;
							$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

							//insert data into emb_bundles_temp
							$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$docno."','".$sizes."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$diffqty."','".$rejctedqty."','".date("Y-m-d H:i:s")."','','".$clubstatus."','".$username."','".$tranid."','".$status."')";
							$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
							}
						}
						
						//update cps_log
						$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$quanforembdash-$rejctedqty where doc_no = '".$docno."' and size_title='". $sizes."' AND operation_code = $b_op_id";
						// echo $update_qry_cps_log;
						$update_qry_cps_log_res = $link->query($update_qry_cps_log);
						
						$update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$quanforembdash where doc_no = '".$docno."' and size_title='". $sizes."' AND operation_code = $pre_ops_code";   
						$update_cps_log_res = $link->query($update_pre_qty);
						//update send qty to next operation if available
						if($post_ops_code != null)
						{
							$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+'".$diffqty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$docno and size_title='$sizes' and operation_id = ".$post_ops_code;
							$result_query = $link->query($query_post) or exit('query error in updating');
						}
						
						if($rejctedqty>0)
						{
										
												$b_remarks  = '';
										
										$actual_rejection_reason_array_string = array();
										foreach($rej_data as $reason_key=>$reason_value)
										{   
											//to get form type
											$rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
											$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
											while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
											{
												$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
												$type = $rowresult_rejection_code_fetech_qry['form_type'];
											}
											$bundle_individual_number=$bundle_no;
											$remain_qty_key=$reason_key;
											$remain_qty_value=$reason_value;
											if($reason_value > 0)
											{   
												$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
												$remarks_code = $reason_code.'-'.$reason_value;
												$remarks_var = $module.'-'.$shift.'-'.$type;
												$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
												$bulk_insert_rej .= '("'.$style.'","'.$schedule.'","'.$maped_color.'","'.$username.'","'.date('Y-m-d').'","'.$sizes.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$docno.'","'.$input_job_no_random.'","'. $b_op_id.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
												$rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
												//updating BCD
												
												
											}
										}


										//update rejections to M3 trasactions
										if(sizeof($actual_rejection_reason_array_string) > 0)
										{
											for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
												{
													$r_qty = array();
													$r_reasons = array();
													$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
													$r_qty[] = $implode_next[2];
													$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
													$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
														while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
														{
															$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
														}
													//$r_reasons[] = $m3_reason_code;
													$b_tid = $implode_next[0];
													//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
													$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $b_op_id";
													$bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
														while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
														{
															$bcd_id = $bcd_id_row['id'];
															$style = $bcd_id_row['style'];
															$schedule = $bcd_id_row['schedule'];
															$color = $bcd_id_row['color'];
															$doc_no = $bcd_id_row['docket_number'];
															$size_title = $bcd_id_row['size_title'];
															$size_id = $bcd_id_row['size_id'];
															$assigned_module = $bcd_id_row['assigned_module'];
															$input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
															$doc_value = $bcd_id_row['docket_number'];
														}
													//searching the bcd_id in rejection log child or not
													$bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
													$bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
													if($bcd_id_searching_qry_result->num_rows > 0)
													{
														while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
														{
															$parent_id = $bcd_id_searching_qry_result_row['parent_id'];
														}
														$update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
														mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
														$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$style' and schedule='$schedule' and color='$maped_color'";
														$update_qry_rej_lg = $link->query($update_qry_rej_lg);
													}
													else
													{
														$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$maped_color'";
														// echo $search_qry;
														$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
														if($result_search_qry->num_rows > 0)
														{
															while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
															{
																$rejection_log_id = $row_result_search_qry['id'];
																$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
																// echo $update_qry_rej_lg;
																$update_qry_rej_lg = $link->query($update_qry_rej_lg);
																$parent_id = $rejection_log_id;
															}

														}
														else
														{
															$insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$style','$schedule','$maped_color',$implode_next[2],'0',$implode_next[2])";
															$res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
															$parent_id=mysqli_insert_id($link);
														}
														$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$b_op_id)";
														$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
													}
													//inserting into rejections_reason_track'
													if($implode_next[2] > 0)
													{
														$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
														$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
														//updating this to cps log
														// if($b_op_id)
														// {
															//getting dependency operation
															// $parellel_ops=array();
															// $qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$maped_color' and ops_dependency='$b_op_id'";
															// $qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
															// if($qry_parellel_ops_result->num_rows > 0){
																// while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
																// { 
																	// $parellel_ops[] = $row_prellel['operation_code'];
																// }
															// }
															// if($ops_cps_updat>0){
																// if(sizeof($parellel_ops)>0){
																	// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code in (".implode(',',$parellel_ops).")";
																// }else{
																	// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code = $ops_cps_updat";
																// }
																// $update_qry_cps_log_res = $link->query($update_qry_cps_log);
															// }	
															
														// }
													}
													updateM3TransactionsRejections($b_tid,$b_op_id,$r_qty,$m3_reason_code);
													updateM3Transactions($b_tid,$b_op_id,$diffqty);
												}
										}
						
						}
						else
						{
							updateM3Transactions($b_tid[0],$b_op_id,$diffqty);
						}
						
						
						// for($i=0;$i<sizeof($b_tid);$i++)
						// {
						// $updation_m3 = updateM3Transactions($b_tid[$i],$b_op_id,$diffqty);
						// }
						$result_array['bundle_no'] = $orgdoc;
						$result_array['op_no'] = $op_no;
						$result_array['style'] = $style;
						$result_array['schedule'] = $clubsch;
						$result_array['color_dis'] = $color;
						$result_array['size'] = $sizes;
						$result_array['reported_qty'] = $diffqty;
						$result_array['rejected_qty'] = $rejctedqty;
						$result_array['bunno'] = $seqno;
						$result_array['date_n'] = date("Y-m-d H:i:s");
						echo json_encode($result_array);
						die();
					}
					else
					{
						$result_array['status'] = 'Previous Operation Not Done';
						echo json_encode($result_array);
						die();
					}
				}	
		}
		else
		{
			$result_array['status'] = 'Already Scanned';
			echo json_encode($result_array);
			die();
		}
					
	}
		
		
		// for($i=0;$i<sizeof($clubdocno);$i++)
		// {
			// checking if docket quantities
			// $get_quant_qry="select send_qty as send_qty,(recevied_qty+rejected_qty) as receive_qty from $brandix_bts.bundle_creation_data where docket_number='".$clubdocno[$i]."' and operation_id=$op_no and size_title='$sizes'";
			// $quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
			// {
				// $sendqty[$clubdocno[$i]]['send_qty']=$quant_qry_result_row['send_qty'];
				// $sendqty[$clubdocno[$i]]['received_qty']=$quant_qry_result_row['receive_qty'];
			// }
			
			// if($embquantity>0)
			// {
				// foreach($sendqty[$clubdocno[$i]] as $key=>$sendqty)
				// {
					// echo $sendqty[$clubdocno[$i]][$key]."</br>";
				// }
			// }
		// }
		
		foreach($clubdocno as $child_doc)
		{
			$get_quant_qry="select send_qty as send_qty,(recevied_qty+rejected_qty) as receive_qty from $brandix_bts.bundle_creation_data where docket_number='".$child_doc."' and operation_id=$op_no and size_title='$sizes'";
			$quant_qry_result=mysqli_query($link,$get_quant_qry) or exit("error retriving quantities from bundle_creation_data for child docs".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($quant_qry_result_row=mysqli_fetch_array($quant_qry_result))
			{
				$sendqty[$child_doc]['doc_no']=$child_doc;
				$sendqty[$child_doc]['send_qty']=$quant_qry_result_row['send_qty'];
				$sendqty[$child_doc]['received_qty']=$quant_qry_result_row['receive_qty'];
			}
		}
		if($embquantity>0)
		{
			for($i=0;$i<sizeof($clubdocno);$i++)
			{
				$doc_no=$sendqty[$clubdocno[$i]]['doc_no'];
				$sendqtys=$sendqty[$clubdocno[$i]]['send_qty'];
				$receivedqty=$sendqty[$clubdocno[$i]]['received_qty'];
				$eligibleqty=$sendqtys-$receivedqty;
				if($eligibleqty>0)
				{
					if($eligibleqty>=$embquantity)
					{
						// $repqty[$doc_no]['doc_no']=$doc_no;
						// $repqty[$doc_no]['reportqty']=$embquantity;
						$repqty[$doc_no]=$embquantity;
						$embquantity = 0;
					}
					else
					{
						
						// $repqty[$doc_no]['reportqty']=$embquantity;
						$repqty[$doc_no]=$eligibleqty;
						// $repqty[$doc_no]['doc_no']=$doc_no;
						$embquantity -= $eligibleqty;
					}
				}
			}
		}

	if($repqty!='')
	{		
		foreach($repqty as $x => $x_value) {
			$docno=$x;
			$quantity=$x_value;
			
				// echo $rejctedqty."vachanu";
				// die();
			if($quantity>0)
			{
				getdet($quantity,$docno,$op_no,$sizes,$docstatus,$seqno,$barcode,$rejctedqty,$rej_data);
			}
		}
	}
	else
	{
		foreach($clubdocno as $child_doc)
		{
			$docno=$child_doc;
			$quantity=0;
			getdet($quantity,$docno,$op_no,$sizes,$docstatus,$seqno,$barcode,$rejctedqty,$rej_data);
		}
	}

	
		
	}
	else
	{
				$doc_no=explode('-', $barcode)[0];
				$op_no = explode('-', $barcode)[1];
				$seqno = explode('-', $barcode)[2];
				
				//getting bundle number from bundle_creation_data
				$selct_qry = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data  WHERE docket_number =$doc_no AND operation_id=$op_no AND size_title='$sizes'";
				$selct_qry_res=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($selct_qry_res->num_rows > 0)
				{
			   
					while($selct_qry_result_rows=mysqli_fetch_array($selct_qry_res))
					{
						$bundle_no = $selct_qry_result_rows['bundle_number'];
					}
				}
				
				$emb_cut_check_flag = 0;
				$msg = 'Scanned Successfully';

				$string = $bundle_no.','.$op_no.','.'0';

				function getjobdetails1($job_number, $bundle_no, $op_no, $shift ,$gate_id, $embquantity, $seqno,$doc_no,$sizes,$docstatus,$rejctedqty,$rej_data)
				{
					if($rej_data!=''){
						$total_rej_qty=array_sum($rej_data);   
					}else{
						$total_rej_qty=0;
					}
					$job_number = explode(",",$job_number);
					$job_number[4]=$job_number[1];
					$gate_pass_no=$gate_id;
					include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
					include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/m3Updations.php");
				   
					$column_to_search = $job_number[0];
					$column_in_where_condition = 'bundle_number';
				   
					$selecting_style_schedule_color_qry = "select style,schedule,color from $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id=$op_no  order by bundle_number";
					
					$result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
					if($result_selecting_style_schedule_color_qry->num_rows > 0)
					{
						while($row = $result_selecting_style_schedule_color_qry->fetch_assoc())
						{
							$job_number[1]= $row['style'];
							$job_number[2]= $row['schedule'];
							$job_number[3]= $row['color'];
						}
					}
					else
					{
						$result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
						echo json_encode($result_array);
						die();
					}
					$result_array['style'] = $job_number[1];
					$result_array['schedule'] = $job_number[2];
					$result_array['color_dis'] = $job_number[3];

					  $maped_color = $job_number[3];
				   

					//*To check Parallel Operations
					$ops_sequence_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code=$job_number[4]";
					//echo $ops_sequence_check;
					$result_ops_sequence_check = $link->query($ops_sequence_check);
					while($row2 = $result_ops_sequence_check->fetch_assoc())
					{
						$ops_seq = $row2['ops_sequence'];
						$seq_id = $row2['id'];
						$ops_order = $row2['operation_order'];

					}

					//getting previous and next operations
					$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND operation_code = '$op_no'";
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

					$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND operation_code = '$op_no'";
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
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and ops_dependency = $next_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						if($prev_operation>0)
						{
							$get_ops_dep = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and previous_operation = $prev_operation";
							$result_ops_dep = $link->query($get_ops_dep);
							   while($row_dep = $result_ops_dep->fetch_assoc())
							   {
								  $operations[] = $row_dep['operation_code'];
							   }
							   $emb_operations = implode(',',$operations);
						}
						$flag='parallel_scanning';
					}
			   
					//End Here
					else
					{
					  $ops_dep_flag = 0;
						$ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$job_number[1]' AND color =  '$maped_color' AND ops_dependency != 200 AND ops_dependency != 0";
						$result_ops_dep_qry = $link->query($ops_dep_qry);
						while($row = $result_ops_dep_qry->fetch_assoc())
						{
							if($row['ops_dependency'])
							{
								if($row['ops_dependency'] == $job_number[4])
								{
									$ops_dep_code = $row['operation_code'];
									$schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id =$ops_dep_code";
									$schedule_count_query = $link->query($schedule_count_query);
									if($schedule_count_query->num_rows > 0)
									{
										while($row = $schedule_count_query->fetch_assoc())
										{
											$recevied_qty = $row['recevied_qty'];
										}
										if($recevied_qty == 0)
										{
											$ops_dep_flag =1;
											$result_array['status'] = 'The dependency operations for this operation are not yet done.';
											echo json_encode($result_array);
											die();
										}
									}
								}
							}
						}
					}


				   
					//  if($next_operation < 0)
					// {
				   if($flag == 'parallel_scanning')
				   {
					   $flag = 'parallel_scanning';
					   $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code=$job_number[4]";
							
							$result_ops_seq_check = $link->query($ops_seq_check);
							
							if($result_ops_seq_check->num_rows > 0)
							{
								while($row = $result_ops_seq_check->fetch_assoc())
								{
									$ops_seq = $row['ops_sequence'];
									$seq_id = $row['id'];
									$ops_order = $row['operation_order'];
								}
							}
							else
							{
								$result_array['status'] = 'Invalid Operation for this Docket.Plese verify Operation Mapping.';
								echo json_encode($result_array);
								die();
							}
							
							$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
							$result_pre_ops_check = $link->query($pre_ops_check);
								while($row = $result_pre_ops_check->fetch_assoc())
								{
									$pre_ops_code = $row['operation_code'];
								}
								$category=['cutting','Send PF','Receive PF'];
								$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$job_number[4]'";
								$result_checking_qry = $link->query($checking_qry);
								while($row_cat = $result_checking_qry->fetch_assoc())
								{
									$category_act = $row_cat['category'];
								}
				   }
				   else
				   {
							$flags=0;
							$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code=$job_number[4]";
							//echo $ops_seq_check;
							$result_ops_seq_check = $link->query($ops_seq_check);
							if($result_ops_seq_check->num_rows > 0)
							{
								while($row = $result_ops_seq_check->fetch_assoc())
								{
									$ops_seq = $row['ops_sequence'];
									$seq_id = $row['id'];
									$ops_order = $row['operation_order'];
								}
							}
							else
							{
								$result_array['status'] = 'Invalid Operation for this Docket.Plese verify Operation Mapping.';
								echo json_encode($result_array);
								die();
							}

							$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN  (10,200) ORDER BY operation_order DESC LIMIT 1";
							//echo $pre_ops_check;
							$result_pre_ops_check = $link->query($pre_ops_check);
							if($result_pre_ops_check->num_rows > 0)
							{
								while($row = $result_pre_ops_check->fetch_assoc())
								{
									$pre_ops_code = $row['operation_code'];
								}
								$category=['cutting','Send PF','Receive PF'];
								$checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
								$result_checking_qry = $link->query($checking_qry);
								while($row_cat = $result_checking_qry->fetch_assoc())
								{
									$category_act = $row_cat['category'];
								}
								if(in_array($category_act,$category))
								{
									$emb_cut_check_flag = 1;
								}
								if($emb_cut_check_flag != 1)
								{
									$pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM  $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $pre_ops_code";
									$result_pre_ops_validation = $link->query($pre_ops_validation);
									while($row = $result_pre_ops_validation->fetch_assoc())
									{
										$recevied_qty_qty = $row['recevied_qty'];
									}
									if($recevied_qty_qty == 0)
									{
										$flags = 2;
									}
									else
									{
										$schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
										$flag = 'bundle_creation_data';
									}
								}
								else
								{
									$schedule_count_query = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_number[0]' AND operation_id =$job_number[4]";
									$schedule_count_query = $link->query($schedule_count_query);
									if($schedule_count_query->num_rows > 0)
									{
										$schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
										$flags=3;
										$flag = 'bundle_creation_data';
									}
								   
								}
							}
							else
							{
								$schedule_count_query = "SELECT bundle_number FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_number[0]' AND operation_id =$job_number[4]";
								$schedule_count_query = $link->query($schedule_count_query);
								if($schedule_count_query->num_rows > 0)
								{
									$schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,`recevied_qty` as reported_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] order by tid";
									$flags=3;
									$flag = 'bundle_creation_data';
								}
						   
							}
				  }  
					 if($flag == 'parallel_scanning')
					 {
						 //get min qty of previous operations
						$qry_min_prevops="SELECT MIN(recevied_qty) AS min_recieved_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND size_title = '$sizes' AND operation_id in ($emb_operations)";
						$result_qry_min_prevops = $link->query($qry_min_prevops);
						while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc())
						{
							$previous_minqty=$row_result_min_prevops['min_recieved_qty'];
						}
						
						$schedule_query = "SELECT `style` as order_style_no,`schedule` as order_del_no,`send_qty`,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,`original_qty` as carton_act_qty,sum(recevied_qty) AS current_recieved_qty,`rejected_qty` as rejected_qty,((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'parallel_scanning' as flag,size_id as old_size,remarks, mapped_color,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND operation_id = '$job_number[4]' and size_title='$sizes' order by tid";
						$flags=3;
						$flag = 'parallel_scanning';
						   
					 }
					if($flags == 2)
					{
						$result_array['status'] .= 'Previous operation not yet done for this job.';
						echo json_encode($result_array);
						die();
					}
				   
					else
					{
						// echo $schedule_query;
						$result_style_data = $link->query($schedule_query);
						$select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_number[0]'";
						$result_select_modudle_qry = $link->query($select_modudle_qry);
						while($row = $result_select_modudle_qry->fetch_assoc())
						{
							$module = $row['input_module'];
						}
						while($row = $result_style_data->fetch_assoc())
						{       
						 
							$style = $job_number[1];
							$schedule =  $job_number[2];
							$color = $job_number[3];
							$size = $sizes;
						   
							$b_job_no = $row['input_job_no_random'];
							$b_style= $row['order_style_no'];
							$b_schedule=$row['order_del_no'];
							$b_colors[]=$row['order_col_des'];
							$b_sizes[] = $row['size_code'];
							$b_size_code[] = $row['old_size'];
							$size_ims = $row['size_code'];
							$b_doc_num[]=$row['doc_no'];
							$doc_value = $row['doc_no'];
							$b_in_job_qty[]=$row['carton_act_qty'];

							if($flag == 'parallel_scanning')
							{
								$current_ops_qty=$row['balance_to_report'];
								$parallel_balance_report=($previous_minqty-$current_ops_qty);
								
								if($parallel_balance_report>0)
								{
								   
								  $b_rep_qty[]=$parallel_balance_report;
						   
								}
							}  
							$b_rep_qty[]=$row['balance_to_report'];
							$b_rej_qty[]=0;
							$b_op_id = $op_no;
							$b_tid[] = $row['tid'];
							$b_inp_job_ref[] = $row['input_job_no'];
							$b_a_cut_no[] = $row['acutno'];
							if($flag == 'bundle_creation_data')
							{
							$b_remarks[] = $row['remarks'];
							}
							$b_shift = $shift;
							if($flag == 'bundle_creation_data'){
								$mapped_color = $row['mapped_color'];
								$b_module[] = $row['assigned_module'];
							}else{
								$mapped_color = $row['order_col_des'];
								$b_module[] = $module;
							}
							$result_array['table_data'][] = $row;
						}
					}
					$result_array['flag'] = $flag;
					$table_name = $result_array['flag'];
					$style = $result_array['style'];
					$schedule = $result_array['schedule'];
					$color = $result_array['color_dis'];
					$table_data = $result_array['table_data'];

					// checking ops ..............................................

					$dep_ops_array_qry = "select operation_code,ops_sequence, default_operration,smv,manual_smv from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and operation_code=$b_op_id";
					$result_dep_ops_array_qry = $link->query($dep_ops_array_qry);
					while($row = $result_dep_ops_array_qry->fetch_assoc())
					{
						$sequnce = $row['ops_sequence'];
						$is_m3 = $row['default_operration'];
						$sfcs_smv = $row['smv'];
						if($sfcs_smv=='0.0000')
						{
						$sfcs_smv = $row_ops['manual_smv'];
						}
					}
				   
					$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
					$result_ops_dep_qry = $link->query($ops_dep_qry);
					while($row = $result_ops_dep_qry->fetch_assoc())
					{
						$ops_dep = $row['ops_dependency'];
					}
					if($ops_dep){
						$dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' and ops_dependency=$ops_dep";
					   
						$result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
						while($row = $result_dep_ops_array_qry_raw->fetch_assoc())
						{
							$dep_ops_codes[] = $row['operation_code'];
						}
					}
				   
					$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$mapped_color' and operation_code=$b_op_id";
					$result_ops_seq_check = $link->query($ops_seq_check);
					while($row = $result_ops_seq_check->fetch_assoc())
					{
						$ops_seq = $row['ops_sequence'];
						$seq_id = $row['id'];
						$ops_order = $row['operation_order'];
					}
				   
					if($ops_dep)
					{
						$dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
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
						$ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$b_style' AND color = '$mapped_color' AND operation_code in (".implode(',',$ops_dep_ary).")";
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
					$pre_ops_check = "SELECT tm.operation_code as operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN brandix_bts.`tbl_orders_ops_ref` tr ON tr.id=tm.operation_name WHERE style='$b_style' AND color = '$mapped_color' and (ops_sequence = '$ops_seq' or ops_sequence in  (".implode(',',$ops_seq_dep).")) AND  tr.category  IN ('sewing') AND tm.operation_code != 200";
					//echo $pre_ops_check;
					$result_pre_ops_check = $link->query($pre_ops_check);
					if($result_pre_ops_check->num_rows > 0)
						{
						while($row_ops = $result_pre_ops_check->fetch_assoc())
						 {
							$pre_ops_code_temp[] = $row_ops['operation_code'];
						}
					}
					$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200,15) ORDER BY operation_order ASC LIMIT 1";
					$result_post_ops_check = $link->query($post_ops_check);
					if($result_post_ops_check->num_rows > 0)
					{
						while($row = $result_post_ops_check->fetch_assoc())
						{
							$post_ops_code = $row['operation_code'];
						}
					}
					foreach($pre_ops_code_temp as $index => $op_code)
					{
						if($op_code != $b_op_id)
						{
							$b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES";

							// temp table data query

							$b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `scanned_user`) VALUES";
						}
					}
					// insert or update based on table
					if($table_name == 'parallel_scanning')
					{
						if($category_act=='Send PF')
						{
							$cehck_status_qry="select recevied_qty as good_qty from $brandix_bts.bundle_creation_data where docket_number=$doc_no and operation_id=$prev_operation and size_title='$sizes'";
						}
						else
						{
							$cehck_status_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$doc_no and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
						}
						// echo $cehck_status_qry;
						// die();
						$check_qty_qry_result=mysqli_query($link,$cehck_status_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rowss=mysqli_fetch_array($check_qty_qry_result))
						{
							$statusopqty=$rowss['good_qty'];
						}
						
						if($category_act=='Send PF')
						{
							$check_googd_qty_qry="select good_qty from $bai_pro3.emb_bundles where barcode='$barcode'";
						}
						else
						{
							$check_googd_qty_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$doc_no and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
						}
						$check_googd_qty_qry_rslt=mysqli_query($link,$check_googd_qty_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rowss=mysqli_fetch_array($check_googd_qty_qry_rslt))
						{
							$goodqty=$rowss['good_qty'];
						}
						if($goodqty>0)
						{
							$embquantity=$goodqty-$rejctedqty;
						}
						else
						{
							$embquantity=$embquantity;
						}
						
						if($statusopqty>0)
						{
							if($docstatus==0 || $docstatus=='' ||  $docstatus==2)
							{
									$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id =$b_op_id";
									$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
								   
									if($schedule_count_query->num_rows > 0)
									{
										$schedule_count = true;
									}else{
										$schedule_count = false;
									}
								   
									 foreach ($b_tid as $key => $tid)
									{
										if($b_tid[$key] == $bundle_no)
										{
											
										  $smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
												$result_smv_query = $link->query($smv_query);
												while($row_ops = $result_smv_query->fetch_assoc())
												{
													$sfcs_smv = $row_ops['smv'];
													if($sfcs_smv=='0.0000')
													{
													$sfcs_smv = $row_ops['manual_smv'];
													}
												}
												$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

												$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`) VALUES";
											   
												$remarks_code = "";                            
												$select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty, left_over FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
												$result_select_send_qty = $link->query($select_send_qty);
												if($result_select_send_qty->num_rows >0)
												{
													while($row = $result_select_send_qty->fetch_assoc())
													{
														$b_old_rep_qty_new = $row['recevied_qty'];
														$b_old_rej_qty_new = $row['rejected_qty'];
														$b_left_over_qty = $row['left_over'];
														$b_send_qty = $row['send_qty'];

													}
												}
													$final_rep_qty = $parallel_balance_report;

													$final_rej_qty = $b_old_rej_qty_new;

													$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
													// LAST STEP MODIFIED
													$left_over_qty_update = $b_send_qty - $final_rep_qty;

													$previously_scanned = $parallel_balance_report;
																			  
													if($schedule_count){
														$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+'".$embquantity."',`rejected_qty`=rejected_qty+'".$rejctedqty."' ,`left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
													   
														$result_query = $link->query($query) or exit('query error in updating');
													}else{
														   
														$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$embquantity.'","'.$rejctedqty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';  
														$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
													}
													
													//getting data form embellishment_plan_dashboard
													$quanforembdash=$embquantity+$rejctedqty;
													$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and send_op_code=$b_op_id";
													$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
													while($qry_row=mysqli_fetch_array($check_qry_result))
													{
														$sendop_code=$qry_row['send_op_code'];
													}
													$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and receive_op_code=$b_op_id";
													$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
													while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
													{
														$recop_code=$qry_rec_row['receive_op_code'];
													}
													if($sendop_code==$b_op_id)
													{
														//update in emblishment dashboard
														$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$quanforembdash where doc_no =$b_doc_num[$key] and send_op_code=$b_op_id";
														$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
													}
													if($recop_code==$b_op_id)
													{
														//update in emblishment dashboard
														$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$quanforembdash where doc_no =$b_doc_num[$key] and receive_op_code=$b_op_id";
														$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
													}
													//checking data exist in emb_bundles or not
													$check_data_qry="select * from $bai_pro3.emb_bundles where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
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
														$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty='$embquantity',status=1,reject_qty='$rejctedqty',update_time='".date("Y-m-d H:i:s")."' where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
														$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

														//insert data into emb_bundles_temp
														$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$b_doc_num[$key]."','".$b_sizes[$key]."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$embquantity."','".$rejctedqty."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$clubstatus."','".$username."','".$tranid."','".$status."')";
														$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
														}
													}
													// else
													// {
													// insert data into emb_bundles

													// }

													if($result_query)
													{
														if($b_rep_qty[$key] > 0)
														{
															$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_send_qty.'","'.$embquantity .'","'.$rejctedqty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';  
															$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');
															if($gate_pass_no>0)
															{
															$sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$b_rep_qty[$key]."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-1')";
															$result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');

															}
															$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$previous_minqty where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code=$b_op_id";
															$update_qry_cps_log_res = $link->query($update_qry_cps_log);
														   
															$update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$previous_minqty where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code = $pre_ops_code";   
															$update_cps_log_res = $link->query($update_pre_qty);
														}
													}
													
														if($post_ops_code != null)
														{
															$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+'".$embquantity."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$post_ops_code;
															$result_query = $link->query($query_post) or exit('query error in updating');
															
														}
														if($ops_dep)
														{
															$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
															$result_pre_send_qty = $link->query($pre_send_qty_qry);
															while($row = $result_pre_send_qty->fetch_assoc())
															{
																$pre_recieved_qty = $row['recieved_qty'];
															}

															$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` =send_qty+ '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$ops_dep;

															$result_query = $link->query($query_post_dep) or exit('query error in updating');
												   
														}                
												   

																	   
										}
									   
									}
									
									
									
									
									if($rejctedqty>0)
									{
									
											$b_remarks  = '';
											
											$actual_rejection_reason_array_string = array();
											foreach($rej_data as $reason_key=>$reason_value)
											{   
												//to get form type
												$rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
												$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
												while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
												{
													$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
													$type = $rowresult_rejection_code_fetech_qry['form_type'];
												}
												$bundle_individual_number=$bundle_no;
												$remain_qty_key=$reason_key;
												$remain_qty_value=$reason_value;
												if($reason_value > 0)
												{   
													$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
													$remarks_code = $reason_code.'-'.$reason_value;
													$remarks_var = $module.'-'.$shift.'-'.$type;
													$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
													$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$maped_color.'","'.$username.'","'.date('Y-m-d').'","'.$sizes.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$doc_no.'","'.$input_job_no_random.'","'. $b_op_id.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
													$rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
													//updating BCD
													
													
												}
											}


											//update rejections to M3 trasactions
											if(sizeof($actual_rejection_reason_array_string) > 0)
											{
												for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
													{
														$r_qty = array();
														$r_reasons = array();
														$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
														$r_qty[] = $implode_next[2];
														$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
														$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
															while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
															{
																$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
															}
														//$r_reasons[] = $m3_reason_code;
														$b_tid = $implode_next[0];
														//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
														$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $b_op_id";
														$bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
															while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
															{
																$bcd_id = $bcd_id_row['id'];
																$style = $bcd_id_row['style'];
																$schedule = $bcd_id_row['schedule'];
																$color = $bcd_id_row['color'];
																$doc_no = $bcd_id_row['docket_number'];
																$size_title = $bcd_id_row['size_title'];
																$size_id = $bcd_id_row['size_id'];
																$assigned_module = $bcd_id_row['assigned_module'];
																$input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
																$doc_value = $bcd_id_row['docket_number'];
															}
														//searching the bcd_id in rejection log child or not
														$bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
														$bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
														if($bcd_id_searching_qry_result->num_rows > 0)
														{
															while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
															{
																$parent_id = $bcd_id_searching_qry_result_row['parent_id'];
															}
															$update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
															mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
															$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$job_number[1]' and schedule='$job_number[2]' and color='$maped_color'";
															$update_qry_rej_lg = $link->query($update_qry_rej_lg);
														}
														else
														{
															$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$job_number[1]' and schedule='$job_number[2]' and color='$maped_color'";
															// echo $search_qry;
															$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
															if($result_search_qry->num_rows > 0)
															{
																while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
																{
																	$rejection_log_id = $row_result_search_qry['id'];
																	$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
																	// echo $update_qry_rej_lg;
																	$update_qry_rej_lg = $link->query($update_qry_rej_lg);
																	$parent_id = $rejection_log_id;
																}

															}
															else
															{
																$insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$job_number[1]','$job_number[2]','$maped_color',$implode_next[2],'0',$implode_next[2])";
																$res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
																$parent_id=mysqli_insert_id($link);
															}
															$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$b_op_id)";
															$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
														}
														//inserting into rejections_reason_track'
														if($implode_next[2] > 0)
														{
															$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
															$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
															//updating this to cps log
															// if($b_op_id)
															// {
																//getting dependency operation
																// $parellel_ops=array();
																// $qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$maped_color' and ops_dependency='$b_op_id'";
																// $qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
																// if($qry_parellel_ops_result->num_rows > 0){
																	// while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
																	// { 
																		// $parellel_ops[] = $row_prellel['operation_code'];
																	// }
																// }
																// if($ops_cps_updat>0){
																	// if(sizeof($parellel_ops)>0){
																		// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code in (".implode(',',$parellel_ops).")";
																	// }else{
																		// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code = $ops_cps_updat";
																	// }
																	// $update_qry_cps_log_res = $link->query($update_qry_cps_log);
																// }	
																
															// }
														}
														updateM3TransactionsRejections($b_tid,$b_op_id,$r_qty,$m3_reason_code);
														updateM3Transactions($b_tid,$b_op_id,$embquantity);
													}
											}
									
									}
									else
									{
										updateM3Transactions($b_tid[0],$b_op_id,$embquantity);
									}
									
									
									
									
									
									
									
									
									
									//updating into  m3 transactions for positives
									// for($i=0;$i<sizeof($b_tid);$i++)
									// {
									// $updation_m3 = updateM3Transactions($b_tid[$i],$b_op_id,$embquantity);
									// }
									$result_array['bundle_no'] = $doc_no;
									$result_array['op_no'] = $op_no;
									$result_array['size'] = $sizes;
									$result_array['reported_qty'] = $embquantity;
									$result_array['rejected_qty'] = $rejctedqty;
									$result_array['bunno'] = $seqno;
									$result_array['date_n'] = date("Y-m-d H:i:s");
									echo json_encode($result_array);
									die();
									
							}
							else
							{
								$result_array['status'] = 'Already Scanned';
								echo json_encode($result_array);
								die();
							}
						}
						else
						{
							$result_array['status'] = 'Previous Operation Not Done';
							echo json_encode($result_array);
							die();
						}
					}
				   
					else
					{
						$query = '';
				   
						if($table_name == 'bundle_creation_data')
						{
							if($category_act=='Send PF' || $category_act=='Receive PF')
							{
								$cehck_status_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$doc_no and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
							}
							else
							{
								$cehck_status_qry="select send_qty as good_qty from $brandix_bts.bundle_creation_data where docket_number=$doc_no and operation_id=$b_op_id and size_title='$sizes'";
							}
							$check_qty_qry_result=mysqli_query($link,$cehck_status_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($rowss=mysqli_fetch_array($check_qty_qry_result))
							{
								$statusopqty=$rowss['good_qty'];
							}
							
							$check_googd_qty_qry="select good_qty from $bai_pro3.emb_bundles where doc_no=$doc_no and ops_code=$pre_ops_code and size='$sizes' and tran_id=$seqno";
							$check_googd_qty_qry_rslt=mysqli_query($link,$check_googd_qty_qry) or exit("while retriving data from emb_bundles".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($rowss=mysqli_fetch_array($check_googd_qty_qry_rslt))
							{
								$goodqty=$rowss['good_qty'];
							}
							if($goodqty>0)
							{
								$embquantity=$goodqty-$rejctedqty;
							}
							else
							{
								$embquantity=$embquantity;
							}
							
							
								if($statusopqty>0)
								{
									if($docstatus==0 || $docstatus=='' || $docstatus==2)
									{
										$schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$b_job_no' AND operation_id =$b_op_id";

										$schedule_count_query = $link->query($schedule_count_query) or exit('query error');
									   
										if($schedule_count_query->num_rows > 0)
										{
											$schedule_count = true;
										}else{
											$schedule_count = false;
										}
										$concurrent_flag = 0;
										foreach ($b_tid as $key => $tid)
										{
											if($b_tid[$key] == $bundle_no){
												if($concurrent_flag == 0)
												{
													$smv_query = "select smv,manual_smv from $brandix_bts.tbl_style_ops_master where style='$b_style' and color='$mapped_color' and operation_code = $b_op_id";
													$result_smv_query = $link->query($smv_query);
													while($row_ops = $result_smv_query->fetch_assoc())
													{
														$sfcs_smv = $row_ops['smv'];
														if($sfcs_smv=='0.0000')
														{
														$sfcs_smv = $row_ops['manual_smv'];
														}
													}
													$bulk_insert_post = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";

													$bulk_insert_post_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `scanned_user`) VALUES";

													$remarks_code = "";                            
													$select_send_qty = "SELECT (send_qty+recut_in+replace_in)as send_qty, recevied_qty,rejected_qty, left_over FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $b_tid[$key] AND operation_id = $b_op_id";
										   
													$result_select_send_qty = $link->query($select_send_qty);
													if($result_select_send_qty->num_rows >0)
													{
														while($row = $result_select_send_qty->fetch_assoc())
														{
															$b_old_rep_qty_new = $row['recevied_qty'];
															$b_old_rej_qty_new = $row['rejected_qty'];
															$b_left_over_qty = $row['left_over'];
															$b_send_qty = $row['send_qty'];

														}
													}
														$final_rep_qty = $b_old_rep_qty_new + $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new);

														$final_rej_qty = $b_old_rej_qty_new;

														$left_over_qty = $b_in_job_qty[$key] - $final_rep_qty - $final_rej_qty;
														// LAST STEP MODIFIED
														$left_over_qty_update = $b_send_qty - $final_rep_qty;

														$previously_scanned = $b_send_qty - ($b_old_rep_qty_new + $b_old_rej_qty_new);
													   

														// if($previously_scanned == 0){
															// if($b_send_qty == $b_old_rej_qty_new){
																// $result_array['status'] = 'This Bundle Qty Is Completely Rejected';
															// }else{
																// $result_array['status'] = 'Already Scanned';
															// }
															// echo json_encode($result_array);
															// die();
														// }
														if($schedule_count){
															$query = "UPDATE $brandix_bts.bundle_creation_data SET `recevied_qty`= recevied_qty+'".$embquantity."',`rejected_qty`=rejected_qty+'".$rejctedqty."', `left_over`= '".$left_over_qty_update."' , `scanned_date`='". date('Y-m-d')."' where bundle_number =$b_tid[$key] and operation_id = ".$b_op_id;
		   
															$result_query = $link->query($query) or exit('query error in updating');
														}else{
															   
															$bulk_insert_post .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_in_job_qty[$key].'","'.$embquantity.'","'.$rejctedqty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'")';
															$result_query_001 = $link->query($bulk_insert_post) or exit('bulk_insert_post query error in updating');
														}
														
														//getting data form embellishment_plan_dashboard
														$quanforembdash=$embquantity+$rejctedqty;
														
														$get_data_embd_send_qry="select send_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and send_op_code=$b_op_id";
														$check_qry_result=mysqli_query($link,$get_data_embd_send_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
														while($qry_row=mysqli_fetch_array($check_qry_result))
														{
															$sendop_code=$qry_row['send_op_code'];
														}
														$get_data_embd_rec_qry="select receive_op_code from $bai_pro3.embellishment_plan_dashboard where doc_no=$b_doc_num[$key] and receive_op_code=$b_op_id";
														$check_qry_rec_result=mysqli_query($link,$get_data_embd_rec_qry) or exit("while retriving data from embellishment_plan_dashboard".mysqli_error($GLOBALS["___mysqli_ston"]));
														while($qry_rec_row=mysqli_fetch_array($check_qry_rec_result))
														{
															$recop_code=$qry_rec_row['receive_op_code'];
														}
														if($sendop_code==$b_op_id)
														{
															//update in emblishment dashboard
															$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `send_qty`= send_qty+$quanforembdash where doc_no =$b_doc_num[$key] and send_op_code=$b_op_id";
															$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
														}
														if($recop_code==$b_op_id)
														{
															//update in emblishment dashboard
															$embellishment_plan_dashboard_qry = "UPDATE $bai_pro3.embellishment_plan_dashboard SET `receive_qty`= receive_qty+$quanforembdash where doc_no =$b_doc_num[$key] and receive_op_code=$b_op_id";
															$embellishment_plan_dashboard_result = $link->query($embellishment_plan_dashboard_qry) or exit('Embellishment Plan Dashboard query receive error');
														}
														
														//checking data exist in emb_bundles or not
														$check_data_qry="select * from $bai_pro3.emb_bundles where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
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
														$update_emb_bundles="UPDATE $bai_pro3.emb_bundles SET good_qty=$embquantity,status=1,reject_qty='$rejctedqty',update_time='".date("Y-m-d H:i:s")."' where doc_no='$b_doc_num[$key]' and ops_code='$b_op_id' and size='$b_sizes[$key]' and tran_id=$seqno";
																								//echo $update_emb_bundles;
														$result_query = $link->query($update_emb_bundles) or exit('query error in updating emb_bundles');

														//insert data into emb_bundles_temp
														$insert_emb_bundles="INSERT INTO $bai_pro3.emb_bundles_temp(doc_no,  size,    ops_code,  barcode,  quantity,  good_qty,  reject_qty,  insert_time,  update_time,  club_status,  log_user,  tran_id,  status) VALUES ('".$b_doc_num[$key]."','".$b_sizes[$key]."','".$b_op_id."','".$barcodeno."','".$orgqty."','".$embquantity."','".$rejctedqty."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$clubstatus."','".$username."','".$tranid."','".$status."')";
														$result_emb_temp = $link->query($insert_emb_bundles) or exit('error while insert into emb_bundles_temp');
														}
														}
														// else
														// {
														// insert data into emb_bundles

														// }
														if($result_query)
														{
															if($b_rep_qty[$key] > 0)
															{
																$bulk_insert_post_temp .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors[$key].'","'.$b_size_code[$key].'","'. $b_sizes[$key].'","'. $sfcs_smv.'","'.$b_tid[$key].'","'.$b_in_job_qty[$key].'","'.$b_send_qty.'","'.$embquantity .'","'.$rejctedqty.'","'.$left_over_qty.'","'. $b_op_id.'","'.$b_doc_num[$key].'","'.date('Y-m-d').'","'.$b_a_cut_no[$key].'","'.$b_inp_job_ref[$key].'","'.$b_job_no.'","'.$b_shift.'","'.$b_module[$key].'","'.$b_remarks[$key].'","'.$username.'")';
																$result_query_001_temp = $link->query($bulk_insert_post_temp) or exit('bulk_insert_post query error in updating');

															if($gate_pass_no>0)
															{
															$sql_gate="insert into $brandix_bts.`gatepass_track` (`gate_id`, `bundle_no`, `bundle_qty`, `style`, `schedule`, `color`, `size`,operation_id) values ('".$gate_pass_no."', ".$b_tid[$key].", '".$previously_scanned."', '".$b_style."','".$b_schedule."','".$b_colors[$key]."','".$b_sizes[$key]."','".$b_op_id."-4')";
															$result_sql_temp = $link->query($sql_gate) or exit('Gate_pass_child query error in updating');

															}

																if($emb_cut_check_flag == 1)
																{
																	$update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty+$quanforembdash-$rejctedqty where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code = $b_op_id";
																	$update_qry_cps_log_res = $link->query($update_qry_cps_log);
																	
																	$update_pre_qty= "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$quanforembdash where doc_no = '".$b_doc_num[$key]."' and size_title='". $b_sizes[$key]."' AND operation_code = $pre_ops_code";
																	$update_cps_log_res = $link->query($update_pre_qty);
																}
															}
														}
													   
														if($post_ops_code != null)
														{
															$query_post = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` = send_qty+'".$embquantity."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$post_ops_code;
															$result_query = $link->query($query_post) or exit('query error in updating');
														}
														if($ops_dep)
														{
															$pre_send_qty_qry = "select min(recevied_qty)as recieved_qty from $brandix_bts.bundle_creation_data where bundle_number =$b_tid[$key] and operation_id in (".implode(',',$dep_ops_codes).")";
															$result_pre_send_qty = $link->query($pre_send_qty_qry);
															while($row = $result_pre_send_qty->fetch_assoc())
															{
																$pre_recieved_qty = $row['recieved_qty'];
															}

															$query_post_dep = "UPDATE $brandix_bts.bundle_creation_data SET `send_qty` =send_qty+ '".$pre_recieved_qty."', `scanned_date`='". date('Y-m-d')."' where docket_number =$b_doc_num[$key] and size_title='$sizes' and operation_id = ".$ops_dep;

															$result_query = $link->query($query_post_dep) or exit('query error in updating');
												   
														}                
												}
											}
										   
										}
										if($concurrent_flag == 1)
										{
											echo "<h1 style='color:red;'>You are Scanning More than eligible quantity.</h1>";
										}
										
									
										
								if($rejctedqty>0)
								{
									$b_remarks  = '';
									$actual_rejection_reason_array_string = array();
										foreach($rej_data as $reason_key=>$reason_value)
										{   
											//to get form type
											$rejection_code_fetech_qry = "select reason_code,form_type from $bai_pro3.bai_qms_rejection_reason where sno= '$reason_key'";
											$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
											while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
											{
												$reason_code = $rowresult_rejection_code_fetech_qry['reason_code'];
												$type = $rowresult_rejection_code_fetech_qry['form_type'];
											}
											$bundle_individual_number=$bundle_no;
											$remain_qty_key=$reason_key;
											$remain_qty_value=$reason_value;
											if($reason_value > 0)
											{   
												$actual_rejection_reason_array_string[] =  $bundle_individual_number.'-'.$remain_qty_key.'-'. $remain_qty_value ;
												$remarks_code = $reason_code.'-'.$reason_value;
												$remarks_var = $module.'-'.$shift.'-'.$type;
												$bulk_insert_rej = "INSERT INTO $bai_pro3.bai_qms_db(`qms_style`, `qms_schedule`,`qms_color`,`log_user`, `log_date`, `qms_size`, `qms_qty`, `qms_tran_type`,`remarks`, `ref1`, `doc_no`, `input_job_no`, `operation_id`, `qms_remarks`, `bundle_no`) VALUES";
												$bulk_insert_rej .= '("'.$b_style.'","'.$b_schedule.'","'.$maped_color.'","'.$username.'","'.date('Y-m-d').'","'.$sizes.'","'.$remain_qty_value.'","3","'.$remarks_var.'","'.$remarks_code.'","'.$doc_no.'","'.$input_job_no_random.'","'. $b_op_id.'","'. $b_remarks.'","'.$bundle_individual_number.'")';
												$rej_insert_result = $link->query($bulk_insert_rej) or exit('data error');
												//updating BCD
												
												
											}
										}

										
										//update rejections to M3 trasactions
										if(sizeof($actual_rejection_reason_array_string) > 0)
										{
											for($i=0;$i<sizeof($actual_rejection_reason_array_string);$i++)
												{
													$r_qty = array();
													$r_reasons = array();
													$implode_next = explode('-',$actual_rejection_reason_array_string[$i]);
													$r_qty[] = $implode_next[2];
													$rejection_code_fetech_qry = "select m3_reason_code from $bai_pro3.bai_qms_rejection_reason where sno= $implode_next[1]";
													$result_rejection_code_fetech_qry = $link->query($rejection_code_fetech_qry);
														while($rowresult_rejection_code_fetech_qry = $result_rejection_code_fetech_qry->fetch_assoc()) 
														{
															$m3_reason_code = $rowresult_rejection_code_fetech_qry['m3_reason_code'];
														}
													//$r_reasons[] = $m3_reason_code;
													$b_tid = $implode_next[0];
													//retreving bcd id from bundle_ceration_data and inserting into the rejection_log table and rejection_log_child
													$bcd_id_qry = "select id,style,schedule,color,docket_number,size_title,size_id,assigned_module,input_job_no_random_ref from $brandix_bts.bundle_creation_data where bundle_number=$bundle_no and operation_id = $b_op_id";
													$bcd_id_qry_result=mysqli_query($link,$bcd_id_qry) or exit("Bcd id qry".mysqli_error($GLOBALS["___mysqli_ston"]));
														while($bcd_id_row=mysqli_fetch_array($bcd_id_qry_result))
														{
															$bcd_id = $bcd_id_row['id'];
															$style = $bcd_id_row['style'];
															$schedule = $bcd_id_row['schedule'];
															$color = $bcd_id_row['color'];
															$doc_no = $bcd_id_row['docket_number'];
															$size_title = $bcd_id_row['size_title'];
															$size_id = $bcd_id_row['size_id'];
															$assigned_module = $bcd_id_row['assigned_module'];
															$input_job_random_ref = $bcd_id_row['input_job_no_random_ref'];
															$doc_value = $bcd_id_row['docket_number'];
														}
													//searching the bcd_id in rejection log child or not
													$bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
													$bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
													if($bcd_id_searching_qry_result->num_rows > 0)
													{
														while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
														{
															$parent_id = $bcd_id_searching_qry_result_row['parent_id'];
														}
														$update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
														mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
														$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$job_number[1]' and schedule='$job_number[2]' and color='$maped_color'";
														$update_qry_rej_lg = $link->query($update_qry_rej_lg);
													}
													else
													{
														$search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$job_number[1]' and schedule='$job_number[2]' and color='$maped_color'";
														// echo $search_qry;
														$result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
														if($result_search_qry->num_rows > 0)
														{
															while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
															{
																$rejection_log_id = $row_result_search_qry['id'];
																$update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
																// echo $update_qry_rej_lg;
																$update_qry_rej_lg = $link->query($update_qry_rej_lg);
																$parent_id = $rejection_log_id;
															}

														}
														else
														{
															$insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$job_number[1]','$job_number[2]','$maped_color',$implode_next[2],'0',$implode_next[2])";
															$res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
															$parent_id=mysqli_insert_id($link);
														}
														$inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$b_op_id)";
														$insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
													}
													//inserting into rejections_reason_track'
													if($implode_next[2] > 0)
													{
														$insert_into_rejections_reason_track = "INSERT INTO $bai_pro3.`rejections_reason_track` (`parent_id`,`date_time`,`bcd_id`,`rejected_qty`,`rejection_reason`,`username`,`form_type`) values ($parent_id,DATE_FORMAT(NOW(), '%Y-%m-%d %H'),$bcd_id,'$implode_next[2]','$implode_next[1]','$username','$type')";
														$insert_into_rejections_reason_track_res =$link->query($insert_into_rejections_reason_track);
														//updating this to cps log
														// if($b_op_id)
														// {
															//getting dependency operation
															// $parellel_ops=array();
															// $qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$b_style' and color = '$maped_color' and ops_dependency='$b_op_id'";
															// $qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
															// if($qry_parellel_ops_result->num_rows > 0){
																// while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
																// { 
																	// $parellel_ops[] = $row_prellel['operation_code'];
																// }
															// }
															// if($ops_cps_updat>0){
																// if(sizeof($parellel_ops)>0){
																	// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code in (".implode(',',$parellel_ops).")";
																// }else{
																	// $update_qry_cps_log = "update $bai_pro3.cps_log set remaining_qty=remaining_qty-$implode_next[2] where doc_no = $doc_value and size_title='$size_title' AND operation_code = $ops_cps_updat";
																// }
																// $update_qry_cps_log_res = $link->query($update_qry_cps_log);
															// }	
															
														// }
													}
													updateM3TransactionsRejections($b_tid,$b_op_id,$r_qty,$m3_reason_code);
													updateM3Transactions($b_tid,$b_op_id,$embquantity);
													
												}
										}
										
								}
								else{
									updateM3Transactions($b_tid[0],$b_op_id,$embquantity);
								}								
																		
										
										
										
										
										
										
										
										
										
										
										
										
										
										
										//updating into  m3 transactions for positives
										// for($ii=0;$ii<sizeof($b_tid);$ii++)
										// {
										// $updation_m3 = updateM3Transactions($b_tid[$ii],$b_op_id,$embquantity);
										// }
										$result_array['bundle_no'] = $doc_no;
										$result_array['op_no'] = $op_no;
										$result_array['size'] = $sizes;
										$result_array['reported_qty'] = $embquantity;
										$result_array['rejected_qty'] = $rejctedqty;
										$result_array['bunno'] = $seqno;
										$result_array['date_n'] = date("Y-m-d H:i:s");
										echo json_encode($result_array);
										die();
										
								}
								else
								{
									$result_array['status'] = 'Already Scanned';
									echo json_encode($result_array);
									die();
								}
							}
							else
							{
								$result_array['status'] = 'Previous Operation Not Done';
								echo json_encode($result_array);
								die();
							}
						}
					}
				   
						
				   
				}
				getjobdetails1($string,$bundle_no,$op_no,$shift,$gate_id,$embquantity,$seqno,$doc_no,$sizes,$docstatus,$rejctedqty,$rej_data);
	}
}
else
{
	$result_array['status'] = 'Please Plan Embellishment For This Dockets';
	echo json_encode($result_array);
	die();
}
?>