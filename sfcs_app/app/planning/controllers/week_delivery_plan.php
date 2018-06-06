<!--
Core Module: We can view the updated weekly delivery details.

Description: We can view the updated weekly delivery details.

-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0127",$username,1,$group_id_sfcs);

/*
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=$username_list[1];
$authorized=array("muralim","kirang","kiranm","kranthic","rajanaa","kirang","bainet","baiadmn","baiict","dhanyap","duminduw","srikanthb","rajithago","kirang","khyathid");
if(!(in_array(strtolower($username),$authorized)))
{
	header("Location:restrict.php");
}
*/
?>
<?php

$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

$start_date_w=date("Y-m-d",$start_date_w);
$end_date_w=date("Y-m-d",$end_date_w);
?>

<script src="<?= getFullURLLevel($_GET['r'],'common/js/gs_sortable.js',1,'R'); ?>"></script>
<!-- <script src="../js/jquery-1.4.2.min.js"></script> -->
<!-- <script src="../js/jquery-ui-1.8.1.custom.min.js"></script> -->
<!-- <script src="../js/cal.js"></script> -->


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
</SCRIPT>

<!-- Inline Edit -->
<!-- <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/moo1.2.js',1,'R'); ?>"></script> -->

<script type="text/javascript">
		//once the dom is ready
		window.addEvent('domready', function() {
			//find the editable areas
			$('.editable').each(function(el) {
				//add double-click and blur events
				el.addEvent('dblclick',function() {
					//store "before" message
					var before = el.get('html').trim();
					//erase current
					el.set('html','');
					//replace current text/content with input or textarea element
					if(el.hasClass('textarea'))
					{
						var input = new Element('textarea', { 'class':'box', 'text':before });
					}
					else
					{
						var input = new Element('input', { 'class':'box', 'value':before });
						//blur input when they press "Enter"
						input.addEvent('keydown', function(e) { if(e.key == 'enter') { this.fireEvent('blur'); } });
					}
					input.inject(el).select();
					//add blur event to input
					input.addEvent('blur', function() {
						//get value, place it in original element
						val = input.get('value').trim();
						el.set('text',val).addClass(val != '' ? '' : 'editable-empty');
						
						//save respective record
						$week_delivery_plan_edit_process = getFullURL($_GET['r'],'week_delivery_plan_edit_process.php','N');
						
						var url = '$week_delivery_plan_edit_process&id=' + el.get('rel') + '&content=' + el.get('text');
						var request = new Request({
							url:url,
							method:'get',
							onRequest: function() {
								
								//alert('Successfully Updated.');
							}
						}).send();
					});
				});
			});
		});

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

	</script>

<!-- Inline Edit -->

<?php
// include("../dbconf.php");
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'../dbconf.php',0,'R'));
?>

<?php

if(isset($_GET['division']))
{
	$division=$_GET['division'];
	$from_date=$_GET['from_date'];
	$to_date=$_GET['to_date'];
}
else
{
	$division=$_POST['division'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
}
$pending=$_POST['pending'];

if($from_date=="" or $to_date=="")
{
	$from_date=$start_date_w;
	$to_date=$end_date_w;
}
?>
<div class="panel panel-primary"><div class="panel-heading">Delivery Status Report</div><div class="panel-body">

<form method="post" name="input" action="?r=<?= $_GET["r"];?>">

<!-- Section: <input type="text" name="section" size=12 value="">  -->
<!-- <label class="alert alert-warning">Enter Ex-Factory </label> -->

<div class="row">
	<div class="col-md-3">
		<label>Enter Ex-Factory From Date:</label>
		<input type="text" id="from_date" class="form-control" data-toggle="datepicker" name="from_date" value="<?php echo $from_date; ?>">
	</div>
	<div class="col-md-3">
		<label>To Date: </label><br/>
		<input type="text" id="to_date" class="form-control" name="to_date" data-toggle="datepicker" value="<?php echo $to_date; ?>" onchange="verify_date(event)">
	</div>
	<div class="col-md-2">
		<label>Section Buyer Division:</label>
		<select name="division" class="form-control">
		<?php
			echo "<option value=\"ALL\" selected >ALL</option>";
			//$sqly="select distinct(buyer_div) from plan_modules";
			$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
			//echo $sqly."<br>";
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
		<label>Pending Deliveries(Yes):</label><br/>
		<input type="checkbox" name="pending" value="1" <?php if($pending==1){ echo "checked";} ?>>
	</div>
	<div class="col-md-1"><br/>
		<input type="submit" value="Show" name="submit" class="btn btn-success" onclick="verify_date(event)"/>
	</div>
</div>
</form>


<form method="post" name="test" action="?r=<?= $_GET["r"];?>">
<?php
	if(isset($_GET['r_tid']))
	{
		$row_count = 0;
		$ref_id=$_GET['r_tid'];
		$division=$_GET['division'];
		$from_date=$_GET['from_date'];
		$to_date=$_GET['to_date'];
		
		$sql="select * from week_delivery_plan where ref_id=$ref_id";
		mysqli_query($link, $sql) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error--2".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$r_tid=$sql_row['ref_id'];
			$remarks=$sql_row['remarks'];
			$embl_tag=$sql_row['rev_emb_status'];
			$rev_ex_factory_date=$sql_row['rev_exfactory']; 
			$rev_mode=$sql_row['rev_mode'];
		}
		
		echo '<br/><hr/><br/><div class="col-sm-12" style="overflow:scroll;max-height:800px;">
		<table class="table table-bordered"><th>Sec 1</th><th>Sec 2</th>	<th>Sec 3</th>	<th>Sec 4</th>	<th>Sec 5</th>	<th>Sec 6</th>	<th colspan=57>Sizes</th><th colspan=3></th><th>Remarks</th></tr>';	
		echo '<th>Plan</th>	<th>Plan</th><th>Plan</th>	<th>Plan</th>		<th>Plan</th>	<th>Plan</th>	<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th><th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th><th>Rev. Ex-Factory</th><th>Emblishment</th><th>Rev. Mode</th><th>Remarks</th></tr>';	
		echo "<tr><td><input type=\"text\" name=\"plan[]\" size=\"6\" value=\"$plan_sec1\"></td><td><input type=\"text\" name=\"plan[]\" size=\"6\" value=\"$plan_sec2\"></td><td><input type=\"text\" name=\"plan[]\" size=\"6\" value=\"$plan_sec3\"></td><td><input type=\"text\" name=\"plan[]\" size=\"6\" value=\"$plan_sec4\"></td><td><input type=\"text\" name=\"plan[]\" size=\"6\" value=\"$plan_sec5\"></td><td><input type=\"text\" name=\"plan[]\" size=\"6\" value=\"$plan_sec6\"></td>";
	
		echo "
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_xs\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_m\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_l\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_xl\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_xxl\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_xxxl\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s01\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s02\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s03\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s04\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s05\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s06\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s07\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s08\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s09\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s10\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s11\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s12\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s13\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s14\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s15\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s16\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s17\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s18\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s19\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s20\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s21\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s22\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s23\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s24\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s25\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s26\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s27\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s28\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s29\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s30\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s31\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s32\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s33\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s34\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s35\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s36\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s37\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s38\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s39\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s40\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s41\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s42\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s43\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s44\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s45\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s46\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s47\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s48\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s49\"></td>
		<td><input type=\"text\" name=\"size[]\" size=\"6\" value=\"$size_s50\"></td>

		<td><input type=\"text\" name=\"rev_exfact\" size=\"6\" value=\"$rev_ex_factory_date\"></td>
		<td><input type=\"text\" name=\"rev_emblish\" size=\"6\" value=\"$embl_tag\"></td>
		<td><input type=\"text\" name=\"rev_mode\" size=\"6\" value=\"$rev_mode\"></td>
		";

		echo "<td><input type=\"text\" name=\"remarks\" size=\"30\" value=\"$remarks\"><input type=\"hidden\" name=\"division\" value=\"$division\"><input type=\"hidden\" name=\"from_date\" value=\"$from_date\"><input type=\"hidden\" name=\"to_date\" value=\"$to_date\"><input type=\"hidden\" name=\"ref_id\" value=\"$ref_id\"></td>";
		echo "</tr>";
		
		echo "</table></div><br/>";
		echo "<input type=\"submit\" name=\"update\" value=\"Update\" class='col-xs-1 btn btn-success'> &nbsp; <input type=\"submit\" name=\"delete\" class='col-xs-1 btn btn-danger' value=\"Delete\"><br/><br/>";
	}

?>
</form>

<?php
//To delete multiple entries.
if(isset($_POST['multidelete']))
{
	$tid_base=$_POST['tid_base'];
	//print_r($tid_base);
	
	for($i=0;$i<sizeof($tid_base);$i++)
	{
		$sql1="delete from $bai_pro4.week_delivery_plan where ref_id=".$tid_base[$i];
		//echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error--4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//TO Track Operations
		$sql1="insert into $bai_pro4.query_edit_log(query_executed) values ('".$sql1."/".$username."')";
		mysqli_query($link, $sql1) or exit("Sql Error--5".mysqli_error($GLOBALS["___mysqli_ston"]));
		//TO Track Operations
	}
}


?>

<?php

if(isset($_POST['submit']) or isset($_GET['division']))
{
	if(isset($_GET['division']))
	{
		$division=$_GET['division'];
		$from_date=$_GET['from_date'];
		$to_date=$_GET['to_date'];
	}
	else
	{
		$division=$_POST['division'];
		$from_date=$_POST['from_date'];
		$to_date=$_POST['to_date'];
	}
	
	$pending=$_POST['pending'];
	
	$query="where ex_factory_date_new between \"".date("Y-m-d",strtotime($from_date))."\" and  \"".date("Y-m-d",strtotime($to_date))."\"";
//echo $query;
	if($division!="All")
	{
		//$query="where MID(buyer_division,1, 2)=\"$division\" and ex_factory_date_new between \"".date("Y-m-d",strtotime($from_date))."\" and  \"".date("Y-m-d",strtotime($to_date))."\"";
		$query="where buyer_division = \"$division\" and ex_factory_date_new between \"".date("Y-m-d",strtotime($from_date))."\" and  \"".date("Y-m-d",strtotime($to_date))."\"";
	} 
	
	/* $query="where ex_factory_date between \"".date("Y-m-d",strtotime($from_date))."\" and  \"".date("Y-m-d",strtotime($to_date))."\"";
	if($division!="All")
	{
		$query="where MID(buyer_division,1, 2)=\"$division\" and ex_factory_date between \"".date("Y-m-d",strtotime($from_date))."\" and  \"".date("Y-m-d",strtotime($to_date))."\"";
	} */
	$report = getFullURL($_GET['r'],'report.php','N');
	$week_delivery_plan_cache = getFullURL($_GET['r'],'week_delivery_plan_cache.php','N');
echo "<br/>";
echo "<a href='$report' class='btn btn-info'>Add New</a> "; 
echo "<a href='$week_delivery_plan_cache' class='btn btn-info'>Backup This Plan</a>";
echo '<br/><hr/>';
?>
<form name="delete" method="post" action="?r=<?= $_GET["r"];?>">
<?php
echo "<label>Select All : </label> <a href=\"#\" onclick=\"SetAllCheckBoxes('delete', 'tid_base[]', true);\" class='btn btn-success'>ON</a>";
echo "<a href=\"#\" onclick=\"SetAllCheckBoxes('delete', 'tid_base[]', false);\" class='btn btn-danger'>OFF</a> &nbsp;&nbsp;&nbsp;";
echo '<input type="submit" id="multidelete" name="multidelete" value="Multiple Delete" class="btn btn-primary">';
echo '<br/>';
//TEMP Tables

$sql="Truncate $bai_pro4.week_delivery_plan_ref_temp";
//echo $sql;
mysqli_query($link, $sql) or exit("No data Found".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="Truncate $bai_pro4.week_delivery_plan_temp";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error-5".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="Truncate $bai_pro4.shipment_plan_ref_view";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error-6".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into $bai_pro4.week_delivery_plan_ref_temp select * from bai_pro4.week_delivery_plan_ref $query";
mysqli_query($link, $sql) or exit("Sql Error-7".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into $bai_pro4.week_delivery_plan_temp select * from $bai_pro4.week_delivery_plan where ref_id in (select ref_id from $bai_pro4.week_delivery_plan_ref_temp $query)";

mysqli_query($link, $sql) or exit("Sql Error-8".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="insert into $bai_pro4.shipment_plan_ref_view select * from $bai_pro4.shipment_plan_ref where ship_tid in (select shipment_plan_id from $bai_pro4.week_delivery_plan_temp)";
mysqli_query($link, $sql) or exit("Sql Error-9".mysqli_error($GLOBALS["___mysqli_ston"]));

$table_ref3="$bai_pro4.shipment_plan_ref_view";

$table_ref="$bai_pro4.week_delivery_plan_ref_temp";
$table_ref2="$bai_pro4.week_delivery_plan";


//TEMP Tables

$x=1;
//$sql="select * from week_delivery_plan where shipment_plan_id in (select ship_tid from week_delivery_plan_ref $query)";
$sql="select * from $table_ref2 where ref_id in (select ref_id from $table_ref $query)";

//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error-10".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error-11".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
$edit_ref=$sql_row['ref_id'];
$x='<input type="checkbox" name="tid_base[]" value="'.$edit_ref.'">'.$edit_ref;
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
$r_tid=$sql_row['ref_id'];
$remarks=array();
$remarks=explode("^",$sql_row['remarks']);


//TEMP Enabled
$embl_tag=$sql_row['rev_emb_status'];
$rev_mode=$sql_row['rev_mode'];
$rev_ex_factory_date=$sql_row['rev_exfactory']; 
if($rev_ex_factory_date=="0000-00-00")
{
	$rev_ex_factory_date="";
}

//$order_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s06+$size_s08+$size_s10+$size_s12+$size_s14+$size_s16+$size_s18+$size_s20+$size_s22+$size_s24+$size_s26+$size_s28+$size_s30;
$actu_total=$size_xs+$size_s+$size_m+$size_l+$size_xl+$size_xxl+$size_xxxl+$size_s01+$size_s02+$size_s03+$size_s04+$size_s05+$size_s06+$size_s07+$size_s08+$size_s09+$size_s10+$size_s11+$size_s12+$size_s13+$size_s14+$size_s15+$size_s16+$size_s17+$size_s18+$size_s19+$size_s20+$size_s21+$size_s22+$size_s23+$size_s24+$size_s25+$size_s26+$size_s27+$size_s28+$size_s29+$size_s30+$size_s31+$size_s32+$size_s33+$size_s34+$size_s35+$size_s36+$size_s37+$size_s38+$size_s39+$size_s40+$size_s41+$size_s42+$size_s43+$size_s44+$size_s45+$size_s46+$size_s47+$size_s48+$size_s49+$size_s50;
$plan_total=$actu_sec1+$actu_sec2+$actu_sec3+$actu_sec4+$actu_sec5+$actu_sec6+$actu_sec7+$actu_sec8+$actu_sec9;
//$plan_total=$plan_sec1+$plan_sec2+$plan_sec3+$plan_sec4+$plan_sec5+$plan_sec6+$plan_sec7+$plan_sec8+$plan_sec9;

//EXEC Secs
{
	$executed_secs=array();
	if($plan_sec1>0 or $actu_sec1>0)
	{
		$executed_secs[]="1";
	}
	if($plan_sec2>0 or $actu_sec2>0)
	{
		$executed_secs[]="2";
	}
	if($plan_sec3>0 or $actu_sec3>0)
	{
		$executed_secs[]="3";
	}
	if($plan_sec4>0 or $actu_sec4>0)
	{
		$executed_secs[]="4";
	}
	if($plan_sec5>0 or $actu_sec5>0)
	{
		$executed_secs[]="5";
	}
	if($plan_sec6>0  or $actu_sec6>0)
	{
		$executed_secs[]="6";
	}
	$exe_sec=implode(", ",$executed_secs);
}




$order_total=0;
$sql1="select * from $table_ref3 where ship_tid=$shipment_plan_id";
mysqli_query($link, $sql1) or exit("Sql Error--12".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error-13".mysqli_error($GLOBALS["___mysqli_ston"]));
echo '<div style="overflow:scroll;max-height:800px;"><table class="table table-bordered">';



if($division=="All" )
{
echo '<thead>
		<tr>
			<th colspan=13>Shipment Details</th><th colspan=57> Sizes</th><th colspan=7>Shipment Details</th><th colspan=2>Sec1</th><th colspan=2>Sec2</th>		<th colspan=2>Sec3</th>		<th colspan=2>Sec4</th>		<th colspan=2>Sec5</th>		<th colspan=2>Sec6</th>	<th colspan=3></th>
		</tr>';
echo '	<tr class="tblheading">
		<th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th><th>Total</th><th>Planned Sections</th>	';
echo '	<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>	<th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>';
}
else
{		
	if($division=="M&")
	{
		echo '<thead>
		<tr>
		<td colspan=13>Shipment Details</td><td colspan=57> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>		<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td></td>
		</tr>';

		echo '<tr class="tblheading">
		<th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th><th>Total</th><th>Planned Sections</th>	';
		echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th><th>s01</th> <th>s02</th> <th>s03</th> <th>s04</th> <th>s05</th> <th>s06</th> <th>s07</th> <th>s08</th> <th>s09</th> <th>s10</th> <th>s11</th> <th>s12</th> <th>s13</th> <th>s14</th> <th>s15</th> <th>s16</th> <th>s17</th> <th>s18</th> <th>s19</th> <th>s20</th> <th>s21</th> <th>s22</th> <th>s23</th> <th>s24</th> <th>s25</th> <th>s26</th> <th>s27</th> <th>s28</th> <th>s29</th> <th>s30</th> <th>s31</th> <th>s32</th> <th>s33</th> <th>s34</th> <th>s35</th> <th>s36</th> <th>s37</th> <th>s38</th> <th>s39</th> <th>s40</th> <th>s41</th> <th>s42</th> <th>s43</th> <th>s44</th> <th>s45</th> <th>s46</th> <th>s47</th> <th>s48</th> <th>s49</th> <th>s50</th>';
	}else {
		echo '<thead>
		<tr>
		<td colspan=13>Shipment Details</td><td colspan=57> Sizes</td><td colspan=7>Shipment Details</td><td colspan=2>Sec1</td><td colspan=2>Sec2</td>		<td colspan=2>Sec3</td>		<td colspan=2>Sec4</td>		<td colspan=2>Sec5</td>		<td colspan=2>Sec6</td>	<td></td>
		</tr>';

		echo '<tr class="tblheading">
		<th>S. No</th>	<th>Buyer Division</th>	<th>MPO</th>	<th>CPO</th>	<th>Customer Order No</th>	<th>Z-Feature</th><th>Style No.</th>	<th>Schedule No.</th>	<th>Colour</th>	<th>Order Total</th><th>Actual Total</th><th>Total</th><th>Planned Sections</th>	';
			echo '<th>XS</th>	<th>S</th>	<th>M</th>	<th>L</th>	<th>XL</th>	<th>XXL</th>	<th>XXXL</th>';
	}
}

echo '<th>Ex Factory</th><th>Rev. Ex-Factory</th>	<th>Mode</th><th>Rev. Mode</th>	<th>Packing Method</th>	<th>Plan End Date</th>	<th>Embellishment</th><th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th>	<th>Plan</th>	<th>Actual</th><th>Planning Remarks</th><th>Production Remarks</th><th>Commitment Remarks</th></tr></thead><tbody>';
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
	//$ex_factory_date=$sql_row1['ex_factory_date']; //TEMP Disabled due to M3 Issue
	$mode=$sql_row1['mode'];
	$destination=$sql_row1['destination'];
	$packing_method=$sql_row1['packing_method'];
	$fob_price_per_piece=$sql_row1['fob_price_per_piece'];
	$cm_value=$sql_row1['cm_value'];
	$ssc_code=$sql_row1['ssc_code'];
	$ship_tid=$sql_row1['ship_tid'];
	$week_code=$sql_row1['week_code'];
	$status=$sql_row1['status'];
	//$order_total=$sql_row1['ord_qty_new']; //changed due to sum issues (cw_check issues) not tracking properly 2011-05-17
	
	//TEMP Disabled due to M3 Issue
	//$embl_tag=embl_check($sql_row1['order_embl_a'].$sql_row1['order_embl_b'].$sql_row1['order_embl_c'].$sql_row1['order_embl_d'].$sql_row1['order_embl_e'].$sql_row1['order_embl_f'].$sql_row1['order_embl_g'].$sql_row1['order_embl_h']);
}

$sql1="select * from $bai_pro4.$table_ref  where ship_tid=$shipment_plan_id";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error-14".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$ex_factory_date=$sql_row1['ex_factory_date'];
}
//EMB stat 20111201

if($rev_ex_factory_dat>"2011-12-11" or $ex_factory_date>"2011-12-11")
{
	$embl_tag="";
	$sql1="select order_embl_a,order_embl_e from $bai_pro3.bai_orders_db where order_del_no=\"$schedule_no\"";
	//echo $sql1."<br/>";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error-15".mysqli_error($GLOBALS["___mysqli_ston"]));
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

$order_total=$sql_row['original_order_qty'];
//NEW ORDER QTY TRACK
/*
$sql1="select * from shipfast_sum where shipment_plan_id=$shipment_plan_id";
$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
while($sql_row1=mysql_fetch_array($sql_result1))
{
	$size_xs1=$sql_row1['size_xs'];
	$size_s1=$sql_row1['size_s'];
	$size_m1=$sql_row1['size_m'];
	$size_l1=$sql_row1['size_l'];
	$size_xl1=$sql_row1['size_xl'];
	$size_xxl1=$sql_row1['size_xxl'];
	$size_xxxl1=$sql_row1['size_xxxl'];
	$size_s061=$sql_row1['size_s06'];
	$size_s081=$sql_row1['size_s08'];
	$size_s101=$sql_row1['size_s10'];
	$size_s121=$sql_row1['size_s12'];
	$size_s141=$sql_row1['size_s14'];
	$size_s161=$sql_row1['size_s16'];
	$size_s181=$sql_row1['size_s18'];
	$size_s201=$sql_row1['size_s20'];
	$size_s221=$sql_row1['size_s22'];
	$size_s241=$sql_row1['size_s24'];
	$size_s261=$sql_row1['size_s26'];
	$size_s281=$sql_row1['size_s28'];
	$size_s301=$sql_row1['size_s30'];
	
}
$order_total=$size_xs1+$size_s1+$size_m1+$size_l1+$size_xl1+$size_xxl1+$size_xxxl1+$size_s061+$size_s081+$size_s101+$size_s121+$size_s141+$size_s161+$size_s181+$size_s201+$size_s221+$size_s241+$size_s261+$size_s281+$size_s301; */
//NEW ORDER QTY TRACK
$week_delivery_plan = getFullURL($_GET['r'],'week_delivery_plan.php','N');

if($pending==1)
{
	if($order_total>$actu_total)
	{
		if($division=="All" )
		{
			// echo $week_delivery_plan.'&r_tid='.$r_tid.'&division='.$division;
			echo "<tr><td> $x<a href='$week_delivery_plan.'&r_tid='.$r_tid.'&division='.$division' style='color:blue'>Edit </a> </td>
			<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$exe_sec</td>	<td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td><td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td><td>$rev_mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td  class=\"editable\" rel=\"A$edit_ref\">".$remarks[0]."</td><td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td><td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td></tr>";
		}
		else
		{
			
		
		if($division=="M&" )
		{
		echo "<tr><td> $x <a href='$week_delivery_plan&r_tid=$r_tid&division=$division' style='color:blue'>Edit </a> </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$exe_sec</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td><td>$rev_mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td  class=\"editable\" rel=\"A$edit_ref\">".$remarks[0]."</td><td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td><td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td></tr>";
		}
		else
		{
			echo "<tr><td>  $x</td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$exe_sec</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td><td>$rev_mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td  class=\"editable\" rel=\"A$edit_ref\">".$remarks[0]."</td><td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td><td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td></tr>";
		}
		}
	}
}
else
{
		if($division=="All" )
		{
			echo "<tr><td> $x <a href='$week_delivery_plan&r_tid=$r_tid&division=$division'>Edit </a> </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$exe_sec</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td><td>$rev_mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td  class=\"editable\" rel=\"A$edit_ref\">".$remarks[0]."</td><td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td><td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td></tr>";
		}
		else
		{
			
		
		if($division=="M&" )
		{
		echo "<tr><td> $x <a href='$week_delivery_plan&r_tid=$r_tid&division=$division'>Edit </a> </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$exe_sec</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td><td>$size_s01</td>  <td>$size_s02</td>  <td>$size_s03</td>  <td>$size_s04</td>  <td>$size_s05</td>  <td>$size_s06</td>  <td>$size_s07</td>  <td>$size_s08</td>  <td>$size_s09</td>  <td>$size_s10</td>  <td>$size_s11</td>  <td>$size_s12</td>  <td>$size_s13</td>  <td>$size_s14</td>  <td>$size_s15</td>  <td>$size_s16</td>  <td>$size_s17</td>  <td>$size_s18</td>  <td>$size_s19</td>  <td>$size_s20</td>  <td>$size_s21</td>  <td>$size_s22</td>  <td>$size_s23</td>  <td>$size_s24</td>  <td>$size_s25</td>  <td>$size_s26</td>  <td>$size_s27</td>  <td>$size_s28</td>  <td>$size_s29</td>  <td>$size_s30</td>  <td>$size_s31</td>  <td>$size_s32</td>  <td>$size_s33</td>  <td>$size_s34</td>  <td>$size_s35</td>  <td>$size_s36</td>  <td>$size_s37</td>  <td>$size_s38</td>  <td>$size_s39</td>  <td>$size_s40</td>  <td>$size_s41</td>  <td>$size_s42</td>  <td>$size_s43</td>  <td>$size_s44</td>  <td>$size_s45</td>  <td>$size_s46</td>  <td>$size_s47</td>  <td>$size_s48</td>  <td>$size_s49</td>  <td>$size_s50</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td><td>$rev_mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td  class=\"editable\" rel=\"A$edit_ref\">".$remarks[0]."</td><td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td><td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td></tr>";
		}
		else
		{
			echo "<tr><td> $x <a href='$week_delivery_plan&r_tid=$r_tid&division=$division'>Edit </a> </td>	<td>$buyer_division</td>	<td>$mpo</td>	<td>$cpo</td>	<td>$order_no</td>	<td>$z_feature</td><td>$style</td>	<td>$schedule_no</td>	<td>$color</td>	<td>$order_total</td><td>$plan_total</td><td>$actu_total</td><td>$exe_sec</td><td>$size_xs</td>	<td>$size_s</td>	<td>$size_m</td>	<td>$size_l</td>	<td>$size_xl</td>	<td>$size_xxl</td>	<td>$size_xxxl</td>	<td>$ex_factory_date</td><td>$rev_ex_factory_date</td>	<td>$mode</td><td>$rev_mode</td>	<td>$packing_method</td>	<td>$plan_comp_date</td><td>$embl_tag</td>	<td>$plan_sec1</td>	<td>$actu_sec1</td>	<td>$plan_sec2</td>	<td>$actu_sec2</td>	<td>$plan_sec3</td>	<td>$actu_sec3</td>	<td>$plan_sec4</td>	<td>$actu_sec4</td>	<td>$plan_sec5</td>	<td>$actu_sec5</td>	<td>$plan_sec6</td>	<td>$actu_sec6</td>	<td  class=\"editable\" rel=\"A$edit_ref\">".$remarks[0]."</td><td class=\"editable\" rel=\"B$edit_ref\">".$remarks[1]."</td><td class=\"editable\" rel=\"C$edit_ref\">".$remarks[2]."</td></tr>";
		}
		}
}


$x+=1;


}

echo '</tbody></table>';
echo '</form>';
if($row_count==0){
	echo "<br/><div class='alert alert-danger'>No Date Found</div>";
	echo "<script>document.getElementById('multidelete').disabled = true </script>";
}
}
echo "</div>";
?>


<?php


if(isset($_POST['delete']) or isset($_POST['update']))
{
	$ref_id=$_POST['ref_id'];
	$division=$_POST['division'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$plan=$_POST['plan'];
	$size=$_POST['size'];
	$remarks=$_POST['remarks'];
	$rev_exfactory=$_POST['rev_exfact'];
	$rev_emblish=$_POST['rev_emblish'];
	$rev_mode=$_POST['rev_mode'];
	
	echo $rev_exfactory;
	
	if(isset($_POST['delete']))
	{
		$sql1="delete from $bai_pro4.week_delivery_plan where ref_id=$ref_id";
		//echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//TO Track Operations
		$sql1="insert into $bai_pro4.query_edit_log(query_executed) values ('".$sql1."/".$username."')";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//TO Track Operations
		
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = '$week_delivery_plan&division=$division&from_date=$from_date&to_date=$to_date\"; }</script>";
	}
	
	if(isset($_POST['update']))
	{
		$sql1="update $bai_pro4.week_delivery_plan set size_xs='".$size[0]."', size_s='".$size[1]."', size_m='".$size[2]."', size_l='".$size[3]."', size_xl='".$size[4]."', size_xxl='".$size[5]."', size_xxxl='".$size[6]."', size_s01='".$size[7]."', size_s02='".$size[8]."', size_s03='".$size[9]."', size_s04='".$size[10]."', size_s05='".$size[11]."', size_s06='".$size[12]."', size_s07='".$size[13]."', size_s08='".$size[14]."', size_s09='".$size[15]."', size_s10='".$size[16]."', size_s11='".$size[17]."', size_s12='".$size[18]."', size_s13='".$size[19]."', size_s14='".$size[20]."', size_s15='".$size[21]."', size_s16='".$size[22]."', size_s17='".$size[23]."', size_s18='".$size[24]."', size_s19='".$size[25]."', size_s20='".$size[26]."', size_s21='".$size[27]."', size_s22='".$size[28]."', size_s23='".$size[29]."', size_s24='".$size[30]."', size_s25='".$size[31]."', size_s26='".$size[32]."', size_s27='".$size[33]."', size_s28='".$size[34]."', size_s29='".$size[35]."', size_s30='".$size[36]."', size_s31='".$size[37]."', size_s32='".$size[38]."', size_s33='".$size[39]."', size_s34='".$size[40]."', size_s35='".$size[41]."', size_s36='".$size[42]."', size_s37='".$size[43]."', size_s38='".$size[44]."', size_s39='".$size[45]."', size_s40='".$size[46]."', size_s41='".$size[47]."', size_s42='".$size[48]."', size_s43='".$size[49]."', size_s44='".$size[50]."', size_s45='".$size[51]."', size_s46='".$size[52]."', size_s47='".$size[53]."', size_s48='".$size[54]."', size_s49='".$size[55]."', size_s50='".$size[56]."', plan_sec1='".$plan[0]."', plan_sec2='".$plan[1]."', plan_sec3='".$plan[2]."', plan_sec4='".$plan[3]."', plan_sec5='".$plan[4]."', plan_sec6='".$plan[5]."', remarks=\"$remarks\", rev_exfactory=\"$rev_exfactory\", rev_emb_status=\"$rev_emblish\",rev_mode=\"$rev_mode\" where ref_id=$ref_id";
		// echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//TO Track Operations
		$sql1="insert into $bai_pro4.query_edit_log(query_executed) values ('".$sql1."/".$username."')";
		//echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//TO Track Operations
		echo "<script>sweetAlert('success','','success');</script>";
		
		// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",300); function Redirect() {  location.href = '$week_delivery_plan&division=$division&from_date=$from_date&to_date=$to_date' }</script>";
	}
}

?>


<!--
History Track:

20110906: Introduced Inline Editing using moo tools. This is to edit remarks of Planner/Production/Commitments. (ABC) Code based.




-->
</div>
</div>
</div>
<style>
table {
	text-align:center;
	text-weight:bold;
}
th {
	background-color:#286090;
	color:white;
}
td {
	color:black;
}
</style>
