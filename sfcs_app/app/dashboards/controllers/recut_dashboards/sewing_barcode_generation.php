<?php
function issue_to_sewing($job_no,$size,$qty,$doc,$bcd_ids)
{
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

   $ops=array();
   $opst=array();
   $recut_doc = $doc;
   $sewing_cat = 'sewing';

   foreach($job_no as $key=>$value)
   {
        $ops = [];
	    $input_job_no = $job_no[$key];
	    $size_title = $size[$key];
	    $reported_qty = $qty[$key];
        $bcd_id = $bcd_ids[$key];
        $ops=array();
        $op_namem=array();

		
		$bcd_qry = "select style,schedule,assigned_module,operation_id,bundle_number,sfcs_smv,remarks,color from $brandix_bts.bundle_creation_data 
		where id in (".$bcd_id.") limit 1";
	    // echo $bcd_qry;
	    // die();
	    $result_bcd_qry = $link->query($bcd_qry);
		while($row = $result_bcd_qry->fetch_assoc()) 
	    {
	        $style = $row['style'];
	        $schedule = $row['schedule'];
	        $mapped_color = $row['color'];
	        $ops_code = $row['operation_id'];
	        $bundle_number = $row['bundle_number'];
	        $sfcs_smv = $row['sfcs_smv'];
	        $remarks = $row['remarks'];
	        $assigned_module = $row['assigned_module'];
        }
		
		$op_codes_query = "SELECT tor.operation_code,tor.operation_name FROM brandix_bts.tbl_orders_ops_ref AS tor LEFT JOIN `brandix_bts`.`tbl_style_ops_master` AS tosm ON tor.operation_code=tosm.operation_code WHERE category = 'sewing' AND display_operations='yes' AND style='$style' AND color='$mapped_color' ORDER BY operation_order*1 ";
		 $op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing');
		 while($row = mysqli_fetch_array($op_codes_result))
		 {
			$ops[]=$row['operation_code'];
			$op_namem[]=$row['operation_name'];
		 }

	    $first_sewing_op = "SELECT tor.operation_code FROM brandix_bts.tbl_orders_ops_ref AS tor LEFT JOIN `brandix_bts`.`tbl_style_ops_master` AS tosm ON tor.operation_code=tosm.operation_code WHERE category = 'sewing' AND display_operations='yes' AND style='$style' AND color='$mapped_color' ORDER BY operation_order*1 LIMIT 1";
	    $first_sewing_op_result = mysqli_query($link,$first_sewing_op) or exit('Problem in getting the first code for sewing');   
	    while($row_code = mysqli_fetch_array($first_sewing_op_result))
	    {
	        $op_code=$row_code['operation_code'];
	    }

        $checking_qry_plan_dashboard = "SELECT * FROM `$bai_pro3`.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no'";
        $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
        if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
        {   
            $insert_qry_ips = "INSERT INTO `$bai_pro3`.`plan_dashboard_input` 
            SELECT * FROM `$bai_pro3`.`plan_dashboard_input_backup`
            WHERE input_job_no_random_ref = '$input_job_no' order by input_trims_status desc limit 1";
            mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
        }	

        $get_mo = "select mo_no from $bai_pro3.mo_operation_quantites where ref_no = $bundle_number and op_code in (".implode(",",$ops).") order by mo_no*1 desc limit 1";
        $result_get_mo = $link->query($get_mo);
        while($row_mo = $result_get_mo->fetch_assoc())
        {
           $mo_no = $row_mo['mo_no'];
        }
 
        $pre_send_qty_qry = "select max(carton_act_qty) as bundle_qty,carton_act_qty,destination,packing_mode,sref_id,input_job_no,old_size,type_of_sewing from $bai_pro3.pac_stat_log_input_job where input_job_no_random = '$input_job_no' and size_code= '$size_title'";
            //echo $pre_send_qty_qry;
            //die();
        $result_pre_send_qty = $link->query($pre_send_qty_qry);
        while($row = $result_pre_send_qty->fetch_assoc()) 
        {
            $bundle_qty = $row['bundle_qty'];
            $carton_qty = $row['carton_act_qty'];
            $destination = $row['destination'];
            $packing_mode = $row['packing_mode'];
            $sref_id = $row['sref_id'];
            $input_job = $row['input_job_no'];
            $type_of_swng = $row['type_of_sewing'];
            $size_id = $row['old_size'];
        } 

        $job_counter_tmp1= echo_title("$bai_pro3.packing_summary_input","MAX(barcode_sequence)+1","input_job_no='".$input_job."' and order_del_no",$schedule,$link);
        if ($job_counter_tmp1 > 1)
        {
            $job_counter = $job_counter_tmp1;
        }
   
        while($reported_qty > 0)
        {
      
            if($reported_qty <= $bundle_qty)
            {
               $insert_pac_stat_log="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,doc_type,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id,barcode_sequence,type_of_sewing) values('".$recut_doc."','".$size_title."','R','".$reported_qty."','".$input_job."','".$input_job_no."','".$destination."','".$packing_mode."','".$size_id."','".$sref_id."','".$job_counter."','".$type_of_swng."')";

                mysqli_query($link, $insert_pac_stat_log) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
                $id = mysqli_insert_id($link);
                for($k=0;$k<sizeof($ops);$k++)
                {
                    if($ops[$k] == $op_code)
                    {
                      $insert_bcd="INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`) VALUES('".$style."','".$schedule."','".$mapped_color."','".$size_id."','".$size_title."','".$sfcs_smv."','".$id."','".$reported_qty."','".$reported_qty."',0,0,0,'".$ops[$k]."','".$recut_doc."','".date('Y-m-d')."','".$recut_doc."','".$input_job."','".$input_job_no."','".$shift."','".$assigned_module."','".$remarks."','".$mapped_color."','".$job_counter."','".$id."')";
                    }
                    else
                    {
                       $insert_bcd="INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`) VALUES('".$style."','".$schedule."','".$mapped_color."','".$size_id."','".$size_title."','".$sfcs_smv."','".$id."','".$reported_qty."',0,0,0,0,'".$ops[$k]."','".$recut_doc."','".date('Y-m-d')."','".$recut_doc."','".$input_job."','".$input_job_no."','".$shift."','".$assigned_module."','".$remarks."','".$mapped_color."','".$job_counter."','".$id."')";
                    }    
                     mysqli_query($link,$insert_bcd) or exit("Whille inserting into bcd2222".$insert_bcd.mysqli_error($GLOBALS["___mysqli_ston"]));

                     $moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no."', '".$id."','".$reported_qty."', '".$ops[$k]."', '".$op_namem[$k]."')";
                     mysqli_query($link,$moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                }


              
                $reported_qty=0;
                break;
            }
            else
            {
               $reported_qty -= $bundle_qty;
               $insert_pac_stat_log="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,doc_type,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id,barcode_sequence,type_of_sewing) values('".$recut_doc."','".$size_title."','R','".$bundle_qty."','".$input_job."','".$input_job_no."','".$destination."','".$packing_mode."','".$size_id."','".$sref_id."','".$job_counter."','".$type_of_swng."')";
                //echo  $insert_pac_stat_log;
               // die();
                mysqli_query($link, $insert_pac_stat_log) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"]));
                $id = mysqli_insert_id($link);

                for($k=0;$k<sizeof($ops);$k++)
                {
                    if($ops[$k] == $op_code)
                    {
                      $insert_bcd="INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`) VALUES('".$style."','".$schedule."','".$mapped_color."','".$size_id."','".$size_title."','".$sfcs_smv."','".$id."','".$bundle_qty."','".$bundle_qty."',0,0,0,'".$ops[$k]."','".$recut_doc."','".date('Y-m-d')."','".$recut_doc."','".$input_job."','".$input_job_no."','".$shift."','".$assigned_module."','".$remarks."','".$mapped_color."','".$job_counter."','".$id."')";
                    }
                    else
                    {
                       $insert_bcd="INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`,`mapped_color`,`barcode_sequence`,`barcode_number`) VALUES('".$style."','".$schedule."','".$mapped_color."','".$size_id."','".$size_title."','".$sfcs_smv."','".$id."','".$bundle_qty."',0,0,0,0,'".$ops[$k]."','".$recut_doc."','".date('Y-m-d')."','".$recut_doc."','".$input_job."','".$input_job_no."','".$shift."','".$assigned_module."','".$remarks."','".$mapped_color."','".$job_counter."','".$id."')";
                    }    
                     mysqli_query($link,$insert_bcd) or exit("Whille inserting into bcd111".mysqli_error($GLOBALS["___mysqli_ston"]));
                    // echo $insert_bcd;

                     $moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no."', '".$id."','".$bundle_qty."', '".$ops[$k]."', '".$op_namem[$k]."')";
                     //echo $moq_qry;
                     mysqli_query($link,$moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                }
            } 
            $job_counter++;  
        }
   }
}

?>