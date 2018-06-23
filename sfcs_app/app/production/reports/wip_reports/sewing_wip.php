
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R'); ?>">

<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/css/table.css',4,'R'); ?>">
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
 float:right;
</style>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',4,'R') ?>"></script>
<script language="javascript" type="text/javascript"></script>



<div class="panel panel-primary">
<div class="panel-heading">Sewing WIP</div>
<div class="panel-body">

<?php



//$section1=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16");
//$section2=array("17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32");
//$section3=array("33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48");
//$section4=array("49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64");

echo "<table class='table table-bordered' id='table1'><tr><th>Buyer Division</th><th>Style</th><th>CO</th><th>Schedule</th><th>Color</th><th>Section</th><th>Module</th><th>Sewing Wip</th><th>EX-Factory</th></tr>";

$sql="select sum(ims_qty) as ims_qty,sum(ims_pro_qty) as ims_pro_qty,ims_style,ims_schedule,ims_color,ims_mod_no from $bai_pro3.ims_log where ims_date >= \"2015-01-01\" and ims_qty!=ims_pro_qty and ims_mod_no > 0 group by ims_style,ims_schedule,ims_color,ims_mod_no order by ims_doc_no";

$result=mysqli_query($link, $sql) or die("Error=1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($result))
{
	$ims_style=$row["ims_style"];
	$ims_schedule=$row["ims_schedule"];
	$ims_color=$row["ims_color"];
	$ims_mod_no=$row["ims_mod_no"];


	$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$ims_schedule."\" and order_col_des=\"".$ims_color."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error=2".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result1)==0)
	{
		$sql1="select * from $bai_pro3.bai_orders_db_confirm_archive where order_del_no=\"".$ims_schedule."\" and order_col_des=\"".$ims_color."\"";
	}
	$result1=mysqli_query($link, $sql1) or die("Error=3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$order_tid=$row1["order_tid"];
	}

	$sql1="select co_no from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$co_no=$row1["co_no"];
	}	
	
	$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error=4".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result1)==0)
	{
		$sql1="select * from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"".$order_tid."\"";
	}
	$result1=mysqli_query($link, $sql1) or die("Error=5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$buyer=$row1["order_div"];
		$order_style_no=$row1["order_style_no"];
		$order_del_no=$row1["order_del_no"];
		$order_col_des=$row1["order_col_des"];
		$order_date=$row1["order_date"];
	}
	$section="";
	
	$sql_sec="select * from $bai_pro3.sections_db where sec_id > 0";
	$result_sec=mysqli_query($link, $sql_sec) or die("Error=6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row_sec=mysqli_fetch_array($result_sec))
	{
		$section_ref=$row_sec["sec_id"];
		$modules_ref_id=$row_sec["sec_mods"];
		
		$modules_ref_id_explode=explode(",",$modules_ref_id);
		for($i=0;$i<sizeof($modules_ref_id_explode);$i++)
		{
			if($ims_mod_no==$modules_ref_id_explode[$i])
			{
				$section=$section_ref;
			}
		}
	}
	
	/*if(in_array($ims_mod_no,$section1))
	{
		$section="1";
	}
	
	if(in_array($ims_mod_no,$section2))
	{
		$section="2";
	}
	
	if(in_array($ims_mod_no,$section3))
	{
		$section="3";
	}
	
	if(in_array($ims_mod_no,$section4))
	{
		$section="4";
	}*/

	echo "<tr>";
	echo "<td>".$buyer."</td>";
	echo "<td>".$order_style_no."</td>";
	echo "<td>".$co_no."</td>";
	echo "<td>".$order_del_no."</td>";
	echo "<td>".$order_col_des."</td>";
	echo "<td>".$section."</td>";
	echo "<td>".$ims_mod_no."</td>";
	echo "<td>".($row["ims_qty"]-$row["ims_pro_qty"])."</td>";
	echo "<td>".$order_date."</td>";
	echo "</tr>";
}
/*
$sqlx="select sum(ims_qty) as ims_qty,sum(ims_pro_qty) as ims_pro_qty,ims_style,ims_schedule,ims_color,ims_mod_no from ims_log_backup where ims_date >= \"2015-01-01\" and ims_qty!=ims_pro_qty and ims_mod_no > 0 and ims_remarks!=\"SAMPLE\" group by ims_style,ims_schedule,ims_color,ims_mod_no order by ims_doc_no";
//echo $sqlx."<br>";
$resultx=mysql_query($sqlx,$link) or die("Error=".mysql_error());
while($rowx=mysql_fetch_array($resultx))
{
	$ims_style=$rowx["ims_style"];
	$ims_schedule=$rowx["ims_schedule"];
	$ims_color=$rowx["ims_color"];
	$ims_mod_no=$rowx["ims_mod_no"];
	$order_tid1="";
	$sql1="select * from bai_orders_db_confirm where order_del_no=\"".$ims_schedule."\" and order_col_des=\"".$ims_color."\"";
	$result1=mysql_query($sql1,$link) or die("Error=".mysql_error());
	if(mysql_num_rows($result1)==0)
	{
		$sql1="select * from bai_orders_db_confirm_archive where order_del_no=\"".$ims_schedule."\" and order_col_des=\"".$ims_color."\"";
	}
	$result1=mysql_query($sql1,$link) or die("Error=".mysql_error());
	while($row1=mysql_fetch_array($result1))
	{
		$order_tid1=$row1["order_tid"];
	}
	
	$sql1="select * from bai_orders_db_confirm where order_tid=\"".$order_tid1."\"";
	$result1=mysql_query($sql1,$link) or die("Error=".mysql_error());
	if(mysql_num_rows($result1)==0)
	{
		$sql1="select * from bai_orders_db_confirm_archive where order_tid=\"".$order_tid1."\"";
	}
	$result1=mysql_query($sql1,$link) or die("Error=".mysql_error());
	while($row1=mysql_fetch_array($result1))
	{
		$buyer=$row1["order_div"];
		$order_style_no=$row1["order_style_no"];
		$order_del_no=$row1["order_del_no"];
		$order_col_des=$row1["order_col_des"];
		$order_date=$row1["order_date"];
	}
	
	$section="";
	
	if(in_array($ims_mod_no,$section1))
	{
		$section="1";
	}
	
	if(in_array($ims_mod_no,$section2))
	{
		$section="2";
	}
	
	if(in_array($ims_mod_no,$section3))
	{
		$section="3";
	}
	
	if(in_array($ims_mod_no,$section4))
	{
		$section="4";
	}

	echo "<tr>";
	echo "<td>".$buyer."</td>";
	echo "<td>".$order_style_no."</td>";
	echo "<td></td>";
	echo "<td>".$order_del_no."</td>";
	echo "<td>".$order_col_des."</td>";
	echo "<td>".$section."</td>";
	echo "<td>".$ims_mod_no."</td>";
	echo "<td>".($rowx["ims_qty"]-$rowx["ims_pro_qty"])."</td>";
	echo "<td>".$order_date."</td>";
	echo "</tr>";
}
*/
echo "</table>";

?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
//]]>
</script>

</div>
</div>
</div>