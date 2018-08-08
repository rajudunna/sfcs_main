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
	var ajax_url ="mini_order_report.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

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
<div id="page_heading"><span style="float: left"><h3>Input Job Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php 
	// include("dbconf.php");
	include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/production/common/config/dbconf.php"); 

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
	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$miniord_ref,$link);
	//echo $bundles."<br>";
if($miniord_ref=='' || $bundles==0)
{
	if($miniord_ref=='')
	{
		echo "<h2>Input Job not yet generated.</h2>";
	}
	else
	{
		echo "<h2>Cut Allocation not completed to Input Jobs.</h2>";
	}
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	//getting schedule
	$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	//echo "<div id='excel_export'><right><strong><a href=\"mini_order_report/export_excel.php?style=$style_code&schedule=$schedule&flag=mini_orders\">Export to Excel</a></strong></right></div>";
	$sql121="select zfeature from bai_pro3.bai_orders_db where order_del_no=".$schedule_result." ";
	$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($sql_result121))
	{
		$c_block=$row121['zfeature'];
	}

		
	//getting carton qty
	$qry_cartonqty_result = echo_title("brandix_bts.tbl_carton_ref","carton_tot_quantity","ref_order_num=".$schedule." and style_code",$style_code,$link);
	//echo $qry_cartonsizes."</br>";
	$sql="select group_concat(distinct(ref_size_name) order by ref_size_name) as size_id,group_concat(distinct(size_title) order by ref_size_name) as size_name from brandix_bts.tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) ORDER BY `ref_size_name` ASC";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$max_size=$row['size_id'];
		$size_title=$row['size_name'];
	}
	$sizesarray=explode(",",$max_size);
	$sizesnames_array=explode(",",$size_title);
	$val= sizeof($sizesarray)+2;
	$val1=round($val/2);
	$val2=$val-$val1;
				//echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin-left: 1.5%;margin-right: 0.5%;margin-bottom:3%; padding: 5px;">';
				
				echo "<div id='test'><table width=\"60%\" height=\"75\" border=\"1px\">";
				echo "<tr><th colspan=".$val." ><center><b>Orders</b></center></th></tr>";
				echo "<tr><th colspan=".$val1.">Style :<b>".$stylecode."</b></th><th colspan=".$val2.">Schedule :<b>".$schedule_result."</b><br></b>Country Block :<b>".$c_block."</b></th></tr>";
				echo "<tr><th>Color</th>";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{		
					if($sizesnames_array[$i] !='')
					{	
						echo "<th><u>".$sizesnames_array[$i]."</u></th>";
					}
					else
					{	
						$get_siz_nam=echo_title("brandix_bts.tbl_orders_size_ref","size_name","id",$sizesarray[$i],$link);
						echo "<th><u>".$get_siz_nam."</u></th>";
					}
				}
				echo "<th>Total</th></tr>";
				$sql = "SELECT md.order_col_des as color,sum(md.order_quantity) as Qnty,";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{
					$temp_array[]=" sum(if(ref_size_name='".$sizesarray[$i]."',md.order_quantity,0)) as size".$sizesarray[$i]."_qty ";
				
				}
				$sql.=implode(",",$temp_array);
				$sql.=" FROM `tbl_orders_sizes_master` md where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result)";
				$sql1=$sql." group by color order by color ASC";
				//echo $sql1."</br>";
				$sql_result12=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result12))
				{
					echo "<tr>";
					echo "<td>".$row2['color']."</td>";
					$cnt=0;
					for($j=0;$j<sizeof($sizesarray);$j++)
					{
						if($sizesnames_array[$j]!='')
						{
							$qry_vallidate_size2="select id,ref_size_name from tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) and order_col_des='".$row2['color']."' and size_title='".$sizesnames_array[$j]."'";
							$sql_result22=mysqli_query($link, $qry_vallidate_size2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $qry_vallidate_size2."<br>";
							while($row22=mysqli_fetch_array($sql_result22))
							{
								$cnt=$row22['id'];
								$size_id_n=$row22['ref_size_name'];
							}
							
							if((0<$cnt) || ($cnt!=''))
							{		
								echo "<td>".$row2['size'.$size_id_n.'_qty']."</td>";
							}
							else
							{
								echo "<td>0</td>";
							}
							//$minisizes_sum[$i]+=$r['size'.$size_id_n.'_qty'];
						}
						else
						{
							echo "<td>".$row2['size'.$sizesarray[$j].'_qty']."</td>";
							//$minisizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
						}
					$cnt=0;	
					}
					echo "<td>".$row2['Qnty']."</td>";
					echo "<tr>";
					
				}	
						
				
				echo "</table></div>";
}
else
{	
	$val= sizeof($sizesarray)+2;
	$stylecode = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	//getting schedule
	$schedule_result = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	echo "<div id='excel_export'><right><strong><a href=\"export_excel.php?style=$style_code&schedule=$schedule&flag=mini_orders\">Export to Excel</a></strong></right></div>";
	$sql121="select zfeature from bai_pro3.bai_orders_db where order_del_no=".$schedule_result." ";
	$sql_result121=mysqli_query($link, $sql121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($sql_result121))
	{
		$c_block=$row121['zfeature'];
	}

	//$c_block="TEST";
	//getting carton qty
	$qry_cartonqty_result = echo_title("brandix_bts.tbl_carton_ref","carton_tot_quantity","ref_order_num=".$schedule." and style_code",$style_code,$link);
	//echo $qry_cartonsizes."</br>";
	$sql="select group_concat(distinct(ref_size_name) order by ref_size_name) as size_id,group_concat(distinct(size_title) order by ref_size_name) as size_name from brandix_bts.tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) ORDER BY `ref_size_name` ASC";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result))
	{
		$max_size=$row['size_id'];
		$size_title=$row['size_name'];
	}
	$sizesarray=explode(",",$max_size);
	$sizesnames_array=explode(",",$size_title);
	$val= sizeof($sizesarray)+2;
	$val1=round($val/2);
	$val2=$val-$val1;
				//echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin-left: 1.5%;margin-right: 0.5%;margin-bottom:3%; padding: 5px;">';
				
				echo "<div id='test'><table width=\"80%\" height=\"75\" border=\"1px\">";
				echo "<tr><th colspan=".$val." ><center><b>Orders</b></center></th></tr>";
				echo "<tr><th colspan=".$val1.">Style :<b>".$stylecode."</b></th><th colspan=".$val2.">Schedule :<b>".$schedule_result."<br></b>Country Block :<b>".$c_block."</b></th></tr>";
				echo "<tr><th>Color</th>";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{		
					if($sizesnames_array[$i] !='')
					{	
						echo "<th><u>".$sizesnames_array[$i]."</u></th>";
					}
					else
					{	
						$get_siz_nam=echo_title("brandix_bts.tbl_orders_size_ref","size_name","id",$sizesarray[$i],$link);
						echo "<th><u>".$get_siz_nam."</u></th>";
					}
				}
				echo "<th>Total</th></tr>";
				$sql = "SELECT md.order_col_des as color,sum(md.order_quantity) as Qnty,";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{
					$temp_array[]=" sum(if(ref_size_name='".$sizesarray[$i]."',md.order_quantity,0)) as size".$sizesarray[$i]."_qty ";
				
				}
				$sql.=implode(",",$temp_array);
				$sql.=" FROM `tbl_orders_sizes_master` md where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result)";
				$sql1=$sql." group by color order by color ASC";
				//echo $sql1."</br>";
				$sql_result12=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($sql_result12))
				{
					echo "<tr>";
					echo "<td>".$row2['color']."</td>";
					$cnt=0;
					for($j=0;$j<sizeof($sizesarray);$j++)
					{
						if($sizesnames_array[$j]!='')
						{
							$qry_vallidate_size2="select id,ref_size_name from tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) and order_col_des='".$row2['color']."' and size_title='".$sizesnames_array[$j]."'";
							$sql_result22=mysqli_query($link, $qry_vallidate_size2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $qry_vallidate_size2."<br>";
							while($row22=mysqli_fetch_array($sql_result22))
							{
								$cnt=$row22['id'];
								$size_id_n=$row22['ref_size_name'];
							}
							
							if((0<$cnt) || ($cnt!=''))
							{		
								echo "<td>".$row2['size'.$size_id_n.'_qty']."</td>";
							}
							else
							{
								echo "<td>0</td>";
							}
							//$minisizes_sum[$i]+=$r['size'.$size_id_n.'_qty'];
						}
						else
						{
							echo "<td>".$row2['size'.$sizesarray[$j].'_qty']."</td>";
							//$minisizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
						}
					$cnt=0;	
					}
					echo "<td>".$row2['Qnty']."</td>";
					echo "<tr>";
					
				}	
						
				
				echo "</table></div>";
				
	
	
	
	
	
	$temp_array=array();
	$miniord_ref = echo_title("brandix_bts.tbl_min_ord_ref","group_concat(id)","ref_product_style=$style_code and ref_crt_schedule",$schedule,$link);
	$rowcount = "SELECT md.docket_number,md.mini_order_ref,md.mini_order_num,md.color,sum(md.quantity) as Qnty,";
	for($i=0;$i<sizeof($sizesarray);$i++)
	{
		$temp_array[]=" sum(if(size='".$sizesarray[$i]."',md.quantity,0)) as size".$sizesarray[$i]."_qty ";
	}
	$rowcount.=implode(",",$temp_array);
	$rowcount.=" FROM `tbl_miniorder_data` md where `mini_order_ref` in($miniord_ref)";
	$rowcount1=$rowcount." group by md.color,md.mini_order_num order by md.mini_order_num,md.color ASC";
		
	//echo $rowcount1."<br>";
	$sql_result1=mysqli_query($link, $rowcount1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count=mysqli_num_rows($sql_result1);
	$last_min = echo_title("tbl_miniorder_data","max(mini_order_num)","mini_order_ref ",$miniord_ref,$link);
	$color_cnt = echo_title("tbl_miniorder_data","count(distinct color)"," mini_order_num=".$last_min." and mini_order_ref ",$miniord_ref,$link);
	//echo $last_min;
	if($count>0)
	{
	//	echo "<table  width=\"100%\" style=\"background-color: #F2F2F2 ;\">";
		$old_miniorder=0;
		$miniorder_count=0;
		$miniorder_old=0;
		$tot_qnty=0;
		//$test=1;
		$temp=1;
		$col=0;
		while($r=mysqli_fetch_array($sql_result1))
		{
			$miniorder=$r['mini_order_num'];
			$tp=$r['docket_number'];
			$type_d=substr($tp,0,1);
			//echo $type_d."<br>";
			if($type_d == 'R')
			{
				$name='-Recut';
			}
			else
			{
				$name='';
			}
			//echo $miniorder_count."--".$temp."<br>";
			if(($miniorder_count==0) && $temp==1)
			{
			//	echo "<tr><td>";
			}
			//$id=$r['id'];
			if($old_miniorder!=0)
			{	
				if($miniorder!=$old_miniorder)
				{	
					//echo $miniorder."----".$old_miniorder;
						//echo $color_cnt."----".$col;
					//$size_total=$sizes_sum[$i];
					echo"<tr><td><b>Total Cartons : <u>".round($miniwise_qnty/$qry_cartonqty_result,2)."</u></b></td>";
					for($i=0;$i<=sizeof($sizesarray)-1;$i++)
					{		
						echo"<td><b><u>".$minisizes_sum[$i]."</u></b></td>";
						$minisizes_sum[$i]=0;
					}
					echo"<td><b><u>".$miniwise_qnty."</u></b></td>";
					echo"</tr>";
					
					$minisizes_sum[$i]=0;
					$miniwise_qnty=0;
					$miniorder_count++;
					
					echo "</table>";
					//echo "</td><td>";
					//echo "</p>";
					echo "</div>";
					$col=0;
				}
				
				
			}
			//echo $color_cnt."----".$col;
			
			if($miniorder!=$old_miniorder)
			{
				echo '<div id="table_div" style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin-left: 1.5%;margin-right: 0.5%;margin-bottom:1.5%; padding: 5px;">';
				echo "<table width=\"350\" height=\"75\" border=\"1px\" id='table1'>";
				echo "<tr><th colspan=".$val."><center><b> Input Job No:".$miniorder.$name."</b></center></th></tr>";
				//echo "<tr><td colspan=6><center><h3 style=\"background-color: #A9BCF5 ;\">Mini order No:".$miniorder."</h3></center></td></tr>";
				
				echo "<tr><th>Color</th>";
				for($i=0;$i<sizeof($sizesarray);$i++)
				{		
					if($sizesnames_array[$i] !='')
					{	
						echo "<th><u>".$sizesnames_array[$i]."</u></th>";
					}
					else
					{	
						$get_siz_nam=echo_title("brandix_bts.tbl_orders_size_ref","size_name","id",$sizesarray[$i],$link);
						echo "<th><u>".$get_siz_nam."</u></th>";
					}
				}
				echo "<th>Total</th>";
				echo "</tr>";
			}
			echo"<tr><td>".$r['color']."</td>";
			$col++;
			//echo $col."<br>";
			$cnt=0;
			for($i=0;$i<sizeof($sizesarray);$i++)
			{
				
				if($sizesnames_array[$i]!='')
				{
					$qry_vallidate_size="select id,ref_size_name from tbl_orders_sizes_master where parent_id in (SELECT id FROM `tbl_orders_master` WHERE ref_product_style =$style_code and `product_schedule`=$schedule_result) and order_col_des='".$r['color']."' and size_title='".$sizesnames_array[$i]."'";
					$sql_result2=mysqli_query($link, $qry_vallidate_size) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					while($row2=mysqli_fetch_array($sql_result2))
					{
						$cnt=$row2['id'];
						$size_id_n=$row2['ref_size_name'];
					}
					
					if((0<$cnt) || ($cnt!=''))
					{		
						echo "<td>".$r['size'.$size_id_n.'_qty']."</td>";
					}
					else
					{
						echo "<td>0</td>";
					}
					$minisizes_sum[$i]+=$r['size'.$size_id_n.'_qty'];
				}
				else
				{
					echo "<td>".$r['size'.$sizesarray[$i].'_qty']."</td>";
					$minisizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
				}
				$sizes_sum[$i]+=$r['size'.$sizesarray[$i].'_qty'];
				$cnt=0;
			}
			echo "<td><b>".$r['Qnty']."</b></td>";
			echo "</tr>";
			$temp++;
			$old_miniorder=$miniorder;
			$tot_qnty=$tot_qnty+$r['Qnty'];
			$miniwise_qnty+=$r['Qnty'];
			if(($old_miniorder==$last_min) && ($color_cnt==$col))
			{
				//echo $color_cnt."--".$col;
				echo"<tr><td><b>Total Cartons : <u>".round($miniwise_qnty/$qry_cartonqty_result,2)."</u></b></td>";
				for($i=0;$i<=sizeof($sizesarray)-1;$i++)
				{		
					echo"<td><b><u>".$minisizes_sum[$i]."</u></b></td>";
					$minisizes_sum[$i]=0;
				}
				echo"<td><b><u>".$miniwise_qnty."</u></b></td>";
				echo"</tr>";
				
				$minisizes_sum[$i]=0;
				$miniwise_qnty=0;
				$miniorder_count++;
				
				echo "</table>";
				//echo "</td><td>";
				//echo "</p>";
				echo "</div>";
			}
			if($miniorder_count==3)
			{
				//echo "check";
				//echo "</tr>";
				//echo "</tr>";
				$miniorder_count=0;
				$temp=1;
			}
			
		}
	}	
		
	
	}	//echo "</table>";
	
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