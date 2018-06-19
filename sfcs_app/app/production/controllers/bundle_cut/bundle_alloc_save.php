<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
<!---<style type="text/css">
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
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>

<?php
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));

if(isset($_POST['save']))
{
	$code='';
	$style_id=$_POST['style_id'];
	$schedule_id=$_POST['schedule'];
	$mini_order_num=$_POST['mini_order_num'];
	$mini_order_ref=$_POST['mini_order_ref'];
	$color=$_POST["color"];
	$color_code=$_POST["color_code"];
	$size_id=$_POST['size_id'];
	$lines_select=explode("-",$_POST['lines_selected']);
	$quantity=$_POST['quantity'];
	$bundles_count=$_POST['bundles_count'];
	$mod=$_POST['mod'];
	$total=$_POST['total'];
	$code='';
	//echo $mini_order_ref."---".$mini_order_num."<br>";
	/*
	echo "Color-".sizeof($color)."<br>";
	echo "module-".$_POST['lines_selected']."<br>";
	echo "module-".sizeof($lines_select)."<br>";
	echo "size-".sizeof($size_id)."<br>";
	echo "quantity-".sizeof($quantity)."<br>";
	echo "bundle_count-".sizeof($bundles_count)."<br>";
	echo "total-".sizeof($total)."<br>";
	echo "mod-".sizeof($mod)."<br>";
	*/
	echo "<h2>Saved Successfully.</h2>";
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	echo "<h3>Style = ".$style."Schedule ".$schedule." Mini Order Number  ".$mini_order_num."</h3>";
	echo "<table class='table table-bordered'>";
	echo "<tr><th>S.No</th><th>Color</th><th>Size</th><th>Quantity</th><th>Bundles</th>";
	for($i=0;$i<sizeof($lines_select)-1;$i++)
	{
		echo "<th>Module-".$lines_select[$i]."</th>";
		//$i++;
		$code.=$lines_select[$i]."-";
	}
	echo "<th>Total</th></tr>";
	//$sno=1;
	$size_title='';
	for($i=1;$i<=sizeof($color);$i++)
	{
		//echo sizeof($color)."<br>";
		//$color=$color[$i];
		$size=$size_id[$i];
		$size_title_query="select size_title from $brandix_bts.tbl_orders_sizes_master where order_col_des='".$color[$i]."' and ref_size_name=$size and parent_id in(select id from $brandix_bts.tbl_orders_master where ref_product_style=$style_id and product_schedule='$schedule') limit 0,1";
		$size_title_result=mysqli_query($link, $size_title_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($m1= mysqli_fetch_array($size_title_result))
		{
			$size_title=$m1['size_title'];
		}
		
		echo "<tr><td>".$i."</td><td>".$color[$i]."</td><td>".$size_title."</td><td>".$quantity[$i]."</td><td>".$bundles_count[$i]."</td>";
		for($k=0;$k<sizeof($lines_select)-1;$k++)
		{
			$line_num=$lines_select[$k];
			$bundle_update_count=$mod[$i][$k];
			
			if($total[$i]<=$quantity[$i])
			{
				echo "<td>".$mod[$i][$k]."</td>";
				echo "<input type='hidden' id='mod[".$i."][".$k."]' name='mod[".$i."][".$k."]' value='".$mod[$i][$k]."'>";
				//$module_assigned[$i][$k]=$mod[$i][$k];
				if($bundle_update_count!='' or $bundle_update_count!=0)
				{
					
					//get bundle numbers of this color,size based on mini order number and mini order ref number
					$get_bundle_query="select bundle_number from $brandix_bts.tbl_miniorder_data where color='".$color[$i]."' and size=$size and mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref and (planned_module=0 or planned_module is NULL) order by bundle_number limit $bundle_update_count";
					//echo $get_bundle_query."</br>";
					$bundle_result=mysqli_query($link, $get_bundle_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($b = mysqli_fetch_array($bundle_result))
					{
						$bundle_num=$b['bundle_number'];
						$update_module="update $brandix_bts.tbl_miniorder_data set planned_module=$line_num where bundle_number=$bundle_num";
						//echo $update_module."</br>";
						$result=mysqli_query($link, $update_module) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
			else
			{
					echo "<td>0</td>";
			}
		}
		echo "</td><td>".$total[$i]."</td>";
		echo "</tr>";
			
	}
	$data_sym="$";
	$File = "module.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."style=\"".$style_id."\"; ".$data_sym."color_code=\"".$color_code."\"; ".$data_sym."schedule=\"".$schedule_id."\"; ".$data_sym."last_min=\"".$mini_order_num."\"; ".$data_sym."mini_order_ref=\"".$mini_order_ref."\"; ".$data_sym."module=\"".$code."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
/*	$sql="SELECT module,MAX(bundles) FROM (
	SELECT planned_module AS module,COUNT(bundle_number) AS bundles,SUM(quantity) AS quatity FROM tbl_miniorder_data WHERE mini_order_ref='".$mini_order_ref."' AND mini_ordeR_num='".$mini_order_num."' GROUP BY planned_module ) AS tmp";
	//echo $sql."<br>";
	$result=mysql_query($sql,$link) or exit("Sql Error2".mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$module=$row['module'];
		$section = echo_title("brandix_bts.tbl_module_ref","module_section","id",$module,$link);
		
		$sql1="insert into bai_pro3.trims_dashboard(doc_ref,mini_ord_ref,mini_ord_num,module,section,priority) values('".$mini_order_ref."','".$mini_order_num."','".$module."','".$section."',1)";
		//echo $sql1."<br>";
		$result1=mysql_query($sql1,$link) or exit("Sql Error2".mysql_error());
	}
*/
	echo "</table>";
	$url=getFullURLLevel($_GET['r'],'bundle_allocation.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"$url&color_code=$color_code&color_code=$color_code&style_id=$style_id&sch_id=$schedule_id&mini_order_num=$mini_order_num&mini_order_ref=$mini_order_ref&ops\"; }</script>";
	//header("Location:bundle_allocation.php?mini_order_num=$mini_order_num&mini_order_ref=$mini_order_ref&ops&");
}
if(isset($_POST['update']))
{
	$style_id=$_POST['style_id'];
	$schedule_id=$_POST['schedule'];
	$mini_order_num=$_POST['mini_order_num'];
	$mini_order_ref=$_POST['mini_order_ref'];
	$color=$_POST["color"];
	$color_code=$_POST["color_code"];
	$size_id=$_POST['size_id'];
	$lines_select=explode("-",$_POST['lines_selected']);
	$quantity=$_POST['quantity'];
	$bundles_count=$_POST['bundles_count'];
	$mod=$_POST['mod'];
	$code='';
	$total=$_POST['total'];
	//echo $mini_order_ref."---".$mini_order_num."<br>";
	echo "<h2>Updated Successfully.</h2>";
	/*
	echo "Color-".sizeof($color)."<br>";
	echo "module-".$_POST['lines_selected']."<br>";
	echo "module-".sizeof($lines_select)."<br>";
	echo "size-".sizeof($size_id)."<br>";
	echo "quantity-".sizeof($quantity)."<br>";
	echo "bundle_count-".sizeof($bundles_count)."<br>";
	echo "total-".sizeof($total)."<br>";
	echo "mod-".sizeof($mod)."<br>";
	*/	
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	echo "<h2>Style = ".$style."Schedule ".$schedule." Mini Order Number  ".$mini_order_num."</h2>";
	echo "<table class='table table-bordered'>";
	echo "<tr><th>S.No</th><th>Color</th><th>Size</th><th>Quantity</th><th>Bundles</th>";
	for($i=0;$i<sizeof($lines_select)-1;$i++)
	{
		echo "<th>Module-".$lines_select[$i]."</th>";
		$code.=$lines_select[$i]."-";
	}
	echo "<th>Total</th></tr>";
	//$sno=1;
	for($i=1;$i<=sizeof($color);$i++)
	{
		//echo sizeof($color)."<br>";
		//$color=$color[$i];
		$size=$size_id[$i];
		$size_title_query="select size_title from $brandix_bts.tbl_orders_sizes_master where order_col_des='".$color[$i]."' and ref_size_name=$size and parent_id in(select id from $brandix_bts.tbl_orders_master where ref_product_style=$style_id and product_schedule='$schedule') limit 0,1";
		$size_title_result=mysqli_query($link, $size_title_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($m1= mysqli_fetch_array($size_title_result))
		{
			$size_title=$m1['size_title'];
		}
		$module_update="update $brandix_bts.tbl_miniorder_data set planned_module=0 where color='".$color[$i]."' and size='".$size."' and mini_order_num='".$mini_order_num."' and mini_order_ref='".$mini_order_ref."'";
		$result=mysqli_query($link, $module_update) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo "<tr><td>".$i."</td><td>".$color[$i]."</td><td>".$size_title."</td><td>".$quantity[$i]."</td><td>".$bundles_count[$i]."</td>";
		for($k=0;$k<sizeof($lines_select)-1;$k++)
		{
			$line_num=$lines_select[$k];
			$bundle_update_count=$mod[$i][$k];
			if($total[$i]<=$quantity[$i])
			{
				echo "<td>".$mod[$i][$k]."</td>";
				echo "<input type='hidden' id='mod[".$i."][".$k."]' name='mod[".$i."][".$k."]' value='".$mod[$i][$k]."'>";
				if($bundle_update_count!='' or $bundle_update_count!=0)
				{
					//get bundle numbers of this color,size based on mini order number and mini order ref number
					$get_bundle_query="select bundle_number from $brandix_bts.tbl_miniorder_data where color='".$color[$i]."' and size=$size and mini_order_num=$mini_order_num and mini_order_ref=$mini_order_ref and (planned_module=0 or planned_module is NULL) order by bundle_number limit $bundle_update_count";
					//echo $get_bundle_query."</br>";
					$bundle_result=mysqli_query($link, $get_bundle_query) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($b = mysqli_fetch_array($bundle_result))
					{
						$bundle_num=$b['bundle_number'];
						$update_module="update $brandix_bts.tbl_miniorder_data set planned_module=$line_num where bundle_number=$bundle_num";
						//echo $update_module."</br>";
						$result=mysqli_query($link, $update_module) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
			else
			{
				echo "<td>0</td>";
			}
		}
		echo "</td><td>".$total[$i]."</td>";
		echo "</tr>";
		$data_sym="$";
		$File = "module.php";
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."style=\"".$style_id."\"; ".$data_sym."color_code=\"".$color_code."\"; ".$data_sym."schedule=\"".$schedule_id."\"; ".$data_sym."last_min=\"".$mini_order_num."\"; ".$data_sym."mini_order_ref=\"".$mini_order_ref."\"; ".$data_sym."module=\"".$code."\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh);
		
	/*	$sql="SELECT module,MAX(bundles) FROM (
		SELECT planned_module AS module,COUNT(bundle_number) AS bundles,SUM(quantity) AS quatity FROM tbl_miniorder_data WHERE mini_order_ref='".$mini_order_ref."' AND mini_ordeR_num='".$mini_order_num."' GROUP BY planned_module ) AS tmp";
		//echo $sql."<br>";
		$result=mysql_query($sql,$link) or exit("Sql Error2".mysql_error());
		while($row = mysql_fetch_array($result))
		{
			$module=$row['module'];
			$section = echo_title("brandix_bts.tbl_module_ref","module_section","id",$module,$link);
			$check = echo_title("bai_pro3.trims_dashboard","count(*)","mini_ord_ref=\"$mini_order_ref\" and mini_ord_num",$mini_order_num,$link);
			if($check>0)
			{
				$sql1="update bai_pro3.trims_dashboard set module='".$module."',section='".$section."' where mini_ord_ref=\"$mini_order_ref\" and mini_ord_num=\"$mini_order_num\"";
				$result1=mysql_query($sql1,$link) or exit("Sql Error2".mysql_error());
			}
			else
			{
				$sql1="insert into bai_pro3.trims_dashboard(mini_ord_ref,mini_ord_num,module,section,priority) values('".$mini_order_ref."','".$mini_order_num."','".$module."','".$section."',1,)";
				$result1=mysql_query($sql1,$link) or exit("Sql Error2".mysql_error());
			}
		}
		*/
	}
	
	
	echo "</table>";
	$url=getFullURLLevel($_GET['r'],'bundle_allocation.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"$url&color_code=$color_code&style_id=$style_id&sch_id=$schedule_id&mini_order_num=$mini_order_num&mini_order_ref=$mini_order_ref&ops\"; }</script>";
}
?>
<!---<style>

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
</style>--->