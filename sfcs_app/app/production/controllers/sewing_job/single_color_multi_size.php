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
	echo "<div class='panel panel-primary'>";
		echo "<div class='panel-heading'>Single Color Multi Size</div>";
		echo "<div class='panel-body'>";
			//first table
			echo "<div class='panel panel-primary'>";
					echo "<div class='panel-heading'>Number of Garments Per Poly Bag</div>
					<div class='panel-body'>
						<table class=\"table table-bordered\">
							<tr>
								<th>Color</th>";
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
							for ($j=0; $j < sizeof($color1); $j++)
							{
								echo "<tr>
										<td>$color1[$j]</td>";
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
			
			//second table
			echo "<div class='panel panel-primary'>";
					echo "<div class='panel-heading'>Poly Bags Per Carton</div>";
						echo "<div class='panel-body'>";
							echo "<div class='col-md-3 col-sm-3 col-xs-12'>Number of Poly Bags Per Carton : <input type='text' name='BagPerCart' id='BagPerCart' class='form-control' onchange=calculateqty($sizeofsizes,$size_of_ordered_colors);></div>";
						echo "</div>
				</div>";
			
			//third table	
			echo "<div class='panel panel-primary'>
					<div class='panel-heading'>Number of Garments Per Carton</div>
					<div class='panel-body'>
						<table class=\"table table-bordered\">
							<tr>
								<th>Color</th>";
									for ($i=0; $i < sizeof($sizes_to_display); $i++)
									{
										echo "<th>".$sizes_to_display[$i]."</th>";
									}
								echo "<th>Total</th>
							</tr>";
							$row_count=0;
							for ($j=0; $j < sizeof($color1); $j++)
							{
								echo "<tr>";
										echo "<td>$color1[$j]</td>";
										for ($size_count=0; $size_count < sizeof($size1); $size_count++)
										{
											echo "<td><input type='text' readonly='true' name='GarPerCart' id='GarPerCart_".$size_count."_".$row_count."' class='form-control' value=''></td>";
										}
										echo "<td><input type='text' name='total_".$j."' id='total_".$j."' readonly='true' class='form-control'></td>";
								echo "</tr>";
								$row_count++;
							}
						echo "</table>
					</div>
				</div>";
		echo "</div>
	</div>";
?>