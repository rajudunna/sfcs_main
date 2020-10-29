<?php 
	if($_GET['plantCode']){
		$plant_code = $_GET['plantCode'];
	}else{
		$plant_code = $argv[1];
	}
$username=$_SESSION['userName'];
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');


if($attendance_integration=='HRMS')
{
	$link_hrms= ($GLOBALS["___mysqli_ston"] = mysqli_connect($hrms_host, $hrms_user, $hrms_pass)) or die("Could not connect21: ".mysqli_error($GLOBALS["___mysqli_ston"]));
	//today
	$date=date("Y-m-d"); 
	$database="bai_hr_database"; 
	$database1="bai_hr_tna_em_".date("y",strtotime($date)).date("y",strtotime($date)); 
	$month=date("M",strtotime($date)); 

	$sql1="select id_map_ref FROM $database.emp_join_track WHERE emp_join_type=2 and emp_cat4=1"; 
	// echo $sql1."<br>"; 
	$result=mysqli_query($link_hrms, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	$emp_list=array(); 
	while($row=mysqli_fetch_array($result)) 
	{ 
		$emp_list[]=$row['id_map_ref']; 
	} 

	$emp_lists=implode(",",$emp_list); 

	$sql="SELECT team,module, SUM(IF(attn_status='A',1,0)) AS absent, SUM(IF(attn_status='P',1,0)) AS present FROM $database1.$month WHERE emp_id IN ($emp_lists) AND DATE=\"".$date."\" AND $database1.$month.emp_w_status in (".$emp_active_status.") AND module>0 GROUP BY module,team ORDER BY module+0" ;
	//echo $sql;

	$sql11="update $pts.pro_attendance set present='',absent='',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date=\"$date\"";
	mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
	$sql_result=mysqli_query($link_hrms, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row1=mysqli_fetch_array($sql_result)) 
	{ 
		$module=$sql_row1['module']; 
		// echo $module."<br>";
		$team=$sql_row1['team']; 
		$active=($sql_row1['present']+$sql_row1['absent']); 
		// echo  "Active".$active."<br>";
		$present=$sql_row1['present']; 
		// echo "Present".$present."<br>";

		$absent=$sql_row1['absent']; 
		// echo "Absent".$absent."<br>";


		$sqla="select * from $pts.pro_attendance where plant_code='$plantcode' and date=\"$date\" and module=\"$module\" and shift='".$team."'";
		// echo $sqla."</br>";
		$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sqlresa)==0)
		{
			$sql1="insert into $pts.pro_attendance (date,module,shift,plant_code,created_user,created_at) VALUES ('".$date."','$module','".$team."','$plantcode','$username','".date('Y-m-d')."')";
			// echo $sql1."</br>";
			mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql23="update $pts.pro_attendance set present='".$active."',absent='".$absent."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='".$team."'";
			// echo $sql23."</br>";
			mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
		}else{
			$sql22="update $pts.pro_attendance set present='".$active."',absent='".$absent."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='".$team."'";
			// echo $sql22."</br>";
			mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	} 

	//yesterday 
	$date=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"))); 
	$database1="bai_hr_tna_em_".date("y",strtotime($date)).date("y",strtotime($date)); 
	$month=date("M",strtotime($date)); 
	$sqly="select team,module, SUM(IF(attn_status='A',1,0)) as absent, SUM(IF(attn_status='P',1,0)) as present FROM $database1.$month WHERE emp_id IN ($emp_lists) AND DATE=\"".$date."\" AND $database1.$month.emp_w_status in (".$emp_active_status.") AND module>0 GROUP BY module,team ORDER BY module+0" ;
	// echo $sql."<br>"; 
	$sql_resulty=mysqli_query($link_hrms, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

	$sql11="update $pts.pro_attendance set present='',absent='',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date=\"$date\"";
		//echo $sql11."<br/>";
	mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		
	while($sql_row1=mysqli_fetch_array($sql_resulty)) 
	{ 
		$module=$sql_row1['module']; 
		$team=$sql_row1['team']; 
		$active=($sql_row1['present']+$sql_row1['absent']); 
		$present=$sql_row1['present']; 
		$absent=$sql_row1['absent']; 

		$sqla="select * from $pts.pro_attendance where plant_code='$plantcode' and date=\"$date\" and module=\"$module\" and shift='".$team."'";
		// echo $sqla."</br>";
		$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sqlresa)==0)
		{
			$sql1="insert into $pts.pro_attendance (date,module,shift,plant_code,created_user,created_at) VALUES ('".$date."','$module','".$team."','$plantcode','$username','".date('Y-m-d')."')";
			// echo $sql1."</br>";
			mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql23="update $pts.pro_attendance set present='".$active."',absent='".$absent."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='".$team."'";
			// echo $sql23."</br>";
			mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else{
			$sql22="update $pts.pro_attendance set present='".$active."',absent='".$absent."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='".$team."'";
			// echo $sql22."</br>";
			mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	} 
}
else
{
	//today
	if($_GET['date'])
	{
		$date=$_GET['date'];
	}
	else
	{
		$date=date("Y-m-d");
	} 
	$conn = odbc_connect("$hcm_sql_driver_name;Server=$hcm_sql_server;Database=$hcm_db;",$hcm_sql_user,$hcm_sql_pass);
	
	$hcm_module=array();
	$hcm_modules=array();
	$hcm_shift=array();
	$hcm_shifts=array();
	$teams=array();
	//HCM Module Mapping
	for($k=0; $k < sizeof($shifts_array); $k++)
	{
		$sql_shift="select sum(present) as nop from $bai_pro.pro_attendance where plant_code='$plantcode' and date='".$date."' and shift='".$shifts_array[$k]."'";
		$result_shift=mysqli_query($link, $sql_shift) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_shift_rows=mysqli_fetch_array($result_shift))
		{			
			if($sql_shift_rows['nop']>0)
			{
				$teams[]=$shifts_array[$k];	
			}	
		}		
	}
	
	//HCM Module Mapping
	$hcm_query_module = "select * from $bai_pro.hcm_module_mapping where plant_code='$plantcode'";
	$hcm_result=mysqli_query($link, $hcm_query_module) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($hcm_row=mysqli_fetch_array($hcm_result))
	{
		$hcm_modules[]=$hcm_row['hcm_code'];
		$hcm_module[$hcm_row['hcm_code']]=$hcm_row['sfcs_module'];	
	}
	//HCM Shift Mapping
	$hcm_query_shift = "select * from $bai_pro.hcm_shift_mapping where plant_code='$plantcode'";
	$hcm_shift_result=mysqli_query($link, $hcm_query_shift) or die ("Error1.1=".$get_details.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($hcm_shift_row=mysqli_fetch_array($hcm_shift_result))
	{
		$hcm_shifts[]=$hcm_shift_row['hcm_code'];	
		$hcm_shift[$hcm_shift_row['hcm_code']]=$hcm_shift_row['sfcs_shift'];	
	}
	$locations=explode(",",$hcm_location_id);
	
	if(sizeof($hcm_modules)>0 && sizeof($hcm_shifts) && sizeof($locations)>0)
	{
		for($i=0;$i<sizeof($locations);$i++)
		{
			for($ii=0;$ii<sizeof($hcm_shifts);$ii++)
			{
				for($iii=0;$iii<sizeof($hcm_modules);$iii++)
				{
					$get_details = "SELECT COUNT(CASE WHEN In_time = '-1.00' THEN 1 END) AS absence
					,COUNT(CASE WHEN In_time != '-1.00' THEN 1 END) AS present
					FROM [$hcm_db].[sfcs].[VW_Attendance_Info] where date='".$date."' and Location_ID='".$locations[$i]."' and Sft_code='".$hcm_shifts[$ii]."' and Ros_code='".$hcm_modules[$iii]."' and Emp_Category='000001'";
					//echo $get_details."<br>";
					$sql_result = odbc_exec($conn, $get_details);
					if(odbc_num_rows($sql_result) == 0)
					{
						//echo "No result<br>";
						$module=$hcm_module[$hcm_modules[$iii]];
						$team=$hcm_shift[$hcm_shifts[$ii]];
						$sqla1="select * from $bai_pro.pro_attendance where plant_code='$plantcode' and date='".$date."' and module='".$module."' and shift='".$team."'";
						$sqlresa1=mysqli_query($link, $sqla1) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sqlresa1)==0)
						{
							$sql1="insert into $bai_pro.pro_attendance (date,module,shift,present,absent,plant_code,created_user,created_at) VALUES ('".$date."','$module','".$team."',0,0,'$plantcode','$username','".date('Y-m-d')."')";						
							mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					else
					{
						while(odbc_fetch_row($sql_result))
						{
							$active=odbc_result($sql_result,'present'); 
							$absent=odbc_result($sql_result,'absence');												
							$module=$hcm_module[$hcm_modules[$iii]];
							$team=$hcm_shift[$hcm_shifts[$ii]];	
							if(!in_array($team,$teams))
							{							
								$sqla="select * from $bai_pro.pro_attendance where plant_code='$plantcode' and date='".$date."' and module='".$module."' and shift='".$team."'";
								$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
								if(mysqli_num_rows($sqlresa)==0)
								{
									$sql1="insert into $bai_pro.pro_attendance (date,module,shift,plant_code,created_user,created_at) VALUES ('".$date."','$module','".$team."','$plantcode','$username','".date('Y-m-d')."')";							
									mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									$sql23="update $bai_pro.pro_attendance set present=".$active.",updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='".$team."'";
									//echo $sql23."<br>";
									mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
								}
								else{
									$sql22="update $bai_pro.pro_attendance set present=present+".$active.",updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='".$team."'";
									//echo $sql23."<br>";
									mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
								}									
							}
						}
					}
				}
			}
		}	
	}
}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";

?>

