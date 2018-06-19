<?php
	$global_path = getFullURLLevel($_GET['r'],'',4,'R');
	// echo $global_path;

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',2,'R'); ?>">

<script language="javascript" type="text/javascript">
function firstbox()
{
	var url1 = '<?= getFullUrl($_GET['r'],'carton_ratio.php','N'); ?>';
	window.location.href =url1+"&style="+document.mini_order_report.style.value;
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
	var carton_tot=document.getElementById("carton_tot").value;
	var barcode=document.getElementById("barcode").value;
	var count=document.getElementById("total_cnt").value;
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
		
	}
	else
	{
		alert('Please Check the values.');
		document.getElementById('save').style.display=''
		document.getElementById('msg1').style.display='none';
		return false;
	}
	
}
function check_sum1()
{
	var count=document.getElementById("total_cnt").value;
	var total_val=0;
	for(i=0;i<count;i++)
	{
		total_val+=Number(document.getElementById("ratio["+i+"]").value);
		
	}
	document.getElementById('carton_tot').value=total_val;
}

function validateQty(event) 
{
    var key = window.event ? event.keyCode : event.which;
	if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 45) 
	{
		return true;
	}
	else if ( key < 48 || key > 57 ) 
	{
		return false;
	}
	else 
	{
		return true;
	}
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Carton Ratio</div>

<?php
// echo getFullURLLevel($_GET['r'],'dbconf.php',0,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0270",$username,1,$group_id_sfcs);

// getFullURLLevel($_GET['r'],'dbconf.php',0,'R');

//KK 20171226 - To avoid missing of zfeature
$sql="UPDATE bai_pro3.bai_orders_db_confirm 
SET bai_pro3.bai_orders_db_confirm.zfeature= (SELECT zfeature FROM bai_pro3.bai_orders_db WHERE bai_pro3.bai_orders_db_confirm.order_tid=bai_pro3.bai_orders_db.order_tid)
WHERE zfeature IS NULL OR zfeature='' OR LENGTH(zfeature)=0";
mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));


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
// error_reporting(0);

// // Report simple running errors
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

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

// echo $style.$schedule.$color.'Hell';
?>
<div class="panel-body">
<form name="mini_order_report" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class="form-group col-lg-2">
<label>Select Style:</label>
<?php

echo " <select name=\"style\" id=\"style\" onchange=\"firstbox();\"  class='form-control'>";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from brandix_bts.tbl_orders_style_ref order by product_style";	
//}
// echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
</div>
<div class="col-lg-2 form-group">
<label>Select Schedule:</label>

<?php

echo "<select name=\"schedule\" id=\"schedule\"  class='form-control'>";

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
</div>
<br>
<div class="col-lg-2" >
	<label></label>
 <?php
	echo "<input class='btn btn-sm btn-primary' type=\"submit\" value=\"submit\" name=\"submit\" id=\"submit\"  onclick=\"document.getElementById('submit').style.display=''; document.getElementById('msg').style.display='none';\">";
	echo "<span id=\"msg\" style=\"display:none;\"><h4>Please Wait...<h4></span>";		
?>
</div>


</form>



<?php
if(isset($_POST['submit']))
{
	// echo $_POST['style'];
	$style_code=$_POST['style'];
	$schedule=$_POST['schedule'];
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","max(id)","ref_crt_schedule='".$schedule."' and ref_product_style",$style_code,$link);
	// var_dump($link);
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
	echo "<form name=\"input\" method=\"post\" action=?r=".$_GET['r']." onsubmit=\" return check_val1();\">";
		
	echo "<table class=\"table table-bordered table-responsive\"><tr>	<th>Barcode:</th><th><input style=\"color: black\" type=\"text\" id=\"barcode\" name=\"barcode\" value=\"$barcode_num\"  onkeypress='return validateQty(event);'></th><th>Carton Total:</th><th><input style=\"color: black\" type=\"text\" value=\"$carton_qty\" id=\"carton_tot\" readonly=\"true\" name=\"carton_tot\" onmouseover=\"check_sum1();\"> ";
	if($bundles>0)
	{
		
	}
	else
	{
		echo "<input class=\"btn btn-sm btn-warning\" type=\"submit\" name=\"save\" value=\"Save\" id=\"save\" onclick=\"document.getElementById('save').style.display='';
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
			
		<input type=\"text\" class=\"form-control\" id=\"ratio[".$i."]\" onfocus=\"if(this.value==0){this.value=''}\" onblur=\"javascript: if(this.value==''){this.value=0;}\" name=\"ratio[".$i."]\" value='".$carton."' onkeypress='return validateQty(event);'
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
	echo "<script>swal('success', 'Data Saved Successfully');</script>";
	// echo "<h2>Data Saved Successfully.</h2>";
} 
?>
</div>
</div>
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