
<?php 
 //include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
  
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
	// include('mssql_conn.php');
    $conn = odbc_connect($serverName,$uid,$pwd);
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
    $seq_no=$_GET['seq_no'];
  
    
                $sql="SELECT * FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color' and input_job_no_random='$doc_no'";
               
               
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
                $rowcount=mysqli_num_rows($sql_result);
               // $tid=array();
                while($sql_row=mysqli_fetch_array($sql_result))
                {


                            $carton_act_qty=$sql_row['carton_act_qty'];
                            $size_code=$sql_row['m3_size_code'];
                            $tid=$sql_row['tid'];
                            $input_job_no=$sql_row['input_job_no'];
                            $order_del_no=$sql_row['order_del_no'];
                            $date=date('Ymd');


                            $sql14="SELECT * FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color'";
                           
                           
                            $sql_result14=mysqli_query($link, $sql14) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row14=mysqli_fetch_array($sql_result14))
                            {
                                $co_no=$sql_row14['co_no'];
                            }
                 

                  $employee_no=$order_del_no."-".$input_job_no."</br>";
                  $remarks=$order_del_no."-".$date."</br>";
                
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
            
              
                $insert_query="insert into $bai_pro3.m3_transactions (quantity,log_user,mo_no,op_code, op_des,ref_no, workstation_id,m3_ops_code) values ('$bundle_quantity', '$username','$mo_no', '$op_code', '$op_desc','$id','$workcenter_id','$op_code')";
                $insert_query_result=mysqli_query($link, $insert_query) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                $last_inserted_id =  mysqli_insert_id($link); 
                $sql_num_check1=mysqli_num_rows($insert_query_result);

               if($insert_query_result){
                $mssql_insert_query="insert into [MRN_V2].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status) values ('$company_no', '$facility_code','$mo_no', '$op_code', '$bundle_quantity','$employee_no','$remarks','$co_no','$order_del_no','')";
                $mssql_insert_query_result = odbc_exec($conn, $mssql_insert_query);
                $sql_num_check5=mysqli_num_rows($mssql_insert_query_result);
                    if($mssql_insert_query_result){
                        $pass_update="update $bai_pro3.m3_transactions set response_status='pass' where id='$last_inserted_id'";
                        $pass_update_result=mysqli_query($link, $pass_update) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                        // $query7="select * from $bai_pro3.m3_transactions where id='$last_inserted_id'";
                        // $query7_result=mysqli_query($link, $query7) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                        // while($query7_result7=mysqli_fetch_array($query7_result))
                        // {
                        //     $rollback_ref_num=$query7_result7['ref_no'];
        
                        // }
                        $query8="select * from $bai_pro3.mo_operation_quantites where id='$id'";
                        $query8_result=mysqli_query($link, $query8) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($query8_result8=mysqli_fetch_array($query8_result))
                        {
                            $mo_ref_num=$query5_result8['ref_no'];
        
                        }
                        $pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='1' where tid='$mo_ref_num'";
                        $pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));


                    }else{
                        $fail_update="update $bai_pro3.m3_transactions set response_status='fail' where id='$last_inserted_id'";
                        $fail_update_result=mysqli_query($link, $fail_update) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                        
                    }
               }
               else{

                // $query5="select * from $bai_pro3.m3_transactions where id='$last_inserted_id'";
                // $query5_result=mysqli_query($link, $query5) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                // while($query5_result5=mysqli_fetch_array($query5_result))
                // {
                //     $rollback_ref_no=$query5_result5['ref_no'];

                // }
                $query8="select * from $bai_pro3.mo_operation_quantites where id='$id'";
                $query8_result=mysqli_query($link, $query8) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($query8_result8=mysqli_fetch_array($query8_result))
                {
                    $mo_ref_num=$query8_result8['ref_no'];

                }
                $fail_update="update $bai_pro3.pac_stat_log_input_job set mrn_status='0' where tid='$mo_ref_num'";
                $fail_update_result=mysqli_query($link, $fail_update) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
               }
                

                
                }
    //echo "<h1 style=\"color:green;font-size:26px\">Confirmed</h1>";
            }
    
        $sql="select * from $brandix_bts.tbl_orders_style_ref where product_style='$style'";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
        while($sql_row10=mysqli_fetch_array($sql_result))
        {
            $id=$sql_row10['id'];
        }
        $sql8="select * from $brandix_bts.tbl_orders_master where product_schedule='$schedule'";
        $sql_result8=mysqli_query($link, $sql8) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result8);
        while($sql_row11=mysqli_fetch_array($sql_result8))
        {
            $schedule_id=$sql_row11['id'];
        }
        // if (mysqli_query($link, $insert_query)){
           // echo "<h1 style=\"color:green;font-size:26px\">Confirmed</h1>";
           echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
		function Redirect() {
            sweetAlert('Confirmed','','success');
            location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
            
			}
		</script>";
		
        // }else{

        //     echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
        //     function Redirect() {
        //         sweetAlert('No Records for Mo Operation Quantites Table','','warning');
        //         location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
                
        //         }
        //     </script>"; 
        // }     
 }
?>
