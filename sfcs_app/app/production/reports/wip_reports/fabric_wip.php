<?php
   include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>

<div class="panel panel-primary">
<div class="panel-heading">Fabric WIP</div>
<div class="panel-body">
<div style='overflow:scroll;max-height:600px'>
<br>
<?php

echo "<div class='table-responsive'><table class='table table-bordered table-striped' id='table1'><thead><tr class='info'><th>Buyer Division</th><th>Style</th><th>CO</th><th>Schedule</th><th>Color</th><th>Fabric WIP Yards</th><th>Fabric WIP Pcs</th><th>EX-Factory</th></tr></thead>";

$sql=mysqli_query($link, "select order_tid,SUM(material_req) AS fabric_wip_yards,GROUP_CONCAT(doc_no) AS DOCNO,SUM((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s06+a_s08+a_s10++a_s12+a_s14+a_s16+a_s18+a_s20+a_s22+a_s24+a_s26+a_s28+a_s30)*a_plies) AS pcs from $bai_pro3.order_cat_doc_mk_mix WHERE fabric_status=5 and date >= \"2015-01-01\" AND act_cut_status=\"\" and category in (\"Body\",\"Front\") GROUP BY ORDER_TID ORDER BY DOC_NO");
while($row=mysqli_fetch_array($sql))
{
	$order_tid=$row["order_tid"];

	$sql1="select co_no from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$co_no=$row1["co_no"];
	}	
	
	$sql1="select order_div,order_style_no,order_del_no,order_col_des,order_date from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid."\"";
	//echo $sql1;
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result1)==0)
	{
		$sql1="select order_div,order_style_no,order_del_no,order_col_des,order_date from $bai_pro3.bai_orders_db_confirm_archive where order_tid=\"".$order_tid."\"";
	}
	$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$buyer=$row1["order_div"];
		$order_style_no=$row1["order_style_no"];
		$order_del_no=$row1["order_del_no"];
		$order_col_des=$row1["order_col_des"];
		$order_date=$row1["order_date"];
	}
	
	$fabric_wip_yards=$row["fabric_wip_yards"];
	$fabric_wip_pcs=$row["pcs"];
	echo "<tr>";
	
	echo "<td>".$buyer."</td>";
	echo "<td>".$order_style_no."</td>";
	echo "<td>".$co_no."</td>";
	echo "<td>".$order_del_no."</td>";
	echo "<td>".$order_col_des."</td>";
	echo "<td>".$fabric_wip_yards."</td>";
	echo "<td>".$fabric_wip_pcs."</td>";
	echo "<td>".$order_date."</td>";
 
  echo "</tr>";
}
echo "</table></div>";

?>

<script language="javascript" type="text/javascript">
	$('#reset_table1').addClass('btn btn-warning');
// <![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});$('#reset_table1').addClass('btn btn-warning');
// <![CDATA[
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );

	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
		$('#reset_table1').find('a').addClass('table_resets');
	});
// ]]>
</script>
</div></div>
<style>
.flt{
	color:black;
}
#reset_table1{
	width : 80px;
	color : #fff;
	margin-top : 80px;
	margin-left : -110px;
	margin-bottom:15pt;
}
</style>