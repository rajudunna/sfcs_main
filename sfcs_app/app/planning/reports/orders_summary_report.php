<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0044",$username,1,$group_id_sfcs);
?>


<html>
<head>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'Alpha/anu/incentives/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<!-- <script type="text/javascript" src="<?= getFullURL($_GET['r'],'jquery-1.3.2.js','R')?>"></script> -->
<script type="text/javascript" src="<?= getFullURL($_GET['r'],'table2CSV.js','R')?>"></script>
<!-- <script type="text/javascript" src="<?= getFullURL($_GET['r'],'datetimepicker_css.js','R')?>"></script> -->


<?php
//  echo '<link href="'.getFullURL($_GET['r'],'/master/styles/sfcs_styles.css','R').'" rel="stylesheet" type="text/css" />'; ?>

</head>
<body>

<div class="panel panel-primary">
<div class="panel-heading">Orders Summary Report</div>
<div class="panel-body">
<div class="form-group">
<form name="input" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<!-- Start Date <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> End Date <input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
 --><div class="row">
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
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$sch=$_POST['sch'];
	$colorgroup=$_POST['colorgroup'];
	
	$order="(order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50)";
	if(strlen($sch)>0)
	{
		$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, $order as orderqty, output,act_cut,act_in,act_fg,act_fca,act_ship,priority from bai_orders_db_confirm where order_del_no in ($sch) group by concat(order_del_no,order_col_des) union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, $order as orderqty, output,act_cut,act_in,act_fg,act_fca,act_ship, priority from bai_orders_db_confirm_archive where order_del_no in ($sch) group by concat(order_del_no,order_col_des)";
	}
	
	if(strlen($sch)>0 and $colorgroup==1)
	{
		$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_orders_db_confirm where order_del_no in ($sch) group by order_del_no union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_orders_db_confirm_archive where order_del_no in ($sch) group by order_del_no";
	}
	
	if(strlen($sch)==0 and $colorgroup!=1)
	{
		$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty,  sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_orders_db_confirm where order_date between '$sdate' and '$edate' group by concat(order_del_no,order_col_des) union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty,  sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_orders_db_confirm_archive where order_date between '$sdate' and '$edate' group by concat(order_del_no,order_col_des)";
	}
	
	if(strlen($sch)==0 and $colorgroup==1)
	{
		$sql="select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_orders_db_confirm where order_date between '$sdate' and '$edate' group by order_del_no union select order_date,order_style_no,order_del_no,group_concat(trim(both from order_col_des)) as order_col_des, sum($order) as orderqty, sum(output) as output,sum(act_cut) as act_cut,sum(act_in) as act_in,sum(act_fg) as act_fg,sum(act_fca) as act_fca,sum(act_ship) as act_ship, priority from bai_orders_db_confirm_archive where order_date between '$sdate' and '$edate' group by order_del_no";
	}



	echo '<form action="'.getFullURL($_GET['r'],'export_excel.php','R').'" method ="post" > 
	<input type="hidden" name="csv_text" id="csv_text">
	<input type="submit" class="btn btn-info"  value="Export to Excel" onclick="getCSVData()">
	</form>';

	echo "<br><div class='table-responsive'><table id='example1' class ='table'>";
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
		$row_count++;
			echo "<tr>";
			echo "<td>".$sql_row['order_date']."</td>";
			echo "<td>".$sql_row['order_style_no']."</td>";
			echo "<td>".$sql_row['order_del_no']."</td>";
			echo "<td>".$sql_row['order_col_des']."</td>";
			echo "<td>".$sql_row['orderqty']."</td>";
			echo "<td>".$sql_row['act_cut']."</td>";
			echo "<td>".$sql_row['act_in']."</td>";
			echo "<td>".$sql_row['output']."</td>";
			echo "<td>".$sql_row['act_fg']."</td>";
			echo "<td>".$sql_row['act_fca']."</td>";
			echo "<td>".$sql_row['act_ship']."</td>";
			
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
	var MyTableFilter = {  exact_match: false,
	display_all_text: "Show All",
	col_0: "select",
	col_1: "select" }
	setFilterGrid( "example1", MyTableFilter );
	//]]>
</script>

</div>
</div>
</body>
</html>