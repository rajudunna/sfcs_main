<?php
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
$sql="select * from bai_pro.pro_atten";
$sql_res=mysqli_query($link,$sql) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_res))
{
    $date=$sql_row['date'];
    $avail_A=$sql_row['avail_A'];
    $avail_B=$sql_row['avail_B'];
    $absent_A=$sql_row['absent_A'];
    $absent_B=$sql_row['absent_B'];
    $module=$sql_row['module'];
    
    $sqla="select * from $pts.pro_attendance where plant_code='$plantcode' and date=\"$date\" and module=\"$module\" and shift='A'";
	// echo $sqla."</br>";
	$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sqlresa)==0)
	{
		$sql1="insert into $pts.pro_attendance (date,module,shift,plant_code,created_user,created_at) VALUES ('".$date."','$module','A','$plantcode','$username','".date('Y-m-d')."')";
		// echo $sql1."</br>";
		mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql23="update $pts.pro_attendance set present='".$avail_A."',absent='".$absent_A."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='A'";
		// echo $sql23."</br>";
		mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
	}else{
		$sql22="update $pts.pro_attendance set present='".$avail_A."',absent='".$absent_A."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='A'";
		// echo $sql22."</br>";
		mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

    $sqla="select * from $pts.pro_attendance where plant_code='$plantcode' and date=\"$date\" and module=\"$module\" and shift='B'";
	// echo $sqla."</br>";
	$sqlresa=mysqli_query($link, $sqla) or exit("Sql Errord $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sqlresa)==0)
	{
		$sql1="insert into $pts.pro_attendance (date,module,shift,plant_code,created_user,created_at) VALUES ('".$date."','$module','B','$plantcode','$username','".date('Y-m-d')."')";
		// echo $sql1."</br>";
		mysqli_query($link, $sql1) or exit("Sql Errore".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql23="update $pts.pro_attendance set present='".$avail_B."',absent='".$absent_B."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='B'";
		// echo $sql23."</br>";
		mysqli_query($link, $sql23) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    else
    {
		$sql22="update $pts.pro_attendance set present='".$avail_B."',absent='".$absent_B."',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and date='".$date."' and module='$module' and shift='B'";
		// echo $sql22."</br>";
		mysqli_query($link, $sql22) or exit("Sql Errorf".mysqli_error($GLOBALS["___mysqli_ston"]));
    }

}
?>