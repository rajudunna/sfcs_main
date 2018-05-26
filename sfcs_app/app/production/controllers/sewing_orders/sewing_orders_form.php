<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sewing Orders</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<link rel="stylesheet" href="cssjs/bootstrap.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
		.load {
			width: 200px;  
			height: 200px; 
			margin: auto;  
		}
	</style>
</head>
<script>
    
    function reload_style(){
	document.getElementById('loading').style.display = 'block';
        console.log('welcome');
        var style_id=document.getElementById('style_id').value;
        window.location.href ="sewing_orders_form.php?style_id="+style_id
    }
	function reload_schedule(){
	document.getElementById('loading').style.display = 'block';
        var schedule_num=document.getElementById('schedule_id').value;
		var style_id=document.getElementById('style_id').value;
        window.location.href ="sewing_orders_form.php?style_id="+style_id+"&schedule="+schedule_num
    }
	function reload_color(){
	document.getElementById('loading').style.display = 'block';
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		//alert(color_num);
        window.location.href ="sewing_orders_form.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num
    }
	function reload_cut(){
	document.getElementById('loading').style.display = 'block';
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
		//console.log(cut_num);
        window.location.href ="sewing_orders_form.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num+"&cut_id="+cut_num
    }
	function sewing_orders(){
	document.getElementById('loading').style.display = 'block';
		var style_id=document.getElementById('style_id').value;
        var schedule_num=document.getElementById('schedule_id').value;
		var color_num=document.getElementById('color_id').value;
		var cut_num=document.getElementById('cut_id').value;
		var operation_code=document.getElementById('operation_code').value;
        window.location.href ="sewing_orders_form.php?style_id="+style_id+"&schedule="+schedule_num+"&color="+color_num+"&cut_id="+cut_num+"&operation_code="+operation_code
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
	function load(){
		document.getElementById('loading').style.display = 'block';
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
			
			// $ops_codes_query="SELECT operation_code,operation_name FROM brandix_bts.tbl_orders_ops_ref WHERE operation_code IN(SELECT DISTINCT ops_dependency FROM brandix_bts.tbl_style_ops_master WHERE TRIM(style)='$style' AND color='$color' AND ops_dependency<>'0' AND ops_dependency<>'NULL') and type like '%Panel%'";
			
			$ops_codes_query = "SELECT opsm.ops_dependency,opsm.component,opsrf.operation_code,opsrf.operation_name FROM brandix_bts.tbl_style_ops_master opsm LEFT JOIN brandix_bts.tbl_orders_ops_ref opsrf ON opsrf.operation_code=opsm.ops_dependency WHERE TRIM(opsm.style)='$style' AND opsm.color='$color' AND ops_dependency<>0 AND TYPE LIKE '%Panel%' GROUP BY ops_dependency";
			
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

	<div class="container-fluid">			
		<div class="panel panel-primary"> 
			<div class="panel-heading"><strong>Generate Sewing orders Here:</strong></div>
			<div class="panel-body">
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="GET">
					<div class="form-group col-md-2">
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
					<div class="form-group col-md-2">
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
					<div class="form-group col-md-3">
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
					<div class="form-group col-md-2">
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
								echo "No Cut no's Found";
							}
							echo "</select>";
						?>
					</div>
					<div class="form-group col-md-2">
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
<?php
	if(isset($_GET['style_id']) && isset($_GET['schedule']) && isset($_GET['color'])&&isset($_GET['cut_id'])&&isset($_GET['operation_code'])){
		$style=$_GET['style_id'];
		$schedule=$_GET['schedule'];
		$color=$_GET['color'];
		$cut_num=$_GET['cut_id'];
		$operation_code=$_GET['operation_code'];
		//echo $color;
		//get modules list
		// $get_modules_qry="SELECT sec_id,sec_head,sec_mods FROM bai_pro3.sections_db WHERE sec_id>0";
		// $modules_qry_result=mysqli_query($link,$get_modules_qry);
		
		/* echo "<script>document.getElementById('style_id').value=".$style."</script>";
		echo "<script>document.getElementById('schedule_id').value=".$schedule."</script>";
		*/
		//echo '<form class="form-inline" action='. $_SERVER["PHP_SELF"].' method="POST">';
		echo '<form class="form-horizantal" action="sewing_orders_process.php" method="POST">';
		// if(mysqli_num_rows($modules_qry_result)>0){		
			// echo '<div class="form-group col-md-1">Module:<select class="form-control" name="module_name" id="module_name" required>';
			// echo '<option value="">Please Select</option>';
			// while($modules=mysqli_fetch_array($modules_qry_result)){
				// $modules_list = explode(",", $modules['sec_mods']);
				// foreach($modules_list as $module) {
					// echo "<option value='".$module."'>" . $module . "</option>";
				// }
			// }
			// echo '</select></div>';
		// }
		echo '<button type="submit" onclick="load();" class="btn btn-primary pull-right">Save</button>';
		echo "<input type='hidden' name='style' value=$style>";
		echo "<input type='hidden' name='schedule' value=$schedule>";
		echo "<input type='hidden' name='color' value='".$_GET["color"]."'>";
		echo "<input type='hidden' name='cut_num' value=$cut_num>";
		echo "<input type='hidden' name='operation_code' value=$operation_code>";
		
		$available_bundles_qry= 'SELECT bundle_number,GROUP_CONCAT(operation_sequence) AS operation_sequence,GROUP_CONCAT(operation_id ORDER BY operation_id) AS operation_id,GROUP_CONCAT(recevied_qty ORDER BY operation_id) AS operation_qty,size_title FROM brandix_bts.bundle_creation_data WHERE TRIM(style)="'.$style.'" AND TRIM(SCHEDULE)="'.$schedule.'" AND TRIM(color)="'.$color.'" AND cut_number="'.$cut_num.'" AND ops_dependency="'.$operation_code.'" AND sewing_order_status="No" GROUP BY bundle_number';
		
		$available_bundles=mysqli_query($link,$available_bundles_qry);
		if(mysqli_num_rows($available_bundles)>0){
			$sno=0;
			//$operations_list=array();
			echo "<table class='table table-striped header-fixed'>";
			echo "<thead class='thead-inverse'><tr class='table-active'>";
			echo "<tr><th>Bundle Number</th><th>Size</th>";
			while($bundles_result = mysqli_fetch_array($available_bundles)){
				$display='';
				$bundle_quantity=explode(',',$bundles_result['operation_qty']);
				$available_qty=array();
				if($sno==0){
					$opcodes=explode(',',$bundles_result['operation_id']);
					$result = array_has_dupes($opcodes);
					$opseq=explode(',',$bundles_result['operation_sequence']);
					if($result == 1){
						foreach($opcodes as $op_codes)
						{
							foreach($opseq as $opseq)
							{	
								$comp_query= 'SELECT component FROM tbl_style_ops_master WHERE operation_code='.$op_codes.' AND style="'.$style.'" AND color="'.$color.'" AND ops_sequence ='.$opseq;	
								$comp_res=mysqli_query($link,$comp_query);	
								$comp_row = mysqli_fetch_row($comp_res);
								if($comp_row>0){
									echo "<th>".$op_codes."(".$comp_row[0].")"."</th>";
									$operations_list.=$op_codes.",";
								}
							}
						}						
						
					}else{
						foreach($opseq as $opseq)
						{	
							foreach($opcodes as $op_codes)
							{							
								$comp_query= 'SELECT component FROM tbl_style_ops_master WHERE operation_code='.$op_codes.' AND style="'.$style.'" AND color="'.$color.'" AND ops_sequence ='.$opseq;
								$comp_res=mysqli_query($link,$comp_query);	
								$comp_row = mysqli_fetch_row($comp_res);
								if($comp_row>0){
									echo "<th>".$op_codes."(".$comp_row[0].")"."</th>";
									$operations_list.=$op_codes.",";
								}
							}
						}						
					}
					
					$sno++;
					$operations_list=rtrim($operations_list,",");
					echo "<th>Available Quantity</th><th><div id='divCheckAll'><input type='checkbox' name='checkall' id='checkall' onClick='check_uncheck_checkbox(this.checked);' />Check All</div></th></tr>";
				}
				$display.= "<tr><td>".$bundles_result['bundle_number']."</td>";
				$display.= "<td>".$bundles_result['size_title']."</td>";
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
			//check whether dependent operations existed or not
			// $dependent_ops_qry='select count(*) from FROM brandix_bts.tbl_style_ops_master WHERE TRIM(style)="'.$style.'" and trim(color)="'.$color.'" and ops_dependency>0';
			// echo $dependent_ops_qry;
			echo "Sorry no bundles available";
		}
		echo "<input type='hidden' name='operation_ids' value=".$operations_list.">";
		echo "</form>";
	}
	
	function array_has_dupes($array) {
	   return count($array) !== count(array_unique($array));
	}
	
?>			
			</div>
		</div>
		<div id="loading" style="display: none" >
			<center><img src="loading.gif" alt="Loading..." class='load'/></center>
		</div>
	</div>	
</body>
</html>
