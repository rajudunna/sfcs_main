<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sewing Orders</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<script>
    
    function reload_style(){
        console.log('welcome');
        var style_id=document.getElementById('style_id').value;
        window.location.href ="sewing_orders_form12.php?style_id="+style_id
    }
	function reload_schedule(){
        var schedule_num=document.getElementById('schedule_id').value;
		var style_id=document.getElementById('style_id').value;
        window.location.href ="sewing_orders_form12.php?style_id="+style_id+"&schedule="+schedule_num
    }
	function reload_color(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
        window.location.href ="sewing_orders_form12.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num
    }
	function reload_cut(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
		//console.log(cut_num);
        window.location.href ="sewing_orders_form12.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num+"&cut_id="+cut_num
    }
	function sewing_orders(){
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
		var operation_code=document.getElementById('operation_code').value;
        window.location.href ="sewing_orders_form12.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num+"&cut_id="+cut_num+"&operation_code="+operation_code
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
		//include("generate_bundles.php");
		/*getting style codes*/
		$style_codes="SELECT DISTINCT trim(order_style_no) as order_style_no FROM bai_pro3.bai_orders_db_confirm";
		$style_result=mysqli_query($link,$style_codes);
		//echo "Style rows :".mysqli_num_rows($style_result)."</br>";
		
		$style=$_GET['style_id'];
		//echo "style : ".$style."</br>";
		$schedule=$_GET['schedule'];
		//echo "schedule : ".$schedule."</br>";
		$color=$_GET['color'];
		//echo "color : ".$color."</br>";
		$cut_num=$_GET['cut_id'];
		/*getting schedule codes*/
		if($style!=''){
			$schedule_codes="select distinct trim(order_del_no) as order_del_no from bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style'";
		}else{
			$schedule_codes="select distinct trim(order_del_no) as order_del_no from bai_pro3.bai_orders_db_confirm";
		}
		$schedule_result=mysqli_query($link,$schedule_codes);
		//echo "Schedule rows :".mysqli_num_rows($schedule_result)."</br>";
		
		/*getting color codes*/
		if(($style != '')&&($schedule != '')){
			$color_codes="select distinct trim(order_col_des) as order_col_des from bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule'";
		}else{
			$color_codes="select distinct trim(order_col_des) as order_col_des from bai_pro3.bai_orders_db_confirm";
		}
		//echo "Color Qry :".$color_codes."</br>";
		$color_result=mysqli_query($link,$color_codes);
		//echo "Color rows :".mysqli_num_rows($color_result)."</br>";
		
		/*getting cut no's */
		if(($style != '')&&($schedule != '')&&($color != '')){
			
			//$ordertid_qry="select distinct trim(order_tid) as order_tid from bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule' and trim(order_col_des)='$color'";
			
			$pcutno_qry="SELECT distinct TRIM(pcutno) as pcutno FROM bai_pro3.plandoc_stat_log WHERE order_tid=(SELECT order_tid FROM bai_pro3.bai_orders_db_confirm WHERE TRIM(order_style_no)='$style' AND TRIM(order_del_no)='$schedule' AND TRIM(order_col_des)='$color')";
		}
		$pcutno_result=mysqli_query($link,$pcutno_qry);
		/*getting Operation codes */
		if(($style != '')&&($schedule != '')&&($color != '')&&($cut_num != '')){
			
			//$ordertid_qry="select distinct trim(order_tid) as order_tid from bai_pro3.bai_orders_db_confirm where trim(order_style_no)='$style' and trim(order_del_no)='$schedule' and trim(order_col_des)='$color'";
			
			$ops_codes_query="SELECT operation_code,operation_name FROM brandix_bts.tbl_orders_ops_ref WHERE operation_code IN(SELECT DISTINCT ops_dependency FROM brandix_bts.tbl_style_ops_master WHERE TRIM(style)='$style' AND color='$color' AND ops_dependency<>'0' AND ops_dependency<>'NULL')";
		}
		//echo $ops_codes_query."</br>";
		$ops_code_result=mysqli_query($link,$ops_codes_query);
		// echo "pcutno_qry :".$pcutno_qry."</br>";
		
		//echo "cut result rows :".mysqli_num_rows($pcutno_result)."</br>";
		//$pcutno_result_row = mysqli_fetch_assoc($pcutno_result);
		//echo "Order tid : ".$ordertid_row['order_tid']."</br>";
		
		/*getting all parameters through docket no*/
		if(isset($_GET['docket_no'])){
			
			$docket_num=$_GET['docket_no'];
			echo "Getting Docket : ".$docket_num;
			
			/*Getting parameters through plandoc statlog*/
			$plandocstat_qry="SELECT TRIM(bai_orders_db_confirm.order_style_no) AS order_style_no,TRIM(bai_orders_db_confirm.order_del_no) AS order_del_no,TRIM(bai_orders_db_confirm.order_col_des) as order_col_des,TRIM(plandoc_stat_log.pcutno) AS pcutno FROM bai_pro3.bai_orders_db_confirm LEFT JOIN bai_pro3.plandoc_stat_log ON TRIM(bai_orders_db_confirm.order_tid)=TRIM(plandoc_stat_log.order_tid) WHERE TRIM(plandoc_stat_log.doc_no)=$docket_num";
			echo "Plandoc qry : ".$plandocstat_qry."</br>";
			$plandocstat_result=mysqli_query($link,$plandocstat_qry);
			echo "Docket rows :".mysqli_num_rows($plandocstat_result)."</br>";
			//$pcutno_result_row = mysqli_fetch_assoc($pcutno_result);
			if (mysqli_num_rows($plandocstat_result)>0){
			  while($styles = mysqli_fetch_array($plandocstat_result)) {
				 echo  "bdsjdshj".$styles->order_style_no;
				 
			  }
			}
		}
	   
	?>
	<div class="bs-example">
	<h3> Generate Sewing orders Here : </h3>
	</div>

	<div class="bs-example">
		<form class="form-inline" action="<?php $_SERVER['PHP_SELF']; ?>" method="GET">
			<div class="form-group">
				Style  :
				<?php
					echo '<select class="form-control selectpicker" id="style_id" name="style_id" onchange="reload_style();" data-live-search="true">
					<option value="">Please Select</option>';
					if(mysqli_num_rows($style_result)>0){
						while($styles = mysqli_fetch_array($style_result)) {
							$style_number=$styles['order_style_no'];
						   // $style_id=$style_number;
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
			<div class="form-group">
				Schedule :
				<?php
					echo '<select class="form-control selectpicker" id="schedule_id" name="schedule_id" onchange="reload_schedule();" data-live-search="true">
					      <option value="">Please Select</option>';
					if(mysqli_num_rows($schedule_result)>0){
						while($styles = mysqli_fetch_array($schedule_result)) {
							$schedule_number=$styles['order_del_no'];
						   // $style_id=$style_number;
							if(trim($schedule_number)==$_GET['schedule']){
							   echo "<option value=".$schedule_number." selected>".$schedule_number."</option>";
							}else{
								echo "<option value=".$schedule_number.">".$schedule_number."</option>";
							}
						}
						if(isset($_GET['schedule'])){
									$redirect_check1=1;
								}else{
									$redirect_check1=0;
								}
							if(mysqli_num_rows($schedule_result)==1 && $redirect_check1==0){
								echo "<script>reload_schedule();</script>";
							}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group">
				Color  : 
				<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
				<?php
					echo '<select class="form-control selectpicker" id="color_id" name="color_id" onchange="reload_color();" data-live-search="true">
					      <option value="">Please Select</option>';
					if(mysqli_num_rows($color_result)>0){
						while($colors = mysqli_fetch_array($color_result)) {
							$color_number=$colors['order_col_des'];
						   // $style_id=$style_number;
							if(trim($color_number)==$_GET['color']){
							   echo "<option value='".$color_number."' selected>".$color_number."</option>";
							}else{
								echo "<option value='".$color_number."'>".$color_number."</option>";
							}
						}
						if(isset($_GET['color'])){
								$redirect_check=1;
							}else{
								$redirect_check=0;
							}
						if(mysqli_num_rows($color_result)==1 && $redirect_check==0){
							echo "<script>reload_color();</script>";
						}
					}else{
						echo "No Styles Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group">
				Cut No's  : 
				<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
				<?php
					echo '<select class="form-control selectpicker" id="cut_id" name="cut_id" onchange="reload_cut();" data-live-search="true">
					<option value="">Please Select</option>';
					if(mysqli_num_rows($pcutno_result)>0){
						while($colors = mysqli_fetch_array($pcutno_result)) {
							$cut_number=$colors['pcutno'];
						   // $style_id=$style_number;
							if(trim($cut_number)==$_GET['cut_id']){
							   echo "<option value=".$cut_number." selected>".$cut_number."</option>";
							}else{
								echo "<option value=".$cut_number.">".$cut_number."</option>";
							}
						}
					}else{
						echo "No Cut numbers Found";
					}
					echo "</select>";
				?>
			</div>
			<div class="form-group">
				Sewing Order  : 
				<!--<input type="text" class="form-control" id="color_id" name="color_id" required>-->
				<?php
					echo '<select class="form-control selectpicker" id="operation_code" name="operation_code" onchange="sewing_orders();" data-live-search="true">
					<option value="">Please Select</option>';
					if(mysqli_num_rows($ops_code_result)>0){
						while($ops_codes = mysqli_fetch_array($ops_code_result)) {
							$op_code=$ops_codes['operation_code'];
							$op_desc=$ops_codes['operation_name'];
							$opname=$op_code."--".$op_desc;
						   // $style_id=$style_number;
							if(trim($op_code)==$_GET['operation_code']){
							   echo "<option value=".$op_code." selected>".$opname."</option>";
							}else{
								echo "<option value=".$op_code.">".$opname."</option>";
							}
						}
					}else{
						echo "No operation codes Found";
					}
					echo "</select>";
				?>
			</div>
			<!--<button type="submit" class="btn btn-primary">Submit</button>-->
		</form>
		<br>
	</div>
	<?php
		if(isset($_GET['style_id']) && isset($_GET['schedule']) && isset($_GET['color'])&&isset($_GET['cut_id'])&&isset($_GET['operation_code'])){
			$style=$_GET['style_id'];
			$schedule=$_GET['schedule'];
			$color=$_GET['color'];
			$cut_num=$_GET['cut_id'];
			$operation_code=$_GET['operation_code'];
			//get modules list
			$get_modules_qry="SELECT sec_id,sec_head,sec_mods FROM bai_pro3.sections_db WHERE sec_id>0";
			$modules_qry_result=mysqli_query($link,$get_modules_qry);
			
			/* echo "<script>document.getElementById('style_id').value=".$style."</script>";
			echo "<script>document.getElementById('schedule_id').value=".$schedule."</script>";
			*/
			//echo '<form class="form-inline" action='. $_SERVER["PHP_SELF"].' method="POST">';
			echo '<form class="form-inline" action="sewing_orders_process.php" method="POST">';
			// if(mysqli_num_rows($modules_qry_result)>0){
				// echo '<select name="module_name" id="module_name" required>';
				// echo '<option value="">Please Select</option>';
				// while($modules=mysqli_fetch_array($modules_qry_result)){
					// $modules_list = explode(",", $modules['sec_mods']);
					// foreach($modules_list as $module) {
						// echo "<option value='".$module."'>" . $module . "</option>";
					// }
				// }
				// echo '</select>';
			// }
			echo '<button type="submit" class="btn btn-primary">Save</button>';
			echo "<input type='hidden' name='style' value=$style>";
			echo "<input type='hidden' name='schedule' value=$schedule>";
			echo "<input type='hidden' name='color' value=$color>";
			echo "<input type='hidden' name='cut_num' value=$cut_num>";
			echo "<input type='hidden' name='operation_code' value=$operation_code>";
			$available_bundles_qry= 'SELECT bundle_number,GROUP_CONCAT(operation_id ORDER BY operation_id) AS operation_id,GROUP_CONCAT(recevied_qty ORDER BY operation_id) AS operation_qty FROM brandix_bts.bundle_creation_data WHERE TRIM(style)="'.$style.'" AND TRIM(SCHEDULE)="'.$schedule.'" AND TRIM(color)="'.$color.'" AND cut_number="'.$cut_num.'" AND ops_dependency="'.$operation_code.'" AND sewing_order_status="No" GROUP BY bundle_number';
			//echo $available_bundles_qry;
			$available_bundles=mysqli_query($link,$available_bundles_qry);
			if(mysqli_num_rows($available_bundles)>0){
				$sno=0;
				//$operations_list=array();
				echo "<table class='table table-striped header-fixed'>";
				echo "<thead class='thead-inverse'><tr class='table-active'>";
				echo "<tr><th>S.No</th><th>Bundle Number</th>";
				while($bundles_result = mysqli_fetch_array($available_bundles)){
					$display='';
					$bundle_quantity=explode(',',$bundles_result['operation_qty']);
					$available_qty=array();
					if($sno==0){
						$opcodes=explode(',',$bundles_result['operation_id']);
						foreach($opcodes as $op_codes)
						{
							echo "<th>".$op_codes. "</th>";
							$operations_list.=$op_codes.",";
						}
						$operations_list=rtrim($operations_list,",");
						echo "<th>Available Quantity</th><th><div id='divCheckAll'><input type='checkbox' name='checkall' id='checkall' onClick='check_uncheck_checkbox(this.checked);' />Check All</div></th></tr>";
					}
					$display.= "<tr><td>".$sno++."</td><td>".$bundles_result['bundle_number']."</td>";
					foreach($bundle_quantity as $bundle_qty)
					{
						$display.= "<td>".$bundle_qty. "</td>";
						$available_qty[]=$bundle_qty;
						
					}
					$display.= "<td>".min($available_qty)."</td>";
					$bundle_number=$bundles_result['bundle_number'];
					$display.= '<td><input type="checkbox" class="cb_element" name="bundles_list[]" id="bundles_list[$bundle_number]" value="'.$bundle_number.'"></td>';
					$display.= "</tr>";
						
					if (!in_array("0", $available_qty)) {
						echo $display;
						//$sno++;
					}
					
				}
				echo "</table>";
			}else{
				echo "No Bundles found";
			}
			echo "<input type='hidden' name='operation_ids' value=".$operations_list.">";
			echo "</form>";
		}
		
	?>

	
</body>
</html>
