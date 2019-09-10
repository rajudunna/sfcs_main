<?php
   
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    error_reporting(0);
    $ops_code=$_POST['ops_code'];
    $module = $_POST['module'];
    $barcode = $_POST['barcode'];

    $barcode_number = explode('-', $barcode)[0];
    $selct_qry = "select * from $brandix_bts.bundle_creation_data where barcode_number = '$barcode_number'";
    $selct_qry_result=mysqli_query($link,$selct_qry) or exit("while retriving bundle_number".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($selct_qry_result->num_rows > 0)
    {       
        $selct_qry_result_row = mysqli_fetch_assoc($selct_qry_result);
        $style = $selct_qry_result_row['style'];
        $color = $selct_qry_result_row['color'];
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
                echo " Module Transfered successfully";

                }else
                {
                    $result_array['status'] = 'Previous operation not completed';
                    echo json_encode($result_array);
                }
            }
            else
            {
                $result_array['status'] = 'Partially Scanned';
                echo json_encode($result_array);
            } 
            

        }    
        else
        {
            $result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
            echo json_encode($result_array);
        }
?>