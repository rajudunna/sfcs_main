<?php
    include("../../../../../common/config/config_ajax.php");
    $barcode = $_POST['barcode'];

    $bundle_no = explode('-', $barcode)[0];
    $op_no = explode('-', $barcode)[1];
    // $status = true;
    $msg = 'Scanned Successfully';

    $response['bundle_no'] = $bundle_no;
    $response['op_no'] = $op_no;
    $response['msg'] = $msg;
    
    $barcode_exist_query = "SELECT * FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $bundle_no AND operation_id = $op_no";
    
    $barcode_exist_result = $link->query($barcode_exist_query);
    if(mysqli_num_rows($barcode_exist_result) > 0){

        $status = true;

    }else{

        $get_job_no_qry = "SELECT * FROM $bai_pro3.packing_summary_input WHERE tid = $bundle_no";

        $get_job_no_result = $link->query($get_job_no_qry);
        if($get_job_no_result->num_rows > 0){
            while($row = $get_job_no_result->fetch_assoc()) 
            {
                $order_joins = $row['order_joins'];
                $doc_no     = $row['doc_no'];
                $input_job_no   = $row['input_job_no'];
                $input_job_no_random    = $row['input_job_no_random'];
                $doc_no_ref = $row['doc_no_ref'];
                $tid    = $row['tid'];
                $size_code  = $row['size_code'];
                $status = $row['status'];
                $carton_act_qty = $row['carton_act_qty'];
                $packing_mode   = $row['packing_mode'];
                $order_style_no = $row['order_style_no'];
                $order_del_no   = $row['order_del_no'];
                $order_col_des  = $row['order_col_des'];
                $acutno = $row['acutno'];
                $destination    = $row['destination'];
                $cat_ref    = $row['cat_ref'];
                $m3_size_code   = $row['m3_size_code'];
                $old_size   = $row['old_size'];
                $type_of_sewing = $row['type_of_sewing'];
                $doc_type   = $row['doc_type'];
            }
        }else{
            $response['msg'] = 'Invalid Input. Please Check And Try Again !!!';
            $response['status'] = false;
			echo json_encode($response);
			die();
        }
        // to check ops dependency
		$ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$order_style_no' AND color =  '$order_col_des' AND ops_dependency != 200 AND ops_dependency != 0";
		//echo $ops_dep_qry;
		$result_ops_dep_qry = $link->query($ops_dep_qry);
		while($row = $result_ops_dep_qry->fetch_assoc()) 
		{
			if($row['ops_dependency'])
			{
                // $ops_dep_array[$row['ops_sequence']] = $row['ops_dependency'];
				if($row['ops_dependency'] == $op_no)
				{
					$ops_dep_code = $row['operation_code'];
					$schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = $bundle_no AND operation_id ='$ops_dep_code'";

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
                            $response['msg'] = 'The dependency operations for this operation are not yet done.';
                            $response['status'] = false;
                            
							echo json_encode($responseresponse);
							die();
						}
					}
				}
			}
        }
        // ops seq check
		$ops_seq_check = "select operation_code,ops_sequence, default_operration,smv,id from $brandix_bts.tbl_style_ops_master where style='$order_style_no' and color = '$order_col_des' and operation_code='$op_no'";

        $result_ops_seq_check = $link->query($ops_seq_check);
		if($result_ops_seq_check->num_rows > 0)
		{
			while($row = $result_ops_seq_check->fetch_assoc()) 
			{
				$sequnce = $row['ops_sequence'];
                $is_m3 = $row['default_operration'];
                $sfcs_smv = $row['smv'];
                $seq_id = $row['id'];
		        $ops_seq = $row['ops_sequence'];
                
			}
		}
		else
		{
            $response['msg'] = 'Invalid Operation for this barcode.Plese verify Operation Mapping.';
            $response['status'] = false;
            
			echo json_encode($response);
			die();
        }

        $ops_dep_qry = "SELECT ops_dependency,operation_code,ops_sequence FROM $brandix_bts.tbl_style_ops_master WHERE style='$order_style_no' AND color = '$order_col_des' and ops_sequence='$sequnce' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
        $result_ops_dep_qry = $link->query($ops_dep_qry);
        while($row = $result_ops_dep_qry->fetch_assoc()) 
        {
            $ops_dep = $row['ops_dependency'];
        }

        $dep_ops_array_qry_raw = "select operation_code from $brandix_bts.tbl_style_ops_master WHERE style='$order_style_no' AND color = '$order_col_des' and ops_dependency='$ops_dep'";
        $result_dep_ops_array_qry_raw = $link->query($dep_ops_array_qry_raw);
        while($row = $result_dep_ops_array_qry_raw->fetch_assoc()) 
        {
            $dep_ops_codes[] = $row['operation_code'];	
        }

        if($ops_dep)
        {
            $dep_ops_array_qry_seq = "select ops_dependency,operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='$order_style_no' AND color = '$order_col_des' AND ops_dependency != 200 AND ops_dependency != 0 group by ops_dependency";
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
            $ops_seq_qrs = "select ops_sequence from $brandix_bts.tbl_style_ops_master WHERE style='".$order_style_no."' AND color = '".$order_col_des."' AND operation_code in (".implode(',',$ops_dep_ary).")";
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

        $pre_ops_check = "select operation_code,ops_sequence from $brandix_bts.tbl_style_ops_master where style='".$order_style_no."' and color = '".$order_col_des."' and (ops_sequence = ".$ops_seq." or ops_sequence in  (".implode(',',$ops_seq_dep)."))";
        $result_pre_ops_check = $link->query($pre_ops_check);
        if($result_pre_ops_check->num_rows > 0)
        {
            while($row = $result_pre_ops_check->fetch_assoc()) 
            {
                if($row['ops_sequence'] != 0)
                {
                    $pre_ops_code[] = $row['operation_code'];
                }
            }
        }
        $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$order_style_no' and color = '$order_col_des' and ops_sequence = $ops_seq and id > $seq_id order by id limit 1";
        $result_post_ops_check = $link->query($post_ops_check);
        if($result_post_ops_check->num_rows > 0)
        {
            while($row = $result_post_ops_check->fetch_assoc()) 
            {
                $post_ops_code = $row['operation_code'];
            }
        }
        foreach($pre_ops_code as $index => $op_code)
	    {
            if($op_code != $b_op_id)
            {
                $b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";

                // temp table data query

                $b_query_temp[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`) VALUES";
            }
        }
        $m3_bulk_bundle_insert = "INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_remarks,sfcs_log_user,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref,m3_error_code) VALUES";

        $bulk_insert = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`) VALUES";
        // temp table data insertion query.........
        $bulk_insert_temp = "INSERT INTO $brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) VALUES";

        $schedule_query = "SELECT *,carton_act_qty as balance_to_report, 0 as reported_qty, 0 as rejected_qty, 'packing_summary_input' as flag FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = $job_number[0] order by tid";

        $result_style_data = $link->query($schedule_query);
        
    }
    $response['status'] = $status;
    $response['ops_codes'] = $pre_ops_code;
    $response['job_no'] = $input_job_no_random;
    $response['msg']    = 'done';

    echo json_encode($response);
?>