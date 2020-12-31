<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>

<script type="text/javascript" src="<?php echo getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>


<div class="panel panel-primary"><div class="panel-heading">Daily Rejection Analysis</div><div class="panel-body">

<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>">
<div class="row">
	<div class='col-md-2'><label>Start Date</label><input id="demo1" class="form-control" type="text" data-toggle='datepicker' name="sdate" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"></div>
	<div class='col-md-2'><label>End Date </label><input id="demo2" type="text" data-toggle='datepicker' name="edate" class="form-control" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>"></div>
	<br/>
	<div class='col-md-1'>
	<input type="submit" name="filter" value="Filter" onclick ="return verify_date()" class="btn btn-primary">
	</div>
</div>
</form>


<?php

if(isset($_POST['filter']))
{
	echo "<hr>";
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	
	$sql_rejection ="SELECT date(rt.created_at) as rej_date,rt.workstation_id,rh.style,rh.schedule,rh.fg_color,rh.size,rt.job_number,SUM(rt.rejection_quantity) AS rej_qty,SUM(rt.replaced_quantity) AS rep_qty,rt.reason_id FROM $pts.rejection_transaction AS rt LEFT JOIN $pts.rejection_header AS rh ON rt.rh_id=rh.rh_id WHERE DATE(rt.created_at) BETWEEN '".$sdate."' AND '".$edate."' group by rh.style,rh.schedule,rh.fg_color,rh.size";
	$sql_result=mysqli_query($link, $sql_rejection) or exit("Error while Fetching Out put Information".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result) > 0) {
		$export_excel = getFullURLLevel($_GET['r'],'export_excel.php',0,'R');
		echo '<form action="'.$export_excel.'" method ="post" >
				<input type="hidden" name="csv_text" id="csv_text">
				<input type="submit" class="btn btn-success btn-xs pull-right" id="export" style="background-color:#57b756;" value="Export to Excel" onclick="getCSVData()">
				</form>';
		echo "<div class='table-responsive' style='max-height:800px;overflow-y:scroll;'><table id=\"example1\" class='table table-bordered table-striped'>";
		echo "<tr class='tblheading'>
			<th>Date</th>
			<th>Module</th>
			<th>Section</th>
			<th>Style</th>
			<th>Schedule</th>
			<th>Color</th>
			<th>Docket / Job Number</th>
			<th>Size</th>
			<th>Rejection<br/>Description</th>
			<th>Qty</th>
			<th>Replaced</th>
		</tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$date = $sql_row['rej_date'];
			$workstation_id = $sql_row['workstation_id'];
			$style = $sql_row['style'];
			$schedule = $sql_row['schedule'];
			$fg_color = $sql_row['fg_color'];
			$size = $sql_row['size'];
			$job_number = $sql_row['job_number'];
			$rej_qty = $sql_row['rej_qty'];
			$rep_qty = $sql_row['rep_qty'];
			$reason_id = $sql_row['reason_id'];
			$workstation="SELECT ws.workstation_code,sc.section_code FROM $pms.workstation ws LEFT JOIN $pms.sections AS sc ON sc.section_id = ws.section_id  where ws.workstation_id='$workstation_id'";
			$workstation_result=mysqli_query($link, $workstation) or exit("Sql Error42".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($workstation_result_row=mysqli_fetch_array($workstation_result))
			{
				$workstation_code=$workstation_result_row["workstation_code"];
				$section_code=$workstation_result_row["section_code"];
			}
			
			$reason="SELECT rs.internal_reason_description AS reason_code FROM $mdm.reasons rs where rs.reason_id='$reason_id'";
			$reason_result=mysqli_query($link, $reason) or exit("Sql Error423".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($reason_result_row=mysqli_fetch_array($reason_result))
			{
				$reason_code=$reason_result_row["reason_code"];
			}
			if($rej_qty > 0 || $rep_qty>0){
				echo "<tr>";
				echo "<td>".$date."</td>";
				echo "<td>".$workstation_code."</td>";
				echo "<td>".$section_code."</td>";
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$fg_color."</td>";
				echo "<td>".$job_number."</td>";
				echo "<td>".$size."</td>";
				echo "<td>".$reason_code."</td>";
				echo "<td>".$rej_qty."</td>";
				echo "<td>".$rep_qty."</td>";
				echo "</tr>";
			}
		}
		echo "</table>"; 
	}else {
		echo "<div style='color:Red' font-size:12px;><center><b><h3>! No data Found</h3></b></center></div>";
	}
	
}


?>

<script>
function getCSVData(){
	var csv_value=$('#example1').table2CSV({delivery:'value'});
		$("#csv_text").val(csv_value);	
	}
</script>

<style>


table tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}

table td.lef
{
	border: 1px solid grey;
	text-align: left;
	white-space:nowrap; 
}
table th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
/* #filter {
    width: 5em;  height: 3em;
}
#export {
    width: 20em;  height: 3em;
	margin-left:520px;
	
} */
}

}
</style>
</div></div>
</div>
</div>
<script >
function verify_date()
{
	var val1 = $('#demo1').val();
	var val2 = $('#demo2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
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
