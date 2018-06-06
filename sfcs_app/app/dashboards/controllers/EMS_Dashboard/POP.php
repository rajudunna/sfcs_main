<?php
set_time_limit(2000);
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',2,'R')); ?>
<?php include("functions2.php"); ?>

<title>POP - IMS Track Panel</title>
<?php include("header_scripts.php"); ?>



<style>

a {text-decoration: none;}

.atip
{
	color:black;
}

table
{
	border-collapse:collapse;
	width:100%;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
	text-align:center;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
	background-color:#ff0000;
	text-align:center;
}

.bottom
{
	border-bottom: 3px solid white;
	padding-bottom: 5px;
	padding-top: 5px;
}



</style>

<?php
$module_ref=$_GET['module'];
$ims_doc_no_ref=$_GET['doc_ref'];
$rand_track=$_GET['rand_track'];


	
	$sql1="SELECT distinct rand_track, ims_doc_no FROM ims_log WHERE ims_mod_no=$module_ref AND ims_doc_no=$ims_doc_no_ref AND rand_track=$rand_track AND ims_status <> \"DONE\"";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result1);
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$ims_doc_no=$sql_row1['ims_doc_no'];
		
$sql22="select * from plandoc_stat_log where doc_no=$ims_doc_no and a_plies>0";
mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row22=mysqli_fetch_array($sql_result22))
{
	$order_tid=$sql_row22['order_tid'];
	
	$sql33="select * from bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$color_code=$sql_row33['color_code']; //Color Code
	}
	$cutno=$sql_row22['acutno'];
}
	
	//echo "<h2>Module - $module_ref - CUT No: ".chr($color_code).leading_zeros($cutno,3)." Summary</h2>";
	?>
	
<div class="panel panel-primary">
<div class="panel-heading">Module <?= $module_ref; ?> CUT No: <?= chr($color_code).leading_zeros($cutno,3); ?> Summary</div>
<div class="panel-body">
<?php
	//echo '<div id="page_heading"><span style="float: left"><h3>Module - '.$module_ref.' - CUT No: '.chr($color_code).leading_zeros($cutno,3).' Summary</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>';	
		echo '<div class="table-responsive" ><table style="color:black; border: 1px solid red;"';
		echo "<tr class=\"new\"><th>TID</th><th>Style</th><th>Schedule</th><th>Color</th><th>CID</th><th>DOC#</th><th>Cut No</th><th>Size</th><th>Input</th><th>Output</th><th>Balance</th></tr>";
					
		$sql12="select * from ims_log where ims_mod_no=$module_ref and rand_track=$rand_track";
		mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			echo "<tr class=\"new\"><td>".$sql_row12['tid']."</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$sql_row12['ims_size']."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>".($sql_row12['ims_qty']-$sql_row12['ims_pro_qty'])."</td></tr>";
		}
		
		echo "</table></div>";
	}


?>
</div>
</div>

