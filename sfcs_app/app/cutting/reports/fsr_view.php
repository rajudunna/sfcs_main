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
$plantcode = 'AIP';
$username = 'AIP';
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
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
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
			$sqlxx="select workstation_type_id from $pms.workstation_type where plant_code='$plantcode' and workstation_type_description='Cutting'";
			$sql_resultx1=mysqli_query($link, $sqlxx) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				 $workstation_type_id=$sql_rowx1['workstation_type_id'];
			}
			
			$sqlx="select workstation_id,workstation_description from $pms.workstation where plant_code='$plantcode' and workstation_type_id='$workstation_type_id'";
			$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$all_secs = array();
			$all_sec_query = "SELECT GROUP_CONCAT('\"',workstation_id,'\"') as sec FROM $pms.workstation where plant_code='$plantcode' and workstation_type_id='$workstation_type_id'";
			$sec_result_all = mysqli_query($link,$all_sec_query) or exit('Unable to load sections all');
			while($res1 = mysqli_fetch_array($sec_result_all)){
				$all_secs[] = $res1['sec'];
			}
			$all_secs = implode(",",$all_secs);
			?>
			<div class="col-md-2">
				<label>Section: </label>
				<select name="section" class="form-control" required>
					<?php if($all_secs){
					echo "<option value=$all_secs>All</option>";
					}
					?>
					<?php
						foreach($sql_resultx as $key=>$value){
							if($section == $value['workstation_id']){
								echo "<option value='\"".$value['workstation_id']."\"' selected>".$value['workstation_description']."</option>";
							}else {
								echo "<option value='\"".$value['workstation_id']."\"'>".$value['workstation_description']."</option>";

							}
						}
					?>
				</select>
			</div>
			<div class='col-sm-2'>
                Shift :<select class='form-control' id='shift' name='shift' required>
                    <option value=''>Select</option>
					<?php
                    foreach($shifts_array as $shift){
                      echo "<option value='$shift'>$shift</option>";
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
			<div class="col-sm-2">
				<label for='cat'>Category : </label> 
				<select class='form-control' name="cat">
					<option value='<?= $all_cats ?>'>All</option>
				<?php
				foreach($cat_result_all as $key=>$value){
					if($cat == $value['workstation_id']){
						echo "<option value='\"".$value['fabric_category_id']."\"' selected>".$value['fabric_category_code']."</option>";
					}else {
						echo "<option value='\"".$value['fabric_category_id']."\"'>".$value['fabric_category_code']."</option>";
					}
				}
				?>
				</select>
				<input type="hidden" name="section_name" id="section_name">
				<input type="hidden" name="category_name" id="category_name">
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
	$shift=$_POST['shift'];
	$reptype=$_POST['reptype'];
	$cat=$_POST['cat'];
?>
<br>
	<div class="col-sm-12 ">
		<div class="row">
				<h4 style="color:blue">Fabric Saving Report</h4>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="col-sm-4 black"><b>Date Range : </b></div>
				<div class="col-sm-7 "><code><?php if($from_date and $to_date){ echo $from_date."<b> to </b>".$to_date;} ?></code></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="col-sm-4 black"><b>Shift : </b></div>
				<div class="col-sm-7 "><code><?php echo str_replace('"',"",$shift); ?></code></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="col-sm-4 black"><b>Supervisor : </b></div>
				<div class="col-sm-7"><code><?php echo $section ?></code></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="col-sm-4 black"><b>Category : </b></div>
				<div class="col-sm-8"><code><?php echo str_replace('"','',$cat) ?></code></div>
			</div>
		</div>
	</div>

<?php
 }
?>


<?php
$reptype = $_POST['reptype'];
// echo 'rep type = '.$reptype;
if(isset($_POST['submit']) && $reptype == 1)

{

	//NEW Enhancement for category breakup		 
	// $doc_ref_new="";
	// $sql2="select * from $pps.act_cut_status where plant_code='$plantcode' and section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\"";
	// // echo $sql2;
	// $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error a".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row2=mysqli_fetch_array($sql_result2))
	// {
	// 	$doc_ref_no=$sql_row2['doc_no'];
	// 	$sql="select * from $bai_pro3.plandoc_stat_log where doc_no=\"$doc_ref_no\"";
		
		
	// 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error b".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	while($sql_row=mysqli_fetch_array($sql_result))
	// 	{
	// 		$cat_ref_new=$sql_row['cat_ref'];
	// 	}

	// 	$sql="select * from $bai_pro3.cat_stat_log where category in ($cat) and tid=\"$cat_ref_new\"";
	// 	$sql_result=mysqli_query($link, $sql) or exit("Sql Error c".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	$sql_num_check=mysqli_num_rows($sql_result);
		
	// 	if($sql_num_check>0)
	// 	{
	// 		$doc_ref_new=$doc_ref_new.$doc_ref_no.", ";
	// 	}
		
	// }
	
	// $doc_ref_new=substr($doc_ref_new,0,-2);
	// $query="";
	// if( strlen($doc_ref_new)>0)
	// {
	// 	$query="and doc_no in ($doc_ref_new)";
	// }
	// else
	// {
	// 	$query="and doc_no in (-1)";
	// }
	//NEW Enhancement for category breakup		

	// $sql="select * from $pps.act_cut_status where plant_code='$plantcode' and section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\" ".$query;
	$sql = "SELECT lpl.lp_lay_id,lpl.shift,ws.workstation_description,DATE(lpl.created_at) AS date1,lrfc.fabric_category,
	jdl.docket_line_number,jcj.cut_number,jcbd.quantity AS pcs,jdlb.quantity,jdl.plies,lpl.po_number,lrfc.fabric_category 
	FROM `pps_prod`.`lp_lay` lpl 
	LEFT JOIN `pps_prod`.`lp_ratio` lp ON lp.po_number = lpl.po_number
	LEFT JOIN `pps_prod`.`lp_ratio_fabric_category` lrfc ON lrfc.ratio_id = lp.ratio_id
	LEFT JOIN `pps_prod`.`jm_docket_lines` jdl ON jdl.jm_docket_line_id = lpl.jm_docket_line_id
	LEFT JOIN `pps_prod`.`jm_docket_bundle` jdb ON jdb.jm_docket_line_id = jdl.jm_docket_line_id
	LEFT JOIN `pps_prod`.`jm_docket_logical_bundle` jdlb ON jdlb.jm_docket_bundle_id = jdb.jm_docket_bundle_id
	LEFT JOIN `pps_prod`.`jm_cut_bundle` jcb ON jcb.jm_cut_bundle_id = jdb.jm_docket_bundle_id
	LEFT JOIN `pps_prod`.`jm_cut_bundle_details` jcbd ON jcbd.jm_cut_bundle_id = jcb.jm_cut_bundle_id
	LEFT JOIN `pps_prod`.`jm_dockets` jd ON jd.jm_docket_id = jdl.jm_docket_id
	LEFT JOIN `pps_prod`.`jm_cut_job` jcj ON jcj.jm_cut_job_id = jd.jm_cut_job_id 
	LEFT JOIN `pms_prod`.`workstation` ws ON ws.workstation_id = lpl.workstation_id
	GROUP BY lpl.lp_lay_id";
	// WHERE `pps_prod`.lpl.workstation_id IN ('4c7db809-1bf4-4b36-811b-b4ff701ced98') AND lpl.shift='A'
	echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error d".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	echo "<th>Team Leader</th>";
	echo "</tr>";	

	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$doc_no=$sql_row['docket_line_number'];
		$date=$sql_row['date1'];
		$act_shift=$sql_row['shift'];
		$act_section=$sql_row['workstation_description'];
		$po_number=$sql_row['po_number'];
		$category=$sql_row['fabric_category'];
		$cut_number=$sql_row['cut_number'];
		$act_total = $sql_row['quantity'];
		$plies = $sql_row['plies'];
		$lay_id = $sql_row['lp_lay_id'];
		$getdetails = getStyleColorSchedule($po_number,$plantcode);
		$style = $getdetails['style_bulk'][0];
		$schedule = $getdetails['schedule_bulk'][0];
		$color = $getdetails['color_bulk'][0];
		// $fab_rec=$sql_row['fab_received'];
		// $fab_ret=$sql_row['fab_returned'];
		// $damages=round($sql_row['damages'],2);
		// $shortages=round($sql_row['shortages'],2);
		// $leader_name = $sql_row['leader_name'];	
		// $joints_endbits=$sql_row["joints_endbits"];
		// $jo_int_check=explode('$',$joints_endbits);
		// $joints=0;
		// $endbits=0;	

		//To get fabric attributes
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
		$net_util= $fab_rec - $fab_ret - $damages - $shortages- $endbits;
		$act_con=round((($fab_rec - $fab_ret)/$act_total));
		$net_con=round($net_util/$act_total,4);

		//OrderConsumption
		//To get wastage and consumption
		$Qry_get_order_consumption="SELECT SUM(consumption) AS consumption,SUM(wastage_perc) AS wastage FROM $oms.`oms_mo_items` LEFT JOIN $oms.`oms_products_info` ON oms_mo_items.`mo_number`=oms_products_info.`mo_number` WHERE style='$style' AND color_desc='$color' AND operation_code=15";
		$sql_result3=mysqli_query($link, $Qry_get_order_consumption) or die("Error".$Qry_get_order_consumption.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($sql_result3))
		{
			$consumption=$row3['consumption'];
			$cut_wastage=$row3['wastage'];
		}
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

		$order_consumption=(($mo_qty*$consumption*$wastage)/100);


		$act_saving=round(($order_consumption*$act_total)-($act_con*$order_consumption),1);
		$act_saving_pct=round((($order_consumption-$act_con)/$order_consumption)*100,0);
		$net_saving=round(($order_consumption*$act_total)-($net_con*$act_total),1);
		$net_saving_pct=round((($order_consumption-$net_con)/$order_consumption)*100,0);


		 // $net_util=$fab_rec-$fab_ret-$damages-$shortages-$endbits;
        // $act_con=round(($fab_rec-$fab_ret)/$act_total,4);
        // $net_con=round($net_util/$act_total,4);
        // $act_saving=round(($cat_yy*$act_total)-($act_con*$act_total),1);
        // $act_saving_pct=round((($cat_yy-$act_con)/$cat_yy)*100,0);
        // $net_saving=round(($cat_yy*$act_total)-($net_con*$act_total),1);
        // $net_saving_pct=round((($cat_yy-$net_con)/$cat_yy)*100,0);

		// $doc_req=$doc_req+$req_qty;

		// for($ii=0;$ii<sizeof($jo_int_check);$ii++)
		// {
		// 	$values_joint=explode('^',$jo_int_check[$ii]);
		// 	$joints=$joints+$values_joint[0];
		// 	$endbits=$endbits+$values_joint[1];		
		// }

		// $s="select emp_name from $pms.tbl_leader_name where plant_code='$plantcode' and id = '$leader_name'";
	
		// $sql_result22=mysqli_query($link, $s) or exit("Sql Error ef".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row22=mysqli_fetch_array($sql_result22))
		// {
		// 	$leader_name1 = $sql_row22['emp_name'];
		// }
		// $sql1="select * from $bai_pro3.plandoc_stat_log where doc_no='$doc_no'";
		// //echo $sql1;
		// //mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error e".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1=mysqli_fetch_array($sql_result1))
		// {
		// 	$cat_ref=$sql_row1['cat_ref'];
		// 	$act_cut_no=$sql_row1['acutno'];
		// 	$mk_ref=$sql_row1['mk_ref'];
		// 	$a_plies=$sql_row1['p_plies']; //20110911
		// 	$act_xs=$sql_row1['a_xs']*$sql_row1['a_plies'];
		// 	$act_s=$sql_row1['a_s']*$sql_row1['a_plies'];
		// 	$act_m=$sql_row1['a_m']*$sql_row1['a_plies'];
		// 	$act_l=$sql_row1['a_l']*$sql_row1['a_plies'];
		// 	$act_xl=$sql_row1['a_xl']*$sql_row1['a_plies'];
		// 	$act_xxl=$sql_row1['a_xxl']*$sql_row1['a_plies'];
		// 	$act_xxxl=$sql_row1['a_xxxl']*$sql_row1['a_plies'];
			
		// 	$act_s01=$sql_row1['a_s01']*$sql_row1['a_plies'];
		// 	$act_s02=$sql_row1['a_s02']*$sql_row1['a_plies'];
		// 	$act_s03=$sql_row1['a_s03']*$sql_row1['a_plies'];
		// 	$act_s04=$sql_row1['a_s04']*$sql_row1['a_plies'];
		// 	$act_s05=$sql_row1['a_s05']*$sql_row1['a_plies'];
		// 	$act_s06=$sql_row1['a_s06']*$sql_row1['a_plies'];
		// 	$act_s07=$sql_row1['a_s07']*$sql_row1['a_plies'];
		// 	$act_s08=$sql_row1['a_s08']*$sql_row1['a_plies'];
		// 	$act_s09=$sql_row1['a_s09']*$sql_row1['a_plies'];
		// 	$act_s10=$sql_row1['a_s10']*$sql_row1['a_plies'];
		// 	$act_s11=$sql_row1['a_s11']*$sql_row1['a_plies'];
		// 	$act_s12=$sql_row1['a_s12']*$sql_row1['a_plies'];
		// 	$act_s13=$sql_row1['a_s13']*$sql_row1['a_plies'];
		// 	$act_s14=$sql_row1['a_s14']*$sql_row1['a_plies'];
		// 	$act_s15=$sql_row1['a_s15']*$sql_row1['a_plies'];
		// 	$act_s16=$sql_row1['a_s16']*$sql_row1['a_plies'];
		// 	$act_s17=$sql_row1['a_s17']*$sql_row1['a_plies'];
		// 	$act_s18=$sql_row1['a_s18']*$sql_row1['a_plies'];
		// 	$act_s19=$sql_row1['a_s19']*$sql_row1['a_plies'];
		// 	$act_s20=$sql_row1['a_s20']*$sql_row1['a_plies'];
		// 	$act_s21=$sql_row1['a_s21']*$sql_row1['a_plies'];
		// 	$act_s22=$sql_row1['a_s22']*$sql_row1['a_plies'];
		// 	$act_s23=$sql_row1['a_s23']*$sql_row1['a_plies'];
		// 	$act_s24=$sql_row1['a_s24']*$sql_row1['a_plies'];
		// 	$act_s25=$sql_row1['a_s25']*$sql_row1['a_plies'];
		// 	$act_s26=$sql_row1['a_s26']*$sql_row1['a_plies'];
		// 	$act_s27=$sql_row1['a_s27']*$sql_row1['a_plies'];
		// 	$act_s28=$sql_row1['a_s28']*$sql_row1['a_plies'];
		// 	$act_s29=$sql_row1['a_s29']*$sql_row1['a_plies'];
		// 	$act_s30=$sql_row1['a_s30']*$sql_row1['a_plies'];
		// 	$act_s31=$sql_row1['a_s31']*$sql_row1['a_plies'];
		// 	$act_s32=$sql_row1['a_s32']*$sql_row1['a_plies'];
		// 	$act_s33=$sql_row1['a_s33']*$sql_row1['a_plies'];
		// 	$act_s34=$sql_row1['a_s34']*$sql_row1['a_plies'];
		// 	$act_s35=$sql_row1['a_s35']*$sql_row1['a_plies'];
		// 	$act_s36=$sql_row1['a_s36']*$sql_row1['a_plies'];
		// 	$act_s37=$sql_row1['a_s37']*$sql_row1['a_plies'];
		// 	$act_s38=$sql_row1['a_s38']*$sql_row1['a_plies'];
		// 	$act_s39=$sql_row1['a_s39']*$sql_row1['a_plies'];
		// 	$act_s40=$sql_row1['a_s40']*$sql_row1['a_plies'];
		// 	$act_s41=$sql_row1['a_s41']*$sql_row1['a_plies'];
		// 	$act_s42=$sql_row1['a_s42']*$sql_row1['a_plies'];
		// 	$act_s43=$sql_row1['a_s43']*$sql_row1['a_plies'];
		// 	$act_s44=$sql_row1['a_s44']*$sql_row1['a_plies'];
		// 	$act_s45=$sql_row1['a_s45']*$sql_row1['a_plies'];
		// 	$act_s46=$sql_row1['a_s46']*$sql_row1['a_plies'];
		// 	$act_s47=$sql_row1['a_s47']*$sql_row1['a_plies'];
		// 	$act_s48=$sql_row1['a_s48']*$sql_row1['a_plies'];
		// 	$act_s49=$sql_row1['a_s49']*$sql_row1['a_plies'];
		// 	$act_s50=$sql_row1['a_s50']*$sql_row1['a_plies'];
		
		// 	$act_total=$act_xs+$act_s+$act_m+$act_l+$act_xl+$act_xxl+$act_xxxl+$act_s01+$act_s02+$act_s03+$act_s04+$act_s05+$act_s06+$act_s07+$act_s08+$act_s09+$act_s10+$act_s11+$act_s12+$act_s13+$act_s14+$act_s15+$act_s16+$act_s17+$act_s18+$act_s19+$act_s20+$act_s21+$act_s22+$act_s23+$act_s24+$act_s25+$act_s26+$act_s27+$act_s28+$act_s29+$act_s30+$act_s31+$act_s32+$act_s33+$act_s34+$act_s35+$act_s36+$act_s37+$act_s38+$act_s39+$act_s40+$act_s41+$act_s42+$act_s43+$act_s44+$act_s45+$act_s46+$act_s47+$act_s48+$act_s49+$act_s50;
			
		// 	$sql2="select mklength from $bai_pro3.maker_stat_log where tid='$mk_ref'";
		// 	//	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error f".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	while($sql_row2=mysqli_fetch_array($sql_result2))
		// 	{
		// 		$mk_length=$sql_row2['mklength'];
		// 	}
			
		// 	$doc_req=$mk_length*$a_plies;
			
		// 	//Binding Consumption / YY Calculation
		// 	$order_tid=$sql_row1['order_tid'];
		
		// 	//Binding Consumption / YY Calculation
		// 	$sql1="select COALESCE(binding_consumption,0) as \"binding_consumption\" from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid='$cat_ref'";
		// 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
		// 	while($sql_row1=mysqli_fetch_array($sql_result1))
		// 	{
		// 		$binding_consumption=$sql_row1['binding_consumption'];
		// 	}	
		// 	$doc_req+=$act_total*$binding_consumption;
			
		// }
		
		// $sql1="select * from $bai_pro3.cat_stat_log where tid='$cat_ref'";
		// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1=mysqli_fetch_array($sql_result1))
		// {
		// 	$category=$sql_row1['category'];
		// 	$order_tid=$sql_row1['order_tid'];
		// 	$cat_yy=$sql_row1['catyy'];
		// }	
		
		// $sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error i".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row1=mysqli_fetch_array($sql_result1))
		// {
		// 	$style=$sql_row1['order_style_no'];
		// 	$schedule=$sql_row1['order_del_no'];
		// 	$color_code=$sql_row1['color_code'];
		// 	$color=$sql_row1['order_col_des'];
		// }
        // $req_qty=0;
		// $issued_qty=0;
        // $sql112="SELECT req_qty,issued_qty FROM $wms.mrn_track WHERE product='FAB' and plant_code='$plantcode' and style='$style' and schedule='$schedule' and color='$color^$act_cut_no'";
		// $sql_result112=mysqli_query($link, $sql112) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
		// if(mysqli_num_rows($sql_result112)>0)
		// {
		// 	while($sql_row112=mysqli_fetch_array($sql_result112))
		// 	{
		// 		$req_qty=$sql_row112['req_qty'];
		// 		$issued_qty=$sql_row112['issued_qty'];
		// 	}
		// }
		// $doc_req=$doc_req+$req_qty;
		// $fab_rec=$fab_rec+$issued_qty;

        // $net_util=$fab_rec-$fab_ret-$damages-$shortages-$endbits;
        // $act_con=round(($fab_rec-$fab_ret)/$act_total,4);
        // $net_con=round($net_util/$act_total,4);
        // $act_saving=round(($cat_yy*$act_total)-($act_con*$act_total),1);
        // $act_saving_pct=round((($cat_yy-$act_con)/$cat_yy)*100,0);
        // $net_saving=round(($cat_yy*$act_total)-($net_con*$act_total),1);
        // $net_saving_pct=round((($cat_yy-$net_con)/$cat_yy)*100,0);
		
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
		echo "<td class=xl6618241 style='border-top:none;border-left:none'>".($plies/$act_total)."</td>";
		echo "<td class=xl6618241 style='border-top:none;border-left:none'>".$plies."</td>";
		echo "<td class=xl6618241 style='border-top:none;border-left:none'>mk_length</td>";
		echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_total</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$doc_req</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$fab_rec</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$fab_ret</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$damages</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$shortages</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$joints</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>".round($endbits,4)."</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_util</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$cat_yy</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_con</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_con</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_saving</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$act_saving_pct%</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_saving</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$leader_name1</td>";
		// echo "<td class=xl6618241 style='border-top:none;border-left:none'>$net_saving_pct%</td>";
		echo "</tr>";
	}	
	}
	echo "</table>";

 
 ?>
 
 
<?php
$reptype == $_POST['reptype'];
if(isset($_POST['submit']) && $reptype==2)
{ 
	
	
   //NEW Enhancement for category breakup		 
	$doc_ref_new="";
	
	$sql2="select * from $pps.act_cut_status where plant_code='$plantcode' and section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\"";
	
	//mysqli_query($link, $sql2) or exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$doc_ref_no=$sql_row2['doc_no'];
		
		
		$sql="select * from $bai_pro3.plandoc_stat_log where doc_no='$doc_ref_no'";
		//echo $sql."<br>";
		//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cat_ref_new=$sql_row['cat_ref'];
		}

		$sql1="select * from $bai_pro3.cat_stat_log where category in ($cat) and tid='$cat_ref_new'";
		//echo $sql."<br>";
		//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error 3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check1=mysqli_num_rows($sql_result1);
		
		if($sql_num_check1>0)
		{
			$doc_ref_new=$doc_ref_new.$doc_ref_no.", ";
		}
		
	}
	
	$doc_ref_new=substr($doc_ref_new,0,-2);
	$query="";
	if( strlen($doc_ref_new)>0)
	{
		$query="and doc_no in ($doc_ref_new)";
	}
	else
	{
		$query="and doc_no in (-1)";
	}
//NEW Enhancement for category breakup	
   
$sql="select section from $pps.act_cut_status where plant_code='$plantcode' and date between \"$from_date\" and \"$to_date\" and shift in ($shift) and section in ($section) ".$query. " group by section order by section";

//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

while($sql_row=mysqli_fetch_array($sql_result))
{
	$section_new=$sql_row['section'];
	$sql11="select distinct shift from $pps.act_cut_status where plant_code='$plantcode' and date between \"$from_date\" and \"$to_date\" and section in ($section_new) and shift in ($shift) ".$query. "order by shift";
	//mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error 6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row11=mysqli_fetch_array($sql_result11))
	{
		$shift_new=$sql_row11['shift'];

		$doc_list="";
		
		$sql2="select doc_no from $pps.act_cut_status where plant_code='$plantcode' and date between \"$from_date\" and \"$to_date\" and section in ($section_new) and shift=\"$shift_new\" ".$query;
		//mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error 7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$doc_list=$doc_list.$sql_row2['doc_no'].", ";
		}
		
		$doc_list=substr($doc_list,0,-2);
		$cut_qty=0;
		$damages=0;
		$shortages=0;
	
		$sql3="select sum((a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*a_plies) as \"cut_qty\" from $bai_pro3.plandoc_stat_log where doc_no in ($doc_list)";
		//echo $sql3;
		//mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error 8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$cut_qty=$sql_row3['cut_qty'];
		}
		
		$sql3="select sum(damages) as \"damages\", sum(shortages) as \"shortages\" from $pps.act_cut_status where plant_code='$plantcode' and doc_no in ($doc_list)";
		//echo $sql3;
		//mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error 9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$damages=round($sql_row3['damages'],2);
			$shortages=round($sql_row3['shortages'],2);
		}
		

		
		
		/* NEW */
		
		$requested=0;
		$allocated=0;
		$utilized=0;
		$act_saving_sum=0;
		$act_saving_pct=0;
		$net_saving_sum=0;
		$net_saving_pct=0;
		
$sql33="select * from $pps.act_cut_status where plant_code='$plantcode' and section in ($section) and shift in ($shift) and doc_no in ($doc_list) and date between \"$from_date\" and \"$to_date\"".$query;
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error 10".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check33=mysqli_num_rows($sql_result33);
$joints=0;$endbits=0;	
while($sql_row33=mysqli_fetch_array($sql_result33))
{
	$doc_no=$sql_row33['doc_no'];
	$date=$sql_row33['date'];
	$act_shift=$sql_row33['shift'];
	$act_section=$sql_row33['section'];
	$fab_rec=$sql_row33['fab_received'];
	$fab_ret=$sql_row33['fab_returned'];
	$damages_new=$sql_row33['damages'];
	$shortages_new=$sql_row33['shortages'];
	$leader_name = $sql_row33['leader_name'];
	$joints_endbits=$sql_row33["joints_endbits"];
	$jo_int_check=explode("$",$joints_endbits);	
	for($ii=0;$ii<sizeof($jo_int_check);$ii++)
	{
		$values_joint=explode("^",$jo_int_check[$ii]);
		$joints=$joints+$values_joint[0];
		$endbits=$endbits+$values_joint[1];			
	}
	
	
	$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no='$doc_no'";
	//mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error 11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		//Binding Consumption / YY Calculation
		$order_tid=$sql_row1['order_tid'];
		$cat_ref=$sql_row1['cat_ref'];
		$act_cut_no=$sql_row1['acutno'];
		$mk_ref=$sql_row1['mk_ref'];
		$a_plies=$sql_row1['p_plies']; //20110911
		$act_xs=$sql_row1['a_xs']*$sql_row1['a_plies'];
		$act_s=$sql_row1['a_s']*$sql_row1['a_plies'];
		$act_m=$sql_row1['a_m']*$sql_row1['a_plies'];
		$act_l=$sql_row1['a_l']*$sql_row1['a_plies'];
		$act_xl=$sql_row1['a_xl']*$sql_row1['a_plies'];
		$act_xxl=$sql_row1['a_xxl']*$sql_row1['a_plies'];
		$act_xxxl=$sql_row1['a_xxxl']*$sql_row1['a_plies'];
		
		$req_qty=0;
		$issued_qty=0;
		$sql112="SELECT req_qty,issued_qty FROM $wms.mrn_track WHERE product='FAB' and plant_code='$plantcode' and schedule='$schedule' and color='$color^$act_cut_no'";
		$sql_result112=mysqli_query($link, $sql112) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result112)>0)
		{
			while($sql_row112=mysqli_fetch_array($sql_result112))
			{
				$req_qty=$sql_row112['req_qty'];
				$issued_qty=$sql_row112['issued_qty'];
			}
			$fab_rec=$fab_rec+$issued_qty;
		}

			$act_s01=$sql_row1['a_s01']*$sql_row1['a_plies'];
			$act_s02=$sql_row1['a_s02']*$sql_row1['a_plies'];
			$act_s03=$sql_row1['a_s03']*$sql_row1['a_plies'];
			$act_s04=$sql_row1['a_s04']*$sql_row1['a_plies'];
			$act_s05=$sql_row1['a_s05']*$sql_row1['a_plies'];
			$act_s06=$sql_row1['a_s06']*$sql_row1['a_plies'];
			$act_s07=$sql_row1['a_s07']*$sql_row1['a_plies'];
			$act_s08=$sql_row1['a_s08']*$sql_row1['a_plies'];
			$act_s09=$sql_row1['a_s09']*$sql_row1['a_plies'];
			$act_s10=$sql_row1['a_s10']*$sql_row1['a_plies'];
			$act_s11=$sql_row1['a_s11']*$sql_row1['a_plies'];
			$act_s12=$sql_row1['a_s12']*$sql_row1['a_plies'];
			$act_s13=$sql_row1['a_s13']*$sql_row1['a_plies'];
			$act_s14=$sql_row1['a_s14']*$sql_row1['a_plies'];
			$act_s15=$sql_row1['a_s15']*$sql_row1['a_plies'];
			$act_s16=$sql_row1['a_s16']*$sql_row1['a_plies'];
			$act_s17=$sql_row1['a_s17']*$sql_row1['a_plies'];
			$act_s18=$sql_row1['a_s18']*$sql_row1['a_plies'];
			$act_s19=$sql_row1['a_s19']*$sql_row1['a_plies'];
			$act_s20=$sql_row1['a_s20']*$sql_row1['a_plies'];
			$act_s21=$sql_row1['a_s21']*$sql_row1['a_plies'];
			$act_s22=$sql_row1['a_s22']*$sql_row1['a_plies'];
			$act_s23=$sql_row1['a_s23']*$sql_row1['a_plies'];
			$act_s24=$sql_row1['a_s24']*$sql_row1['a_plies'];
			$act_s25=$sql_row1['a_s25']*$sql_row1['a_plies'];
			$act_s26=$sql_row1['a_s26']*$sql_row1['a_plies'];
			$act_s27=$sql_row1['a_s27']*$sql_row1['a_plies'];
			$act_s28=$sql_row1['a_s28']*$sql_row1['a_plies'];
			$act_s29=$sql_row1['a_s29']*$sql_row1['a_plies'];
			$act_s30=$sql_row1['a_s30']*$sql_row1['a_plies'];
			$act_s31=$sql_row1['a_s31']*$sql_row1['a_plies'];
			$act_s32=$sql_row1['a_s32']*$sql_row1['a_plies'];
			$act_s33=$sql_row1['a_s33']*$sql_row1['a_plies'];
			$act_s34=$sql_row1['a_s34']*$sql_row1['a_plies'];
			$act_s35=$sql_row1['a_s35']*$sql_row1['a_plies'];
			$act_s36=$sql_row1['a_s36']*$sql_row1['a_plies'];
			$act_s37=$sql_row1['a_s37']*$sql_row1['a_plies'];
			$act_s38=$sql_row1['a_s38']*$sql_row1['a_plies'];
			$act_s39=$sql_row1['a_s39']*$sql_row1['a_plies'];
			$act_s40=$sql_row1['a_s40']*$sql_row1['a_plies'];
			$act_s41=$sql_row1['a_s41']*$sql_row1['a_plies'];
			$act_s42=$sql_row1['a_s42']*$sql_row1['a_plies'];
			$act_s43=$sql_row1['a_s43']*$sql_row1['a_plies'];
			$act_s44=$sql_row1['a_s44']*$sql_row1['a_plies'];
			$act_s45=$sql_row1['a_s45']*$sql_row1['a_plies'];
			$act_s46=$sql_row1['a_s46']*$sql_row1['a_plies'];
			$act_s47=$sql_row1['a_s47']*$sql_row1['a_plies'];
			$act_s48=$sql_row1['a_s48']*$sql_row1['a_plies'];
			$act_s49=$sql_row1['a_s49']*$sql_row1['a_plies'];
			$act_s50=$sql_row1['a_s50']*$sql_row1['a_plies'];

		$act_total=$act_xs+$act_s+$act_m+$act_l+$act_xl+$act_xxl+$act_xxxl+$act_s01+$act_s02+$act_s03+$act_s04+$act_s05+$act_s06+$act_s07+$act_s08+$act_s09+$act_s10+$act_s11+$act_s12+$act_s13+$act_s14+$act_s15+$act_s16+$act_s17+$act_s18+$act_s19+$act_s20+$act_s21+$act_s22+$act_s23+$act_s24+$act_s25+$act_s26+$act_s27+$act_s28+$act_s29+$act_s30+$act_s31+$act_s32+$act_s33+$act_s34+$act_s35+$act_s36+$act_s37+$act_s38+$act_s39+$act_s40+$act_s41+$act_s42+$act_s43+$act_s44+$act_s45+$act_s46+$act_s47+$act_s48+$act_s49+$act_s50;
		
		$sql2="select mklength from $bai_pro3.maker_stat_log where tid='$mk_ref'";
		//mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$mk_length=$sql_row2['mklength'];
		}
		
		$doc_req=$mk_length*$a_plies;
		
		

		$sql1="select COALESCE(binding_consumption,0) as \"binding_consumption\" from $bai_pro3.cat_stat_log where tid='$cat_ref'";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error h".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$binding_consumption=$sql_row1['binding_consumption'];
		}	
		$doc_req+=$act_total*$binding_consumption;
	}
	
	
	$sql1="select * from $bai_pro3.cat_stat_log where tid='$cat_ref'";
	//echo $sql1."<br>";
	//mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error 14".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$category=$sql_row1['category'];
		$order_tid=$sql_row1['order_tid'];
		$cat_yy=$sql_row1['catyy'];
	}	
	$sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		//mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error 15".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color_code=$sql_row1['color_code'];
			$color=$sql_row1['order_col_des'];
		}	
	
	
	
	
	$net_util=$fab_rec-$fab_ret-$damages_new-$shortages_new-$endbits;
	$act_con=round(($fab_rec-$fab_ret)/$act_total,4);
	$net_con=round($net_util/$act_total,4);
	$act_saving=round(($cat_yy*$act_total)-($act_con*$act_total),1);
	
	//New code for avoiding division error
	/*if($cat_yy != 0)
	{
		$act_saving_pct=round((($cat_yy-$act_con)/$cat_yy)*100,1);
		$net_saving_pct=round((($cat_yy-$net_con)/$cat_yy)*100,1);
	}
	else
	{
		$act_saving_pct=0;
		$net_saving_pct=0;
	}*/
	
	$act_saving_pct=round((($cat_yy-$act_con)/$cat_yy)*100,1);
	$net_saving_pct=round((($cat_yy-$net_con)/$cat_yy)*100,1);
	
	$net_saving=round(($cat_yy*$act_total)-($net_con*$act_total),1);
	
	
	
	
	$requested=$requested+($cat_yy*$act_total);
	$allocated=$allocated+($act_con*$act_total);
	$utilized=$utilized+($net_con*$act_total);
}
	$act_saving_sum=round($requested-$allocated,1);
	$act_saving_pct=round(($act_saving_sum/$requested)*100,0);
	$net_saving_sum=round($requested-$utilized,1);
	$net_saving_pct=round(($net_saving_sum/$requested)*100,0);
	
	echo" <tr height=17 style='height:12.75pt'>";
	echo "<td class=xl6618241 style='border-top:none'>$section_new</td>";
	echo "<td>$shift_new</td>";
	echo "<td>$cut_qty</td>";
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


