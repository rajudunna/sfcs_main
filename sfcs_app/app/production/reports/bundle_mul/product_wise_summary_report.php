<html>
<head>
<title>Product Wise Summary Report</title>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:0px; padding:0px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}

caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
</head>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<body>

<div id="page_heading"><span style="float: left"><h3>Style Wise WIP Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

$x=0;
echo "<table cellspacing=\"0\" class=\"mytable1\">";
echo "<tr><th>Sno</th><th>Product</th><th>Style</th><th>Order Qty</th><th>Cut Qty</th><th>Recut Cut Qty</th><th>Bundle In Qty</th><th>Bundle Out Qty</th><th>Sewing In Qty</th><th>Sewing Out Qty</th><th>Rejections</th><th>FG Qty</th><th>Cut Pending</th><th>Recut Pending</th><th>Bundling WIP</th><th>Sewing WIP</th><th>Sewing Out WIP</th><th>Packign WIP</th><th>SAH</th></tr>";

$sql_source="SELECT order_div as buyer_id,tbl_orders_style_ref_product_style as styles FROM $brandix_bts_uat.view_set_snap_1_tbl WHERE tbl_orders_style_ref_product_style<>'' group by tbl_orders_style_ref_product_style";
//echo $sql_source."<br><br>";
$result_source=mysqli_query($link, $sql_source) or die("Error=".$sql."=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_source=mysqli_fetch_array($result_source))
{
	$buyer_name=$row_source["buyer_id"];
	$styles=$row_source["styles"];
	
	$total_order_qty=0;
	$total_cut_qty=0;
	$total_recut_cut_qty=0;
	$total_bundle_in_qty=0;
	$total_bundle_out_qty=0;
	$total_sewing_in_qty=0;
	$total_sewing_out_qty=0;
	$total_rejection_qty=0;
	$total_cpk_qty=0;
	$total_sah=0;
	
	
	
	$sql="select tbl_orders_style_ref_product_style as style,sum(tbl_orders_sizes_master_order_quantity) as qty,smv from $brandix_bts_uat.view_set_2_snap WHERE LENGTH(tbl_orders_style_ref_id) > 0 and tbl_orders_style_ref_product_style in ('".$styles."') group by tbl_orders_style_ref_product_style";
	//echo $sql."<br><br>";
	$result=mysqli_query($link, $sql) or die("Error=".$sql."=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{
		$order_qty=0;
		$cut_qty=0;
		$recut_cut_qty=0; 
		$bundle_in_qty=0;
		$bundle_out_qty=0;
		$sewing_in_qty=0;
		$sewing_out_qty=0;
		$rejection_qty=0;
		$cpk_qty=0;
		$sahx=0;

		$style=$row["style"];
		$order_qty=$row["qty"];
		$smv=$row["smv"];
		
		$total_order_qty=$total_order_qty+$order_qty;
				
		$sql2="SELECT doc_no,COALESCE(SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*p_plies) AS doc_qty FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"%".$style."%\" and act_cut_status=\"DONE\" group by doc_no";
		$result2=mysqli_query($link, $sql2) or die("Error=".$sql2."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($result2))
		{
			$doc_nos[]=$row2["doc_no"];
			$cut_qty=$cut_qty+$row2["doc_qty"];
		}
		$total_cut_qty=$total_cut_qty+$cut_qty;
		
		$sql3="SELECT doc_no,COALESCE(SUM(a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s06+a_s08+a_s10+a_s12+a_s14+a_s16+a_s18+a_s20+a_s22+a_s24+a_s26+a_s28+a_s30)*a_plies) AS doc_qty FROM $bai_pro3.recut_v2 WHERE order_tid LIKE \"%".$style."%\" and act_cut_status=\"DONE\" group by doc_no";
		$result3=mysqli_query($link, $sql3) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($result3))
		{
			$recut_doc_nos[]=$row3["doc_no"];
			$recut_cut_qty=$recut_cut_qty+$row3["doc_qty"];
		}
		$total_recut_cut_qty=$total_recut_cut_qty+$recut_cut_qty;
		
		$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$style."\" and bundle_transactions_20_repeat_operation_id=1";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$bundle_in_qty=$row4["qty"];
			$total_bundle_in_qty=$total_bundle_in_qty+$bundle_in_qty;
		}
		
		$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$style."\" and bundle_transactions_20_repeat_operation_id=2";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$bundle_out_qty=$row4["qty"];
			$total_bundle_out_qty=$total_bundle_out_qty+$bundle_out_qty;
		}
		
		$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$style."\" and bundle_transactions_20_repeat_operation_id=3";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$sewing_in_qty=$row4["qty"];
			$total_sewing_in_qty=$total_sewing_in_qty+$sewing_in_qty;
		}
		
		$sql4="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$style."\" and bundle_transactions_20_repeat_operation_id=4";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$sewing_out_qty=$row4["qty"];
			$total_sewing_out_qty=$total_sewing_out_qty+$sewing_out_qty;
		}
		
		/*$sqlx="select tbl_orders_style_ref_product_style as style,sum(tbl_orders_sizes_master_order_quantity) as qty,smv,tbl_orders_sizes_master_order_col_des as color from $view_set_2_snap WHERE LENGTH(tbl_orders_style_ref_id) > 0 and tbl_orders_style_ref_product_style=\"".$style."\" group by tbl_orders_style_ref_product_style,tbl_orders_sizes_master_order_col_des";
		//echo $sqlx."<br><br>";
		$resultx=mysql_query($sqlx,$link) or die("Error=".$sqlx."=".mysql_error());
		while($rowx=mysql_fetch_array($resultx))
		{
			$stylex=$rowx["style"];
			$colorx=$rowx["color"];
			$smvx=$rowx["smv"];
			
			$sql4x="select COALESCE(sum(bundle_transactions_20_repeat_quantity)) as qty from $view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$stylex."\" and bundle_transactions_20_repeat_operation_id=4 and tbl_miniorder_data_color=\"".$colorx."\"";
			//echo $sql4x."<br><br>";
			$result4x=mysql_query($sql4x,$link) or die("Error=".$sql4x."=".mysql_error());
			while($row4x=mysql_fetch_array($result4x))
			{
				$sewing_out_qtyx=$row4x["qty"];
			}			
			$sahx=$sahx+round(($sewing_out_qtyx*$smvx/60),2);
			//echo $stylex."-".$colorx."-".$smvx."-".$sewing_out_qtyx."<br>";
			
		}*/
		
		$sql4x="select SUM(sah) as sah from $brandix_bts_uat.view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$style."\" and bundle_transactions_20_repeat_operation_id=4";
		//echo $sql4x."<br><br>";
		$result4x=mysqli_query($link, $sql4x) or die("Error=".$sql4x."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4x=mysqli_fetch_array($result4x))
		{
			$sahx=$row4x["sah"];
		}
		
		$sql4="select COALESCE(sum(bundle_transactions_20_repeat_rejection_quantity)) as qty from $brandix_bts_uat.view_set_snap_1_tbl where tbl_orders_style_ref_product_style=\"".$style."\"";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$rejection_qty=$row4["qty"];
			$total_rejection_qty=$total_rejection_qty+$rejection_qty;
		}
		
		$sql4="select COALESCE(sum(cpk_qty)) as qty from $brandix_bts_uat.view_set_6_snap where style=\"".$style."\"";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$cpk_qty=$row4["qty"];
			$total_cpk_qty=$total_cpk_qty+$cpk_qty;
		}
		
		$x=$x+1;
		echo "<tr>";
		echo "<td>".$x."</td>";
		echo "<td>".trim($buyer_name)."</td>";
		echo "<td>".trim($style)."</td>";
		echo "<td>".$order_qty."</td>";
		echo "<td>".$cut_qty."</td>";
		echo "<td>".$recut_cut_qty."</td>";
		echo "<td>".round($bundle_in_qty)."</td>";
		echo "<td>".round($bundle_out_qty)."</td>";
		echo "<td>".round($sewing_in_qty)."</td>";
		echo "<td>".round($sewing_out_qty)."</td>";
		echo "<td>".round($rejection_qty)."</td>";
		echo "<td>".round($cpk_qty)."</td>";
		echo "<td>".($order_qty-$cut_qty)."</td>";
		echo "<td>".($rejection_qty-$recut_cut_qty)."</td>";
		echo "<td>".($cut_qty-$bundle_in_qty)."</td>";
		echo "<td>".($bundle_in_qty-$bundle_out_qty)."</td>";
		echo "<td>".($sewing_in_qty-$sewing_out_qty)."</td>";
		echo "<td>".($sewing_out_qty-$cpk_qty)."</td>";
		//echo "<td>".Round(($smv*$sewing_out_qty)/60,2)."</td>";
		echo "<td>".$sahx."</td>";		
		//$total_sah=$total_sah+Round(($smv*$sewing_out_qty)/60,2);
		$total_sah=$total_sah+$sahx;
		echo "</tr>";
	}
	/*
	echo "<tr bgcolor=\"#A9A9A9\">";
	echo "<td colspan=3 align=\"center\">".$buyer_name."</td>";
	echo "<td>".$total_order_qty."</td>";
	echo "<td>".$total_cut_qty."</td>";
	echo "<td>".$total_recut_cut_qty."</td>";
	echo "<td>".$total_bundle_in_qty."</td>";
	echo "<td>".$total_bundle_out_qty."</td>";
	echo "<td>".$total_sewing_in_qty."</td>";
	echo "<td>".$total_sewing_out_qty."</td>";
	echo "<td>".$total_rejection_qty."</td>";
	echo "<td>".$total_cpk_qty."</td>";
	echo "<td>".($total_order_qty-$total_cut_qty)."</td>";
	echo "<td>".($total_rejection_qty-$total_recut_cut_qty)."</td>";
	echo "<td>".($total_cut_qty-$total_bundle_in_qty)."</td>";
	echo "<td>".($total_bundle_in_qty-$total_bundle_out_qty)."</td>";
	echo "<td>".($total_sewing_in_qty-$total_sewing_out_qty)."</td>";
	echo "<td>".($total_sewing_out_qty-$total_cpk_qty)."</td>";
	//echo "<td>".($total_smv*$total_sewing_out_qty)."</td>";
	echo "<td>".$total_sah."</td>";
	echo "</tr>";
	*/
}
echo "</table>";
?>
<body>
</html>