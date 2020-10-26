
<?php
$start_timestamp = microtime(true);
error_reporting(E_ALL & ~E_NOTICE);
include("ims_process_ses_track.php");
$time_diff=(int)date("YmdH")-$log_time;
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];

if($log_time==0 or $time_diff>1)
{
		$myFile = "ims_process_ses_track.php";
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData = "<?php $"."log_time=".(int)date("YmdH")."; ?>";
		fwrite($fh, $stringData);
		fclose($fh);
		?>

		<?php $process_the_auto_process=1; //1-Yes ; 0-No; ?>
		<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
		<script language="javascript" type="text/javascript" src="check.js"></script>
		<link rel="stylesheet" href="../styles/ddcolortabs.css" type="text/css" media="all" />

		<script type="text/javascript" language="javascript">
			window.onload = function () {
				noBack();
			}
			window.history.forward();
			function noBack() {
				window.history.forward();
			}
		</script>
		<script language="JavaScript">
			var version = navigator.appVersion;
			function showKeyCode(e) {
				var keycode = (window.event) ? event.keyCode : e.keyCode;

				if ((version.indexOf('MSIE') != -1)) {
					if (keycode == 116) {
						event.keyCode = 0;
						event.returnValue = false;
						return false;
					}
				}
				else {
					if (keycode == 116) {
						return false;
					}
				}
			}

		</script>
			
		</head>
		<body onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">

		<?php 
		$include_path=getenv('config_job_path');
		include($include_path.'\sfcs_app\common\config\config_jobs.php');
		include($include_path.'\sfcs_app\common\config\functions_v2.php');
		// var_dump($shifts_array);
			$plantcode=$_SESSION['plantCode'];
			$teams=$shifts_array;
			$team_array=implode(",",$shifts_array);
			$team = "'".str_replace(",","','",$team_array)."'"; 

		?>
		<?php
		//New Version 1.0 to Eliminate Duplicates
		if($process_the_auto_process==1)
		{
			echo "START:".date("H:i:s");
			echo "<br>";	
			//SPEED PROCESS - START
			$date=date("Y-m-d");
			// $date="2018-09-17";
			$work_hrs=0;
			$sql_hr="select start_time,end_time from $pms.pro_atten_hours where plant_code='$plant_code' and date='$date' and shift in ($team)";
			// echo $sql_hr."<br>";
			$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if(mysqli_num_rows($sql_result_hr) >0)
			{
				while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
				{ 
					$time1 = strtotime($sql_row_hr['start_time']);
					$time2 = strtotime($sql_row_hr['end_time']);
					$difference = round(abs($time2 - $time1) / 3600,2);
					$work_hrs=$work_hrs+$difference;
				}
				$break_time=sizeof($teams)*0.5;
				$work_hours=$work_hrs-$break_time;
			}else{
					if(sizeof($teams) > 1) 
					{ 
						$work_hours=15; 
					} 
					else 
					{ 
						$work_hours=7.5; 
					} 
			}
			
			// echo $work_hours."<br>";
			$current_hr=date('H');
			// echo $current_hr."<br>";

			// $current_date="2018-09-17";
			$current_date=date('Y-m-d');
			$work_hrs_plan=array();
			if($current_date==$date)
			{
				$hour_dur=0;
				for($i=0;$i<sizeof($teams);$i++)
				{
					$sql_hr="select * from $pms.pro_atten_hours where plant_code='$plant_code' and date='$date' and shift='".$teams[$i]."' and  $current_hr between start_time and end_time";
					// echo $sql_hr."<br>";
					$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
					if(mysqli_num_rows($sql_result_hr) >0)
					{
						while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
						{ 
							$time1 = strtotime($start_time);
							$time2 = strtotime($end_time);
							$difference = round(abs($time2 - $time1) / 3600,2);
							$hour_dur=$hour_dur+$difference;
							$work_hrs_plan[$teams[$i]]=$difference;
						}
					}else{
						$hour_dur=$hour_dur+0;
					}
					
				}
			
				if($hour_dur >3){
					$hour_dur=$hour_dur-0.5;
				}
				$hoursa_shift=$hour_dur;
			}
			else
			{
				$hoursa_shift=$work_hours;
			}
			// echo $hoursa_shift."<br>";
			
			//GRAND EFF UPDATE - START
			$edate=$date;
			$sdate=$date;
			
			$departments=getSectionByDeptTypeSewing($plantCode);
     	 	foreach($departments as $department)    //section Loop -start
			{
				$sectionId=$department['sectionId'];
				$sectionCode=$department['sectionCode'];
				$workstationsArray=getWorkstationsForSectionId($plantCode, $sectionId);
				foreach($workstationsArray as $workstations)
				{
					$module=$workstations['workstationId'];	
					$moduleCode=$workstations['workstationCode'];
					for($i=0;$i<sizeof($teams);$i++)
					{
						// Getting Plan Information
						$sql_month_plan="select sum(planned_qty) as qty,sum(planned_sah) as sah,planned_eff,capacity_factor from $pps.monthly_production_plan where plant_code='$plantcode' and row_name='".$moduleCode."'";
						$sql_month_plan_res=mysqli_query($link, $sql_month_plan) or exit("Fetching Monthly Plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_month_plan_res)==0)
						{
							$plan_sah=0;
							$plan_out=0;
							$plan_clh=0;
							$plan_eff=0;
							$plan_smo=0;
						}
						else
						{
							while($monthlyRow=mysqli_fetch_array($sql_month_plan_res))
							{
								$plan_sah=$monthlyRow['sah']/sizeof($teams);
								$plan_out=$monthlyRow['qty']/sizeof($teams);
								$plan_smo=$monthlyRow['capacity_factor'];
								$plan_clh=$monthlyRow['capacity_factor']*$work_hrs_plan[$teams[$i]];
								$plan_eff=$monthlyRow['planned_eff'];	
							}	
							
						}
						
						$sql_trans="SELECT operation_code,style,color,SUM(good_quantity) AS qty FROM $pts.transaction_log WHERE created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' AND parent_barcode_type='PPLB' and reasuorce_id='".$module."' and shift='".$teams[$i]."' and plant_code='".$plantcode."' group by style,color,operation_code"
						$trans_result=mysqli_query($link, $sql_trans) or exit("Error while getting transactional Data".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($trans_result)>0)
						{
							while($trans_row=mysqli_fetch_array($trans_row))
							{	
								$style=$trans_row['style'];
								$color=$trans_row['color'];
								$operaiton_code=$trans_row['operation_code'];
								//Fetching SMV
								$sql_to_fet_smv="SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number WHERE opi.style='".$style."' AND opi.color_desc='".$color."' AND omo.operation_code=".$operaiton_code." and plant_code='".$plantcode."' LIMIT 1"
								$sql_to_fet_smv_res=mysqli_query($link, $sql_to_fet_smv) or exit("Error while getting SMV Information".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($smv_res=mysqli_fetch_array($sql_to_fet_smv_res))
								{
									$smv=$smv_res['smv'];
								}
								if($smv>0)
								{
									$act_qty=$act_qty+$trans_row['qty'];
									$act_sah=$act_sah+$trans_row['qty']*$smv/60;
								}								
							}
							//Fetching Actual NOP
							$sql_to_fet_smo="SELECT sum(present_jumper) as smo FROM $pms.pro_attendance where plant_code='".$plantcode."' and module='".$module."' and shift='".$teams[$i]."'"	
							$sql_to_fet_smo_res=mysqli_query($link, $sql_to_fet_smo) or exit("Error while getting Machine Operaitors information".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($smo_res=mysqli_fetch_array($sql_to_fet_smo_res))
							{
								$smo=$smo_res['smo'];
							}
							$act_clh=$smo*$work_hrs_plan[$teams[$i]];
													
							$code=$date."-".$moduleCode."-".$teams[$i];
							$sql_grand_rep="select tid from $pts.grand_rep where plant_code='$plantcode' and tid='".$code."'";
							$sql_grand_rep_res=mysqli_query($link, $sql_grand_rep) or exit("Checking Grand rep information".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_check_res)==0)
							{
								$sql2="insert into $pts.grand_rep(tid,plant_code,created_user,created_at) values ('".$code."','$plantcode','$username','".date('Y-m-d')."')";
								mysqli_query($link, $sql2) or exit("Inserting into Grand cumulative data".mysqli_error($GLOBALS["___mysqli_ston"]));
							}  
							$sql2="update $pts.grand_rep set date='".$date."', module=$moduleCode, shift='".$teams[$i]."', section='".$sectionCode."', plan_out=$plan_out, act_out=$act_qty, plan_clh=$plan_clh, act_clh=$act_clh, plan_sth=$plan_sah, act_sth=$act_sah, smv=$smv, nop=$plan_smo,updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and tid='".$code."'";
						}
						else
						{							
							$code=$date."-".$moduleCode."-".$teams[$i];
							$sql_grand_rep="select tid from $pts.grand_rep where plant_code='$plantcode' and tid='".$code."'";
							$sql_grand_rep_res=mysqli_query($link, $sql_grand_rep) or exit("Checking Grand rep information".mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($sql_check_res)==0)
							{
								$sql2="insert into $pts.grand_rep(tid,plant_code,created_user,created_at) values ('".$code."','$plantcode','$username','".date('Y-m-d')."')";
								mysqli_query($link, $sql2) or exit("Inserting into Grand cumulative data".mysqli_error($GLOBALS["___mysqli_ston"]));
							}  
							$sql2="update $pts.grand_rep set date='".$date."', module=$moduleCode, shift='".$teams[$i]."', section='".$sectionCode."', plan_out=$plan_out, act_out=0, plan_clh=$plan_clh, act_clh=0, plan_sth=$plan_sah, act_sth=0, smv=$smv, nop=$plan_smo,updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and tid='".$code."'";
						}
					}

				}
			}
			//echo $note;
			//E:To avoid Duplicate Entry - 20150511 Kirang
			echo "END:".date("H:i:s");
			$myFile = "ims_process_ses_track.php";
			$fh = fopen($myFile, 'w') or die("can't open file");
			$stringData = "<?php $"."log_time=0; ?>";
			fwrite($fh, $stringData);
			fclose($fh);


		} 

	//Auto Close
}

?>



<?php
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
?>
