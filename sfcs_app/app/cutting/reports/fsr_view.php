<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/menu_content.php',1,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/header_scripts.php',1,'R')); 
$table_csv = '../'.getFullURLLevel($_GET['r'],'common/js/table2CSV.js',1,'R');
$excel_form_action = '../'.getFullURLLevel($_GET['r'],'common/php/export_excel.php',1,'R');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
// $plantcode='AIP';

?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="../common/filelist.xml">

<style id="Book2_18241_Styles">
.black{
	color : #000;
	text-align : right;
}
th{
	color : #000;
}
</style>
<script type="text/javascript">
function verify_date(){
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}

</script>

<script src="js/cal.js"></script>
<script type="text/javascript" src="<?php echo $table_csv ?>" ></script>	

<?php
if(isset($_POST['submit'])) {
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$section=$_POST['section'];
	$shift=$_POST['shift'];
	$reptype=$_POST['reptype'];
	$cat=$_POST['cat'];
} else {
	$from_date='';
	$to_date='';
	$section='';
	$shift='';
	$reptype='';
	$cat='';
}
?>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>Fabric Saving Report</b>
	</div>
	<div class="panel-body">
		<form method="post" name="input" action="?r=<?php echo $_GET['r']; ?>">
			<div class="col-sm-2">
				<label for='from_date'>Start Date : </label>
				<input class='form-control' type="text" id="sdate"  data-toggle="datepicker" name="from_date" size="8" value="<?php  if(isset($_POST['from_date'])) { echo $_POST['from_date']; } else { echo date("Y-m-d"); } ?>" />
			</div>
			<div class="col-sm-2">
				<label for='to_date'>End Date : </label>
				<input class='form-control' type="text" data-toggle="datepicker" id="edate" onchange="return verify_date();" name="to_date" size="8" value="<?php  if(isset($_POST['to_date'])) { echo $_POST['to_date']; } else { echo date("Y-m-d"); } ?>" />
			</div>
			<?php
			$workstation_type_id = array();
			$sqlxx="select workstation_type_id from $pms.workstation_type where plant_code='$plantcode' and workstation_type_description='Cutting'";
			$sql_resultx1=mysqli_query($link, $sqlxx) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				 $workstation_type_id[] =$sql_rowx1['workstation_type_id'];
			}
			$workstation_type_id = implode("','",$workstation_type_id);
			?>
			<div class='col-md-2'>
				<label>Section: </label>
				<select name="section" class="select2_single form-control">
				<option value='All' <?php if($section=="All"){ echo "selected"; } ?> >All</option>
				<?php 
				$sqly="SELECT workstation_id,workstation_description FROM $pms.workstation where workstation_type_id in ('$workstation_type_id') and plant_code='$plantcode'";
				$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowy=mysqli_fetch_array($sql_resulty))
				{
					$workstation_id=$sql_rowy['workstation_id'];
					$workstation_description=$sql_rowy['workstation_description'];
					$workstation_id1[]=$sql_rowy['workstation_id'];
					$workstation_description1[$sql_rowy['workstation_id']]=$sql_rowy['workstation_description'];
					if($section==$workstation_id) 
					{
						echo "<option value=\"".$workstation_id."\" selected>".$workstation_description."</option>";  
					} 
					else 
					{
						echo "<option value=\"".$workstation_id."\" >".$workstation_description."</option>"; 
					}
				}
				?>
				</select>
			</div>
			<div class='col-sm-2'>
                Shift :<select class='form-control' id='shift' name='shift' required>
				<option value=''>Select</option>
				<?php
					$shift_sql="SELECT shift_id,shift_code FROM $pms.shifts where plant_code = '$plantcode' and is_active=1";
					$shift_sql_res=mysqli_query($link, $shift_sql) or exit("Sql Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($shift_row = mysqli_fetch_array($shift_sql_res))
					{
						$shifts=$shift_row['shift_code'];
						if($shift==$shifts) 
						{
							echo "<option value='".$shifts."' selected>".$shifts."</option>"; 
						} else {
							echo "<option value='".$shifts."' >".$shifts."</option>"; 
						}
					}
				?>
              </select></div>
			<?php
				$all_cats = array();
				$all_cat_query = "select fabric_category_id,fabric_category_code from $mdm.fabric_category where is_active=true";
				$cat_result_all = mysqli_query($link,$all_cat_query) or exit('Unable to load Categories all');
				while($res = mysqli_fetch_array($cat_result_all)){
					$all_cats[] = $res['fabric_category_id'];
				}
				$all_cats = implode(",",$all_cats);
			?>
			<div class='col-md-2'>
				<label>Category: </label>
				<select name="cat" class="select2_single form-control">
				<option value='All' <?php if($cat=="All"){ echo "selected"; } ?> >All</option>
				<?php 
				$sqlyy="SELECT fabric_category_id,fabric_category_code FROM $mdm.fabric_category where is_active=true";
				$sql_resultyy=mysqli_query($link, $sqlyy) or exit("Sql Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowyy=mysqli_fetch_array($sql_resultyy))
				{
					$fabric_category_id=$sql_rowyy['fabric_category_id'];
					$fabric_category_code=$sql_rowyy['fabric_category_code'];
					$fabric_category_id1[]=$sql_rowyy['fabric_category_id'];
					$fabric_category_code1[$sql_rowyy['fabric_category_id']]=$sql_rowyy['fabric_category_code'];
					if($cat==$fabric_category_id) 
					{
						echo "<option value=\"".$fabric_category_id."\" selected>".$fabric_category_code."</option>";  
					} 
					else 
					{
						echo "<option value=\"".$fabric_category_id."\" >".$fabric_category_code."</option>"; 
					}
				}
				?>
				</select>
			</div>
			<div class="col-sm-2">
				<label for='reptype'>Report : </label>
				<select class='form-control' name="reptype">
					<option value=1 <?php if($reptype==1){ echo "selected"; } ?> >Detailed</option>
					<option value=2 <?php if($reptype==2){ echo "selected"; } ?>>Summary</option>
				</select>
			</div>
			<div class="col-sm-1">
				<br>
				<input class="btn btn-success" type="submit" value="Show" onclick="return verify_date();" name="submit">
			</div>
		</form>



<?php
if(isset($_POST['submit']))
{
	echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"red\">Please wait while preparing report...</font></h1></center></div>";
	// var_dump($_POST);
	ob_end_flush();
	flush();
	usleep(10);
	
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$section=$_POST['section'];
	if($section=='All')
	{	
		$sec_list="'".implode("','",$workstation_id1)."'";
		$all_sec_names='';
		foreach($workstation_id1 as $wsid){
			$all_sec_names .='"'.$workstation_description1[$wsid].'",';
		}
		$all_sec_names = rtrim($all_sec_names, ',');
	}else{
		$sec_list='"'.str_replace(",",'","',$section).'"';
		$all_sec_names = '"'.$workstation_description1[$section].'"';
	}
	$shift=$_POST['shift'];
	$reptype=$_POST['reptype'];
	$cat=$_POST['cat'];
	if($cat=='All')
	{	
		$cat_list="'".implode("','",$fabric_category_id1)."'";
		$all_cats='';
		foreach($fabric_category_id1 as $fcid){
			$all_cats .= '"'.$fabric_category_code1[$fcid].'",';
		}
		$all_cats = rtrim($all_cats, ',');
	}else{
		$cat_list='"'.str_replace(",",'","',$cat).'"';
		$all_cats = '"'.$fabric_category_code1[$cat].'"';
	}
?>
<br>
	<div class="col-sm-12 ">
		<div class="row">
				<h4 style="color:blue">Fabric Saving Report</h4>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<div class="col-sm-4 black"><b>Date Range : </b></div>
				<div class="col-sm-7 "><code><?php if($from_date and $to_date){ echo $from_date."<b> to </b>".$to_date;} ?></code></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<div class="col-sm-4 black"><b>Shift : </b></div>
				<div class="col-sm-7"><code><?php echo str_replace('"',"",$shift); ?></code></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<div class="col-sm-4 black"><b>Supervisor : </b></div>
				<div class="col-sm-8" style='word-wrap:break-word;'><code><?php echo $all_sec_names ?></code></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<div class="col-sm-4 black"><b>Category : </b></div>
				<div class="col-sm-8"><code><?php echo str_replace('"','',$all_cats) ?></code></div>
			</div>
		</div>
	</div>

<?php
 }
?>


<?php
$reptype = $_POST['reptype'];
if(isset($_POST['submit']) && $reptype == 1)
{
	$sql = "SELECT lpl.lp_lay_id,lpl.workstation_id,lpl.shift,DATE(lpl.created_at) AS date1,lrfc.fabric_category,
	jdl.docket_line_number,jcj.cut_number,sum(jcbd.quantity) as pcs,sum(jdlb.quantity) as quantity,sum(jdl.plies) as plies,lpl.po_number,lrfc.fabric_category,jd.ratio_comp_group_id,lrfc.ratio_id 
	FROM $pps.`lp_lay` lpl 
	LEFT JOIN $pps.`lp_ratio` lp ON lp.po_number = lpl.po_number
	LEFT JOIN $pps.`lp_ratio_fabric_category` lrfc ON lrfc.ratio_id = lp.ratio_id
	LEFT JOIN $pps.`jm_docket_lines` jdl ON jdl.jm_docket_line_id = lpl.jm_docket_line_id
	LEFT JOIN $pps.`jm_docket_bundle` jdb ON jdb.jm_docket_line_id = jdl.jm_docket_line_id
	LEFT JOIN $pps.`jm_docket_logical_bundle` jdlb ON jdlb.jm_docket_bundle_id = jdb.jm_docket_bundle_id
	LEFT JOIN $pps.`jm_cut_bundle` jcb ON jcb.jm_cut_bundle_id = jdb.jm_docket_bundle_id
	LEFT JOIN $pps.`jm_cut_bundle_details` jcbd ON jcbd.jm_cut_bundle_id = jcb.jm_cut_bundle_id
	LEFT JOIN $pps.`jm_dockets` jd ON jd.jm_docket_id = jdl.jm_docket_id
	LEFT JOIN $pps.`jm_cut_job` jcj ON jcj.jm_cut_job_id = jd.jm_cut_job_id 
	WHERE DATE(lpl.created_at) between \"$from_date\" and  \"$to_date\" and lpl.workstation_id IN ($sec_list) AND lrfc.fabric_category IN ($all_cats) AND lpl.shift='$shift'
	GROUP BY lpl.lp_lay_id";
	// echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error dd".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);

	echo '<div id="export"  class="pull-right">
			<form action="'.$excel_form_action.'" method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input class="btn btn-warning btn-sm" type="submit" value="Export to Excel" onclick="getCSVData()">
			</form>
			</div>';	
	echo "<div class='col-sm-12' style='overflow-x:scroll;overflow-y:scroll;max-height:600px;'><br>";
	echo "<h5><b>Detailed Report</b></h5>";
	echo "<table class='table table-bordered table-responsive' id='report'>";	
	echo "<tr class='info'>";
	echo "<th>Date</th>";
	echo "<th>Shift</th>";
	echo "<th>Section</th>";
	echo "<th>Docket No</th>";
	echo "<th>Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>Color</th>";
	echo "<th>Category</th>";
	echo "<th>Cut No</th>";
	echo "<th>Pcs</th>";
	echo "<th>Plies</th>";
	echo "<th>MK Len.</th>";
	echo "<th>Cut Qty</th>";
	echo "<th>Docket Requested</th>";
	echo "<th>Fabric Received</th>";
	echo "<th>Fabric Returned</th>";
	echo "<th>Damages</th>";
	echo "<th>Shortages</th>";
	echo "<th>joints</th>";
	echo "<th>Endbits</th>";
	echo "<th>Net Utlization</th>";
	echo "<th>Ordering Consumpt-ion</th>";
	echo "<th>Actual Consumpt-ion</th>";
	echo "<th>Net Consumpt-ion</th>";
	echo "<th>Actual Saving</th>";
	echo "<th>Pct %</th>";
	echo "<th>Net Saving</th>";
	echo "<th>Net Saving %</th>";
	echo "<th>Team Leader</th>";
	echo "</tr>";	
	if($sql_num_check > 0) {
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			
			$doc_no=$sql_row['docket_line_number'];
			$date=$sql_row['date1'];
			$act_shift=$sql_row['shift'];
			// $act_section=$sql_row['workstation_description'];
			$po_number=$sql_row['po_number'];
			$workstation_id=$sql_row['workstation_id'];
			$category=$sql_row['fabric_category'];
			$cut_number=$sql_row['cut_number'];
			$act_total = $sql_row['quantity'];
			$plies = $sql_row['plies'];
			$lay_id = $sql_row['lp_lay_id'];
			$ratio_comp_group_id = $sql_row['ratio_comp_group_id'];
			$ratio_id = $sql_row['ratio_id'];
			// echo $po_number;
			$getdetails = getStyleColorSchedule($po_number,$plantcode);
			$style = $getdetails['style_bulk'][0];
			$schedule = $getdetails['schedule_bulk'][0];
			$color = $getdetails['color_bulk'][0];
			
			// get the docket qty
			$size_ratio_sum = 0;
			$size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id = '$ratio_id' ";
			$size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row = mysqli_fetch_array($size_ratios_result))
			{
				$size_ratio_sum += $row['size_ratio'];
			}
		
			$docket_quantity = $size_ratio_sum * $plies;

			$Qry_get_order_consumption="SELECT workstation_description from $pms.`workstation` WHERE workstation_id='$workstation_id'";
			$sql_result3=mysqli_query($link, $Qry_get_order_consumption) or die("Error".$Qry_get_order_consumption.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($sql_result3))
			{
				$act_section=$row3['workstation_description'];
			}

			if($ratio_comp_group_id!=''){
				$qry_lp_markers="SELECT `length` FROM $pps.`lp_markers` WHERE `lp_ratio_cg_id`='$ratio_comp_group_id' AND default_marker_version=1 AND `plant_code`='$plantcode'";
				// echo $qry_lp_markers;
				$lp_markers_result=mysqli_query($link_new, $qry_lp_markers) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
				$lp_markers_num=mysqli_num_rows($lp_markers_result);
				if($lp_markers_num>0){
					while($sql_row1=mysqli_fetch_array($lp_markers_result))
					{
						$mk_length = $sql_row1['length'];
					}
				}
			}

			$req_qty=0;
			$issued_qty=0;
			$sql112="SELECT req_qty,issued_qty FROM $wms.mrn_track WHERE product='FAB' and plant_code='$plantcode' and style='$style' and schedule='$schedule' and color='$color^$cut_number'";
			$sql_result112=mysqli_query($link, $sql112) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result112)>0)
			{
				while($sql_row112=mysqli_fetch_array($sql_result112))
				{
					$req_qty=$sql_row112['req_qty'];
					$issued_qty=$sql_row112['issued_qty'];
				}
			}


			//To get fabric attributes
			$fab_rec = 0;
			$fab_ret = 0;
			$shortages = 0;
			$damages = 0;
			$endbits = 0;
			$joints = 0;
			$net_util = 0;
			$act_con = 0;
			$net_con = 0;
			$fabricattributes=array();
			$qrt_get_attributes1="SELECT * FROM $pps.lp_lay_attribute WHERE lp_lay_id= '$lay_id' and plant_code='$plantcode'";
			$sql_result7=mysqli_query($link, $qrt_get_attributes1) or die("Error".$qrt_get_attributes1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row7=mysqli_fetch_array($sql_result7))
			{
				$fabricattributes[$row7['attribute_name']] = $row7['attribute_value'];
			}
			$fab_rec=  $fabricattributes[$fabric_lay_attributes['fabricrecevied']];
			$fab_ret=  $fabricattributes[$fabric_lay_attributes['fabricreturned']];
			$shortages=  $fabricattributes[$fabric_lay_attributes['shortages']];
			$damages=  $fabricattributes[$fabric_lay_attributes['damages']];
			$endbits=  $fabricattributes[$fabric_lay_attributes['endbits']];
			$joints=  $fabricattributes[$fabric_lay_attributes['joints']];
			$net_util= $fab_rec - $fab_ret - $damages - $shortages;
			$act_con=round((($fab_rec - $fab_ret)/$act_total));
			$net_con=round($net_util/$docket_quantity,4);
			//To get Total order qty
			$sql2="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plantcode'";
			$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($sql_result2))
			{
				$total_order_qty=$row2['quantity'];
			}
			//OrderConsumption
			//To get wastage and consumption
			$Qry_get_order_consumption="SELECT SUM(consumption) AS consumption,SUM(wastage_perc) AS wastage FROM $oms.`oms_mo_items` LEFT JOIN $oms.`oms_products_info` ON oms_mo_items.`mo_number`=oms_products_info.`mo_number` WHERE style='$style' AND color_desc='$color' AND operation_code=15";
			$sql_result3=mysqli_query($link, $Qry_get_order_consumption) or die("Error".$Qry_get_order_consumption.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($sql_result3))
			{
				$consumption=$row3['consumption'];
				$cut_wastage=$row3['wastage'];
			}
			$doc_req=$total_order_qty*$consumption;

			//To get mo qty aganist style,schedule,color
			$Qry_get_quantity="SELECT SUM(mo_quantity) as mo_qty FROM $oms.`oms_mo_details` LEFT JOIN $oms.`oms_products_info` ON oms_mo_details.`mo_number`=oms_products_info.`mo_number` WHERE style='$style' AND SCHEDULE='$schedule' AND color_desc='$color' AND oms_mo_details.plant_code='$plantcode'";
			$sql_result4=mysqli_query($link, $Qry_get_quantity) or die("Error".$Qry_get_quantity.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row4=mysqli_fetch_array($sql_result4))
			{
				$mo_qty=$row4['mo_qty'];
			}
			if($cut_wastage > 0)
			{
				$wastage=$cut_wastage;
			}else
			{
				$wastage=1;
			}


			// $doc_req=$doc_req+$req_qty;


			$order_consumption=(($mo_qty*$consumption*$wastage)/100);
			$act_saving = 0;
			$act_saving_pct = 0;
			$net_saving = 0;
			$net_saving_pct = 0;
			if( $order_consumption > 0 ){
				$act_saving=round(($order_consumption*$docket_quantity)-($act_con*$order_consumption),1);
				$act_saving_pct=round((($order_consumption-$act_con)/$order_consumption)*100,0);
				$net_saving=round(($order_consumption*$docket_quantity)-($net_con*$docket_quantity),1);
				$net_saving_pct=round((($order_consumption-$net_con)/$order_consumption)*100,0);
			}
			$s="select emp_name from $pms.tbl_leader_name where plant_code='$plantcode'";
			$sql_result22=mysqli_query($link, $s) or exit("Sql Error ef".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row22=mysqli_fetch_array($sql_result22))
			{
				$leader_name1 = $sql_row22['emp_name'];
			}
			echo "<tr height=17 style='height:12.75pt'>";
			echo "<td class=xl6618241 style='border-top:none'>$date</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_shift</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_section</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>".leading_zeros($doc_no,9)."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$style</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$schedule</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none;word-wrap: break-word;'>$color</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$category</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$cut_number</td>";
			// echo "<td class=xl6618241 style='border-top:none;border-left:none'>".($act_total/$plies)."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>".($docket_quantity)."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>".$plies."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>".$mk_length."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_total</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>".($doc_req+round($doc_req*0.01,2))."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$fab_rec</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$fab_ret</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$damages</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$shortages</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$joints</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>".round($endbits,4)."</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_util</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$order_consumption</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_con</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_con</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_saving</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_saving_pct%</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_saving</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_saving_pct%</td>";
			echo "<td class=xl6618241 style='border-top:none;border-left:none'>$leader_name1</td>";
			echo "</tr>";
		}	
	} else {
		echo "<tr><td colspan='29' style='color:red';><center>No Data Found</center></td></tr>";	
	}
	}
	echo "</table>";

 
 ?>
 
 
<?php
$reptype == $_POST['reptype'];
if(isset($_POST['submit']) && $reptype==2)
{ 
   
	$sql = "SELECT GROUP_CONCAT(distinct(lpl.lp_lay_id)) as lp_lay_id,GROUP_CONCAT(distinct(jcj.cut_number)) as cut_number,sum(jcb.quantity) AS pcs,sum(jdlb.quantity) as quantity,sum(jdl.plies) as plies,GROUP_CONCAT(distinct(lpl.po_number)) as po_number,GROUP_CONCAT(distinct(jd.ratio_comp_group_id)) as ratio_comp_group_id,lpl.workstation_id 
	FROM $pps.`lp_lay` lpl 
	LEFT JOIN $pps.`lp_ratio` lp ON lp.po_number = lpl.po_number
	LEFT JOIN $pps.`lp_ratio_fabric_category` lrfc ON lrfc.ratio_id = lp.ratio_id
	LEFT JOIN $pps.`jm_docket_lines` jdl ON jdl.jm_docket_line_id = lpl.jm_docket_line_id
	LEFT JOIN $pps.`jm_docket_bundle` jdb ON jdb.jm_docket_line_id = jdl.jm_docket_line_id
	LEFT JOIN $pps.`jm_docket_logical_bundle` jdlb ON jdlb.jm_docket_bundle_id = jdb.jm_docket_bundle_id
	LEFT JOIN $pps.`jm_cut_bundle` jcb ON jcb.jm_cut_bundle_id = jdb.jm_docket_bundle_id
	LEFT JOIN $pps.`jm_cut_bundle_details` jcbd ON jcbd.jm_cut_bundle_id = jcb.jm_cut_bundle_id
	LEFT JOIN $pps.`jm_dockets` jd ON jd.jm_docket_id = jdl.jm_docket_id
	LEFT JOIN $pps.`jm_cut_job` jcj ON jcj.jm_cut_job_id = jd.jm_cut_job_id 
	WHERE DATE(lpl.created_at) between \"$from_date\" and  \"$to_date\" and lpl.workstation_id IN ($sec_list) AND lrfc.fabric_category IN ($all_cats) AND lpl.shift='$shift'
	GROUP BY  lpl.workstation_id";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);

	echo "<div class='col-sm-12' style='overflow-x:scroll;overflow-y:scroll;max-height:600px;'>";
	echo "<h5>Summary Report</h5>";
	echo "<table class='table table-bordered table-responsive' id='report'>";	
	echo "<tr class='info'>";
	echo "<th>Table</th>";
	echo "<th>Shift</th>";
	echo "<th>Cut Qty</th>";
	echo "<th>Damages</th>";
	echo "<th>Shortages</th>";
	echo "<th>Joints</th>";
	echo "<th>Endbits</th>";
	echo "<th>ActualSaving</th>";
	echo "<th>Pct %</th>";
	echo "<th>Net Saving</th>";
	echo "<th>Pct %</th>";
	//echo "<th>Team Leader</th>";
	echo "</tr>";
	$sql_result_num=mysqli_num_rows($sql_result);
	if($sql_result_num > 0) {
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$shift_new=$shift;
				$po_number=$sql_row['po_number'];
				$cut_number=$sql_row['cut_number'];
				// $act_total = $sql_row['quantity'];
				$plies = $sql_row['plies'];
				$act_total = $sql_row['quantity'];
				$lay_ids = $sql_row['lp_lay_id'];
				$workstation_id = $sql_row['workstation_id'];
				$ratio_comp_group_id = $sql_row['ratio_comp_group_id'];
				
				$Qry_get_order_consumption="SELECT workstation_description from $pms.`workstation` WHERE workstation_id='$workstation_id'";
				$sql_result3=mysqli_query($link, $Qry_get_order_consumption) or die("Error".$Qry_get_order_consumption.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row3=mysqli_fetch_array($sql_result3))
				{
					$act_section=$row3['workstation_description'];
				}
	
				if($ratio_comp_group_id!=''){
					$qry_lp_markers="SELECT `length` FROM $pps.`lp_markers` WHERE `lp_ratio_cg_id` in ('".implode("','" , $ratio_comp_group_id)."') AND default_marker_version=1 AND `plant_code`='$plantcode'";
					// echo $qry_lp_markers;
					$lp_markers_result=mysqli_query($link_new, $qry_lp_markers) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
					$lp_markers_num=mysqli_num_rows($lp_markers_result);
					if($lp_markers_num>0){
						while($sql_row1=mysqli_fetch_array($lp_markers_result))
						{
							$mk_length = $sql_row1['length'];
						}
					}
				}
				$req_qty=0;
				$issued_qty=0;
				$total_order_qty= 0;
				$consumption=0;
				$cut_wastage=0;
				$po_number_arr=explode(",",$po_number);
				foreach($po_number_arr as $po){
					$getdetails = getStyleColorSchedule($po,$plantcode);
					$style = $getdetails['style_bulk'][0];
					$schedule = $getdetails['schedule_bulk'][0];
					$color = $getdetails['color_bulk'][0];
					foreach($cut_number as $cut_no){
						$sql112="SELECT req_qty,issued_qty FROM $wms.mrn_track WHERE product='FAB' and plant_code='$plantcode' and style='$style' and schedule='$schedule' and color='$color^$cut_no'";
						$sql_result112=mysqli_query($link, $sql112) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result112)>0)
						{
							while($sql_row112=mysqli_fetch_array($sql_result112))
							{
								$req_qty += $sql_row112['req_qty'];
								$issued_qty += $sql_row112['issued_qty'];
							}
						}
					}
	
					$sql2="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plantcode'";
					$sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row2=mysqli_fetch_array($sql_result2))
					{
						$total_order_qty += $row2['quantity'];
					}
					//To get wastage and consumption
					$Qry_get_order_consumption="SELECT SUM(consumption) AS consumption,SUM(wastage_perc) AS wastage FROM $oms.`oms_mo_items` LEFT JOIN $oms.`oms_products_info` ON oms_mo_items.`mo_number`=oms_products_info.`mo_number` WHERE style='$style' AND color_desc='$color' AND operation_code=15";
					$Qry_get_order_consumption;
					$sql_result3=mysqli_query($link, $Qry_get_order_consumption) or die("Error".$Qry_get_order_consumption.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row3=mysqli_fetch_array($sql_result3))
					{
						$consumption += $row3['consumption'];
						$wastage += $row3['wastage'];
					}
				}
				$order_consumption=(($total_order_qty*$consumption*$wastage)/100);
				$doc_req=$total_order_qty*$consumption;
				
				$fab_rec = 0;
				$fab_ret = 0;
				$shortages = 0;
				$damages = 0;
				$endbits = 0;
				$joints = 0;
				$net_util = 0;
				$act_con = 0;
				$net_con = 0;
				
				$lay_ids_arr=explode(",",$lay_ids);
				foreach($lay_ids_arr as $lay_id){
					$fabricattributes=array();
					$qrt_get_attributes1="SELECT * FROM $pps.lp_lay_attribute WHERE lp_lay_id = '$lay_id' and plant_code='$plantcode'";
					$sql_result7=mysqli_query($link, $qrt_get_attributes1) or die("Error".$qrt_get_attributes1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row7=mysqli_fetch_array($sql_result7))
					{
						$fabricattributes[$row7['attribute_name']] = $row7['attribute_value'];
					}
					$fab_rec +=  $fabricattributes[$fabric_lay_attributes['fabricrecevied']];
					$fab_ret +=  $fabricattributes[$fabric_lay_attributes['fabricreturned']];
					$shortages +=  $fabricattributes[$fabric_lay_attributes['shortages']];
					$damages +=  $fabricattributes[$fabric_lay_attributes['damages']];
					$endbits +=  $fabricattributes[$fabric_lay_attributes['endbits']];
					$joints +=  $fabricattributes[$fabric_lay_attributes['joints']];
				}
				
				
				$net_util = $fab_rec - $fab_ret - $damages - $shortages;
				$act_con=round((($fab_rec - $fab_ret)/$act_total));
				$net_con=round($net_util/$act_total,4);
				$act_saving=round(($order_consumption*$act_total)-($act_con*$act_total),1);
				$act_saving_pct=round((($order_consumption-$act_con)/$order_consumption)*100,1);
				$net_saving_pct=round((($order_consumption-$net_con)/$order_consumption)*100,1);
				$net_saving=round(($order_consumption*$act_total)-($net_con*$act_total),1);
				$requested=($order_consumption*$act_total);
				$allocated=($act_con*$act_total);
				$utilized=($net_con*$act_total);
	
	
			
				$act_saving_sum=round(($order_consumption*$act_total)-($act_con*$order_consumption),1);
				$act_saving_pct=round((($order_consumption-$act_con)/$order_consumption)*100,0);
				$net_saving_sum=round(($order_consumption*$act_total)-($net_con*$act_total),1);
				$net_saving_pct=round((($order_consumption-$net_con)/$order_consumption)*100,0);
	
				echo" <tr height=17 style='height:12.75pt'>";
				echo "<td class=xl6618241 style='border-top:none'>$act_section</td>";
				echo "<td>$shift_new</td>";
				echo "<td>$act_total</td>";
				echo "<td>$damages</td>";
				echo "<td>$shortages</td>";
				echo "<td>$joints</td>";
				echo "<td>".round($endbits,4)."</td>";
				echo "<td>$act_saving_sum</td>";
				echo "<td>".$act_saving_pct."%</td>";
				echo "<td>$net_saving_sum</td>";
				echo "<td>".$net_saving_pct."%</td>";
				//echo "<td>$leader_name1</td>";
				echo "</tr>";
		}
	} else {
		echo "<tr><td colspan='11' style='color:red';><center>No Data Found</center></td></tr>";	
	}
	echo "<table>
	</div>";
}
 
?>
 
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=8 style='width:6pt'></td>
  <td width=77 style='width:58pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=57 style='width:43pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=80 style='width:60pt'></td>
  <td width=78 style='width:59pt'></td>
  <td width=84 style='width:63pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=59 style='width:44pt'></td>
 </tr>
 <![endif]>
</table>
</div>
</div><!-- panel body -->
</div><!--  panel -->
</div>
<script>
function getCSVData(){
 var csv_value=$('#report').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>

<script>
	document.getElementById("msg").style.display="none";
	document.getElementById("export").style.display="";		
</script>


