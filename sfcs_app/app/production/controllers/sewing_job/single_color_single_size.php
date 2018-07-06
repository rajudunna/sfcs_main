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
		echo "<div class='panel-heading'>Single Color Single Size</div>";
		echo "<div class='panel-body'>";
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
		echo "</div>
	</div>";
	
?>