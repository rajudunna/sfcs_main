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
     while($sql_row=mysqli_fetch_array($sql_result))
    {
    $carton_act_qty=$sql_row['carton_act_qty'];
  
                $operation_master_query="SELECT * FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code='1'";
                $sql_result1=mysqli_query($link, $operation_master_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row1=mysqli_fetch_array($sql_result1))
                {
                    $operation_name=$sql_row1['operation_name'];
                    $operation_code=$sql_row1['operation_code'];
                    $operation_description=$sql_row1['operation_description'];
                    $workcenter_id=$sql_row1['work_center_id'];

                }

                $insert_query="insert into $bai_pro3.m3_transactions (quantity,log_user,op_code, op_des, workstation_id,m3_ops_code) values ('$carton_act_qty', '$username', '$operation_code', '$operation_description','$workcenter_id','$operation_code')";
                $insert_query_result=mysqli_query($link, $insert_query) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                //echo $insert_query;
    } 
    echo "<h1 style=\"color:green;font-size:26px\">Confirmed</h1>";
 }
?>
