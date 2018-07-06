<script>

function calculateqty(sizeofsizes,sizeOfColors)
{
	var total=0;
	for (var row_count = 0; row_count < sizeOfColors; row_count++)
	{
		for(var size=0;size < sizeofsizes; size++)
		{
			var GarPerBag=document.getElementById('GarPerBag_'+size+'_'+row_count).value;
			var BagPerCart=document.getElementById('BagPerCart').value;
			var GarPerCart = GarPerBag*BagPerCart;
			document.getElementById('GarPerCart_'+size+'_'+row_count).value=GarPerCart;
			total = total+GarPerCart;
		}
		document.getElementById('total_'+row_count).value=total;
		total=0;
	}
}

</script>

<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);
	
	// $style_code=$_GET['style'];
	// $schedule=$_GET['schedule'];
	$pack_method=$_GET['pack_method'];
	
	$style_code='3';
	$schedule='3';
	
	$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
	$o_colors = echo_title("$bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","bai_orders_db.order_joins NOT IN ('1','2') AND order_del_no",$schedule_original,$link);	
	$p_colors = echo_title("$brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$schedule,$link);
	$order_colors=explode(",",$o_colors);	
	$planned_colors=explode(",",$p_colors);
	$size_of_ordered_colors=sizeof($order_colors);
	$size_of_planned_colors=sizeof($planned_colors);
	// echo 'order_colors: '.$size_of_ordered_colors.'<br>planned: '.$size_of_planned_colors;
	
	
	echo "<div class='panel panel-primary'>";
	echo "<div class='panel-heading'>Single Color Single Size</div>";
	echo "<div class='panel-body'>";
	if ($size_of_ordered_colors==$size_of_planned_colors)
	{
		echo "<script>sweetAlert('Please prepare Lay Plan for all Colors in this Schedule - $schedule','','warning')</script>";
	}
	else
	{		
		$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule AND style_code=$style_code)";
		$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
		while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
		{
			$parent_id = $sewing_jobratio_color_details['parent_id'];
			$color = $sewing_jobratio_color_details['color'];
			$size = $sewing_jobratio_color_details['size'];
			$color1 = explode(",",$color);
			$size1 = explode(",",$size);
			// var_dump($size);
		}
		//first table
		echo "<div class='panel panel-primary'>";
				echo "<div class='panel-heading'>Carton Details</div>
				<div class='panel-body'>
					<table class=\"table table-bordered\">
						<tr>
							<th>Size</th>";
							// Display Sizes
							$sizes_to_display=array();
							for ($i=0; $i < sizeof($size1); $i++)
							{
								$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
								// echo $Original_size_query;
								$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
								while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
								{
									$Ori_size = $Original_size_details['size_title'];
									$sizes_to_display[] = $Original_size_details['size_title'];
								}
								$sizeofsizes=sizeof($sizes_to_display);
								echo "<th>".$Ori_size."</th>";
							}
						echo "</tr>";
						// Display Textboxes
						$row_count=0;
						for ($j=0; $j < 2; $j++)
						{
							echo "<tr>";
									for ($size_count=0; $size_count < sizeof($size1); $size_count++)
									{
										echo "<td><input type='text' name='GarPerBag' id='GarPerBag_".$size_count."_".$row_count."' class='form-control' value=''></td>";
									}
							echo "</tr>";
							$row_count++;
						}
					echo "</table>
				</div>
			</div>";
		
		
	}
	echo "</div></div>";
	
?>