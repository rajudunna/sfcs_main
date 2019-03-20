	<?php
	
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	

	$sql = "SELECT * FROM $bai_pro3.tbl_plant_timings";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1;
		if($norows > 0){
		echo "<table id='downtime_reason' class='table'><thead><tr><th>S.No</th><th>Time Value</th><th>Time Display</th><th>Start Time</th><th>End Time</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$rowid=$row["time_id"];
			$time_value=$row["time_value"];
			$time_display=$row["time_display"];
			$start_time=$row["start_time"];
			$end_time=$row["end_time"];
			$day_part = $row["day_part"];
			
			$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
			$url1=getFullURL($_GET['r'],'delete_plant_timings.php','N');

			echo "<tr><td>".$sno++."</td><td>".$row["time_value"]."</td><td>".$row["time_display"]." </td><td>".$row["start_time"]."</td><td>".$row["end_time"]."</td>
			<td>
			<a href='$url&id=$rowid&time_value=$time_value&time_display=$time_display&day_part=$day_part&start_time=$start_time&end_time=$end_time' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$url1&id=$rowid&time_value=$time_value&time_display=$time_display&day_part=$day_part&start_time=$start_time&end_time=$end_time'class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a>
			</td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "<span class='label label-danger'>0 results</span>";
	}
	?>


<script>
$(document).ready(function() {
    $('#downtime_reason').DataTable();
} );

function confirm_delete(e,t)
{
	e.preventDefault();
	var v = sweetAlert({
	title: "Are you sure to Delete the Record?",
	icon: "warning",
	buttons: true,
	dangerMode: true,
	buttons: ["No, Cancel It!", "Yes, I am Sure!"],
	}).then(function(isConfirm){
		if (isConfirm) {
			window.location = $(t).attr('href');
			return true;
		}else{
			sweetAlert("Request Cancelled",'','error');
			return false;
		}
	});
}
</script>

<style>
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
</style>