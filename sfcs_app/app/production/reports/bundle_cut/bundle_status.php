<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="../../../common/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../common/js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="../../../common/js/style.css">
<link rel="stylesheet" type="text/css" href="../../../common/table.css">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	window.location.href ="../mini_order_report/mini_order_report.php?style="+document.mini_order_report.style.value
}

function secondbox()
{
	//alert('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function check_val()
{
	//alert('dfsds');
	var style=document.bundle_operation.style.value;
	var c_block=document.bundle_operation.c_block.value;
	var schedule=document.bundle_operation.schedule.value;
	var barcode=document.bundle_operation.barcode.value;
	//alert(style);
	//alert(c_block);
	//alert(schedule);
		if(style==0 || c_block=='NIL' || schedule=='NIL' || barcode=='NIL')
		{
			alert('Please select the values');
			return false;
		}
		
}

function check_val_2()
{
	//alert('dfsds');
	
	var count=document.barcode_mapping_2.count_qty.value;
	//alert(count);
	//alert('qty');
	var check_exist=0;
	for(i=0;i<5;i++)
	{
		var qty=document.getElementById("qty["+i+"]").value;
		if(qty!=0)
	    {
			var check_exist=1;
		}
	}
	if(check_exist==0)
	{
		alert('Please fill the values');
		return false;
	}
	//return false;	
}
function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;
	//alert(key);
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 ) {
    return true;
}
else if ( key < 48 || key > 57 ) {
    return false;
}
else 
{
return true;

}
};
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Bundle Status Form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>


<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");

?>

<form action="bundle_status.php" method="post">
<table class="mytable1" border=0 cellpadding=0 cellspacing=0>
<tr>
	
<th>Bundle Barcode:</th><td> <input type="text" value="" name="bundle_id" id="bundle_id" onkeypress="return validateQty(event);">
</td>
<td><span id="msg" style="display:none;">Please Wait...</span>
	<input type="submit" name="submit" value="Submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"></td>
</table>

</form>


<?php
if(isset($_POST['submit']))
{
	$barcode=$_POST['bundle_id'];
	$sql="select * from $brandix_bts.view_set_1 where bundle_transactions_20_repeat_bundle_id='".$barcode."' group by bundle_transactions_20_repeat_bundle_barcode order by bundle_transactions_20_repeat_id*1";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rows=mysqli_num_rows($sql_result);
	if(mysqli_num_rows($sql_result)>0)
	{
		
		
		$docket=echo_title("tbl_miniorder_data","docket_number","bundle_number",$barcode,$link);
		$schedule=echo_title("tbl_cut_master","product_schedule","doc_num",$docket,$link);
		$emb_status=echo_title("tbl_orders_master","emb_status","product_schedule",$schedule,$link);
		if($emb_status==1)
		{
			$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id <= 7 order by ops_order*1";
		}
		else if($emb_status==0)
		{
			$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id in (1,2,3,4) order by ops_order*1";
		}
		else if($emb_status==2)
		{
			$sql1="select * from $brandix_bts.tbl_orders_ops_ref where default_operation='YES' and id not in (6,7) order by ops_order*1";
		}	
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($sql_result1))
		{
			$operation_id[]=$row1['id'];
			$operation_code[]=$row1['operation_code'];
			$operation_name[]=$row1['operation_name'];
		}
		echo "<table border=1px>
		<tr><th colspan=".sizeof($operation_id).">Bundle Number : $barcode</th></tr>";
		echo "<tr>";
		for($i=0;$i<sizeof($operation_id);$i++)
		{
			echo "<th>".$operation_name[$i]."</th>";
		}
		echo "</tr><tr>";
		$i=0;
		for($i=0;$i<sizeof($operation_id);$i++)
		{
			$sql="select * from $brandix_bts.view_set_1 where bundle_transactions_20_repeat_bundle_id='".$barcode."' and bundle_transactions_20_repeat_operation_id='".$operation_id[$i]."' limit 1";
			$sql_result1=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $operation_id[$i]."--".mysql_num_rows($sql_result1)."<br>";
			if(mysqli_num_rows($sql_result1)>0)
			{
				while($row=mysqli_fetch_array($sql_result1))
				{
					if($row["bundle_transactions_20_repeat_operation_id"]==4)
					{
						echo "<td>Time :<b>".$row["bundle_transactions_date_time"]."</b></br>Module :<b>".$row["bundle_transactions_20_repeat_act_module"]."</b> Employee :<b>".$row["bundle_transactions_employee_id"]."</b></br>Quantity :<b>".$row["bundle_transactions_20_repeat_quantity"]."</b> Rejection :<b>".$row["bundle_transactions_20_repeat_rejection_quantity"]."</b> Shift :<b>".$row["tbl_shifts_master_shift_name"]."</b></td>";
					}
					else
					{
						echo "<td>Time :<b>".$row["bundle_transactions_date_time"]."</b></br>Module :<b>".$row["bundle_transactions_module_id"]."</b> Employee :<b>".$row["bundle_transactions_employee_id"]."</b></br>Quantity :<b>".$row["bundle_transactions_20_repeat_quantity"]."</b> Rejection :<b>".$row["bundle_transactions_20_repeat_rejection_quantity"]."</b> Shift :<b>".$row["tbl_shifts_master_shift_name"]."</b></td>";
					}
					//$i++;
				}
			}
			else
			{
				echo "<td>Not Done</td>";
			}
		}
		
		echo "</tr>";	
		echo "</table>";	
	}
	else
	{
		echo "<h2>Scanning not yet started.</h2>";
	}
}
?> 
<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>