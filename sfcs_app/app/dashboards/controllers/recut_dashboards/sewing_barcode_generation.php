<?php
function issue_to_sewing($job_no,$size,$qty,$doc)
{
   include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

   $ops=array();
   $opst=array();
   $recut_doc = $doc;
   $sewing_cat = 'sewing';

   foreach($job_no as $key=>$value)
   {
	    $input_job_no = $job_no[$key];
	    $size_title = $size[$key];
	    $reported_qty = $qty[$key];

	    $op_codes_query = "SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref 
	                    WHERE category = '$sewing_cat'";
	    $op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing');   
	    while($row = mysqli_fetch_array($op_codes_result))
	    {
	        $opst[]=$row['operation_code'];
	        $op_namem[]=$row['operation_name'];
	    }

	    $first_sewing_op = "SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref 
	                    WHERE category = '$sewing_cat' limit 1";
	    $first_sewing_op_result = mysqli_query($link,$first_sewing_op) or exit('Problem in getting the first code for sewing');   
	    while($row_code = mysqli_fetch_array($first_sewing_op_result))
	    {
	        $op_code=$row_code['operation_code'];
	    }

	    $checking_qry_plan_dashboard = "SELECT * FROM `$bai_pro3`.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no'";
        $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
        if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
        {   
            $insert_qry_ips = "INSERT IGNORE INTO `$bai_pro3`.`plan_dashboard_input` 
            SELECT * FROM `$bai_pro3`.`plan_dashboard_input_backup`
            WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
            mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

	    $bcd_qry = "select style,schedule,mapped_color,assigned_module,operation_id,bundle_number,sfcs_smv,remarks from $brandix_bts.bundle_creation_data where input_job_no_random_ref = $input_job_no limit 1";
	     // echo $bcd_qry;
	     // die();
	    $result_bcd_qry = $link->query($bcd_qry);
	    while($row = $result_bcd_qry->fetch_assoc()) 
	    {
	        $style = $row['style'];
	        $schedule = $row['schedule'];
	        $mapped_color = $row['mapped_color'];
	        $ops_code = $row['operation_id'];
	        $bundle_number = $row['bundle_number'];
	        $sfcs_smv = $row['sfcs_smv'];
	        $remarks = $row['remarks'];
	        $assigned_module = $row['assigned_module'];
        }

        $get_mo = "select mo_no from $bai_pro3.mo_operation_quantites where ref_no = $bundle_number";
        $result_get_mo = $link->query($get_mo);
        while($row_mo = $result_get_mo->fetch_assoc())
        {
           $mo_no = $row_mo['mo_no'];
        }

        $pre_send_qty_qry = "select max(carton_act_qty) as bundle_qty,carton_act_qty,destination,packing_mode,sref_id,input_job_no,old_size from $bai_pro3.pac_stat_log_input_job where input_job_no_random = '$input_job_no' and size_code= '$size_title'";
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
            $size_id = $row['old_size'];
        } 

        $job_counter_tmp1= echo_title("$bai_pro3.packing_summary_input","MAX(barcode_sequence)+1","input_job_no='".$input_job."' and order_del_no",$schedule,$link);
        if ($job_counter_tmp1 > 1)
        {
            $job_counter = $job_counter_tmp1;
        }

        $ops=array_unique($opst);

   
        while($reported_qty > 0)
        {
      
            if($reported_qty <= $bundle_qty)
            {
               $insert_pac_stat_log="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,doc_type,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id,barcode_sequence) values('".$recut_doc."','".$size_title."','R','".$reported_qty."','".$input_job."','".$input_job_no."','".$destination."','".$packing_mode."','".$size_id."','".$sref_id."','".$job_counter."')";

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
                     mysqli_query($link,$insert_bcd) or exit("Whille inserting into bcd2222".mysqli_error($GLOBALS["___mysqli_ston"]));

                     $moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no."', '".$id."','".$reported_qty."', '".$ops[$k]."', '".$op_namem[$k]."')";
                     mysqli_query($link,$moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                }


              
                $reported_qty=0;
                break;
            }
            else
            {
               $reported_qty -= $bundle_qty;
               $insert_pac_stat_log="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,doc_type,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id,barcode_sequence) values('".$recut_doc."','".$size_title."','R','".$bundle_qty."','".$input_job."','".$input_job_no."','".$destination."','".$packing_mode."','".$size_id."','".$sref_id."','".$job_counter."')";
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
        }
   }
}

?>