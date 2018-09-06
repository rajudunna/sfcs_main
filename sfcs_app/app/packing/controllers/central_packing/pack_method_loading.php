<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'pack_method_loading.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
	}

</script>
</head>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
	
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Pack Method Loading</b></div>
	<div class="panel-body">
	<?php
	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
	    $schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
				echo "<form name=\"mini_order_report\" action=\"#\" method=\"post\" >";
				echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
						$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Style</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
						echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
					?>

					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
						$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					&nbsp;&nbsp;
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit" style="margin-top: 18px;">
					</div>
				</form>
		<div class="col-md-12">
			<?php
			if(isset($_POST['submit']))
			{	
				if($_POST['style'] and $_POST['schedule'])
				{
					$style=$_POST['style'];
				$schedule=$_POST['schedule'];
				// echo $_POST['style']."----". $_POST['schedule'];
				$pack_meth_qry="SELECT p.ref_order_num,p.style_code,SUM(s.color) AS color,SUM(s.size_title) AS size ,s.seq_no,s.pack_method,s.pack_description FROM $bai_pro3.tbl_pack_ref AS p LEFT JOIN $bai_pro3.tbl_pack_size_ref AS s ON p.id=s.parent_id WHERE p.ref_order_num=$schedule AND p.style_code='".$style."' ORDER BY s.pack_method";
				// echo $pack_meth_qry;
				// $sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr>
									<th>S.No</th>
									<th>Packing Method</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>No Of Colors</th>
									<th>No Of Sizes</th>
									<th>Controlls</th></tr>";
								while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									$pack_qnty_qry="SELECT p.id,(SUM(s.garments_per_carton)*(s.cartons_per_pack_job*s.pack_job_per_pack_method)) AS quantity FROM $bai_pro3.tbl_pack_ref AS p LEFT JOIN $bai_pro3.tbl_pack_size_ref AS s ON p.id=s.parent_id WHERE p.ref_order_num=$schedule AND s.pack_method='$pack_result1[pack_method]'  LIMIT 0,1 ";
									// echo $pack_qnty_qry;
									$pack_qnty_qry_res=mysqli_query($link, $pack_qnty_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
									if($res=mysqli_fetch_array($pack_qnty_qry_res)){
										$qnty=$res['quantity'];
									}
									$seq_no=$pack_result1['seq_no'];
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><td>".$pack_result1['seq_no']."</td>";
									echo"<td>".$pack_result1['pack_method']."</td>";
									echo "<td>".$pack_result1['pack_description']."</td>";
									echo "<td>".$qnty."</td>";
									echo "<td>".$pack_result1['color']."</td>";
									echo "<td>".$pack_result1['size']."</td>";

									$url=getFullURL($_GET['r'],'pack_generation.php','R');
									echo "<td><a href='$url?schedule=$schedule&style=$style&seq_no=$seq_no' target='_blank'>Generate Sewing Job</td>";
									echo "<tr>";
									
								}	
							
							echo "</table></div>";
							$url=getFullURL($_GET['r'],'.php','R');
							echo "<div class='col-md-3 col-sm-3 col-xs-12'>
							<a class='btn btn-success btn-sm' href='$url?schedule=$schedule&style=$style' target='_blank' style='margin-right: 139px;float: right;margin-top: -1px'>Packing List</a>
							</div>";
							$url=getFullURL($_GET['r'],'.php','R');
							echo "<div class='col-md-3 col-sm-3 col-xs-12'>
							<a class='btn btn-success btn-sm' href='$url?schedule=$schedule&style=$style' target='_blank' style='margin-right: 284px;float: right;margin-top: -1px'>Print Lables</a>
							</div>";
							$url=getFullURL($_GET['r'],'.php','R');
							echo "<div class='col-md-3 col-sm-3 col-xs-12'>
							<a class='btn btn-success btn-sm' href='$url?schedule=$schedule&style=$style' target='_blank' style='margin-right: 415px;float: right;margin-top: -1px'>Carton Track</a>
							</div>";
							$url=getFullURL($_GET['r'],'decentralized_packing_ratio.php','N');
							echo "<div class='col-md-12 col-sm-12 col-xs-12'>
							<a class='btn btn-success btn-sm' href='$url&schedule=$schedule&style=$style' target='_blank' style='margin-right: 21px;float: right;margin-top: -29px'>Add Packing Method</a>
							</div>";
							
				}
				
			}
			?> 
		</div>
	</div>
</div>