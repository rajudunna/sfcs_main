<?php
//Ticket #724688  - KiranG 20140328
//Excempted sample inputs from KPI calculations

//Ticket #695167 - KiranG 20140514
//Excemption has been added in query for 'EXCESS','EMB'

?>


<?php

if(isset($_GET['sec_x']))
{
	$sections_db=array($_GET['sec_x']);
}

for($i=0;$i<sizeof($sections_db);$i++)
{
	$section_id=$sections_db[$i];
	
	$id_new="green";
	$count1=0;
	$count2=0;
	$count=0;
	
	$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$section_id GROUP BY section ORDER BY section + 0";
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$section=$sql_rowx['sec_id'];
		$section_head=$sql_rowx['sec_head'];
		$section_mods=$sql_rowx['sec_mods'];
		
		//$sql1="SELECT ims_mod_no, MAX(test) AS \"max_blocks\" FROM (SELECT ims_mod_no, COUNT(DISTINCT rand_track) AS \"test\" FROM ims_log WHERE ims_mod_no IN ($section_mods) GROUP BY ims_mod_no) AS t";
		$sql1="SELECT ims_mod_no, COUNT(DISTINCT rand_track) AS \"test\" FROM $bai_pro3.ims_log WHERE ims_status<>'DONE' and ims_mod_no IN ($section_mods) and ims_remarks not in ('SAMPLE','EXCESS','EMB') GROUP BY ims_mod_no";
		//echo $sql1;

		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$max_blocks=$sql_row1['test'];
			if($max_blocks>4)
			{
				$id_new="red";
				$count++;
			}
		}
		
		
	}
	
	//echo $count."<br/>";
	$echo_content="";
	if($count>3)
	{
		$id_new="red";
		//echo "<td><div id=\"$id_new\"><a href=\"#\"></a></div></td>";
	}
	else
	{
		if($count<=3 and $count>1)
		{
			$id_new="yellow";
			//echo "<td><div id=\"$id_new\"><a href=\"#\"></a></div></td>";
		}
		else
		{
			$id_new="green";
			//echo "<td><div id=\"$id_new\"><a href=\"#\"></a></div></td>";
		}
	}
	// $url_ims=getFullURLLevel($_GET['r'],'beta/cut_plan_new/ims/cpanel/cpanel_main_v2.php',2,'N');
	// echo "<td><div id=\"$id_new\"><a href=\"$url_ims&sec_x=$section_id&rand=".rand()."\"></a></div></td>";
	echo "<td><div id=\"$id_new\"><a href=\"http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/cpanel_main_live_dashboard.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";

}
			

?>