<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$plant_code=$_SESSION['plantCode'];
?>


<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>


<div class="panel panel-primary">
<div class="panel-heading">Orders Summary Report</div>
<div class="panel-body">
<div class="form-group">
<form name="input" method="post" action="index-no-navi.php?r=<?php echo $_GET['r']; ?>">
<div class="row">
<div class="col-sm-3">

<label>Start Date: </label><input data-toggle="datepicker" id="demo1" class="form-control" type="text" id="demo1" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>" required >

</div>
<div class="col-sm-3">
<label>End Date: </label><input data-toggle="datepicker" id="demo2" class="form-control" type="text"  id="demo2" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>" required >
</div>

<div class="col-sm-3">
Schedule: <input type="text" name="sch"  class="form-control" value="">
</div>
<div class="col-sm-3">
<input type="submit" style="margin-top:22px;" name="filter" id="filter" class="btn btn-info" value="Filter" onclick="return verify_date()">
</div>
</form>
</div>



<?php

if(isset($_POST['filter']))
{
	$row_count = 0;
	$sdate=date('Ymd',strtotime($_POST['sdate']));
	$edate=date('Ymd',strtotime($_POST['edate']));
	$sch=$_POST['sch'];
	$colorgroup=$_POST['colorgroup'];
		
	$cut_operation=15;
	$sew_in=100;
	$sew_out=130;
	$fg=200;
	$operation_code_array=[15,100,130,200];


	$sql="SELECT * FROM $oms.oms_mo_details where planned_cut_date between  '$sdate' and '$edate' and po_number !='' and plant_code='$plant_code' group by po_number";
	
	if(strlen($sch)>0)
	{
		$sql="SELECT * FROM $oms.oms_mo_details where schedule='$sch' and po_number !='' and plant_code='$plant_code' group by po_number";
	}


	echo '<form action="'.getFullURL($_GET['r'],'export_excel.php','R').'" method ="post" > 
	<input type="hidden" name="csv_text" id="csv_text">
	<input type="hidden" name="csvname" id="csvname" value="Order Summary Report">
	<input type="submit" class="btn btn-info" id="expexc" name="expexc" value="Export to Excel" onclick="getCSVData()">
	</form>';
	echo "<br><div class='table-responsive'><table id='example1' name='example1' class ='table table-bordered table-striped'>";
	echo "<tr class='tblheading'>
	<th>Order Date</th>
	<th>Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Order</th>
	<th>Cut</th>
	<th>In</th>
	<th>Out</th>
	<th>FG</th>
	<th>Status</th>
	</tr>";
	
	// echo $sql."<br/>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$po_number=$sql_row['po_number'];
		$schedule=$sql_row['schedule'];
		$order_date=$sql_row['planned_cut_date'];
		$sql1="SELECT * FROM $pps.mp_color_detail where master_po_number='$po_number' group by style,color";
		// echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$row_count++;
			$style=$sql_row1['style'];
			$color=$sql_row1['color'];
			$master_po_details_id=$sql_row1['master_po_details_id'];
			// var_dump($style,$color,$schedule,$po_number,"<br>");
			$sql2="SELECT sum(quantity) as order_qty FROM $pps.mp_mo_qty where master_po_details_id='$master_po_details_id' and master_po_order_qty_type='ORIGINAL_QUANTITY' group by schedule,color";
			// echo $sql2."<br/>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$order_qty=$sql_row2['order_qty'];
			}
			$finished_good_id=[];
			$sql3="SELECT finished_good_id FROM $pts.finished_good WHERE  master_po ='$po_number' AND style='$style' AND color='$color' AND SCHEDULE='$schedule'";
			// echo $sql3."<br/>";

			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$finished_good_id[]=$sql_row3['finished_good_id'];
			}
			$cut_qty=0;
			$sew_in=0;
			$sew_out=0;
			$fg=0;

			if(sizeof($finished_good_id) >0){
				$finished_good_ids = "'" . implode( "','", $finished_good_id) . "'";
				$operation_codes = "'" . implode( "','", $operation_code_array) . "'";


				$sql4="SELECT SUM(IF(operation_code=$cut_operation,1,0)) AS cut_qty,SUM(IF(operation_code=$sew_in,1,0)) AS sew_in,SUM(IF(operation_code=$sew_out,1,0)) AS sew_out,SUM(IF(operation_code=$fg,1,0)) AS fg FROM $pts.fg_operation WHERE finished_good_id IN ($finished_good_ids) AND operation_code IN ($operation_codes) AND required_components=completed_components";
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$cut_qty=(int)$sql_row4['cut_qty'];
					$sew_in=(int)$sql_row4['sew_in'];
					$sew_out=(int)$sql_row4['sew_out'];
					$fg=(int)$sql_row4['fg'];
				}
			}
			$status="RM";
			if($order_qty<=$cut_qty){
				$status="Cutting";
			}
			if($order_qty<=$sew_in || $order_qty<=$sew_out){
				$status="Sewing";
			}
			
			if($order_qty<=$fg){
				$status="FG";
			}
			
				
				echo "<tr>";
				echo "<td>".$order_date."</td>";
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$color."</td>";
				echo "<td>".$order_qty."</td>";
				echo "<td>".$cut_qty."</td>";
				echo "<td>".$sew_in."</td>";
				echo "<td>".$sew_out."</td>";
				echo "<td>".$fg."</td>";
				echo "<td>$status</td>";
				echo "</tr>";
		}
			
	}

	echo "</table></div>";
	if($row_count == 0){
		echo 'No Data Found';
	}
}

?>

<script language="javascript">
function getCSVData(){
 var csv_value=$('#example1').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>

<script type="text/javascript">
	

	function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		// d1 = new Date(val1);
		// d2 = new Date(val2);
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

<script language="javascript" type="text/javascript">
	//<![CDATA[
		$('#reset_example1').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "example1",table6_Props );
	$(document).ready(function(){
		$('#reset_example1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>

</div>
</div>

<style>
	table
{
	font-family:calibri;
	font-size:15px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
	background-color: #337ab7;
	border-color: #337ab7;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:15px;
}
#reset_example1{
	width : 50px;
	color : #ec971f;
	margin-top : 10px;
	margin-left : 0px;
	margin-bottom:15pt;
}
</style>