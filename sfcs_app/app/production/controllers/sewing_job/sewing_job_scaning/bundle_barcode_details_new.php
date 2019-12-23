<?php
    error_reporting(0);
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    include 'functions_scanning_ij.php';
	
	$barcode = $_POST['barcode'];
	$rej_data=$_POST['rej_data'];
	
	if($rej_data!='')
	{
		$rejctedqty=array_sum($rej_data);		
	}else
	{
		$rejctedqty=0;
	}
	
	function scanningdetails($barcode,$rej_data,$rejctedqty)
	{
		if($rej_data!=''){
			$total_rej_qty=array_sum($rej_data);   
		}else{
			$total_rej_qty=0;
		}
		$docket_no = explode('-', $barcode)[1];
		$bundle_no = explode('-', $barcode)[2];
		$operation = explode('-', $barcode)[3];

		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		//getting style and color
		$get_style_details="select style,color from $bai_pro3.act_cut_bundle where docket=".$docket_no."";
		$result_selecting_style_color_qry = $link->query($get_style_details);
		while($row = $result_selecting_style_color_qry->fetch_assoc())
		{
			$style=$row['style'];
			$color=$row['color'];
		}
		
		//getting operation code
		$get_curr_ops_code="select ops_code,rec_qty,good_qty,rejection_qty from $bai_pro3.act_cut_bundle_trn where barcode='".$barcode."'";
		$rslt_get_cur_ops = $link->query($get_curr_ops_code);
		while($row_rslt = $rslt_get_cur_ops->fetch_assoc())
		{
			$ops_code=$row_rslt['ops_code'];
			$rec_qty=$row_rslt['rec_qty'];
			$report_qty=$row_rslt['rec_qty'];
			$good_qty=$row_rslt['good_qty'];
			$rejection_qty=$row_rslt['rejection_qty'];
		}

		if($rec_qty>0)
		{
			//getting previous operation
			$prev_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = $ops_code";
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
			
			//getting next operation
			$dep_ops_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code =$ops_code";
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
			
			
			$ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$ops_code";
			$result_ops_seq_check = $link->query($ops_seq_check);
			while($row = $result_ops_seq_check->fetch_assoc())
			{
				$ops_seq = $row['ops_sequence'];
				$seq_id = $row['id'];
				$ops_order = $row['operation_order'];
			}
			$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code NOT IN (10,200) ORDER BY operation_order ASC LIMIT 1";
			$result_post_ops_check = $link->query($post_ops_check);
			if($result_post_ops_check->num_rows > 0)
			{
				while($row = $result_post_ops_check->fetch_assoc())
				{
					$post_ops_code = $row['operation_code'];
				}
			}
			
			$pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN (10,200) ORDER BY operation_order DESC LIMIT 1";
			$result_pre_ops_check = $link->query($pre_ops_check);
			if($result_pre_ops_check->num_rows > 0)
			{
				while($row = $result_pre_ops_check->fetch_assoc())
				{
					$pre_ops_code = $row['operation_code'];
				}
			}
			
			
			if($flag=='parallel_scanning')
			{
				if($rec_qty=$good_qty+$rejection_qty)
				{
					$result_array['status'] = 'Already Scanned';
					echo json_encode($result_array);
					die();
				}
				else
				{
						//quantity filling in act_cut_bundle_trn
						$update_qnty_qry="Update $bai_pro3.act_cut_bundle_trn SET good_qty=$report_qty-$rejctedqty,rejection_qty=".$rejctedqty.",remaining_qty=remaining_qty+($report_qty-$rejctedqty),status=1 where barcode='".$barcode."'";
						$result_query = $link->query($update_qnty_qry) or exit('query error in updating');
						
						if($pre_ops_code)
						{
							$pre_ops_barcode="ACB-".$docket_no."-".$bundle_no."-".$pre_ops_code;
							$update_prev_ops_qry="update $bai_pro3.act_cut_bundle_trn SET remaining_qty=0 where barcode='".$pre_ops_barcode."'";
							$result_update_query = $link->query($update_prev_ops_qry) or exit('query error in updating pre ops');
						}
						if($post_ops_code)
						{
							$post_ops_barcode="ACB-".$docket_no."-".$bundle_no."-".$post_ops_code;
							$update_post_ops_qry="update $bai_pro3.act_cut_bundle_trn SET rec_qty=$report_qty-$rejctedqty where barcode='".$post_ops_barcode."'";
							$result_update_query = $link->query($update_post_ops_qry) or exit('query error in updating post ops');
						}
						$result_array['bundle_no'] = $barcode;	
						$result_array['style'] = $style;	
						$result_array['color_dis'] = $color;	
						$result_array['reported_qty'] = $report_qty-$rejctedqty;	
						$result_array['rejected_qty'] = $rejctedqty;	
						echo json_encode($result_array);
						die();

				}
			}
			else
			{
				if($rec_qty=$good_qty+$rejection_qty)
				{
					$result_array['status'] = 'Already Scanned';
					echo json_encode($result_array);
					die();
				}
				else
				{
					//quantity filling in act_cut_bundle_trn
					$update_qnty_qry="Update $bai_pro3.act_cut_bundle_trn SET good_qty=$report_qty-$rejctedqty,rejection_qty=".$rejctedqty.",remaining_qty=remaining_qty+($report_qty-$rejctedqty),status=1 where barcode='".$barcode."'";
					$result_query = $link->query($update_qnty_qry) or exit('query error in updating');
					
					if($pre_ops_code)
					{
						$pre_ops_barcode="ACB-".$docket_no."-".$bundle_no."-".$pre_ops_code;
						$update_prev_ops_qry="update $bai_pro3.act_cut_bundle_trn SET remaining_qty=0 where barcode='".$pre_ops_barcode."'";
						$result_update_query = $link->query($update_prev_ops_qry) or exit('query error in updating pre ops');
					}
					if($post_ops_code)
					{
						$post_ops_barcode="ACB-".$docket_no."-".$bundle_no."-".$post_ops_code;
						$update_post_ops_qry="update $bai_pro3.act_cut_bundle_trn SET rec_qty=$report_qty-$rejctedqty where barcode='".$post_ops_barcode."'";
						$result_update_query = $link->query($update_post_ops_qry) or exit('query error in updating post ops');
					}
				}
				$result_array['bundle_no'] = $barcode;	
				$result_array['style'] = $style;	
				$result_array['color_dis'] = $color;	
				$result_array['reported_qty'] = $report_qty-$rejctedqty;	
				$result_array['rejected_qty'] = $rejctedqty;	
				echo json_encode($result_array);
				die();
				
			}
		}
		else
		{
			$result_array['status'] = 'Previous Operation Not Yet Done';
			echo json_encode($result_array);
			die();
		}
	}
	scanningdetails($barcode,$rej_data,$rejctedqty);
	
?>	