
<?php 
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config_jobs.php',4,'R')); 
    $conn =odbc_connect("$driver_name;Server=$serverName;Database=MRN_V2;", $uid,$pwd);   
?>

<?php
if(isset($_GET['style']) && isset($_GET['schedule']))
{
    
                    $schedule=$_GET['schedule'];
                    $style=$_GET['style'];
                    $color=$_GET['color'];
                    $doc_no=$_GET['doc_no'];
                    $seq_no=$_GET['seq_no'];
                    $co_no ="";
    
                    $sql14="SELECT co_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color'";
                    $sql_result14=mysqli_query($link, $sql14) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row14=mysqli_fetch_array($sql_result14))
                    {
                        $co_no=$sql_row14['co_no'];
                    }
                    $sql="SELECT carton_act_qty,m3_size_code,tid,input_job_no,order_del_no  FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color' and input_job_no_random='$doc_no'";
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
               //$rowcount=mysqli_num_rows($sql_result);
              // $tid=array();

                    while($sql_row=mysqli_fetch_array($sql_result))
                    {


                            $carton_act_qty=$sql_row['carton_act_qty'];
                            $size_code=$sql_row['m3_size_code'];
                            $tid=$sql_row['tid'];
                            $input_job_no=$sql_row['input_job_no'];
                            $order_del_no=$sql_row['order_del_no'];
                            $date=date('Ymd');
                
                            $employee_no=$order_del_no."-".$input_job_no."</br>";
                            $remarks=$order_del_no."-".$date."</br>";
                            
                            $tid1=implode(",",array_unique($tid)); 
                            // var_dump($size_code);die(); 
                            $mo_operation_quantites_query="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid1) and op_code=1 group by mo_no";
                            //echo $mo_operation_quantites_query;
                            $sql_result5=mysqli_query($link, $mo_operation_quantites_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                            try
                            {
                            mysqli_begin_transaction();
                            while($sql_row5=mysqli_fetch_array($sql_result5))
                            {
                                $id=$sql_row5['id'];
                                $mo_no=$sql_row5['mo_no'];
                                $bundle_quantity=$sql_row5['bundle_quantity'];
                                $op_code=$sql_row5['op_code'];
                                $op_desc=$sql_row5['op_desc'];

              
                                $mssql_insert_query="insert into [MRN_V2].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status) values ('$company_no', '$facility_code','$mo_no', '$op_code', '$bundle_quantity','$employee_no','$remarks','$co_no','$order_del_no','')";
                                $mssql_insert_query_result = odbc_exec($conn, $mssql_insert_query);
                                $sql_num_check5=odbc_num_rows($mssql_insert_query_result);
                                
                
                                if($sql_num_check5>0){

                                            $mo_query="select ref_no from $bai_pro3.mo_operation_quantites where mo_no='$mo_no' and op_code=1";
                                            $mo_query_result=mysqli_query($link, $mo_query) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));

                                            while($sql_row16=mysqli_fetch_array($mo_query_result))
                                            {
                                                $mo_ref_no=$sql_row16['ref_no'];
                                                $pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='1' where tid='$mo_ref_no'";
                                                $pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            }

                                        }
                    // else{

                    //     $mo_query1="select * from $bai_pro3.mo_operation_quantites where mo_no='$mo_no'";
                    //     $mo_query_result1=mysqli_query($link, $mo_query1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                    //     while($sql_row17=mysqli_fetch_array($mo_query_result1))
                    //     {
                    //     $mo_ref_no1=$sql_row17['ref_no'];  
                    //     $fail_update="update $bai_pro3.pac_stat_log_input_job set mrn_status='0' where tid='$mo_ref_no1'";
                    //     $fail_update_result=mysqli_query($link, $fail_update) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
                    //     }
                                     }       
               
               
                
                            mysqli_commit($conn);
                            }
                            catch (Exception $e){
                                mysqli_rollback($conn);                                                                                
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
