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
	var ajax_url ="../mini_order_report/bundle_allocation_report.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

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
<div id="page_heading"><span style="float: left"><h3>Bundle Allocation Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php 
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0289",$username,1,$group_id_sfcs);
?>

<?php
include("dbconf.php");
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);



$dynamic=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50);
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

echo "Select Schedule: <select name=\"schedule\" >";

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
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";	
?>


</form>


<?php
if(isset($_POST['submit']))
{

	$style_code=$_POST['style'];
	$schedule=$_POST['schedule'];
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","group_concat(id)","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(bundle_number)","mini_order_ref",$miniord_ref,$link);
	$planned_module = echo_title("brandix_bts.tbl_miniorder_data","count(bundle_number)","planned_module<>'' and mini_order_ref",$miniord_ref,$link);
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	//getting schedule
	if($bundles>0)
	{
		if($planned_module>0)
		{
			$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
			$c_block = echo_title("bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule_result,$link);
			$carton_ref = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule,$link);
			//echo $carton_ref."<br>";
			//getting carton qty
			$sql_cart="SELECT parent_id,color,GROUP_CONCAT(ref_size_name ORDER BY ref_size_name SEPARATOR \"-\" ) AS sizes,GROUP_CONCAT(quantity ORDER BY ref_size_name SEPARATOR \"-\") as ratio FROM tbl_carton_size_ref WHERE parent_id IN ($carton_ref) GROUP BY color";
			//echo $sql_cart."<br>";
			$sql_result1=mysqli_query($link, $sql_cart) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($sql_result1))
			{
				$col_ratio[$row1['color']]=$row1['ratio'];
			}
			echo "<div id='excel_export'><right><strong><a href=\"export_excel.php?style=$style_code&schedule=$schedule&flag=bundle_alloc\">Export to Excel</a></strong></right></div>";
			
			$sql2="SELECT order_col_des AS color,COUNT(ref_size_name) AS cnt,GROUP_CONCAT(ref_size_name ORDER BY ref_size_name) AS size_code,GROUP_CONCAT(size_title ORDER BY ref_size_name) AS size_title FROM brandix_bts.tbl_orders_sizes_master WHERE parent_id in (".$schedule.") GROUP BY parent_id,order_col_des ORDER BY cnt DESC LIMIT 1";
			//echo $sql."<br>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($sql_result2))
			{	
				$size_tit=$row2['size_title'];
				$size_code=$row2['size_code'];
			}
			$sizes_tit=explode(",",$size_tit);
			$sizes_code=explode(",",$size_code);
			
			for($i=0;$i<sizeof($sizes_code);$i++)
			{		
				$query.= "sum(if(size = '".$sizes_code[$i]."',quantity,0)) as size$sizes_code[$i],";
			}
			$sql1="select distinct mini_order_num from brandix_bts.tbl_miniorder_data where mini_order_ref=".$miniord_ref." and planned_module!='' order by mini_order_num";
			//echo $sql1."<br>";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($sql_result1))
			{		
				$val1=sizeof($sizes_code);
				$query_n=substr($query,0,-1);
				$sql2="select planned_module,color,$query_n from brandix_bts.tbl_miniorder_data where mini_order_ref=".$miniord_ref." and mini_order_num='".$row1['mini_order_num']."' and planned_module<>'' group by planned_module,color";
				//echo $sql2."<br>";
				//exit;
				$sql_result=mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo "<div id='test'><table width=\"50%\" height=\"50\" border=\"1px\">";
				echo "<tr><th>Style :<b>".$stylecode."</b></th><th>Schedule :<b>".$schedule_result."</b>/<b>".$c_block."</b></th><th>Mini order :<b>".$row1['mini_order_num']."</b></th><th colspan=$val1>Sizes</th><th rowspan=2>Total</th></tr>";
				echo "<tr><th>Line No</b></th>";
				echo "<th>Color</th>";
				echo "<th>Carton ratio</th>";
				
				for($i=0;$i<sizeof($sizes_code);$i++)
				{		
					echo "<th><u>".$sizes_tit[$i]."</u></th>";
				}
				echo "</tr>";
				while($row2=mysqli_fetch_array($sql_result))
				{	
					$total=0;
					echo "<td>".$row2['planned_module']."</td>";
					echo "<td>".$row2['color']."</td>";
					echo "<td>".$col_ratio[$row2['color']]."</td>";
					for($j=0;$j<sizeof($sizes_code);$j++)
					{
						$val="size".$sizes_code[$j];
						echo "<td>".$row2[$val]."</td>";
						$total+=$row2['size'.$sizes_code[$j]];
					}
					//$total[]=$total;
					echo "<td>".$total."</td>";
					echo "<tr>";
						
				}
				$total1=0;
				$sql3="select planned_module,color,$query_n from brandix_bts.tbl_miniorder_data where mini_ordeR_ref=".$miniord_ref." and mini_order_num='".$row1['mini_order_num']."'";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row3=mysqli_fetch_array($sql_result3))
				{
					echo "<tr><td colspan=3>Total</td>";
					for($j=0;$j<sizeof($sizes_code);$j++)
					{
						$val="size".$sizes_code[$j];
						echo "<td>".$row3[$val]."</td>";
						$total1+=$row3[$val];
					}
					echo "<td>".$total1."</td>";
				
				}
				echo "</table></div>";
			}	
		}
		else
		{
			echo "<h3>Bundle Allocation pending.</h3>";
		}
		
	}
	else	
	{
		echo "<h3>Mini orders not yet generated.</h3>";
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