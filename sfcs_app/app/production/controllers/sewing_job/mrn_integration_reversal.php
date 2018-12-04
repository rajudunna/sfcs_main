
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$conn = odbc_connect("$ms_sql_driver_name;Server=$ms_sql_odbc_server;Database=$mssql_db;", $ms_sql_odbc_user,$ms_sql_odbc_pass);
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
					
                        $sql_result14=mysqli_query($link, $sql14) or exit("Sql Error71".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row14=mysqli_fetch_array($sql_result14))
                        {
                            $co_no=$sql_row14['co_no'];
                        }
    
                        $sql55="SELECT group_concat(tid SEPARATOR ',' ) as tid,input_job_no,order_del_no  FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' and order_style_no='$style' and order_col_des='$color' and input_job_no_random='$doc_no'";
                        $sql_result01=mysqli_query($link, $sql55) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
                        // $tid=array();
                        while($sql_row01=mysqli_fetch_array($sql_result01))
                        {

                            $tid=$sql_row01['tid'];
                            $input_job_no=$sql_row01['input_job_no'];
                            $order_del_no=$sql_row01['order_del_no'];
                            $date=date('Ymd');

                            $employee_no=$order_del_no."-".$input_job_no;
                            $remarks=$order_del_no."-".$date;
                
                           // $tid1=implode(",",array_unique($tid)); 
                            // var_dump($size_code);die(); 
                            $mo_operation_quantites_query="SELECT mo_no,sum(bundle_quantity) as bundle_quantity,op_code,op_desc,ref_no FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($tid) and op_code='1' group by mo_no";
                            //echo $mo_operation_quantites_query;


                            $mssql_insert_query="insert into [MRN_V2].[dbo].[M3_MRN_Link] (Company,Facility,MONo,OperationNo, ManufacturedQty,EmployeeNo,Remark,CONO,Schedule,Status) values";
                            $values = array();
            
                            $sql_result5=mysqli_query($link, $mo_operation_quantites_query) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($sql_row5=mysqli_fetch_array($sql_result5))
                                {
                                    $id=$sql_row5['id'];
                                    $mo_no=$sql_row5['mo_no'];
                                    $bundle_quantity=$sql_row5['bundle_quantity']*-1;
                                    $op_code=$sql_row5['op_code'];
                                    $op_desc=$sql_row5['op_desc'];
                                    $ref_no=$sql_row5['ref_no'];

                                    array_push($values, "('" . $company_no . "','" . $facility_code . "','" . $mo_no . "','" . $op_code . "','" . $bundle_quantity . "','".$employee_no."','".$remarks."','".$co_no."','".$order_del_no."','')"); 
               
                                }

                                $mssql_insert_query_result=odbc_exec($conn, $mssql_insert_query . implode(', ', $values));
			                    $sql_num_check5=odbc_num_rows($mssql_insert_query_result);
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
                                if($sql_num_check5>0){
                                    $pass_update1="update $bai_pro3.pac_stat_log_input_job set mrn_status='0' where tid='$ref_no'";
                                    $pass_update1_result=mysqli_query($link, $pass_update1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
            
                                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
                                    function Redirect() {
                                    sweetAlert('MRN Reversal successfully Completed','','success');
                                    location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
            
                                    }
                                    </script>";
                                }
                                else{
                                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
                                    function Redirect() {
                                    sweetAlert('Reversal Failed','','success');
                                    location.href = \"".getFullURLLevel($_GET['r'], "sewing_job_create_mrn.php", "0", "N")."&style=$id&schedule=$schedule_id\";
            
                                    }
                                    </script>";
                                }
                        }
    
        
 }
?>
