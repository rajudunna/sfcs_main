<?php
	// include("../dbconf.php"); 
//change dots to server document root 26-06-2018
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?>

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

table{
	font-size:12px;
}
th {
    text-align:center;
}
td {
    text-align:center;
}
</style>

<!--Loading End -->

<title>Carton Pending Report</title>


<!-- Loading begining -->
<div id="loading_screen">
    <h1>Loading...</h1> 
   <h3>Please Wait...</h3> 

</div>

<!-- <script type="text/javascript"> 
display_loading_screen();
</script> -->

<!-- Loading End -->

<?php
echo "<div class='panel panel-primary'>
		<div class='panel-heading'>Carton Scanning Issues</div>
    		<div class='panel-body'>";
echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>";
echo "<tr style='background-color:#ede8e8;color:black;text-align:center;font-size:12px;'><th>Module</th><th>Style</th><th>Schedule</th><th>Color</th><th>Job</th><th>Carton ID</th><th>Size</th><th>Carton Qty</th></tr>";

		$sql1="SELECT * FROM $bai_pro3.packing_issues order by ims_mod_no";
		// echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result1)>0) {	
			while($sql_row1=mysqli_fetch_array($sql_result1))
				{			
					$sqlx="select acutno,color_code from $bai_pro3.live_pro_table_ref2 where doc_no=".$sql_row1['doc_no'];
					$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowx=mysqli_fetch_array($sql_resultx))
					{
						$job=chr($sql_rowx['color_code']).leading_zeros($sql_rowx['acutno'],3);
					}
					echo "<tr><td>$sql_row1[ims_mod_no]</td><td>$sql_row1[ims_style]</td><td>$sql_row1[ims_schedule]</td><td>$sql_row1[ims_color]</td><td>$job</td><td>$sql_row1[tid]</td><td>$sql_row1[size_code]</td><td>$sql_row1[carton_act_qty]</td></tr>";
					echo "</tr>";
				}
		}
		else {
			echo "<tr><td colspan=8><span style='color:red;'><center><b>no data found!</b></center></span></td></tr>";
		}
echo "</table></div>";
?>

<?php
echo "<br/><div class='panel panel-primary'>
		<div class='panel-heading'>Section Wise Carton Pending List</div>
    <div class='panel-body'>";
echo "<div class='table-responsive'><table class='table table-bordered'  style='width:80%;'>";
echo "<tr style='background-color:#ede8e8;color:black;'><th>Section</th><th>Pending</th></tr>";

//NEW2013
//NEW ADD 2013-04-17
$sql1="truncate $bai_pro3.packing_dashboard_pop_temp";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="insert into $bai_pro3.packing_dashboard_pop_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from $bai_pro3.packing_dashboard";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
//NEW ADD 2013-04-17

$sqlx="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` GROUP BY section ORDER BY section + 0";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	// $section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	

	if(sizeof($section_mods)>0)
	{
		$y=0;
		$sql1="SELECT * FROM $bai_pro3.packing_dashboard_pop_temp WHERE ims_mod_no in ($section_mods) ORDER BY lastup";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
					
			$ims_doc_no=$sql_row1['doc_no'];
			$ims_size=$sql_row1['size_code'];
			$ims_tid_qty=$sql_row1['carton_act_qty'];
			
			//$sqla="select sum(bac_qty) as qty from bai_pro.bai_log_buf where ims_doc_no=$ims_doc_no and size_$ims_size > 0";
			$sqla="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0";
			$sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowa=mysqli_fetch_array($sql_resulta))
			{
				$output_qty=$sql_rowa["qty"];	
			}
			
			$sqla1="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log_backup where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0";
			//echo $sqla1;
			$sql_resulta1=mysqli_query($link, $sqla1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowa1=mysqli_fetch_array($sql_resulta1))
			{
				$output_qty1=$sql_rowa1["qty"];	
			}
			
			$sqlb="select sum(carton_act_qty) as qty from $bai_pro3.pac_stat_log where doc_no=$ims_doc_no and size_code=\"".$ims_size."\" and status=\"DONE\"";
			$sql_resultb=mysqli_query($link, $sqlb) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowb=mysqli_fetch_array($sql_resultb))
			{
				$packing_qty=$sql_rowb["qty"];	
			}
			
			//echo $packing_qty."-".($output_qty+$output_qty1)."-".$ims_size."-".$ims_doc_no."-".(($output_qty+$output_qty1)-$packing_qty)."<br>";
			
			if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty)
			{
				$y=$y+1;
			}
		}	
		echo "<tr><td>$section</td><td>$y</td>";
		echo "</tr>";
		$y=0;
		
		
	}
}
echo "</table></div></div></div></div></div></div>";
?>