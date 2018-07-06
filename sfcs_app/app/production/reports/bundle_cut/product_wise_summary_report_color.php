<?php
set_time_limit(500000);
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");

?>

<?php
    //settings
    $cache_ext  = '.html'; //file extension
    $cache_time     = 3600;  //Cache file expires afere these seconds (1 hour = 3600 sec)
    $cache_folder   = ''; //folder to store Cache files
    $ignore_pages   = array('', '');

    $dynamic_url    = 'product_wise_summary_report_color'; // requested dynamic page (full url)
    $cache_file     = $dynamic_url.$cache_ext; // construct a cache file
    

    if (isset($_GET['snap'])) { //check Cache exist and it's not expired.
        ob_start(); //Turn on output buffering, "ob_gzhandler" for the compressed page with gzip.
        //readfile($cache_file); //read Cache file
        //echo '<!-- cached page - '.date('l jS \of F Y h:i:s A', filemtime($cache_file)).', Page : '.$dynamic_url.' -->';
       ob_end_flush();
        //exit(); //no need to proceed further, exit the flow.
	
    }
	else
	{
		//	header("Location: product_wise_summary_report_color.html");
	}
    //Turn on output buffering with gzip compression.
    ob_start();
    ######## Your Website Content Starts Below #########
    ?>
<html>
<head>
<title>Product Wise Summary Report</title>

<style type="text/css" media="screen">
@import "../TableFilter_EN/filtergrid.css";
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
	<style>

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
<script src="js/jquery.min1.7.1.js"></script>
<script src="ddtf.js"></script>


<link rel="stylesheet" type="text/css" media="all" href="jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsdatepick-calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
</head>
<body>
<div id="page_heading"><span style="float: left"><h3>Style & Color Level WIP Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<?php



echo "Last Updated:".date("Y-m-d H:i:s");

echo "<table cellspacing=\"0\" class=\"mytable1\" id='table_format'>";
echo "<tr><th>Sno</th><th>Product</th><th>CO Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Order Qty</th><th>Cut Qty</th><th>Recut Cut Qty</th><th>Bundle In Qty</th><th>Bundle Out Qty</th><th>Sewing In Qty</th><th>Sewing Out Qty</th><th>Rejections</th><th>FG Qty</th><th>Cut Pending</th><th>Recut Pending</th><th>Bundling WIP</th><th>Input WIP</th><th>Sewing WIP</th><th>Packing WIP</th><th>SAH</th></tr>";
$x=0;
// if($username=='sfcsproject1')
// {
// echo $sql_source."<br><br>";
// }

$sql_source="SELECT order_div as buyer_id,tbl_orders_style_ref_product_style as styles FROM $brandix_bts.view_set_snap_1_tbl 
WHERE trim(tbl_orders_style_ref_product_style)<>'' group by tbl_orders_style_ref_product_style";
$result_source=mysqli_query($link, $sql_source) or die("1Error=".$sql."=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_source=mysqli_fetch_array($result_source))
{
	$buyer_name=$row_source["buyer_id"];
	$styles=$row_source["styles"];
	$color=$row_source["color"];
	
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
	$o_s=array();
		
		
	$sql="select tbl_orders_style_ref_product_style as style,tbl_orders_master_product_schedule as schedule,sum(tbl_orders_sizes_master_order_quantity) as qty,smv,
	tbl_orders_sizes_master_order_col_des as color from $brandix_bts.view_set_2_snap WHERE LENGTH(tbl_orders_style_ref_id) > 0 and 
	tbl_orders_style_ref_product_style in ('".$styles."') AND LENGTH(tbl_orders_master_product_schedule)<7 group by tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_orders_sizes_master_order_col_des";
	 if($username=='sfcsproject1')
	 {
		//echo $sql."<br><br>";
	 }
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
		$cpk_qty_tmp=0;
		$style=trim($row["style"]);
		$schedule=trim($row["schedule"]);
		$color=trim($row["color"]);
		
		$smv=$row["smv"];
		
		$sql6="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no='".$schedule."' and order_col_des=\"$color\"";

		$result6=mysqli_query($link, $sql6) or die("Error=".$sql6."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($result6))
		{
			$co_no=$sql_row["co_no"];
			for($s=0;$s<sizeof($sizes_code);$s++)
			{
				$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
			}
			$order_qty+=array_sum($o_s);
			unset($o_s);
		}
	
	
		//$total_order_qty=$total_order_qty+$order_qty;
		// $sql21="SELECT SUM(tbl_orders_sizes_master_order_quantity) as qty FROM $view_set_2_snap WHERE trim(tbl_orders_style_ref_product_style)='".$style."' and trim(tbl_orders_sizes_master_order_col_des)='".$color."'";
		//echo $sql21."<br>";
		// $result21=mysql_query($sql21,$link) or die("Error=".$sql21."=".mysql_error());
		// while($row21=mysql_fetch_array($result21))
		// {
			// $order_qty=$row21["qty"];
		// }	
		$sql4="select COALESCE(sum(cpk_qty)) as qty from $brandix_bts.view_set_6_snap where trim(style)=\"".$style."\" and schedule=\"".$schedule."\" and trim(color)=\"".$color."\"";
		$result4=mysqli_query($link, $sql4) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($username=='sfcsproject1')
		{
		//	echo $sql4."<br>";
			
		}
		While($row4=mysqli_fetch_array($result4))
		{
			$cpk_qty_tmp=$row4["qty"];
		}
		
		if($cpk_qty_tmp>0 && $cpk_qty_tmp<>'')
		{
			$cpk_qty=$cpk_qty_tmp;
		}
		else
		{
			$cpk_qty=0;
		}
		
		if($username=='sfcsproject1')
		{
			//echo $style."--".$schedule."--".$color."--".$order_qty."--".$cpk_qty."<br>";
		}
		//if($order_qty>$cpk_qty)
		//{
		$sql2="SELECT doc_no,COALESCE(SUM(p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*a_plies) AS doc_qty FROM $bai_pro3.order_cat_doc_mk_mix left join $bai_pro3.bai_orders_db_confirm ON $bai_pro3.bai_orders_db_confirm.order_tid=$bai_pro3.order_cat_doc_mk_mix.order_tid WHERE  trim($bai_pro3.bai_orders_db_confirm.order_style_no)=\"".$style."\" and $bai_pro3.order_cat_doc_mk_mix.order_del_no=\"".$schedule."\" and trim($bai_pro3.bai_orders_db_confirm.order_col_des)=\"".$color."\" and category in ($in_categories) and act_cut_status=\"DONE\" group by doc_no";
		if($username=='sfcsproject1' and $schedule=='506652')
		{
			//echo $sql2."<br>";
		}
		$result2=mysqli_query($link, $sql2) or die("Error=".$sql2."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($result2))
		{
			$doc_nos[]=$row2["doc_no"];
			$cut_qty=$cut_qty+$row2["doc_qty"];
			
		}
		//order_cat_recut_doc_mk_mix
		//$total_cut_qty=$total_cut_qty+$cut_qty;
		
		$sql3="SELECT doc_no,COALESCE(SUM(p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)) AS doc_qty FROM $bai_pro3.order_cat_recut_doc_mk_mix left join $bai_pro3.bai_orders_db_confirm ON $bai_pro3.bai_orders_db_confirm.order_tid=$bai_pro3.order_cat_recut_doc_mk_mix.order_tid WHERE trim($bai_pro3.bai_orders_db_confirm.order_style_no)=\"".$style."\" and $bai_pro3.order_cat_recut_doc_mk_mix.order_del_no=\"".$schedule."\" and trim($bai_pro3.bai_orders_db_confirm.order_col_des)=\"".$color."\" and category in ($in_categories) and act_cut_status=\"DONE\" group by doc_no";
		//echo $sql3."<br>";
		$result3=mysqli_query($link, $sql3) or die("Error=".$sql3."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($result3))
		{
			$recut_doc_nos[]=$row3["doc_no"];
			$recut_cut_qty=$recut_cut_qty+$row3["doc_qty"];
		}
		
		//$total_recut_cut_qty=$total_recut_cut_qty+$recut_cut_qty;
		
		
		$sql4="select bundle_transactions_20_repeat_operation_id,COALESCE(SUM(bundle_transactions_20_repeat_quantity)) AS qty,
		COALESCE(SUM(bundle_transactions_20_repeat_rejection_quantity)) AS rej_qty,
		SUM(sah) AS sah from $brandix_bts.view_set_snap_1_tbl where trim(tbl_orders_style_ref_product_style)=\"".$style."\" and 
		trim(tbl_miniorder_data_color)=\"".$color."\" and tbl_orders_master_product_schedule=\"".$schedule."\" GROUP BY bundle_transactions_20_repeat_operation_id";
		//echo $sql4."<br>";
		$result4=mysqli_query($link, $sql4) or die("Error4=".$sql4."=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			switch($row4['bundle_transactions_20_repeat_operation_id'])
			{
					case 1:
					{
							$bundle_in_qty=$row4["qty"];
							$total_bundle_in_qty=$total_bundle_in_qty+$bundle_in_qty;
							break;
					}
					
					case 2:
					{
							$bundle_out_qty=$row4["qty"];
							$total_bundle_out_qty=$total_bundle_out_qty+$bundle_out_qty;
							break;
					}
					
					case 3:
					{
							$sewing_in_qty=$row4["qty"];
							$total_sewing_in_qty=$total_sewing_in_qty+$sewing_in_qty;
							break;
					}
					
					case 4:
					{
							$sewing_out_qty=$row4["qty"];
							$total_sewing_out_qty=$total_sewing_out_qty+$sewing_out_qty;
							break;
					}
				
			}
			
			$rejection_qty+=$row4["rej_qty"];
			$total_rejection_qty=$total_rejection_qty+$rejection_qty;
			
			$sahx+=$row4x["sah"];
		}
		
		
		$x++;
		echo "<tr>";
		echo "<td>".$x."</td>";
		echo "<td>".trim($buyer_name)."</td>";
		echo "<td>".$co_no."</td>";
		echo "<td>".trim($style)."</td>";
		echo "<td>".$schedule."</td>";
		echo "<td>".$color."<br>";
		echo "<td>".$order_qty."</td>";
		echo "<td>".$cut_qty."</td>";
		echo "<td>".$recut_cut_qty."</td>";
		echo "<td>".round($bundle_in_qty,0)."</td>";
		echo "<td>".round($bundle_out_qty,0)."</td>";
		echo "<td>".round($sewing_in_qty,0)."</td>";
		echo "<td>".round($sewing_out_qty,0)."</td>";
		echo "<td>".round($rejection_qty,0)."</td>";
		echo "<td>".round($cpk_qty,0)."</td>";
		echo "<td>".($order_qty-$cut_qty)."</td>";
		echo "<td>".($rejection_qty-$recut_cut_qty)."</td>";
		//echo "<td>".($cut_qty-$bundle_in_qty)."</td>";
		echo "<td>".($bundle_in_qty-$bundle_out_qty)."</td>";
		echo "<td>".($bundle_out_qty-$sewing_in_qty)."</td>";
		echo "<td>".($sewing_in_qty-($sewing_out_qty+$rejection_qty))."</td>";
		echo "<td>".($sewing_out_qty-$cpk_qty)."</td>";
		echo "<td>".Round(($smv*$sewing_out_qty)/60,2)."</td>";
		$total_sah=$total_sah+Round(($smv*$sewing_out_qty)/60,2);
		echo "</tr>";
		//}
	}
	
	/*
	echo "<tr bgcolor=\"#A9A9A9\">";
	echo "<td colspan=4 align=\"center\">".$buyer_name."</td>";
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
	echo "<td>".$total_sah."</td>";
	echo "</tr>";
	*/
}
echo '<tr><td colspan=6>Total:</td>
	<td id="table1Tot1" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot2" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot3" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot4" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot5" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot6" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot7" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot8" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot9" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot10" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot11" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot12" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot13" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot14" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot15" style="background-color:#FFFFCC; color:red;">
	<td id="table1Tot16" style="background-color:#FFFFCC; color:red;">
	</td></tr>';
echo "</table>";

?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	col_1: 'select',
	col_2: 'select',
	col_3: 'select',
	col_4: 'select',
	col_5: 'select',
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1","table1Tot2","table1Tot3","table1Tot4","table1Tot5","table1Tot6","table1Tot7","table1Tot8","table1Tot9","table1Tot10","table1Tot11","table1Tot12","table1Tot13","table1Tot14","table1Tot15","table1Tot16"],
						 col: [6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21],  
						operation: ["sum","sum","sum","sum","sum","sum","sum","sum","sum","sum","sum","sum","sum","sum","sum","sum"],
						 decimal_precision: [1,1,1,1,1,1,1,1,2],
						write_method: ["innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table_format'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table_format",fnsFilters);
	//setFilterGrid( "table10" );
//]]>
</script>
<body>
</html>

<?php
    ######## Your Website Content Ends here #########

   
    if(isset($_GET['snap'])){
        $fp = fopen($cache_file, 'w');  //open file for writing
        fwrite($fp, ob_get_contents()); //write contents of the output buffer in Cache file
        fclose($fp); //Close file pointer
		ob_end_flush(); //Flush and turn off output buffering
    }
    
//echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
    ?>