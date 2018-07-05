<?php
$username="sfcsproject1";
$view_access=array("sfcsproject1");
$authorized=array("sfcsproject1");
$authorized2=array("sfcsproject1");
$authorized3=array("sfcsproject1");

?>
<?php
set_time_limit(9000);
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
// $start_date_w="2017-12-09";
// $end_date_w="2018-07-04";
// echo $start_date_w;
// echo $end_date_w;
?>


<style>

.toggleview li{
	float:left;
	padding: 10px;
	
	margin:2px;
}
#tableone thead.Fixed
{
     position: absolute; 
}
</style>

<style>
table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #29759C;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURL($_GET['r'],'common/css/TableFilter_EN/filtergrid.css',3,'R')?>"></script>
<script>
function dodisablenew()
{
	document.getElementById('update').disabled='true';
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled=false;
	} 
	else 
	{
		document.getElementById('update').disabled=true;
	}
}
</script>

<div class="panel panel-primary">
<div class="panel-heading">Weekly Delivery Report</div>
<div class="panel-body">
<?php
	// include("../dbconf3.php");
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>

<?php

if(isset($_GET['division']))
{
	$division=$_GET['division'];
}
else
{
	$division=$_POST['division'];
}
$pending=$_POST['pending'];
?>



<form method="post" name="input" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">

<div class="row">
<div class='col-md-3'>
<label>Buyer Division: </label><select name="division" class="select2_single form-control">
<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
<?php 
$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
// echo $sqly."<br>";

mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
	$buyer_div=$sql_rowy['buyer_div'];
	$buyer_name=$sql_rowy['buyer_name'];

	if(urldecode($_GET["view_div"])=="$buyer_name") 
	{
		echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
	} 
	else 
	{
		echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
	}
}

?>
</select>
</div>

<div class='col-md-2' style="margin-top: 23px;">
<input type="checkbox" name="custom" value="1" <?php if(isset($_POST['custom'])) { echo "checked"; } ?>> Custom View 
<!-- Pending Deliveries (Yes) : <input type="checkbox" name="pending" value="1" <?php if($pending==1){ echo "checked";} ?>> -->
</div>
<input type="submit" class="btn btn-success" value="Show" name="submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';" style="margin-top: 22px;">  <!--11-21-2013 by dharani-->
</div>
</form>

<!---<span id="msg" style="display:none;"><h4>Please Wait.. While Processing The Data..<h4></span>--->   <!--11-21-2013 by dharani-->
<?php
$start_date_w_new=time();

while((date("N",$start_date_w_new))!=1) {
$start_date_w_new=$start_date_w_new-(60*60*24); // define monday
}
$end_date_w_new=$start_date_w_new+(60*60*24*6); // define sunday 

$start_date_w_new=date("Y-m-d",$start_date_w_new);
$end_date_w_new=date("Y-m-d",$end_date_w_new);

$start_date_w_new=date("Y-m-d",strtotime("-7 days", strtotime($start_date_w_new)));
$end_date_w_new=date("Y-m-d",strtotime("-7 days", strtotime($end_date_w_new)));

// echo '<div align="right"><h3><a href="week_delivery_plan_view3_next_wk.php?start_date_w_new='.$start_date_w_new.'&end_date_w_new='.$end_date_w_new.'&title=Previous"><< Prev. Week</a>';

$start_date_w_new=time();

while((date("N",$start_date_w_new))!=1) {
$start_date_w_new=$start_date_w_new-(60*60*24); // define monday
}
$end_date_w_new=$start_date_w_new+(60*60*24*6); // define sunday 

$start_date_w_new=date("Y-m-d",$start_date_w_new);
$end_date_w_new=date("Y-m-d",$end_date_w_new);

$start_date_w_new=date("Y-m-d",strtotime("+7 days", strtotime($start_date_w_new)));
$end_date_w_new=date("Y-m-d",strtotime("+7 days", strtotime($end_date_w_new)));

// echo '<a href="week_delivery_plan_view3_next_wk.php?start_date_w_new='.$start_date_w_new.'&end_date_w_new='.$end_date_w_new.'&title=Next"><h3>Next Week >></a></h3></div>';

?>
</form>

<?php

$sizes_array=array('s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');


if(isset($_POST['submit']) || isset($_GET['division']))
{
	echo "<hr/>";
	// echo '<a href="week_delivery_plan_view3_excel.php">Export to Excel</a> | <a href="week_cache/">Archive</a>';
	if(isset($_GET['division']))
	{
		$division=$_GET['division'];
	}
	else
	{
		$division=$_POST['division'];
	}
	
	$pending=$_POST['pending'];

	if($division!='ALL' && $division!='')
	{
		$buyer_division=$division;
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$order_div_ref="and buyer_division in (".$buyer_division_ref.")";
	}
	else {
		 $order_div_ref='';
	}	
	
	$sql_res="select * from $bai_pro4.weekly_cap_reasons where category=1";
	// echo $sql_res."<br>";
	$sql_result_res=mysqli_query($link, $sql_res) or exit("Sql Error".$sql_res."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_res=mysqli_fetch_array($sql_result_res))
	{
		$searial_no[]=$sql_row_res["sno"];
		$reason_ref[]=$sql_row_res["reason"];
		$color_code_ref[]=$sql_row_res["color_code"];
	}
	//	for($j=0;$j<sizeof($searial_no);$j++)
	//	{
	//		echo $searial_no[$j]."<br>";
	//	}
	$query="where ex_factory_date_new between \"$start_date_w\" and  \"$end_date_w\" order by left(style,1),schedule_no+0";
	if($division!="All")
	{
		$query="where ex_factory_date_new between \"$start_date_w\" and  \"$end_date_w\" ".$order_div_ref." order by left(style,1),schedule_no+0";
	}
	
	echo '<div class="table-responsive">';
	//echo '<div id="targetone" name="targetone" class="target col-sm-12 toggleview">toggle columns:</div>';
	echo '<form method="post" name="test" action='.getFullURL($_GET['r'],'week_delivery_plan_edit_process.php','N').'>
			<p style="float:right">
				<input type="checkbox" name="option"  id="option" height= "21px" onclick="javascript:enableButton();">Enable
				<input type="submit" name="update" id="update" class="btn btn-success" disabled value="Update">
			</p>';
	echo '</form>';

	echo '<table id="tableone" name="table_one" cellspacing="0" class="table table-bordered"><thead>';

	echo '<tr>
		<th>S. No</th>	<th class="filter">Buyer Division</th>	<th class="filter">MPO</th>	<th class="filter">CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th class="filter">Style No.</th>	<th class="filter">Schedule No.</th>	<th>Colour</th><th>Actual Cut %</th><th>Ext Ship %</th>	<th>Order Total</th><th>Actual Total</th><th>Act Out %</th><th class="filter">Current Status</th><th>Rejection %</th><th>M3 Ship Qty</th><th>Total</th><th>Size</th><th>Quantity</th>';
		if(!isset($_POST['custom']))
		{
			//echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>	<th>S06</th><th>S08</th>	<th>S10</th>	<th>S12</th>	<th>S14</th>	<th>S16</th>	<th>S18</th>	<th>S20</th>	<th>S22</th>	<th>S24</th>	<th>S26</th>	<th>S28</th><th>S30</th>';
		}


	echo '<th class="filter">Ex Factory</th><th class="filter">Rev. Ex-Factory</th><th class="filter">Mode</th>
		  <th class="filter">Rev. Mode</th><th class="filter">Packing Method</th><th>Plan End Date</th>	
		  <th class="filter">Exe. Sections</th><th>Embellishment</th>';
	if(!isset($_POST['custom']))
	{
		echo '<th>Plan</th><th>Actual</th><th>Plan</th><th>Actual</th><th>Plan</th><th>Actual</th>	
			  <th>Plan</th><th>Actual</th><th>Plan</th><th>Actual</th><th>Plan</th><th>Actual</th>';
	}
	echo '	<th>Plan Module</th><th>Actual Module</th><th>Planning Remarks</th><th>Production Remarks</th>
		 	<th>Commitments</th><th>Remarks</th>
		</tr>';
	echo '</thead><tbody>';

	//TEMP Tables

	$sql="Truncate $bai_pro4.week_delivery_plan_ref_temp";
	// echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="Truncate $bai_pro4.week_delivery_plan_temp";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="Truncate $bai_pro4.shipment_plan_ref_view";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="insert into $bai_pro4.week_delivery_plan_ref_temp select * from $bai_pro4.week_delivery_plan_ref $query";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="insert into $bai_pro4.week_delivery_plan_temp select * from $bai_pro4.week_delivery_plan where ref_id in (select ref_id from $bai_pro4.week_delivery_plan_ref_temp $query)";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql="insert into $bai_pro4.shipment_plan_ref_view select * from $bai_pro4.shipment_plan_ref where ship_tid in (select shipment_plan_id from $bai_pro4.week_delivery_plan_temp)";
	mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$table_ref3="shipment_plan_ref_view";
	$table_ref="week_delivery_plan_ref_temp";
	$table_ref2="week_delivery_plan_temp";
	//TEMP Tables
	$x=1;
	$sql="select * from $bai_pro4.$table_ref2 where ref_id in (select ref_id from $bai_pro4.$table_ref $query) order by ref_id+0";
	// echo $sql."<br>";
	// mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$edit_ref=$sql_row['ref_id'];
		//$x=$edit_ref;
		$shipment_plan_id=$sql_row['shipment_plan_id'];
		$fastreact_plan_id=$sql_row['fastreact_plan_id'];
		$size_xs=$sql_row['size_xs'];
		$size_s=$sql_row['size_s'];
		$size_m=$sql_row['size_m'];
		$size_l=$sql_row['size_l'];
		$size_xl=$sql_row['size_xl'];
		$size_xxl=$sql_row['size_xxl'];
		$size_xxxl=$sql_row['size_xxxl'];
		$size_s01=$sql_row['size_s01'];
		$size_s02=$sql_row['size_s02'];
		$size_s03=$sql_row['size_s03'];
		$size_s04=$sql_row['size_s04'];
		$size_s05=$sql_row['size_s05'];
		$size_s06=$sql_row['size_s06'];
		$size_s07=$sql_row['size_s07'];
		$size_s08=$sql_row['size_s08'];
		$size_s09=$sql_row['size_s09'];
		$size_s10=$sql_row['size_s10'];
		$size_s11=$sql_row['size_s11'];
		$size_s12=$sql_row['size_s12'];
		$size_s13=$sql_row['size_s13'];
		$size_s14=$sql_row['size_s14'];
		$size_s15=$sql_row['size_s15'];
		$size_s16=$sql_row['size_s16'];
		$size_s17=$sql_row['size_s17'];
		$size_s18=$sql_row['size_s18'];
		$size_s19=$sql_row['size_s19'];
		$size_s20=$sql_row['size_s20'];
		$size_s21=$sql_row['size_s21'];
		$size_s22=$sql_row['size_s22'];
		$size_s23=$sql_row['size_s23'];
		$size_s24=$sql_row['size_s24'];
		$size_s25=$sql_row['size_s25'];
		$size_s26=$sql_row['size_s26'];
		$size_s27=$sql_row['size_s27'];
		$size_s28=$sql_row['size_s28'];
		$size_s29=$sql_row['size_s29'];
		$size_s30=$sql_row['size_s30'];
		$size_s31=$sql_row['size_s31'];
		$size_s32=$sql_row['size_s32'];
		$size_s33=$sql_row['size_s33'];
		$size_s34=$sql_row['size_s34'];
		$size_s35=$sql_row['size_s35'];
		$size_s36=$sql_row['size_s36'];
		$size_s37=$sql_row['size_s37'];
		$size_s38=$sql_row['size_s38'];
		$size_s39=$sql_row['size_s39'];
		$size_s40=$sql_row['size_s40'];
		$size_s41=$sql_row['size_s41'];
		$size_s42=$sql_row['size_s42'];
		$size_s43=$sql_row['size_s43'];
		$size_s44=$sql_row['size_s44'];
		$size_s45=$sql_row['size_s45'];
		$size_s46=$sql_row['size_s46'];
		$size_s47=$sql_row['size_s47'];
		$size_s48=$sql_row['size_s48'];
		$size_s49=$sql_row['size_s49'];
		$size_s50=$sql_row['size_s50'];

		$plan_start_date=$sql_row['plan_start_date'];
		$plan_comp_date=$sql_row['plan_comp_date'];
		$size_comp_xs=$sql_row['size_comp_xs'];
		$size_comp_s=$sql_row['size_comp_s'];
		$size_comp_m=$sql_row['size_comp_m'];
		$size_comp_l=$sql_row['size_comp_l'];
		$size_comp_xl=$sql_row['size_comp_xl'];
		$size_comp_xxl=$sql_row['size_comp_xxl'];
		$size_comp_xxxl=$sql_row['size_comp_xxxl'];
		$size_comp_s06=$sql_row['size_comp_s06'];
		$size_comp_s08=$sql_row['size_comp_s08'];
		$size_comp_s10=$sql_row['size_comp_s10'];
		$size_comp_s12=$sql_row['size_comp_s12'];
		$size_comp_s14=$sql_row['size_comp_s14'];
		$size_comp_s16=$sql_row['size_comp_s16'];
		$size_comp_s18=$sql_row['size_comp_s18'];
		$size_comp_s20=$sql_row['size_comp_s20'];
		$size_comp_s22=$sql_row['size_comp_s22'];
		$size_comp_s24=$sql_row['size_comp_s24'];
		$size_comp_s26=$sql_row['size_comp_s26'];
		$size_comp_s28=$sql_row['size_comp_s28'];
		$size_comp_s30=$sql_row['size_comp_s30'];
		$size_comp_s01=$sql_row['size_comp_s01'];
		$size_comp_s02=$sql_row['size_comp_s02'];
		$size_comp_s03=$sql_row['size_comp_s03'];
		$size_comp_s04=$sql_row['size_comp_s04'];
		$size_comp_s05=$sql_row['size_comp_s05'];
		$size_comp_s06=$sql_row['size_comp_s06'];
		$size_comp_s07=$sql_row['size_comp_s07'];
		$size_comp_s08=$sql_row['size_comp_s08'];
		$size_comp_s09=$sql_row['size_comp_s09'];
		$size_comp_s10=$sql_row['size_comp_s10'];
		$size_comp_s11=$sql_row['size_comp_s11'];
		$size_comp_s12=$sql_row['size_comp_s12'];
		$size_comp_s13=$sql_row['size_comp_s13'];
		$size_comp_s14=$sql_row['size_comp_s14'];
		$size_comp_s15=$sql_row['size_comp_s15'];
		$size_comp_s16=$sql_row['size_comp_s16'];
		$size_comp_s17=$sql_row['size_comp_s17'];
		$size_comp_s18=$sql_row['size_comp_s18'];
		$size_comp_s19=$sql_row['size_comp_s19'];
		$size_comp_s20=$sql_row['size_comp_s20'];
		$size_comp_s21=$sql_row['size_comp_s21'];
		$size_comp_s22=$sql_row['size_comp_s22'];
		$size_comp_s23=$sql_row['size_comp_s23'];
		$size_comp_s24=$sql_row['size_comp_s24'];
		$size_comp_s25=$sql_row['size_comp_s25'];
		$size_comp_s26=$sql_row['size_comp_s26'];
		$size_comp_s27=$sql_row['size_comp_s27'];
		$size_comp_s28=$sql_row['size_comp_s28'];
		$size_comp_s29=$sql_row['size_comp_s29'];
		$size_comp_s30=$sql_row['size_comp_s30'];
		$size_comp_s31=$sql_row['size_comp_s31'];
		$size_comp_s32=$sql_row['size_comp_s32'];
		$size_comp_s33=$sql_row['size_comp_s33'];
		$size_comp_s34=$sql_row['size_comp_s34'];
		$size_comp_s35=$sql_row['size_comp_s35'];
		$size_comp_s36=$sql_row['size_comp_s36'];
		$size_comp_s37=$sql_row['size_comp_s37'];
		$size_comp_s38=$sql_row['size_comp_s38'];
		$size_comp_s39=$sql_row['size_comp_s39'];
		$size_comp_s40=$sql_row['size_comp_s40'];
		$size_comp_s41=$sql_row['size_comp_s41'];
		$size_comp_s42=$sql_row['size_comp_s42'];
		$size_comp_s43=$sql_row['size_comp_s43'];
		$size_comp_s44=$sql_row['size_comp_s44'];
		$size_comp_s45=$sql_row['size_comp_s45'];
		$size_comp_s46=$sql_row['size_comp_s46'];
		$size_comp_s47=$sql_row['size_comp_s47'];
		$size_comp_s48=$sql_row['size_comp_s48'];
		$size_comp_s49=$sql_row['size_comp_s49'];
		$size_comp_s50=$sql_row['size_comp_s50'];

		$plan_sec1=$sql_row['plan_sec1'];
		$plan_sec2=$sql_row['plan_sec2'];
		$plan_sec3=$sql_row['plan_sec3'];
		$plan_sec4=$sql_row['plan_sec4'];
		$plan_sec5=$sql_row['plan_sec5'];
		$plan_sec6=$sql_row['plan_sec6'];
		$plan_sec7=$sql_row['plan_sec7'];
		$plan_sec8=$sql_row['plan_sec8'];
		$plan_sec9=$sql_row['plan_sec9'];
		$actu_sec1=$sql_row['actu_sec1'];
		$actu_sec2=$sql_row['actu_sec2'];
		$actu_sec3=$sql_row['actu_sec3'];
		$actu_sec4=$sql_row['actu_sec4'];
		$actu_sec5=$sql_row['actu_sec5'];
		$actu_sec6=$sql_row['actu_sec6'];
		$actu_sec7=$sql_row['actu_sec7'];
		$actu_sec8=$sql_row['actu_sec8'];
		$actu_sec9=$sql_row['actu_sec9'];
		$tid=$sql_row['tid'];
		$r_tid=$sql_row['ref_id'];
		$act_rej=$sql_row['act_rej'];

		$remarks=array();
		$remarks=explode("^",$sql_row['remarks']);

		//TEMP Enabled

		$embl_tag=$sql_row['rev_emb_status'];
		$rev_ex_factory_date=$sql_row['rev_exfactory']; 
		$rev_mode=$sql_row['rev_mode']; 
		if($rev_ex_factory_date=="0000-00-00")
		{
			$rev_ex_factory_date="";
		}

		$executed_sec=array();
		if($actu_sec1>0 or $plan_sec1>0){$executed_sec[]="1";}
		if($actu_sec2>0 or $plan_sec2>0){$executed_sec[]="2";}
		if($actu_sec3>0 or $plan_sec3>0){$executed_sec[]="3";}
		if($actu_sec4>0 or $plan_sec4>0){$executed_sec[]="4";}
		if($actu_sec5>0 or $plan_sec5>0){$executed_sec[]="5";}
		if($actu_sec6>0 or $plan_sec6>0){$executed_sec[]="6";}

		//$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
		$actu_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
		$plan_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;

		$rej_per=0;	 

		$order_total=0;

		$sql1="select * from $bai_pro4.$table_ref3 where ship_tid=$shipment_plan_id";
		// echo "<br>2=".$sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2x".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$order_no=$sql_row1['order_no'];
			$delivery_no=$sql_row1['delivery_no'];
			$del_status=$sql_row1['del_status'];
			$mpo=trim($sql_row1['mpo']);
			$cpo=trim($sql_row1['cpo']);
			$buyer=trim($sql_row1['buyer']);
			$product=$sql_row1['product'];
			$buyer_division=trim($sql_row1['buyer_division']);
			$style=trim($sql_row1['style']);
			$schedule_no=$sql_row1['schedule_no'];
			$color=$sql_row1['color'];
			$size=$sql_row1['size'];
			$z_feature=$sql_row1['z_feature'];
			$ord_qty=$sql_row1['ord_qty'];
			//$order_total=$sql_row1['ord_qty_new'];
			
			//$ex_factory_date=$sql_row1['ex_factory_date']; //TEMP Disabled due to M3 Issue
			$mode=$sql_row1['mode'];
			$destination=$sql_row1['destination'];
			$packing_method=$sql_row1['packing_method'];
			$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
			$cm_value=$sql_row1['cm_value'];
			$ssc_code=$sql_row1['ssc_code'];
			$order_tid=$sql_row1['ssc_code_new'];// for cut% variable
			$ship_tid=$sql_row1['ship_tid'];
			$week_code=$sql_row1['week_code'];
			$status=$sql_row1['status'];
			
			
			//Start Need to capture plan and actual modules based on schedule number
			$sql12 = "select GROUP_CONCAT(DISTINCT plan_module) as module from $bai_pro3.plandoc_stat_log where order_tid like '% $schedule_no%'";
			//$plan_mod = array();
			// echo $sql12;
			$query12 = mysqli_query($link, $sql12) or die("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				while($row12 = mysqli_fetch_array($query12))
				{
					$plan_modu = $row12['module'];
				}
			if($plan_modu>0)
			{
				$plan_mod = $plan_modu;
			}
			else
			{
				$plan_mod = 0;
			}
			$sql13 = "SELECT GROUP_CONCAT(DISTINCT bac_no) as bac_no FROM $bai_pro.bai_log_buf where delivery = '$schedule_no' and bac_qty>0";
			//$act_mod = array();
			$query13 = mysqli_query($link, $sql13) or die("Sql Error 13".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				while($row13 = mysqli_fetch_array($query13))
				{
					$act_modu = $row13['bac_no'];
				}
			if($act_modu>0)
			{
				$act_mod = $act_modu;
			}
			else
			{
				$act_mod = 0;
			}
		}

		// open data from production review for cut%
					
		$CID=0;
		$sql1z="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($in_categories) and purwidth>0";
		// echo "<br>".$sql1z."<br>";
		mysqli_query($link, $sql1z) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1z=mysqli_query($link, $sql1z) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1z=mysqli_fetch_array($sql_result1z))
		{
			$CID=$sql_row1z['tid'];
		}

		$sqlc="SELECT cuttable_percent as cutper from $bai_pro3.cuttable_stat_log where cat_id=$CID";
		//echo $sqlc;
		$sql_resultc=mysqli_query($link, $sqlc) or exit("Sql Error41".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowc=mysqli_fetch_array($sql_resultc))
		{
			$cut_per=$sql_rowc['cutper'];
			//echo "cut_per=".$cut_per;
		}

		$sqla="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		$sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error51".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_confirma=mysqli_num_rows($sql_resulta);

		if($sql_num_confirma>0)
		{
			$sqlza="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
		}
		else
		{
			$sqlza="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
		}
		// echo "<br>4=".$sqlza."<br>";
		mysqli_query($link, $sqlza) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resultza=mysqli_query($link, $sqlza) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowza=mysqli_fetch_array($sql_resultza))
		{			
			$o_xs=$sql_rowza['order_s_xs'];
			$o_s=$sql_rowza['order_s_s'];
			$o_m=$sql_rowza['order_s_m'];
			$o_l=$sql_rowza['order_s_l'];
			$o_xl=$sql_rowza['order_s_xl'];
			$o_xxl=$sql_rowza['order_s_xxl'];
			$o_xxxl=$sql_rowza['order_s_xxxl'];
			$act_cut_val=$sql_rowza['act_cut'];
			$act_out_val=$sql_rowza['output'];
			$title_size_s01=$sql_rowza['title_size_s01'];
			$title_size_s02=$sql_rowza['title_size_s02'];
			$title_size_s03=$sql_rowza['title_size_s03'];
			$title_size_s04=$sql_rowza['title_size_s04'];
			$title_size_s05=$sql_rowza['title_size_s05'];
			$title_size_s06=$sql_rowza['title_size_s06'];
			$title_size_s07=$sql_rowza['title_size_s07'];
			$title_size_s08=$sql_rowza['title_size_s08'];
			$title_size_s09=$sql_rowza['title_size_s09'];
			$title_size_s10=$sql_rowza['title_size_s10'];
			$title_size_s11=$sql_rowza['title_size_s11'];
			$title_size_s12=$sql_rowza['title_size_s12'];
			$title_size_s13=$sql_rowza['title_size_s13'];
			$title_size_s14=$sql_rowza['title_size_s14'];
			$title_size_s15=$sql_rowza['title_size_s15'];
			$title_size_s16=$sql_rowza['title_size_s16'];
			$title_size_s17=$sql_rowza['title_size_s17'];
			$title_size_s18=$sql_rowza['title_size_s18'];
			$title_size_s19=$sql_rowza['title_size_s19'];
			$title_size_s20=$sql_rowza['title_size_s20'];
			$title_size_s21=$sql_rowza['title_size_s21'];
			$title_size_s22=$sql_rowza['title_size_s22'];
			$title_size_s23=$sql_rowza['title_size_s23'];
			$title_size_s24=$sql_rowza['title_size_s24'];
			$title_size_s25=$sql_rowza['title_size_s25'];
			$title_size_s26=$sql_rowza['title_size_s26'];
			$title_size_s27=$sql_rowza['title_size_s27'];
			$title_size_s28=$sql_rowza['title_size_s28'];
			$title_size_s29=$sql_rowza['title_size_s29'];
			$title_size_s30=$sql_rowza['title_size_s30'];
			$title_size_s31=$sql_rowza['title_size_s31'];
			$title_size_s32=$sql_rowza['title_size_s32'];
			$title_size_s33=$sql_rowza['title_size_s33'];
			$title_size_s34=$sql_rowza['title_size_s34'];
			$title_size_s35=$sql_rowza['title_size_s35'];
			$title_size_s36=$sql_rowza['title_size_s36'];
			$title_size_s37=$sql_rowza['title_size_s37'];
			$title_size_s38=$sql_rowza['title_size_s38'];
			$title_size_s39=$sql_rowza['title_size_s39'];
			$title_size_s40=$sql_rowza['title_size_s40'];
			$title_size_s41=$sql_rowza['title_size_s41'];
			$title_size_s42=$sql_rowza['title_size_s42'];
			$title_size_s43=$sql_rowza['title_size_s43'];
			$title_size_s44=$sql_rowza['title_size_s44'];
			$title_size_s45=$sql_rowza['title_size_s45'];
			$title_size_s46=$sql_rowza['title_size_s46'];
			$title_size_s47=$sql_rowza['title_size_s47'];
			$title_size_s48=$sql_rowza['title_size_s48'];
			$title_size_s49=$sql_rowza['title_size_s49'];
			$title_size_s50=$sql_rowza['title_size_s50'];
			$title_size_s01=$sql_rowza['title_size_s01'];
			$title_size_s02=$sql_rowza['title_size_s02'];
			$title_size_s03=$sql_rowza['title_size_s03'];
			$title_size_s04=$sql_rowza['title_size_s04'];
			$title_size_s05=$sql_rowza['title_size_s05'];
			$title_size_s06=$sql_rowza['title_size_s06'];
			$title_size_s07=$sql_rowza['title_size_s07'];
			$title_size_s08=$sql_rowza['title_size_s08'];
			$title_size_s09=$sql_rowza['title_size_s09'];
			$title_size_s10=$sql_rowza['title_size_s10'];
			$title_size_s11=$sql_rowza['title_size_s11'];
			$title_size_s12=$sql_rowza['title_size_s12'];
			$title_size_s13=$sql_rowza['title_size_s13'];
			$title_size_s14=$sql_rowza['title_size_s14'];
			$title_size_s15=$sql_rowza['title_size_s15'];
			$title_size_s16=$sql_rowza['title_size_s16'];
			$title_size_s17=$sql_rowza['title_size_s17'];
			$title_size_s18=$sql_rowza['title_size_s18'];
			$title_size_s19=$sql_rowza['title_size_s19'];
			$title_size_s20=$sql_rowza['title_size_s20'];
			$title_size_s21=$sql_rowza['title_size_s21'];
			$title_size_s22=$sql_rowza['title_size_s22'];
			$title_size_s23=$sql_rowza['title_size_s23'];
			$title_size_s24=$sql_rowza['title_size_s24'];
			$title_size_s25=$sql_rowza['title_size_s25'];
			$title_size_s26=$sql_rowza['title_size_s26'];
			$title_size_s27=$sql_rowza['title_size_s27'];
			$title_size_s28=$sql_rowza['title_size_s28'];
			$title_size_s29=$sql_rowza['title_size_s29'];
			$title_size_s30=$sql_rowza['title_size_s30'];
			$title_size_s31=$sql_rowza['title_size_s31'];
			$title_size_s32=$sql_rowza['title_size_s32'];
			$title_size_s33=$sql_rowza['title_size_s33'];
			$title_size_s34=$sql_rowza['title_size_s34'];
			$title_size_s35=$sql_rowza['title_size_s35'];
			$title_size_s36=$sql_rowza['title_size_s36'];
			$title_size_s37=$sql_rowza['title_size_s37'];
			$title_size_s38=$sql_rowza['title_size_s38'];
			$title_size_s39=$sql_rowza['title_size_s39'];
			$title_size_s40=$sql_rowza['title_size_s40'];
			$title_size_s41=$sql_rowza['title_size_s41'];
			$title_size_s42=$sql_rowza['title_size_s42'];
			$title_size_s43=$sql_rowza['title_size_s43'];
			$title_size_s44=$sql_rowza['title_size_s44'];
			$title_size_s45=$sql_rowza['title_size_s45'];
			$title_size_s46=$sql_rowza['title_size_s46'];
			$title_size_s47=$sql_rowza['title_size_s47'];
			$title_size_s48=$sql_rowza['title_size_s48'];
			$title_size_s49=$sql_rowza['title_size_s49'];
			$title_size_s50=$sql_rowza['title_size_s50'];			
			
			$total_ord=$sql_rowza['old_order_s_s01']+$sql_rowza['old_order_s_s02']+$sql_rowza['old_order_s_s03']+$sql_rowza['old_order_s_s04']+$sql_rowza['old_order_s_s05']+$sql_rowza['old_order_s_s06']+$sql_rowza['old_order_s_s07']+$sql_rowza['old_order_s_s08']+$sql_rowza['old_order_s_s09']+$sql_rowza['old_order_s_s10']+$sql_rowza['old_order_s_s11']+$sql_rowza['old_order_s_s12']+$sql_rowza['old_order_s_s13']+$sql_rowza['old_order_s_s14']+$sql_rowza['old_order_s_s15']+$sql_rowza['old_order_s_s16']+$sql_rowza['old_order_s_s17']+$sql_rowza['old_order_s_s18']+$sql_rowza['old_order_s_s19']+$sql_rowza['old_order_s_s20']+$sql_rowza['old_order_s_s21']+$sql_rowza['old_order_s_s22']+$sql_rowza['old_order_s_s23']+$sql_rowza['old_order_s_s24']+$sql_rowza['old_order_s_s25']+$sql_rowza['old_order_s_s26']+$sql_rowza['old_order_s_s27']+$sql_rowza['old_order_s_s28']+$sql_rowza['old_order_s_s29']+$sql_rowza['old_order_s_s30']+$sql_rowza['old_order_s_s31']+$sql_rowza['old_order_s_s32']+$sql_rowza['old_order_s_s33']+$sql_rowza['old_order_s_s34']+$sql_rowza['old_order_s_s35']+$sql_rowza['old_order_s_s36']+$sql_rowza['old_order_s_s37']+$sql_rowza['old_order_s_s38']+$sql_rowza['old_order_s_s39']+$sql_rowza['old_order_s_s40']+$sql_rowza['old_order_s_s41']+$sql_rowza['old_order_s_s42']+$sql_rowza['old_order_s_s43']+$sql_rowza['old_order_s_s44']+$sql_rowza['old_order_s_s45']+$sql_rowza['old_order_s_s46']+$sql_rowza['old_order_s_s47']+$sql_rowza['old_order_s_s48']+$sql_rowza['old_order_s_s49']+$sql_rowza['old_order_s_s50'];

			
			$total_qty_ord=$sql_rowza['order_s_s01']+$sql_rowza['order_s_s02']+$sql_rowza['order_s_s03']+$sql_rowza['order_s_s04']+$sql_rowza['order_s_s05']+$sql_rowza['order_s_s06']+$sql_rowza['order_s_s07']+$sql_rowza['order_s_s08']+$sql_rowza['order_s_s09']+$sql_rowza['order_s_s10']+$sql_rowza['order_s_s11']+$sql_rowza['order_s_s12']+$sql_rowza['order_s_s13']+$sql_rowza['order_s_s14']+$sql_rowza['order_s_s15']+$sql_rowza['order_s_s16']+$sql_rowza['order_s_s17']+$sql_rowza['order_s_s18']+$sql_rowza['order_s_s19']+$sql_rowza['order_s_s20']+$sql_rowza['order_s_s21']+$sql_rowza['order_s_s22']+$sql_rowza['order_s_s23']+$sql_rowza['order_s_s24']+$sql_rowza['order_s_s25']+$sql_rowza['order_s_s26']+$sql_rowza['order_s_s27']+$sql_rowza['order_s_s28']+$sql_rowza['order_s_s29']+$sql_rowza['order_s_s30']+$sql_rowza['order_s_s31']+$sql_rowza['order_s_s32']+$sql_rowza['order_s_s33']+$sql_rowza['order_s_s34']+$sql_rowza['order_s_s35']+$sql_rowza['order_s_s36']+$sql_rowza['order_s_s37']+$sql_rowza['order_s_s38']+$sql_rowza['order_s_s39']+$sql_rowza['order_s_s40']+$sql_rowza['order_s_s41']+$sql_rowza['order_s_s42']+$sql_rowza['order_s_s43']+$sql_rowza['order_s_s44']+$sql_rowza['order_s_s45']+$sql_rowza['order_s_s46']+$sql_rowza['order_s_s47']+$sql_rowza['order_s_s48']+$sql_rowza['order_s_s49']+$sql_rowza['order_s_s50'];

			
			if($act_rej==0)
			{
				$act_rej=$sql_rowza["act_rej"];
			}
			
			//$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);
			if($total_ord > 0)
			{
				$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);		
			}
			else
			{
				$extra_ship_ord=0;
			}
			$order_date=$sql_rowza["order_date"];
		}

		// Ticket #222648 / Add the Actual Out% and Ext Ship%  and Modify the Act Cut% in weekly delivery report
		if($total_ord>0)
		{
			$act_cut_per=(100+round(($act_cut_val-$total_ord)*100/$total_ord,0))."%";
			$ext_cut_per=round(($total_qty_ord-$total_ord)*100/$total_ord,0)."%";
		}
		else
		{
			$act_cut_per=(0)."%";
			$ext_cut_per=(0)."%";
		}

		//echo "old ord qty ->".$total_ord."&nbsp;&nbsp; new ord qty ->".$total_qty_ord."&nbsp;&nbsp; Act_cut ->".$act_cut_val."&nbsp;&nbsp; Act cut% ->".$act_cut_per."&nbsp;&nbsp; Ext cut% ->".$ext_cut_per."&nbsp;&nbsp; Act Out% ->".$act_out_per."<br/>";

		if($plan_total>0)
		{
		$rej_per=round(($act_rej/$plan_total)*100,1)."%"."</br>";
		}

		$cutper=(100+$cut_per+$extra_ship_ord)."%"; //For Cut % as Production Review Sheet

		// close data from production review 
		//EMB stat 20111201

		if(date("Y-m-d")>"2011-12-11")
		{
			$embl_tag="";
			$sql1="select order_embl_a,order_embl_e from $bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				if($sql_row1['order_embl_a']==1)
				{
					$embl_tag="Panle Form*";
				}
				if($sql_row1['order_embl_e']==1)
				{
					$embl_tag="Garment Form*";
				}
			}
		}

		//EMB stat

		$order_total=$sql_row['original_order_qty'];
		$act_cut=$sql_row['act_cut'];


		{

		$sql1="select * from $bai_pro4.$table_ref  where ship_tid=$shipment_plan_id";
		//echo "<br>".$sql1."<br>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$priority=$sql_row1['priority'];
			$cut=$sql_row1['act_cut'];
			$in=$sql_row1['act_in'];
			$out=$sql_row1['output'];
			$pendingcarts=$sql_row1['cart_pending'];
			$order=$sql_row1['ord_qty_new'];
			$order_qty_new_old=$sql_row1['ord_qty_new_old'];
			$fcamca=$sql_row1['act_mca'];
			$fgqty=$sql_row1['act_fg'];
			$internal_audited=$sql_row1['act_fca'];
			$act_ship=$sql_row1['act_ship'];
			$ex_factory_date=$sql_row1['act_exfact'];
		}

		if($total_ord>0)
		{
			$act_out_per=round(($out/$total_ord)*100,2)."%";
		}	
		else
		{
			$act_out_per=(0)."%";
		}

		$status="NIL";
		if($cut==0)
		{
			$status="RM";
		}
		else
		{
			if($cut>0 and $in==0)
			{
				$status="Cutting";
			}
			else
			{
				if($in>0)
				{
					$status="Sewing";
				}
			}
		}
		if($out>=$fgqty and $out>0 and $fgqty>=$order) //due to excess percentage of shipment over order qty
		{
			$status="FG";
		}
		if($out>=$order and $out>0 and $fgqty<$order)
		{
			$status="Packing";
		}

		if($status=="FG" and $internal_audited>=$fgqty)
		{
			$status="FCA";
		}

		//DISPATCH

			$sql1="select ship_qty from $bai_pro2.style_status_summ where sch_no=\"$schedule_no\"";
			//echo $sql1."<br>";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$ship_qty=$sql_row1['ship_qty'];
			}
			if($actu_total > 0)
			{
				if($plan_total>0)
				{
					$ext_ship_per=round((($plan_total-$ship_qty)/$actu_total)*100,0)."%";
				}
				else
				{
					$ext_ship_per=0;
				}
			}
			else
			{
				$ext_ship_per=0;
			}
			//echo "act ship% ->".$ext_ship_per."<br/>";
			if($status=="FG" and $fgqty>=$ship_qty and $ship_qty>=$order)
			{
				$status="M3 Dispatched";
			}
			
			if($priority==-1 and $status=="FG")
			{
				$status="Shipped";
			}
			//echo $ship_tid."-".$schedule_no."-".$status."-".$priority."-".$cut."-".$in."-".$out."-".$pendingcarts."-".$order."-".$fcamca."-".$fgqty."-".$$internal_audited."<br/>";
		//DISPATCH
		}

			//CR#930 //Fetching the color code of selected reason.
			$color_code_ref1="#FFFFFF";
			$sql_res1="select * from $bai_pro4.weekly_cap_reasons where sno=\"".$remarks[0]."\"";
			//echo $sql_res1."<br>";
			$sql_result_res1=mysqli_query($link, $sql_res1) or exit("Sql Error".$sql_res1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_res1=mysqli_fetch_array($sql_result_res1))
			{
				$color_code_ref1=$sql_row_res1["color_code"];		
			}
			
			$highlight=" bgcolor=\"".$color_code_ref1."\" ";

		if(in_array(strtolower($username),$authorized))
		{
			
			//$edit_rem="<td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td>";
			$edit_rem="<td><input type=\"text\" name=\"B[]\" value=\"".$remarks[1]."\"><input type=\"hidden\" name=\"REF[]\" value=\"".$edit_ref."\"><input type=\"hidden\" name=\"REM_REF[]\" value=\"".implode("^",$remarks)."\"><input type=\"hidden\" name=\"C[]\" value=\"".$remarks[2]."\"><input type=\"hidden\" name=\"A[]\" value=\"".$remarks[0]."\"><input type=\"hidden\" name=\"code[]\" value=\"B\"><input type=\"hidden\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\"></td>";
		}
		else
		{
			//$edit_rem="<td $highlight>".$remarks[1]."</td>";
			$edit_rem="<td $highlight>".$remarks[1]."</td>";
		}


		if(!(in_array(strtolower($username),$authorized2)))
		{
			$edit_rem2="<td $highlight>".$remarks[2]."</td>";
		}
		else
		{
			//$edit_rem="<td $highlight>".$remarks[1]."</td>";
			//$edit_rem2="<td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td>";
			$edit_rem2="<td><input type=\"text\" name=\"C[]\" value=\"".$remarks[2]."\">";
			$edit_rem2.="<input type=\"hidden\" name=\"REF[]\" value=\"".$edit_ref."\"><input type=\"hidden\" name=\"REM_REF[]\" value=\"".implode("^",$remarks)."\"><input type=\"hidden\" name=\"B[]\" value=\"".$remarks[1]."\"><input type=\"hidden\" name=\"A[]\" value=\"".$remarks[0]."\"><input type=\"hidden\" name=\"code[]\" value=\"C\"><input type=\"hidden\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\"></td>";
		}

		if(!(in_array(strtolower($username),$authorized3)))
		{
			//CR#930 //Displaying the Reasons List to Users for selecting the appropriate reason of the schedule.
			$reason_ref2="";
			$sql_res2="select * from $bai_pro4.weekly_cap_reasons where sno=\"".$remarks[0]."\"";
			//echo $sql_res1."<br>";
			$sql_result_res2=mysqli_query($link, $sql_res2) or exit("Sql Error".$sql_res2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_res2=mysqli_fetch_array($sql_result_res2))
			{
				$reason_ref2=$sql_row_res2["reason"];		
			}
			$edit_rem3="".$reason_ref2."";
		}
		else
		{
			//$edit_rem3="<input type=\"text\" name=\"A[]\" value=\"".$remarks[0]."\">";
			//CR#930 //Displaying the Reasons List to Users for selecting the appropriate reason of the schedule.
			$edit_rem3="<select name=\"A[]\">";
			$option_sta1="";	
			if($remarks[0] == 0)
			{
				$option_sta1="selected";
			}
			$edit_rem3.="<option value=\"0\" $option_sta1>Select</option>";
				
			for($i1=0;$i1<sizeof($reason_ref);$i1++)
			{
				//echo "Re=".$remarks[0]."==".$searial_no[$i1]."<br>";
				$option_sta="";
				if($remarks[0] == $searial_no[$i1])
				{    
					$option_sta="selected";
				}		
				$edit_rem3.="<option value=\"".$searial_no[$i1]."\" $option_sta>".$reason_ref[$i1]."</option>";
			}
			$edit_rem3.="</select>";
			$edit_rem3.="<input type=\"hidden\" name=\"REF[]\" value=\"".$edit_ref."\"><input type=\"hidden\" name=\"REM_REF[]\" value=\"".implode("^",$remarks)."\"><input type=\"hidden\" name=\"B[]\" value=\"".$remarks[1]."\"><input type=\"hidden\" name=\"C[]\" value=\"".$remarks[2]."\"><input type=\"hidden\" name=\"code[]\" value=\"A\">";
			$rev_ex_factory_date="<input type=\"text\" name=\"rev_exfa[]\" value=\"".$rev_ex_factory_date."\">";
		}
		//Restricted Editing for Packing Team

			if(!isset($_POST['custom']))
			{
				 for($i=0;$i<13;$i++){
					$size_val= ${'size_'.$sizes_array[$i]};
					//echo '<br>size_'.$sizes_array[$i]."<br>";
					$title_size=${'title_size_'.$sizes_array[$i]};
					if($title_size==''){
						$title_size=$sizes_array[$i];
					}
					//echo "<br>".$size_val."<br>";
					if($size_val>0){
						echo "<tr>
							 <td $highlight> $x  </td>	<td $highlight>$buyer_division</td>	<td $highlight>$mpo</td>	<td $highlight>$cpo</td>	<td $highlight>$order_no</td>	<td $highlight>$z_feature</td><td $highlight>$style</td>	<td $highlight>$schedule_no</td>	<td $highlight>$color</td><td$highlight>$act_cut_per</td><td$highlight>$ext_cut_per</td>	<td $highlight>$order_total</td><td $highlight>$plan_total</td><td $highlight>$act_out_per</td><td $highlight>$status</td><td$highlight>$rej_per</td><td$highlight>$ship_qty</td><td $highlight>$actu_total</td>";
						echo "<td $highlight>".strtoupper($title_size)."</td><td>".$size_val." </td>"; 
						echo "<td $highlight>$ex_factory_date</td><td $highlight>$rev_ex_factory_date</td>	<td $highlight>$mode</td><td $highlight>$rev_mode</td>	<td $highlight>$packing_method</td>	<td $highlight>$plan_comp_date</td><td $highlight>".implode(",",$executed_sec)."</td><td $highlight>$embl_tag</td>";
						echo "<td $highlight>$plan_sec1</td>	<td $highlight>$actu_sec1</td>	<td $highlight>$plan_sec2</td>	<td $highlight>$actu_sec2</td>	<td $highlight>$plan_sec3</td>	<td $highlight>$actu_sec3</td>	<td $highlight>$plan_sec4</td>	<td $highlight>$actu_sec4</td>	<td $highlight>$plan_sec5</td>	<td $highlight>$actu_sec5</td>	<td $highlight>$plan_sec6</td>	<td $highlight>$actu_sec6</td>"; 
						echo "<td $highlight>".$plan_mod."</td>	<td $highlight>".$act_mod."</td><td $highlight>".$edit_rem3."</td><td>".$edit_rem.$edit_rem2."</td>
							 </tr>";
						$x+=1;
					}
					
				} 
			}
	}
	//echo $i;
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
	
}

?>

<script language="javascript" type="text/javascript">

	var table3Filters = {
        status_bar: true,
	    sort_select: true,
		alternate_rows: false,
		loader_text: "Filtering data...",
		loader: true,
		rows_counter: true,
		display_all_text: "Display all",
		btn_reset : true,
	};
	setFilterGrid("tableone",table3Filters);

	jQuery(function() {
		var table = jQuery("#tableone");

		jQuery(window).scroll(function() {
			var windowTop = jQuery(window).scrollTop();
			if (windowTop > table.offset().top) {
				jQuery("thead", table).addClass("Fixed").css("top", windowTop);
			}
			else {
				jQuery("thead", table).removeClass("Fixed");
			}
		});
	});

</script>


</div>
</div>
</div>
</div>



	
