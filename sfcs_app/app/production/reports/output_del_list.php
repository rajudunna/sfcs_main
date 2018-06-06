<!DOCTYPE html>
	<title>Output Deleted List</title>
	<?php 
		
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
        include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
		$view_access=user_acl("SFCS_0069",$username,1,$group_id_sfcs);
		$output_del_list = getFullURL($_GET["r"],"output_del_list.php","N")
	?>
	<style type=\"text/css\" media=\"screen\">
		body{
		margin:15px; padding:15px; border:opx solid #666;
		font-family:Trebuchet MS, sans-serif; font-size:88%;
		height:100%;
		width:100%;
		}
		.table{
		width:100%;
		font-size:12px;
		border:1px solid #ccc;
		white-space: nowrap;
		position:relative;
		border-collapse:collapse;
		}
		div.tools{ margin:5px; }
		div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
		tr{ font-size : 12px; }
		th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
		td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; font-size : 12px; }	
	</style>
	<?php 
	echo '<div class="panel panel-primary"><div class="panel-heading">Output Deleted List</div><div class="panel-body">';
	?>
	<form name="input" class="form-inline" method="post" action="".$output_del_list>
		<div class="row">
			<div class="col-md-3">
				<label>Start Date : </label>
				<input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" class="form-control" type="text" data-toggle="datepicker" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
			</div>
			<div class="col-md-3">
				<label>End Date : </label>
				<input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" class="form-control" type="text" data-toggle="datepicker" size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
			</div>
			<div class="col-md-3">
				<button type="submit" name="submit" value="submit" id="submit" onclick ="return verify_date()" class="btn btn-primary">Filter</button>
			</div>
		</div>
	</form>
	<?php 
		if(isset($_POST['submit']))
		{
			$sdate=$_POST['sdate'];
			$edate=$_POST['edate'];
			$sql='select bac_no,bac_sec,bac_qty,bac_lastup,bac_date,bac_shift,bac_style,bac_remarks,log_time,buyer,delivery,color,loguser from bai_pro.bai_log_deleted where bac_date between "'.$sdate.'" and "'.$edate.'" order by bac_date,bac_no+0';
			$result=mysqli_query($link, $sql) or die("Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows=mysqli_num_rows($result);
			if ($rows > 0) {
				echo "<br/><br/><h4><span class='label label-warning'><b>Please find below Output Deleted Entries from $sdate to $edate.</b></span></h4><br/>";
				echo "<div class='row'><div class='col-md-4'><table class='table table-bordered table-responsive' width='20px;'>";
				echo "<tr style='background-color:#286090;color:white;'><th>Buyer</th><th>Count</th></tr>";
				$sql1='select buyer,count(bac_no) as cnt from bai_pro.bai_log_deleted where bac_date between "'.$sdate.'" and "'.$edate.'" group by buyer';
				$result1=mysqli_query($link, $sql1) or die("Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1=mysqli_fetch_array($result1))
				{
					echo "<tr>";
					echo "<td>".$row1["buyer"]."</td>";
					echo "<td style='text-align:right;'>".$row1["cnt"]."</td>";
					echo "</tr>";
				}
				echo"<tr><td>Total</td><td style='text-align:right;'>$rows</td></tr>";
				echo "</table></div></div><br/>";
				echo "<div class='col-md-12' style='max-height:600px;overflow-y:scroll;'><table class='table table-fixed table-bordered table-responsive'>";
				echo "<thead><tr style='background-color:#286090;color:white;'><th>Date</th><th>Section</th><th>Module</th><th>Shift</th><th>Buyer</th><th>Style</th><th>Schedule</th><th>Color</th><th>Quantity</th><th>Reporting Time</th><th>Updated Time</th><th>Updated User</th><th>Deleted User</th><th>Deleted Time</th><th>Reason</th></tr></thead><tbody>";
				while($row=mysqli_fetch_array($result))
				{
					$remarks=explode("^",$row["bac_remarks"]);
					echo "<tr>";
					echo "<td>".$row["bac_date"]."</td>";
					echo "<td style='text-align:right;'>".$row["bac_sec"]."</td>";
					echo "<td style='text-align:right;'>".$row["bac_no"]."</td>";
					echo "<td>".$row["bac_shift"]."</td>";
					echo "<td>".$row["buyer"]."</td>";
					echo "<td>".$row["bac_style"]."</td>";
					echo "<td>".$row["delivery"]."</td>";
					echo "<td>".$row["color"]."</td>";
					echo "<td style='text-align:right;'>".$row["bac_qty"]."</td>";
					echo "<td>".$row["bac_lastup"]."</td>";	
					if($row["log_time"] == '0000-00-00 00:00:00'){
						$row["log_time"] = '-';
						echo "<td style='text-align:center;'>-</td>";	
					}
					else {
						echo "<td>".$row["log_time"]."</td>";	
					}
					echo "<td>".$row["loguser"]."</td>";
					if(sizeof($remarks) > 2)
					{
						echo "<td>".$remarks[1]."</td>";
						echo "<td>".$remarks[2]."</td>";
						echo "<td>".$remarks[0]."</td>";
					}
					else
					{
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
					}
					
					echo "</tr>";
				}
			}
			else {
				echo "<br/><br/><br/><div style='color:red;font-size:16px;text-align:center;font-weight:bold;'>No Output Deleted Entries Found from ".$sdate." to ".$edate."</div>";
			}
		}
		echo '</tbody></table></div></div></div>';
		
		?>
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
</div>