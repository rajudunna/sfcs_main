<?php
//include("dbconf.php");
//TEMP Table
/*
$sql1="truncate bai_pro3.packing_dashboard_temp";
//echo $sql1;
mysql_query($sql1,$link) or exit("Sql Error".mysql_error());

//$packing_dashboard_temp="packing_dashboard_temp";

//$sql1="insert into $packing_dashboard_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from bai_pro3.packing_dashboard";
$sql1="insert into $packing_dashboard_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from packing_dashboard";
mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
*/
//TEMP Table
//sleep(2000);
//echo mysql_affected_rows($link)+1;
if(mysqli_affected_rows($link)>=0)
{
	$sqlx="SET GLOBAL log_bin_trust_function_creators = 1";
	mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	

if(isset($_GET['sec_x']))
{
	$sections_db=array($_GET['sec_x']);
}

for($i=0;$i<sizeof($sections_db);$i++)
{

	$packing_dashboard_temp="packing_dashboard_temp";	
	$section_id=$sections_db[$i];
	
	$id_new="green";
	
	$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$section_id GROUP BY section ORDER BY section + 0";
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$section=$sql_rowx['sec_id'];
		$section_head=$sql_rowx['sec_head'];
		$section_mods=$sql_rowx['sec_mods'];
		$count=0;
		//$sql1="SELECT ims_mod_no, MAX(test) AS \"max_blocks\" FROM (SELECT ims_mod_no, COUNT(DISTINCT doc_no_ref) AS \"test\" FROM $packing_dashboard_temp WHERE ims_mod_no IN ($section_mods) GROUP BY ims_mod_no) AS t";
		//$sql1="SELECT ims_mod_no, COUNT(DISTINCT doc_no_ref) AS \"test\" FROM $packing_dashboard_temp WHERE ims_mod_no IN ($section_mods) GROUP BY ims_mod_no";
		
		//New Modified Code to sync logic with lms dashboard
		/* $sql1="SELECT ims_mod_no, COUNT(DISTINCT doc_no_ref) AS \"test\" FROM $packing_dashboard_temp WHERE ims_mod_no IN ($section_mods)  AND ((fn_ims_log_output(doc_no,size_code)+fn_ims_log_bk_output(doc_no,size_code))-fn_act_pac_qty(doc_no,size_code))>=carton_act_qty GROUP BY ims_mod_no";
		//echo $sql1;
		$sql_result1=mysql_query($sql1,$link) or exit("Sql Error2".$sql1.mysql_error());
		while($sql_row1=mysql_fetch_array($sql_result1))
		{
			$max_blocks=$sql_row1['test'];
			if($max_blocks>3)
			{
				$id_new="red";
				$count++;
			}
		} */
		$count=0; //KK20170824
		//echo $count;
		if($count>5)
		{
			$id_new="red";
		}
		else
		{
			if($count<=5 and $count>3)
			{
				$id_new="yellow";
			}
			else
			{
				$id_new="green";
			}
		}
			
	}
	echo "<td><div id=\"$id_new\"><a href=\"http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/packing_dashboard_live_dashboard.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";
}
			
	
} //criteria
?>