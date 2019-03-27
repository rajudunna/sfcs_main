<?php
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$connect = odbc_connect("$driver_name;Server=$serverName;Database=$m3_databasename;", $uid,$pwd);
error_reporting(1);

$get_details="select * from $bai_pro3.job_transfer_details where status='P'";
echo $get_details."<br>";
$result=mysqli_query($link, $get_details) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo mysqli_num_rows($result);
while($row = mysqli_fetch_array($result))
{
	   $sewing_job_number =$row['sewing_job_number'];

	   $transfered_module = $row['transfered_module'];


       $sql55="SELECT order_style_no,order_del_no,order_col_des,input_job_no,mrn_status FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$sewing_job_number' and mrn_status='1' group by input_job_no_random";
       $sql_result01=mysqli_query($link, $sql55) or exit("Sql Error01".mysqli_error($GLOBALS["___mysqli_ston"]));
       $sql_num_check1=mysqli_num_rows($sql_result01);
      if($sql_num_check1>0){
           while($sql_row01=mysqli_fetch_array($sql_result01))
           {
               $order_style_no=$sql_row01["order_style_no"];
               $order_del_no=$sql_row01["order_del_no"];
               $order_col_des=$sql_row01["order_col_des"];
               $input_job_no=$sql_row01["input_job_no"];
               $mrn_status=$sql_row01["mrn_status"];

               $employee_no=$order_del_no."-".$input_job_no;
               $date=date('Ymd');
               $line="CW"."-"."Team"."-".$transfered_module;
           }
           $sql14="SELECT co_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$order_del_no' and order_style_no='$order_style_no' and order_col_des='$order_col_des'";					
					$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error71".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row14=mysqli_fetch_array($sql_result14))
					{
						$co_no=$sql_row14['co_no'];
                    }
                    

            $sql2="insert into [$mssql_db].[dbo].[tbl_Update_M3_MRN_Link](CONO,Color,EmployeeNo,Inputdate,Line,Status) values('".$cono."','".$order_col_des."','".$employee_no."','".$date."','".$line."',NULL)";
                    echo $sql2."<br>";
            $result7=odbc_exec($connect, $sql2) or exit("Error2=".odbc_errormsg($connect));
            $sql_num_check5=odbc_num_rows($result7);
            if($sql_num_check5>0){

             $sql_query="update $bai_pro3.job_transfer_details set status='S' where sewing_job_number='$sewing_job_number' ";
             $sql_query_result=mysqli_query($link, $sql_query) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));

            }


        }
	  

      
}  

?>