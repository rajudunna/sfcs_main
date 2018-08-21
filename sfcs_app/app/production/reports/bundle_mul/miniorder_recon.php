<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
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
	var ajax_url ="miniorder_recon.php?style="+document.mini_order_report.style.value;
	Ajaxify(ajax_url,'report_body'); 
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
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('txtPhn');
//comparing pressed keycodes
if ((keycode < 48 || keycode > 57) && (keycode<46 || keycode>47))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Mini Order Report-Reconciliation report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
 ?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$static=array(1,2,3,4,5,6,7);
$dynamic=array(8,9,10,11,12,13,14,15,16,17,18,19,20);
if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
	//$mini_order_num=$_POST['mini_order_num']; 
	//$color=$_POST['color'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	//$mini_order_num=$_GET['mini_order_num'];
	//$color=$_GET['color']; 
}

//echo $style.$schedule.$color;
?>

<form name="mini_order_report" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit=" return check_val();">
<br>
<?php

echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";	
//}
mysqli_query($link2, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
	}

}

echo "</select>";

?>
<?php

echo "Select Schedule: <select name=\"schedule\" >";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";	
	//$sql="select product_schedule as schedule,id from tbl_orders_master where ref_product_style=$style group by schedule";
//}
//echo $sql;
mysqli_query($link2, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
/*
if(str_replace(" ","",0)==str_replace(" ","",$c_block))
{
echo "<option value=\"0\" selected>All Country blocks</option>";
}
else
{
	echo "<option value=\"0\">All Country block</option>";
}*/
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
}

}


echo "</select>";

?>
 <?php
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";	
?>


</form>


<?php
if(isset($_POST['submit']))
{

	
	$style_code=$_POST['style'];
	$schedule=$_POST['schedule'];
	$stylecode = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule_result = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	$miniord_ref = echo_title("$brandix_bts.tbl_min_ord_ref","id","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	$miniordr = echo_title("$brandix_bts.tbl_miniorder_data","count(distinct mini_order_num)","mini_order_ref",$miniord_ref,$link);
	$bundles = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
	echo "<table border=1px><tr><th>Style</th><th>Schedule</th><th>Miniorder</th><th>Total Bundles</th><th>Scanned bundles</th><th>Pending Bundles</th><th>Status</th></tr>";
	$sql="select mini_order_num,count(bundle_number) as bundles from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$miniord_ref."' GROUP BY mini_order_num order by mini_order_num";
	//echo $sql."<br>";	
	$sql_result=mysqli_query($link2, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$status='';
	$scan_bundle=array();$scan_total=0;
	
	//echo "<tr><td rowspan=$miniordr>".$stylecode."</td><td rowspan=$miniordr>".$schedule_result."</td>";
	while($row=mysqli_fetch_array($sql_result))
	{
		$status='';
		//$stylecode = echo_title("$brandix_bts.bundle_transactions_20_repeat","count(distinct bundle_id)","bundle_id in ",$row['mini_order_num'],$link);
		$mini_num=$row['mini_order_num'];
		$sql1="select bundle_number from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$miniord_ref."' and mini_order_num='".$mini_num."'";
		$sql_result1=mysqli_query($link2, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result1)>0)
		{
			while($row1=mysqli_fetch_array($sql_result1))
			{
				$scan_bundle[]=$row1['bundle_number']; 
			}
		} 
		else
		{
			$scan_bundle[]=0;
		}
		$sql21="SELECT COUNT(*) FROM $brandix_bts.bundle_transactions_20_repeat WHERE bundle_id IN ('".implode("','",$scan_bundle)."') GROUP BY bundle_id HAVING COUNT(*)=4";
		$sql_result21=mysqli_query($link2, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$scan_total_1=mysqli_num_rows($sql_result21); 
		
		$val=0;
		$val=$row['bundles'];
		//echo $scan_total."==".$val."<br>";
		if($scan_total_1==$val)
		{
			$status="Complete";
		}
		else
		{
			$status="Pending";
		}
		$diff=$row['bundles']-$scan_total_1;
		echo "<td>".$stylecode."</td><td>".$schedule_result."</td><td>".$row['mini_order_num']."</td><td>".$row['bundles']."</td><td>".$scan_total_1."</td><td>".$diff."</td>";
		echo "<td><span style=\"cursor: pointer; cursor: hand; color:blue;\" onclick=\"Popup=window.open('popup.php?schedule=$schedule_result&mini_num=$mini_num','Popup2','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$status</span></td></tr>";
		unset($scan_bundle);
		$scan_total=0;		
	}
echo "</table>";
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