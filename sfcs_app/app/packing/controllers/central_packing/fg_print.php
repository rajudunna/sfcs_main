<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'fg_print.php','N'); ?>';
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
	<div class="panel-heading"><b>Pack Method</b></div>
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
			$page = mysql_escape_string($_GET['page']);
		if($page)
		{
			$start = ($page - 1) * $limit; 
		}
		else
		{
			$start = 0;	
		}
			if(isset($_POST['submit']))
			{	
				
				//packing method details
				$style=$_POST['style'];
				$schedule=$_POST['schedule'];
				$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where ref_order_num=$schedule AND style_code='".$style."'"; 
				// echo $get_pack_id;
				$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row = mysqli_fetch_row($get_pack_id_res);
				$pack_id=$row[0];
				// echo $pack_id;
				// die();
				$pack_meth_qry="SELECT *,parent_id,SUM(garments_per_carton) as qnty,GROUP_CONCAT(size_title) as size ,GROUP_CONCAT(color) as color,seq_no,pack_method FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id='$pack_id' GROUP BY pack_method";
				// echo $pack_meth_qry;
				// $sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo "<table class=\"table table-bordered\">";
			echo "<div class='col-md-12'>";
			echo "<div class='col-md-4'>Style: ".$style."</div>";
			echo "<div class='col-md-4'>Buyer Division: </div>";
			echo "<div class='col-md-4'>Schedule No: ".$schedule."</div>";
			
			echo "</div>";
			echo "<div class='col-md-12'>";
			echo "<div class='col-md-4'>MPO: </div>";
			echo "<div class='col-md-4'>CPO: </div>";
			echo "<div class='col-md-4'>Customer Order :</div>";
			
			echo "</div>";
			// echo "</table>";
				echo "<div class='col-md-6' style='float: right; margin: center;'> <a class='btn btn-warning' href='$url?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print All packing list
				<a class='btn btn-warning' href='$url1?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print All Carton track
				<a class='btn btn-warning' href='$url2?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print All Labels</a>";
			echo "</div>";
					echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr>
									<th>S.No</th>
									<th>Packing Method</th>
									<th>Description</th>
									<th>No Of Colors</th>
									<th>No Of Sizes</th>
									<th>No Of Cartons</th>
									<th>Quantity</th>
									<th>Controlls</th></tr>";
								while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									// var_dump($operation);
									$seq_no=$pack_result1['seq_no'];
									$parent_id=$pack_result1['parent_id'];
									$pack_method=$pack_result1['pack_method'];
									// echo $pack_method;
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><tr><td>".++$start."</td>";
									echo"<td>".$operation[$pack_method]."</td>";
									echo "<td>".$pack_result1['pack_description']."</td>";
									echo "<td>".$pack_result1['color']."</td>";
									echo "<td>".$pack_result1['size']."</td>";
									echo "<td>-</td>";
									echo "<td>".$pack_result1['qnty']."</td>";
									$url=getFullURL($_GET['r'],'#','N');
									$url1=getFullURL($_GET['r'],'#','N');
									$url2=getFullURL($_GET['r'],'#','N');
									// $url3=getFullURL($_GET['r'],'.php','R');
									// $url4=getFullURL($_GET['r'],'.php','R');
									echo "<td>
									<a class='btn btn-warning' href='$url?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >FG Check List
									<a class='btn btn-warning' href='$url1?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Carton Track
									<a class='btn btn-warning' href='$url2?seq_no=$seq_no&c_ref=$parent_id&pack_method=$pack_method' target='_blank' >Print Lables</a>
									</td>";
									echo "<tr>";
									
								}	
							
						echo "</table></div>";
												
			}
				
			?> 
		</div>
	</div>
</div>