<?php
include("dbconf.php");



$database1="bai_hr_database";
$user1=$host_adr1_un;
$password1=$host_adr1_pw;
$host1="baidbsrv05";

$link1= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host1, $user1, $password1)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($link1, $database1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));


include("session_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<title>BAI BTS -POPUP :: Master Performance Reports</title>
<style>
	<style>
body
{
	font-family:Arial;
	font-size:12px;
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

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	font-family:Arial;
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


h2
{
	font-family:Arial;
}
h1{
	font-family:Arial;
}
h3{
	font-family:Arial;
}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:25px;
 right:0;
 width:auto;
float:right;
}
</style>
	

<script src="js/jquery.min1.7.1.js"></script>
<script src="ddtf.js"></script>


<link rel="stylesheet" type="text/css" media="all" href="jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsdatepick-calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>

</head>
<body>


<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" name="input">

Date: <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>">
<input type="submit" name="submit" value="submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"/>


</form>
<?php
if(isset($_POST['submit']))
{
	$date=$_POST['sdate'];
	$year=substr($date,2,2);
	//$hour=date("H");
	$sql="SELECT * FROM `bai_hr_tna_em_$year$year`.`calendar` WHERE DATE='".$date."'";
	
	$sql_result=mysqli_query($link1, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$shift=$sql_row['remarks'];
	}
	//echo $shift;
	$shift_tot=explode("$",$shift);
	$first_shift=substr($shift_tot[0],0,1);
	$second_shift=substr($shift_tot[1],0,1);
	//echo $first_shift."--".$second_shift."<br>";
	if($first_shift=='A')
	{
		$sql1="select * from brandix_bts.view_set_1 where date(bundle_transactions_date_time)='".$date."' and bundle_transactions_shift='2' and hour(bundle_transactions_date_time) between 6 and 13";
	}
	else if($first_shift=='B')
	{
		$sql1="select * from brandix_bts.view_set_1 where date(bundle_transactions_date_time)='".$date."' and bundle_transactions_shift='1' and hour(bundle_transactions_date_time) between 6 and 13";
	}
	//echo $sql1."<br>";
	echo "<h3>Shift -$shift_tot[0]<h3><br>";
	/*$sql_result=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	while($sql_row=mysql_fetch_array($sql_result))
	{
		$parent_id[]=$sql_row['id'];
	}*/
	$i=1;
	//$sql1="select * from brandix_bts.view_set_1 where bundle_transactions_20_repeat_parent_id in ('".implode(" ",$parent_id)."')";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result1)>0)
	{
		$table_data.="<table id='table_format'>";
		$table_data.="<tr>";
		$table_data.="<th>Sno</th>";
		$table_data.="<th>Date</th>";
		$table_data.="<th>Bundle Number</th>";
		$table_data.="<th>Quantity</th>";
		$table_data.="<th>Rejection Quantity</th>";
		$table_data.="<th>Module</th>";
		$table_data.="<th>Operation</th>";
		$table_data.="<th>Employee Number</th>";
		$table_data.="<th>Selected Shift</th>";
		$table_data.="<tr>";
		while($sql_row=mysqli_fetch_array($sql_result1))
		{
			$table_data.="<tr>";
			$table_data.="<td>".$i."</td>";
			$table_data.="<td>".date($sql_row['bundle_transactions_date_time'])."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_bundle_id']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_quantity']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_rejection_quantity']."</td>";
			
			if($sql_row['bundle_transactions_20_repeat_operation_id']==1)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_module_id']."</td>";
				$table_data.="<td>Bundling</td>";
			}
			else if($sql_row['bundle_transactions_20_repeat_operation_id']==2)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_module_id']."</td>";
				$table_data.="<td>Bundling Out</td>";
			}
			else if($sql_row['bundle_transactions_20_repeat_operation_id']==3)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_module_id']."</td>";
				$table_data.="<td>Line In</td>";
			}
			else if($sql_row['bundle_transactions_20_repeat_operation_id']==4)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_act_module']."</td>";
				$table_data.="<td>Line Out</td>";
			}
			//$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_operation_id']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_employee_id']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_shift']."</td>";
			$table_data.="<tr>";
			$i++;
		}
		$table_data.="</table>";
		echo $table_data;
		echo "<br><br>";
		$table_data='';
	}
	else
	{
		echo "Data not Found";
	}
	
	$i=1;
	if($second_shift=='A')
	{
		$sql2="select * from brandix_bts.view_set_1 where date(bundle_transactions_date_time)='".$date."' and bundle_transactions_shift='2' and hour(bundle_transactions_date_time) between 14 and 22";
	}
	else if($second_shift=='B')
	{
		$sql2="select * from brandix_bts.view_set_1 where date(bundle_transactions_date_time)='".$date."' and bundle_transactions_shift='1' and hour(bundle_transactions_date_time) between 14 and 22";
	}
	//echo $sql2."<br>"; 
	echo "<h3>Shift -$shift_tot[1]</h3><br>";
	/*$sql_result2=mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
	while($sql_row2=mysql_fetch_array($sql_result2))
	{
		$parent_id1[]=$sql_row2['id'];
	}
	$sql3="select * from brandix_bts.view_set_1 where bundle_transactions_20_repeat_parent_id in ('".implode(" ",$parent_id1)."')";*/
	$sql_result=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0)
	{
		$table_data.="<table id='table_format'>";
		$table_data.="<tr>";
		$table_data.="<th>Sno</th>";
		$table_data.="<th>Date</th>";
		$table_data.="<th>Bundle Number</th>";
		$table_data.="<th>Quantity</th>";
		$table_data.="<th>Rejection Quantity</th>";
		$table_data.="<th>Module</th>";
		$table_data.="<th>Operation</th>";
		$table_data.="<th>Employee Number</th>";
		$table_data.="<th>Selected Shift</th>";
		$table_data.="<tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$table_data.="<tr>";
			$table_data.="<td>".$i."</td>";
			$table_data.="<td>".date($sql_row['bundle_transactions_date_time'])."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_bundle_id']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_quantity']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_rejection_quantity']."</td>";
			
			if($sql_row['bundle_transactions_20_repeat_operation_id']==1)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_module_id']."</td>";
				$table_data.="<td>Bundling</td>";
			}
			else if($sql_row['bundle_transactions_20_repeat_operation_id']==2)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_module_id']."</td>";
				$table_data.="<td>Bundling Out</td>";
			}
			else if($sql_row['bundle_transactions_20_repeat_operation_id']==3)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_module_id']."</td>";
				$table_data.="<td>Line In</td>";
			}
			else if($sql_row['bundle_transactions_20_repeat_operation_id']==4)
			{
				$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_act_module']."</td>";
				$table_data.="<td>Line Out</td>";
			}
			//$table_data.="<td>".$sql_row['bundle_transactions_20_repeat_operation_id']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_employee_id']."</td>";
			$table_data.="<td>".$sql_row['bundle_transactions_shift']."</td>";
			$table_data.="<tr>";
			$i++;
		}
		$table_data.="</table>";
		echo $table_data;
		echo "<br><br>";
		
	}
	else
	{
		echo "Data not Found";
	}
}	
/*	
	$table_data.="<h2>Day wise Style/Schedule/Color Performance</h2>";	
	$table_data.="<h3>$title</h3>";
	$table_data.="<table id='table_format'>";
	$table_data.="<tr>";
	$table_data.="<td>Date</td>";
	$table_data.="<td>Style</td>";
	$table_data.="<td>Schedule</td>";
	$table_data.="<td>Color</td>";
	$table_data.="<td>Bundling</td>";
	$table_data.="<td>Bundle Out</td>";
	$table_data.="<td>Line In</td>";
	$table_data.="<td>Line Out</td>";
	$table_data.="<td>Rejected</td>";
	$table_data.="<td>Carton Pack</td>";
	$table_data.="<td>SAH</td>";
	$table_data.="</tr>";
	
	$table_data_export.="</tr>";
	$sql="";
	$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	while($sql_row=mysql_fetch_array($sql_result))
	{
		
		$style=$sql_row['style'];	$schedule=$sql_row['schedule'];	$color=$sql_row['color'];	$daten=$sql_row['daten'];	$output=$sql_row['output'];	$bundling=$sql_row['bundling'];	$bundleout=$sql_row['bundleout'];	$linein=$sql_row['linein'];	$rejected=$sql_row['rejected'];	$sah=$sql_row['sah'];	$cpk_qty=$sql_row['cpk_qty'];


		$table_data.="<tr>";
		$table_data.="<td>$daten</td>";
		$table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?style=$style','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, widtd=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$style</span></td>";
		$table_data.="<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, widtd=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$schedule</span></td>";
		$table_data.="<td>$color</td>";
		$table_data.="<td>$bundling</td>";
		$table_data.="<td>$bundleout</td>";
		$table_data.="<td>$linein</td>";
		$table_data.="<td>$output</td>";
		$table_data.="<td>$rejected</td>";
		$table_data.="<td>$cpk_qty</td>";
		$table_data.="<td>".$sah."</td>";
		$table_data.="</tr>";
		
		$style=$sql_row['style'];	$schedule=$sql_row['schedule'];	$color=$sql_row['color'];	$daten=$sql_row['daten'];	$output=$sql_row['output'];	$bundling=$sql_row['bundling'];	$bundleout=$sql_row['bundleout'];	$linein=$sql_row['linein'];	$rejected=$sql_row['rejected'];	$sah=$sql_row['sah'];	$cpk_qty=$sql_row['cpk_qty'];


		$table_data_export.="<tr>";
		$table_data_export.="<td>$daten</td>";
		$table_data_export.="<td>$style</td>";
		$table_data_export.="<td>$schedule</td>";
		$table_data_export.="<td>$color</td>";
		$table_data_export.="<td>$bundling</td>";
		$table_data_export.="<td>$bundleout</td>";
		$table_data_export.="<td>$linein</td>";
		$table_data_export.="<td>$output</td>";
		$table_data_export.="<td>$rejected</td>";
		$table_data_export.="<td>$cpk_qty</td>";
		$table_data_export.="<td>".$sah."</td>";
		$table_data_export.="</tr>";

	}

*/
?>
</body>
</html>
