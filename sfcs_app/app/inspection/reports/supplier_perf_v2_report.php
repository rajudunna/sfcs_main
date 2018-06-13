<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
// Need to show summary of batches and update the log time for fully filled batches. Total Batches || Updated Batches || Pending Batches || Passed Batches || Failed Batches
?>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$Page_Id='SFCS_0058';
?>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionChartsExportComponent.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<style>
tr.headings {
    background-color: #d9edf7;
}
</style>

<script language="javascript" type="text/javascript">

function popitup(url) {
	newwindow=window.open(url,'name','height=500,width=650');
	if (window.focus) {newwindow.focus()}
	return false;
}

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



<div class="panel panel-primary">
<div class="panel-heading">Supplier Wise Performance Report</div>
<div class="panel-body">

<body>

<form name="input" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
Start Date <input id="demo1"  class="form-control" style="width: 150px;  display: inline-block;"  type="text" data-toggle="datepicker" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>">
 End Date <input id="demo2" class="form-control" style="width: 150px;  display: inline-block;" type="text" data-toggle="datepicker"  onchange="return verify_date();" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
<input type="checkbox"  value="1" name="excemptflag">Excempt Inspection/Relaxation Results
&nbsp;&nbsp;
<input type="submit" name="filter" class="btn btn-success" onclick="return verify_date();" value="Filter">
</form>
<?php

if(isset($_POST['filter']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	
	echo "<div id='main_div' class='table-responsive' style='height:500px;'>";
	echo "<hr/>";
	$table="<table id='table1' class='table table-bordered'>";
	$table.="<tr class = 'headings'>";
	$table.="<th>RECORD #</th><th>WEEK #</th><th>ENTRY NO</th><th>INVOICE NO & DATE</th><th>SWATCHES RECEIVED DATE FROM STORES</th><th>SWATCHES RECEIVED TIME FROM STORES</th><th>SWATCHES RECEIVED FROM (SUPPLIER/WH)</th><th>INSPECTED DATE</th><th>RELEASED DATE</th><th>REPORT #</th><th>GRN.DATE</th><th>ENT. DATE</th><th>BUYER</th><th>STYLE</th><th>M3 LOT#</th><th>PO</th><th>SUPPLIER</th><th>QUALITY</th><th>RM SPECIALTY</th><th>CONSTRUCTION</th>
	<th>COMPOSITION</th><th>COLOR</th><th>SOLID / YARN DYE / PRINT</th><th>BATCH #</th><th>NO OF ROLLS</th><th>QTY $fab_uom</th><th>C TEX LENGTH</th>
	<th>C TEX L/S</th><th>INSPECTED TAG STY ($fab_uom)</th><th>INSPECTED ACT STY ($fab_uom)</th><th>L/S</th><th>WIDTH MEASURING UNIT</th>	<th>PURCHASE WIDTH</th><th>ACTUAL WIDTH</th><th>PURCHASED WEIGHT (GSM)</th><th>ACTUAL WEIGHT (GSM)</th><th>CONSUMPTION</th><th>PTS./100 SQ. $fab_uom OR FAULT RATE</th><th>GMT FALLOUT% (FAB.INS)</th>	<th>FREQUENTLY SEEN DEFECTS</th><th>SKEW / BOW / WAVINESS / DOG-LEG</th><th>SKEW / BOW / WAVINESS / DOG-LEG %</th><th>RESIDUAL SHRINKAGE LENGTH</th><th>RESIDUAL SHRINKAGE WIDTH</th><th>SUPPLIER TEST REPORT (PASS/FAIL/NA)</th><th>AT SOURCE INSPECTION 10% REPORT (YES /NO)</th><th>AT SOURCE INSPECTION C.C REPORT (YES /NO)</th><th>COMPLAINT#</th><th>REJECTED QTY ($fab_uom)</th><th>FAIL REASON1</th><th>REASON 1 VALUE</th><th>FAIL REASON 2</th>	<th>REASON 2 VALUE</th><th>FAB TECH DECISION</th><th>HIGH PTS</th><th>FALL OUT</th><th>SKEW/BOWING</th><th>WIRC SHADING</th><th>GSM</th><th>OTHERS</th>	<th>OFF SHADE</th><th>HAND FEEL</th><th>LENGTH</th><th>WIDTH</th><th>Test Report</th><th>STATUS</th><th>IMPACT (YES/NO)</th>";
	$table.="</tr>";
	
	$sql="select * from $bai_rm_pj1.supplier_performance_track where DATE(log_time) between \"".$sdate."\" AND \"".$edate."\" AND LENGTH(srdfs)>0 AND LENGTH(srtfs)>0 AND LENGTH(srdfsw)>0 AND LENGTH(reldat)>0 AND LENGTH(quality)>0 AND LENGTH(rms)>0 AND LENGTH(const)>0 AND LENGTH(syp)>0 AND LENGTH(qty_insp_act)>0 AND LENGTH(defects)>0 AND LENGTH(skew_cat_ref)>0 AND LENGTH(sup_test_rep)>0 AND LENGTH(inspec_per_rep)>0 AND LENGTH(cc_rep)>0 AND LENGTH(fab_tech)>0 ORDER BY log_time";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result) > 0)
	{
		$flag=true;
		// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'controllers/supplier_perf_summary.php',1,'R')); 
		
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$table.="<tr>";
			$table.="<td>".$sql_row["bai1_rec"]."</td>";
			$table.="<td>".$sql_row["weekno"]."</td>";
			$table.="<td>".$sql_row["pkg_no"]."</td>";
			$table.="<td>".$sql_row["invoice"]."</td>";
			$table.="<td>".$sql_row["srdfs"]."</td>";
			$table.="<td>".$sql_row["srtfs"]."</td>";
			$table.="<td>".$sql_row["srdfsw"]."</td>";
			$table.="<td>".$sql_row["insp_date"]."</td>";
			$table.="<td>".$sql_row["reldat"]."</td>";
			$table.="<td>".$sql_row["unique_id"]."</td>";
			$table.="<td>".$sql_row["grn_date"]."</td>";
			$table.="<td>".$sql_row["entdate"]."</td>";
			$table.="<td>".$sql_row["buyer"]."</td>";
			$table.="<td>".$sql_row["item"]."</td>";
			$table.="<td>".$sql_row["lots_ref"]."</td>";
			$table.="<td>".$sql_row["po_ref"]."</td>";
			$table.="<td>".$sql_row["supplier_name"]."</td>";
			$table.="<td>".$sql_row["quality"]."</td>";
			$table.="<td>".$sql_row["rms"]."</td>";
			$table.="<td>".$sql_row["const"]."</td>";
			$table.="<td>".$sql_row["compo"]."</td>";
			$table.="<td>".$sql_row["color_ref"]."</td>";
			$table.="<td>".$sql_row["syp"]."</td>";
			$table.="<td>".$sql_row["batch_ref"]."</td>";
			$table.="<td>".$sql_row["rolls_count"]."</td>";
			$table.="<td>".$sql_row["tktlen"]."</td>";
			$table.="<td>".$sql_row["ctexlen"]."</td>";
			$table.="<td>".$sql_row["lenper"]."</td>";
			$table.="<td>".$sql_row["qty_insp"]."</td>";
			$table.="<td>".$sql_row["qty_insp_act"]."</td>";
			if($sql_row["qty_insp_act"] > 0)
			{
				$table.="<td>".round($sql_row["qty_insp"]/$sql_row["qty_insp_act"],0)."%</td>";
			}
			else
			{
				$table.="<td>0%</td>";
			}
			//$table.="<td>".$sql_row["len_qty"]."</td>";
			$table.="<td>".$sql_row["inches"]."</td>";
			$table.="<td>".$sql_row["pur_width_ref"]."</td>";
			$table.="<td>".$sql_row["act_width_ref"]."</td>";
			$table.="<td>".$sql_row["pur_gsm"]."</td>";
			$table.="<td>".$sql_row["act_gsm"]."</td>";
			$table.="<td>".$sql_row["consumption"]."</td>";
			$table.="<td>".$sql_row["pts"]."</td>";
			$table.="<td>".$sql_row["fallout"]."</td>";
			$table.="<td>".$sql_row["defects"]."</td>";
			$table.="<td>".$sql_row["skew_cat_ref"]."</td>";
			$table.="<td>".$sql_row["skew"]."</td>";
			$table.="<td>".$sql_row["shrink_l"]."</td>";
			$table.="<td>".$sql_row["shrink_w"]."</td>";
			$table.="<td>".$sql_row["sup_test_rep"]."</td>";
			$table.="<td>".$sql_row["inspec_per_rep"]."</td>";
			$table.="<td>".$sql_row["cc_rep"]."</td>";
			$table.="<td>".$sql_row["com_ref1"]."</td>";
			$table.="<td>".$sql_row["reason_qty"]."</td>";
			$table.="<td>".$sql_row["reason_name"]."</td>";
			$table.="<td>".$sql_row["reason_ref_explode_ex"]."</td>";
			$table.="<td>".$sql_row["reason_name1"]."</td>";
			$table.="<td>".$sql_row["reason_ref_explode_ex1"]."</td>";
			$table.="<td>".$sql_row["fab_tech"]."</td>";
			if($_POST['excemptflag']==1)
			{
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
				$table.="<td>Pass</td>";
			}
			else
			{
				$table.="<td>".$sql_row["high_pts"]."</td>";
				$table.="<td>".$sql_row["fall_out"]."</td>";
				$table.="<td>".$sql_row["skew_bowing"]."</td>";
				$table.="<td>".$sql_row["wirc_shading"]."</td>";
				$table.="<td>".$sql_row["gsm"]."</td>";
				$table.="<td>".$sql_row["others"]."</td>";
				$table.="<td>".$sql_row["off_shade"]."</td>";
				$table.="<td>".$sql_row["hand_feel"]."</td>";
				$table.="<td>".$sql_row["length"]."</td>";
				$table.="<td>".$sql_row["width"]."</td>";
				$table.="<td>".$sql_row["test_report"]."</td>";
				$table.="<td>".$sql_row["status_f"]."</td>";
				
			}
				
			$table.="<td>".$sql_row["impact"]."</td>";
			$table.="</tr>";
		}
		$table.="</table>";
		echo $table;
		echo '</div>';
	}
	else
	{
		$flag=false;
	}
	if(!$flag){
		echo "<script>sweetAlert('No Data Found','','warning');
		$('#main_div').hide()</script>";
	}
}

?>

<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_66: "select",
	sort_select: true,
	display_all_text: "Display all",
	loader: true,
	loader_text: "Filtering data...",
	sort_select: true,
	exact_match: true,
	rows_counter: true,
	btn_reset: true
	}
	setFilterGrid("table1",table3Filters);
</script>

</body>
</div>
</div>
</div>

<script>

$(document).ready(function(){
	$('#reset_table1').addClass('btn');
	$('#reset_table1').addClass('btn-warning');
	$('#reset_table1').css({'width':'100px'});
})

</script>