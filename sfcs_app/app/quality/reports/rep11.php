<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0057",$username,1,$group_id_sfcs);
 ?>


<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R'); ?>" ></script>

<script>
function verify_date(e){
	var from = document.getElementById('demo1').value;
	var to =   document.getElementById('demo2').value;
	if(from > to){
		sweetAlert('From date should not be greater than To Date','','warning');
		e.preventDefault();
		return false;
	}
	return true;
}
</script>


<div class="panel panel-primary">
	<div class="panel-heading">Sample Room Transaction Log
	</div>
	<div class="panel-body">
		<form name="input" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
		<div class='col-sm-3'>
			<label>Start Date</label> 
			<input id="demo1" type="text" class='form-control' data-toggle='datepicker' name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
		</div>
		<div class='col-sm-3'>
			<label>End Date</label>
			<input class='form-control' id="demo2" type="text" data-toggle='datepicker' size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
		</div>
		<div class='col-sm-3'>
			<label></label><br/>
			<input type="submit" name="filter" value="Filter" class="btn btn-success" onclick='return verify_date(event)'>
		</div>
		</form><br>

<?php

if(isset($_POST['filter']))
{
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];	
	
	$sql="select * from $bai_pro3.bai_qms_db where qms_tran_type in (4,8) and log_date between \"$sdate\" and \"$edate\" order by log_date,substring_index(remarks,\"-\",1)+0,substring_index(remarks,\"-\",-1),qms_style,qms_schedule,qms_color,qms_size";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result) > 0) {
		echo '<div class="row">
				<div class="col-sm-2">
					<form action='.getFullURL($_GET['r'],'export_excel.php','R').' method ="post" > 
					<input type="hidden" name="csv_text" id="csv_text">
					<input type="submit" value="Export to Excel" class="btn btn-warning" onclick="getTableData()">
					</form>
				</div>
			 </div><br/>';

		    echo '<div class="row" style="overflow-x:scroll;overflow-y:scroll;max-height:600px;">';
			echo "<table id='example1' class=\"table table-bordered\">";
			echo "<tr class='danger'>
					<th>Date</th>
					<th>Module</th>
					<th>Section</th>
					<th>Shift</th>
					<th>Style</th>
					<th>Schedule</th>
					<th>Color</th>
					<th>Size</th>
					<th>Qty</th>
					<th>Remarks</th>
					<th>Sample type</th>
					<th>Ex Factory Date</th>
				</tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$temp=array();
			$temp=explode("-",$sql_row['remarks']);
			
			if($sql_row['qms_tran_type']==4){
				$section=$temp[0];
				$module=$temp[1];
				$team=$temp[2];
				$remarks="-";
				$status='';
				$status123='-';
				
			}else{
				$section="-";
				$module="-";
				$team="-";
				$remarks=$sql_row['remarks'];
				
				$sqlxs="select status from $bai_fin_pj3.aod_db where track_id=".$temp[1];
				//echo $sql;
				
				$sql_resultxs=mysqli_query($link, $sqlxs) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowxs=mysqli_fetch_array($sql_resultxs))
				{
					$status=$sql_rowxs['status'];
					
					switch($status)	{
						case 0:
						{
							
							$status="Created";
							
							break;
						}
						case 1:
						{
							
							$status="Printed";
							
							break;
						}
						case 2:
						{
							$status="Canceled";
							break;
						}
						case 3:
						{
							
							$status="***Sent";
								
							break;
						}
						case 4:
						{
							$status="Partial Return";
							break;
						}
						case 5:
						{
							
							$status="Full Return";
							
							break;
						}
						case 6:
						{
							$status="Closed";
							break;
						}
					}
				}
				if($status) {
					$status123="(".$status.")";
				}else {
					$status123 = "(No Status in DB)";
				}
			}
			echo "<tr>";
			echo "<td>".$sql_row['log_date']."</td>";
			echo "<td>".$module."</td>";
			echo "<td>".$section."</td>";
			echo "<td>".$team."</td>";
			echo "<td>".$sql_row['qms_style']."</td>";
			echo "<td>".$sql_row['qms_schedule']."</td>";
			echo "<td class=\"lef\">".$sql_row['qms_color']."</td>";
			echo "<td>".strtoupper($sql_row['qms_size'])."</td>";
			echo "<td>".$sql_row['qms_qty']."</td>";
			echo "<td>".$remarks.$status123."</td>";
			echo "<td>".$sql_row['ref1']."</td>";
			
			$ims_remarks='';$ims_remarks1='';
			$sql_ims="select order_date from $bai_pro3.bai_orders_db where order_style_no='".$sql_row['qms_style']."' and order_del_no='".$sql_row['qms_schedule']."' and order_col_des='".$sql_row['qms_color']."'";
			$sql_result1=mysqli_query($link, $sql_ims) or exit("Sql Error $sql_ims".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{	
				$ex_factory=$sql_row1['order_date'];
			}
			
			echo "<td>".$ex_factory."</td></tr>";
			
		} 
		echo "</table>
			</div>";
	}else {
		echo "<script>sweetAlert('Oops!','No Data Found','error')</script>";
	}

}
?>

<script language="javascript">
function getTableData(){
	var csv_value=$('#example1').table2CSV({delivery:'value'}); 
	$("#csv_text").val(csv_value);
}
</script>

</div>
</div>
</div>
</div>