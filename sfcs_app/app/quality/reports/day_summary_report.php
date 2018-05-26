<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$view_access=user_acl("SFCS_0053",$username,1,$group_id_sfcs); 
?>
<?php
if(isset($_POST['division']))
{
	$division=$_POST['division'];
}
else
{
	$division="All";
}
?>




<div class="panel panel-primary">
	<div class="panel-heading"><b>Quality Journal</b></div>
	<div class="panel-body">
    <div id="page_heading" class="form-group">
	<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>">
	<div class="col-md-3">
					Start Date <input type="text" data-toggle='datepicker' id="dat1" name="sdate" size="10" value="<?php  if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>" class="form-control"> 
				</div>
				<div class="col-md-3">
					End Date <input type="text" data-toggle='datepicker' id="dat2" class="form-control" name="edate" size="10" value="<?php  if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
				</div>
					<?php
						$sql="select buyer_code,buyer_name from $bai_pro2.buyer_codes where status=1";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$buyer_code[]=$sql_row["buyer_code"];
							$buyer_name[]=$sql_row["buyer_name"];
						}
					?>
				<div class="col-md-3">
					Buyer Division: <select name="division" class="form-control">
						<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
						<?php
							for($i=0;$i<sizeof($buyer_name);$i++)
							{
								if($buyer_name[$i]==$division) 
								{ 
									echo "<option value=\"".$buyer_name[$i]."\" selected>".$buyer_code[$i]."</option>";	
								}
								else
								{
									echo "<option value=\"".$buyer_name[$i]."\">".$buyer_code[$i]."</option>";	
								}
							}
						?>
					</select>
					
				</div>
                  <input type="submit" name="filter" value="Filter" class="btn btn-success" onclick='return verify_date()' style = "margin-top:18px">
			
			</form>
		</div>

		<div class="table table-responsive">
			<?php
				
				if(isset($_POST['filter']))
				{
					
					
					$sdate=$_POST['sdate'];
					$edate=$_POST['edate'];
					$buyer=$_POST["division"];
					// echo $buyer;

					
					if($buyer=="All")
					{
						$sql="select * from $bai_pro3.bai_qms_day_report where log_date between \"$sdate\" and \"$edate\"";
					}
					// else if($buyer=="VS")
					// {
					// 	$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\" and (qms_style like \"L%\" or qms_style like \"O%\" OR qms_style like \"G%\" or qms_style like \"P%\" or qms_style like \"K%\")";
					// }
					// else if($buyer=="M&")
					// {
					// 	$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\" and qms_style like \"M%\"";
					// }
					// else if($buyer=="LB")
					// {
					// 	$sql="select * from bai_qms_day_report where log_date between \"$sdate\" and \"$edate\" and qms_style like \"Y%\"";
					// }
					else
					{
						$sql="SELECT * FROM $bai_pro3.bai_qms_day_report LEFT JOIN bai_orders_db ON order_style_no = qms_style AND order_del_no = qms_schedule AND order_col_des = qms_color where order_div = \"$buyer\" and log_date between \"$sdate\" and \"$edate\"";
					}
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(mysqli_num_rows($sql_result)>0){
						echo "<br><table class='table table-bordered'>";
						echo "<tr class='tblheading'>
						<th>Log Date</th>
						<th>Style</th>
						<th>Schedule</th>
						<th>Color</th>
						<th>Size</th>
						<th>Good Panels</th>
						<th>Rejected</th>
						<th>Replaced</th>
						<th>Transfer - Sent</th>
						<th>Transfer - Received</th>
						<th>Balance Good Panels</th>
						<th>Reserved for Destroy</th>
						<th>Destroyed Panels</th>
						<th>Recut</th>
						<th>Sample Received</th>
						<th>Sample Sent</th>
						<th>O.R. (Garments)</th>
						<th>Destroyed Garments</th>
						</tr>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							echo "<tr>";
							echo "<td>".$sql_row['log_date']."</td>";
							echo "<td>".$sql_row['qms_style']."</td>";
							echo "<td>".$sql_row['qms_schedule']."</td>";
							echo "<td>".$sql_row['qms_color']."</td>";
							//echo "<td>".$sql_row['qms_size']."</td>";
							$size_value=ims_sizes($order_tid,$sql_row['qms_schedule'],$sql_row['qms_style'],$sql_row['qms_color'],$sql_row['qms_size'],$link);
							echo "<td>".$size_value."</td>";
							echo "<td>".$sql_row['good_panels']."</td>";
							echo "<td>".$sql_row['rejected']."</td>";
							echo "<td>".$sql_row['replaced']."</td>";
							echo "<td>".$sql_row['tran_sent']."</td>";
							echo "<td>".$sql_row['tran_rec']."</td>";
							echo "<td bgcolor=\"#99EEFF\">".($sql_row['good_panels']-$sql_row['replaced']-$sql_row['tran_sent']-$sql_row['res_panel_destroy'])."</td>";
							echo "<td>".$sql_row['resrv_dest']."</td>";
							echo "<td>".$sql_row['panel_destroyed']."</td>";
							echo "<td>".$sql_row['actual_recut']."</td>";
							echo "<td>".$sql_row['sample_room']."</td>";
							echo "<td>".$sql_row['sent_to_customer']."</td>";
							echo "<td>".$sql_row['good_garments']."</td>";
							echo "<td>".$sql_row['disposed']."</td>";
							echo "</tr>";
						}
						echo "</table>";
					} else {
						echo "<div><b>No Data Found!</b></div>";
					}
					
				}
			?>
		</div>
	</div>
</div>
<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
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