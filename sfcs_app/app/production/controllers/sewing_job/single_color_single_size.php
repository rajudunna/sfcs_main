<script>
	function calculateqty(i)
	{
		var GarPerBag=document.getElementById('GarPerBag_'+i).value;
		var BagPerCart=document.getElementById('BagPerCart_'+i).value;
		var GarPerCart = GarPerBag*BagPerCart;
		document.getElementById('GarPerCart_'+i).value=GarPerCart;
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
							echo "<tr>
									<td>Number of Garments per Polybag</td>";
									for ($i=0; $i < $sizeofsizes; $i++)
									{ 
										echo "<td><input type='text' name='GarPerBag' id='GarPerBag_".$i."' class='form-control' value=''></td>";
									}
							echo "</tr>";

							echo "<tr>
									<td>Number of Polybags per Carton</td>";
									for ($i=0; $i < $sizeofsizes; $i++)
									{ 
										echo "<td><input type='text' name='BagPerCart' id='BagPerCart_".$i."' class='form-control' onchange='calculateqty($i);' value=''></td>";
									}
							echo "</tr>";

							echo "<tr>
									<td>Number of Garments per Carton</td>";
									for ($i=0; $i < $sizeofsizes; $i++)
									{ 
										echo "<td><input type='text' name='GarPerCart' id='GarPerCart_".$i."' class='form-control' value='' readonly></td>";
									}
							echo "</tr>";
						echo "</table>
					</div>
				</div>";
		echo "</div>
	</div>";
	
?>