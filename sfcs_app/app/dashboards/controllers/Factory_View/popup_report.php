<?php 
include ("../../../../common/config/config.php");
include ("../../../../common/config/functions.php");
$section_no=$_GET['section_no'];
?>

<html>
<head>

<!-- Loading Page -->

<script type="text/javascript">
(function()
{	
  if (window.addEventListener)
  {
    window.addEventListener("load", hide_loading_screen, false);    
  }
  else
  {
    window.attachEvent("onload", hide_loading_screen);
  }
})();

function display_loading_screen()
{
  document.getElementById("loading_screen").style.display = 'block';
}

function hide_loading_screen()
{
  document.getElementById("loading_screen").style.display = 'none';
}

</script>

<style type="text/css">
#loading_screen
{  
  display: none;
  position: absolute;
  left: 0px;
  top: 0px;
  height: 100%;
  width: 100%;
  background-color: black;
  color: white;  
  text-align: center;
  padding-top: 100px;
}
</style>

<!--Loading End -->

<link rel="stylesheet" type="text/css" href="../../common/css/page_style.css" />
<title>Carton Pending Report</title>

<style>


body
{
	font-family: Century Gothic;
	font-size: 12px;
}
table{
	font-size:12px;
}
</style>





</head>
<body>

<!-- Loading begining -->
<div id="loading_screen">
    <h1>Loading...</h1> 
   <h3>Please Wait...</h3> 

</div>

<script type="text/javascript"> 
display_loading_screen();
</script>

<!-- Loading End -->

<?php
echo "<h2>Carton Pending List - Section - $section_no</h2>";
echo "<table>";
echo "<tr><th>Module</th><th>Style</th><th>Schedule</th><th>Color</th><th>Job</th><th>Carton ID</th><th>Size</th><th>Carton Qty</th><th>Completed on</th><th>Executed Modules</th></tr>";

//NEW2013
//NEW ADD 2013-04-17
$sql1="truncate packing_dashboard_temp";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="insert into packing_dashboard_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from packing_dashboard";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//NEW ADD 2013-04-17

$sqlx="select * from sections_db where sec_id>=0 and sec_id in ($section_no)";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	
	$mods=array();
	$mods=explode(",",$section_mods);

	$row_color="test";
	for($x=0;$x<sizeof($mods);$x++)
	{
		$module=$mods[$x];
	
		$sql1="SELECT * FROM packing_dashboard_temp WHERE ims_mod_no=$module ORDER BY lastup";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		$check=0;
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			echo "<tr class=\"$row_color\">";
			if($check==0)
			{
				echo "<td rowspan=$sql_num_check>$module</td>";
				$check=1;
			}			
			
			$sql11="SELECT group_concat(distinct ims_mod_no order by ims_mod_no) as \"bac_no\" FROM ims_log_backup where ims_mod_no<>0 and ims_schedule=".$sql_row1['ims_schedule'];
			mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$modules_list=$sql_row11['bac_no'];	
			}
			
			$sql11="select acutno,color_code from live_pro_table_ref2 where doc_no=".$sql_row1['doc_no'];
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$job=chr($sql_row11['color_code']).leading_zeros($sql_row11['acutno'],3);
			}
			
			echo "<td>$sql_row1[ims_style]</td><td>$sql_row1[ims_schedule]</td><td>$sql_row1[ims_color]</td><td>$job</td><td>$sql_row1[tid]</td><td>$sql_row1[size_code]</td><td>$sql_row1[carton_act_qty]</td><td>$sql_row1[ims_log_date]</td><td>$modules_list</td>";
			echo "</tr>";

		}
		
		if($row_color=="test")
		{
			$row_color="test1";
		}
		else
		{
			$row_color="test";
		}
	}
	
}
?>
</body>
</html>