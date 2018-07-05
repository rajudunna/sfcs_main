<script>

function calculateqty(i)
{
	alert(i);
	var qty=document.getElementsByName('qty').value;
	alert(qty);
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
	echo "<div class='panel-heading'>Multi Color Single Size</div>";
	echo "<div class='panel-body'>";

	if ($size_of_ordered_colors==$size_of_planned_colors)
	{
		echo "<script>sweetAlert('Please prepare Lay Plan for all Colors in this Schedule - $schedule','','warning')</script>";
		// echo "<br><br><br><div class='alert alert-danger'>Please prepare Lay Plan for all Colors in this Schedule - $schedule_original</div>";
	}
	else
	{
	
	
	//first table
	echo "";
	$sewing_jobratio_sizes_query = "SELECT parent_id,GROUP_CONCAT(DISTINCT color) AS color, GROUP_CONCAT(DISTINCT ref_size_name) AS size FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule AND style_code=$style_code)";
	$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
	echo "<div class='panel panel-primary'>";
	echo "<div class='panel-heading'>Number of Garments For Poly Bag</div>
	<div class='panel-body'>
		<table class=\"table table-bordered\">
			<tr>
				<th>Color</th>";
		while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
		{
			$parent_id = $sewing_jobratio_color_details['parent_id'];
			$color = $sewing_jobratio_color_details['color'];
			$size = $sewing_jobratio_color_details['size'];
			$color1 = explode(",",$color);
			$size1 = explode(",",$size);
			// var_dump($size);
		}
		for ($i=0; $i < sizeof($size1); $i++)
		{
			$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
			// echo $Original_size_query;
			$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
			while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
			{
				$Ori_size = $Original_size_details['size_title'];
			}
			echo "<th>".$Ori_size."</th>";
		}
		echo "</tr>";
		for ($j=0; $j < sizeof($color1); $j++)
		{
			echo "<tr>
					<td>$color1[$j]</td>";
					for ($i=0; $i < sizeof($size1); $i++)
					{
						echo "<td><input type='text' name='qty' class='form-control'></td>";
					}
			echo "</tr>";
		}
		echo "</table></div></div>";
	
	//second table
	echo "<div class='panel panel-primary'>";
	echo "<div class='panel-heading'>Number of Poly Bags Per Carton</div>";
	echo "<div class='panel-body'>";
	echo "<div class='table-responsive'>";
	
	echo "<table class='table table-bordered'>";
	
		for ($i=0; $i < sizeof($size1); $i++)
		{
			$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
			// echo $Original_size_query;
			$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
			while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
			{
				$Ori_size = $Original_size_details['size_title'];
			}
			echo "<th>".$Ori_size."</th>";
		}
		echo "</tr>";
		// for ($j=0; $j < sizeof($color1); $j++)
		// {
			echo "<tr>";
					for ($i=0; $i < sizeof($size1); $i++)
					{
						echo "<td><input type='text' name='qty' class='form-control' onchange=calculateqty($i);></td>";
					}
			echo "</tr>";
		// }	
	echo "</table>";
	
	echo "</div></div></div>";
	
	
	
	//third table	
	echo "<div class='panel panel-primary'>";
	echo "<div class='panel-heading'>Number of Garments Per Carton</div>
	<div class='panel-body'>
		<table class=\"table table-bordered\">
			<tr>
				<th>Color</th>";
		
		for ($i=0; $i < sizeof($size1); $i++)
		{
			$Original_size_query = "SELECT DISTINCT size_title FROM `brandix_bts`.`tbl_orders_sizes_master` WHERE parent_id = $schedule AND ref_size_name=$size1[$i]";
			// echo $Original_size_query;
			$Original_size_result=mysqli_query($link, $Original_size_query) or exit("Error while getting Qty Details");
			while($Original_size_details=mysqli_fetch_array($Original_size_result)) 
			{
				$Ori_size = $Original_size_details['size_title'];
			}
			echo "<th>".$Ori_size."</th>";
		}
		echo "</tr>";
		for ($j=0; $j < sizeof($color1); $j++)
		{
			echo "<tr>
					<td>$color1[$j]</td>";
					for ($i=0; $i < sizeof($size1); $i++)
					{
						echo "<td><input type='text' readonly='true' name='qtyfinal' class='form-control'></td>";
					}
			echo "</tr>";
		}
		echo "</table></div></div>";
	}
	echo "</div></div>";
	
?>