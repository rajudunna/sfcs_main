<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
//include($include_path.'\sfcs_app\common\config\config_jobs.php');

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

$sql="SELECT team,module, SUM(IF(attn_status='A',1,0)) AS absent, SUM(IF(attn_status='P',1,0)) AS present FROM $database1.$month WHERE emp_id IN ($emp_lists) AND DATE=\"".$date."\" AND $database1.$month.emp_w_status in (".$Status.") AND module>0 GROUP BY module,team ORDER BY module+0" ;
//echo $sql;

 
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


    $sqla="select * from $bai_pro.pro_attendance where date=\"$date\" and module=\"$module\" and shift='".$team."'";
	// echo $sqla."</br>";
	$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sqlresa)==0)
	{
		$sql1="insert into $bai_pro.pro_attendance (date,module,shift) VALUES ('".$date."','$module','".$team."')";
		// echo $sql1."</br>";
		mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql23="update $bai_pro.pro_attendance set present='".$active."',absent='".$absent."' where date='".$date."' and module='$module' and shift='".$team."'";
		// echo $sql23."</br>";
		mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}else{
		$sql22="update $bai_pro.pro_attendance set present='".$active."',absent='".$absent."' where date='".$date."' and module='$module' and shift='".$team."'";
		// echo $sql22."</br>";
		mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
} 

//yesterday 
$date=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"))); 
$database1="bai_hr_tna_em_".date("y",strtotime($date)).date("y",strtotime($date)); 
$month=date("M",strtotime($date)); 
$sqly="select team,module, SUM(IF(attn_status='A',1,0)) as absent, SUM(IF(attn_status='P',1,0)) as present FROM $database1.$month WHERE emp_id IN ($emp_lists) AND DATE=\"".$date."\" AND $database1.$month.emp_w_status in (".$Status.") AND module>0 GROUP BY module,team ORDER BY module+0" ;
// echo $sql."<br>"; 
$sql_resulty=mysqli_query($link_hrms, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

$sql11="update $bai_pro.pro_attendance set present='',absent='' where date=\"$date\"";
	echo $sql11."<br/>";
	mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	
while($sql_row1=mysqli_fetch_array($sql_resulty)) 
{ 
    $module=$sql_row1['module']; 
    $team=$sql_row1['team']; 
    $active=($sql_row1['present']+$sql_row1['absent']); 
    $present=$sql_row1['present']; 
    $absent=$sql_row1['absent']; 

    $sqla="select * from $bai_pro.pro_attendance where date=\"$date\" and module=\"$module\" and shift='".$team."'";
	// echo $sqla."</br>";
	$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sqlresa)==0)
	{
		$sql1="insert into $bai_pro.pro_attendance (date,module,shift) VALUES ('".$date."','$module','".$team."')";
		// echo $sql1."</br>";
		mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql23="update $bai_pro.pro_attendance set present='".$active."',absent='".$absent."' where date='".$date."' and module='$module' and shift='".$team."'";
		// echo $sql23."</br>";
		mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else{
		$sql22="update $bai_pro.pro_attendance set present='".$active."',absent='".$absent."' where date='".$date."' and module='$module' and shift='".$team."'";
		// echo $sql22."</br>";
		mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
} 


$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.")."\n";

?>

