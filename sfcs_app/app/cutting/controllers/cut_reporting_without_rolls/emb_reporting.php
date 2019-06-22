<?php

 // $doc_nos='20563';
 // $style='A0737SS9';
 // $color='CHINTZ ROSE';
 //  emblishment_quantities(20563,'A0737SS9','CHINTZ ROSE');

function emblishment_quantities($doc_no,$style,$color)
{
	$doc_no = explode(",",$doc_no);
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
	error_reporting(0);
    $emb_category = 'Send PF';
    $op_code = 15;

    foreach($doc_no as $doc_nos )
    {
	    $get_operations = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category ='$emb_category'";
		//echo $get_operations;
		$result_ops_qry = $link->query($get_operations);
		while($row1 = $result_ops_qry->fetch_assoc())
		{
		  $operations[] = $row1['operation_code'];
		}

		$qry_to_find_in_out = "select * from $brandix_bts.bundle_creation_data where docket_number='$doc_nos'";
		//echo $qry_to_find_in_out;
	    $qry_to_find_in_out_result = $link->query($qry_to_find_in_out);
	    if(mysqli_num_rows($qry_to_find_in_out_result) > 0)
	    {
	        $reported_status = 'P';
	        
	        //$plies = $_GET['plies'];
	        $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_nos'";
	        $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	        while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	        {
	            $plies = $row['a_plies'];
	            // $doc_array[$row['doc_no']] = $row['act_cut_status'];
	            $p_plies = $row['p_plies'];
	            $a_plies = $row['a_plies'];	
	            if($p_plies == $a_plies){
	                $reported_status = 'F';			
	            }	
	            for ($i=0; $i < sizeof($sizes_array); $i++)
	            { 
	                if ($row['a_'.$sizes_array[$i]] > 0)
	                {
	                    $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies;
	                }
	            }
	        }

	    }

		    foreach ($cut_done_qty as $key => $value)
		   {
			    $category=['cutting'];
			    $emb_operations = implode(',',$operations);
				// $get_previous_ops = "select previous_operation FROM $brandix_bts.default_operation_workflow where operation_code in ($emb_operations)";
				// //echo $get_previous_ops;
				// $result_prev_qry = $link->query($get_previous_ops);
				// while($row_prev = $result_prev_qry->fetch_assoc())
				// {
			 //       $prev_operation[] = $row_prev['previous_operation'];

				// } 
				// $previous_operations = implode(',',$prev_operation);


				$ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code='$op_code'";
				//echo $ops_seq_check;
				$result_ops_seq_check = $link->query($ops_seq_check);
				while($row2 = $result_ops_seq_check->fetch_assoc()) 
				{
					$ops_seq = $row2['ops_sequence'];
					$seq_id = $row2['id'];
					$ops_order = $row2['operation_order'];

				}
	

				$post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq'  AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code not in (10,200) ORDER BY operation_order ASC LIMIT 1";
				//echo $post_ops_check;
				$result_post_ops_check = $link->query($post_ops_check);
				if($result_post_ops_check->num_rows > 0)
				{
					while($row3 = $result_post_ops_check->fetch_assoc()) 
					{
						$post_ops_code = $row3['operation_code'];
					}
				}

				$pre_ops_check = "select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND operation_code = '$post_ops_code'";
				//echo $pre_ops_check;
				$result_pre_ops_check = $link->query($pre_ops_check);
				if($result_pre_ops_check->num_rows > 0)
				{
					while($row22 = $result_pre_ops_check->fetch_assoc()) 
					{
						$previous_operation = $row22['previous_operation'];
					}
				}
				else
				{
					$previous_operation = '';
				}

				$get_previous_category = "select category FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code = $previous_operation";
				//echo $get_previous_category;
				$result_cat_qry = $link->query($get_previous_category);
				while($row_cat = $result_cat_qry->fetch_assoc())
				{
			       $cutting_category = $row_cat['category'];
				}
                
                
                 if(in_array($cutting_category,$category))
				{
                   $update_qry_post = "update $brandix_bts.bundle_creation_data set send_qty = send_qty+$value WHERE docket_number = '$doc_nos' AND size_id = '$key' AND operation_id in ($emb_operations) AND operation_id NOT IN ($post_ops_code)";
				    //echo $update_qry_post;
				    $updating_post_ops = mysqli_query($link,$update_qry_post) or exit("While updating cps".mysqli_error($GLOBALS["___mysqli_ston"]));

				    // $update_cps_query = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty+$value,
        //                     reported_status = '$reported_status' 
        //                     where doc_no = $doc_nos and size_code='$key' and operation_code in ($emb_operations) AND operation_id NOT IN ($post_ops_code)";
        //             $update_cps_result = mysqli_query($link,$update_cps_query); 
				}
                
				
			
		    }
		    unset($operations);
		    unset($cut_done_qty);

    }	
}


	

?>