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
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$b_style' AND color='$b_colors' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
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
				$plan_cut_insert_query = "insert into $bai_pro3.plan_cut_bundle(`doc_no`,`style`,`color`,`size_code`,`size`,`bundle_no`,`plies`,`barcode`,`tran_user`) values (".$docket_no.",'".$b_style."','".$b_colors."','".$b_size_code."','".$b_sizes."',".$bundle_no.",".$plies_per_cut.",'".$barcode."','".$username."')";
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

function plan_logical_bundles($dono,$plan_jobcount,$plan_bundleqty,$inserted_id,$schedule,$cut) 
{	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$doc_type = 'N';
    $packing_mode = 1;
    $destination = '';	
    //get input job number for each schedule
    $old_jobs_count_qry1 = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.packing_summary_input WHERE order_del_no='".$schedule."'";
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
    //get destination to fill logical bundle
    $sql="select destination,order_style_no,order_col_des from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
    $sql_result=mysqli_query($link, $sql) or exit("Issue while Selecting Bai_orders".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row = mysqli_fetch_array($sql_result))
	{
		$destination = $sql_row['destination'];
		$style = $sql_row['order_style_no'];
		$color = $sql_row['order_col_des'];		
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
	$barcode='';
	$cut_no=$cut;
	$shift='A';
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
			do 
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
					//Plan Logical Bundle Trn
					$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','". $size_code."','".$size."','". $smv[$op_code]."',".$pac_tid.",".$logic_qty.",0,0,0,0,".$op_code.",'".$dono."','".date('Y-m-d H:i:s')."', '".$username."','".$cut_no."','".$input_job_num."','".$input_job_num_rand."','".$shift."','".$module."','Normal','".$color."',".$bundle_seq.",'".$barcode."')";
					mysqli_query($link, $b_query) or exit("Issue in inserting BCD".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				$barcode='';
				$size_plies = $size_plies - $logic_qty;
				$count++;
				$bundle_seq++;
			}while ($size_plies > 0);   
        }			
        // update count of plan logical bundles for each sewing job
        $update_query = "UPDATE `bai_pro3`.`sewing_jobs_ref` set bundles_count = $count where id = '$inserted_id' ";
        $update_result = mysqli_query($link,$update_query) or exit("Problem while inserting to sewing jobs ref");
    }	
}

function act_logical_bundles($doc_no,$schedule_new,$style,$color)
{			
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$category=['cutting','Send PF','Receive PF'];
	
	$operation_codes = array();
	$fetching_ops_with_category = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
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
						$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,plies,tran_user,bundle_order,act_good_qty)
						VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','".$barcode."','".$shade."',".$startno.",".$endno.",".$plies.",'".$username."',".$lay_seq.",".$plies.")";	
						$result= mysqli_query($link,$insert_docket_num_info);
						$id=mysqli_insert_id($link);
						
						$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,15,$plies,$plies,$plies,0,'$username',1,'".$barcode."-15')";
						$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
						
					}
					else
					{
						$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,plies,tran_user,bundle_order)
						VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','".$barcode."','".$shade."',".$startno.",".$endno.",".$plies.",'".$username."',".$lay_seq.")";	
						$result= mysqli_query($link,$insert_docket_num_info);
						$id=mysqli_insert_id($link);
						
						$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,15,$plies,$plies,$plies,0,'$username',1,'".$barcode."-15')";
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
								$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,$op_code,$plies,$plies,0,0,'$username',0,'".$barcode."-".$op_code."')";
								$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
							}
							else
							{											
								$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`,barcode) values ($id,$plan_id,$op_code,0,$plies,0,0,'$username',0,'".$barcode."-".$op_code."')";
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
		}			
	}		
}

?>