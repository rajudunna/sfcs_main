<?php 
     include("../../../../common/config/config.php");
     $username_list=explode('\\',$_SERVER['REMOTE_USER']);
	 $username=strtolower($username_list[1]);
     
?>

<?php
if(isset($_GET['style']) && isset($_GET['schedule']))
{
    
    $schedule=$_GET['schedule'];
    $style=$_GET['style'];
    $color=$_GET['color'];
    $doc_no=$_GET['doc_no'];
    
                $sql="SELECT * FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color' and input_job_no_random='$doc_no'";
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
                $rowcount=mysqli_num_rows($sql_result);
                $tid=array();
                while($sql_row=mysqli_fetch_array($sql_result))
                {


                            $carton_act_qty=$sql_row['carton_act_qty'];
                            $size_code=$sql_row['m3_size_code'];
                            $tid=$sql_row['tid'];
                            


                
                //$tid1=implode(",",array_unique($tid)); 
                // var_dump($size_code);die(); 
                $mo_operation_quantites_query="SELECT id,mo_no,bundle_quantity,op_code,op_desc FROM $bai_pro3.mo_operation_quantites WHERE ref_no =$tid and op_code='1'";
                //echo $mo_operation_quantites_query;
                $sql_result5=mysqli_query($link, $mo_operation_quantites_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row5=mysqli_fetch_array($sql_result5))
                {
                    $id=$sql_row5['id'];
                    $mo_no=$sql_row5['mo_no'];
                    $bundle_quantity=$sql_row5['bundle_quantity'];
                    $op_code=$sql_row5['op_code'];
                    $op_desc=$sql_row5['op_desc'];

                


                $operation_master_query="SELECT * FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code='1'";
                $sql_result1=mysqli_query($link, $operation_master_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row1=mysqli_fetch_array($sql_result1))
                {
                    $workcenter_id=$sql_row1['work_center_id'];

                }
            
                // $get_modetails="SELECT * FROM $bai_pro3.mo_details WHERE style='$style' and schedule='$schedule' and color='$color' and size ='$size_code'";
                // $get_modetails_result=mysqli_query($link, $get_modetails) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                // while($sql_row4=mysqli_fetch_array($get_modetails_result))
                // {
                //     $mo_no=$sql_row4['mo_no'];

                // }




                $insert_query="insert into $bai_pro3.m3_transactions (quantity,log_user,mo_no,op_code, op_des,ref_no, workstation_id,m3_ops_code) values ('$bundle_quantity', '$username','$mo_no', '$op_code', '$op_desc','$id','$workcenter_id','$op_code')";
                $insert_query_result=mysqli_query($link, $insert_query) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                }
    //echo "<h1 style=\"color:green;font-size:26px\">Confirmed</h1>";
            }
            echo "<h1 style=\"color:green;font-size:26px\">Confirmed</h1>";
            
 }
?>
