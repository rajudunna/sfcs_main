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
	var ajax_url ="../mini_order_report/cut_docket_allocation.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	var ajax_url ="../mini_order_report/cut_docket_allocation.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
	Ajaxify(ajax_url);

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
<div id="page_heading"><span style="float: left"><h3>Cut Docket Allocation</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0266",$username,1,$group_id_sfcs);
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
    $color=$_POST['color'];
	//$mini_order_ref=echo_title("brandix_bts.tbl_miniorder_data","id","ref_crt_schedule",$schedule,$link);
	//$mini_order_num=$_POST['mini_order_num']; 
	
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$mini_order_ref=echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	//$mini_order_num=$_GET['mini_order_num'];
	$color=$_GET['color']; 
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

?>
<?php

echo "Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\">";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select id,product_schedule as schedule from brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";	
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

?>
<?php

echo "Select Color: <select name=\"color\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct color from brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'";	
//}
mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['color'])==str_replace(" ","",$color))
	{
		echo "<option value=\"".$sql_row['color']."\" selected>".$sql_row['color']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['color']."\">".$sql_row['color']."</option>";
	}

}

echo "</select>";

?>

 <?php
	echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";	
?>


</form>


<?php
if(isset($_POST['submit']))
{

	
	$style_code=$_POST['style'];
	//$color=$_POST['color'];
	$shcedule_code=$_POST['schedule'];
	$color=$_POST['color'];
	
	$sno=1;
	$cumm_qnty=0;
	$yards=0;
	$total_yards=0;
	//$schedule=$_POST['schedule'];
	$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$shcedule_code,$link);
	//$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);
	//$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style=$style_code and ref_crt_schedule",$shcedule_code,$link);
//	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
	$order_tid=$style.$schedule.$color;
	echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><b>Style Code : ".$style."</b>Schedule : <b>".$schedule."</b></div>";
	echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><table border=1px><tr><th rowspan=2>Sno</th><th rowspan=2>Color</th><th rowspan=2>Mini order No</th><th rowspan=2>Cut No</th><th rowspan=2>Docket No</th><th>Ratio</th><th rowspan=2>Plies</th><th rowspan=2>Quantity</th><th rowspan=2>Cumulative Qty</th><th rowspan=2>Yards</th></tr>";
	
	
	$sql33="select * from bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$color_code=$sql_row33['color_code']; //Color Code
	}
	$sql="select GROUP_CONCAT(ref_size_name ORDER BY ref_size_name SEPARATOR \"-\" ) as size_code,GROUP_CONCAT(size_title ORDER BY ref_size_name SEPARATOR \"-\" ) as size_title from tbl_orders_sizes_master where order_col_des='".$color."' and parent_id='".$shcedule_code."'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$size_title=$row['size_title'];
	}
	echo "<tr><th>".$size_title."</th></tr>";
	echo "<br>";
	echo "<br>";
	$lay_plan_query="SELECT tbl_cut_master.id,style_id,product_schedule,color,doc_num,actual_plies,tbl_cut_master.cut_num,
		GROUP_CONCAT(tbl_cut_size_master.quantity ORDER BY tbl_cut_size_master.ref_size_name ASC SEPARATOR '-' ) AS ratio,
		SUM(tbl_cut_size_master.quantity) AS quantity,SUM(tbl_cut_size_master.quantity)*actual_plies AS total_quantity,tbl_cut_master.cat_ref,tbl_cut_master.cuttable_ref,tbl_cut_master.mk_ref
		FROM tbl_cut_master 
		LEFT JOIN tbl_cut_size_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id
		WHERE style_id=$style_code AND product_schedule='$schedule' and tbl_cut_size_master.color='".$color."'
		GROUP BY tbl_cut_master.id";
		//echo $lay_plan_query."</br>";
	$sql_result33=mysqli_query($link, $lay_plan_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($cr=mysqli_fetch_array($sql_result33))
	{	
		$cut_code=chr($color_code).leading_zeros($cr['cut_num'],3);
		$cumm_qnty+=$cr['total_quantity'];
		$docket_number=$cr['doc_num'];
		$mini_orders=echo_title("tbl_miniorder_data","group_concat(distinct mini_order_num order by mini_order_num)","docket_number",$docket_number,$link);
		$doc=substr($docket_number,1);
		$doc_type=substr($docket_number,0,1);
		if($doc_type=='R')
		{
			$yards=echo_title("bai_pro3.order_cat_recut_doc_mk_mix","round(material_req,2)","doc_no",$doc,$link);
			//$var=$doc_type;
		}
		else
		{
			//$var=$doc_type;
			$yards=echo_title("bai_pro3.order_cat_doc_mk_mix","round(material_req,2)","doc_no",$docket_number,$link);
			
		}
		
		
		echo "<tr><td>".$sno."</td><td>".$cr['color']."</td><td>".$mini_orders."</td><td>".$cut_code."</td><td>".$cr['doc_num']."</td><td>".$cr['ratio']."</td><td>".$cr['actual_plies']."</td><td>".$cr['total_quantity']."</td><td>".$cumm_qnty."</td><td>".$yards."</td></tr>";
		$sno++;
	}		
	
	echo "</table></div>";
	
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