
<?php
error_reporting(E_ALL & ~E_NOTICE);
//$include_path=getenv('config_job_path');
$include_path='C:\xampp\htdocs\sfcs_main';
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\functions_v2.php');
include($include_path.'\sfcs_app\common\config\enums.php');
// var_dump($shifts_array);
if(isset($_GET['plant_code']))
{
	$plant_Code= $_GET['plant_code']; 
	$username= $_GET['username']; 
}
else
{
	$plant_Code = $_SESSION['plantCode'];
	$username = $_SESSION['userName'];
}
$teams=$shifts_array;
$team_array=implode(",",$shifts_array);
$team = "'".str_replace(",","','",$team_array)."'"; 
$date=date('Y-m-d');
$current_date=date('Y-m-d');
$work_hrs=0;
$current_hr=date('H');
$sql_hr="select * from $pms.pro_atten_hours where plant_code='$plant_Code' and date='$date' and shift in ($team)";
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

$work_hrs_plan=array();
if($current_date==$date)
{
	$hour_dur=0;
	for($i=0;$i<sizeof($teams);$i++)
	{
		$sql_hr="select * from $pms.pro_atten_hours where plant_code='$plant_Code' and date='$date' and shift='".$teams[$i]."' and  $current_hr between start_time and end_time";
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
			$work_hrs_plan[$teams[$i]]=8;
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

//GRAND EFF UPDATE - START
$edate=$date;
$sdate=$date;

$departments=getSectionByDeptTypeSewing($plant_Code);
foreach($departments as $department)    //section Loop -start
{
	$sectionId=$department['sectionId'];
	$sectionCode=$department['sectionCode'];
	$workstationsArray=getWorkstationsForSectionId($plant_Code, $sectionId);
	foreach($workstationsArray as $workstations)
	{
		$module=$workstations['workstationId'];	
		$moduleCode=$workstations['workstationCode'];
		for($i=0;$i<sizeof($teams);$i++)
		{
			// Getting Plan Information
			$sql_month_plan="select sum(planned_qty) as qty,sum(planned_sah) as sah,planned_eff,capacity_factor from $pps.monthly_production_plan where plant_code='$plant_Code' and row_name='".$moduleCode."'";
			// echo $sql_month_plan."<br>";
			$sql_month_plan_res=mysqli_query($link, $sql_month_plan) or exit("Fetching Monthly Plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($monthlyRow=mysqli_fetch_array($sql_month_plan_res))
			{
				// echo $monthlyRow['sah']."-Plan--".$monthlyRow['qty']."<br>";
				//Plan SAH
				if($monthlyRow['sah']>0)
				{
					$plan_sah=$monthlyRow['sah']/sizeof($teams);
				}
				else
				{
					$plan_sah=0;
				}
				//Plan Out
				if($monthlyRow['qty']>0)
				{
					$plan_out=$monthlyRow['qty']/sizeof($teams);
				}
				else
				{
					$plan_out=0;
				}
				//Plan SMO
				if($monthlyRow['capacity_factor']>0)
				{
					$plan_smo=$monthlyRow['capacity_factor']/sizeof($teams);
					$plan_clh=$monthlyRow['capacity_factor']*$work_hrs_plan[$teams[$i]];
				}
				else
				{
					$plan_smo=0;
					$plan_clh=0;
				}
				//Plan Eff
				if($monthlyRow['planned_eff']>0)
				{
					$plan_eff=$monthlyRow['planned_eff'];
				}
				else
				{
					$plan_sah=0;
				}
			}				
			
			$act_qty=0;
			$act_sah=0;
			$sql_trans="SELECT operation,style,color,SUM(good_quantity) AS qty FROM $pts.transaction_log WHERE created_at BETWEEN '".$sdate." 00:00:00' AND '".$edate." 23:59:59' AND parent_barcode_type='PPLB' and resource_id='".$module."' and shift='".$teams[$i]."' and plant_code='".$plant_Code."' group by style,color,operation";
			// echo $sql_trans."<br>";
			$trans_result=mysqli_query($link, $sql_trans) or exit("Error while getting transactional Data".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($trans_result)>0)
			{
				while($trans_row=mysqli_fetch_array($trans_result))
				{	
					$style=$trans_row['style'];
					$color=$trans_row['color'];
					$operaiton_code=$trans_row['operation'];
					//echo $style."--".$color."--".$operaiton_code."<br>";
					//Fetching SMV
					$sql_to_fet_smv="SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number LEFT JOIN $oms.oms_mo_details AS omd ON omd.mo_number=omo.mo_number WHERE opi.style='".$style."' AND opi.color_desc='".$color."' AND omo.operation_code=".$operaiton_code." and omd.plant_code='".$plant_Code."' LIMIT 1";
					// echo $sql_to_fet_smv."<br>";
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
				$sql_to_fet_smo="SELECT sum(present+jumper) as smo FROM $pms.pro_attendance where plant_code='".$plant_Code."' and module='".$module."' and shift='".$teams[$i]."'";
				// echo $sql_to_fet_smo."<br>";
				$sql_to_fet_smo_res=mysqli_query($link, $sql_to_fet_smo) or exit("Error while getting Machine Operaitors information".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($smo_res=mysqli_fetch_array($sql_to_fet_smo_res))
				{
					$smo=$smo_res['smo'];
					if($smo==0)
					{
						$smo=0;	
					}
				}
				$act_clh=$smo*$work_hrs_plan[$teams[$i]];
										
				$code=$date."-".$moduleCode."-".$teams[$i];
				$sql_grand_rep="select tid from $pts.grand_rep where plant_code='$plant_Code' and tid='".$code."'";
				$sql_grand_rep_res=mysqli_query($link, $sql_grand_rep) or exit("Checking Grand rep information".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_grand_rep_res)==0)
				{
					$sql_insert="insert into $pts.grand_rep(tid,plant_code,created_user,created_at) values ('".$code."','$plant_Code','$username','".date('Y-m-d')."')";
					// echo $sql2."<br>";
					mysqli_query($link, $sql_insert) or exit("Inserting into Grand cumulative data".mysqli_error($GLOBALS["___mysqli_ston"]));
				}  
				$sql_update="update $pts.grand_rep set date='".$date."', module='$moduleCode', shift='".$teams[$i]."', section='".$sectionCode."', plan_out='$plan_out', act_out='$act_qty', plan_clh='$plan_clh', act_clh='$act_clh', plan_sth='$plan_sah', act_sth='$act_sah', smv='$smv', nop='$plan_smo',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plant_Code' and tid='".$code."'";
				// echo $sql_update."---1<br>";
				mysqli_query($link, $sql_update) or exit("Updating Grand cumulative data".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{							
				$code=$date."-".$moduleCode."-".$teams[$i];
				$sql_grand_rep="select tid from $pts.grand_rep where plant_code='$plant_Code' and tid='".$code."'";
				$sql_grand_rep_res=mysqli_query($link, $sql_grand_rep) or exit("Checking Grand rep information".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_grand_rep_res)==0)
				{
					$sql_insert="insert into $pts.grand_rep(tid,plant_code,created_user,created_at) values ('".$code."','$plant_Code','$username','".date('Y-m-d')."')";
					// echo $sql2."<br>";
					mysqli_query($link, $sql_insert) or exit("Inserting into Grand cumulative data".mysqli_error($GLOBALS["___mysqli_ston"]));
				}  
				$sql_update="update $pts.grand_rep set date='".$date."', module='$moduleCode', shift='".$teams[$i]."', section='".$sectionCode."', plan_out='$plan_out', act_out='0', plan_clh='$plan_clh', act_clh='0', plan_sth='$plan_sah', act_sth='0', smv='0.00', nop='$plan_smo',updated_user='$username',updated_at='".date('Y-m-d H:i:s')."' where plant_code='$plant_Code' and tid='".$code."'";
				// echo $sql_update."---2<br>";
				mysqli_query($link, $sql_update) or exit("Updating Grand cumulative data".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}

	}
}
