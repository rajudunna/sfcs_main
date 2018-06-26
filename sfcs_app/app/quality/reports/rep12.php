
<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));



$view_access=user_acl("SFCS_0296",$username,1,$group_id_sfcs);
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
	<div class="panel-heading">Surplus Room Stock Report</div>
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

if(isset($_POST['filter'])){
	
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];

	$sql="SELECT * FROM bai_qms_db LEFT JOIN $bai_pro3.bai_qms_location_db ON location_id=qms_location_id WHERE qms_location_id IS NOT NULL";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($sql_result) > 0){
		echo "<div class='col-sm-12'>";
		echo '<form action='.getFullURL($_GET['r'],'export_excel.php','R').' method ="post" > 
				<input type="hidden" name="csv_text" id="csv_text">
				<input type="submit" class="btn btn-warning" value="Export to Excel" onclick="getCSVData()">
			  </form>';
		echo "</div>";	  

		echo "<div class='col-sm-12' style='max-height : 600px;overflow:scroll;'>";
		echo "<table id=\"example1\" class=\"table table-bordered\">";
		echo "<tr>
				<th>Style</th>
				<th>Schedule</th>
				<th>Color</th>
				<th>Size</th>
				<th>Qty</th>
				<th>Carton No</th>
				<th>Ex Factory Date</th>
				</tr>";
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				
			echo "<tr>";
			
			echo "<td>".$sql_row['qms_style']."</td>";
			echo "<td>".$sql_row['qms_schedule']."</td>";
			echo "<td class=\"lef\">".$sql_row['qms_color']."</td>";
			$size = '';
			$size = ims_sizes('',$sql_row['qms_schedule'],$sql_row['qms_style'],$sql_row['qms_color'],$sql_row['qms_size'],$link);
			echo "<td>".strtoupper($size)."</td>";
			echo "<td>".$sql_row['qms_qty']."</td>";
			echo "<td>".$sql_row['location_id']."</td>";

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

<script type="text/javascript">
function getCSVData(){
 	var csv_value=$('#example1').table2CSV({delivery:'value'});
 	$("#csv_text").val(csv_value);	
}
</script>



</div>
</div>
</div>
</div>