
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
	$view_access=user_acl("SFCS_0238",$username,1,$group_id_sfcs);
?>

<title>Freez Plan Log</title>
<style type="text/css" media="screen">
</style>
<link href="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
</head>
<body>

<?php
	$sdate=$_REQUEST['sdate'];
	
	if($sdate==null)
	{
		$sdate=date("Y-m-d");
	}
?>

<div class="panel panel-primary">
<div class="panel-heading">Freez Plan Log <?= date("Y-M",strtotime($sdate)); ?></div>
<div class="panel-body">
<?php 

echo "<a class='btn btn-primary' href=".getFullURLLevel($_GET['r'],'log.php',0,'N')."&sdate=".date('Y-m-d', strtotime('-1 month', strtotime($sdate)))."><< Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-primary' href=".getFullURLLevel($_GET['r'],'log.php',0,'N')."&sdate=".date("Y-m-d") ."> Current Month</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class='btn btn-primary' href=".getFullURLLevel($_GET['r'],'log.php',0,'N')."&sdate=".date('Y-m-d', strtotime('+1 month', strtotime($sdate))).">Next >></a>";  ?>

<?php

$sql="select * from $bai_pro.tbl_freez_plan_log where left(date,7)=left('$sdate',7) order by date, mod_no,shift";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result)==0)
{
	$sql="select * from $bai_pro.tbl_freez_plan_tmp where left(date,7)=left('$sdate',7) order by date, mod_no,shift";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($sql_result)==0)
	{
		echo "<h3><font color=\"red\">No data available.</font></h3>";
	
	}
	else
	{
		echo "<h3><font color=\"red\">Pending to Finalize.</font></h3>";
	
	}
}

echo "<table id=\"table1\" border=1 class=\"table table-bordered\">";
echo "<tr><th>Date</th><th>Section</th><th>Module</th><th>Shift</th><th>Plan Production</th><th>Plan SAH</th><th>Plan CLH</th><th>Plan EFF%</th></tr>";


while($sql_row=mysqli_fetch_array($sql_result))
{
	
		$mod_no=$sql_row['mod_no'];
		$shift=$sql_row['shift'];
		$plan_eff=$sql_row['plan_eff'];
		$plan_pro=$sql_row['plan_pro'];
		$sec_no=$sql_row['sec_no'];
		
		$plan_clh=$sql_row['plan_clh'];
		$plan_sah=$sql_row['plan_sah'];
		$date=$sql_row['date'];
	
		echo "<tr>";
		echo "<td>$date</td>";
		echo "<td>$sec_no</td>";
		echo "<td>$mod_no</td>";
		echo "<td>$shift</td>";
				
		echo "<td>$plan_pro</td>";
		echo "<td>$plan_sah</td>";
		echo "<td>$plan_clh</td>";
		echo "<td>$plan_eff</td>";
		

		echo "</tr>";
}

echo '<tr><td colspan=4>Total:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td>
<td id="table1Tot2" style="background-color:#FFFFCC; color:red;"></td>
<td id="table1Tot3" style="background-color:#FFFFCC; color:red;"></td>
<td></td></tr>';

echo "</table>";
?>

<script language="javascript" type="text/javascript">
	var fnsFilters = {
	col_0: "select",
	col_1: "select",
	col_2: "select",
	col_3: "select",
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1","table1Tot2","table1Tot3"],
						 col: [4,5,6],  
						operation: ["sum","sum","sum"],
						 decimal_precision: [2,2,2],
						write_method: ["innerHTML","innerHTML","innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table1",fnsFilters);
	
</script>
</div></div>

</body>

