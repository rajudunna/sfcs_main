<!--
2014-02-01/kirang/Ticket #124373: Add srikanthb user in $authorized_users

//2015-11-25// kirang //  // Added Clause to capture the schedule numbers(length of the schedule should be grater than '0') from the database to process the report. and display the year dynamically based on current year and month reference.

-->

<?php

// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);
$username="sfcsproject1";
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

//$view_access=user_acl("SFCS_0039",$username,1,$group_id_sfcs); 
//$authorized_users=user_acl("SFCS_0039",$username,7,$group_id_sfcs);

$has_perm=haspermission($_GET['r']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Balance Sheet</title>
<head>
<script language="javascript" type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R') ?>"></script>
<link rel="stylesheet" href="../<?= getFullURL($_GET['r'],'styles/ddcolortabs.css','R') ?>" type="text/css" media="all" />
<!-- <link href="../<?= getFullURL($_GET['r'],'table_style.css','R') ?>" rel="stylesheet" type="text/css" /> -->
<script type="text/javascript" src="../<?= getFullURL($_GET['r'],'datetimepicker_css.js','R') ?>"></script>

<!-- <script type="text/javascript" src="../<?= getFullURL($_GET['r'],'scripts/showhidecolumns/jquery-1.2.2.pack.js','R') ?>"></script> -->


<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/showhidecolumns/chili.js',1,'R') ?>"></script>
<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/showhidecolumns/jquery.cookie.js',1,'R') ?>"></script>
<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/showhidecolumns/jquery.clickmenu.pack.js',1,'R') ?>"></script>
<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/showhidecolumns/jquery.columnmanager.js',1,'R') ?>"></script>


<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'table2CSV.js',1,'R') ?>" ></script>

<script>

function mainbox()
{
	y=document.test.buyer_div.value;
	window.location.href ="<?= getFullURL($_GET['r'],'analysis_rep3.php','N').'&buyer_div=' ?>"+encodeURIComponent(y)+"&sdate="+document.test.sdate.value+"&edate="+document.test.edate.value	
}

function firstbox()
{
	y=document.test.buyer_div.value;
	window.location.href ="<?= getFullURL($_GET['r'],'analysis_rep3.php','N').'&buyer_div=' ?>"+encodeURIComponent(y)+"&sdate="+document.test.sdate.value+"&edate="+document.test.edate.value+"&style="+document.test.style_name.value	
}

function checkAll(ele) {
	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			// console.log(i)
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}

function check_date()
{
	var from_date = document.getElementById("sdate").value;
	var to_date = document.getElementById("edate").value;
	var today = document.getElementById("today").value;

	if ((Date.parse(to_date) <= Date.parse(from_date)))
	{
		sweetAlert('Start date should be less than End date','','warning');

		document.getElementById("edate").value = "<?php  echo date("Y-m-d");  ?>";
		document.getElementById("sdate").value = "<?php  echo date("Y-m-d");  ?>";
	}
	if ((Date.parse(to_date) > Date.parse(today)))
	{
		sweetAlert('End date should not be greater than Today','','warning');

		document.getElementById("edate").value = "<?php  echo date("Y-m-d");  ?>";
	}
}

</script>

<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	 -->
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "<?= $_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'common/css/TableFilter_EN/filtergrid.css',3,'R') ?>";

/*====================================================
	- General html elements
=====================================================*/
/* body{ 
	margin:0px; padding:0px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}

caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;} */
th{
	background-color:#337ab7;
	color:#FFF;
}
</style>
<script type="text/javascript">
	function check_style(){
		if(document.getElementById('buyer_div').value == 'Select'){
			sweetAlert('Please select Buyer First ','','warning')
			return false;
		}
		else if(document.getElementById('style_name').value == ''){
			sweetAlert('Please select style ','','warning')
			return false;
		}else{
			return true;
		}
	}
	function check_buyer(){
		if(document.getElementById('buyer_div').value == 'Select'){
			sweetAlert('Please select Buyer First ','','warning')
			return false;
		}else{
			return true;
			
		}
	}
</script>


<?php

//To Convert week to date
function weeknumber_v2 ($y, $w) {
// include ('../'.getFullURL($_GET['r'],"dbconf2.php",'R'));
   $sql="select STR_TO_DATE('$y$w Friday', '%X%V %W') as week";
   //	echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		 return ($sql_row['week']);
	}
}


# get_week_date( week_number, year, day_offset, format )
function get_week_date($wk_num, $yr, $first = 5, $format = 'F d, Y') {
	$wk_ts = strtotime('+' . (($wk_num)-1) . ' weeks', strtotime($yr . '0101'));
	$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
	//echo $wk_ts."-".$mon_ts."<br>";
	return date($format, $mon_ts);
}

function daysDifference($endDate, $beginDate){   
	//explode the date by "-" and storing to array  
	$date_parts1=explode("-", $beginDate);   
	$date_parts2=explode("-", $endDate);  

	//gregoriantojd() Converts a Gregorian date to Julian Day Count   
	$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);   
	$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);   
	return $end_date - $start_date;
}

# get start and end date of a week
function getStartAndEndDate($week, $year) {
	$dto = new DateTime();
	$dto->setISODate($year, $week);
	$ret['week_start'] = $dto->format('Y-m-d');
	$dto->modify('+4 days');
	$ret['friday'] = $dto->format('Y-m-d');
	$dto->modify('+2 days');
	$ret['week_end'] = $dto->format('Y-m-d');
	return $ret;
}

$buyer_div="";
$year_add_query2="";
$style_name="";

if(isset($_GET['buyer_div']))
{
	$buyer_div=urldecode($_GET["buyer_div"]);
	// $buyer_div=$_GET['buyer_div'];
}

if(isset($_GET['sdate']))
{
	$sdate=$_GET['sdate'];
}
else
{
	$sdate=date("Y-m-d"); 
}

if(isset($_GET['edate']))
{
	$edate=$_GET['edate'];
}
else
{
	$edate=date("Y-m-d"); 
}


if(isset($_GET['style_name']))
{
	$style_name=$_GET['style_name'];
}

if(isset($_POST['buyer_div']))
{
	// $buyer_div=urldecode($_GET["buyer_div"]);
	$buyer_div=$_POST['buyer_div'];
}

if(isset($_POST['sdate']))
{
	$sdate=$_POST['sdate'];
}

if(isset($_POST['edate']))
{
	$edate=$_POST['edate'];
}

if(isset($_POST['style_name']))
{
	$style_name=$_POST['style_name'];
}

$shipment_plan="shipment_plan";


$All=$_POST['All'];
$Plan_Qty=$_POST['Plan_Qty'];
$Cut_Qty=$_POST['Cut_Qty'];
$Sewing_IN=$_POST['Sewing_IN'];
$Sewing_OUT=$_POST['Sewing_OUT'];
$Packing_Out=$_POST['Packing_Out'];
$Shiping_Out=$_POST['Shiping_Out'];
$Sewing_Balance=$_POST['Sewing_Balance'];
$No_of_Days=$_POST['No_of_Days'];
$Current_Modules=$_POST['Current_Modules'];
$Required_Target=$_POST['Required_Target'];
$Actual_Reached=$_POST['Actual_Reached'];
$Days_Required=$_POST['Days_Required'];
$Expected_Comp_Date=$_POST['Expected_Comp_Date'];

$buyer_div=urldecode($buyer_div);
$year_add_query2=" and exfact_date between \"".$sdate."\" and \"".$edate."\" ";
?>
	<!-- <script src="jquery-1.3.2.js"></script> -->
	<link type="text/css" rel="stylesheet" href="<?= '../'.getFullURL($_GET['r'],'dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112','R') ?>" media="screen"></link>
	<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118','R') ?>"></script>
</head>

<div class='panel panel-primary'><div class='panel-heading'>Balance Sheet (Live) - Week: <?php echo date("W")+1; ?></div><div class='panel-body'>
<!--style="background-color: #EEEEEE;"-->
<script language="JavaScript">
	function toggle(source) {
		checkboxes = document.getElementsByClassName('food');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}
</script>
<form name="test" id="test"  action="index.php?r=<?php echo $_GET['r']; ?>" method="post">
<div class="row">

<div class="col-md-2">
<label>Start Date</label>
<input type="text" id="sdate" data-toggle="datepicker" onchange="check_date()" name="sdate" size="8" class="form-control" value="<?php  if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo $sdate; } ?>"  required>
</div>
<div class="col-md-2">	
<label>End Date</label>
<input type="text" id="edate" data-toggle="datepicker" onchange="check_date()" name="edate" size="8" class="form-control" value="<?php  if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo $edate; } ?>"  required>
</div>
		

			  <?php
		
			 $sql='SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code';

			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$buyer_code[]=$sql_row["buyer_div"];
				$buyer_name[]=$sql_row["buyer_name"];
			}

			  ?>
			
			<div class="col-md-2">
				<input type="hidden" name="today" id="today" value="<?php  echo date("Y-m-d");  ?>">
			<label>Buyer Division: </label><select name="buyer_div" id="buyer_div"  onchange="mainbox();" class="form-control">

		   	<option value="Select" <?php if($buyer_div=="Select"){ echo "selected"; } ?> >Select</option>
			<?php
				for($i=0;$i<sizeof($buyer_name);$i++)
			{
				if($buyer_name[$i]==$buyer_div) 
				{ 
					echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_code[$i]."</option>";	
				}
				else
				{
					echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_code[$i]."</option>";			
				}
			}
			?>
			</select>
			</div>
			<div class="col-md-2">
			<label>Style Filter: </label>
			<select name="style_name" id="style_name"  class="form-control" onclick="return check_buyer()" required>

			<option value="" <?php if($style_name==""){ echo "selected"; } ?> >Select</option>
			<option value="ALL" <?php if($style_name=="ALL"){ echo "selected"; } ?> >All</option>
			<?php
				if(strlen($buyer_div) >0)
				{
					// $query_add=" where left(style_no,1) in ($buyer_div) $year_add_query2";
					$query_add="where schedule_no in (SELECT order_del_no FROM bai_pro3.bai_orders_db WHERE order_div IN ('".str_replace(",","','",$buyer_div)."'))";
					
					$sql="select distinct style_id from $bai_pro2.shipment_plan $query_add order by style_id";
					
					//echo "<option value=\"".$style_name."\" selected>".$style_name."-".$sql."</option>";	
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if($sql_row['style_id'] == $style_name) 
						{ 
							echo "<option value=\"".$sql_row['style_id']."\" selected>".$sql_row['style_id']."</option>";	
						}
						else
						{
							echo "<option value=\"".$sql_row['style_id']."\" >".$sql_row['style_id']."</option>";		
						}
					}
				}
			?>
			</select>
			</div>
			<div class="col-md-2">
				<label>Row Filter:</label>
				<div style="overflow:auto;width:auto;height:75px;border:0px solid #336699;padding-left:0px">
				<input type="checkbox"  name="All" onClick="toggle(this)" value="1" <?php if($All==1) { echo "checked"; } ?>>Show All<br>
				<input type="checkbox" class='food' name="Plan_Qty" value="1" <?php if($Plan_Qty==1) { echo "checked"; } ?>>Plan Qty<br>
				<input type="checkbox" class='food' name="Cut_Qty" value="1" <?php if($Cut_Qty==1) { echo "checked"; } ?>>Cut Qty<br>
				<input type="checkbox" class='food' name="Sewing_IN" value="1" <?php if($Sewing_IN==1) { echo "checked"; } ?>>Sewing IN<br>
				<input type="checkbox" class='food' name="Sewing_OUT" value="1" <?php if($Sewing_OUT==1) { echo "checked"; } ?>>Sewing OUT<br>
				<input type="checkbox" class='food' name="Packing_Out" value="1" <?php if($Packing_Out==1) { echo "checked"; } ?>>Packing Out<br>
				<input type="checkbox" class='food' name="Sewing_Balance" value="1" <?php if($Sewing_Balance==1) { echo "checked"; } ?>>Sewing Balance<br>
				<input type="checkbox" class='food' name="No_of_Days" value="1" <?php if($No_of_Days==1) { echo "checked"; } ?>>No of Days<br>
				<input type="checkbox" class='food' name="Current_Modules" value="1" <?php if($Current_Modules==1) { echo "checked"; } ?>>Current Modules<br>
				<input type="checkbox" class='food' name="Required_Target" value="1" <?php if($Required_Target==1) { echo "checked"; } ?>>Required Target<br>
				<input type="checkbox" class='food' name="Actual_Reached" value="1" <?php if($Actual_Reached==1) { echo "checked"; } ?>>Actual Reached<br>
				<input type="checkbox" class='food' name="Days_Required" value="1" <?php if($Days_Required==1) { echo "checked"; } ?>>Days Required<br>
				<input type="checkbox" class='food' name="Expected_Comp_Date" value="1" <?php if($Expected_Comp_Date==1) { echo "checked"; } ?>>Expected Comp.Date<br>
				<input type="checkbox" class='food' name="Shiping_Out" value="1" <?php if($Shiping_Out==1) { echo "checked"; } ?>>Shipping Out<br>
				</div>
			</div>
				<?php
					if(in_array($authorized,$has_perm))
					{
						//echo '<span id="msg" style="display:none;"><b><font color=\"blue\">Please Wait...</font></b></span>';
						echo "<input class='btn btn-success' type=submit name=\"submit\" value=\"submit\" id=\"submit\" onClick='return check_style()' style='margin-top:22px;'>";
					}
				?>

	</div>					  
</form>
<?php
if(isset($_POST["submit"]))
{

$style_status_summ_primary="style_status_summ";
$style_status_summ="temp_pool_db.".$username.date("YmdHis")."_"."style_status_summ_live_temp";
$style_status_summ_today="style_status_summ_today";
$ssc_code_temp="temp_pool_db.".$username.date("YmdHis")."_"."ssc_code_temp";

$sql="create TEMPORARY table $style_status_summ ENGINE = MyISAM select * from $bai_pro2.style_status_summ_live ";
mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="create TEMPORARY table $ssc_code_temp ENGINE = MyISAM select * from $bai_pro2.ssc_code_temp ";
mysqli_query($link, $sql) or exit("Sql Error1z".mysqli_error($GLOBALS["___mysqli_ston"]));

$start_date=$_POST["sdate"];
$end_date=$_POST["edate"];
$buyer=urldecode($_POST["buyer_div"]);
$style_id=$_POST["style_name"];


if($style_id=="ALL")
{
	$add_style_id="";
}
else
{
	$add_style_id=" and style_id=\"".$style_id."\"";
}

$year_code=date("Y");

$january=($year_code)."-01-31";

$december=($year_code-1)."-12-01";

$t=0;
$sql="select distinct week(bac_date)+1 as week_code from $bai_pro.bai_log_buf where bac_date between \"".$december."\" and \"".$january."\" group by week(bac_date) order by bac_date,week(bac_date)";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{

	if($sql_row['week_code']==53)
	{
		$t=1;
	}
}


$All=$_POST['All'];
$Plan_Qty=$_POST['Plan_Qty'];
$Cut_Qty=$_POST['Cut_Qty'];
$Sewing_IN=$_POST['Sewing_IN'];
$Sewing_OUT=$_POST['Sewing_OUT'];
$Packing_Out=$_POST['Packing_Out'];
$Shiping_Out=$_POST['Shiping_Out'];
$Sewing_Balance=$_POST['Sewing_Balance'];
$No_of_Days=$_POST['No_of_Days'];
$Current_Modules=$_POST['Current_Modules'];
$Required_Target=$_POST['Required_Target'];
$Actual_Reached=$_POST['Actual_Reached'];
$Days_Required=$_POST['Days_Required'];
$Expected_Comp_Date=$_POST['Expected_Comp_Date'];

echo '<form action="'.getFullURL($_GET["r"],"export_excel.php",'R').'" method ="post" > 
<input type="hidden" id="csv_text" name="csv_text" >
<input type="submit" class="btn btn-info" value="Export to Excel" onclick="getData()">
</form>';



echo '<table class="table table-bordered" border=1  id="tablecol" >';


$i=0;
$j=1;
$r=$t;
$sql="select distinct week(exfact_date) as week_code,year(exfact_date) as \"year\",GROUP_CONCAT(DISTINCT exfact_date ORDER BY exfact_date)AS dates from $shipment_plan where exfact_date between \"".$start_date."\" and \"".$end_date."\" and schedule_no in (SELECT order_del_no FROM bai_pro3.bai_orders_db WHERE order_div IN (SELECT buyer_name FROM bai_pro2.buyer_codes WHERE buyer_name IN ('".str_replace(",","','",$buyer_div)."'))) group by week(exfact_date) order by exfact_date,week(exfact_date)";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$week_code_ref=$sql_row['week_code'];
	$week_code_ref1=$sql_row['week_code']+$r;
	$year_ref=$sql_row['year'];
	if($sql_row['week_code']==53)
	{
		$week_code_ref1=1;
		$r=1;
	}
	
	$week_code_ref_val[$i]=$week_code_ref;
	$exfact_year[$i]=$year_ref;
	
	$i=$i+$j;	
}


$week_code=array();

for($i=0; $i<(sizeof($week_code_ref_val)); $i++)
{
	$week_code[$i]=$week_code_ref_val[$i];
}

echo "<tr>";
echo "<th>Week</th>";

for($i=0; $i<(sizeof($week_code_ref_val)); $i++)
{
	echo "<th>".($week_code_ref_val[$i]+$t)."</th>";
}
echo "</tr>";



//Friday of the week
echo "<tr>";
echo "<th>Date</th>";
	
for($i=0; $i<sizeof($week_code); $i++)
{
	
	$friday[$i]=weeknumber_v2($exfact_year[$i],$week_code[$i]);
	$week_array = getStartAndEndDate($week_code[$i],$exfact_year[$i]);
	$monday=date("Y-m-d",strtotime(get_week_date($week_code[$i],$exfact_year[$i])));
	$monday_split=explode("-",$monday);
	
	echo "<td class=date>".$week_array["friday"]."</td>";
}
echo "</tr>";

$sql="select distinct style_id as style_id from $shipment_plan where exfact_date between \"".$start_date."\" and \"".$end_date."\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."') $add_style_id ORDER BY style_id";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Error Message: No styles to process...".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$style_code=$sql_row["style_id"];
	echo "<tr>";
	echo "<th>".$style_code."</th>";
	for($i=0; $i<sizeof($week_code); $i++)
	{
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$week_array = getStartAndEndDate($week_code[$i],$exfact_year[$i]);
			
			echo "<td class=style><a href=\"../".getFullURL($_GET['r'],'Tabular_rep_pop.php','R')."?week_start=".$week_array["week_start"]."&week_end=".$week_array["week_end"]."&style_id=$style_code\" onclick=\"Popup=window.open('../".getFullURL($_GET['r'],'Tabular_rep_pop.php','R')."?week_start=".$week_array["week_start"]."&week_end=".$week_array["week_end"]."&style_id=$style_code','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><center><strong>POP</strong></center></a></td>";
			
		}
	}
	echo "</tr>";
	
	if($Plan_Qty==1 || $All==1){  echo "<tr><td>Plan Qty</td>"; }
	if($Plan_Qty==1 || $All==1)
	{
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$order_qty[$i]=0;
			$week_array1 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);
			unset($temp);
			
			$sql21="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array1["week_start"]."\" and \"".$week_array1["week_end"]."\" and style_id=\"".$style_code."\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			//echo "Query=".$sql21."<br>";		
			$sql_result2=mysqli_query($link, $sql21) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}

			if(sizeof($temp)>0)
			{
				$sql2="select sum(order_qty) as \"order_qty\" from $shipment_plan where ssc_code in (".implode(",",$temp).") $year_add_query2";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $sql2."<br>";
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$order_qty[$i]=$sql_row2['order_qty'];
				}
			}
			else
			{
				$order_qty[$i]=0;
			}
			
			if($order_qty[$i]==0)
			{
				if($Plan_Qty==1 || $All==1){ echo "<td>0</td>";  }
			}
			else
			{
				if($Plan_Qty==1 || $All==1){ echo "<td>".$order_qty[$i]."</td>"; }
			}		
		}
	}
	if($Plan_Qty==1 || $All==1){ echo "</tr>"; }
	
	if($Cut_Qty==1 || $All==1){ echo "<tr><td>Cut Qty</td>"; }
	if($Cut_Qty==1 || $All==1)
	{
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$cut_qty[$i]=0;
			$week_array2 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);
			
			unset($temp);
			
			$sql2="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array2["week_start"]."\" and \"".$week_array2["week_end"]."\" and style_id=\"$style_code\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			//echo $sql2."<br>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}
			
			if(sizeof($temp)>0)
			{
				$sql2="select sum(cut_qty) as \"cut_qty\" from $style_status_summ where ssc_code in (".implode(",",$temp).")";
				//echo $sql2."<br>";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$cut_qty[$i]=$sql_row2['cut_qty'];
				}

				$sql2="select sum(cut_qty) as \"cut_qty\" from $style_status_summ_today where ssc_code in (".implode(",",$temp).")";
				//echo $sql2."<br>";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$cut_qty[$i]=$cut_qty[$i]+$sql_row2['cut_qty'];
				}
			}
			else
			{
				$cut_qty[$i]=0;
			}
			
			if($cut_qty[$i]==0 or $order_qty[$i]==0)
			{
				if($Cut_Qty==1 || $All==1){ echo "<td>0</td>";	}
			}
			else
			{
				if($Cut_Qty==1 || $All==1){ echo "<td>".$cut_qty[$i]."</td>"; }
			}
			
		}
	}
	if($Cut_Qty==1 || $All==1){ echo "</tr>"; }
	
	if($Sewing_IN==1 || $All==1){ echo "<tr><td>Sewing IN</td>"; }
	if($Sewing_IN==1 || $All==1)
	{
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$sewing_in[$i]=0;
			unset($temp);
			$week_array2 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);			
			$sql2="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array2["week_start"]."\" and \"".$week_array2["week_end"]."\" and style_id=\"$style_code\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			//echo $sql2."<br>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}

			if(sizeof($temp)>0){
				$sql2="select sum(sewing_in) as \"sewing_in\" from $style_status_summ where ssc_code in (".implode(",",$temp).")";
				//echo $sql2."<br>";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$sewing_in[$i]=$sql_row2['sewing_in'];
					
				}
				
				$sql2="select sum(sewing_in) as \"sewing_in\" from $style_status_summ_today where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$sewing_in[$i]=$sewing_in[$i]+$sql_row2['sewing_in'];
					
				}
			}else{
				$sewing_in[$i]=0;
			}
			
			if($sewing_in[$i]==0 or $order_qty[$i]==0)
			{
				if($Sewing_IN==1 || $All==1){  echo "<td>0</td>";	}
			}
			else
			{
				if($Sewing_IN==1 || $All==1){ echo "<td>".$sewing_in[$i]."</td>";	}
			}
		}
	}
	if($Sewing_IN==1 || $All==1){  echo "</tr>"; }
		
	if($Sewing_OUT==1 || $All==1){  echo "<tr><td>Sewing OUT</td>"; }
	if($Sewing_OUT==1 || $All==1)
	{
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$sewing_out[$i]=0;
			unset($temp);
			$week_array2 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);			
			$sql2="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array2["week_start"]."\" and \"".$week_array2["week_end"]."\" and style_id=\"$style_code\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}
			
			if(sizeof($temp)>0){
				$sql2="select sum(sewing_out) as \"sewing_out\" from $style_status_summ where ssc_code in (".implode(",",$temp).")";
				//echo $sql2;
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$sewing_out[$i]=$sql_row2['sewing_out'];
				}

				$sql2="select sum(sewing_out) as \"sewing_out\" from $style_status_summ_today where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$sewing_out[$i]=$sewing_out[$i]+$sql_row2['sewing_out'];
				}
			}else
			{
				$sewing_out[$i]=0;
			}
			
			if($sewing_out[$i]==0 or $order_qty[$i]==0)
			{
				if($Sewing_OUT==1 || $All==1){  echo "<td>0</td>";	}
			}
			else
			{
				if($Sewing_OUT==1 || $All==1){  echo "<td>".$sewing_out[$i]."</td>"; }	
			}			
		}
	}
	if($Sewing_OUT==1 || $All==1){  echo "</tr>"; }
		
	if($Packing_Out==1 || $All==1){ echo "<tr><td>Packing Out</td>"; }
	if($Packing_Out==1 || $All==1)
	{
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$pack_out[$i]=0;
			unset($temp);
			$week_array2 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);		
			$sql2="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array2["week_start"]."\" and \"".$week_array2["week_end"]."\" and style_id=\"$style_code\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}			
			
			if(sizeof($temp)>0){
				$sql2="select sum(pack_qty) as \"pack_out\" from $style_status_summ where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$pack_out[$i]=$sql_row2['pack_out'];	
				}
				
				$sql2="select sum(pack_qty) as \"pack_out\" from $style_status_summ_today where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$pack_out[$i]=$pack_out[$i]+$sql_row2['pack_out'];
				}
			}
			else
			{
				$pack_out[$i]=0;
			}	
			
			if($pack_out[$i]==0  or $order_qty[$i]==0)
			{
				if($Packing_Out==1 || $All==1){ echo "<td>0</td>";	}
			}
			else
			{
				if($Packing_Out==1 || $All==1){ echo "<td>".$pack_out[$i]."</td>";	}
			}			
		}
	}
	if($Packing_Out==1 || $All==1){ echo "</tr>"; }
	
	if($Shiping_Out==1 || $All==1){ echo "<tr><td>Shipping Out</td>"; }
		if($Shiping_Out==1 || $All==1){
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$Ship_out[$i]=0;
			unset($temp);
			$week_array2 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);		
			
			$sql2="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array2["week_start"]."\" and \"".$week_array2["week_end"]."\" and style_id=\"$style_code\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}
			
			if(sizeof($temp)>0){
				$sql2="select sum(ship_qty) as \"ship_out\" from $style_status_summ where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$ship_out[$i]=$sql_row2['ship_out'];
					
				}

				$sql2="select sum(ship_qty) as \"ship_out\" from $style_status_summ_today where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$ship_out[$i]=$ship_out[$i]+$sql_row2['ship_out'];
					
				}
			}else{
				$ship_out[$i]=0;
			}
			
			
			if($ship_out[$i]==0  or $order_qty[$i]==0)
			{
				if($Shiping_Out==1 || $All==1){ echo "<td>0</td>";	}
			}
			else
			{
				if($Shiping_Out==1 || $All==1){ echo "<td>".$ship_out[$i]."</td>";	}
			}
			
		}
		}
		if($Shiping_Out==1 || $All==1){ echo "</tr>"; }
		
		if($Sewing_Balance==1 || $All==1){ echo "<tr><td>Sewing Balance</td>"; }
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$sew_bal[$i]=$order_qty[$i]-$sewing_out[$i];
			if($Sewing_Balance==1 || $All==1){ echo "<td>".($sew_bal[$i])."</td>";	}
		}
		if($Sewing_Balance==1 || $All==1){ echo "</tr>"; }
		
		
		if($No_of_Days==1 || $All==1){ echo "<tr><td>No of Days</td>"; }
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$today=date("Y-m-d");
			$nodays[$i]=daysDifference($friday[$i], $today);
			if($No_of_Days==1 || $All==1){ echo "<td>".($nodays[$i])."</td>";	}
		}
		if($No_of_Days==1 || $All==1){ echo "</tr>"; }
		
		if($Current_Modules==1 || $All==1){ echo "<tr><td>Current Modules</td>"; }
		if($Current_Modules==1 || $All==1){
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$sql2="select max(mod_count) as \"mod_count\" from movex_styles where style_id=\"$style_id\"";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$modcount[$i]=$sql_row2['mod_count'];
			}
			
			if($Current_Modules==1 || $All==1){ echo "<td>".($modcount[$i])."</td>"; }	
		}
		}
		if($Current_Modules==1 || $All==1){ echo "</tr>"; }
		
		if($Required_Target==1 || $All==1){ echo "<tr><td>Required Target</td>"; }
		for($i=0; $i<sizeof($week_code); $i++)
		{
			if($nodays[$i]>0 && $modcount[$i]>0)
			{
				$req_tgt[$i]=round($sew_bal[$i]/(15*$nodays[$i]*$modcount[$i]),0);
			}
			else
			{
				$req_tgt[$i]=round($sew_bal[$i]/(15),0);
			}
			
			if($Required_Target==1 || $All==1){ echo "<td>".($req_tgt[$i])."</td>";	}
		}
		if($Required_Target==1 || $All==1){ echo "</tr>"; }
		
		
		if($Actual_Reached==1 || $All==1){ echo "<tr><td>Actual Reached</td>"; }
		if($Actual_Reached==1 || $All==1){
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$act_reach[$i]=0;
			$old_sewing_out[$i]=0;

			unset($temp);
			$week_array2 = getStartAndEndDate($week_code[$i],$exfact_year[$i]);		
			$sql2="select distinct ssc_code from $shipment_plan where exfact_date between \"".$week_array2["week_start"]."\" and \"".$week_array2["week_end"]."\" and style_id=\"$style_code\" and left(style_no,1) in ('".str_replace(",","','",$buyer_div)."')";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$temp[]="\"".$sql_row2['ssc_code']."\"";
			}
			
			if(sizeof($temp)>0){
				$sql2="select sum(old_sewing_out) as \"old_sewing_out\" from $style_status_summ_primary where ssc_code in (".implode(",",$temp).")";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$old_sewing_out[$i]=$sql_row2['old_sewing_out'];
					
				}
			}else{
				$old_sewing_out[$i]=0;
			}
			
			
				if($modcount[$i]>0)
				{
					$act_reach[$i]=($sewing_out[$i]-$old_sewing_out[$i])/($modcount[$i]*15);
				}
				else
				{
					$act_reach[$i]=($sewing_out[$i]-$old_sewing_out[$i])/(15);
				}
				
				if($Actual_Reached==1 || $All==1){ echo "<td>".round($act_reach[$i],0)."</td>"; }	
			
		}
		}
		if($Actual_Reached==1 || $All==1){ echo "</tr>"; }
		
		
		if($Days_Required==1 || $All==1){ echo "<tr><td>Days Required</td>"; }
		for($i=0; $i<sizeof($week_code); $i++)
		{
			if($nodays[$i]==0 || $req_tgt[$i]==0)
			{
				$days_req[$i]=0;
			}
			else
			{
				$days_req[$i]=round($sew_bal[$i]/(15*$nodays[$i]*$req_tgt[$i]),0);
			}
			
			if($Days_Required==1 || $All==1){ echo "<td>".($days_req[$i])."</td>"; }
		}
		if($Days_Required==1 || $All==1){ echo "</tr>"; }
		
		if($Expected_Comp_Date==1 || $All==1){ echo "<tr><td>Expected Comp. Date</td>"; }
		for($i=0; $i<sizeof($week_code); $i++)
		{
			$exp_comp[$i]=date("Y-m-d", mktime(0,0,0,date("m") ,date("d")+$days_req[$i],date("Y")));
			if($Expected_Comp_Date==1 || $All==1){ echo "<td>".($exp_comp[$i])."</td>";	}
		}
		if($Expected_Comp_Date==1 || $All==1){ echo "</tr>"; }
	}

echo "</table>";
}
?>

<script language="javascript">
function popitup(url) {
	newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=1,toolbar=1');
	if (window.focus) {newwindow.focus()}
	return false;
}
function getData(){
 var csv_value=$('#tablecol').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>
</div>
</div>
</div>
</html>


	