<?php
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
// if(isset($_GET['sec_x']))
// {
// 	$sections_db=array($_GET['sec_x']);
// }

for($i=0;$i<sizeof($sections_db);$i++)
{
	$section_id=$sections_db[$i];
	$sec=$section_id;
	
	$id_new="green";
	
	$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM bai_pro3.`module_master` LEFT JOIN bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$section_id GROUP BY section ORDER BY section + 0";
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$section=$sql_rowx['sec_id'];
		$section_head=$sql_rowx['sec_head'];
		$section_mods=$sql_rowx['sec_mods'];
		
		$mods=array();
		$mods=explode(",",$section_mods);
			
		$teams=array();
		$sql2="SELECT  DISTINCT bac_shift FROM $bai_pro.bai_log_buf WHERE bac_date=\"".date("Y-m-d")."\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error145".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$teams[]=$sql_row2['bac_shift'];
		}
		
		// $avail_criteria='sum(avail_'.implode('+avail_',$teams).')';
		// $absen_criteria='sum(absent_'.implode('+absent_',$teams).')';
		$date=date("Y-m-d");
		if(sizeof($teams)>0) // ERROR CORRECTION
		{
			$sql2="select sum(present+jumper) as \"avail\", sum(absent) as \"absent\" from $bai_pro.pro_attendance where module in ($section_mods) and date='".$date."'";
			//secho $sql2;
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error4569".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$avail=$sql_row2['avail'];
				$absent=$sql_row2['absent'];		
			}
		}
	}
	
	if($avail>0) // ERROR CORRECTION
	{
		$percent=round(($absent/$avail)*100,0);
	}
	else // ERROR CORRECTION
	{
		$percent=10;
	}

	if($percent>8)
	{
		$id_new="red";
	}
	else
	{
		if($percent<=4)
		{
			$id_new="green";
		}
		else
		{
			$id_new="yellow";
		}
	}
	
	if($username=="kiran")
	{
		echo "<td><div id=\"$id_new\"><a href=\"#\"></a>$absent/$avail</div></td>";
	}
	else
	{
		echo "<td><div id=\"$id_new\"><a href=\"$dns_adr3/projects/Beta/Reports/Production_Live_Chart/Control_Room_Charts/Dash_Board_new.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";
	}
}
//projects/dashboards/production_kpi/Attendance_live_dashboard.php	
			

?>