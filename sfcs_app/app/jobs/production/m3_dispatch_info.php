
<?php 

//SFCS_PRO_SI_WED_OUTPUT_Details
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');
include("mail_config.php");
		

	$facility=$global_facility_code;


$sdate=date("Y-m-d",strtotime('-7 days'));
$edate=date("Y-m-d",strtotime('-1 days'));
$date = date("Y-m-d",strtotime('-1 days'));




$title_list = array
	(
	"date","style","schedule","color","m3_size","doc_no","qty","log_user","status","m3_mo_no","m3_op_code","job_no","mod_no","shift","m3_op_des"
	);

$file_name="SI_Output.csv";
$file = fopen($file_name,"w");

fputcsv($file,$title_list);
			
			$sqlx="SELECT sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,m3_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,sfcs_status,m3_mo_no,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des
FROM  $m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE (sfcs_date between '$sdate' and '$edate') and m3_op_code=130 AND sfcs_reason='' ORDER BY sfcs_date";
			$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowx=mysqli_fetch_array($sql_resultx))
			{
				
				{
					$values=array();
					$values[]=$sql_rowx['sfcs_date'];	
					$values[]=$sql_rowx['sfcs_style'];	
					$values[]=$sql_rowx['sfcs_schedule'];	
					$values[]=$sql_rowx['sfcs_color'];	
					$values[]=$sql_rowx['m3_size'];	
					$values[]=$sql_rowx['sfcs_doc_no'];	
					$values[]=$sql_rowx['sfcs_qty'];	
					$values[]=$sql_rowx['sfcs_log_user'];	
					$values[]=$sql_rowx['sfcs_status'];	
					$values[]=$sql_rowx['m3_mo_no'];	
					$values[]=$sql_rowx['m3_op_code'];	
					$values[]=$sql_rowx['sfcs_job_no'];	
					$values[]=$sql_rowx['sfcs_mod_no'];	
					$values[]=$sql_rowx['sfcs_shift'];	
					$values[]=$sql_rowx['m3_op_des'];

					
					fputcsv($file,$values);
									
					unset($values);
					
					
				}
			}
			fclose($file);	
		
			$to=$SFCS_PRO_SI_WED;

			email_attachment($to,'Please open the attachment for dispatch details of Brandix Essentials Limited - '.$facility.' Facility on '.$date.'.<br/><br/> Message Sent Via: '.$plant_name.'', $plant_name.'-'.$facility.' Dispatch Details ('.$date.') ',$header_from, $header_from, $file_name, $default_filetype='application/zip');
		
			unlink($file_name);
			
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
