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
	window.location.href ="bundle_ticket_mrn.php?style="+document.mini_order_report.style.value
}

function secondbox()
{
	//alert('test');
	window.location.href ="bundle_ticket_mrn.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
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
<div id="page_heading"><span style="float: left"><h3>MRN Confirm Interface</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php 
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0288",$username,1,$group_id_sfcs);
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("dbconf.php"); 
$static=array(1,2,3,4,5,6,7);
$dynamic=array(8,9,10,11,12,13,14,15,16,17,18,19,20);
if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
   // $color=$_POST['color'];
	//$mini_order_ref=echo_title("brandix_bts.tbl_miniorder_data","id","ref_crt_schedule",$schedule,$link);
	//$mini_order_num=$_POST['mini_order_num']; 
	
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$mini_order_ref=echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
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
	$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	$sch_check="J".$schedule;
	$check_club = echo_title("bai_pro3.bai_orders_db_confirm","count(*)","order_joins",$sch_check,$link);
	if($check_club>0)
	{
		$table_name="bai_pro3.plandopc_stat_log";
		$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
		$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
		//$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);
		$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style=$style_code and ref_crt_schedule",$shcedule_code,$link);	
		$sql1="select * from tbl_cut_master where product_schedule='".$schedule."'";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql."<br>";
		$rowcount=1;$i=1;$doc_no=array();
		echo '<table border="1" border="1px">';
		echo "<tr><th>S.No</th><th>Cut - Docket</th><th>Mini Order Number</th><th>Color</th><th>Print</th></tr>";
		while($m=mysqli_fetch_array($sql_result1))
		{
			$sql11="select * from $table_name where org_doc_no='".$m['docket_number']."'";
			$sql_result11=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($sql_result11))
			{
				$doc_no[]=$row1['doc_no'];
			}
			$sql11="select * from tbl_cut_master where doc_num in (".implode(",",$doc_no).")";
			$sql_result11=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($sql_result11))
			{
				$schedule_temp[]=$row1['product_schedule'];
			}
			$sql="select mini_order_num,count(*) as bundles from tbl_miniorder_data where docket_number in (".implode(",",$doc_no).") ";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($sql_result))
			{
				$docket=$m['doc_num'];
				echo "<tr><td>".$rowcount."</td><td>".$m['cut_num']."-".$m['doc_num']."</td><td><b>".$row['mini_order_num']."</b></td><td><b>".$row['color']."</b>Total Bundles-".$row['bundles']."</td>";
				echo "<td>";
				$sql1x="select * from `m3_bulk_ops_rep_db`.`m3_sfcs_mrn_log` where sfcs_style='$style' and  minord_no=".$row['mini_order_num']." and sfcs_schedule in (".implode(",",$schedule_temp)."";
				$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				if(mysqli_num_rows($sql_result1x)==0)
				{
					echo "<a href='bundle_gen_mrn.php?mini_order_num=".$m['mini_order_num']."&doc_no=".$m['doc_num']."&ops=2'>Confirm</a>";
					
				}
				else
				{
					echo "Updated";
				}
				echo "</td></tr>";
				unset($doc_no);
				unset($schedule_temp);
			}	
		
			$rowcount++;
	
	}
	else
	{
		
		
		$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
		$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$shcedule_code,$link);
		//$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);
		$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style=$style_code and ref_crt_schedule",$shcedule_code,$link);
		
		
		$sql1="select mini_order_num,count(*) as bundles from tbl_miniorder_data where mini_order_ref=\"$miniord_ref\" and SUBSTRING_INDEX(mini_order_num,'.',-1)=0 group by mini_order_num";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql."<br>";
		$rowcount=1;
		echo '<table border="1" border="1px">';
		echo "<tr><th>S.No</th><th colspan=2>Mini Order Number</th><th>Print</th></tr>";
		while($m=mysqli_fetch_array($sql_result1))
		{
			
			$i=1;
			echo "<tr><td>".$rowcount."</td><td colspan=2><b>".$m['mini_order_num']."</b>-Total Bundles-".$m['bundles']."</td><td>";
			$sql1x="select * from `m3_bulk_ops_rep_db`.`m3_sfcs_mrn_log` where sfcs_style='$style' and  sfcs_schedule='$schedule' and minord_no=".$m['mini_order_num'];
		$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
			if(mysqli_num_rows($sql_result1x)==0)
			{
				echo "<a href='bundle_gen_mrn.php?mini_order_num=".$m['mini_order_num']."&mini_order_ref=".$miniord_ref."&ops=1'>Confirm</a>";
				
			}
			else
			{
				echo "Updated";
			}
			
			
			echo "</td></tr>";
			$mini_order_query_color="select color,count(*) as bundle from tbl_miniorder_data where mini_order_num=".$m['mini_order_num']." and mini_order_ref=".$miniord_ref." group by color";
			$sql_result=mysqli_query($link, $mini_order_query_color) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($mc=mysqli_fetch_array($sql_result))
			{
				echo "<tr><td></td><td>".$i."</td><td >".$mc['color']."-Total Bundles-".$mc['bundle']."</td><td>";
				//echo "<a href='..\..\packing\labels\mpdf50\\examples\bundle_tag_gen.php?mini_order_num=".$m['mini_order_num']."&mini_order_ref=".$miniord_ref."&color_code=".$mc['color']."&ops=2' target='_blank'>Print</a>";
				echo "</td></tr>";
				$i++;			
			}
			$i=0;
			$rowcount++;
		}
		echo "</table>";
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