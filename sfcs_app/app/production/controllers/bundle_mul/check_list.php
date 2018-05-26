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
	//alert("test");
	window.location.href ="../mini_order_report/check_list.php?style_id="+document.mini_order_report.style_id.value
}

function secondbox()
{
	//alert('test');
	window.location.href ="../mini_order_report/check_list.php?style_id="+document.mini_order_report.style_id.value+"&sch_id="+document.mini_order_report.sch_id.value
}

function thirdbox()
{
	//alert('test');
	window.location.href ="../mini_order_report/check_list.php?style_id="+document.mini_order_report.style_id.value+"&sch_id="+document.mini_order_report.sch_id.value+"&min_id="+document.mini_order_report.mini_order_num.value
}

function check_val1()
{
	//alert('Test');
	var tot_cnt=document.getElementById("tot_cnt").value;
	var tot_bund=document.getElementById("bundle_tot").value;
	var total=0;
	//alert(tot_cnt);
	//alert(tot_bund);
	for(var i=1;i<tot_cnt;i++)
	{
		var total=parseInt(document.getElementById("total["+i+"]").value)+parseInt(total);
	}
	if(total==tot_bund)
	{
		//alert('Ok');
	}
	else
	{
		alert('Allocation Pending/Exceed for some Colors.');
		return false;
	}
	
	
	//return false;
}
function check_val()
{
	//alert('dfsds');
	var style=document.getElementById("style").value;
	var schedule=document.getElementById("schedule").value;
	var mini_order=document.getElementById("mini_order_num").value;
	
	if(style == 'NIL' || schedule == 'NIL' || mini_order == 'NIL')
	{
		alert('Please select the values');
		return false;
	}	
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

function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;
	//alert(key);
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 45) {
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

function myFunction() {
//alert("Test");
    window.print();
}

</script>

<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Check List</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php 
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0265",$username,1,$group_id_sfcs);
?>

<?php
include("dbconf.php");
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


if(isset($_POST['style_id']))
{
    $style=$_POST['style_id'];
    $schedule=$_POST['sch_id'];
    $mini_order_ref=echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	
}
if($_GET['style_id']<>'')
{
	$style=$_GET['style_id'];
	if($_GET['sch_id']<>'')
	{
		$schedule=$_GET['sch_id'];
		$mini_order_ref=echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	}
}

?>

<form name="mini_order_report" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit=" return check_val();">
<br>
<?php
echo "<table><tr><td>";
echo "Select Style:</td><td> <select id=\"style_id\" name=\"style_id\" onchange=\"firstbox();\" >";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from brandix_bts.tbl_orders_style_ref";	
//}
mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
echo "</td><td>";
?>
<?php

echo "Select Schedule: </td><td><select id=\"sch_id\" name=\"sch_id\" onchange=\"secondbox();\">";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select id,product_schedule as schedule from brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule order by product_schedule";	
	//$sql="select product_schedule as schedule,id from tbl_orders_master where ref_product_style=$style group by schedule";
//}
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
echo "</td><td>";
echo "<td>";
?>
 <?php
	echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";	
	echo "</td></table>";
?>



</form>


<?php
if(isset($_POST['submit']))
{

	$style_code=$_POST['style_id'];
	$mini_order_ref=$_POST['mini_order_ref'];
	
	$schedule_code=$_POST['sch_id'];
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule_code,$link);
	$order_div_result = echo_title("bai_pro3.bai_orders_db_confirm","order_div","order_del_no",$schedule_code,$link);
	$orders_total_result = echo_title("brandix_bts.tbl_orders_sizes_master","sum(order_quantity)","parent_id",$schedule_code,$link);
	//$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style='".$style_code."' and ref_crt_schedule",$schedule_code,$link);
	//$miniordr = echo_title("brandix_bts.tbl_miniorder_data","count(distinct mini_order_num)","mini_order_ref",$miniord_ref,$link);
		$sql="SELECT mini_order_num from brandix_bts.tbl_miniorder_data where mini_order_ref=$mini_order_ref group by mini_order_num order by mini_order_num*1";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result))
		{
			echo "<table border=1>";
			echo "<tr><th >Mini order Num</th><th style='float:left;'>Control</th></tr>";
			
			$sno=1;
			$total_quantity=0;
			
			while($m=mysqli_fetch_array($sql_result))
			{
				
				echo "<tr><td >".$m['mini_order_num']."</td>";
				echo "<td ><a href=\"check_list_v5.php?min_ref=".$mini_order_ref."&min_num=".$m['mini_order_num']."&sch=".$schedule_result."&style=".$stylecode."\" target=\"_blank\"\">Click Here</a></tr>";
			}
			echo "</table>";
		}
		else
		{
			echo "<h3>Mini orders are not yet generated</h3>";
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