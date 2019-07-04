<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$sql2="Alter table `bai_pro3`.`ims_log`   
  change `input_job_no_ref` `input_job_no_ref` varchar(20) NOT NULL  COMMENT 'reference of input job number'";
$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2--".mysqli_error($GLOBALS["___mysqli_ston"]));
  
$sql3="Alter table `bai_pro3`.`ims_log_backup`   
  change `input_job_no_ref` `input_job_no_ref` varchar(11) NOT NULL";
$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error3--".mysqli_error($GLOBALS["___mysqli_ston"]));
  
$sql4="Alter table `bai_pro`.`bai_log`   
  change `jobno` `jobno` varchar(4) NOT NULL";
$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4--".mysqli_error($GLOBALS["___mysqli_ston"]));
  
  
$sql5="Alter table `brandix_bts`.`bundle_creation_data`   
  change `input_job_no` `input_job_no` varchar(11) NULL";
$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error5--".mysqli_error($GLOBALS["___mysqli_ston"]));
  
  
$sql6="Alter table `brandix_bts`.`bundle_creation_data_temp`   
  change `input_job_no` `input_job_no` varchar(11) NULL";
$sql_result6=mysqli_query($link, $sql6) or exit("Sql Error6--".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="SELECT group_concat(operation_code) as op_code FROM brandix_bts.tbl_orders_ops_ref where category='sewing' ";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1--".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$op_code=$sql_row1['op_code'];
}

$sql11="SELECT tid,input_job_no_random,input_job_no FROM bai_pro3.pac_stat_log_input_job WHERE input_job_no LIKE '%.%' ";
$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error11--".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row11=mysqli_fetch_array($sql_result11))
{
	$pac_tid=$sql_row11['tid'];
	$ijno_ref=$sql_row11['input_job_no_random'];
	$ijno=$sql_row11['input_job_no'];
	
	$sql12="update bai_pro3.ims_log set `input_job_no_ref` = '$ijno' where  pac_tid=$pac_tid ";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error12--".mysqli_error($GLOBALS["___mysqli_ston"]));
	
    $sql13="update bai_pro3.ims_log_backup set `input_job_no_ref` = '$ijno' where pac_tid=$pac_tid ";
	$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error13--".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	$sql14="update brandix_bts.bundle_creation_data set input_job_no='$ijno' where bundle_number=$pac_tid and operation_id in($op_code) ";
	$sql_result14=mysqli_query($link, $sql14) or exit("Sql Error14--".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql15="update brandix_bts.bundle_creation_data_temp set input_job_no='$ijno' where bundle_number=$pac_tid and operation_id in($op_code) ";
	$sql_result15=mysqli_query($link, $sql15) or exit("Sql Error15--".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql16="update bai_pro.bai_log set jobno='$ijno' where SUBSTRING_INDEX(ims_pro_ref, '-', 1)=$pac_tid and operation_id in($op_code) ";
	$sql_result16=mysqli_query($link, $sql15) or exit("Sql Error16--".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql17="update bai_pro.bai_log_buf set jobno='$ijno' where SUBSTRING_INDEX(ims_pro_ref, '-', 1)=$pac_tid and operation_id in($op_code) ";
	$sql_result15=mysqli_query($link, $sql17) or exit("Sql Error17--".mysqli_error($GLOBALS["___mysqli_ston"]));

}



?>