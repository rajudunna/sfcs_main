<?php
//plan bundles generation
function plan_cut_bundle($docket_no) 
{	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
  //  $username = getrbac_user()['uname'];
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
				$plan_cut_insert_query = "insert into $bai_pro3.plan_cut_bundle(`doc_no`,`style`,`color`,`size_code`,`size`,`bundle_no`,`plies`,`barcode`,`tran_user`) values (".$docket_no.",'".$b_style."','".$b_colors."','".$b_size_code."','".$b_sizes."',".$bundle_no.",".$plies_per_cut.",'".$barcode."','".$username."')";
				$plan_cut_insert_query_res = $link->query($plan_cut_insert_query);
				$plan_cut_insert_id = mysqli_insert_id($link);
				foreach($operation_codes as $index => $op_code)
				{
					$plan_cut_insert_transactions_query = "insert into $bai_pro3.plan_cut_bundle_trn(`plan_cut_bundle_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`) values (".$plan_cut_insert_id.",".$op_code.",0,".$plies_per_cut.",0,0,'".$username."',0)";
					$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);			
				}
				$bundle_no++;
			}
		}
	}
}

function plan_logical_bundles($dono,$plan_jobcount,$plan_bundleqty,$inserted_id,$schedule,$cut) {	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	//$username = getrbac_user()['uname'];
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
				$ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` 				(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,plan_cut_bundle_id,barcode_sequence,tran_user,barcode,style,color,schedule)VALUES(".$dono.", '".$size."', ".$logic_qty.", '".$input_job_num."', '".$input_job_num_rand."', '".$destination."', '".$packing_mode."', '".$size_code."',
				'".$doc_type."', '-1', $inserted_id, $plan_cut_bundle_id,$bundle_seq,'".$username."','".$barcode."','".$style."','".$color."','".$schedule."')";
				$result_ins_qry=mysqli_query($link, $ins_qry) or exit("Issue in Inserting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
				$pac_tid= mysqli_insert_id($link);
				foreach($operation_codes as $index => $op_code)
				{
					$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','".$size."','". $size_code."','". $smv[$op_code]."',".$pac_tid.",".$logic_qty.",0,0,0,0,".$op_code.",'".$dono."','".date('Y-m-d H:i:s')."', '".$username."','".$cut_no."','".$input_job_num."','".$input_job_num_rand."','".$shift."','".$module."','Normal','".$color."',".$bundle_seq.",'".$barcode."')";
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
	//$username = getrbac_user()['uname'];
	$operation_codes = array();
	$fetching_ops_with_category = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
	LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category in ('".implode("','",$category)."') GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
	$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit("Issue while selecting the Operations");
	while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
	{
		$operation_codes[] = $row['operation_code'];			
	}
	
	$sql1="select * from $bai_pro3.`bai_orders_db_confirm` where orde_del_no=".$schedule."";
	$resut_1= mysqli_query($link,$sql1);
	while($rows1 = mysqli_fetch_array($resut_1))
	{
		$orde_tid = $rows1['order_tid'];			
		for($ss=0;$ss<sizeof($sizes_array);$ss++)
		{
		   if($rows1["title_size_".$sizes_array[$ss].""]<>'')
		   {
				$o_s[$sizes_array[$ss]]=$rows1["title_size_".$sizes_array[$ss].""];                     
		   }
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
			$bundle = $row_act['bundles'];
		}
	}
	$docket_query="SELECT * FROM $bai_pro3.`docket_roll_alloc` where docket=".$doc_no." and plies>0 and status=0 order by lay_seq,shade asc";
	$docket_queryresult = mysqli_query($link,$docket_query);
	if(mysqli_num_rows($docket_queryresult) > 0)
	{
		while($row = mysqli_fetch_array($docket_queryresult))
		{
			$docket_info[] = $row;
			$udpate ="UPDATE $bai_pro3.`docket_roll_alloc` set status=1 where id =".$row['id']."";
			mysqli_query($link,$udpate);
			$sizeofrolls=count($docket_info);
			$shadebundleno=0;	
		}
		$endno=0;
		$get_det_qry="select size,id,plies from $bai_pro3.plan_cut_bundle where doc_no=".$doc_no."";
		$get_det_qry_rslt= mysqli_query($link,$get_det_qry);
		if(mysqli_num_rows($get_det_qry_rslt)>0)
		{
			$check_value=array();
			$check_qty="SELECT plan_cut_bundle_id,sum(plies) as fill FROM $bai_pro3.`act_cut_bundle` where docket=".$doc_no." group by plan_cut_bundle_id";
			$check_qty_result = mysqli_query($link,$check_qty);
			if(mysqli_num_rows($check_qty_result) > 0)
			{
				while($rows = mysqli_fetch_array($check_qty_result))
				{				
					$check_value[$rows['plan_cut_bundle_id']]=$rows['fill'];
				}
			}
			while($rowdet = mysqli_fetch_array($get_det_qry_rslt))
			{					
				$size = $rowdet['size'];
				$plan_id = $rowdet['id'];
				if($check_value[$plan_id]=='')
				{
					$planplies = $rowdet['plies'];
				}
				else
				{
					$planplies = $rowdet['plies']-$check_value[$plan_id];
				}
				if($planplies>0)
				{
					for($k=0;$k<$sizeofrolls;$k++)
					{
						$shadebundleno++;					
						$endno=($startno+$docket_info[$k]['plies'])-1;					
						//inserting data into docket_number_info
						$insert_docket_num_info="INSERT INTO $bai_pro3.`act_cut_bundle` (style,color,plan_cut_bundle_id,docket,size,barcode,shade,start_no,end_no,plies,tran_user,bundle_order)
						VALUES ('".$style."','".$color."',".$plan_id.",".$doc_no.",'".$size."','ACB-".$doc_no."-".$bundle."-".$shadebundleno."','".$docket_info[$k]['shade']."',".$startno.",".$endno.",".$docket_info[$k]['plies'].",'".$username."','".$docket_info[$k]['lay_seq']."')";
						$result= mysqli_query($link,$insert_docket_num_info);
						$id=mysqli_insert_id($link);						
						foreach($operation_codes as $index => $op_code)
						{
							if($op_code==15)
							{									
								$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`) values (".$id.",".$plan_id.",".$op_code.",".$docket_info[$k]['plies'].",".$docket_info[$k]['plies'].",".$docket_info[$k]['plies'].",0,'".$username."',1)";
								$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
							}
							else
							{
								$plan_cut_insert_transactions_query = "insert into $bai_pro3.act_cut_bundle_trn(`act_cut_bundle_id`,`plan_cut_bundle_trn_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`) values (".$id.",".$plan_id.",".$op_code.",0,".$docket_info[$k]['plies'].",0,0,'".$username."',0)";
								$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
							}						
						}
						
						$startno=$startno+$docket_info[$k]['plies'];
						$planplies=$planplies-$docket_info[$k]['plies'];
					}				
					$bundle++;
					$shadebundleno=0;
				}				
			}			
			unset($operation_codes);		
			// Filling Actual Logical bundles		
			$category='sewing';
			$operation_codes = array();
			$fetching_ops_with_category1 = "SELECT tsm.operation_code AS operation_code FROM $brandix_bts.tbl_style_ops_master tsm 
			LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category='".$category."' GROUP BY tsm.operation_code ORDER BY tsm.operation_order";
			$result_fetching_ops_with_cat1 = mysqli_query($link,$fetching_ops_with_category1) or exit("Issue in Selecting Operaitons-S");
			while($row1=mysqli_fetch_array($result_fetching_ops_with_cat1))
			{
				$operation_codes[] = $row1['operation_code'];				
			}
			
			$plac_log = "SELECT plan_cut_bundle_id,GROUP_CONCAT(tid ORDER BY tid)  AS ids, GROUP_CONCAT(carton_act_qty ORDER BY tid)  AS qty FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no=".$doc_no." GROUP BY plan_cut_bundle_id";    
			$plan_log_result = mysqli_query($link, $plac_log) or exit("Issue in selecting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row_plan_log = mysqli_fetch_array($plan_log_result))
			{				
				$pla_log = $row_plan_log['plan_cut_bundle_id'];
				$plan_qty[$pla_log]= $row_plan_log['qty'];
				$plan_ids[$pla_log]=$row_plan_log['ids'];
			}
			
			//generating actual logical bundles
			$act_cut_bundle_qry = "SELECT plan_cut_bundle_id,GROUP_CONCAT(id ORDER BY id)  AS ids, GROUP_CONCAT(plies ORDER BY id)  AS qty, GROUP_CONCAT(shade ORDER BY id)  AS shades FROM $bai_pro3.act_cut_bundle WHERE docket=".$doc_no." GROUP BY plan_cut_bundle_id";    
			$act_cut_bundle_res = mysqli_query($link, $act_cut_bundle_qry) or exit("Issue in selecting ACB".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($act_cut_bundle_row = mysqli_fetch_array($act_cut_bundle_res))
			{				
				$act_plan_cut_bundle_id[] = $act_cut_bundle_row['plan_cut_bundle_id'];
				$act_plan_cut_bundle_id_temp = $act_cut_bundle_row['plan_cut_bundle_id'];
				$act_qty[$act_plan_cut_bundle_id_temp] = $act_cut_bundle_row['qty'];
				$act_qty_id[$act_plan_cut_bundle_id_temp] = $act_cut_bundle_row['ids'];
				$shade[$act_plan_cut_bundle_id_temp] = $act_cut_bundle_row['shades'];			
			}          
			for($j=0;$j<sizeof($act_plan_cut_bundle_id);$j++)
			{
				$values_qct_qty=explode(",",$act_qty[$act_plan_cut_bundle_id[$j]]);
				$values_qct_ids=explode(",",$act_qty_id[$act_plan_cut_bundle_id[$j]]);
				$values_qct_shade=explode(",",$shade[$act_plan_cut_bundle_id[$j]]);
				$values_plan_qty=explode(",",$plan_qty[$act_plan_cut_bundle_id[$j]]);
				$values_plan_ids=explode(",",$plan_ids[$act_plan_cut_bundle_id[$j]]);
				for($jj=0;$jj<sizeof($values_qct_ids);$jj++)
				{					
					do
					{						
						for($jjj=0;$jjj<sizeof($values_plan_qty);$jjj++)
						{					
							if($values_plan_qty[$jjj]>0 && $values_qct_qty[$jj]>0)
							{
								if($values_qct_qty[$jj] <= $values_plan_qty[$jjj])
								{
									$reported_qty = $values_qct_qty[$jj];
									$values_plan_qty[$jjj]=$values_plan_qty[$jjj]-$values_qct_qty[$jj];
									$values_qct_qty[$jj]=0;
								} 
								else 
								{
									$reported_qty = $values_plan_qty[$jjj];
									$values_qct_qty[$jj]=$values_qct_qty[$jj]-$values_plan_qty[$jjj];
									$values_plan_qty[$jjj]=0;
								}  								
								$ins_qry =  "INSERT INTO $bai_pro3.act_log_bundle(barcode,plan_log_bundle_id,shade,qty,act_cut_bundle_id,tran_user)
								VALUES('ALG-', ".$values_plan_ids[$jjj].", '".$values_qct_shade[$jj]."', ".$reported_qty.", ".$values_qct_ids[$jj].", '".$username."')";
								$result_time = mysqli_query($link, $ins_qry) or exit("Issue inserting ALB".mysqli_error($GLOBALS["___mysqli_ston"]));
								$actlogid=mysqli_insert_id($link);	
								
								foreach($operation_codes as $index => $op_code)
								{
									$act_log_trn_qry="INSERT INTO $bai_pro3.act_log_bundle_trn(plan_log_bundle_trn_id,act_log_bundle_id,ops_code,rec_qty,original_qty,good_qty,rejection_qty,tran_user,status) VALUES (".$values_plan_ids[$jjj].",".$actlogid.",".$op_code.",0,".$reported_qty.",0,0,'".$username."',0)";
									mysqli_query($link, $act_log_trn_qry) or exit("Issue inserting ALBtr".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							}
						}
					}
					while($values_qct_qty[$jj]>0);						
				} 
				unset($values_qct_qty);
				unset($values_qct_ids);
				unset($values_qct_shade);
				unset($values_plan_qty);
				unset($values_plan_ids);
			}			
		}			
	}		
}

?>