<!DOCTYPE html>
<html>
<head>
	<title>Operation Wise Bundle Quantity</title>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />

	<link rel="stylesheet" href="styles/bootstrap.min.css" type="text/css">
	<style>
	.load {
		width: 200px;  
		height: 200px; 
		margin: auto;  
	}
	</style>
	<script>
    	var url1 = '<?= getFullUrl($_GET['r'],'component_wise_bundle_qty.php','N'); ?>';

		function getstyle(){
			document.getElementById('loading').style.display = 'block';
			window.location.href =url1+"&style="+document.test.style.value
		}

		function getschedule(){
			document.getElementById('loading').style.display = 'block';
			window.location.href =url1+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value
		}

		function getcolor(){
			document.getElementById('loading').style.display = 'block';
			window.location.href =url1+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
		}

		function getcut(){
			document.getElementById('loading').style.display = 'block';
			window.location.href =url1+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&cut="+document.test.cut.value
		}

		function myFunction() {
		    window.print();
		}
		
		function load(){
			document.getElementById('loading').style.display = 'block';
		}
	</script> 
</head>
<body>
	<?php 
		// include("dbconf.php");
	    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));


		$style=$_GET['style'];
		$schedule=$_GET['schedule']; 
		$color=$_GET['color'];
		$cut=$_GET['cut'];

	?>
	<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Operation Wise Bundle Quantity</strong></div>
			<div class="panel-body">
				<form method="POST" class="form-inline" name="test" action="#">
					<div class="form-group">
						<label>Style: </label>
						<?php
							echo "<select class='form-control' name=\"style\" onchange=\"getstyle();\" >";

							$sql="SELECT DISTINCT order_style_no FROM $bai_pro3.bai_orders_db_confirm";	
							$sql_result=mysqli_query($link, $sql) or exit("<strong>Problem while getting Style Numbers</strong>/ ".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_result);

							echo "<option value=\"NIL\" selected>Please Select</option>";
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
								{
									echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
								}
								else
								{
									echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
								}

							}
							echo "</select>";
						?>
					</div>
					<div class="form-group">
						<label>Schedule: </label>
						<?php
							echo "<select class='form-control' name=\"schedule\" onchange=\"getschedule();\" >";

							$sql="SELECT DISTINCT order_del_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no='$style'";	
							$sql_result=mysqli_query($link, $sql) or exit("<strong>Problem while getting Schedule Numbers</strong>/ ".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_result);

							echo "<option value=\"NIL\" selected>Please Select</option>";
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
									echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
								}else{
									echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
								}
							}
							echo "</select>";
						?>
					</div>
					<div class="form-group">
						<label>Colour: </label> 
						<?php
							echo "<select class='form-control' name=\"color\" onchange=\"getcolor();\" >";

							$sql="SELECT DISTINCT order_col_des FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no ='$style' AND order_del_no ='$schedule'";
							$sql_result=mysqli_query($link, $sql) or exit("<strong>Problem while getting Colours</strong>/ ".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_result);

							echo "<option value=\"NIL\" selected>Please Select</option>";
								
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)){
									echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
								}else{
									echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
								}
							}
							echo "</select>";
						?>
					</div>
					<div class="form-group">
						<label>Cut No: </label>
						<?php
							echo "<select class='form-control' name=\"cut\" onchange=\"getcut();\" >";

							$sql10="SELECT DISTINCT pcutno FROM $bai_pro3.plandoc_stat_log WHERE order_tid=(SELECT order_tid FROM $bai_pro3.bai_orders_db_confirm WHERE order_style_no ='$style' AND order_del_no ='$schedule' AND order_col_des ='$color')";	
							$sql_result=mysqli_query($link, $sql10) or exit("<strong>Problem while getting Cut Numbers</strong>/ ".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_result);

							echo "<option value=\"NIL\" selected>Please Select</option>";
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['pcutno'])==str_replace(" ","",$cut)){
									echo "<option value=\"".$sql_row['pcutno']."\" selected>".$sql_row['pcutno']."</option>";
								}else{
									echo "<option value=\"".$sql_row['pcutno']."\">".$sql_row['pcutno']."</option>";
								}
							}
							echo "</select>";
						?>
					</div>
					<button type="submit" name="submit" value="submit" onclick="load();" class="btn btn-primary">Submit</button>
				</form>
				

				<?php
					if($_POST['submit'])
					{
						echo "<br>";
						// echo $style;
						// echo $schedule;
						// echo $color;
						// echo $cut;
						if($style and $schedule and $color and $cut)
						{						
							// $sql = "SELECT bundle_number, size_title, original_qty FROM $brandix_bts.`bundle_creation_data` WHERE cut_number = $cut AND  style='$style' AND schedule = '$schedule' AND color = '$color' GROUP BY bundle_number,operation_id,operation_sequence order by id";
							$sql="SELECT DISTINCT bundle_number, size_title, original_qty FROM $brandix_bts.`bundle_creation_data` WHERE cut_number = $cut AND  style='$style' AND schedule = '$schedule' AND color = '$color'";
							$sql_result=mysqli_query($link, $sql) or exit("<strong><font color='red'>Problem while getting Bundle Details</font></strong> ");
							// echo $sql;
							$Data =array();
							$values =array();
							while($sql_row=mysqli_fetch_array($sql_result)){
								$Data['bundle_number'] = $sql_row['bundle_number'];
								$Data['size_title'] = $sql_row['size_title'];
								$Data['original_qty'] = $sql_row['original_qty'];
								// $Data['operation_sequence'] = $sql_row['operation_sequence'];
								array_push($values, $Data);
							}

							// GeT Operation Codes for head
							$operationCodeQuery = "SELECT operation_id FROM $brandix_bts.`bundle_creation_data` WHERE cut_number = $cut AND  style='$style' AND schedule = '$schedule' AND color = '$color' group by operation_id,operation_sequence order by id";
							// echo '<br>'.$operationCodeQuery;
							$OpCodes = mysqli_query( $link, $operationCodeQuery) or exit("<strong><font color='red'>Problem while getting Operation Numbers</font></strong> ".mysqli_error($GLOBALS["___mysqli_ston"]));
							$Data1 = array();
							$OP_code = array();
							while($row = mysqli_fetch_array($OpCodes)){
								$Data1['operation_id'] = $row['operation_id'];
								array_push($OP_code, $Data1);
							}
							
							if(count($values) > 0){

							?>
							<font size="3" color="red">Note: </font><font size="3">'-' indicates Bundle Not Scanned for that Operation</font>
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead>
										<tr class="info">
											<th>Size-Bundle Number</th>
											<th>Bundle Quantity</th>
											<?php
												if(count($OP_code) > 0){
													for($i=0; $i<count($OP_code); $i++){	?>
														<th>Operation ID: <?php echo $OP_code[$i]['operation_id']; ?> </th>
														<?php
													}
												}
											?>
										</tr>
									</thead>
									<tbody>
							<?php
								
									for($z=0;$z<count($values);$z++)
									{	?>
										<tr>
											<td> <?php echo $values[$z]['size_title']."-".$values[$z]['bundle_number']; ?> </td>
											<td> <strong><?php echo $values[$z]['original_qty']; ?></strong> </td>
											<?php
												for ($i=0; $i <count($OP_code) ; $i++)
												{
													$op_Query = "SELECT recevied_qty,scanned_date FROM $brandix_bts.`bundle_creation_data` WHERE bundle_number = '".$values[$z]['bundle_number']."' AND operation_id = '".$OP_code[$i]['operation_id']."' AND  schedule = '$schedule' AND color = '$color' AND style='$style' AND cut_number = $cut";
													// echo '<br>'.$op_Query;
													$op = mysqli_query( $link, $op_Query ) or exit("<strong>Problem while getting Bundle Quantites</strong> ");
													if(mysqli_num_rows($op) > 0)
													{
														while($row2 = mysqli_fetch_array($op))
														{
															if($row2['recevied_qty'] == '0' and $row2['scanned_date']=='')
															{
																$received_qty = '-';
															}else{
																$received_qty = $row2['recevied_qty'];
															}
															echo "<td>".$received_qty."</td>";
															// '*'.$row2['scanned_date'].
														}
													}
													else{
														echo "<td> - </td>";
													}
												}
											?>
										</tr>
										<?php
									}
								}else{
									echo "<strong><font color='red'>No Bundles Found for Cut Number ".$cut."</font></strong>";
								}
							
						}
						else{
							echo "<strong><font color='red'>Please Provide All Details!</font></strong> ";
						}
							?>	
						</tbody>
					</table>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<div id="loading" style="display: none" >
		<center><img src='<?= getFullURLLevel($_GET['r'],'loading.gif',0,'R'); ?>' class="img-responsive" /></center>
	</div>
</body>
</html>