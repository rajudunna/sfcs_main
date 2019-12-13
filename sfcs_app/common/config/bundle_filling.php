<?php
//plan bundles generation
function plan_cut_bundle($docket_no) {	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    
	$username = getrbac_user()['uname'];

	$category=['cutting','Send PF','Receive PF'];
	$operation_codes = array();
	foreach($category as $key => $value)
	{
		$fetching_ops_with_category = "SELECT operation_code,short_cut_code FROM brandix_bts.tbl_orders_ops_ref WHERE category = '".$category[$key]."'";
		// echo $fetching_ops_with_category;
		$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit("Bundles Query Error 1423");
		while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
		{
			$operation_codes[] = $row['operation_code'];
			$short_key_code[] = $row['short_cut_code'];
		}
	}
	$cut_done_qty = array();
	$plan_size_cut = array();

	
	$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = $docket_no ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		$org_doc = $row['org_doc_no'];
        $order_tid = $row['order_tid'];
        $plies_per_cut = $row['p_plies'];

		$get_exact_size_code = "SELECT * FROM $bai_pro3.bai_orders_db_confirm 
										WHERE order_tid = '".$order_tid."'";
		$sql_query_size_code = mysqli_query($link,$get_exact_size_code) or exit("bai_orders_db_confirm Error 1423");
		while($row_size=mysqli_fetch_array($sql_query_size_code))
		{
			for($ii=0;$ii<sizeof($sizes_array);$ii++)
			{
				if($row_size["title_size_".$sizes_array[$ii].""]<>"")
				{
					$check_upto[]=$sizes_array[$ii];
				}
			}
		}			
		
		for ($i=0; $i < sizeof($check_upto); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
				$plan_size_cut[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]];
			}
			else
			{
				$cut_done_qty[$sizes_array[$i]] =0;
				$plan_size_cut[$sizes_array[$i]] =0;
			}
		}
	}
	foreach($cut_done_qty as $key => $value)
	{
		if($value>0)
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

			$bundle_no=1;
			//size wise ratio numbers
			$ratio_number = $plan_size_cut[$key];
			for($m = $ratio_number; $m > 0; $m--)
			{
				$bundle_query = "SELECT max(bundle_no) as bundle_no from $bai_pro3.plan_cut_bundle where doc_no=$docket_no";
				$bundle_result = mysqli_query($link,$bundle_query);
				while($bun=mysqli_fetch_array($bundle_result))
				{
					$bundle_no = $bun['bundle_no']+1;
				}	
				$barcode=$docket_no.'-'.$bundle_no;

				$plan_cut_insert_query = "insert into $bai_pro3.plan_cut_bundle(`doc_no`,`style`,`color`,`size_code`,`size`,`bundle_no`,`plies`,`barcode`,`tran_user`) values ('".$docket_no."','".$b_style."','".$b_colors."','".$b_size_code."','".$b_sizes."','".$bundle_no."','".$plies_per_cut."','".$barcode."','".$username."')";
				$plan_cut_insert_query_res = $link->query($plan_cut_insert_query);
				$plan_cut_insert_id = mysqli_insert_id($link);
				foreach($operation_codes as $index => $op_code)
				{
					$plan_cut_insert_transactions_query = "insert into $bai_pro3.plan_cut_bundle_trn(`plan_cut_bundle_id`,`ops_code`,`rec_qty`,`original_qty`,`good_qty`,`rejection_qty`,`tran_user`,`status`) values ('".$plan_cut_insert_id."','".$op_code."','0','".$plies_per_cut."','0','0','".$username."','1')";
					$plan_cut_insert_transactions_query_res = $link->query($plan_cut_insert_transactions_query);
			
				}
			}

		}
	}
}



function plan_logical_bundles($dono,$plan_jobcount,$plan_bundleqty,$inserted_id,$schedule) {	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    $doc_type = 'N';
    $packing_mode = 1;
    $destination = '';

    //get input job number for each schedule
    $old_jobs_count_qry1 = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.packing_summary_input WHERE order_del_no='".$schedule."'";
    $old_jobs_count_res1 = mysqli_query($link, $old_jobs_count_qry1) or exit("Sql Error : old_jobs_count_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($old_jobs_count_res1)>0)
    {
        while($max_oldqty_jobcount1 = mysqli_fetch_array($old_jobs_count_res1))
        {
            if($max_oldqty_jobcount1['result'] > 0) {
                $input_job_num=$max_oldqty_jobcount1['result'];
            } else {
                $input_job_num=1;
            }
        }
    } else {
        $input_job_num=1;
    }
    //get destination to fill logical bundle
    $sql="select destination from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
    $sql_result=mysqli_query($link, $sql) or exit("Sql bai_orders_db_confirm".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($sql_result)>0)
    {
        while($sql_row = mysqli_fetch_array($sql_result))
        {
            $destination = $sql_row['destination'];
        }
    }
    $plan_jobcount1= $plan_jobcount;
    $plan_cut_bundle_qry = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no=$dono";
    $plan_cut_bundle_res = mysqli_query($link, $plan_cut_bundle_qry) or exit("Sql Error : plan_cut_bundle_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    if(mysqli_num_rows($plan_cut_bundle_res)>0)
    {
        
        while($plan_cut_bundle_row = mysqli_fetch_array($plan_cut_bundle_res))
        {
            $size = $plan_cut_bundle_row['size'];
            $size_code = $plan_cut_bundle_row['size_code'];
            $plan_cut_bundle_id = $plan_cut_bundle_row['id'];
            $size_plies = $plan_cut_bundle_row['plies'];
            do {
                if($size_plies >= $plan_bundleqty){
                    $reported_qty = $plan_bundleqty;
                } else {
                    $reported_qty = $size_plies;
                }
                if($plan_jobcount1 < $reported_qty){
                    $plan_jobcount1=$plan_jobcount;
                    $input_job_num++;
                }
                
                $input_job_num_rand=$schedule.date("ymd").$input_job_num;
                // doc_no, size_code, carton_act_qty,input_job_no, input_job_no_random,destination,packing_mode,old_size,doc_type,type_of_sewing,pac_seq_no,barcode_sequence,sref_id
                $ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` 
                (
                    doc_no, size_code, carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,pac_seq_no,sref_id,plan_cut_bundle_id
                )
                VALUES
                ( 
                    '".$dono."', 
                    '".$size."', 
                    '".$reported_qty."', 
                    '".$input_job_num."', 
                    '".$input_job_num_rand."', 
                    '".$destination."', 
                    '".$packing_mode."',
                    '".$size_code."',
                    '".$doc_type."',
                    '-1',
                    $inserted_id,
                    $plan_cut_bundle_id
                );
                ";
                $result_time = mysqli_query($link, $ins_qry) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
                $size_plies = $size_plies - $reported_qty;
                $plan_jobcount1 = $plan_jobcount1 - $reported_qty;
                $count++;
            } while ($size_plies > 0);
    
        }
        // update count of plan logical bundles for each sewing job
        $update_query = "UPDATE `bai_pro3`.`sewing_jobs_ref` set bundles_count = $count where id = '$inserted_id' ";
        $update_result = mysqli_query($link,$update_query) or exit("Problem while inserting to sewing jos ref");
    }
}


?>