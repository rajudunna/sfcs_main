<?php
//plan bundles generation
function plan_cut_bundle($docket_no) 
{	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
 	$category=['cutting','Send PF','Receive PF'];
	$operation_codes = array();
	$cut_done_qty = array();
	$plan_size_cut = array();
	
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = $docket_no ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		$org_doc = $row['org_doc_no'];
        $order_tid = $row['order_tid'];
        $plies_per_cut = $row['p_plies'];
		$get_exact_size_code = "SELECT * FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid = '".$order_tid."'";
		$sql_query_size_code = mysqli_query($link,$get_exact_size_code) or exit("Issue while selecting the Bai_order_db");
		while($row_size=mysqli_fetch_array($sql_query_size_code))
		{
			$b_style =  $row_size['order_style_no'];
			$b_schedule =  $row_size['order_del_no'];
			$b_colors =  $row_size['order_col_des'];
			
			for($ii=0;$ii<sizeof($sizes_array);$ii++)
			{
				if($row_size["title_size_".$sizes_array[$ii].""]<>"")
				{
					$check_upto[]=$sizes_array[$ii];
					$size_title[$sizes_array[$ii]] = $row_size["title_size_".$sizes_array[$ii].""];
				}
			}
		}			
		
		for ($i=0; $i < sizeof($check_upto); $i++)
		{ 
			if ($row['p_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['p_'.$sizes_array[$i]] * $row['p_plies'];
				$plan_size_cut[$sizes_array[$i]] = $row['p_'.$sizes_array[$i]];
			}
			else
			{
				$cut_done_qty[$sizes_array[$i]] =0;
				$plan_size_cut[$sizes_array[$i]] =0;
			}
		}
	}
				
	$fetching_ops_with_category = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$b_style' AND color='$b_colors' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') and tsm.operation_code<>10 GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit("Issue while selecting the Operations");
	while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
	{
		$operation_codes[] = $row['operation_code'];			
	}	
	$bundle_no=1;
	foreach($cut_done_qty as $key => $value)
	{
		if($value>0)
		{			
			$b_size_code = $key;
			$b_sizes = $size_title[$key];			
			$ratio_number = $plan_size_cut[$key];
			for($m = $ratio_number; $m > 0; $m--)
			{					
				$barcode='PCB-'.$docket_no.'-'.$bundle_no;				
				// Plan Cut Bundle
				$plan_cut_insert_query = "insert into $bai_pro3.plan_cut_bundle(`doc_no`,`style`,`schedule`,`color`,`size_code`,`size`,`bundle_no`,`plies`,`barcode`,`tran_user`) values (".$docket_no.",'".$b_style."','".$b_schedule."','".$b_colors."','".$b_size_code."','".$b_sizes."',".$bundle_no.",".$plies_per_cut.",'".$barcode."','".$username."')";
				$plan_cut_insert_query_res = $link->query($plan_cut_insert_query);
				$plan_cut_insert_id = mysqli_insert_id($link);
				foreach($operation_codes as $index => $op_code)
				{
					// Plan Cut Bundle Trn
					$plan_cut_insert_transactions_query = "insert into $bai_pro3.plan_cut_bundle_trn(`plan_cut_bundle_id`,`ops_code`,`original_qty`,`tran_user`,`status`) values (".$plan_cut_insert_id.",".$op_code.",".$plies_per_cut.",'".$username."',0)";
					$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);			
				}
				$bundle_no++;
			}
		}
	}
}

function plan_logical_bundles($doc_list,$plan_jobcount,$plan_bundleqty,$inserted_id,$schedule,$cut) 
{	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$doc_list_new = explode(",",$doc_list);
	$cut_new = explode(",",$cut);
	$sql1="select order_tid from $bai_pro3.plandoc_stat_log where doc_no=".$doc_list_new[0]."";
	$sql_result1=mysqli_query($link, $sql1) or exit("Issue while Selecting Bai_orders".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1 = mysqli_fetch_array($sql_result1))
	{
		$order_tid = $sql_row1['order_tid'];
	}	
	// Getting Order
	$get_exact_size_code = "SELECT * FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid = '".$order_tid."'";
	$sql_query_size_code = mysqli_query($link,$get_exact_size_code) or exit("Issue while selecting the Bai_order_db");
	while($row_size=mysqli_fetch_array($sql_query_size_code))
	{
		$destination = $row_size['destination'];
		$style = $row_size['order_style_no'];
		$color = $row_size['order_col_des'];
		for($ii=0;$ii<sizeof($sizes_array);$ii++)
		{
			if($row_size["title_size_".$sizes_array[$ii].""]<>"")
			{
				$check_upto[]=$sizes_array[$ii];
				$order_qty[$sizes_array[$ii]] = $row_size["order_s_".$sizes_array[$ii].""];
				$size_title[$sizes_array[$ii]] = $row_size["title_size_".$sizes_array[$ii].""];
			}
		}
	}
	$category='sewing';
	$operation_codes = array();
	$fetching_ops_with_category1 = "SELECT tsm.operation_code AS operation_code,tsm.m3_smv AS smv FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category='".$category."' GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat1 = mysqli_query($link,$fetching_ops_with_category1) or exit("Issue while Selecting Operaitons");
	while($row1=mysqli_fetch_array($result_fetching_ops_with_cat1))
	{
		$operation_codes[] = $row1['operation_code'];				
		$smv[$row1['operation_code']] = $row1['smv'];				
	}
	
	// Getting Plan
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE order_tid = '".$order_tid."' order by doc_no desc";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		$dockets[]=$row['doc_no'];
		$docket_cut[$row['doc_no']]=$row['pcutno'];
		for ($i=0; $i < sizeof($check_upto); $i++)
		{ 
			if ($row['p_'.$sizes_array[$i]] > 0)
			{
				$cut_plan_qty[$sizes_array[$i]] += $row['p_'.$sizes_array[$i]] * $row['p_plies'];
				$cut_plan_docket[$row['doc_no']][$sizes_array[$i]] = $row['p_'.$sizes_array[$i]] * $row['p_plies'];
			}			
		}
	}
	// Get Diffrence between Order and Plan
	for($s=0;$s<sizeof($check_upto);$s++)
	{		
		if($order_qty[$sizes_array[$s]]>0)
		{
			if($order_qty[$sizes_array[$s]]>$cut_plan_qty[$sizes_array[$s]])
			{
				$pending_plan[$sizes_array[$s]]=$order_qty[$sizes_array[$s]]-$cut_plan_qty[$sizes_array[$s]];
			}
			else
			{
				$excess[$sizes_array[$s]]=$cut_plan_qty[$sizes_array[$s]]-$order_qty[$sizes_array[$s]];				
			}
		}
	}
	
	$usage_from_plan_id=array();
	if(sizeof($excess)>0)
	{	
		//Getting Samples
		$qry_sample_qty_check_qry = "SELECT * FROM $bai_pro3.sp_sample_order_db WHERE order_tid = '".$order_tid."'";
		$result_qry_sample_qty_check_qry = $link->query($qry_sample_qty_check_qry);
		if(mysqli_num_rows($result_qry_sample_qty_check_qry)>0)
		{
			while($row_sample = $result_qry_sample_qty_check_qry->fetch_assoc()) 
			{
				for ($i=0; $i < sizeof($check_upto); $i++)
				{ 
					$samp_qty[$row_sample['sizes_ref']] = $row_sample['input_qty'];							
				}
			}
		}
				
		// Verifying from whcih docket we need remove execess & Samples
		for($s=0;$s<sizeof($dockets);$s++)
		{
			for($ss=0;$ss<sizeof($check_upto);$ss++)
			{		
				if($excess[$sizes_array[$ss]]>0 && $cut_plan_docket[$dockets[$s]][$sizes_array[$ss]]>0)
				{
					if($excess[$sizes_array[$ss]]<$cut_plan_docket[$dockets[$s]][$sizes_array[$ss]])
					{
						$remove_from_excess[$dockets[$s]][$sizes_array[$ss]] = $excess[$sizes_array[$ss]];
						$excess[$sizes_array[$ss]]=0;
					}
					else
					{
						$remove_from_excess[$dockets[$s]][$sizes_array[$ss]]=$cut_plan_docket[$dockets[$s]][$sizes_array[$ss]];
						$excess[$sizes_array[$ss]]=$excess[$sizes_array[$ss]]-$cut_plan_docket[$dockets[$s]][$sizes_array[$ss]];
					}
					$remaval_dockets[]=$dockets[$s];
				}
			}
		}
		
		// Verifying from whcih docket we need remove Samples
		if(sizeof($samp_qty)>0)
		{
			for($s=0;$s<sizeof($dockets);$s++)
			{
				for($ss=0;$ss<sizeof($check_upto);$ss++)
				{		
					if($remove_from_excess[$dockets[$s]][$sizes_array[$ss]]>0 && $samp_qty[$sizes_array[$ss]]>0)
					{
						if($samp_qty[$sizes_array[$ss]]<$remove_from_excess[$dockets[$s]][$sizes_array[$ss]])
						{
							$remove_from_sample[$dockets[$s]][$sizes_array[$ss]] = $samp_qty[$sizes_array[$ss]];
							$samp_qty[$sizes_array[$ss]]=0;
							$remove_from_excess[$dockets[$s]][$sizes_array[$ss]]= $remove_from_excess[$dockets[$s]][$sizes_array[$ss]] - $samp_qty[$sizes_array[$ss]];
						}
						else
						{
							$remove_from_sample[$dockets[$s]][$sizes_array[$ss]]=$remove_from_excess[$dockets[$s]][$sizes_array[$ss]];
							$samp_qty[$sizes_array[$ss]]=$samp_qty[$sizes_array[$ss]]-$remove_from_excess[$dockets[$s]][$sizes_array[$ss]];
							$remove_from_excess[$dockets[$s]][$sizes_array[$ss]]=0;
						}
						$remaval_dockets[]=$dockets[$s];
					}
				}
			}
		}		
		$remaval_dockets=array_values(array_unique($remaval_dockets));		
		//get input job number for each schedule
		$old_jobs_count_qry = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.pac_stat_log_input_job WHERE schedule='".$schedule."'";
		$old_jobs_count_res = mysqli_query($link, $old_jobs_count_qry) or exit("Issue while Selecting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($old_jobs_count_res)>0)
		{
			while($max_oldqty_jobcount = mysqli_fetch_array($old_jobs_count_res))
			{
				if($max_oldqty_jobcount['result'] > 0) 
				{
					$input_job_num=$max_oldqty_jobcount['result'];
				} 
				else 
				{
					$input_job_num=1;
				}
			}
		} 
		else 
		{
			$input_job_num=1;
		}
		
		foreach($remaval_dockets as $key => $docket_no)
		{
			if(in_array($docket_no,$doc_list_new))
			{
				for($i=0;$i<sizeof($check_upto);$i++)
				{	
					$plan_cut_bundle_qry = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no=$docket_no and size_code='".$sizes_array[$i]."' order by id desc";
					$plan_cut_bundle_res = mysqli_query($link, $plan_cut_bundle_qry) or exit("Issue while Selecting PCB".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($plan_cut_bundle_row = mysqli_fetch_array($plan_cut_bundle_res))
					{
						$plan_cut_bundle_id = $plan_cut_bundle_row['id'];						
						$sizes[$plan_cut_bundle_id] = $plan_cut_bundle_row['size'];
						$size_codes[$plan_cut_bundle_id] = $plan_cut_bundle_row['size_code'];
						$size_plies = $plan_cut_bundle_row['plies'];
						
						do 
						{							
							if($remove_from_sample[$docket_no][$sizes_array[$i]]>0)
							{							
								if($size_plies >= $remove_from_sample[$docket_no][$sizes_array[$i]])
								{
									$usage_from_plan_id[$plan_cut_bundle_id] +=$remove_from_sample[$docket_no][$sizes_array[$i]];
									$fill_qty[$plan_cut_bundle_id][3] = $remove_from_sample[$docket_no][$sizes_array[$i]];
									$size_plies=$size_plies-$remove_from_sample[$docket_no][$sizes_array[$i]];
									$remove_from_sample[$docket_no][$sizes_array[$i]]=0;									
								} 
								else 
								{
									$usage_from_plan_id[$plan_cut_bundle_id] +=$size_plies;
									$fill_qty[$plan_cut_bundle_id][3] = $size_plies;
									$remove_from_sample[$docket_no][$sizes_array[$i]]=$remove_from_sample[$docket_no][$sizes_array[$i]]-$size_plies;
									$size_plies=0;									 		
								}
								$plan_ids[]=$plan_cut_bundle_id;
							}
							else if($remove_from_excess[$docket_no][$sizes_array[$i]]>0) 
							{
								if($size_plies >= $remove_from_excess[$docket_no][$sizes_array[$i]])
								{
									$usage_from_plan_id[$plan_cut_bundle_id] +=$remove_from_excess[$docket_no][$sizes_array[$i]];
									$fill_qty[$plan_cut_bundle_id][2] = $remove_from_excess[$docket_no][$sizes_array[$i]];
									$size_plies=$size_plies-$remove_from_excess[$docket_no][$sizes_array[$i]];
									$remove_from_excess[$docket_no][$sizes_array[$i]]=0;									
								} 
								else 
								{
									$usage_from_plan_id[$plan_cut_bundle_id] +=$size_plies;
									$fill_qty[$plan_cut_bundle_id][2] = $size_plies;
									$remove_from_excess[$docket_no][$sizes_array[$i]]=$remove_from_excess[$docket_no][$sizes_array[$i]]-$size_plies;
									$size_plies=0;									 		
								}
								$plan_ids[]=$plan_cut_bundle_id;
							}							
						}while ($size_plies > 0 && $remove_from_sample[$docket_no][$sizes_array[$i]]>0 && $remove_from_excess[$docket_no][$sizes_array[$i]]>0);						
					}	
				}
				$plan_ids=array_values(array_unique($plan_ids));
				// Executing the Bundles		
				for($j=2;$j<4;$j++) 
				{				
					$bundle_seq=1;
					$input_job_no=$input_job_num;
					$input_job_num_rand=$schedule.date("ymd").$input_job_no;
					for($jj=0;$jj<sizeof($plan_ids);$jj++)
					{
						if($fill_qty[$plan_ids[$jj]][$j]>0)
						{
							$barcode="SPB-".$docket_no."-".$input_job_no."-".$bundle_seq."";
							//Plan Logical Bundle				
							$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job`(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,plan_cut_bundle_id,barcode_sequence,tran_user,barcode,style,color,schedule,tran_ts,type_of_sewing)VALUES(".$docket_no.", '".$sizes[$plan_ids[$jj]]."', ".$fill_qty[$plan_ids[$jj]][$j].", '".$input_job_no."', '".$input_job_num_rand."', '".$destination."', 1, '".$size_codes[$plan_ids[$jj]]."','N', '-1', $inserted_id, $plan_ids[$jj],$bundle_seq,'".$username."','".$barcode."','".$style."','".$color."','".$schedule."','".date('Y-m-d H:i:s')."',$j)";
							//echo $ins_qry."<br>";
							$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
							$pac_tid= mysqli_insert_id($link);
							foreach($operation_codes as $index => $op_code)
							{
								$send_qty = 0;
								if($index == 0) {
									$send_qty = $fill_qty[$plan_ids[$jj]][$j];
								}
								//Plan Logical Bundle Trn
								$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','". $size_codes[$plan_ids[$jj]]."','".$sizes[$plan_ids[$jj]]."','". $smv[$op_code]."',".$pac_tid.",".$fill_qty[$plan_ids[$jj]][$j].",".$send_qty.",0,0,0,".$op_code.",'".$docket_no."','".date('Y-m-d H:i:s')."', '".$username."','".$docket_cut[$docket_no]."','".$input_job_num."','".$input_job_num_rand."','','','Normal','".$color."',".$bundle_seq.",'".$barcode."')";
								mysqli_query($link, $b_query) or exit("Issue in inserting BCD".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							$barcode='';
							$bundle_seq++;							
						}
					}
					$input_job_num++;					
				}
				unset($plan_ids);
			}			
		}	
	}
		
	foreach($doc_list_new as $key_list => $dono)
	{
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
		$doc_type = 'N';
		$packing_mode = 1;
		//get input job number for each schedule
		$old_jobs_count_qry1 = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.pac_stat_log_input_job WHERE schedule='".$schedule."'";
		$old_jobs_count_res1 = mysqli_query($link, $old_jobs_count_qry1) or exit("Issue while Selecting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($old_jobs_count_res1)>0)
		{
			while($max_oldqty_jobcount1 = mysqli_fetch_array($old_jobs_count_res1))
			{
				if($max_oldqty_jobcount1['result'] > 0) 
				{
					$input_job_num=$max_oldqty_jobcount1['result'];
				} 
				else 
				{
					$input_job_num=1;
				}
			}
		} 
		else 
		{
			$input_job_num=1;
		}		
		$barcode='';
		$cut_no[$key_list]=$cut_new[$key_list];
		$shift='';
		$module=0;
		$bundle_cum_qty=0;
		$bundle_seq=1;
		$plan_jobcount1= $plan_jobcount;
		$input_job_num_rand=$schedule.date("ymd").$input_job_num;
		$plan_cut_bundle_qry = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no=$dono";
		$plan_cut_bundle_res = mysqli_query($link, $plan_cut_bundle_qry) or exit("Issue while Selecting PCB".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($plan_cut_bundle_res)>0)
		{        
			while($plan_cut_bundle_row = mysqli_fetch_array($plan_cut_bundle_res))
			{								
				$size = $plan_cut_bundle_row['size'];
				$size_code = $plan_cut_bundle_row['size_code'];
				$plan_cut_bundle_id = $plan_cut_bundle_row['id'];
				$size_plies = $plan_cut_bundle_row['plies'];
				
				if($usage_from_plan_id[$plan_cut_bundle_id]>0)
				{
					$size_plies = $size_plies-$usage_from_plan_id[$plan_cut_bundle_id];
				}			
				
				do 
				{
					if($size_plies > 0)
					{
						if($size_plies >= $plan_bundleqty)
						{
							$logic_qty = $plan_bundleqty;
						} 
						else 
						{
							$logic_qty = $size_plies;
						}
						
						$bundle_cum_qty=$logic_qty+$bundle_cum_qty;
						
						if($plan_jobcount1 < $bundle_cum_qty)
						{
							$input_job_num++;
							$bundle_cum_qty=0;
							$bundle_seq=1;
							$bundle_cum_qty=$logic_qty+$bundle_cum_qty;
							$input_job_num_rand=$schedule.date("ymd").$input_job_num;
						}
						$barcode="SPB-".$dono."-".$input_job_num."-".$bundle_seq."";
						//Plan Logical Bundle				
						$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` 				(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,plan_cut_bundle_id,barcode_sequence,tran_user,barcode,style,color,schedule,tran_ts)VALUES(".$dono.", '".$size."', ".$logic_qty.", '".$input_job_num."', '".$input_job_num_rand."', '".$destination."', '".$packing_mode."', '".$size_code."','".$doc_type."', '-1', $inserted_id, $plan_cut_bundle_id,$bundle_seq,'".$username."','".$barcode."','".$style."','".$color."','".$schedule."','".date('Y-m-d H:i:s')."')";
						$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
						$pac_tid= mysqli_insert_id($link);
						foreach($operation_codes as $index => $op_code)
						{
							$send_qty = 0;
							if($index == 0) {
								$send_qty = $logic_qty;
							}
							//Plan Logical Bundle Trn
							$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','". $size_code."','".$size."','". $smv[$op_code]."',".$pac_tid.",".$logic_qty.",".$send_qty.",0,0,0,".$op_code.",'".$dono."','".date('Y-m-d H:i:s')."', '".$username."','".$cut_no[$key_list]."','".$input_job_num."','".$input_job_num_rand."','".$shift."','".$module."','Normal','".$color."',".$bundle_seq.",'".$barcode."')";
							mysqli_query($link, $b_query) or exit("Issue in inserting BCD".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						$barcode='';
						$size_plies = $size_plies - $logic_qty;
						$count++;
						$bundle_seq++;
					}
				}while ($size_plies > 0);   
			}			
			// update count of plan logical bundles for each sewing job
			$update_query = "UPDATE `bai_pro3`.`sewing_jobs_ref` set bundles_count = $count where id = $inserted_id";
			$update_result = mysqli_query($link,$update_query) or exit("Problem while inserting to sewing jobs ref");
		}		
	}
	return true;
}


function plan_logical_bundles_pac_based($inserted_id){
	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$list = array();
	$list1 = array();
	$complete_list;
	$pcb_list = array();
	$complete_pcb_list;
	$count=0;
	$shift='';
	$module=0;
	$spb_input_job_no_random='';
	$doc_no='';
	$size_code='';
	$tid_list=array();

	$get_doc_list_query = "SELECT DISTINCT(tid) as tids FROM  bai_pro3.pac_stat_log_input_job WHERE sref_id=$inserted_id  order by tid";
	// echo $get_doc_list_query;
	$get_doc_list_query_res=mysqli_query($link, $get_doc_list_query) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($doc_row=mysqli_fetch_array($get_doc_list_query_res)) 
	{ 
		$tid_list[]=$doc_row['tids'];
	}
	// var_dump($tid_list,'<br/>');

	$get_input_job_nums = "SELECT *,SUM(carton_act_qty) as carton_act_qty1 FROM  bai_pro3.pac_stat_log_input_job WHERE sref_id=$inserted_id GROUP BY input_job_no_random,old_size,doc_no ORDER BY tid";
	// echo $get_input_job_nums.'get_input_job_nums<br/>';
	$get_input_job_nums_res=mysqli_query($link, $get_input_job_nums) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($job_row = mysqli_fetch_array($get_input_job_nums_res)) 
	{ 
		$old_spb = $job_row['tid'];
		$spb_doc_no = $job_row['doc_no'];
		$spb_size_code = $job_row['size_code'];
		$max_carton_act_qty = $job_row['carton_act_qty'];
		$carton_act_qty = $job_row['carton_act_qty1'];
		$spb_input_job_no = $job_row['input_job_no'];
		$spb_input_job_no_random = $job_row['input_job_no_random'];
		$spb_destination = $job_row['destination'];
		$spb_packing_mode = $job_row['packing_mode'];
		$spb_old_size = $job_row['old_size'];
		$spb_doc_type = $job_row['doc_type'];
		$spb_type_of_sewing = $job_row['type_of_sewing'];
		$spb_sref_id = $job_row['sref_id'];
		$spb_pac_seq_no = $job_row['pac_seq_no'];
		$spb_barcode_sequence = $job_row['barcode_sequence'];
		$spb_mrn_status = $job_row['mrn_status'];
		$spb_bundle_print_status = $job_row['bundle_print_status'];
		$spb_bundle_print_time = $job_row['bundle_print_time'];
		$spb_tran_ts = $job_row['tran_ts'];
		$spb_bundle_print_time = $job_row['bundle_print_time'];
		$spb_tran_user = $job_row['tran_user'];

		// echo $max_carton_act_qty.'max_carton_act_qty<br/>';
		// echo $carton_act_qty.'carton_act_qty<br/>';

		$plan_cut_bundles="select * from $bai_pro3.plan_cut_bundle where doc_no = '".$spb_doc_no."' and size_code= '".$spb_old_size."'";
		if(sizeof($complete_pcb_list) != 0) {
			$plan_cut_bundles .= " and id not in ($complete_pcb_list)";
		}
		$plan_cut_bundles .= " order by size_code,doc_no";
		// echo $plan_cut_bundles.'plan_cut_bundles<br/>';
		$plan_cut_bundles_res=mysqli_query($link, $plan_cut_bundles) or exit("Issue while Selecting plan_cut_bundle".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($pcb_row = mysqli_fetch_array($plan_cut_bundles_res))
		{
			
			$pcb_id = $pcb_row['id'];
			
			// $query="select SUM(carton_act_qty) as count from $bai_pro3.pac_stat_log_input_job where plan_cut_bundle_id = '".$pcb_id."' group by plan_cut_bundle_id";
			// $query_res=mysqli_query($link, $query) or exit("Issue while Selecting pac_stat_log_input_job".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($query_row = mysqli_fetch_array($query_res))
			// {
			// 	$completed_qty = $query_row['count'];
			// }

			// if($completed_qty == $pcb_row['plies']){
			// 	break;
			// }
			$style = $pcb_row['style'];
			$schedule = $pcb_row['schedule'];
			$color = $pcb_row['color'];
			if($pcb_row['doc_no']==$doc_no && $pcb_row['size_code']==$size_code){
				if($pcb_plies == 0 || $pcb_plies == ''){
					$pcb_plies = $pcb_row['plies'];
				}
			} else {
				$pcb_plies = $pcb_row['plies'];
			}
			$doc_no = $pcb_row['doc_no'];
			$size_code = $pcb_row['size_code'];
			do {
				// if($carton_act_qty > 0){
					// echo $pcb_plies.'pcb_plies<br/>';
					// echo $carton_act_qty.'carton_act_qty<br/>';
					// echo $max_carton_act_qty.'max_carton_act_qty<br/>';

					if($pcb_plies >= $max_carton_act_qty){
						if($carton_act_qty > $max_carton_act_qty){
							$spb_qty = $max_carton_act_qty;
							// echo $spb_qty.'ifif<br/>';
						} else {
							$spb_qty = $carton_act_qty;
							// echo $spb_qty.'ifelse<br/>';
						}
					} else {
						if($carton_act_qty == 0){
							$spb_qty = 0;
							// echo $spb_qty.'elseif<br/>';
						} else {
							$spb_qty = $pcb_plies;
							// echo $spb_qty.'elseelse<br/>';
						}

					}
					if($spb_qty > 0){
						$spb_barcode = "SPB-".$spb_doc_no."-".$spb_input_job_no."-".$spb_barcode_sequence."";
				
						$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,plan_cut_bundle_id,barcode_sequence,tran_user,barcode,style,color,schedule,tran_ts)VALUES(".$spb_doc_no.", '".$spb_size_code."', ".$spb_qty.", '".$spb_input_job_no."', '".$spb_input_job_no_random."', '".$spb_destination."', '".$spb_packing_mode."', '".$spb_old_size."','".$spb_doc_type."', '$spb_pac_seq_no', $spb_sref_id, $pcb_id,$spb_barcode_sequence,'".$username."','".$spb_barcode."','".$style."','".$color."','".$schedule."','".date('Y-m-d H:i:s')."')";
						// echo $ins_qry.'ins_qry<br/>';
				
						$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
						$pac_tid= mysqli_insert_id($link);
						
		
						//operation details
						$category='sewing';
						$operation_codes = array();
						$fetching_ops_with_category1 = "SELECT tsm.operation_code AS operation_code,tsm.m3_smv AS smv FROM $brandix_bts.tbl_style_ops_master tsm 
						LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category='".$category."' GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
						$result_fetching_ops_with_cat1 = mysqli_query($link,$fetching_ops_with_category1) or exit("Issue while Selecting Operaitons");
						while($row1=mysqli_fetch_array($result_fetching_ops_with_cat1))
						{
							$operation_codes[] = $row1['operation_code'];				
							$smv[$row1['operation_code']] = $row1['smv'];				
						}
						foreach($operation_codes as $index => $op_code)
						{
							$send_qty = 0;
							if($index == 0) {
								$send_qty = $spb_qty;
							}
							//Plan Logical Bundle Trn
							$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','". $spb_old_size."','".$spb_size_code."','". $smv[$op_code]."',".$pac_tid.",".$spb_qty.",".$send_qty.",0,0,0,".$op_code.",'".$spb_doc_no."','".date('Y-m-d H:i:s')."', '".$username."','','".$spb_input_job_no."','".$spb_input_job_no_random."','".$shift."','".$module."','Normal','".$color."',".$spb_barcode_sequence.",'".$spb_barcode."')";
							// echo $b_query;
							mysqli_query($link, $b_query) or exit("Issue in inserting BCD".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
		
						$count++;
		
						$pcb_plies = $pcb_plies-$spb_qty;
						$carton_act_qty = $carton_act_qty-$spb_qty;
						// echo $pcb_plies.'pcb_plies<br/>';
						// echo $carton_act_qty.'carton_act_qty<br/>';

						if($pcb_plies==0){
							array_push($list, $old_spb);
							$complete_list = implode(", ",$list);
							array_push($list1, $pcb_id);
							$complete_pcb_list = implode(", ",$list1);
							// var_dump($complete_list,'complete_list<br/>');
							// var_dump($complete_pcb_list,'complete_pcb_list<br/>');
							
						}
					}
				// }
			} while($pcb_plies > 0 && $carton_act_qty >0);
		}
	}
	$update_query = "UPDATE `bai_pro3`.`sewing_jobs_ref` set bundles_count = $count where id = $inserted_id";
	// echo $update_query.'<br/>';
	$update_result = mysqli_query($link,$update_query) or exit("Problem while inserting to sewing jobs ref");
	$tid_list_final = implode(", ",$tid_list);
	
	$delete_old_spb = "delete from $bai_pro3.`pac_stat_log_input_job` where tid in ($tid_list_final)";
	// echo $delete_old_spb.'<br/>';
	$delete_old_spb_res=mysqli_query($link, $delete_old_spb) or exit("Issue in Deleting old SPB".mysqli_error($GLOBALS["___mysqli_ston"]));

}


function act_logical_bundles($doc_no,$schedule,$style,$color,$call_status)
{			
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$category=['cutting','Send PF','Receive PF'];
	
	$operation_codes = array();
	$fetching_ops_with_category = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') and tsm.operation_code<>10 GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit("Issue while selecting the Operations");
	while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
	{
		$operation_codes[] = $row['operation_code'];			
	}

	$operation_order='';
	$getting_ops_order = "SELECT tsm.operation_order AS operation_order FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tsm.operation_code=15 GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_getting_ops_order = mysqli_query($link,$getting_ops_order) or exit("Issue while selecting the Operations");
	while($row_order=mysqli_fetch_array($result_getting_ops_order))
	{
		$operation_order = $row_order['operation_order'];			
	}
	
	$next_operations = [];
	$next_operations_query =  "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') AND tsm.previous_operation=15 GROUP BY tsm.operation_code";
	$next_operations_result = mysqli_query($link, $next_operations_query);
	if(mysqli_num_rows($next_operations_result) > 1) 
	{
		while($row_seq_ops = mysqli_fetch_array($next_operations_result))
		{
			$next_operations[] = $row_seq_ops['operation_code'];
		}
	} 
	else 
	{
		$next_operations_query =  "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
		LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') and CAST(tsm.operation_order AS CHAR)> '$operation_order' GROUP BY tsm.operation_code ORDER BY tsm.operation_order limit 1";
		$next_operations_result = mysqli_query($link, $next_operations_query);
		while($row_seq_ops = mysqli_fetch_array($next_operations_result))
		{
			$next_operations[] = $row_seq_ops['operation_code'];
		}
	}
	$docketexisted="SELECT max(end_no) as start,count(*) as bundles from $bai_pro3.act_cut_bundle where docket=".$doc_no."";
	$docketexistedresult=mysqli_query($link,$docketexisted);
	while($row_act = mysqli_fetch_array($docketexistedresult))
	{
		if($row_act['bundles']==0)
		{
			$startno = 1;
			$bundle = 1;
		}
		else
		{		
			$startno = $row_act['start']+1;
			$bundle = $row_act['bundles']+1;
		}
	}
	
	$shade_seq_plies_array = [];
	$shade_seq= '';
	$docket_query="SELECT id,lay_seq,shade,plies FROM $bai_pro3.`docket_roll_alloc` where docket=".$doc_no." and plies>0 and status=0 order by lay_seq,shade asc";
	$docket_queryresult = mysqli_query($link,$docket_query);
	if(mysqli_num_rows($docket_queryresult) > 0)
	{
		while($row = mysqli_fetch_array($docket_queryresult))
		{
			$shade_seq = $row['shade'].'$'.$row['lay_seq'];
			if(!$shade_seq_plies_array[$shade_seq])
			{
				$shade_seq_plies_array[$shade_seq] = 0;
			}	
			$shade_seq_plies_array[$shade_seq] += $row['plies'];
			$udpate ="UPDATE $bai_pro3.`docket_roll_alloc` set status=1 where id =".$row['id']."";
			mysqli_query($link,$udpate);
		}
		//$shadebundleno=0;
		$endno=0;
		$update_qty=array();
		$get_det_qry="select size,id from $bai_pro3.plan_cut_bundle where doc_no=".$doc_no."";
		$get_det_qry_rslt= mysqli_query($link,$get_det_qry);
		if(mysqli_num_rows($get_det_qry_rslt)>0)
		{
			while($row_pcb = mysqli_fetch_array($get_det_qry_rslt))
			{					
				$size = $row_pcb['size'];
				$plan_id = $row_pcb['id'];
				foreach($shade_seq_plies_array as $shade_seq_key => $plies)
				{
					$shade_seq_values = explode('$', $shade_seq_key);
					$shade = $shade_seq_values[0];
					$lay_seq = $shade_seq_values[1];
					//$shadebundleno++;					
					$endno=($startno+$plies)-1;					
					//Actual Cut Bundle 
					$barcode="ACB-".$doc_no."-".$bundle."";
					if(sizeof($operation_codes)==1)
					{
						$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,act_qty,tran_user,bundle_order,act_good_qty)
						VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','".$barcode."','".$shade."',".$startno.",".$endno.",".$plies.",'".$username."',".$lay_seq.",".$plies.")";	
						$result= mysqli_query($link,$insert_docket_num_info);
						$id=mysqli_insert_id($link);
						$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,15,$plies,$plies,$plies,0,'$username',1,'".$barcode."-15')";
						$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
						
					}
					else
					{
						$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,act_qty,tran_user,bundle_order)
						VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','".$barcode."','".$shade."',".$startno.",".$endno.",".$plies.",'".$username."',".$lay_seq.")";	
						$result= mysqli_query($link,$insert_docket_num_info);
						$id=mysqli_insert_id($link);
						$update_qty[$size]+=$plies;
						$sizes_all[]=$size;
						$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,15,$plies,$plies,$plies,0,'$username',1,'".$barcode."-15')";
						$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
						
						//Actual Cut Bundle Trn	
						foreach($operation_codes as $index => $op_code)
						{
							if($op_code==15)
							{
								continue; 
							}
							else if(in_array($op_code,$next_operations))
							{
								$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,$op_code,$plies,$plies,0,0,'$username',0,'".$barcode."-".$op_code."')";
								$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
							}
							else
							{											
								$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,$op_code,0,$plies,0,0,'$username',0,'".$barcode."-".$op_code."')";
								$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
							}						
						}					
					}					
					$startno=$startno + $plies;
					$planplies=$planplies - $plies;
					$bundle++;
				}				
				//$bundle++;
				//$shadebundleno=0;							
			}
			/*
			if(sizeof($next_operations)>0)
			{
				$sizes_all=array_values(array_unique($sizes_all));
				for($jj=0;$jj<sizeof($sizes_all);$jj++)
				{
					for($j=0;$j<sizeof($next_operations);$j++)
					{
						$update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set send_qty = send_qty+".$update_qty[$sizes_all[$jj]]."
						WHERE size_title = '".$sizes_all[$jj]."' AND operation_id = ".$next_operations[$j]." AND docket_number = ".$doc_no."";
						mysqli_query($link,$update_bcd_query);
					}
				}	
			}
			*/			
		}			
	}
	
	if($call_status==2)
	{
		// Calling Actual fillings for Child Dockets
		act_logical_bundles_gen_club($doc_no,$style,$color);	
	}
}

// Creating Child dockets and creating Plan Cut Bundles for Child dockets
function plan_cut_bundle_gen_club($docket_no,$style,$color) 
{	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	
 	$category=['cutting','Send PF','Receive PF'];
	$operation_codes = array();
	$bundle_no=1;
	$fetching_ops_with_category = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') and tsm.operation_code<>10 GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit(message_sql());
	while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
	{
		$operation_codes[] = $row['operation_code'];			
	}
	
	$qry_cut_qty_check_qry = "SELECT cat_ref,cutno,order_tid,destination,order_del_no,size,SUM(qty) as qty FROM bai_pro3.mix_temp_desti WHERE doc_no = $docket_no GROUP BY order_del_no,size";
	$result_qry_cut_qty_check_qry = mysqli_query($link,$qry_cut_qty_check_qry) or exit(message_sql());
	while($row = mysqli_fetch_array($result_qry_cut_qty_check_qry)) 
	{
		$schedule[] = $row['order_del_no'];
		$destination[$row['order_del_no']] = $row['destination'];
		$order_tid[$row['order_del_no']] = $row['order_tid'];
		$cut = $row['cutno'];
		$cat_ref = $row['cat_ref'];
		$size=$row['size'];
		$fill_qty[$row['order_del_no']][$size] += $row['qty'];
	}
	
	$plan_cut = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no = $docket_no";
	$result_plan_cut = mysqli_query($link,$plan_cut) or exit(message_sql());
	while($row_plan_cut=mysqli_fetch_array($result_plan_cut))
	{
		$tot_plies =  $row_plan_cut['plies'];
		$plies =  $row_plan_cut['plies'];
		$size_code =  $row_plan_cut['size_code'];
		$row_plan_cut['size_code'];
		for($j=0;$j<sizeof($schedule);$j++)
		{
			$barcode='PCB-TEMP-'.$bundle_no;
			if($plies>0 && $fill_qty[$schedule[$j]][$size_code]>0)
			{
				if($fill_qty[$schedule[$j]][$size_code]>=$plies)
				{
					// Plan Cut Bundle
					$plan_cut_insert_query = "insert into $bai_pro3.plan_cut_bundle(`style`,`schedule`,`color`,`size_code`,`size`,`bundle_no`,`plies`,`barcode`,`tran_user`,`parent_docket_id`,`parent_plan_cut_bundle_id`) values ('".$row_plan_cut['style']."','".$schedule[$j]."','".$row_plan_cut['color']."','".$size_code."','".$row_plan_cut['size']."',".$bundle_no.",".$plies.",'".$barcode."','".$username."',".$docket_no.",".$row_plan_cut['id'].")";
					$result_qry_cut_qty_check_qry = mysqli_query($link,$plan_cut_insert_query) or exit(message_sql());
					$plan_cut_insert_id = mysqli_insert_id($link);					
					foreach($operation_codes as $index => $op_code)
					{
						// Plan Cut Bundle Trn
						$plan_cut_insert_transactions_query = "insert into $bai_pro3.plan_cut_bundle_trn(`plan_cut_bundle_id`,`ops_code`,`original_qty`,`tran_user`,`status`) values (".$plan_cut_insert_id.",".$op_code.",".$plies.",'".$username."',0)";
						$plan_cut_insert_transactions_query_res = mysqli_query($link,$plan_cut_insert_transactions_query) or exit(message_sql());			
					}	
					$fill_qty[$schedule[$j]][$size_code]=$fill_qty[$schedule[$j]][$size_code]-$plies;
					$plies=0;						
				}
				else
				{
					$plan_cut_insert_query = "insert into $bai_pro3.plan_cut_bundle(`style`,`schedule`,`color`,`size_code`,`size`,`bundle_no`,`plies`,`barcode`,`tran_user`,`parent_docket_id`,`parent_plan_cut_bundle_id`) values ('".$row_plan_cut['style']."','".$schedule[$j]."','".$row_plan_cut['color']."','".$size_code."','".$row_plan_cut['size']."',".$bundle_no.",".$fill_qty[$schedule[$j]][$size_code].",'".$barcode."','".$username."',".$docket_no.",".$row_plan_cut['id'].")";
					$result_qry_cut_qty_check_qry = mysqli_query($link,$plan_cut_insert_query) or exit(message_sql());
					$plan_cut_insert_id = mysqli_insert_id($link);					
					foreach($operation_codes as $index => $op_code)
					{
						// Plan Cut Bundle Trn
						$plan_cut_insert_transactions_query = "insert into $bai_pro3.plan_cut_bundle_trn(`plan_cut_bundle_id`,`ops_code`,`original_qty`,`tran_user`,`status`) values (".$plan_cut_insert_id.",".$op_code.",".$fill_qty[$schedule[$j]][$size_code].",'".$username."',0)";
						$plan_cut_insert_transactions_query_res = mysqli_query($link,$plan_cut_insert_transactions_query) or exit(message_sql());			
					}
					$plies=$plies-$fill_qty[$schedule[$j]][$size_code];
					$fill_qty[$schedule[$j]][$size_code]=0;
				}
				$bundle_no++;
			}
		}
	}
	
	// Creating Docket and updating
	$plan_cut_ratio = "SELECT id,SCHEDULE,size_code,size,plies FROM $bai_pro3.plan_cut_bundle WHERE parent_docket_id = $docket_no";
	$result_plan_cut_ratio = mysqli_query($link,$plan_cut_ratio) or exit(message_sql());
	while($row_result_plan_cut_ratio=mysqli_fetch_array($result_plan_cut_ratio))
	{
		$ids[]=$row_result_plan_cut_ratio['id'];
		$id=$row_result_plan_cut_ratio['id'];
		$plies=$row_result_plan_cut_ratio['plies'];
		$schedule[$id][$plies]=$row_result_plan_cut_ratio['SCHEDULE'];
		$size_code_avlue[$row_result_plan_cut_ratio['SCHEDULE']][$id][$plies]=$row_result_plan_cut_ratio['size_code'];		
		$plies_total[]=$row_result_plan_cut_ratio['plies'];
		$schedules[]=$row_result_plan_cut_ratio['SCHEDULE'];
	}
	
	$get_unique_plies=array_values(array_unique($plies_total));
	$get_unique_schedules=array_values(array_unique($schedules));
	for($i=0;$i<sizeof($get_unique_schedules);$i++)
	{
		$cut_no=$cut;
		for($ii=0;$ii<sizeof($get_unique_plies);$ii++)
		{
			for($iii=0;$iii<sizeof($ids);$iii++)
			{				
				if($size_code_avlue[$get_unique_schedules[$i]][$ids[$iii]][$get_unique_plies[$ii]]<>'')
				{
					$sizes_new[]= $size_code_avlue[$get_unique_schedules[$i]][$ids[$iii]][$get_unique_plies[$ii]];
					$ids_val[]= $ids[$iii];
					$sizecnt[$size_code_avlue[$get_unique_schedules[$i]][$ids[$iii]][$get_unique_plies[$ii]]] += 1;
				}				
			}
			
			if(sizeof($ids_val)>0)
			{
				$sizes_new=array_values(array_unique($sizes_new));
				$query_head_p='';
				$query_head_a='';
				$query_val_p='';
				$query_val_a='';
				// Constructing Query for Plandoc_stat_log
				for($j=0;$j<sizeof($sizes_new);$j++)
				{
					$query_head_p .= "p_".$sizes_new[$j].",";
					$query_head_a .= "a_".$sizes_new[$j].","; 
					$query_val_p .= $sizecnt[$sizes_new[$j]].",";
					$query_val_a .= $sizecnt[$sizes_new[$j]].",";
				}
				$plandoc_query="insert into $bai_pro3.plandoc_stat_log (date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,p_plies,a_plies,destination,org_doc_no,org_plies,ratio,remarks,$query_head_p $query_head_a pcutdocid) select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,'".$order_tid[$get_unique_schedules[$i]]."',".$cut_no.",".$cut_no.",".$get_unique_plies[$ii].",".$get_unique_plies[$ii].",'".$destination[$get_unique_schedules[$i]]."',doc_no,".$tot_plies.",ratio,remarks,$query_val_p $query_val_a pcutdocid 
				from $bai_pro3.plandoc_stat_log where cat_ref=$cat_ref and doc_no=".$docket_no;
				mysqli_query($link,$plandoc_query) or exit(message_sql());
				$docn=mysqli_insert_id($link);
				$update_plan_cut = "update $bai_pro3.plan_cut_bundle set doc_no = $docn where id in (".implode(",",$ids_val).")";
				mysqli_query($link,$update_plan_cut) or exit(message_sql());
				unset($ids_val);
				unset($sizes_new);
				unset($sizecnt);
				$cut_no++;
			}
		}
	}	
}

function act_logical_bundles_gen_club($doc_no,$style,$color)
{			
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$category=['cutting','Send PF','Receive PF'];
	
	$operation_codes = array();
	$fetching_ops_with_category = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') and tsm.operation_code<>10 GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit("Issue while selecting the Operations");
	while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
	{
		$operation_codes[] = $row['operation_code'];			
	}

	$operation_order='';
	$getting_ops_order = "SELECT tsm.operation_order AS operation_order FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tsm.operation_code=15 GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_getting_ops_order = mysqli_query($link,$getting_ops_order) or exit("Issue while selecting the Operations");
	while($row_order=mysqli_fetch_array($result_getting_ops_order))
	{
		$operation_order = $row_order['operation_order'];			
	}
	
	$next_operations = [];
	$next_operations_query =  "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') AND tsm.previous_operation=15 GROUP BY tsm.operation_code";
	$next_operations_result = mysqli_query($link, $next_operations_query);
	if(mysqli_num_rows($next_operations_result) > 1) 
	{
		while($row_seq_ops = mysqli_fetch_array($next_operations_result))
		{
			$next_operations[] = $row_seq_ops['operation_code'];
		}
	} 
	else 
	{
		$next_operations_query =  "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
		LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') and CAST(tsm.operation_order AS CHAR)> '$operation_order' GROUP BY tsm.operation_code ORDER BY tsm.operation_order limit 1";
		$next_operations_result = mysqli_query($link, $next_operations_query);
		while($row_seq_ops = mysqli_fetch_array($next_operations_result))
		{
			$next_operations[] = $row_seq_ops['operation_code'];
		}
	}
		
	$plan_cut_bundles="SELECT id,plies,parent_plan_cut_bundle_id,id,size,style,color,doc_no from $bai_pro3.plan_cut_bundle where parent_docket_id=".$doc_no."";
	$plan_cut_bundle_result=mysqli_query($link,$plan_cut_bundles);
	while($plan_cut_row = mysqli_fetch_array($plan_cut_bundle_result))
	{
		$plan_ids[]=$plan_cut_row['parent_plan_cut_bundle_id'];
		$plan_child_ids[]=$plan_cut_row['id'];
		$plan_qty[$plan_cut_row['id']]=$plan_cut_row['plies'];
		$parent_id[$plan_cut_row['id']]=$plan_cut_row['parent_plan_cut_bundle_id'];
		$size_val[$plan_cut_row['id']]=$plan_cut_row['size'];
		$style_val[$plan_cut_row['id']]=$plan_cut_row['style'];
		$color_val[$plan_cut_row['id']]=$plan_cut_row['color'];
		$docket_val[$plan_cut_row['id']]=$plan_cut_row['doc_no'];
		$tot_docs[]=$plan_cut_row['doc_no'];
	}
	
	
	$plan_ids=array_values(array_unique($plan_ids));	
	$tot_docs=array_values(array_unique($tot_docs));	
	$act_cut_bundles_1="SELECT plan_cut_bundle_id,act_qty from $bai_pro3.act_cut_bundle where plan_cut_bundle_id in (".implode(",",$plan_ids).")";
	$act_cut_bundles_result_1=mysqli_query($link,$act_cut_bundles_1);
	if(mysqli_num_rows($act_cut_bundles_result_1)>0)
	{
		while($act_cut_row_1 = mysqli_fetch_array($act_cut_bundles_result_1))
		{
			$parent_act_qty[$act_cut_row_1['plan_cut_bundle_id']]+=$act_cut_row_1['act_qty'];		
		}
	}
	
	if(array_sum($parent_act_qty)>0)
	{
		$act_cut_bundles="SELECT plan_cut_bundle_id,act_qty from $bai_pro3.act_cut_bundle where plan_cut_bundle_id in (".implode(",",$plan_child_ids).")";
		$act_cut_bundles_result=mysqli_query($link,$act_cut_bundles);
		if(mysqli_num_rows($act_cut_bundles_result)>0)
		{
			while($act_cut_row = mysqli_fetch_array($act_cut_bundles_result))
			{
				$act_qty[$act_cut_row['plan_cut_bundle_id']]+=$act_cut_row['act_qty'];		
			}
			
			//Getting filled Quantity from child to parent
			for($i=0;$i<sizeof($plan_child_ids);$i++)
			{
				$parent_fill_qty[$parent_id[$plan_child_ids[$i]]]+=$act_qty[$plan_child_ids[$i]];
			}
			
			//Child to Be Fill	
			for($iii=0;$iii<sizeof($plan_child_ids);$iii++)
			{
				$to_be_fill_qty[$plan_child_ids[$iii]]=$plan_qty[$plan_child_ids[$iii]]-$act_qty[$plan_child_ids[$iii]];
			}
			
			//Parent Need to Consider	
			for($ii=0;$ii<sizeof($plan_ids);$ii++)
			{
				$parent_usable_qty[$plan_ids[$ii]]=$parent_act_qty[$plan_ids[$ii]]-$parent_fill_qty[$plan_ids[$ii]];
			}		
		}
		else
		{
			//Parent Need to Consider	
			for($ii=0;$ii<sizeof($plan_ids);$ii++)
			{
				$parent_usable_qty[$plan_ids[$ii]]=$parent_act_qty[$plan_ids[$ii]];
			}
			
			//Child to Be Fill	
			for($iii=0;$iii<sizeof($plan_child_ids);$iii++)
			{
				$to_be_fill_qty[$plan_child_ids[$iii]]=$plan_qty[$plan_child_ids[$iii]];
			}
		}	
		$endno=0;
		$update_qty=array();
		for($k=0;$k<sizeof($plan_child_ids);$k++)
		{		
			
			if($to_be_fill_qty[$plan_child_ids[$k]]>0 && $parent_usable_qty[$parent_id[$plan_child_ids[$k]]]>0)
			{
				$docketexisted="SELECT max(end_no) as start,count(*) as bundles from $bai_pro3.act_cut_bundle where docket=".$docket_val[$plan_child_ids[$k]]."";
				$docketexistedresult=mysqli_query($link,$docketexisted);
				while($row_act = mysqli_fetch_array($docketexistedresult))
				{
					if($row_act['bundles']==0)
					{
						$startno = 1;
						$bundle = 1;
					}
					else
					{		
						$startno = $row_act['start']+1;
						$bundle = $row_act['bundles']+1;
					}
				}
				if($to_be_fill_qty[$plan_child_ids[$k]]<=$parent_usable_qty[$parent_id[$plan_child_ids[$k]]])
				{
					$plies=$to_be_fill_qty[$plan_child_ids[$k]];
					$parent_usable_qty[$parent_id[$plan_child_ids[$k]]]=$parent_usable_qty[$parent_id[$plan_child_ids[$k]]]-$to_be_fill_qty[$plan_child_ids[$k]];
					$to_be_fill_qty[$plan_child_ids[$k]]=0;
				}
				else
				{
					$plies=$parent_usable_qty[$parent_id[$plan_child_ids[$k]]];
					$parent_usable_qty[$parent_id[$plan_child_ids[$k]]]=0;
				}		
				$size = $size_val[$plan_child_ids[$k]];
				$style = $style_val[$plan_child_ids[$k]];
				$color = $color_val[$plan_child_ids[$k]];
				$doc_no = $docket_val[$plan_child_ids[$k]];
				$plan_id = $plan_child_ids[$k];
				
				$shade = '';
				$lay_seq = '';
				$endno=($startno+$plies)-1;					
				$barcode="ACB-".$doc_no."-".$bundle."";
				if(sizeof($operation_codes)==1)
				{
					$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,act_qty,tran_user,bundle_order,act_good_qty)
					VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','".$barcode."','".$shade."',".$startno.",".$endno.",".$plies.",'".$username."','".$lay_seq."',".$plies.")";
					$result= mysqli_query($link,$insert_docket_num_info);
					$id=mysqli_insert_id($link);
					$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,15,$plies,$plies,$plies,0,'$username',1,'".$barcode."-15')";
					$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
					
				}
				else
				{
					$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,act_qty,tran_user,bundle_order)
					VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','".$barcode."','".$shade."',".$startno.",".$endno.",".$plies.",'".$username."','".$lay_seq."')";
					$result= mysqli_query($link,$insert_docket_num_info);
					$id=mysqli_insert_id($link);
					$update_qty[$doc_no][$size]+=$plies;
					$sizes_all[]=$size;
					$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,15,$plies,$plies,$plies,0,'$username',1,'".$barcode."-15')";
					$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
					
					//Actual Cut Bundle Trn	
					foreach($operation_codes as $index => $op_code)
					{
						if($op_code==15)
						{
							continue; 
						}
						else if(in_array($op_code,$next_operations))
						{
							$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,$op_code,$plies,$plies,0,0,'$username',0,'".$barcode."-".$op_code."')";
							$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
						}
						else
						{											
							$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`send_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,$op_code,0,$plies,0,0,'$username',0,'".$barcode."-".$op_code."')";
							$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
						}						
					}					
				}					
			}				
		}
		/*
		$qty=0;
		if(sizeof($next_operations)>0)
		{
			$sizes_all=array_values(array_unique($sizes_all));
			for($j=0;$j<sizeof($tot_docs);$j++)
			{
				for($jj=0;$jj<sizeof($sizes_all);$jj++)
				{
					for($jjj=0;$jjj<sizeof($next_operations);$jjj++)
					{
						if($update_qty[$tot_docs[$j]][$sizes_all[$jj]]=='')
						{
							$qty=0;
						}
						else
						{
							$qty=$update_qty[$tot_docs[$j]][$sizes_all[$jj]];
						}					
						$update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set send_qty = send_qty+".$qty."
						WHERE size_title = '".$sizes_all[$jj]."' AND operation_id = ".$next_operations[$jjj]." AND docket_number = ".$tot_docs[$j]."";
						mysqli_query($link,$update_bcd_query);
					}
				}
			}		
		}
		*/
	}	
}

function plan_logical_bundles_recut($dono,$plan_jobcount,$plan_bundleqty,$job,$job_no,$schedule,$size_new) {
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	
	// var_dump($dono,'-dono<br/>');
	// var_dump($plan_jobcount,'-plan_jobcount<br/>');
	// var_dump($plan_bundleqty,'-plan_bundleqty<br/>');
	// var_dump($job_no,'-job_no<br/>');
	// var_dump($schedule,'-schedule<br/>');
	// // var_dump($cut,'-seq<br/>');
	// var_dump($size_new,'-size<br/>');
	$excess_tid = array();
	$list = array();
	$completed_list;
	
	$excess_doc_query = "select tid,input_job_no,sref_id from $bai_pro3.pac_stat_log_input_job where doc_no ='".$dono."' and doc_type='R' and type_of_sewing='2'";
	$excess_doc_query_res = mysqli_query($link, $excess_doc_query) or exit("issue in excess doc query".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($excess_doc_query_res_row = mysqli_fetch_array($excess_doc_query_res))
    {
		$excess_tid[] = $excess_doc_query_res_row['tid'];
	}
	$assigned_module_query = "select assigned_module from $brandix_bts.bundle_creation_data where input_job_no_random_ref ='".$job_no."'";
	$assigned_module_query_res = mysqli_query($link, $assigned_module_query) or exit("issue in excess doc query".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($assigned_module_query_res_row = mysqli_fetch_array($assigned_module_query_res))
    {
		$assigned_module = $assigned_module_query_res_row['assigned_module'];
	}
	// var_dump($excess_tid,'-excess_tid<br/>');
	// var_dump($input_job,'-input_job<br/>');
	// var_dump($sref_id,'-sref_id<br/>');
	
	$doc_type = 'N';
    $packing_mode = 1;
    $destination = '';	

	$sql1="select order_tid from $bai_pro3.plandoc_stat_log where doc_no=".$dono."";
    $sql_result1=mysqli_query($link, $sql1) or exit("Issue while Selecting Bai_orders".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1 = mysqli_fetch_array($sql_result1))
	{
		$order_tid = $sql_row1['order_tid'];
	}
    //get destination to fill logical bundle
    $sql="select destination,order_style_no,order_col_des from $bai_pro3.bai_orders_db_confirm where order_tid='".$order_tid."'";
    $sql_result=mysqli_query($link, $sql) or exit("Issue while Selecting Bai_orders".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row = mysqli_fetch_array($sql_result))
	{
		$destination = $sql_row['destination'];
		$style = $sql_row['order_style_no'];
		$color = $sql_row['order_col_des'];		
	}

	$sql121="SELECT MAX(mo_no)as mo_no FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_new' and 
	TRIM(schedule)='".trim($schedule)."' and TRIM(color)='".trim($color)."' 
	order by mo_no*1";
	$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1210=mysqli_fetch_array($result121)) 
	{
		$max_mo_no = $row1210['mo_no'];
	}

    $category='sewing';
	$operation_codes = array();
	$operation_names = array();
	$fetching_ops_with_category1 = "SELECT tsm.operation_code AS operation_code, tor.operation_name AS operation_name,tsm.m3_smv AS smv FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category='".$category."' GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat1 = mysqli_query($link,$fetching_ops_with_category1) or exit("Issue while Selecting Operaitons");
	// echo $fetching_ops_with_category1;
	while($row1=mysqli_fetch_array($result_fetching_ops_with_cat1))
	{
		$operation_codes[] = $row1['operation_code'];				
		$operation_names[] = $row1['operation_name'];				
		$smv[$row1['operation_code']] = $row1['smv'];				
	}
	
	$job_counter_tmp1= echo_title("$bai_pro3.packing_summary_input","MAX(barcode_sequence)+1","doc_no='".$dono."' and order_del_no",$schedule,$link);
	if ($job_counter_tmp1 > 1)
	{
		$bundle_seq = $job_counter_tmp1;
	} else{
		$bundle_seq = 1;
	}
	$barcode='';
	$bundle_cum_qty=0;
    $plan_jobcount1= $plan_jobcount;
	$input_job_num_rand=$job_no;
    $plan_cut_bundle_qry = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no=$dono and size='".$size_new."'";
    $plan_cut_bundle_res = mysqli_query($link, $plan_cut_bundle_qry) or exit("Issue while Selecting PCB".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($plan_cut_bundle_res)>0)
    {        
        while($plan_cut_bundle_row = mysqli_fetch_array($plan_cut_bundle_res))
        {
            $size = $plan_cut_bundle_row['size'];
            $size_code = $plan_cut_bundle_row['size_code'];
            $plan_cut_bundle_id = $plan_cut_bundle_row['id'];
			$size_plies = $plan_cut_bundle_row['plies'];

			$filled_plies=0;
			$filled_qry = "SELECT * FROM $bai_pro3.pac_stat_log_input_job WHERE plan_cut_bundle_id=$plan_cut_bundle_id";
			$filled_qry_res = mysqli_query($link, $filled_qry) or exit("Issue while Selecting PLB".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($filled_qry_res)>0)
			{
				while($filled_qry_res_row = mysqli_fetch_array($filled_qry_res))
        		{
					$filled_plies = $filled_qry_res_row['carton_act_qty'];
				}
			}
			$size_plies = $size_plies - $filled_plies;
			do 
			{
				if($plan_jobcount1 > 0){
					if($size_plies >= $plan_bundleqty)
					{
						$logic_qty = $plan_bundleqty;
					} 
					else 
					{
						$logic_qty = $size_plies;
					}
					// echo $plan_jobcount1.'$plan_jobcount1<br/>';
					// echo $logic_qty.'$logic_qty<br/>';
					if($plan_jobcount1 <= $logic_qty){
						$logic_qty = $plan_jobcount1;
					}
					// echo $logic_qty.' final logic_qty<br/>';
					if($logic_qty > 0){
	
						$bundle_cum_qty=$logic_qty+$bundle_cum_qty;
					
						$barcode="SPB-".$dono."-".$job."-".$bundle_seq."";
						//Plan Logical Bundle				
						$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job`(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,plan_cut_bundle_id,barcode_sequence,tran_user,barcode,style,color,schedule,tran_ts)VALUES(".$dono.", '".$size."', ".$logic_qty.", '".$job."', '".$input_job_num_rand."', '".$destination."', '".$packing_mode."', '".$size_code."','R', '-1', '', $plan_cut_bundle_id,$bundle_seq,'".$username."','".$barcode."','".$style."','".$color."','".$schedule."','".date('Y-m-d H:i:s')."')";
						// echo $ins_qry.'<br/>';
						$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
						$pac_tid= mysqli_insert_id($link);
						foreach($operation_codes as $index => $op_code)
						{
							$send_qty = 0;
							if($index == 0) {
								$send_qty = $logic_qty;
							}
							//Plan Logical Bundle Trn
							$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','". $size_code."','".$size."','". $smv[$op_code]."',".$pac_tid.",".$logic_qty.",".$send_qty.",0,0,0,".$op_code.",'".$dono."','".date('Y-m-d H:i:s')."', '".$username."','".$dono."','".$job."','".$input_job_num_rand."','".$assigned_module."','Normal','".$color."',".$bundle_seq.",'".$barcode."')";
							// echo $b_query.'<br/>';
							mysqli_query($link, $b_query) or exit("Issue in inserting BCD".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
							$moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$max_mo_no."', '".$pac_tid."','".$logic_qty."', '".$op_code."', '".$operation_names[$index]."')";
							// echo $moq_qry.'<br/>';
							mysqli_query($link,$moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
						$barcode='';
						$size_plies = $size_plies - $logic_qty;
						$count++;
						$bundle_seq++;
						$plan_jobcount1 = $plan_jobcount1 - $logic_qty;
					} else {
						// var_dump($excess_tid.'~~~~excess_tid');
						// var_dump(sizeof($excess_tid).'excess_tid');
						$size_plies=0;
						$plan_jobcount1=0;
					}
				} else{
					$size_plies = 0;
				}
			}while ($size_plies > 0);   
        }			
	}
	// die();
	
}

?>