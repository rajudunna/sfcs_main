<?php
error_reporting(0);
if($_POST['modal_submit'])
{    
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
    $jobcount = $_POST['jobcount'];
    $bundle_qty = $_POST['bundleqty'];
    $docs = $_POST['docs'];
    $cuts = $_POST['cuts'];
    $schedule = $_POST['schedule1'];
    $style = $_POST['style1'];
    $color = $_POST['color1'];
    $sql_new="select * from $bai_pro3.pac_stat_log_input_job where doc_no in($docs)";
    $sql_result_new=mysqli_query($link, $sql_new) or exit("Issue while Selecting pac_stat_log_input_job".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result_new) == 0)
	{
		$sql_new11="select * from $bai_pro3.sewing_jobs_ref where schedule='$schedule' and bundles_count=0";
        $sql_result_new11=mysqli_query($link, $sql_new11) or exit("Issue while Selecting sewing_jobs_ref".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_new11) == 0)
		{
			$ins_qry2 = "INSERT INTO $bai_pro3.`sewing_jobs_ref` (style,schedule,bundles_count,log_time,log_user) VALUES ('".$style."','".$schedule."','0',NOW(),'$username')";
			$result_time2 = mysqli_query($link, $ins_qry2) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
			$inserted_id = mysqli_insert_id($link);
			$sewing_bundle_generation = sewing_bundle_generation($docs,$jobcount,$bundle_qty,$inserted_id,$schedule,$cuts);
			// echo $sewing_bundle_generation;
			// die();
			if($sewing_bundle_generation)
			{
				insertMOQuantitiesSewing($schedule,$inserted_id);		
				$res1['status'] = true;
				echo json_encode($res1);
			} 
			else 
			{
				$res1['status'] = false;
				$res1['final'] = 'first_cut';
				echo json_encode($res1);
				exit();
			} 
        }
		else
		{
			$res1['final'] = 'validating';
			echo json_encode($res1);
			exit();
	    }			
	}
	else
	{
		$res1['final'] = 'validating';
		echo json_encode($res1);
	    exit();
    }
    
}
function sewing_bundle_generation($doc_list,$plan_jobcount,$plan_bundleqty,$inserted_id,$schedule,$cut) 
{	
	header('Content-Type: application/json');
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$doc_list_new = explode(",",$doc_list);
	// var_dump($doc_list_new);
	$cut_new = explode(",",$cut);
	$sql1="select order_tid from $bai_pro3.plandoc_stat_log where doc_no=".$doc_list_new[0]."";
	$sql_result1=mysqli_query($link, $sql1) or exit("Issue while Selecting Bai_orders".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1 = mysqli_fetch_array($sql_result1))
	{
		$order_tid = $sql_row1['order_tid'];
	}	
	$operation_code=15;
	
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
	$query = "select excess_cut_qty from $bai_pro3.excess_cuts_log where schedule_no='".$schedule."' and color='".$color."'";
	// echo $query;
	$query_result = mysqli_query($link,$query) or exit(" Error78".mysqli_error ($GLOBALS["___mysqli_ston"]));
	while($sql_rows1=mysqli_fetch_array($query_result))
	{
		$excess_cut =$sql_rows1['excess_cut_qty'];
	}
	
	// Getting Plan
	if($excess_cut==1)
	{	
		$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log psl LEFT JOIN bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref  WHERE psl.order_tid = '".$order_tid."' and csl.category IN ('Body','Front') order by psl.doc_no asc";
	}
	else
	{
		$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log psl LEFT JOIN bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref  WHERE psl.order_tid = '".$order_tid."' and csl.category IN ('Body','Front') order by psl.doc_no desc";
	}	
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	$cut_plan_qty = [];
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		$dockets[]=$row['doc_no'];
		$docket_cut[$row['doc_no']]=$row['pcutno'];
		for ($i=0; $i < sizeof($check_upto); $i++)
		{
			if ($row['p_'.$sizes_array[$i]] > 0)
			{
				$cut_plan_docket[$row['doc_no']][$sizes_array[$i]] = $row['p_'.$sizes_array[$i]] * $row['p_plies'];
				if(isset($cut_plan_qty[$sizes_array[$i]]))
				{
					// echo 'ifu<br/>';
					$cut_plan_qty[$sizes_array[$i]] += ($row['p_'.$sizes_array[$i]] * $row['p_plies']);
				}
				else {
					// echo 'elseu<br/>';
					$cut_plan_qty[$sizes_array[$i]] = ($row['p_'.$sizes_array[$i]] * $row['p_plies']);
				}
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
		
	$eligible_to_generate=1;
	if($excess_cut == 1){
		if(array_sum($pending_plan)>0)
		{
			$eligible_to_generate=0;
		}
		else
		{
			$eligible_to_generate=1;
		}
	} 
	
	if($eligible_to_generate == 1){
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
								$remove_from_excess[$dockets[$s]][$sizes_array[$ss]]= $remove_from_excess[$dockets[$s]][$sizes_array[$ss]] - $samp_qty[$sizes_array[$ss]];
								$samp_qty[$sizes_array[$ss]]=0;								
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
			
			foreach($remaval_dockets as $key => $docket_no)
			{
				if(in_array($docket_no,$doc_list_new))
				{
					for($i=0;$i<sizeof($check_upto);$i++)
					{	
						$cps_log_qry = "SELECT * FROM $bai_pro3.cps_log WHERE doc_no=$docket_no and size_code='".$sizes_array[$i]."' and operation_code=$operation_code";
						$cps_log_qry_res = mysqli_query($link, $cps_log_qry) or exit("Issue while Selecting PCB".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($cps_row = mysqli_fetch_array($cps_log_qry_res))
						{
							$cps_log_id = $cps_row['id'];						
							$sizes[$cps_log_id] = $cps_row['size_title'];
							$size_codes[$cps_log_id] = $cps_row['size_code'];
							$size_plies = $cps_row['cut_quantity'];
							
							do 
							{							
								if($remove_from_sample[$docket_no][$sizes_array[$i]]>0)
								{							
									if($size_plies >= $remove_from_sample[$docket_no][$sizes_array[$i]])
									{
										$usage_from_plan_id[$cps_log_id] +=$remove_from_sample[$docket_no][$sizes_array[$i]];
										$fill_qty[$cps_log_id][3] = $remove_from_sample[$docket_no][$sizes_array[$i]];
										$size_plies=$size_plies-$remove_from_sample[$docket_no][$sizes_array[$i]];
										$remove_from_sample[$docket_no][$sizes_array[$i]]=0;
										$cps_ids[]=$cps_log_id;
										
									} 
									else 
									{
										$usage_from_plan_id[$cps_log_id] +=$size_plies;
										$fill_qty[$cps_log_id][3] = $size_plies;
										$remove_from_sample[$docket_no][$sizes_array[$i]]=$remove_from_sample[$docket_no][$sizes_array[$i]]-$size_plies;
										$size_plies=0;
										$cps_ids[]=$cps_log_id;										
									}									
								}
								
								
								if($remove_from_excess[$docket_no][$sizes_array[$i]]>0) 
								{
									if($size_plies >= $remove_from_excess[$docket_no][$sizes_array[$i]])
									{
										$usage_from_plan_id[$cps_log_id] +=$remove_from_excess[$docket_no][$sizes_array[$i]];
										$fill_qty[$cps_log_id][2] = $remove_from_excess[$docket_no][$sizes_array[$i]];
										$size_plies=$size_plies-$remove_from_excess[$docket_no][$sizes_array[$i]];
										$remove_from_excess[$docket_no][$sizes_array[$i]]=0;
										$cps_ids[]=$cps_log_id;		
									} 
									else 
									{
										$usage_from_plan_id[$cps_log_id] +=$size_plies;
										$fill_qty[$cps_log_id][2] = $size_plies;
										$remove_from_excess[$docket_no][$sizes_array[$i]]=$remove_from_excess[$docket_no][$sizes_array[$i]]-$size_plies;
										$size_plies=0;
										$cps_ids[]=$cps_log_id;										
									}									
								}							
							}while ($size_plies > 0 && $remove_from_sample[$docket_no][$sizes_array[$i]]>0 && $remove_from_excess[$docket_no][$sizes_array[$i]]>0);						
						}	
					}
				
					$cps_ids1=array_values(array_unique($cps_ids));					
					if($excess_cut == 1){
						$old_jobs_count_qry = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random LIKE '%".$schedule."%'";
						// echo $old_jobs_count_qry;
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
							
						for($j=2;$j<4;$j++) 
						{				
							$bundle_seq=1;
							$input_job_no=$input_job_num;
							$input_job_num_rand=$schedule.date("ymd").$input_job_no;
							for($jj=0;$jj<sizeof($cps_ids1);$jj++)
							{
								do{
									if($fill_qty[$cps_ids1[$jj]][$j]>0)
									{
										$logic_qty=0;
										if($fill_qty[$cps_ids1[$jj]][$j] >= $plan_bundleqty)
										{
											$logic_qty = $plan_bundleqty;
										} 
										else 
										{
											$logic_qty = $fill_qty[$cps_ids1[$jj]][$j];
										}
										
										$sql_cps_query="select * from $bai_pro3.cps_log where doc_no=$docket_no and id=$cps_ids1[$jj]";
										$sql_resutlt_cps=mysqli_query($link, $sql_cps_query) or exit("Issue in Inserting SPB.".mysqli_error($GLOBALS["___mysqli_ston"]));
										if(mysqli_num_rows($sql_resutlt_cps)>0){

											$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job`(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,barcode_sequence,type_of_sewing)VALUES(".$docket_no.", '".$sizes[$cps_ids1[$jj]]."', ".$logic_qty.", '".$input_job_no."', '".$input_job_num_rand."', '".$destination."', 1, '".$size_codes[$cps_ids1[$jj]]."','N', '-1', $inserted_id,$bundle_seq,$j)";
											$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB.".mysqli_error($GLOBALS["___mysqli_ston"]));
											$fill_qty[$cps_ids1[$jj]][$j]=$fill_qty[$cps_ids1[$jj]][$j]-$logic_qty;
											$count++;
											$bundle_seq++;	
										}						
									}
									
								}while($fill_qty[$cps_ids1[$jj]][$j]>0);
							}
							$input_job_num++;					
						}
					}
				}			
			}	
			unset($cps_ids1);
		}
		foreach($doc_list_new as $key_list => $dono)
		{
			// var_dump('actual');
			include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
			$doc_type = 'N';
			$packing_mode = 1;
			//get input job number for each schedule
			$old_jobs_count_qry1 = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random LIKE '%".$schedule."%'";
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
			$cps_log_qry = "SELECT * FROM $bai_pro3.cps_log WHERE doc_no=$dono AND operation_code=$operation_code";
			// echo $cps_log_qry.'<br/>';
			$cps_log_res = mysqli_query($link, $cps_log_qry) or exit("Issue while Selecting PCB".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($cps_log_res)>0)
			{        
				while($cps_log_row = mysqli_fetch_array($cps_log_res))
				{								
					$size = $cps_log_row['size_title'];
					$size_code = $cps_log_row['size_code'];
					$cps_log_id = $cps_log_row['id'];
					$size_plies = $cps_log_row['cut_quantity'];
					
					if($usage_from_plan_id[$cps_log_id]>0)
					{
						$size_plies = $size_plies-$usage_from_plan_id[$cps_log_id];
					}			
					
					do 
					{
						// echo $size_plies;
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
							//Plan Logical Bundle				
							$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job`(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,barcode_sequence)VALUES(".$dono.", '".$size."', ".$logic_qty.", '".$input_job_num."', '".$input_job_num_rand."', '".$destination."', '".$packing_mode."', '".$size_code."','".$doc_type."', '-1', $inserted_id,$bundle_seq)";
							// echo $ins_qry.'<br/>';
							$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$size_plies = $size_plies - $logic_qty;
							$count++;
							$bundle_seq++;
						}
					}while ($size_plies > 0);   
				}
				
			}		
		}
		
		foreach($remaval_dockets as $key => $docket_no)
		{
			if(in_array($docket_no,$doc_list_new))
			{
				// var_dump($docket_no,'excess_docket<br/>');
				if($excess_cut == 2 && $excess > 0){
					// echo 'excess2';
					//get input job number for each schedule
					$old_jobs_count_qry = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random LIKE '%".$schedule."%'";
					// echo $old_jobs_count_qry;
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
					// echo $input_job_num;
					// var_dump($input_job_num,'input_job_num<br/>');
					
					// Executing the Bundles
					
					for($j=2;$j<4;$j++) 
					{				
						$bundle_seq=1;
						$input_job_no=$input_job_num;
						$input_job_num_rand=$schedule.date("ymd").$input_job_no;
						for($jj=0;$jj<sizeof($cps_ids);$jj++)
						{
							// var_dump($fill_qty[$cps_ids[$jj]][$j],'fill_qtyt<br/>');
							
								if($fill_qty[$cps_ids[$jj]][$j]>0)
								{
								
								
									$sql_cps_query="select * from $bai_pro3.cps_log where doc_no=$docket_no and id=$cps_ids[$jj]";
									$sql_resutlt_cps=mysqli_query($link, $sql_cps_query) or exit("Issue in Inserting SPB.".mysqli_error($GLOBALS["___mysqli_ston"]));
									if(mysqli_num_rows($sql_resutlt_cps)>0)
									{
									  do
							           {
											$logic_qty=0;
											if($fill_qty[$cps_ids[$jj]][$j] >= $plan_bundleqty)
											{
												$logic_qty = $plan_bundleqty;
											} 
											else 
											{
												$logic_qty = $fill_qty[$cps_ids[$jj]][$j];
											}
											// echo "hello<br>";
											$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job`(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,barcode_sequence,type_of_sewing)VALUES(".$docket_no.", '".$sizes[$cps_ids[$jj]]."', ".$logic_qty.", '".$input_job_no."', '".$input_job_num_rand."', '".$destination."', 1, '".$size_codes[$cps_ids[$jj]]."','N', '-1', $inserted_id,$bundle_seq,$j)";
											// echo $ins_qry."<br>";
											$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB.".mysqli_error($GLOBALS["___mysqli_ston"]));
											$fill_qty[$cps_ids[$jj]][$j]=$fill_qty[$cps_ids[$jj]][$j]-$logic_qty;
											$count++;
											$bundle_seq++;							
									 }while($fill_qty[$cps_ids[$jj]][$j]>0);
								    }
									
							}
						}
						$input_job_num++;					
					}
				}
			}
		}
		unset($cps_ids);

		// update count of plan logical bundles for each sewing job
		$update_query = "UPDATE `bai_pro3`.`sewing_jobs_ref` set bundles_count = $count where id = $inserted_id";
		$update_result = mysqli_query($link,$update_query) or exit("Problem while updating to sewing jobs ref");

		
		return true;
	} else {

		$delete_query = "DELETE FROM `bai_pro3`.`sewing_jobs_ref` where id = $inserted_id and bundles_count = 0";
		$delete_result = mysqli_query($link,$delete_query) or exit("Problem while deleteing the sewing jobs ref");

		return false;
	}
}


?>
