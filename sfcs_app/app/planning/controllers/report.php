<?php
	
	// include("../dbconf.php");
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
	$view_access=user_acl("SFCS_0127",$username,1,$group_id_sfcs);
	//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	//$username=$username_list[1];
	//$authorized=array("muralim","duminduw","rajanaa","kranthic","kirang","nalakasb","baiadmn","bainet","kiranm","kirang","baiuser","baiict","srikanthb","dhanyap","rajithago","kirang","khyathid");
	//if(!(in_array(strtolower($username),$authorized)))
	//{
	//	header("Location:restrict.php
	//}
?>

<script src="<?= getFullURLLevel($_GET['r'],'common/js/gs_sortable.js',1,'R'); ?>"></script>
<!-- <script src="../js/jquery-1.4.2.min.js"></script>
<script src="../js/jquery-ui-1.8.1.custom.min.js"></script>
<script src="../js/cal.js"></script> -->

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>

<!-- <script type="text/javascript">
	$(function() {
		$("#from_date").simpleDatepicker({startdate: '2010-01-01', enddate: '2020' });
		$("#to_date").simpleDatepicker({startdate: '2010-01-01', enddate: '2020' });
	});
</script> -->

<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table', 'i', 's', 's', 'f', 'i', 's', 'i', 's','','', 'd', 's', 's', 'd', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i');
tsRegister();
// -->
</script>

<?php
/*


'i' - Column contains integer data. If the column data contains a number followed by text then the text will ignored. For example, "54note" will be interpreted as "54".

'n' - Column contains integer number in which all three-digit groups are optionally separated from each other by commas. For example, column data "100,000,000" is treated as "100000000" when type of data is set to 'n', or as "100" when type of data is set to 'i'.

'f' - Column contains floating point numbers in the form ###.###.

'g' - Column contains floating point numbers in the form ###.###. Three-digit groups in the floating-point number may be separated from each other by commas. For example, column data "65,432.1" is treated as "65432.1" when type of data is set to 'g', or as "65" when type of data is set to 'f'.

'h' - column contains HTML code. The script will strip all HTML code before sorting the data.

's' - column contains plain text data.

'd' - column contains a date.

'' - do not sort the column.
*/

?>
	

<SCRIPT>

function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}


function verify_date(e){
	var val1 = $('#from_date').val();
	var val2 = $('#to_date').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		e.preventDefault();
		sweetAlert('From Date Should  be less than To Date','','warning');
		return false;
	}else{
		return true;
	}
}

</SCRIPT>

<?php
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$division=$_POST['division'];
	$pending=$_POST['pending'];
	$new=$_POST['new'];
?>
<div class="panel panel-primary"><div class="panel-heading">Delivery Schedule Report</div><div class="panel-body">

<form method="post" name="input" action="?r=<?= $_GET["r"];?>">
<!-- <label>Enter Ex-Factory </label> -->
<div class="row">
	<div class="col-md-3">
		<label>Enter Ex-Factory From Date: </label>
		<input type="text" id="from_date" class="form-control" data-toggle="datepicker" name="from_date"  size=12 value="<?php if($from_date=="") {echo  date("Y-m-d"); } else {echo $from_date;}?>">
	</div>
	<div class="col-md-2">
		<label>To Date:</label>
		<input type="text" id="to_date" class="form-control" data-toggle="datepicker" name="to_date" onchange="verify_date(event);" size=12 value="<?php if($to_date=="") {echo  date("Y-m-d"); } else {echo $to_date;}?>">
	</div>
	
	<!-- Section: <input type="text" name="section" size=12 value="">  -->
	<div class="col-md-2">
		<label>Section Buyer Division: </label>
		<select name="division" class="form-control">
		<?php
			echo "<option value=\"ALL\" selected >ALL</option>";
			//$sqly="select distinct(buyer_div) from plan_modules";
			$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
			

			// mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($sql_resulty))
			{
				$buyer_div=$sql_rowy['buyer_div'];
				$buyer_name=$sql_rowy['buyer_name'];

				if(urldecode($_GET["view_div"])=="$buyer_name") {
					echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
				} else {
					echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
				}
			}
		?>
	
		</select>
	</div>
	<div class="col-md-2">
		<label>Pending Deliveries(Yes):</label>
		<input type="checkbox" name="pending" value="1" <?php if($pending==1){ echo "checked";} ?>>
	</div>
	<div class="col-md-2">
		<label>New Added Deliveries(Yes):</label><br/>
		<input type="checkbox" name="new" value="1" <?php if($new==1){ echo "checked";} ?>>
	</div>
	<div class="col-md-1"><br/>
		<input type="submit" value="Show" name="submit" class="btn btn-primary" onclick="verify_date(event)">
	</div>
</div>
</form>
<hr/>


<?php
$week_delivery_plan = getFullURL($_GET['r'],'week_delivery_plan.php','N');
echo '<div class="row col-md-12">';
echo "<a href='$week_delivery_plan' class='col-xs-3 col-xs btn btn-info'>Delivery Schedule Week Plan</a> ";
//echo '<a href="'.$dns_adr2.'/projects/beta/visionair/shipment_plan_week.php">Update Shipment Plan</a> | ';
$sync_plan_fr = getFullURLLevel($_GET['r'],'sync_plan_fr.php',0,'N');
echo "<a href='$sync_plan_fr' class='col-xs-3 btn btn-info'>Sync. With Plan and FR</a>";
echo '</div>';
// echo '<div class="row">';

if(isset($_POST['submit']))
{
	$row_count = 0;
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];	
	$division=$_POST['division'];
	$pending=$_POST['pending'];
	$new=$_POST['new'];
	//echo $division."<br>";
	$query="";
	if($division<>"ALL")
	{
		// $query=" and MID(buyer_division,1, 2)=\"$division\"";
		$query=" and buyer_division =\"$division\"";
	}
	if($from_date > $to_date)
	{
		echo "<script>sweetAlert('From Date Should  be less than To Date','','warning');</script>";
	}else{
?>
	<div class="row">	
	<form method="post" name="test" action="?r=<?= $_GET["r"];?>">
	<label class="col-xs-1">Select All:</label>
	<?php
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'s_tid[]\', true);" class="col-xs-1 btn btn-success">ON</a>  ';
	echo '<a href="#" onclick="SetAllCheckBoxes(\'test\', \'s_tid[]\', false);" class="col-xs-1 btn btn-danger">OFF</a>  ';
	echo "<input type=\"submit\" name=\"transfer\" id='transfer' value=\"Add to Delivery Plan\" class='btn btn-success'></div>";
	?>

<div class="col-sm-12" style="overflow:scroll;max-height:800px;">

<?php
$x=1;
if($new==1)
{
	$sql="select * from $bai_pro4.shipfast_sum where shipment_plan_id in (select ship_tid from shipment_plan where ex_factory_date between \"$from_date\" and \"$to_date\" and cw_check=1 $query) and shipment_plan_id not in (select shipment_plan_id from week_delivery_plan)";
//echo $sql;
}
else
{
	$sql="select * from $bai_pro4.shipfast_sum where shipment_plan_id in (select ship_tid from shipment_plan where ex_factory_date between \"$from_date\" and \"$to_date\" and cw_check=1 $query)";

}
//$sql="select * from shipfast_sum where shipment_plan_id in (select ship_tid from shipment_plan where ex_factory_date between \"$from_date\" and \"$to_date\" and cw_check=1 $query) and shipment_plan_id not in (select shipment_plan_id from week_delivery_plan)";
//$sql="select * from shipfast_sum where shipment_plan_id in (select ship_tid from shipment_plan where ex_factory_date between \"$from_date\" and \"$to_date\" $query)";

mysqli_query($link, $sql) or exit("No Data Found");
$sql_result=mysqli_query($link, $sql) or exit("No Data Found");
while($sql_row=mysqli_fetch_array($sql_result))
{

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
$x=$tid;

$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s01+$size_s02+$size_s03+$size_s04+$size_s05+$size_s06+$size_s07+$size_s08+$size_s09+$size_s10+$size_s11+$size_s12+$size_s13+$size_s14+$size_s15+$size_s16+$size_s17+$size_s18+$size_s19+$size_s20+$size_s21+$size_s22+$size_s23+$size_s24+$size_s25+$size_s26+$size_s27+$size_s28+$size_s29+$size_s30+$size_s31+$size_s32+$size_s33+$size_s34+$size_s35+$size_s36+$size_s37+$size_s38+$size_s39+$size_s40+$size_s41+$size_s42+$size_s43+$size_s44+$size_s45+$size_s46+$size_s47+$size_s48+$size_s49+$size_s50;
$actu_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;

$sql1="select * from $bai_pro4.shipment_plan where ship_tid=$shipment_plan_id";
//echo $sql1."--".$x;
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo '

<table id="my_table" class="table table-bordered table-striped">
<thead>
<tr class="success">
<th colspan=16>Shipment Details</th><th colspan=2>Sec1</th><th colspan=2>Sec2</th><th colspan=2>Sec3</th><th colspan=2>Sec4</th>		<th colspan=2>Sec5</th>		<th colspan=2>Sec6</th>	<th colspan=57> Sizes</th>
</tr>';


// if($division=="All" )
// {
	// echo '<tr class="tblheading" >
	// <th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th>	<th>Ex Factory</th>	<th>Mode</th>	<th>Packing Method</th>	<th>Plan End Date</th>	<th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th><th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>	<th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>
	// </tr>';
// }
// else
// {
	// if($division=="M&"){
		echo '<tr class="tblheading" >
		<th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th>	<th>Ex Factory</th>	<th>Mode</th>	<th>Packing Method</th>	<th>Plan End Date</th>	<th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th><th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>
		</tr>';
	// }
	// else{
		// echo '<tr class="tblheading" >
		// <th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th>	<th>Ex Factory</th>	<th>Mode</th>	<th>Packing Method</th>	<th>Plan End Date</th>	<th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th></tr>';
	// }
// }

echo '</thead><tbody>';
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$row_count++;
	$order_no=$sql_row1['order_no'];
	$delivery_no=$sql_row1['delivery_no'];
	$del_status=$sql_row1['del_status'];
	$mpo=$sql_row1['mpo'];
	$cpo=$sql_row1['cpo'];
	$buyer=$sql_row1['buyer'];
	$product=$sql_row1['product'];
	$buyer_division=$sql_row1['buyer_division'];
	$style=$sql_row1['style'];
	$schedule_no=$sql_row1['schedule_no'];
	$color=$sql_row1['color'];
	$size=$sql_row1['size'];
	$z_feature=$sql_row1['z_feature'];
	$ord_qty=$sql_row1['ord_qty'];
	$ex_factory_date=$sql_row1['ex_factory_date'];
	$mode=$sql_row1['mode'];
	$destination=$sql_row1['destination'];
	$packing_method=$sql_row1['packing_method'];
	$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
	$cm_value=$sql_row1['cm_value'];
	$ssc_code=$sql_row1['ssc_code'];
	$ship_tid=$sql_row1['ship_tid'];
	$week_code=$sql_row1['week_code'];
	$status=$sql_row1['status'];
	
	$embl_tag=embl_check($sql_row1['order_embl_a'].$sql_row1['order_embl_b'].$sql_row1['order_embl_c'].$sql_row1['order_embl_d'].$sql_row1['order_embl_e'].$sql_row1['order_embl_f'].$sql_row1['order_embl_g'].$sql_row1['order_embl_h']);
}

//EMB stat 20111201
if(date("Y-m-d")>"2011-12-12")
{
	$embl_tag="";
	$sql1="select order_embl_a,order_embl_e from bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		if($sql_row1['order_embl_a']==1)
		{
			$embl_tag="Panel Form*";
		}
		if($sql_row1['order_embl_e']==1)
		{
			$embl_tag="Garment Form*";
		}
	}
}

//EMB stat
$Ok = getFullURLLevel($_GET['r'],'common/images/ok.jpg',1,'R');

$ref_box="<img src='".$Ok."'><input type=\"checkbox\" name=\"s_tid[]\" value=\"$tid\"><input type=\"hidden\" name=\"ex_fact[]\" value=\"$ex_factory_date\">";


$sql1="select shipment_plan_id from $bai_pro4.week_delivery_plan where shipment_plan_id=$shipment_plan_id";
//echo $sql1."-".$tid."-".$x;
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1x="select schedule_no from $bai_pro4.week_delivery_plan_ref where schedule_no=\"$schedule_no\"";
//echo $sql1x."-".$tid."-".$x;
$sql_result1x=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result1)==0 or mysqli_num_rows($sql_result1x)==0)
{
	$ref_box="<img src=".getFullURLLevel($_GET['r'],'common/images/nok.jpg',1,'R')."><input type=\"checkbox\" name=\"s_tid[]\" value=\"$tid\"><input type=\"hidden\" name=\"ex_fact[]\" value=\"$ex_factory_date\">";
}

echo '<span style="overflow:scroll;max-width:1500px;max-height:800px;">';
if($pending==1)
{
	if($order_total>$actu_total)
	{
		
		
		// if($division=="All" )
		// {
			// echo "<tr><td>$ref_box $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$actu_total</td>	<td>$ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td></tr>";
		// }
		// else
		// {
			
		
		// if($division=="M&" )
		// {
		echo "<tr><td>$ref_box $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$actu_total</td>	<td>$ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td>
</tr>";
		// }
		// else
		// {
			// echo "<tr><td> $ref_box $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$actu_total</td>	<td>$ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td></tr>";
		// }
		// }
	}
}
else
{
		// if($division=="All" )
		// {
			// echo "<tr><td>$ref_box $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$actu_total</td>	<td>$ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td></tr>";
		// }
		// else
		// {
			
		
		// if($division=="M&" )
		// {
		echo "<tr><td>$ref_box $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$actu_total</td>	<td>$ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td></tr>";
		// }
		// else
		// {
			// echo "<tr><td>$ref_box $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$actu_total</td>	<td>$ex_factory_date</td>	<td>$mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td></tr>";
		// }
		// }
}
echo '</span>';

$x+=1;


}

echo '</tbody>
	</table>';
echo '</form>';
}
if($row_count==0){
	echo "<div class='col-sm-12 alert alert-danger'>No Date Found</div>";
	echo "<script>document.getElementById('transfer').disabled = true </script>";
	
}

}
?>
</div>
</div>
</div>
</div>

<?php

if(isset($_POST['transfer']))
{
	$s_tid=$_POST['s_tid'];
	
	$ex_fact=$_POST['ex_fact'];
	
	
	for($i=0;$i<sizeof($s_tid);$i++)
	{
		$tid_new=$s_tid[$i];
		$sql1="insert into $bai_pro4.week_delivery_plan select *,\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",(size_xs+size_s+size_m+size_l+size_xl+size_xxl+size_xxxl+size_s01+size_s02+size_s03+size_s04+size_s05+size_s06+size_s07+size_s08+size_s09+size_s10+size_s11+size_s12+size_s13+size_s14+size_s15+size_s16+size_s17+size_s18+size_s19+size_s20+size_s21+size_s22+size_s23+size_s24+size_s25+size_s26+size_s27+size_s28+size_s29+size_s30+size_s31+size_s32+size_s33+size_s34+size_s35+size_s36+size_s37+size_s38+size_s39+size_s40+size_s41+size_s42+size_s43+size_s44+size_s45+size_s46+size_s47+size_s48+size_s49+size_s50),\"\",\"\",\"".$ex_fact[$i]."\",\"\" from shipfast_sum where tid=$tid_new";

		mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo ((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		
		//TO Track Operations
		$sql1="insert into $bai_pro4.query_edit_log(query_executed) values ('".$sql1."/".$username."')";
		mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		//TO Track Operations
		echo "<script>sweetAlert('success','shipment details added','success')</script>";
	}
	
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = '$week_delivery_plan'}</script>";
}

?>

<style>
table {
	text-align:center;
	text-weight:bold;
}
th {
	//background-color:#286090;
	//color:white;
}
td {
	color:black;
}
</style>
<!-- <script>
var from_date;
$("#from_date").change(function(){
	from_date = $(this).val();
});

$("#to_date").click(function(){
	$(this).datepicker({
		format:'yyyy-mm-dd',
		startDate : from_date,
	});
});

</script> -->