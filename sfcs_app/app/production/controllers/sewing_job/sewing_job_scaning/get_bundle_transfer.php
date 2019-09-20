<?php
   
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    error_reporting(0);
    $ops_code=$_POST['ops_code'];
    $module = $_POST['module'];
    $barcode = $_POST['barcode'];
    $barcode_number = explode('-', $barcode)[0];
   
    $application='IPS'; 
			$scanning_query="select operation_name,operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
			
			$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($scanning_result))
			{
			  $operation_name=$sql_row['operation_name'];
              $operation_code_ims=$sql_row['operation_code'];
            }

    $selct_qry = "select style,color,assigned_module,original_qty,schedule from $brandix_bts.bundle_creation_data where barcode_number = $barcode_number and operation_id=$ops_code";
    $selct_qry_result=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($selct_qry_result->num_rows > 0)
    {       
        $selct_qry_result_row = mysqli_fetch_assoc($selct_qry_result);
        $style = $selct_qry_result_row['style'];
        $color = $selct_qry_result_row['color'];
        $from_module = $selct_qry_result_row['assigned_module'];
        $result_array['from_module'] = $selct_qry_result_row['assigned_module'];
        $result_array['schedule'] = $selct_qry_result_row['schedule'];
        $result_array['original_qty'] = $selct_qry_result_row['original_qty'];
        // echo $original_qty;
        $check_prev_operation = "SELECT * FROM `brandix_bts`.`tbl_style_ops_master` WHERE style ='$style' AND color='$color' AND operation_code ='$ops_code'";
        $prev_result=mysqli_query($link,$check_prev_operation) or exit("while retriving prev".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $selct_qry_result_row1 = mysqli_fetch_assoc($prev_result);

        $operation_order = $selct_qry_result_row1['operation_order'];

        $check_present="select if((recevied_qty+rejected_qty=0),1,0) as pre_otp from $brandix_bts.bundle_creation_data WHERE bundle_number='$barcode_number' and operation_id='$ops_code'";
        $present_check_result=mysqli_query($link,$check_present) or exit("while retriving present".mysqli_error($GLOBALS["___mysqli_ston"]));
        $check_present_row = mysqli_fetch_assoc($present_check_result);
        $check_output = $check_present_row['pre_otp'];

        if($check_output==1)
        {

            $get_opcode = "SELECT * FROM `brandix_bts`.`tbl_style_ops_master` WHERE style ='$style' AND color='$color' AND operation_order < '$operation_order' ORDER BY operation_order DESC LIMIT 1";
            $get_opcode_res=mysqli_query($link,$get_opcode) or exit("while retriving prev".mysqli_error($GLOBALS["___mysqli_ston"]));
            $get_opcode_res_row = mysqli_fetch_assoc($get_opcode_res);
            $operation_code_prev = $get_opcode_res_row['operation_code'];
            
                
            $present = "select IF(original_qty=SUM(recevied_qty+rejected_qty),1,0) AS otp from $brandix_bts.bundle_creation_data WHERE bundle_number='$barcode_number' and operation_id='$operation_code_prev'";          

            $present_result=mysqli_query($link,$present) or exit("while retriving present".mysqli_error($GLOBALS["___mysqli_ston"]));
            $present_row = mysqli_fetch_assoc($present_result);
            $output = $present_row['otp'];
            
                if($output==1)
                {
                    $assign_module="update $brandix_bts.bundle_creation_data set assigned_module='$module' where bundle_number='$barcode_number' and operation_id >='$ops_code'";
                    $assign_module_result=mysqli_query($link,$assign_module) or exit("while retriving assigned_module".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $ims_update="update $bai_pro3.ims_log set ims_mod_no='$module' where pac_tid='$barcode_number' and operation_id='$operation_code_ims'";
                    $ims_update_result=mysqli_query($link,$ims_update) or exit("while retriving assigned_module".mysqli_error($GLOBALS["___mysqli_ston"]));
                   
                    $insert_log="insert into $brandix_bts.module_transfer_track (username,bundle_number,operation_code,from_module,to_module,time) values ('$user','$barcode_number','$ops_code','$from_module','$module',NOW())";
                    $sql_result0=mysqli_query($link, $insert_log) or exit("Sql Error5.0".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $result_array['flag']=0; 
                    $result_array['status'] = 'Module Transferred Successfully';
                    echo json_encode($result_array);
                    //echo "Module Transferred Successfully";

                }else
                {   
                    $result_array['flag']=1;
                    $result_array['status'] = 'Previous operation not completed';
                    echo json_encode($result_array);
                }
            }
            else
            {   
                $result_array['flag']=1;
                $result_array['status'] = 'Partially Scanned';
                echo json_encode($result_array);
            } 
            

        }    
        else
        {   
            $result_array['flag']=1;
            $result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
            echo json_encode($result_array);
        }
?>