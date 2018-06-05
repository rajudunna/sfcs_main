<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',3,'R'); ?>"></script> 
<script src="<?= getFullURLLevel($_GET['r'],'common/js/highcharts.js',3,'R'); ?>"></script>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/exporting.js',3,'R'); ?>"></script>
<?php 
error_reporting(0);
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0054",$username,1,$group_id_sfcs); 
?>
<?php  
//include("../dbconf.php"); 
$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");

$sql="select * from $bai_pro3.bai_qms_rejection_reason where reason_cat=\"Fabric\"";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("bai_qms_rejection_reason error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$reason_code[]=$sql_row["reason_code"];
	$reason_desc[]=$sql_row["reason_desc"];
	//echo "<option value=\"".$sql_row["reason_code"]."\">".$sql_row["reason_desc"]."</option>";
}



$sql="select * from $bai_rm_pj1.inspection_supplier_db where product_code=\"Fabric\"";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("inspection_supplier_db Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$supplier_code[]=$sql_row["supplier_m3_code"];
}

if(isset($_POST['filter']))
{
	$reason1=$_POST['reason'];
	$reasons_list1=array();
	if($reason1)
	{
		foreach ($reason1 as $t)
	    {
			$reasons_list1[]=$t;
		}
	}
	
	$supplier1=$_POST['supplier'];
	$supplier_list1=array();
	if($supplier1)
	{
		foreach ($supplier1 as $t1)
	    {
			$supplier_list1[]=$t1;
		}
	}
}
else
{
	$reasons_list1=array();
	if($reasons_list1){
	$reasons_list1[]=implode(",",$reason_code);
	}
	$supplier_list1=array();
	$supplier_list1[]="All";
}

?>

<html>
<head>

<!--<script type="text/javascript" src="jquery.min.js"></script>
<script src="https://cdn.ovo.ua/pub/fusioncharts/fusioncharts.js"></script> 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>-->

<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	text-align: right;
	white-space:nowrap;
}

table td
{
	text-align: right;
	white-space:nowrap;
}

table td.lef
{
	text-align: left;
	white-space:nowrap; 
}
table th
{
	text-align: center;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}

}

}
</style>
</head>

<body>
<div class="panel panel panel-primary">
<div class="panel-heading">Daily Rejection Analysis Charts</div>
<div class="panel-body">
<!--<div id="page_heading"><span><h3>Daily Rejection Analysis Charts</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<div class="col-md-12">
<form name="input" method="post" action="<?php echo getFullURL($_GET['r'],'rejection_chart.php','N'); ?>">
<div class="col-md-2">
<label>Start Date </label>
<input id="demo1"  class="form-control" type="text" data-toggle='datepicker' name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> </div>
<div class="col-md-2">
<label>End Date </label>
<input id="demo2"   type="text" size="8" class="form-control" data-toggle='datepicker' onchange= "return verify_date();"  name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>"></div>
<div class="col-md-2">
<label>Supplier </label>
<select name="supplier[]" class="form-control" > 
<?php
echo implode(",",$supplier_list1);
if(in_array("All",$supplier_list1))
{	
	echo "<option value=\"All\" selected>All</option>";
}
else
{
	echo "<option value=\"All\">All</option>";
}

for($i=0;$i<sizeof($supplier_code);$i++)
{
	if(in_array($supplier_code[$i],$supplier_list1))
	{
		echo "<option value=\"".$supplier_code[$i]."\" selected>".$supplier_code[$i]."</option>";
	}
	else
	{
		echo "<option value=\"".$supplier_code[$i]."\">".$supplier_code[$i]."</option>";
	}
}

?>
</select></div>
<div class="col-md-2">
<label>Reasons</label>
<select name="reason[]" class="form-control">
<?php

if(in_array(implode(",",$reason_code),$reasons_list1))
{	
	echo "<option value=\"".implode(",",$reason_code)."\" selected>All</option>";
}
else
{
	echo "<option value=\"".implode(",",$reason_code)."\">All</option>";
}

for($i=0;$i<sizeof($reason_desc);$i++)
{
	if(in_array($reason_code[$i],$reasons_list1))
	{
		echo "<option value=\"".$reason_code[$i]."\" selected>".$reason_desc[$i]."</option>";
	}
	else
	{
		echo "<option value=\"".$reason_code[$i]."\">".$reason_desc[$i]."</option>";
	}
}

?>
</select></div>

<div class="col-md-2">
<label>Period Mode</label>

<select name="period" class="form-control">
<option value="0" <?php if($_POST['period']=="0") { echo "selected"; } ?>>Nil</option>
<option value="1" <?php if($_POST['period']=="1") { echo "selected"; } ?>>Day</option>
<option value="2" <?php if($_POST['period']=="2") { echo "selected"; } ?>>Week</option>
<option value="3" <?php if($_POST['period']=="3") { echo "selected"; } ?>>Month</option>
</select></div>
<div class="col-md-2">
<label>Chart Mode</label>
<select name="mode" class="form-control">
<option value="1" <?php if($_POST['mode']=="1") { echo "selected"; } ?>>Bar</option>
<option value="2" <?php if($_POST['mode']=="2") { echo "selected"; } ?>>Pie</option>
<option value="3" <?php if($_POST['mode']=="3") { echo "selected"; } ?>>Line</option>
</select> </div>
<br>
<br>
<div class="col-md-2">
<label>Rejection Value</label>
<select name="rejval" class="form-control">
<option value="1" <?php if($_POST['rejval']=="1") { echo "selected"; } ?>>PCS</option>
<option value="2" <?php if($_POST['rejval']=="2") { echo "selected"; } ?>>%</option>
</select> 
</div>
<div class="col-md-1">
<input type="submit" name="filter" value="Filter" style="margin-top:15pt;" onclick= "return verify_date();" class="form-control btn btn-primary">
</div>
</div>


</form>

<?php

if(isset($_POST['filter']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$reason=$_POST['reason'];
	$supplier=$_POST['supplier'];
	$period=$_POST["period"];
	$mode=$_POST["mode"];
	$rejval=$_POST["rejval"];
	$reasons_list=array();
	$suppliers_list=array();
	if($reason)
	{
		foreach ($reason as $t)
	    {
			$reasons_list[]=$t;
		}
	}
	$sql_out="select sum(bac_qty) as qty from $bai_pro.bai_log_buf where bac_date between \"".$sdate."\" and \"".$edate."\"";
	//echo $sql_out;
	$sql_result_out=mysqli_query($link, $sql_out) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_out=mysqli_fetch_array($sql_result_out))
	{
		$output=$sql_row_out["qty"];
	}
	
	if($supplier)
	{
		foreach ($supplier as $s)
	    {
			$suppliers_list[]=$s;
		}
	}
	
	for($i=0;$i<sizeof($suppliers_list);$i++)
	{
		if($i==0)
		{
			$supplier_ref[]="'".$suppliers_list[$i]."'";
		}
		else
		{
			$supplier_ref[]=",'".$suppliers_list[$i]."'";
		}
	}
	
	$reasons_list_ref=array();
	if($reasons_list)
	{
	$reasons_list_ref=implode(",",$reasons_list);	
	}
	if($supplier_ref){
	$suppliers_list_ref=implode("",$supplier_ref);	
	// echo $suppliers_list_ref;
	}
	if($suppliers_list_ref=="'All'")
	{
		for($i=0;$i<sizeof($supplier_code);$i++)
		{
			if($i==0)
			{
				$supplier_ref1[]="'".$supplier_code[$i]."'";
			}
			else
			{
				$supplier_ref1[]=",'".$supplier_code[$i]."'";
			}
		}
		if ($supplier_ref1 == 0) {
			echo "No data in Database";
		}else{

			$suppliers_list_ref_query=" and supplier in (".implode("",$supplier_ref1).") ";		
		}
	}
	else
	{
		$suppliers_list_ref_query=" and supplier in (".$suppliers_list_ref.") ";		
	}

	if($mode==1)
	{
		$mode_ref="column";
	}
	
	if($mode==2)
	{
		$mode_ref="pie";
	}
	
	if($mode==3)
	{
		$mode_ref="line";
	}
	
	$add_string="";
	
	if($rejval==2)
	{
		$add_string=" Vs Output ";
	}
	
	if($suppliers_list_ref=="'All'" && $mode!=2 && $period==0)
	{
		// echo "True1";
		include("rejection_chart_week_v2.php");
	}
	
	if($suppliers_list_ref=="'All'" && ($period==2 || $period==3 || $period==1) && ($mode==1 || $mode==3))
	{
		// echo "True2";
		include("rejection_chart_week_v5.php");
	}
	
	if($suppliers_list_ref!="'All'" and implode(",",$reason_code)==implode(",",$reasons_list) && $period==0 && ($mode==1 || $mode==3))	
	{
		// echo "True3";
		include("rejection_chart_week_v4.php");
	}
	
	if($suppliers_list_ref!="'All'" && ($period==2 || $period==3 || $period==1) && ($mode==1 || $mode==3))	
	{
		// echo "True4";
		include("rejection_chart_week_v5.php");
	}	
	
	if($suppliers_list_ref!="'All'" && $period==2 && $mode==3)	
	{
		// echo "True5";
		include("rejection_chart_week_v5.php");
	}	
	
	if($suppliers_list_ref!="'All'" && $mode==2)	
	{
		// echo "True6";
		include("rejection_chart_week_v6.php");
	}
	
	if($suppliers_list_ref=="'All'" && $mode==2 && $period==0)	
	{
		// echo "True7";
		include("rejection_chart_week_v7.php");
	}	
}

?>

<script>
function getCSVData(){
	var csv_value=$('#example1').table2CSV({delivery:'value'});
	$("#csv_text").val(csv_value);	
}
</script>
<script type="text/javascript">
	function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}
</script>

</div></div>
</body>
</html>