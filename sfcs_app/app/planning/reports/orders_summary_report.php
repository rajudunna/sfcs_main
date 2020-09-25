<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$plant_code='AIP';

?>


<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>


<div class="panel panel-primary">
<div class="panel-heading">Orders Summary Report</div>
<div class="panel-body">
<div class="form-group">
<form name="input" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="row">
<div class="col-sm-3">

<label>Start Date: </label><input data-toggle="datepicker" id="demo1" class="form-control" type="text" id="demo1" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>" required >

</div>
<div class="col-sm-3">
<label>End Date: </label><input data-toggle="datepicker" id="demo2" class="form-control" type="text"  id="demo2" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>" required >
</div>

<div class="col-sm-3">
Schedule: <input type="text" name="sch"  class="form-control" value="">Group by Color: <input type="checkbox" name="colorgroup" value="1">
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
		
	$sql="SELECT * FROM $oms.`oms_mo_details` where planned_cut_date between  '$sdate' and '$edate' and po_number !='' and plant_code='$plant_code'";
	
	if(strlen($sch)>0)
	{
		$sql="SELECT * FROM $oms.`oms_mo_details` where schedule='$sch' and po_number !='' and plant_code='$plant_code'";
	}

	// if(strlen($sch)>0)
	// {
	// 	$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, $order as orderqty, output,act_cut,act_in,act_fg,act_fca,act_ship,priority from bai_pro3.bai_orders_db_confirm where order_del_no in ($sch) group by concat(order_del_no,order_col_des) union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, $order as orderqty, output,act_cut,act_in,act_fg,act_fca,act_ship, priority from bai_pro3.bai_orders_db_confirm_archive where order_del_no in ($sch) group by concat(order_del_no,order_col_des)";
	// }
	
	// if(strlen($sch)>0 and $colorgroup==1)
	// {
	// 	$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_pro3.bai_orders_db_confirm where order_del_no in ($sch) group by order_del_no union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_pro3.bai_orders_db_confirm_archive where order_del_no in ($sch) group by order_del_no";
	// }
	
	// if(strlen($sch)==0 and $colorgroup!=1)
	// {
	// 	$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty,  sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_pro3.bai_orders_db_confirm where order_date between '$sdate' and '$edate' group by concat(order_del_no,order_col_des) union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty,  sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_pro3.bai_orders_db_confirm_archive where order_date between '$sdate' and '$edate' group by concat(order_del_no,order_col_des)";
	// }
	
	// if(strlen($sch)==0 and $colorgroup==1)
	// {
	// 	$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_pro3.bai_orders_db_confirm where order_date between '$sdate' and '$edate' group by order_del_no union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from $bai_pro3.bai_pro3.bai_orders_db_confirm_archive where order_date between '$sdate' and '$edate' group by order_del_no";
	// }



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
	<th>FCA</th>
	<th>Shipped</th>
	<th>Status</th>
</tr>";
	
	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$po_number=$sql_row['po_number'];
		$schedule=$sql_row['schedule'];
		$order_date=$sql_row['planned_cut_date'];
		$sql1="SELECT * FROM $pps.mp_color_detail where master_po_number='$po_number'";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style=$sql_row1['style'];
			$color=$sql_row1['color'];
			$master_po_details_id=$sql_row1['master_po_details_id'];
			$sql2="SELECT sum(quantity) as order_qty FROM $pps.mp_mo_qty where master_po_details_id='$master_po_details_id' and master_po_order_qty_type='ORIGINAL_QUANTITY' group by schedule,color";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$order_qty=$sql_row2['order_qty'];

				$row_count++;
				echo "<tr>";
				echo "<td>".$order_date."</td>";
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$color."</td>";
				echo "<td>".$order_qty."</td>";
				echo "<td>0</td>";
				echo "<td>0</td>";
				echo "<td>0</td>";
				echo "<td>0</td>";
				echo "<td>0</td>";
				echo "<td>0</td>";
				$priority='0';
				
				$status="";
				switch($sql_row['priority'])
				{
					case -1:
					{
						$status="Shipped";
						break;
					}
					case 1:
					{
						$status="FCA";
						break;
					}
					case 2:
					{
						$status="FG";
						break;
					}
					case 3:
					{
						$status="Packing";
						break;
					}
					case 4:
					{
						$status="Sewing";
						break;
					}
					case 5:
					{
						$status="Cutting";
						break;
					}
					case 6:
					{
						$status="RM";
						break;
					}
					case 0:
					{
						$status="RM";
						break;
					}
					
				}
				echo "<td>$status</td>";
				echo "</tr>";
			}
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