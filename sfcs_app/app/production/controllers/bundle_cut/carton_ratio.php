
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
	var ajax_url ="../mini_order_report/carton_ratio.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function check_val()
{
	
	var style=document.getElementById("style").value;
	var schedule=document.getElementById("schedule").value;
		
	if(style=='NIL' || schedule=='NIL')
	{
		alert('Please select the values');
		document.getElementById('submit').style.display=''
		document.getElementById('msg').style.display='none';
		return false;
	}
		
}
function check_val1()
{
	//alert('Test');
	var carton_tot=document.getElementById("carton_tot").value;
	var barcode=document.getElementById("barcode").value;
	//var mini_order_qty=document.getElementById("mini_order_qty").value;
	var count=document.getElementById("total_cnt").value;
	//alert(count);
	var total_val=0;
	for(i=0;i<count;i++)
	{
		if(Number(document.getElementById("ratio["+i+"]").value)<=0)
		{
			return false;
		}
	}
	if(carton_tot>=0 && barcode>0)
	{
		//alert('Ok');
	}
	else
	{
		alert('Please Check the values.');
		document.getElementById('save').style.display=''
		document.getElementById('msg1').style.display='none';
		return false;
	}
	
	//return false;
	//return false;
}
function check_sum1()
{
	//alert('okaeypress');
	var count=document.getElementById("total_cnt").value;
	//alert(count);
	var total_val=0;
	for(i=0;i<count;i++)
	{
		total_val+=Number(document.getElementById("ratio["+i+"]").value);
		
	}
	//alert(total_val);
	document.getElementById('carton_tot').value=total_val;
	
	//return false;	
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
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Carton Ratio</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php  ?>

<?php
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0270",$username,1,$group_id_sfcs);


include("dbconf.php");

$country_block=array();
$sql="select trim(zfeature) as zfeature from bai_pro3.bai_orders_db_confirm where zfeature like \"%CB8%\" group by zfeature order by zfeature";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$country_block[]=$sql_row['zfeature'];
	//echo $sql_row['zfeature']."<br>";
}
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
	
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
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
	$sql="select * from brandix_bts.tbl_orders_style_ref order by product_style";	
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
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\" id=\"submit\"  onclick=\"document.getElementById('submit').style.display=''; document.getElementById('msg').style.display='none';\">";
	echo "<span id=\"msg\" style=\"display:none;\"><h4>Please Wait...<h4></span>";		
?>


</form>


<?php
if(isset($_POST['submit']))
{
	$style_code=$_POST['style'];
	$schedule=$_POST['schedule'];
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","max(id)","ref_crt_schedule='".$schedule."' and ref_product_style",$style_code,$link);
	//$miniord_ref_cur = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$schedule,$link);
	//$carton_qty = echo_title("brandix_bts.tbl_min_ord_ref","id","carton_quantity",$miniord_ref_cur,$link);
	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
	$check = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num='".$schedule."' and style_code",$style_code,$link);
	
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	//getting schedule
	$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	if($check>0)
	{
		$carton_qty = echo_title("brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$check,$link);
		$barcode_num = echo_title("brandix_bts.tbl_carton_ref","carton_barcode","ref_order_num='".$schedule."' and style_code",$style_code,$link);
	}
	else
	{
		//$sql="SELECT tcs.id,COUNT(tcs.id) AS cnt  FROM brandix_bts.tbl_carton_ref AS tc LEFT JOIN brandix_bts.tbl_carton_size_ref AS tcs ON tcs.parent_id=tc.id WHERE tc.style_code='".$style_code."' GROUP BY tc.ref_order_num HAVING cnt>0 limit 1";
		$sql="SELECT tcs.id,tcs.parent_id,COUNT(tcs.id) AS cnt  FROM brandix_bts.tbl_carton_ref AS tc LEFT JOIN brandix_bts.tbl_carton_size_ref AS tcs ON tcs.parent_id=tc.id WHERE tc.style_code='".$style_code."' GROUP BY tc.ref_order_num HAVING cnt>0 ORDER BY cnt DESC LIMIT 1 ";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($sql_result))
		{
			$carton_id=$row1['parent_id'];
			$barcode_num=echo_title("brandix_bts.tbl_carton_ref","carton_barcode","id",$carton_id,$link);
		}
	}
	//echo $carton_id."<br>";
	$sql="select * from brandix_bts.tbl_orders_sizes_master where parent_id='".$schedule."' order by order_col_des,ref_size_name";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=0;
	echo "<form name=\"input\" method=\"post\" action=\"carton_ratio.php\" onsubmit=\" return check_val1();\">";
		
	echo "<table border=\"1px\"><tr>	<th>Barcode:</th><th><input type=\"text\" value\"\" id=\"barcode\" name=\"barcode\" value=\"$barcode_num\"  onkeypress='return validateQty(event);'></th><th>Carton Total:</th><th><input type=\"text\" value=\"$carton_qty\" id=\"carton_tot\" readonly=\true\ name=\"carton_tot\" onmouseover=\"check_sum1();\">";
	if($bundles>0)
	{
		
	}
	else
	{
		echo "<input type=\"submit\" name=\"save\" value=\"Save\" id=\"save\" onclick=\"document.getElementById('save').style.display='';
		document.getElementById('msg1').style.display='none';\">";
		echo "<span id=\"msg1\" style=\"display:none;\"><h4>Please Wait...<h4></span>";
	}
	
	echo "</th></tr>";
	echo "<br>";
	echo "<tr><th>Sno</th><th>Color</th><th>Size</th><th>Ratio</th>";
	while($row=mysqli_fetch_array($sql_result))
	{
		if($check>0)
		{
			$carton=echo_title("brandix_bts.tbl_carton_size_ref","quantity","color='".$row['order_col_des']."' and ref_size_name='".$row['ref_size_name']."' and parent_id",$check,$link);
		}
		else
		{
			$ratio=echo_title("brandix_bts.tbl_carton_size_ref","quantity","color='".$row['order_col_des']."' and ref_size_name='".$row['ref_size_name']."' and parent_id",$carton_id,$link);
			if($ratio>0)
			{
				$carton=$ratio;
			}
			else
			{	
				$carton=0;
			}
		}
		echo "<tr><td>".($i+1)."</td>
		<td><input type=\"hidden\" name=\"color_code[".$i."]\" value='".$row['order_col_des']."'>".$row['order_col_des']."</td>
		<td><input type=\"hidden\" name=\"size[".$i."]\" value='".$row['ref_size_name']."'><input type=\"hidden\" name=\"size_tit[".$i."]\" value='".$row['size_title']."'>".$row['size_title']."</td>
		<td>
			
		<input type=\"text\" id=\"ratio[".$i."]\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" name=\"ratio[".$i."]\" value='".$carton."' onkeypress='return validateQty(event);'
		onkeyup='check_sum1();'></td>
		</tr>";
		
		$carton=0;
		$i++;
	}
	echo "<input type=\"hidden\" name=\"total_cnt\" id=\"total_cnt\" value=\"$i\">";
	echo "<input type=\"hidden\" name=\"style\" value=\"$style_code\">";
	echo "<input type=\"hidden\" name=\"schedule\" value=\"$schedule\">";
	echo "</table>";
	echo "</form>";
}
if(isset($_POST['save']))
{
	$style_id=$_POST['style'];
	$schedule_id=$_POST['schedule'];
	$barcode=trim($_POST['barcode']);
	$carton_tot=$_POST['carton_tot'];
	$color=$_POST['color_code'];
	$size=$_POST['size'];
	$size_tit=$_POST['size_tit'];
	$ratio=$_POST['ratio'];
	$total_ratio=array_sum($ratio);
	$style=echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$schedule=echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	$c_block=echo_title("bai_pro3.bai_orders_db_confirm","trim(zfeature)","order_del_no",$schedule,$link);
	$check=echo_title("brandix_bts.tbl_carton_ref","id","style_code=\"$style_id\" and ref_order_num",$schedule_id,$link);
	if($check>0)
	{
		$id=$check;
		$sql="update brandix_bts.tbl_carton_ref set carton_barcode='".$barcode."',carton_tot_quantity='".$carton_tot."' where id='".$id."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(!in_array($c_block,$country_block))
		{
			$sql6="INSERT ignore INTO bai3_finishing.barcode_update (style, schedule, barcode, username, c_block) VALUES ('$style', '$schedule', '$barcode', '$username', '$c_block')";
			$sql_result6=mysqli_query($link, $sql6) or exit("Sql Erro--6r".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
	}
	else
	{
		$sql1="insert ignore into brandix_bts.tbl_carton_ref (carton_barcode,carton_tot_quantity,ref_order_num,style_code) values('".$barcode."','".$carton_tot."','".$schedule_id."','".$style_id."')";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		if(!in_array($c_block,$country_block))
		{
			$sql7="INSERT ignore INTO bai3_finishing.barcode_update (style, schedule, barcode, username, c_block) VALUES ('$style', '$schedule', '$barcode', '$username', '$c_block')";
			$sql_result7=mysqli_query($link, $sql7) or exit("Sql Error--7".mysqli_error($GLOBALS["___mysqli_ston"]));
		}	
	}
	//echo sizeof($color);
	for($i=0;$i<sizeof($color);$i++)
	{	
		if($ratio[$i]>0)
		{
			$check_c=echo_title("brandix_bts.tbl_carton_size_ref","id","parent_id=\"$id\" and color=\"$color[$i]\" and ref_size_name",$size[$i],$link);
			if($check_c>0)
			{
				$sql2="update brandix_bts.tbl_carton_size_ref set quantity='".$ratio[$i]."' where id='".$check_c."'";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $sql2."<br>";
				if(!in_array($c_block,$country_block))
				{
					$check_val=echo_title("bai3_finishing.input_update","tid","schedule='".$schedule."' and color='".$color[$i]."' and size",$size_tit[$i],$link);
					if($check_val>0)
					{
						$sql3="update bai3_finishing.input_update set ims_qty='".$ratio[$i]."',barcode='".$barcode."' where schedule='".$schedule."' and color='".$color[$i]."' and size='".$size_tit[$i]."'";
						//echo $sql3."<br>";
						$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error--3".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}	
			}
			else
			{
				$sql4="insert ignore into brandix_bts.tbl_carton_size_ref (parent_id,color,ref_size_name,quantity) values('".$id."','".$color[$i]."','".$size[$i]."','".$ratio[$i]."')";
				//echo $sql4."<br>";
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error--4".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(!in_array($c_block,$country_block))
				{
					$sql5="INSERT ignore INTO `bai3_finishing`.`input_update` (`style`, `schedule`, `size`, `color`, `ims_qty`, `barcode`, `username`, `c_block`) VALUES ('".$style."', '$schedule', '".$size_tit[$i]."', '".$color[$i]."', '$ratio[$i]', '$barcode', '$username', '$c_block')";
					//echo $sql5."<br>";
					$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error--5".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}
	}
	
	echo "<h2>Data Saved Successfully.</h2>";
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