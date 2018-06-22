<?php
$start_timestamp = microtime(true);

include("dbconf_sch.php");
$titles=array("Fabric WH (Yds)","Fabric Cuting (Yds)","Cutting (Pcs)","Sewing (Pcs)","Packing (Pcs)","Finish Goods (Pcs)","SAH","Clock Hours","Out Put (Pcs)","Dispatched (Pcs)","Reject Pcs","Rework Pcs");
$value=array();
$month=date("m");
$year=date("Y");

$sql="select SUM(balance) AS wh_fabric FROM bai_rm_pj1.fabric_status_v1 WHERE tid NOT IN (124952)";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[0]=$sql_row['wh_fabric'];
}

$sql="select ROUND(SUM(order_cat_doc_mix.p_plies*maker_stat_log.mklength),0) AS cutting_fab FROM bai_pro3.order_cat_doc_mix LEFT JOIN bai_pro3.maker_stat_log ON order_cat_doc_mix.mk_ref=maker_stat_log.tid WHERE order_cat_doc_mix.print_status>\"2013-01-01\" AND order_cat_doc_mix.act_cut_status<>'DONE' AND order_cat_doc_mix.fabric_status  AND style_id IS NOT NULL";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[1]=$sql_row['cutting_fab'];
}

$sql="select SUM((p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30
)*p_plies) AS cutting_wip FROM bai_pro3.order_cat_doc_mix WHERE print_status>\"2013-01-01\" AND act_cut_status='DONE' AND act_cut_issue_status<>'DONE' AND category IN ('".implode("','",$in_categories)."') AND style_id IS NOT NULL";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[2]=$sql_row['cutting_wip'];
}

$sql="select SUM(ims_qty-ims_pro_qty) AS wip FROM bai_pro3.ims_log";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[3]=$sql_row['wip'];
}

$sql="select SUM(carton_act_qty) AS packing FROM bai_pro3.packing_dashboard_temp";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[4]=$sql_row['packing'];
}

include("C:/xampp/htdocs/sfcs_app/app/packing/reports/fg_wip.php");
$value[5]=$fg_wip;

$sql="select ROUND(SUM(act_sth),0) AS act_sth, ROUND(SUM(act_clh),0) AS act_clh, SUM(act_out) AS act_out FROM bai_pro.grand_rep WHERE MONTH(DATE)=\"$month\" AND YEAR(DATE)=\"$year\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[6]=$sql_row['act_sth'];
	$value[7]=$sql_row['act_clh'];
	$value[8]=$sql_row['act_out'];
}

$sql="select SUM(ship_s_xs+ship_s_s+ship_s_m+ship_s_l+ship_s_xl+ship_s_xxl+ship_s_xxxl+ship_s_s06+ship_s_s08+ship_s_s10+ship_s_s12+ship_s_s14+ship_s_s16+ship_s_s18+ship_s_s20+ship_s_s22+ship_s_s24+ship_s_s26+ship_s_s28+ship_s_s30) AS shipped FROM bai_pro3.ship_stat_log WHERE disp_note_no IN (select disp_note_no FROM bai_pro3.disp_db WHERE MONTH(exit_date)=\"$month\" AND YEAR(exit_date)=\"$year\") ";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[9]=$sql_row['shipped'];

}

$sql="select SUM(qms_qty) as rejected FROM bai_pro3.bai_qms_db WHERE qms_tran_type=3 AND MONTH(log_date)=\"$month\" AND YEAR(log_date)=\"$year\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[10]=$sql_row['rejected'];
}

$sql="select SUM(bac_qty) AS rework FROM bai_pro.bai_quality_log WHERE MONTH(bac_date)=\"$month\" AND YEAR(bac_date)=\"$year\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$value[11]=$sql_row['rework'];

}

$table1="<table class='wip'>";

for($i=1;$i<6;$i++)
{
	$table1.="<tr><td>".$titles[$i]."</td><td  align='right'>".number_format($value[$i])."</td></tr>";
}

$table1.="</table>";

$table2="<table class='wip'>";

for($i=6;$i<12;$i++)
{
	$table2.="<tr><td>".$titles[$i]."</td><td  align='right'>".number_format($value[$i])."</td></tr>";
}

$table2.="</table>";

//print_r($value);

	//To Write File
	$myFile = "matric_include.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData="<?php $";
	$stringData.="table1=\"";
	$stringData.=$table1;
	$stringData.="\"; $";
	
	$stringData.="table2=\"";
	$stringData.=$table2;
	$stringData.="\"; ?>";
	
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	//To Write File
	$myFile = "matric_include1.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData="<?php $";
	$stringData.="table1=\"";
	$stringData.=$table1;
	$stringData.="\"; $";
	
	$stringData.="table2=\"";
	$stringData.=$table2;
	$stringData.="\"; echo $"."table1; ?>";
	
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	
	
	//To Write File
	$myFile = "matric_include2.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData="<?php $";
	$stringData.="table1=\"";
	$stringData.=$table1;
	$stringData.="\"; $";
	
	$stringData.="table2=\"";
	$stringData.=$table2;
	$stringData.="\"; echo $"."table2; ?>";
	
	fwrite($fh, $stringData);
	fclose($fh);
	//To Write File
	
	//print_r($value);
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");

?>
