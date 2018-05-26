<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sewing Orders</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<link rel="stylesheet" href="cssjs/bootstrap.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<script>
    
    function reload_style(){
        console.log('welcome');
        var style_id=document.getElementById('style_id').value;
        $('#show').hide();
        window.location.href ="sewing_orders_view.php?style_id="+style_id
    }
	function reload_schedule(){
        var schedule_num=document.getElementById('schedule_id').value;
		var style_id=document.getElementById('style_id').value;
        $('#show').hide();
        window.location.href ="sewing_orders_view.php?style_id="+style_id+"&schedule_id="+schedule_num
    }
	function reload_color(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
        $('#show').hide();
        window.location.href ="sewing_orders_view.php?style_id="+style_id+"&schedule_id="+schedule_num+"&color_id="+color_num
    }
	function check_uncheck_checkbox(isChecked) {
		if(isChecked) {
			$('input[class="cb_element"]').each(function() { 
				this.checked = true; 
			});
		} else {
			$('input[class="cb_element"]').each(function() {
				this.checked = false;
			});
		}
	}
</script> 
<body>
<?php
		include("dbconf.php");
		/*getting style codes*/
		$style_codes="SELECT DISTINCT trim(order_style_no) as order_style_no FROM bai_pro3.bai_orders_db_confirm";
		$style_result=mysqli_query($link,$style_codes);
		
		$style=$_GET['style_id'];
		$schedule=$_GET['schedule_id'];
		$color=$_GET['color_id'];
				
		/*getting schedule codes*/
		if($style!=''){
			$schedule_codes="select distinct trim(order_del_no) as order_del_no from bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style'";
		}
		$schedule_result=mysqli_query($link,$schedule_codes);
		
		/*getting color codes*/
		if(($style != '')&&($schedule != '')){
			$color_codes="select distinct trim(order_col_des) as order_col_des from bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule'";
		}
		$color_result=mysqli_query($link,$color_codes);	
			
		
	?>
	<div class="container-fluid">			
		<div class="panel panel-primary"> 
			<div class="panel-heading"><strong>Assign Module Here:</strong></div>
			<div class="panel-body">
			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="form-group col-md-2">
				Style  :
				<?php
					echo '<select class="form-control selectpicker" id="style_id" name="style_id" onchange="reload_style();" data-live-search="true" required>
					<option value="">Please Select</option>';
					if(mysqli_num_rows($style_result)>0){
						while($styles = mysqli_fetch_array($style_result)) {
							$style_number=$styles['order_style_no'];
							if(trim($style_number)==$_GET['style_id']){
							   echo "<option value=".$style_number." selected>".$style_number."</option>";
							}else{
								echo "<option value=".$style_number.">".$style_number."</option>";
							}
						}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				   
				?>
			</div>
			<div class="form-group col-md-2">
				Schedule :
				<?php
					echo '<select class="form-control selectpicker" id="schedule_id" name="schedule_id" onchange="reload_schedule();" data-live-search="true" required>
					      <option value="">Please Select</option>';
					if(mysqli_num_rows($schedule_result)>0){
						while($styles = mysqli_fetch_array($schedule_result)) {
							$schedule_number=$styles['order_del_no'];
							if(trim($schedule_number)==$_GET['schedule_id']){
							   echo "<option value=".$schedule_number." selected>".$schedule_number."</option>";
							}else{
								echo "<option value=".$schedule_number.">".$schedule_number."</option>";
							}
						}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group col-md-2">
				Color  : 
				<?php
					echo '<select class="form-control selectpicker" id="color_id" name="color_id" onchange="reload_color();" data-live-search="true" required>
					      <option value="">Please Select</option>';
					if(mysqli_num_rows($color_result)>0){
						while($colors = mysqli_fetch_array($color_result)) {
							$color_number=$colors['order_col_des'];
							if(trim($color_number)==$_GET['color_id']){
							   echo "<option value='".$color_number."' selected>".$color_number."</option>";
							}else{
								echo "<option value='".$color_number."'>".$color_number."</option>";
							}
						}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group col-md-2">
				<br/>
				<button type="submit" id="view" name="view"  class="btn btn-primary" >View</button>
			</div>
		</form>
	</div>
	<?php
		// echo $_POST['view'];
		if(isset($_POST['view']))
		{	
			echo '<form class="form-inline" action="sewing_orders_view.php" method="POST">';
			$style=$_GET['style_id'];
			$schedule=$_GET['schedule'];
			$color=$_GET['color'];
			echo "<input type='hidden' name='style_post_id' value=$style>";
			echo "<input type='hidden' name='schedule_post_id' value=$schedule>";
			echo "<input type='hidden' name='color_post_id' value=$color>";
			
			
			$bundles_query="select   b.id, b.date_time,  ref.operation_code, ref.operation_description, ref.operation_name, b.cut_number,  b.style,  b.schedule,  b.color,  b.size_id, b.size_title, GROUP_CONCAT(b.bundle_number) as bundle_num ,b.original_qty  ,sum(b.send_qty) as send_qty  ,b.recevied_qty  ,b.missing_qty  ,b.rejected_qty  ,b.left_over  ,b.operation_id  ,b.operation_sequence  ,b.ops_dependency  ,b.docket_number  ,b.bundle_status  ,b.split_status  ,b.sewing_order_status  ,b.is_sewing_order  ,b.sewing_order  ,b.assigned_module  ,b.remarks  from brandix_bts.bundle_creation_data as b left join brandix_bts.tbl_orders_ops_ref as ref ON b.operation_id = ref.operation_code where b.sewing_order>0  and trim(style)='".$style."'";
			// echo $bundles_query;
			if($schedule!=''){
				$bundles_query.=" and trim(schedule)='".$schedule."'";
			}
			if($color!=''){
				$bundles_query.=" and trim(color)='".$color."'";
			}	
				$bundles_query.=" AND is_sewing_order = 'Yes' GROUP BY cut_number,operation_id";
				
			$bundles_qry_result=mysqli_query($link,$bundles_query);
			if(mysqli_num_rows($bundles_qry_result)>0){
				$sno++;
				echo "<table class='table table-striped header-fixed'>";
				echo "<thead class='thead-inverse'><tr class='table-active'><th>S.NO</th><th>Style</th><th>Schedule</th><th>Color</th><th>Cut Number</th><th>Size</th><th>Quantity</th><th>Bundle Number</th>";
				echo "<th>Op Name</th><th>Sewing Order Name</th><th><div id='divCheckAll'><input type='checkbox' name='checkall' id='checkall' onClick='check_uncheck_checkbox(this.checked);' />Check All</div></th></tr></thead>";
				while($result = mysqli_fetch_array($bundles_qry_result)) {
				$bundle_number=$result['bundle_num'];
				$operation_code=$result['operation_code'];
				$assigned_module=$result['assigned_module'];
				echo "<tr><td>".$sno++."</td><td>".$result['style']."</td><td>".$result['schedule']."</td><td>".$result['color']."</td><td>".$result['cut_number']."</td><td>".$result['size_title']."</td><td>".$result['send_qty']."</td><td>".$result['bundle_num']."</td><td>".$result['operation_code']."-".$result['operation_name']."</td><td>".$result['operation_description']."-".str_pad($result['sewing_order'],3,'0',STR_PAD_LEFT)."</td>";
				if($assigned_module=='0'){
				echo"<td><input type='checkbox' class='cb_element' name='bundles_list[]' id='bundles_list[$bundle_number]' value='".$bundle_number."-".$operation_code."'></td>";}else{
					echo"<td>Module -<b>".$assigned_module."</b> Assigned</td>";
				}
				echo"</tr>";
				}
				echo "</table>";
				
				echo "<div style='float:right'>";
					$get_modules_qry="SELECT sec_id,sec_head,sec_mods FROM bai_pro3.sections_db WHERE sec_id>0";
					$modules_qry_result=mysqli_query($link,$get_modules_qry);
					if(mysqli_num_rows($modules_qry_result)>0){
						echo '<select class="form-control selectpicker" id="module_id" name="module_id" required>';
						echo '<option value="">Please Select</option>';
						while($modules=mysqli_fetch_array($modules_qry_result)){
							$modules_list = explode(",", $modules['sec_mods']);
							foreach($modules_list as $module) {
								echo "<option value='".$module."'>" . $module . "</option>";
							}
						}
						echo '</select>';
					}
					echo '<button type="submit" class="btn btn-primary">Update Module</button>';
				echo "</div>";
				echo"</form>";
			}else{
				echo "<div class='alert alert-warning'><center>Sorry.. <strong>No Bundles</strong> Found in your selection</center></div>";
			}
		}
		
		if(isset($_POST['style_post_id']) && isset($_POST['schedule_post_id'])&& isset($_POST['color_post_id'])){
			if(isset($_POST['bundles_list']) && isset($_POST['module_id'])){
				$bundles_list=$_POST['bundles_list'];
				$module_id=$_POST['module_id'];
				$style=$_POST['style_post_id'];
				$schedule=$_POST['schedule_post_id'];
				$color=$_POST['color_post_id'];
				for($j = 0; $j < count($bundles_list); $j++)
				{
					//$bundle_number=$bundles_list[$j];
					$Data_Array=explode("-", $bundles_list[$j]);
					$bundle_number=$Data_Array[0];
					$operation_id=$Data_Array[1];
					// echo "Bundle Number : ".$bundle_number."</br>";
					// echo "Operation Number: ".$operation_id."</br>";
					// echo "Module Id : ".$module_id."</br>";
					
					/*Update Module here*/
					$sewing_update_qry="update brandix_bts.bundle_creation_data set assigned_module=$module_id where bundle_number in (".$bundle_number.") and operation_id=$operation_id";
					
					// echo "Update qry :".$sewing_update_qry."</br>";
					mysqli_query($link,$sewing_update_qry);
				}
					echo "<div class='alert alert-success'><center>Modules Allocated Successfully</center></div>";
					// echo"<script>alert('Modules Allocated Successfully..!');</script>";
					// header('Location: sewing_orders_view.php?style_id='.$style.'&schedule='.$schedule.'&color='.$color.'&view=View');
			}else{
				// echo "<script>alert('Please Select Min. One sewing order');</script>";
				echo "<div class='alert alert-warning'><center>Please... Select Minimum<strong> One Sewing Order</strong> For Assigning Module</center></div>";
			}
		}
	?>
</body>
</html>