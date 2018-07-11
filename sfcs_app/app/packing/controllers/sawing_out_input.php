<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>

<div class="panel panel-primary">
	<div class="panel-heading">Packing List generation(Sawing Job)</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
						<div class="row">
							<div class="col-sm-6">
								Enter Schedule : <input type='text' id='int' name='schedule' size=8 class="form-control integer" required>
							</div>
							<div class="col-sm-3">	
								<input type="submit" value="Show" name="submit" id='sub' style='margin-top:22px;' class="btn btn-info" />
							</div>
						</div>	
					</form>
				</div>	
			</div>		
		
<?php
if(isset($_POST['submit']))
{	
	$schedule=$_POST['schedule'];
	$sch_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
	$c_ref = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
	$mini = echo_title("$brandix_bts.tbl_miniorder_data","sum(quantity)","mini_order_ref",$c_ref,$link);
	if($c_ref>0 && $mini>0)
	{
		$carton_method = echo_title("$brandix_bts.tbl_carton_ref","carton_method","carton_barcode",$schedule,$link);
		$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size, GROUP_CONCAT(DISTINCT order_col_des) AS color FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id='$sch_id'";
		//echo $sewing_jobratio_sizes_query.'<br>';
		$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
		while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
		{
			$parent_id = $sewing_jobratio_color_details['parent_id'];
			$color = $sewing_jobratio_color_details['color'];
			$ref_size = $sewing_jobratio_color_details['size'];
			$color1 = explode(",",$color);
			$size1 = explode(",",$ref_size);
			// var_dump($size);
		}
		if($carton_method==1)
		{
			echo "<div class='col-md-12'><b>";
			echo "<h2>Single Color & Single Size Carton Method</h2></b></div>";
		}
		else if($carton_method==2)
		{
			echo "<div class='col-md-12'><b>";
			echo "<h2>Multi Color & Single Size  Carton Method</h2></b></div>";
		}
		else if($carton_method==3)
		{
			echo "<div class='col-md-12'><b>";
			echo "<h2>Multi Color & Multi Size Carton Method</h2></b></div>";
		}
		if($carton_method==4)
		{
			echo "<div class='col-md-12'><b>";
			echo "<h2>Single Color & Multi Size Carton Method</h2></b></div>";
		}
		?>
		<form name="test" action="<?php echo '?r='.$_GET['r']; ?>" method="post">
		<?php
			echo "<div class='col-md-12'><b>Garments Per Carton: </b>";
			
			echo "<div class='table-responsive'>
				<table class=\"table table-bordered\">
					<tr>
						<th>Color</th>";
						// Display Sizes
						for ($i=0; $i < sizeof($size1); $i++)
						{
							echo "<th>".$size1[$i]."</th>";
						}
					echo "</tr>";
					// Display Textboxes
					$row_count=0;
					for ($j=0; $j < sizeof($color1); $j++)
					{
						echo "<tr>
								<td>$color1[$j]</td>";
								for ($size_count=0; $size_count < sizeof($size1); $size_count++)
								{
									$individual_sizes_query = "SELECT size_title FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id='$sch_id' AND order_col_des='".$color1[$j]."'  AND size_title='".$size1[$size_count]."'";
									// echo $individual_sizes_query.'<br>';
									$individual_sizes_result=mysqli_query($link, $individual_sizes_query) or exit("Error while getting individual size Details");
									while($individual_sizes_details=mysqli_fetch_array($individual_sizes_result)) 
									{
										$individual_color = $individual_sizes_details['size_title'];
									}

									$qty_query = "SELECT garments_per_carton FROM $brandix_bts.`tbl_carton_size_ref` WHERE size_title='$size1[$size_count]' AND parent_id=$c_ref AND color='".$color1[$j]."'";
									// echo '<br>'.$qty_query.'<br>';
									$qty_query_result=mysqli_query($link, $qty_query) or exit("Error while getting Qty Details");
									while($qty_query_details=mysqli_fetch_array($qty_query_result)) 
									{
										$qty = $qty_query_details['garments_per_carton'];
										if ($qty == '') {
											$qty=0;
										}
										if (mysqli_num_rows($individual_sizes_result) >0)
										{
											if ($size1[$size_count] == $individual_color) {
												echo "<td>".$qty."</td>";
											}
										}
										else
										{
											echo "<td>".$qty."</td>";
										}
									}
									
								}
						echo "</tr>";
						$row_count++;
					}
				echo "</table>";
				echo "<input type='hidden' name='c_ref' id='c_ref' value='".$c_ref."' />";
			echo "<input type='submit' class='btn btn-success'  name='generate' id='MM_SM_save' value='Generate' />";
				echo "</div>
		<div></form>";
	}
	else
	{
		echo "<h2>Sewing job not yet generated.</h2>";
	}		
}
if(isset($_POST['generate']))
{	
	$c_ref=$_POST['c_ref'];
	$carton_id=$_GET["id"]; 
	$sql12="SELECT carton_method,style_code,ref_order_num,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM brandix_bts.tbl_carton_ref 
	LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE COMBO_NO>0 and tbl_carton_ref.id='".$carton_id."' GROUP BY COMBO_NO";
	$cols_tot_tmp=array();
	$result121=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$cols_tot_tmp[]=$row121['cols'];
		$style_id=$row121['style_code'];
		$schedule_id=$row121['ref_order_num'];
		$carton_method=$row121['carton_method'];
	}
	if($carton_method==1)
	{
		echo "<h2>Single Color & Single Size Carton Method</h2>";
	}
	else if($carton_method==2)
	{
		echo "<h2>Multi Color & Single Size  Carton Method</h2>";
	}
	else if($carton_method==3)
	{
		echo "<h2>Multi Color & Multi Size Carton Method</h2>";
	}
	if($carton_method==4)
	{
		echo "<h2>Single Color & Multi Size Carton Method</h2>";
	}
	$cols_tot=array();	
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);

	echo "<br>";
	echo "<br>";
	echo "<table class='table table-striped table-bordered'>";
	echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Carton Number</th><th>Carton Rand No </th><th>Quantity</th></thead>";
	//packing List Generation
	$status_check=='1';
	for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
	{
		$cols_tot=explode(",",$cols_tot_tmp[$kk]);
		$sql1y="SELECT color,size_title FROM $brandix_bts.tbl_carton_ref 
		LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE 
		tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
		$resulty=mysqli_query($link, $sql1y) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1y=mysqli_fetch_array($resulty))
		{				
			$carton_job_no_tmp= echo_title;
			for($ii=0;$ii<sizeof($cols_tot);$ii++)
			{			
				$sql121="SELECT input_job_no,order_col_des,size_code FROM $bai_pro3.packing_summary_input WHERE type_of_sewing=1 and order_del_no='".$schedule."' and order_col_des='".$row1y["color"]."' and size_code='".$row1y["size_title"]."' group  BY input_job_no order by input_job_no*1";
				echo $sql121."<br>";
				$result121=mysqli_query($link, $sql121) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($result121=mysqli_fetch_array($result121)) 
				{ 
					if($result121["input_job_no"]=='1')
					{
						$carton_job_no=1;
					}
					else
					{
						$carton_job_no=echo_title("$bai_pro3.pac_stat_log","MAX(CAST(doc_no_ref AS DECIMAL))+1","color in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and schedule",$schedule,$link);
					}
					$rand=$schedule.date("ymd").$carton_job_no;
					$color_code=$result121['order_col_des'];
					$size_ref=$result121['old_size'];
					$size_tit=$result121['size_code'];
					$garments_per_carton=echo_title("$brandix_bts.tbl_carton_size_ref","garments_per_carton","color='".$color_code."' and size_title='".$size_tit."' and parent_id",$carton_id,$link);
					$carton_job_quantiy_tmp=0;
					$sql12="SELECT * FROM $bai_pro3.packing_summary_input WHERE type_of_sewing=1 and order_del_no='".$schedule."' and order_col_des='".$color_code."' and size_code='".$size_tit."' and input_job_no='".$result121['input_job_no']."' ORDER BY input_job_no*1";
					echo $sql12."<br>";	
					//die();
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$destination=$row12["destination"];
						$docket_number=$row12["doc_no"];
						$old_size=$row12["old_size"];
						$qty=$row12["quantity"];
						echo $garments_per_carton."---".$qty."<br>";
						die();
						if($qty>0)
						{												
							do
							{	
								if(($garments_per_carton-$carton_job_quantiy_tmp)<=$qty)
								{
									$qty_new=$garments_per_carton-$carton_job_quantiy_tmp;
									$qty=$qty-$qty_new;
									$sql1q="INSERT INTO `bai_pro3`.`pac_stat_log` (`doc_no`, `size_code`, `carton_no`, `carton_mode`, `carton_act_qty`, `status`, `lastup`, `remarks`, `doc_no_ref`, `container`, `disp_carton_no`, `disp_id`, `audit_status`, `scan_date`, `scan_user`, `input_job_random`, `input_job_number`, `order_tid`, `module`, `style`, `schedule`, `color`) VALUES ('".$docket_number."', '".$old_size."', '".$carton_job_no."', 'F', '".$qty_new."', NULL, NULL, NULL, '".$rand."', '1', NULL, NULL, NULL, NULL, NULL, '".$row12["input_job_no_random"]."', '".$row12["input_job_no"]."', '".$row12["order_Style_no"].$row12["order_del_no"].$row12["order_col_des"]."', '', '".$row12["order_Style_no"]."', '".$row12["order_del_no"]."', '".$row12["order_col_des"]."')";
									//mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
									echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$old_size."</td><td>".$size_tit."</td><td>".$carton_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
									$qty_new=0;
									$carton_job_no++;
									$rand=$schedule.date("ymd").$carton_job_no;
									$carton_job_quantiy_tmp=0;
								}
								else
								{
									$carton_job_quantiy_tmp+=$qty;
									$sql1q="INSERT INTO `bai_pro3`.`pac_stat_log` (`doc_no`, `size_code`, `carton_no`, `carton_mode`, `carton_act_qty`, `status`, `lastup`, `remarks`, `doc_no_ref`, `container`, `disp_carton_no`, `disp_id`, `audit_status`, `scan_date`, `scan_user`, `input_job_random`, `input_job_number`, `order_tid`, `module`, `style`, `schedule`, `color`) VALUES ('".$docket_number."', '".$old_size."', '".$carton_job_no."', 'F', '".$qty."', NULL, NULL, NULL, '".$rand."', '1', NULL, NULL, NULL, NULL, NULL, '".$row12["input_job_no_random"]."', '".$row12["input_job_no"]."', '".$row12["order_Style_no"].$row12["order_del_no"].$row12["order_col_des"]."', '', '".$row12["order_Style_no"]."', '".$row12["order_del_no"]."', '".$row12["order_col_des"]."')";
									// mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
									echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$old_size."</td><td>".$size_tit."</td><td>".$carton_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
									$qty=0;
								} 
								
							}while($qty>0);	
						}
					}
				}	
									
			}				
			$status_check=0;
		}			
		
		unset($cols_tot);
	}
	echo "</table>";
}
	echo "</div></div>";
	


?>