<?php
// include("header.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'header.php','R'));
//2015-11-25 // kirang // Service Request #79594856 // Need to revise the Print Send and Print Receive Calculation methods, due to FG transfers

//2015-12-15/kirang/SR#32892081 /Issue: Recut quantity not adding to the count showing for panel form schedules. Fix:getting the values from audit log which has reported successfully under PS,PR operation. 

//2015-06-10/kirang/SR#85030991 /Issue: vartion in value due to taking backup of data of m3_bulk_ops_rep_db.m3_sfcs_tran_log to m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup. Fix:getting the values from m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup table also and adding to the actual table. 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0216",$username,1,$group_id_sfcs);
// include("header.php");
?>
<?php
//header("Location: http://bainet:8080/m3_bulk_or/transaction_audit_check.php");

set_time_limit(600000);
?>

<!---<style type="text/css" media="screen">


=======
@import "TableFilter_EN/filtergrid.css";


body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
-->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/css/TableFilter_EN/filtergrid.css',3,'R'); ?>"></script>
<!--<link href="style_new.css" rel="stylesheet" type="text/css" />-->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/css/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<SCRIPT LANGUAGE="Javascript" SRC="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',1,'R'); ?>"></SCRIPT>

<!--<link rel="stylesheet" type="text/css" media="all" href="/sfcs/projects/Beta/movex_rep/reports/jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="/sfcs/projects/Beta/movex_rep/reports/jsdatepick-calendar/jsDatePick.min.1.3.js"></script>-->
<script type="text/javascript">
	// window.onload = function()
	// {
		// new JsDatePick({
			// useMode:2,
			// target:"demo1",
			// dateFormat:"%Y-%m-%d"
		// });
		// new JsDatePick({
			// useMode:2,
			// target:"demo2",
			// dateFormat:"%Y-%m-%d"
		// });
	// };
</script>



<!--<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'datetimepicker_css.js',0,'R'); ?>"></script>-->
<link href=" <?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />

<script>
// function verify(e){
// 	var k = e.which;
// 	if( (k>47&&k<58) || (k==8) || k==189 || (k>95&&k<106) ){ }
// 	else{
// 		sweetAlert('Only Numerics are allowed','','warning');
// 		$('#d1').val('');
// 		$('#d2').val('');
// 	}
// }

function check_date(e){
	var d1 = new Date($('#d1').val());
	var d2 = new Date($('#d2').val());
	if(d2<d1){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		e.preventDefault();
		return false;
	}
	
}
</script>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Embellishment Summary Report</div>
<div class="panel-body">


<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<div class='col-md-3 col-sm-3 col-xs-12'>

Ex-factory Start Date: <input type="text" data-toggle='datepicker' id='d1'  size="8" class="form-control" name="date1" value="<?php if(isset($_POST["dat1"])) { echo $_POST["dat1"]; } else { echo date("Y-m-d");}?>"  />

</div>
<?php 
	// echo "<a href="."\"javascript:NewCssCal('demo1','yyyymmdd','dropdown')\">";
	// echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
?>&nbsp;&nbsp;&nbsp;&nbsp;
<div class='col-md-3 col-sm-3 col-xs-12'>
Ex-factory End Date: 

<input type="text" name="dat2" size="8" data-toggle='datepicker' id='d2'  class="form-control" value="<?php if(isset($_POST["dat2"])) { echo $_POST["dat2"]; } else { echo date("Y-m-d");}?>"  />
</div>
<?php 
	// echo "<a href="."\"javascript:NewCssCal('demo2','yyyymmdd','dropdown')\">";
	// echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
?>&nbsp;&nbsp;&nbsp;&nbsp;
<div class='col-md-3 col-sm-3 col-xs-12'>

<input type="submit" name="submit" value="Show" class="btn btn-success" onclick='check_date(event)' style="margin-top: 19px;"/> <!--Adding the please wait option -->
</div>
</form>
<span id="msg" style="display:none;"><h4>Please Wait.. While Processing Data..</h4></span>

<?php

if(isset($_POST["submit"]))
{
	$sdate=$_POST["date1"];
	$edate=$_POST["dat2"];
	
	//echo $sdate."-".$edate."<br>";
	echo "<br><br><div class='table-responsive' id='main_content'>";
	echo "<table  cellspacing=\"0\" id=\"table1\" class=\"table table-bordered\">
			<tr class='info'>
				<th>Customer</th>
				<th>Style No</th>
				<th>Schedule</th>
				<th>Color</th>
				<th>Form of Emb</th>
				<th>Graphic Description</th>
				<th>Graphic Details</th>
				<th>Pilot <br> Request <br> Date</th>
				<th>PSD</th>
				<th>Ex Factory</th>
				<th>Order Qty</th>
				<th>Cut Qty</th>
				<th>Print Sent</th>
				<th>Sewing In</th>
				<th>Sewing Out</th>
				<th>Print <br> Receive</th>
				<th>Rejection Qty</th>
				<th>FG Qty</th>
			</tr>";
	$row_count = 0;
	
	$sqlt="SELECT distinct SCHEDULE FROM $bai_pro3.bai_emb_db where date(del_date) between \"".$sdate."\" and \"".$edate."\" ORDER BY description,psd";
	// echo $sqlt."<br>";
	$sql_resultt=mysqli_query($link, $sqlt) or exit("Sql Errort".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowt=mysqli_fetch_array($sql_resultt))
	{
		
		$emb_sch=$sql_rowt["SCHEDULE"];
		$sql="select * from $bai_pro3.bai_orders_db_confirm where  (order_embl_a+order_embl_b+order_embl_c+order_embl_d+order_embl_e+order_embl_f+order_embl_g+order_embl_h) > 0 and order_del_no=".$emb_sch."";
		// echo $sql."<br>";
		// mysqli_query($link, $sql) or exit("Sql Error".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$row_count++;	
			$total_ord=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"]+$sql_row["old_order_s_xxl"]+$sql_row["old_order_s_xxxl"]+$sql_row["old_order_s_s06"]+$sql_row["old_order_s_s08"]+$sql_row["old_order_s_s10"]+$sql_row["old_order_s_s12"]+$sql_row["old_order_s_s14"]+$sql_row["old_order_s_s16"]+$sql_row["old_order_s_s18"]+$sql_row["old_order_s_s20"]+$sql_row["old_order_s_s22"]+$sql_row["old_order_s_s24"]+$sql_row["old_order_s_s26"]+$sql_row["old_order_s_s28"]+$sql_row["old_order_s_s30"];
			
			$order_style_no=$sql_row["order_style_no"];
			$order_del_no=$sql_row["order_del_no"];
			$order_col_des=$sql_row["order_col_des"];
			$order_tid=$sql_row["order_tid"];
			$buyer=$sql_row["order_div"];
			$ex_factory=$sql_row["order_date"];
			
			//$sql2="select group_concat(distinct ex_factory_date) as ex_factory_date from bai_pro4.shipment_plan where schedule_no=\"".."\" and \"".."\"
			
			$form="";
			$garmnet_details="";
			$garmnet_desc="";
			$sql1="SELECT SCHEDULE,GROUP_CONCAT(DISTINCT SUBSTRING(color_size, 1, LENGTH(trim(color_size))-2)) AS gpdl,GROUP_CONCAT(DISTINCT description) AS des,DATE(psd) AS psd,DATE_SUB(DATE(psd),INTERVAL 6 DAY) AS pilot FROM $bai_pro3.bai_emb_db WHERE SCHEDULE=\"".$order_del_no."\"";
			// echo $sql1."<br>";
			// mysqli_query($link, $sql1) or exit("Sql Error".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$garmnet_details=$sql_row1["gpdl"];
				$garmnet_desc=$sql_row1["des"];
				//$psd=$sql_row1["psd"];
				$pilot=$sql_row1["pilot"];
			}
			
			$sql11="SELECT GROUP_CONCAT(\"'\",SUBSTRING(color_size, 1, LENGTH(trim(color_size))-2),\"'\") AS des FROM $bai_pro3.bai_emb_db WHERE SCHEDULE=\"".$order_del_no."\"";
			// echo $sql1."<br>";
			// mysqli_query($link, $sql11) or exit("Sql Error".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{				
				$garmnet_desc_ref=$sql_row11["des"];
			}
			
			$sql13="SELECT GROUP_CONCAT(DISTINCT SCHEDULE) AS sch,min(DATE(psd)) AS psd FROM $bai_pro3.bai_emb_db WHERE SUBSTRING(color_size, 1, LENGTH(trim(color_size))-2) in (".$garmnet_desc_ref.")"; 
			// echo $order_del_no."-".$sql13."<br>";
			// mysqli_query($link, $sql13) or exit("Sql Error".$sql13."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result13=mysqli_query($link, $sql13) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row13=mysqli_fetch_array($sql_result13))
			{
				$sch_ref=$sql_row13["sch"];
				$psd=$sql_row13["psd"];
			}
			
			$order_tid_ref=array();
			$order_tid_ref2=array();
			$sql131="SELECT REPLACE(order_tid,\" \",\"\") as order_tid FROM $bai_pro3.bai_orders_db WHERE order_del_no IN (".$sch_ref.")"; 
			//echo $sql131."<br>";
			// mysqli_query($link, $sql131) or exit("Sql Error".$sql131."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result131=mysqli_query($link, $sql131) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row131=mysqli_fetch_array($sql_result131))
			{
				if(!in_array($sql_row131["order_tid"],$order_tid_ref2))
				{
					$order_tid_ref[]="'".$sql_row131["order_tid"]."'";
					$order_tid_ref2[]=$sql_row131["order_tid"];
					//echo $sql_row131["order_tid"]."-".implode(",",$order_tid_ref)."<br>";
				}
			}

			$order_tid_ref_implode=implode(",",$order_tid_ref);
			//echo $order_tid_ref_implode."<br>";
			
			$sql23="select group_concat(tid) as cat_tid from $bai_pro3.cat_stat_log where REPLACE(order_tid,\" \",\"\") in (".$order_tid_ref_implode.") and category in ($in_categories)";
			//echo $sql23."<br>";
			// mysqli_query($link, $sql23) or exit("Sql Error".$sql23."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result23=mysqli_query($link, $sql23) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row23=mysqli_fetch_array($sql_result23))
			{
				$cat_ref2=$sql_row23["cat_tid"];
			}
			
			$doc_remarks1=array();
			$sql41="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*a_plies AS doc_qty,doc_no,remarks FROM $bai_pro3.plandoc_stat_log WHERE cat_ref in (".$cat_ref2.") and act_cut_status=\"DONE\" GROUP BY doc_no";
			//echo $order_del_no."-".$sql4."<br>";
			$result41=mysqli_query($link, $sql41) or exit("Sql Error4".$sql41."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row41=mysqli_fetch_array($result41))
			{
				$doc_remarks1[]=$row41["remarks"];
			}
			$sql3="select group_concat(tid) as cat_tid from $bai_pro3.cat_stat_log where order_tid=\"".$order_tid."\" and category in ($in_categories)";
			// mysqli_query($link, $sql3) or exit("Sql Error".$sql3."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$cat_ref=$sql_row3["cat_tid"];
			}
			
			//echo $cat_ref."-".$order_del_no."<br>";
			$cut_total_qty=0;
			
			$doc_remarks=array();
			$sql4="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s06+p_s08+p_s10+p_s12+p_s14+p_s16+p_s18+p_s20+p_s22+p_s24+p_s26+p_s28+p_s30)*a_plies AS doc_qty,doc_no,remarks FROM $bai_pro3.plandoc_stat_log WHERE cat_ref in (".$cat_ref.") and act_cut_status=\"DONE\" GROUP BY doc_no";
			//echo $order_del_no."-".$sql4."<br>";
			$result4=mysqli_query($link, $sql4) or exit("Sql Error4".$sql4."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row4=mysqli_fetch_array($result4))
			{
				$cut_total_qty=$cut_total_qty+$row4["doc_qty"];
				$doc_remarks[]=$row4["remarks"];
			}
			
			$recut_total_qty=0;
			$sql5="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='cut' and sfcs_status in (30,60)";
			
			$result5=mysqli_query($link, $sql5) or exit("Sql Error5".$sql5."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row5=mysqli_fetch_array($result5))
			{
				$recut_total_qty=$row5["qty"];
			
			}
			
			$sql5_backup="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='cut' and sfcs_status in (30,60)";
			
			$result5_backup=mysqli_query($link, $sql5_backup) or exit("Sql Error5".$sql5_backup."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row5_backup=mysqli_fetch_array($result5_backup))
			{
				$recut_total_qty_backup=$row5_backup["qty"];
			
			}
			
			$recut_total_qty=$recut_total_qty+$recut_total_qty_backup;
			
			
			$recut_total_print_input_qty=0;
			$sql6="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='PS' and sfcs_status in (30,60)";
			
			$result6=mysqli_query($link, $sql6) or exit("Sql Error6".$sql6."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row6=mysqli_fetch_array($result6))
			{
				$recut_total_print_input_qty=$row6["qty"];
			
			}
			
			
			$sql6_backup="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='PS' and sfcs_status in (30,60)";
			
			$result6_backup=mysqli_query($link, $sql6_backup) or exit("Sql Error6".$sql6_backup."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row6_backup=mysqli_fetch_array($result6_backup))
			{
				$recut_total_print_input_qty_backup=$row6_backup["qty"];
			
			}
			
			$recut_total_print_input_qty=$recut_total_print_input_qty+$recut_total_print_input_qty_backup;
			
			
			$recut_total_input_qty=0;
			$sql6="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='SIN' and sfcs_status in (30,60)";
			
			$result6=mysqli_query($link, $sql6) or exit("Sql Error6".$sql6."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row6=mysqli_fetch_array($result6))
			{
				$recut_total_input_qty=$row6["qty"];
			
			}
			
			$sql6_backup="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='SIN' and sfcs_status in (30,60)";
			
			$result6_backup=mysqli_query($link, $sql6_backup) or exit("Sql Error6".$sql6_backup."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row6_backup=mysqli_fetch_array($result6_backup))
			{
				$recut_total_input_qty_backup=$row6_backup["qty"];
			
			}
			
			
			$recut_total_input_qty=$recut_total_input_qty+$recut_total_input_qty_backup;
			
			$recut_total_output_qty=0;
			$sql7="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='SOT' and sfcs_status in (30,60)";
			
			$result7=mysqli_query($link, $sql7) or exit("Sql Error7".$sql7."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row7=mysqli_fetch_array($result7))
			{
				$recut_total_output_qty=$row7["qty"];
			
			}
			
			
			$sql7_backup="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='SOT' and sfcs_status in (30,60)";
			
			$result7_backup=mysqli_query($link, $sql7_backup) or exit("Sql Error7".$sql7_backup."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row7_backup=mysqli_fetch_array($result7_backup))
			{
				$recut_total_output_qty_backup=$row7_backup["qty"];
			
			}
			
			$recut_total_output_qty=$recut_total_output_qty+$recut_total_output_qty_backup;
			
			$recut_total_print_output_qty=0;
			$sql8="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='PR' and sfcs_status in (30,60)";
			
			$result8=mysqli_query($link, $sql8) or exit("Sql Error8".$sql8."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row8=mysqli_fetch_array($result8))
			{
				$recut_total_print_output_qty=$row8["qty"];
			
			}
			
			$sql8_backup="SELECT sum(sfcs_qty) as qty FROM $m3_bulk_ops_rep_db.m3_sfcs_tran_log_backup where sfcs_schedule=".$order_del_no." and sfcs_job_no like '%R%' and m3_op_des='PR' and sfcs_status in (30,60)";
			
			$result8_backup=mysqli_query($link, $sql8_backup) or exit("Sql Error8".$sql8_backup."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row8_backup=mysqli_fetch_array($result8_backup))
			{
				$recut_total_print_output_qty_backup=$row8_backup["qty"];
			
			}
			
			$recut_total_print_output_qty=$recut_total_print_output_qty+$recut_total_print_output_qty_backup;
			
			if(($sql_row["order_embl_e"]+$sql_row["order_embl_f"]+$sql_row["order_embl_g"]+$sql_row["order_embl_h"]) > 0)
			{
				$form="Garment";
			}
			
			if(($sql_row["order_embl_a"]+$sql_row["order_embl_b"]+$sql_row["order_embl_c"]+$sql_row["order_embl_d"]) > 0)
			{
				$form="Panel";
			}			
			
			$sewing_in_qty=0;
			$sewing_in_qty1=0;
			$sewing_out_qty=0;
			$sewing_out_qty1=0;
			$emb_panel_in=0;
			$emb_panel_in1=0;
			$emb_panel_out=0;
			$emb_panel_out1=0;
			
			
			$sql2x="select COALESCE(SUM(ims_qty),0) as in_qty,COALESCE(SUM(ims_pro_qty),0) as out_qty from $bai_pro3.ims_log where ims_cid in (".$cat_ref.")  and ims_mod_no > 0";
			//echo $order_del_no."-".$sql2x."<br>";
			$sql_result2x=mysqli_query($link, $sql2x) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2x=mysqli_fetch_array($sql_result2x))
			{
				$sewing_in_qty=$sql_row2x["in_qty"];	
				$sewing_out_qty=$sql_row2x["out_qty"];					
			}
			
			$sql2xx="select COALESCE(SUM(ims_qty),0) as in_qty,COALESCE(SUM(ims_pro_qty),0) as out_qty from $bai_pro3.ims_log_backup where ims_cid in (".$cat_ref.") and ims_mod_no > 0";
			//echo $order_del_no."-".$sql2xx."<br>";
			$sql_result2xx=mysqli_query($link, $sql2xx) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2xx=mysqli_fetch_array($sql_result2xx))
			{
				$sewing_in_qty1=$sql_row2xx["in_qty"];	
				$sewing_out_qty1=$sql_row2xx["out_qty"];					
			}
			
			$sql3="SELECT COALESCE(SUM(ims_qty),0) AS emb_in FROM $bai_pro3.ims_log where ims_cid in (".$cat_ref.") AND ims_mod_no <= 0";
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$emb_panel_in=$sql_row3["emb_in"];
			}
			
			$sql3x="SELECT COALESCE(SUM(ims_qty),0) AS emb_in FROM $bai_pro3.ims_log_backup where ims_cid in (".$cat_ref.") AND ims_mod_no <= 0";
			$sql_result3x=mysqli_query($link, $sql3x) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3x=mysqli_fetch_array($sql_result3x))
			{
				$emb_panel_in1=$sql_row3x["emb_in"];
			}
			
			$sql3="SELECT COALESCE(SUM(ims_qty),0) AS emb_in FROM $bai_pro3.ims_log where ims_cid in (".$cat_ref.") AND ims_status IN (\"EPC\")";
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$emb_panel_out=$sql_row3["emb_in"];
			}
			
			$sql3x="SELECT COALESCE(SUM(ims_qty),0) AS emb_in FROM $bai_pro3.ims_log_backup where ims_cid in (".$cat_ref.") AND ims_status IN (\"EPC\")";
			$sql_result3x=mysqli_query($link, $sql3x) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3x=mysqli_fetch_array($sql_result3x))
			{
				$emb_panel_out1=$sql_row3x["emb_in"];
			}
			
			$scanned_qty=0;
			$sql321="SELECT COALESCE(SUM(carton_act_qty),0) as scan_qty FROM $bai_pro3.packing_summary where order_del_no=\"".$order_del_no."\" and order_col_des=\"".$order_col_des."\" and status=\"DONE\"";
			$sql_result321=mysqli_query($link, $sql321) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row321=mysqli_fetch_array($sql_result321))
			{
				$scanned_qty=$sql_row321["scan_qty"];
			}
			
			$emb_garment_in=0;
			$sql32="SELECT COALESCE(SUM(carton_act_qty),0) as emb_in FROM $bai_pro3.packing_summary where order_del_no=\"".$order_del_no."\" and order_col_des=\"".$order_col_des."\" and status in (\"EGR\",\"EGC\",\"EGI\")";
			$sql_result32=mysqli_query($link, $sql32) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row32=mysqli_fetch_array($sql_result32))
			{
				$emb_garment_in=$sql_row32["emb_in"];
			}
			
			$emb_garment_in1=0;
			$sql4="select COALESCE(sum(qms_qty),0) as qty from $bai_pro3.bai_emb_excess_db WHERE qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\"";
			$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4 =".$sql4."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row4=mysqli_fetch_array($sql_result4))
			{
				$emb_garment_in1=$sql_row4["qty"];
			}
			
			$emb_garment_out=0;
			$sql32x="SELECT COALESCE(SUM(carton_act_qty),0) as emb_out FROM $bai_pro3.packing_summary where order_del_no=\"".$order_del_no."\" and order_col_des=\"".$order_col_des."\" and status in (\"EGI\")";
			$sql_result32x=mysqli_query($link, $sql32x) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row32x=mysqli_fetch_array($sql_result32x))
			{
				$emb_garment_out=$sql_row32x["emb_out"];
			}
			
			$emb_garment_out1=0;
			$sql4="select COALESCE(sum(qms_qty),0) as qty from $bai_pro3.bai_qms_db WHERE qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\" and qms_tran_type=5 and remarks=\"ENP\"";
			$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4 =".$sql4."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row4=mysqli_fetch_array($sql_result4))
			{
				$emb_garment_out1=$sql_row4["qty"];
			}
			
			$rejection_qty=0;
			$sql4="select COALESCE(sum(qms_qty),0) as qty from $bai_pro3.bai_qms_db WHERE qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\" and SUBSTRING_INDEX(remarks,'-',1)=\"ENP\" AND qms_tran_type=3";
			$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4 =".$sql4."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row4=mysqli_fetch_array($sql_result4))
			{
				$rejection_qty=$sql_row4["qty"];
			}
			
			$rejection_qty1=0;
			$sql41="select COALESCE(sum(qms_qty),0) as qty from $bai_pro3.bai_qms_db_archive WHERE qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\" and SUBSTRING_INDEX(remarks,'-',1)=\"ENP\" AND qms_tran_type=3";
			$sql_result41=mysqli_query($link, $sql41) or exit("Sql Error4 =".$sql41."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row41=mysqli_fetch_array($sql_result41))
			{
				$rejection_qty1=$sql_row41["qty"];
			}
			
			$good_exc_qty=0;
			$sql4x="select COALESCE(sum(qms_qty),0) as qty from $bai_pro3.bai_qms_db WHERE qms_schedule=\"".$order_del_no."\" and qms_color=\"".$order_col_des."\" and remarks=\"FG\" AND qms_tran_type=5";
			$sql_result4x=mysqli_query($link, $sql4x) or exit("Sql Error4 =".$sql4."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row4x=mysqli_fetch_array($sql_result4x))
			{
				$good_exc_qty=$sql_row4x["qty"];
			}			
			
			$style_letter=substr($order_style_no,0,1);

			//TO IDENTIFY THE VS PINK STYLES WITH STARTING LETTER P,K
			if($style_letter == "P" or $style_letter == "K")
			{
				$buyer_id="VS Pink";
			}

			//TO IDENTIFY THE VS LOGO STYLES WITH STARTING LETTER L,O
			if($style_letter == "L" or $style_letter == "O")
			{
				$buyer_id="VS Logo";
			}	

			//TO IDENTIFY THE GLAMOUR STYLES WITH STARTING LETTER G,U
			if($style_letter == "G" or $style_letter == "U")
			{
				$buyer_id="Glamour";
			}	

			//TO IDENTIFY THE LBI STYLES WITH STARTING LETTER Y
			if($style_letter == "Y")
			{
				$buyer_id="LBI";
			}	
			
			//TO IDENTIFY THE M&S STYLES WITH BUYER DIVISION IDENTIFICATION
			if($style_letter == "M")
			{
				//$buyer_id="M&S";
				$sql="select * from $bai_pro3.bai_orders_db where order_del_no=\"".$style."\" AND order_div LIKE \"%T61%\"";
				// echo $sql."<br>";
				$result=mysqli_query($link, $sql) or mysqli_error("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
				//IF COUNT OF T61 STYLE > 0 STYLE CODE IS MS-T61 ELSE STYLE CODE IS MS-T14
				if(mysqli_num_rows($result) > 0)
				{
					$buyer_id="MS-T61";	
				}
				else
				{
					$buyer_id="MS-T14";
				}
			}		
			
			echo "<tr>";
			
			echo "<td>".$buyer_id."</td>";
			echo "<td>".$order_style_no."</td>";
			echo "<td>".$order_del_no."</td>";
			echo "<td>".$order_col_des."</td>";
			echo "<td>".$form."</td>";
			if(in_array("Pilot",$doc_remarks1))
			{
				echo "<td style='background-color:#00FF00'>".$garmnet_desc."</td>";
			}
			else
			{
				echo "<td>".$garmnet_desc."</td>";
			}
			if(in_array("Pilot",$doc_remarks1))
			{
				echo "<td style='background-color:#00FF00'>".$garmnet_details."</td>";
			}
			else
			{
				echo "<td>".$garmnet_details."</td>";
			}
			//echo "<td>".$garmnet_details."</td>";
			$date=$psd;
			
			for($i=1;$i<=6;$i++)
			{
				$date_explode=explode("-",$date);
				$weekday= strtolower(date('l', strtotime($date)));
				$diff=1;
				if($weekday=="sunday")
				{
					$diff=2;
				}
				$date=date("Y-m-d",mktime(0, 0, 0, $date_explode[1]  , $date_explode[2]-$diff,  $date_explode[0]));
				$date=$date;
				//echo "<br>".$order_del_no."-".$i."-".$date."-".$weekday."<br>";
			}
			if(in_array("Pilot",$doc_remarks))
			{
				echo "<td>".$date."</td>";
			}
			else
			{
				echo "<td>".$date."</td>";
			}
			echo "<td>".$psd."</td>";
			echo "<td>".$ex_factory."</td>";
			echo "<td>".$total_ord."</td>";
			echo "<td>".($cut_total_qty+$recut_total_qty)."</td>";
			
			if($form=="Garment")
			{
				echo "<td>".($emb_garment_in+$scanned_qty+$emb_garment_in1+$good_exc_qty)."</td>";
			}
			if($form=="Panel")
			{
				echo "<td>".($sewing_in_qty+$sewing_in_qty1+$emb_panel_in+$emb_panel_in1+$recut_total_print_input_qty)."</td>";
			}			
			
			echo "<td>".($sewing_in_qty+$sewing_in_qty1+$recut_total_input_qty)."</td>";
			echo "<td>".($sewing_out_qty+$sewing_out_qty1+$recut_total_output_qty)."</td>";
			
			if($form=="Garment")
			{
				echo "<td>".($emb_garment_out+$scanned_qty+$good_exc_qty)."</td>";
			}
			
			if($form=="Panel")
			{
				echo "<td>".($sewing_in_qty+$sewing_in_qty1+$emb_panel_out+$recut_total_print_output_qty)."</td>";
			}

			echo "<td>".($rejection_qty1+$rejection_qty+$emb_garment_out1)."</td>";
			echo "<td>".($scanned_qty)."</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	echo "</div>";
	if($row_count == 0){
		echo "<div class=' col-sm-12'><p class='alert alert-danger'>No Data Found</p></div><script>$('#main_content').hide();</script>";
	}
}
?>


<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_35: "select",
	sort_select: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
</script> 

<script>
$("#show").click(function () {
    var startDate = document.getElementById("demo1").value;
    var endDate = document.getElementById("demo2").value;

    if ((Date.parse(startDate) > Date.parse(endDate))) {
        sweetAlert("End date should be greater than Start date");
        document.getElementById("demo2").value = "";
    }else{
		document.getElementById('show').style.display='none'; 
		document.getElementById('msg').style.display='';
	}
});
</script>

</div>
</div>
</div>
</body>

<style>
td,th{
	color : #000;
}
</style>

