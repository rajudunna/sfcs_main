<?php
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	$operation_codes = [15];
	$sucess_array = array();
	$selecting_qry = "SELECT docket_number,GROUP_CONCAT(DISTINCT operation_id)AS ops FROM $brandix_bts.`bundle_creation_data`  GROUP BY docket_number HAVING ops = '60,70' ORDER BY docket_number";
	$selecting_qryresult=mysqli_query($link, $selecting_qry)or exit("bcd_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($selecting_qryresult))
	{
		$doc_no_ref=$sql_row['docket_number'];
		echo $doc_no_ref.'-';
		$cut_done_qty = array();
		//logic to insert into bundle_creation_data with doc,size and operation_wise
		$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_no_ref'";
		$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
		while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
		{
			$order_tid = $row['order_tid'];
			$act_cut_status = $row['act_cut_status'];
			for ($i=0; $i < sizeof($sizes_array); $i++)
			{ 
				if ($row['a_'.$sizes_array[$i]] > 0)
				{
					$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
				}
			}
		}
		foreach($cut_done_qty as $key => $value)
		{
			$qty_to_fetch_size_title = "SELECT *,title_size_$key  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
			$res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
			{
				$size_title = $nop_res_qty_to_fetch_size_title["title_size_$key"];
				$b_style =  $nop_res_qty_to_fetch_size_title['order_style_no'];
				$b_schedule =  $nop_res_qty_to_fetch_size_title['order_del_no'];
				$b_colors =  $nop_res_qty_to_fetch_size_title['order_col_des'];
			}
			$b_size_code = $key;
			$b_sizes = $size_title;
			$sfcs_smv = 0;
			$b_tid = $doc_no_ref;
			$b_in_job_qty = $value;
			$send_qty = $value;
			if($act_cut_status == 'DONE')
			{
				$rec_qty = $value;
				$reported_status = 'F';
			}
			else
			{
				$rec_qty = 0;
				$reported_status = 'P';
			}
			$rej_qty = 0;
			$left_over_qty = 0;
			$b_doc_num = $doc_no_ref;
			$b_a_cut_no = $doc_no_ref;
			$b_inp_job_ref = $doc_no_ref;
			$b_job_no = $doc_no_ref;
			$b_shift = 'G';
			$b_module = '0';
			$b_remarks = 'Normal';
			$mapped_color = $b_colors;
			foreach($operation_codes as $index => $op_code)
			{
				if($op_code != 15)
				{
					$send_qty = 0; 
				}
				
				//getting cps_log_id
				$getting_qry = "select id from $bai_pro3.cps_log where doc_no = $doc_no_ref and size_code = '$b_size_code' and operation_code = '15'";
				$getting_qryresult=mysqli_query($link, $getting_qry)or exit("getting_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($cps_row=mysqli_fetch_array($getting_qryresult))
				{
					$last_id = $cps_row['id'];
				}
				
				//updating cps_log 
				$updating_qry_cps = "update $bai_pro3.cps_log set remaining_qty =$rec_qty,reported_status='$reported_status' where id=$last_id";
				$link->query($updating_qry_cps);
				echo "Bundle_number - ".$last_id.", Operation_id -".$op_code." , cps updation done with qty-".$rec_qty.",";
				//deleting the record from bts which is having bundle_Number and op code of same
				$delete_from_bts_qry = "delete from $brandix_bts.bundle_creation_data where bundle_number = $last_id and operation_id = $op_code";
				$link->query($delete_from_bts_qry);
				$b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";
				$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$b_size_code.'","'. $b_sizes.'","'. $sfcs_smv.'","'.$last_id.'","'.$b_in_job_qty.'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks.'","'.$mapped_color.'")';
				$bundle_creation_result_001 = $link->query($b_query[$op_code]);
				echo "bcd insertion_done with recevied_qty as -".$rec_qty."</br>";
			}
		}
	}	
	
?>