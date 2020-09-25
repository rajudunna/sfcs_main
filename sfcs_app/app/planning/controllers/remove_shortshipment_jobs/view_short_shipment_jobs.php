<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));
    
	$sql = "SELECT * FROM $bai_pro3.`short_shipment_job_track` where remove_type in ('1','2') order by id desc";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1;

	
	if ($norows > 0) {
		echo "<table id='shortshipmentjob' class='table'><thead><tr><th>S.No</th><th>Date Time</th><th>Style</th><th>Schedule</th><th>Remove Type</th><th>Removed By</th><th>Remove Reason</th><th>Control</th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$rem_type = $row["remove_type"];
			// echo $rem_type;die();
            $id = $row['id'];
            $style = $row['style'];
			$schedule = $row['schedule'];
			$status = $row['remove_type'];
			// var_dump($status);
			// die();
			$edit_url = getFullURL($_GET['r'],'reverse_short_shipment_jobs.php','N');
			echo "<tr><td>".$sno++."</td><td>".$row["date_time"]." </td><td>".$row["style"]."</td><td>".$row["schedule"]."</td>";
			if($row["remove_type"]==1) {
				echo "<td><label class='label label-success'>Temporary</label></td>";
			}else{
				echo "<td><label class='label label-danger'>Permanent</label></td>";
			}
			$main_style = style_encode($style);
			echo "<td>".$row["removed_by"]."</td><td>".$row["remove_reason"]."</td>";
			if($status == '1') {
				echo "<td><a href='$edit_url&id=$id&style=$main_style&schedule=$schedule&rem_type=$rem_type' class='btn btn-warning btn-sm editor_edit glyphicon glyphicon-retweet' onclick='return confirm_reverse(event,this);'> REVERSE </a></td>";
			} else {
				echo "<td><label class='label label-sm label-danger'>Can't Reverse</label></td>";
			}
            
            echo "</tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	?>


<script>
$(document).ready(function() {
    $('#shortshipmentjob').DataTable();
} );

function confirm_reverse(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Remove?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        console.log(isConfirm);
        if (isConfirm) {
            window.location = $(t).attr('href');
            return true;
        } else {
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