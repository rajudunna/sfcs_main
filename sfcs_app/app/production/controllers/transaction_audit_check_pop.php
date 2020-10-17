<?php  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));   ?>
<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
//08-09-2016/removed user_acl in the page
$plantcode=$_SESSION['plantCode'];
?>
<html>
<head>
<title>POP: Transaction Audit Log</title>
<style type="text/css" media="screen">
@import "<?= getFullURLLevel($_GET['r'],'common/js/filtergrid.css',3,'R');?>";
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R');?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R');?>"></script>


<script>
function popitup(url) {

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0');
if (window.focus) {newwindow.focus();}
return false;
}
</script>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',1,'R'); ?>" type="text/css" media="all" />

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

</head>


<body>

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
 ?>
 <div class="panel panel-primary" style="height:130px;">
<div class="panel-heading" style="height:40px;"><span style="float: left"><h3 style="margin-top: -2px;">Quick Transaction Audit</h3></span></div>
<?php
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$shift=$_POST['shift'];
	$module=$_POST['module'];
	
?>

<form name="text" method="post" action="<?= getFullURLLevel($_GET['r'],'transaction_audit_check_pop.php',0,'N'); ?>" style="padding-top: 11px;">
<div class="col-md-2">
Select Schedule : <input type="text" class="form-control" name="schedule" value="<?php echo $_POST['schedule']; ?>" size="10"> 
</div>
<input type="submit" value="submit" name="submit" class="btn btn-success" style="margin-top: 19px;">
</form>
</div>

<?php
if(isset($_POST['submit']))
{
	$schedule=$_POST['schedule'];
	echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	ob_end_flush();
	flush();
	usleep(10);
	//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
	// echo "<h2>Production Status</h2>";
	$url1=getFullURLLevel($_GET['r'],'transaction_audit_schedule.php',0,'R');
	//echo "<br/><h3><a href=\"$url1?schedule=$schedule\" onclick=\"return popitup("."'"."$url1?schedule=$schedule"."'".")\" class='btn btn-success' style=\"margin-top: -35px;\">Production Status</a></h3><br/>";
	//if($username=="kirang")
	{
		include("transaction_audit_recon_check.php");
	}

	// docket movement track
	echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\"><h2>Plan Board Transaction Log</h2></div>";
	echo "<table id=\"table10\" border=1 class='table table-bordered'>";
	echo "<tr><th>Docket ID</th><th width=\"150\">What</th><th>Who</th><th>When</th></tr>";
	// getting docket line ids for a schedule
	$sql_docket = "SELECT DISTINCT dl.jm_docket_line_id, dl.`docket_line_number` FROM $pps.`jm_docket_lines` dl
	LEFT JOIN $pps.`jm_docket_bundle` db ON db.`jm_docket_line_id` = dl.`jm_docket_line_id`
	LEFT JOIN $pps.`jm_docket_logical_bundle` dlb ON dlb.`jm_docket_bundle_id` = db.`jm_docket_bundle_id`
	LEFT JOIN $pps.`jm_product_logical_bundle` plb ON plb.`jm_pplb_id` = dlb.`jm_pplb_id`
	WHERE plb.`feature_value` = '$schedule'";
	$sql_result_sql_docket=mysqli_query($link,$sql_docket) or exit("Sql Error15".mysqli_error());
	while($sql_row_docket=mysqli_fetch_array($sql_result_sql_docket))
	{
		$task_job_ref = $sql_row_docket['jm_docket_line_id'];
		$sql="SELECT th.resource_id, th.created_user, th.created_at FROM $tms.`task_jobs` tj LEFT JOIN $tms.`task_header` th ON th.`task_header_id` = tj.`task_header_id`
		WHERE th.`resource_id` IS NOT NULL AND `task_job_reference` = '$task_job_ref'";
		mysqli_query($link,$sql) or exit("Sql Error14".mysqli_error());
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error15".mysqli_error());
		while($sql_row_work=mysqli_fetch_array($sql_result))
		{
				$workstation = $sql_row_work['resource_id'];
				$qry_workstation_type="SELECT workstation_code FROM $pms.workstation where  workstation_id = '$workstation'";
				$workstation_type_result=mysqli_query($link, $qry_workstation_type) or exit("Sql Error at workstation type".mysqli_error($GLOBALS["___mysqli_ston"]));
				$workstation_typet_num=mysqli_num_rows($workstation_type_result);
				if($workstation_typet_num>0){
				while($workstaton_type_row=mysqli_fetch_array($workstation_type_result))
				{
					$workstationCode = $workstaton_type_row['workstation_code'];
				}	
				echo "<tr>";
				echo "<td>".$sql_row_docket['docket_line_number']."</td>";
				echo "<td>".$workstationCode."</td>";
				echo "<td>".$sql_row_work['created_user']."</td>";
				echo "<td>".$sql_row_work['created_at']."</td>";
				echo "</tr>";
			}
		}
	}

echo "</table>";
echo "</div>";
?>

<?php

echo "<div class='table-responsive'><div class=\"panel panel-primary\" style=\"width:2000px\"><div class=\"panel-heading\"><h2>BAI Log</h2></div>";
echo "<table id=\"table1\" border=1 class='table table-bordered'>";
echo "<tr><th>Date</th><th>Module</th><th>Section</th><th>Shift</th><th>User Style</th><th>Movex Style</th><th>Schedule</th><th>Color</th><th>Qty</th><th>SMV</th><th>NOP</th>";
$sql_pts_trans_out = "SELECT DATE(trans.created_at)as created_at,SUM(good_quantity)AS good_qty, SUM(rejected_quantity)AS rej_qty, resource_id, shift, barcode,style,color
FROM $pts.`transaction_log` trans 
WHERE  trans.schedule = '$schedule' AND trans.`barcode_type` = 'APLB' 
AND operation = '130' GROUP BY style,color,DATE(trans.created_at),barcode,operation,resource_id,shift";
$sql_result_sql_pts_trans_out=mysqli_query($link,$sql_pts_trans_out) or exit("Sql Error5".mysqli_error());
$tot1 = 0;
while($sql_row_pts_trans_out = mysqli_fetch_array($sql_result_sql_pts_trans_out))
{
	$out_put_qty = $sql_row_pts_trans_out['good_qty'];
	$rejected_qty += $sql_row_pts_trans_out['rej_qty'];
	$workstation = $sql_row_pts_trans_out['resource_id'];
	$date = $sql_row_pts_trans_out['created_at'];
	$shift =  $sql_row_pts_trans_out['shift'];
	$fg_color = $sql_row_pts_trans_out['color'];
	$style = $sql_row_pts_trans_out['style'];
	$userstyle = $style;
	$smv = 0;
	$qry_workstation_type="SELECT workstation_code, sec.section_code FROM $pms.workstation wrk LEFT JOIN $pms.sections sec on sec.section_id = wrk.section_id where  workstation_id = '$workstation'";
	$workstation_type_result=mysqli_query($link, $qry_workstation_type) or exit("Sql Error at workstation type".mysqli_error($GLOBALS["___mysqli_ston"]));
	$workstation_typet_num=mysqli_num_rows($workstation_type_result);
	if($workstation_typet_num>0) {
		while($workstaton_type_row=mysqli_fetch_array($workstation_type_result))
		{
			$workstationCode = $workstaton_type_row['workstation_code'];
			$section_code = $workstaton_type_row['section_code'];
		}
		$plan_qry = "SELECT capacity_factor AS nop, smv, product_code as style FROM $pps.`monthly_production_plan`  
		WHERE row_name = '$workstationCode' AND planned_date like '%$date'  AND order_code = '$schedule' AND colour = '$fg_color'";
		$plan_qry_result=mysqli_query($link, $plan_qry) or exit("Sql Error at workstation type".mysqli_error($GLOBALS["___mysqli_ston"]));
		$plan_qry_num=mysqli_num_rows($plan_qry_result);
		if($plan_qry_num>0){
			while($plan_qry_row=mysqli_fetch_array($plan_qry_result))
			{
				$nop = $plan_qry_row['nop'];
				$smv = $plan_qry_row['smv'];
			}
		}
		$tot1 += $out_put_qty;
		echo "<tr bgcolor=\"$bgcolor\">";
		//echo "<td>$tid</td>";
		echo "<td>$date</td>";
		echo "<td>$workstationCode</td>";
		echo "<td>$section_code</td>";
		echo "<td>$shift</td>";
		echo "<td>$userstyle</td>";
		echo "<td>$style</td>";
		echo "<td>$schedule</td>";
		echo "<td>$fg_color</td>";
		// echo "<td>".chr($color_code).leading_zeros($cutno,3)."</td>";
		// echo "<td>$doc_no</td>";
		echo "<td>$out_put_qty</td>";
		echo "<td>".$smv."</td>";
		echo "<td>".$nop."</td>";
		echo "</tr>";
	}
}
$count_val = 0;	
echo "<tr><td colspan=\"8\">Output Total:</td><td id=\"table1Tot1\" style=\"background-color:#FFFFCC; color:red;\">".$tot1."
</td></tr>";

echo "</table>";
echo"</div>";
echo"</div>";
echo"</br>";

?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var totRowIndex = tf_Tag(tf_Id('table1'),"tr").length;  
	var fnsFilters = {
	
		rows_counter: true,  
	    sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader: true,
		loader_text: "Filtering data...",
		btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	    col_operation: { 
						id: ["table1Tot1"],
						 col: [10],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] ,
						exclude_row: [totRowIndex],  
                         decimal_precision: [1,0] 

					},
		rows_always_visible: [totRowIndex]  
							
	
		
	};
	var tf7 = setFilterGrid("table1", fnsFilters);
	 setFilterGrid("table1");
	setFilterGrid( "table10" );
//]]>
</script>
<?php

// echo "<div class='table-responsive'><div class=\"panel panel-primary\" style=\"width:1500px;\"><div class=\"panel-heading\" ><h2>IMS Log</h2></div>";

// echo "<table id=\"table111\" border=1 class=\"table table-bordered\">";
// echo "<tr><th>Input Date</th><th>Layplan ID</th><th>Dockete</th><th>Module</th><th>Shift</th><th>Size</th><th>Input Qty</th><th>Output Qty</th><th>Status</th><th>Bai Log Ref</th><th>Last Update</th><th>Remarks</th><th>Style</th><th>Schedule</th><th>Color</th><th>IMS Tid</th><th>Random Track</th></tr>";

// $sql="select * from $bai_pro3.ims_log where ims_schedule=\"$schedule\"";
// mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
// $sql_result=mysqli_query($link,$sql) or exit("Sql Error7".mysqli_error());
// $count=mysqli_num_rows($sql_result); 
// while($sql_row=mysqli_fetch_array($sql_result))
// {
// $ims_date=$sql_row['ims_date'];
// $ims_cid=$sql_row['ims_cid'];
// $ims_doc_no=$sql_row['ims_doc_no'];
// $ims_mod_no=$sql_row['ims_mod_no'];
// $ims_shift=$sql_row['ims_shift'];
// $ims_size=$sql_row['ims_size'];
// $ims_qty=$sql_row['ims_qty'];
// $ims_pro_qty=$sql_row['ims_pro_qty'];
// $ims_status=$sql_row['ims_status'];
// $bai_pro_ref=$sql_row['bai_pro_ref'];
// $ims_log_date=$sql_row['ims_log_date'];
// $ims_remarks=$sql_row['ims_remarks'];
// $ims_style=$sql_row['ims_style'];
// $ims_schedule=$sql_row['ims_schedule'];
// $ims_color=$sql_row['ims_color'];
// $tid=$sql_row['tid'];
// $rand_track=$sql_row['rand_track'];
// $size1=str_replace("a_","",$sql_row['ims_size']);
// 		$size2=str_replace("s","",$size1);
// 		$sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."'";
			
// 		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
// 		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
// 		for($s=0;$s<sizeof($count);$s++)
// 			{
				
// 				if($sql_row1["title_size_s".$size2.""]<>'')
// 				{
// 					$s_tit=$sql_row1["title_size_s".$size2.""];
// 				}	
				

// echo "<tr><td>".$sql_row['ims_date']."</td><td>".$sql_row['ims_cid']."</td><td>".$sql_row['ims_doc_no']."</td><td>".$sql_row['ims_mod_no']."</td><td>".$sql_row['ims_shift']."</td><td>".$s_tit."</td><td>".$sql_row['ims_qty']."</td><td>".$sql_row['ims_pro_qty']."</td><td>".$sql_row['ims_status']."</td><td>".$sql_row['bai_pro_ref']."</td><td>".$sql_row['ims_log_date']."</td><td>".$sql_row['ims_remarks']."</td><td>".$sql_row['ims_style']."</td><td>".$sql_row['ims_schedule']."</td><td>".$sql_row['ims_color']."</td><td>".$sql_row['tid']."</td><td>".$sql_row['rand_track']."</td></tr>";
// $input_total_qty+=$sql_row['ims_qty'];
// $input_total_qty1=$input_total_qty;
// $output_total_qty+=$sql_row['ims_pro_qty'];
// $output_total_qty1=$output_total_qty;


// 			}
// 		}
// }
// $total_output_qty = 0;
// $tot4 = 0;
// $sql="select * from $pms.ims_log_backup where plant_code='$plantcode' and ims_schedule=\"$schedule\" order by ims_mod_no";
// mysqli_query($link,$sql) or exit("Sql Error8".mysqli_error());
// $sql_result=mysqli_query($link,$sql) or exit("Sql Error9".mysqli_error());
// $count1=mysqli_num_rows($sql_result); 
// while($sql_row=mysqli_fetch_array($sql_result))
// {
// $ims_date=$sql_row['ims_date'];
// $ims_cid=$sql_row['ims_cid'];
// $ims_doc_no=$sql_row['ims_doc_no'];
// $ims_mod_no=$sql_row['ims_mod_no'];
// $ims_shift=$sql_row['ims_shift'];
// $ims_size=$sql_row['ims_size'];
// $ims_qty=$sql_row['ims_qty'];
// $ims_pro_qty=$sql_row['ims_pro_qty'];
// $ims_status=$sql_row['ims_status'];
// $bai_pro_ref=$sql_row['bai_pro_ref'];
// $ims_log_date=$sql_row['ims_log_date'];
// $ims_remarks=$sql_row['ims_remarks'];
// $ims_style=$sql_row['ims_style'];
// $ims_schedule=$sql_row['ims_schedule'];
// $ims_color=$sql_row['ims_color'];
// $tid=$sql_row['tid'];
// $rand_track=$sql_row['rand_track'];
// $size3=str_replace("a_","",$sql_row['ims_size']);
// $size4=str_replace("s","",$size3);
// $sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."'";
			
// 		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
// 		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
// 		for($s=0;$s<sizeof($count1);$s++)
// 			{
				
// 				if($sql_row1["title_size_s".$size4.""]<>'')
// 				{
// 					$s_tit=$sql_row1["title_size_s".$size4.""];
// 				}	
			
// echo "<tr><td>".$sql_row['ims_date']."</td><td>".$sql_row['ims_cid']."</td><td>".$sql_row['ims_doc_no']."</td><td>".$sql_row['ims_mod_no']."</td><td>".$sql_row['ims_shift']."</td><td>".$s_tit."</td><td>".$sql_row['ims_qty']."</td><td>".$sql_row['ims_pro_qty']."</td><td>".$sql_row['ims_status']."</td><td>".$sql_row['bai_pro_ref']."</td><td>".$sql_row['ims_log_date']."</td><td>".$sql_row['ims_remarks']."</td><td>".$sql_row['ims_style']."</td><td>".$sql_row['ims_schedule']."</td><td>".$sql_row['ims_color']."</td><td>".$sql_row['tid']."</td><td>".$sql_row['rand_track']."</td></tr>";
// $input_total_qty+=$sql_row['ims_qty'];
// $input_total_qty1=$input_total_qty;
// $output_total_qty+=$sql_row['ims_pro_qty'];
// $output_total_qty1=$output_total_qty;
// 			}
// 		}
// }
	
// echo "<tr><td>Input Total:</td><td id=\"table111Tot1\" style=\"background-color:#FFFFCC; color:red;\">".$input_total_qty."</td><td>Output Total:</td><td id=\"table111Tot2\" style=\"background-color:#FFFFCC; color:red;\">".$output_total_qty1."</td></tr>";
// echo "</table>";
// echo"</div>";
// echo"</div>";
// echo "</br>";

// ?>
 <script language="javascript" type="text/javascript">
// //<![CDATA[
// 	//setFilterGrid( "table111" );
// var fnsFilters = {
	
// 	rows_counter: true,
// 	sort_select: true,
// 		on_change: true,
// 		display_all_text: " [ Show all ] ",
// 		loader_text: "Filtering data...",  
// 	loader: true,
// 	loader_text: "Filtering data...",
// 	btn_reset: true,
// 		alternate_rows: true,
// 		btn_reset_text: "Clear",
// 	col_operation: { 
// 						id: ["table111Tot1","table111Tot2"],
// 						 col: [6,7],  
// 						operation: ["sum","sum"],
// 						 decimal_precision: [1,1],
// 						write_method: ["innerHTML","innerHTML"] 
// 					},
// 	rows_always_visible: [grabTag(grabEBI('table111'),"tr").length]
							
	
		
// 	};
	
// 	 setFilterGrid("table111");
// //]]>
// </script>

 <?php

// echo "</table>";

// echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\"><h2>Packing Log</h2></div>";

// echo "<table id=\"table1111\" border=1 class=\"table table-bordered\">";
// echo "<tr><th>Docket</th><th>Docket Ref</th><th>TID</th><th>Size</th><th>Remarks</th><th>Status</th><th>Last Updated</th><th>Carton Act Qty</th><th>Style</th><th>Schedule</th><th>Color</th></tr>";
// $packing_tid_list=array();
// $sql="select * from $bai_pro3.packing_summary where order_del_no=\"$schedule\" order by size_code,carton_act_qty desc,tid";
// mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
// $sql_result=mysqli_query($link,$sql) or exit("Sql Error11".mysqli_error());
// $count2=mysqli_num_rows($sql_result); 
// $carton_act_qty2=0;
// while($sql_row=mysqli_fetch_array($sql_result))
// {

// $doc_no=$sql_row['doc_no'];
// $doc_no_ref=$sql_row['doc_no_ref'];
// $tid=$sql_row['tid'];
// $packing_tid_list[]=$sql_row['tid'];
// $size_code=$sql_row['size_code'];
// $remarks=$sql_row['remarks'];
// $status=$sql_row['status'];
// $lastup=$sql_row['lastup'];
// $container=$sql_row['container'];
// $disp_carton_no=$sql_row['disp_carton_no'];
// $disp_id=$sql_row['disp_id'];
// $carton_act_qty=$sql_row['carton_act_qty'];
// $audit_status=$sql_row['audit_status'];
// $order_style_no=$sql_row['order_style_no'];
// $order_del_no=$sql_row['order_del_no'];
// $order_col_des=$sql_row['order_col_des'];
// $size5=str_replace("a_","",$sql_row['size_code']);
// $size6=str_replace("s","",$size5);
// $sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['order_style_no']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['order_col_des']."'";
			
// 		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
// 		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
// 		for($s=0;$s<sizeof($count1);$s++)
// 			{
				
// 				if($sql_row1["title_size_s".$size6.""]<>'')
// 				{
// 					$s_tit=$sql_row1["title_size_s".$size6.""];
// 				}	
// echo "<tr><td>".$sql_row['doc_no']."</td><td>".$sql_row['doc_no_ref']."</td><td>".$sql_row['tid']."</td><td>".$s_tit."</td><td>".$sql_row['remarks']."</td><td>".(strlen($sql_row['status'])==0?"Pending":$sql_row['status'])."</td><td>".$sql_row['lastup']."</td><td>".$sql_row['carton_act_qty']."</td><td>".$sql_row['order_style_no']."</td><td>".$sql_row['order_del_no']."</td><td>".$sql_row['order_col_des']."</td>
// </tr>";
// $carton_act_qty2+=$sql_row['carton_act_qty'];
// $carton_act_qty3=$carton_act_qty2;

// 			}
// 		}
// }
// echo "<tr><td>Total:</td><td id=\"table1111Tot1\" style=\"background-color:#FFFFCC; color:red;\">".$carton_act_qty3."</td></tr>";
// echo "</table>";
// echo "</div>";

// if($username=="kirang")
// {
// 	echo implode($packing_tid_list,",");
// }

// ?>


 <script language="javascript" type="text/javascript">
// //<![CDATA[
// 	setFilterGrid( "table1111" );

// var fnsFilters = {
	
// 	rows_counter: true,
// 	sort_select: true,
// 		on_change: true,
// 		display_all_text: " [ Show all ] ",
// 		loader_text: "Filtering data...",  
// 	loader: true,
// 	loader_text: "Filtering data...",
// 	btn_reset: true,
// 		alternate_rows: true,
// 		btn_reset_text: "Clear",
// 	col_operation: { 
// 						id: ["table1111Tot1"],
// 						 col: [7],  
// 						operation: ["sum"],
// 						 decimal_precision: [1],
// 						write_method: ["innerHTML"] 
// 					},
// 	rows_always_visible: [grabTag(grabEBI('table1111'),"tr").length]
							
	
		
// 	};
	
// 	 setFilterGrid("table1111",fnsFilters);
// //]]>
// </script>

 <?php
// //Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
// echo "<h2>Packing Check List</h2>";
// $url2=getFullURLLevel($_GET['r'],'packing_check_list.php',0,'R');
// echo "<br/><h3><a href=\"$url2?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\" onclick=\"return popitup("."'"."$url2?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create"."'".")\" class=\"btn btn-success\" style=\"margin-top: -35px;\">Carton Track</a></h3><br/>";

// ?>



 <?php
// //Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
// echo "<div class='table-responsive'><div class=\"panel panel-primary\" style=\"width:1500px;\"><div class=\"panel-heading\"><h2>AOD Details</h2></div>";
// echo "<table id=\"table11111\" border=1 class=\"table table-bordered\">";
// echo "<tr><th>order tid</th><th>update</th><th>remarks</th><th>status</th><th>style</th><th>schedule</th>";
// $sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" group by order_del_no";
// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// if(mysqli_num_rows($sql_result)>0)
// {
// 	$ord_tbl_name="$bai_pro3.bai_orders_db_confirm";	
// }
// else{
// 	$ord_tbl_name="$bai_pro3.bai_orders_db";		
// }
// $count_val1  = 0;
// $sql1="select * from $ord_tbl_name where order_del_no=\"$schedule\" group by order_del_no";
// $sql_result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row10=mysqli_fetch_array($sql_result))
// {
// 	for($s=0;$s<sizeof($sizes_code);$s++)
// 	{
// 		if($sql_row10["title_size_s".$sizes_code[$s].""]<>'')
// 		{
// 			$count_val1++;
// 			$s_tit=$sql_row10["title_size_s".$sizes_code[$s].""];
// 			echo " <th>".$sql_row10["title_size_s".$sizes_code[$s].""]."</th>";
			
// 		}	
// 	}
// }
// echo "<th>tid</th><th>cartons</th><th>AOD no</th><th>lastup</th><th>Total QTY</th></tr>";
// $sql="select * from $pps.ship_stat_log where plant_code='$plantcode' and ship_schedule=$schedule";
// mysqli_query($link,$sql) or exit("Sql Erro12r".mysqli_error());
// $sql_result=mysqli_query($link,$sql) or exit("Sql Error13".mysqli_error());
// while($sql_row=mysqli_fetch_array($sql_result))
// {
// 	echo "<tr><td>".$sql_row["ship_order_tid"]."</td>
// <td>".$sql_row["ship_up_date"]."</td>
// <td>".$sql_row["ship_remarks"]."</td>
// <td>".$sql_row["ship_status"]."</td>
// <td>".$sql_row["ship_style"]."</td>
// <td>".$sql_row["ship_schedule"]."</td>";
// for($s=0;$s<$count_val1;$s++){
// 	echo "<td>".$sql_row["ship_s_s".$sizes_code[$s].""]."</td>";
// 	$tot+=$sql_row["ship_s_s".$sizes_code[$s].""];
// }
// echo"<td>".$sql_row["ship_tid"]."</td>
// <td>".$sql_row["ship_cartons"]."</td>
// <td>".$sql_row["disp_note_no"]."</td>
// <td>".$sql_row["last_up"]."</td>
// <td>".$tot."</td></tr>";

// }
// echo "</table>";
echo "</div>";
echo "</div>";
?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid( "table11111" );
//]]>
</script>
<?php


}
?>
<script>
	document.getElementById("msg").style.display="none";		
</script>


</body>
</html>
