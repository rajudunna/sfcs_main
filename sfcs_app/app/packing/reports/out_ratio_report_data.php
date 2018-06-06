<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	      ?>
<title>Out Of Ratio Report</title>
<?php
$form_action = $_GET['r'];
?>

<?php 
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

$start_week=$_POST["sdat"];
$end_week=$_POST["edat"];
$year_no=$_POST["year"];
$cat=$_POST["cat"];
$schedule = $_POST['sche'];

// echo 'start'.$start_week.'<br>';
// echo 'end'.$end_week.'<br>';
// echo 'year'.$year_no.'<br>';
// echo 'cat'.$cat.'<br>';
// echo 'sch'.$schedule.'<br>';

?>

<style>
td,th{color : #000;}
</style>

<script>
function verify_date(){
	var from_date = $('#sdate').val();
	var to_date   = $('#edate').val();

	if(from_date.length > 2 || to_date.length > 2){
		$('#sdate').val(0);
		$('#edate').val(0);
		sweetAlert('Only 2 digits are allowed','','info');
	}


	if(to_date < from_date){
		$('#edate').val($('#sdate').val());
		sweetAlert('End Week must not be less than Start Week','','warning');
		return false;
	}

	if(to_date > 53 || from_date > 53){
		$('#sdate').val(0);
		$('#edate').val(0);
		sweetAlert('Week should not exceed 53','','warning');
		return false;
	}
	if(to_date <0 || from_date<0){
		sweetAlert('Weeks Must not be negative','','warning');
		$('#sdate').val(1);
		$('#edate').val(1);
		return false;
	}
}

function limit_date(e){
	var k = e.which;
	if(k == 187 || k == 189 || k==43 || k==45){
		sweetAlert('No special characters','','danger');
		e.preventDefault();
		return false;
	}
 	var from_date = $('#sdate').val();
 	var to_date = $('#edate').val();
		if(from_date.length > 2 || to_date.length > 2){
			sweetAlert('Only 2 digits are allowed','','info');
			e.preventDefault();
			$('#sdate').val(from_date.substr(0,2));
			$('#edate').val(to_date.substr(0,2));
			return false;
		}

}


function verify_year(){
	var year = $('#year').val();
	if(year < 2000 || year > 2030){
		sweetAlert('Please enter a valid year','','warning');
		$('#year').val(2017);
	}
}

</script>

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Out Of Ratio Reporting</b>
	</div>
	<div class='panel-body'>
		<form action='?r=<?= $form_action ?>' method='POST'>
			<div class='col-sm-2 form-group'>
				<label for='sdat'>Week Start </label>
				<input required class='form-control integer' type="text"  id='sdate' onkeydow='return limit_date(event)' size='2' name="sdat" placeholder='0' >
			</div>
			<div class='col-sm-2 form-group'>
				<label for='edat'>Week End </label>
				<input required class='form-control' type="text"  id='edate'  onkeydow='return limit_date(event)' size='2' name="edat" placeholder='1'>
			</div>
			<div class='col-sm-2 form-group'>
				<label for='year'>Year </label>
				<input required class='form-control' type="number" placeholder='2017' id='year' onchange=verify_year() size="4" name="year" value="<?php echo date("Y"); ?> ">
			</div>
			<div class='col-sm-2 form-group'>
				<label for='cat'>Criteria </label>
				<select required class='form-control' name="cat"  required>
					<option value="0">Select</option>
					<option value="1">Reported Date</option>
					<option value="2">Ex-Factory Date</option>
				</select>
			</div>
			<div class='col-sm-2 form-group'>
				<label for='sche'>Schedule </label>
				<input required class='form-control' type="number" name="sche" size="8" value=""/>
			</div>
			<div class='col-sm-1'>
				<br>
				<input class='btn btn-warning' type="submit" name="submit" value="submit"
				 onclick='return verify_date()' >
			</div>
		</form>
<br><br>

<div class='table-responsive' style='max-height:600px;overflow:auto'>
<?php
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
if($username=="amulyap" or $username=="kirang")
{
	echo "<div class='row'>";
	echo "<span class='col-sm-1'>
		  <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-warning' href='".getFullURL($_GET['r'],'out_of_ratio_report.xls','N')."'>Export To Excel</a></b>
		  </span>
		  <span class='col-sm-1'>
		  <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-success' href='".getFullURL($_GET['r'],'distraction_details_excel_format.php','N')."'>Destroy Interface</a></b>
		  </span>";
	echo "</div>";	  
}
//echo '<span id="msg" style="display:;"><h4>Please Wait.. While Processing The Data..<h4></span>';
?>

<?php

$start_week=(int)$start_week;
$end_week=(int)$end_week;

function getDaysInWeek ($weekNumber, $year) 
{
	// Count from '0104' because January 4th is always in week 1
	// (according to ISO 8601).
	$time = strtotime($year . '0104 +' . ($weekNumber - 1). ' weeks');
	// Get the time of the first day of the week
	$mondayTime = strtotime('-' . (date('w', $time) - 1) . ' days',$time);
	// Get the times of days 0 -> 6
	$dayTimes = array ();
	for ($i = 0; $i < 7; ++$i) 
	{
		$dayTimes[] = strtotime('+' . $i . ' days', $mondayTime);
	}
	// Return timestamps for mon-sun.
	return $dayTimes;
}

for($i=$start_week;$i<=$end_week;$i++)
{
	$dayTimes = getDaysInWeek($i, $year_no);
	foreach ($dayTimes as $dayTime) 
	{
		$dates[]=strftime('%Y-%m-%d', $dayTime);
		//echo (strftime('%Y-%m-%d', $dayTime) . "<br>");
	}	
}
$max=sizeof($dates)-1;
set_time_limit(1000000000);

$sizes_cap=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");

$sizes=array("xs","s","m","l","xl","xxl","xxxl","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");

$sdat=$dates[0];
$edat=$dates[$max];

$row_count = 0;
echo "<table class='table table-bordered'>
		<tr class='danger'>
			<th>Reported Date</th>
			<th>Style</th>
			<th>Schedule</th>
			<th>Color</th>
			<th>Sizes - Quantity</th>";

for($i=0;$i<sizeof($sizes);$i++){
	//echo "  <th>".$sizes_cap[$i]."</th>";
}  	
	echo "  <th>Total</th>
			<th>Garment Category</th>
			<th>Carton ID</th>
			<th>Mod #</th>
			<th>Ex-Fac</th>
			<th>Week no</th>
	    </tr>";

$schedules_array=array();
if($cat==1)
{
	$sql1x="select distinct qms_schedule as del from $bai_pro3.bai_qms_db where log_date between \"".$sdat."\" and \"".$edat."\" AND qms_schedule > 0";
	//echo "<br>".$sql1x."<br>";
	$result1x=mysqli_query($link, $sql1x) or die("Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1x=mysqli_fetch_array($result1x))
	{
		$schedules_array[]=$row1x["del"];
	}
	$query="and log_date between '$sdat' and '$edat' ";
}
if($cat==2)
{
	//$sql="select distinct order_del_no as del from bai_orders_db where order_style_no not like \"M%\" AND order_date between \"".$sdat."\" and \"".$edat."\" and order_del_no > 0 order by order_date";
	//$sql="select distinct qms_schedule as del from bai_qms_db where SUBSTRING_INDEX(SUBSTRING_INDEX(ref1,'^',-1),'/',1) BETWEEN \"".$start_week."\" AND \"".$end_week."\"";
	// 	Ticket #372506 / Add the trim function to $cat2==2 $sql query & $query and also add the order by group
	$sql="select distinct qms_schedule as del from $bai_pro3.bai_qms_db where trim(SUBSTRING_INDEX(SUBSTRING_INDEX(ref1,'^',-1),'/',1)) BETWEEN $start_week AND $end_week order by SUBSTRING_INDEX(SUBSTRING_INDEX(ref1,'^',-1),'/',1)+0";
	//echo $sql;
	$result=mysqli_query($link, $sql) or die("Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{
		$schedules_array[]=$row["del"];
	}
	//$query=" AND SUBSTRING_INDEX(SUBSTRING_INDEX(ref1,'^',-1),'/',1) BETWEEN \"".$start_week."\" AND \"".$end_week."\"";
	$query=" AND trim(SUBSTRING_INDEX(SUBSTRING_INDEX(ref1,'^',-1),'/',1)) BETWEEN $start_week AND $end_week order by SUBSTRING_INDEX(SUBSTRING_INDEX(ref1,'^',-1),'/',1)+0";
}
 
//echo implode(",",$schedules_array)."-".sizeof($schedules_array);

$schedules_array1=array();
$sql1="select distinct qms_schedule as del from $bai_pro3.bai_qms_db where qms_schedule in ('".implode(",",$schedules_array)."') $query";
//echo $sql1;
$result1=mysqli_query($link, $sql1) or die("Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row1=mysqli_fetch_array($result1))
{
	$schedules_array1[]=$row1["del"];
}
//echo implode(",",$schedules_array1)."-".sizeof($schedules_array1);

for($i=0;$i<sizeof($schedules_array1);$i++) //----------------Main For Loop-------------------------------------------------------------
{
	$sql2="select * from $bai_pro3.bai_orders_db where order_del_no='".$schedules_array1[$i]."'";
	$result2=mysqli_query($link, $sql2);
	while($row2=mysqli_fetch_array($result2))
	{
		$style=$row2["order_style_no"];
		//echo $style.'<br>';
		$schedule=$row2["order_del_no"];
		$color=$row2["order_col_des"];
		$ex_date=$row2["order_date"];
	}
	
	$sql3="select distinct(ref1) as ref from $bai_pro3.bai_qms_db where qms_style=\"".$style."\" and qms_schedule='".$schedule."' and qms_color=\"".$color."\" and qms_tran_type=\"5\" $query";
	$counting = 0;
	$result3=mysqli_query($link, $sql3);
	while($row3=mysqli_fetch_array($result3))//While 1
	{		
		$ref=$row3["ref"];
		$sql5x="select distinct(log_date) from $bai_pro3.bai_qms_db where qms_schedule=\"".$schedule."\" and qms_style=\"".$style."\" and qms_color=\"".$color."\" and qms_tran_type=\"5\" and ref1=\"".$ref."\" $query";
		$result5x=mysqli_query($link, $sql5x) or die("Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row5x=mysqli_fetch_array($result5x))// while 2
		{
			$log_date=$row5x["log_date"];
		
			$sql5="select group_concat(distinct(remarks)) as module from $bai_pro3.bai_qms_db where qms_schedule=\"".$schedule."\" and qms_style=\"".$style."\" and qms_color=\"".$color."\" and qms_tran_type=\"5\" and ref1=\"".$ref."\" and log_date=\"".$log_date."\" $query";
			$result5=mysqli_query($link, $sql5) or die("Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row5=mysqli_fetch_array($result5))
			{
				$module=$row5["module"];		
			}
			$module_explode=explode(",",$module);
			for($j=0;$j<sizeof($module_explode);$j++)
			{
				$sHTML_Content.= "<tr>";
				$sHTML_Content.= "<td>".$log_date."</td>";
				$sHTML_Content.= "<td>".$style."</td>";
				$sHTML_Content.= "<td>".$schedule."</td>";
				$sHTML_Content.= "<td>".$color."</td>";
				echo $sHTML_Content;	
				for($j1=0;$j1<sizeof($sizes);$j1++)
				{					
					$sql4="select sum(qms_qty) as sum from $bai_pro3.bai_qms_db where qms_schedule=\"".$schedule."\" and qms_style=\"".$style."\" and qms_color=\"".$color."\" and qms_size=\"".$sizes[$j1]."\" and qms_tran_type=\"5\" and ref1=\"".$ref."\" and remarks=\"".$module_explode[$j]."\" and log_date=\"".$log_date."\" $query";
					$result4=mysqli_query($link, $sql4) or die("Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row4=mysqli_fetch_array($result4))
					{

						if($row4["sum"] > 0){
							$data.= '<b>'.$sizes_cap[$j1].'</b> - '.round($row4["sum"],0).' , ';
							$counting++;
						}
						if($counting > 3){
							echo '<br>';
							$counting = 0;
						}
						//echo "<td>".round($row4["sum"],0)."</td>";
					}
				}
				echo "<td>$data</td>";
			
				$sql5="select sum(qms_qty) as sum_tot from $bai_pro3.bai_qms_db where qms_schedule=\"".$schedule."\" and qms_style=\"".$style."\" and qms_color=\"".$color."\" and qms_tran_type=\"5\" and ref1=\"".$ref."\" and remarks=\"".$module_explode[$j]."\" and log_date=\"".$log_date."\" $query";
				$result5=mysqli_query($link, $sql5) or die("Error5=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row5=mysqli_fetch_array($result5))
				{
					echo "<td>".round($row5["sum_tot"],0)."</td>";
				}
				$row_count++;
				$ref_explode=explode("^",$ref);
				echo "<td>".$ref_explode[0]."</td>";
				echo "<td>".$ref_explode[1]."</td>";
				echo "<td>".$module_explode[$j]."</td>";
				echo "<td>".$ex_date."</td>";
				$week_no=(int)date("W",strtotime($ex_date));
				echo "<td>".$week_no."</td>";
				echo "</tr>";
			}																											
		}//closing while 2
	}//closing while 1	
}//---------------closing Main For loop-------------------------------------

echo "</table>";
if($row_count == 0){
 	echo "<center><b style='color:#ff0000'>No Data Found</b></center>";
}

if($username=="amulyap" or $username="kirang")
{
	$filename = "out_of_ratio_report.html"; 
	/*$myFile = "out_of_ratio_report.html";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData=$sHTML_Header;
	$stringData.=$sHTML_Content;
	$stringData.=$sHTML_Footer;
	fwrite($fh, $stringData);
	fclose($fh);*/
	
	$myFile1 = "out_of_ratio_report.xls";
	unlink("out_of_ratio_report.xls");
	$fh1 = fopen($myFile1, 'w') or die("can't open file");
	$stringData1=$sHTML_Header;
	$stringData1.=$sHTML_Content;
	$stringData1.=$sHTML_Footer;
	fwrite($fh1, $stringData1);
	fclose($fh1);
}	

?>
		</div><!--col-sm-12 -->
	</div><!-- panel body -->
</div><!--panel -->

</div>

