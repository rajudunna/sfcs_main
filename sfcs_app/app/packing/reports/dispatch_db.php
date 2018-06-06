
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R') );  ?>
<?php
	$view_access=user_acl("SFCS_0030",$username,1,$group_id_sfcs); 
?>
<style>
th,td{
	color : #000;
}
</style>

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Advice Of Dispatch</b>
	</div>
	<div class='panel-body'>
		<?php 

		if(isset($_GET['date']))
		{
			$date=$_GET['date'];
			echo "<h3>Dispatch Note Details - ".date("M-Y",strtotime($date))."</h3><hr>";
			echo '<a class="btn btn-warning btn-xs" href="index.php?r='.$_GET['r'].'&date='.date("Y-m-d",strtotime("-1 month", strtotime($date))).'"> Previous Month</a>  |  ';
			echo '<a class="btn btn-warning btn-xs" href="index.php?r='.$_GET['r'].'&date='.date("Y-m-d",strtotime("+1 month", strtotime($date))).'"> Next Month</a>   ';
		}
		else
		{
			$date=date("Y-m-d");
			echo'<h3>Dispatch Note Details -'.date("M-Y",strtotime($date)).'</h3><hr>';
			//echo "<h2>Dispatch Note Details - ".date("M-Y",strtotime($date))."</h2>";
			echo '<a class="btn btn-warning btn-xs" href="index.php?r='.$_GET['r'].'&date='.date("Y-m-d",strtotime("-1 month")).'"> Previous Month</a>';
		}

		$row_count = 0;
		
		$sql="select * from $bai_pro3.disp_db dd
			  left join $bai_pro3.party_db pt on dd.party=pt.pid 
			  where month(dd.create_date)=month(\"$date\") 
			  and year(dd.create_date)=year(\"$date\") 
			  order by dd.disp_note_no DESC";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_sch=mysqli_num_rows($sql_result);
		$pre_count=0;
		$pri_count=0;
		$dis_count=0;
		if($num_sch > 0)
		{
		echo "<div class='row'><div class='col-md-10 table-responsive' style='max-height:600px;overflow:auto;'>";
		echo "<table class='table table-bordered'>";
		echo "<tr class='info'><th>Dispatch No</th><th>Date</th><th>Party</th><th>Vehicle Details</th><th>Status</th><th>Exit Time</th></tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$row_count++;
			$disp_note_no = $sql_row['disp_note_no'];
			$url = $_GET['r']."&disp_id=".$disp_note_no;
			$popup_url = '..'.getFullURL($_GET['r'],"dispatch_note.php",'R');
			echo "<tr>";
			echo "<td>
				<a class='btn btn-success btn-sm' href='index.php?r=$url' 
					onclick=\"Popup=window.open('$popup_url?disp_id=$disp_note_no','Popup',
					'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); 
						if (window.focus){
							Popup.focus()
						}
							return false;
					\">$disp_note_no</a>
				</td>";
			
			//<a href=\"dispatch_note.php?disp_id=".$sql_row['disp_note_no']."\" target=\"_blank\">".$sql_row['disp_note_no']."</a></td>";
			echo "<td>".$sql_row['create_date']."</td>";
			echo "<td>".$sql_row['party_name']."</td>";
			echo "<td>".$sql_row['vehicle_no']."</td>";
			switch($sql_row['status'])
			{
				case 1:
				{
					echo "<td>Prepared</td>";
					$pre_count++;
					break;
				}
				case 2:
				{
					echo "<td>Printed</td>";
					$pri_count++;
					break;
				}
				case 3:
				{
					echo "<td>Dispatched</td>";
					$dis_count++;
					break;
				}
			}
			echo "<td>".$sql_row['exit_date']."</td>";
			echo "</tr>";	
		}
		
		echo "</table></div>";
		if(mysqli_num_rows($sql_result) > 0){
			echo "<div class='col-sm-2' style='color : blue;'>
					<u>Quick Stats</u><br/>".str_pad($num_sch,3,0,STR_PAD_LEFT)." : Prepared</br>".str_pad($pri_count,3,0,STR_PAD_LEFT)." : Printed<br/>".str_pad($dis_count,3,0,STR_PAD_LEFT)." : Dispatched</div>";
		}
		echo "</div>";
		}
		else
		{
			echo "<script>swal('No Data Found.','','warning');</script>";		
		}
		?>

	
  </div>
</div>
</div>
