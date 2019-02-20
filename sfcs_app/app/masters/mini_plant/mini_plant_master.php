<!DOCTYPE html>
<html>
<head>
	<title>Mini Plant Master</title>
	<?php 
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
		$self_url = getFullURL($_GET['r'],'mini_plant_master.php','N');
		if (isset($_GET['edit_id'])) 
		{
			$loc_id = $_GET['edit_id'];
			$currentLoc = "select * from $bai_pro3.mini_plant_master where id = ".$loc_id." ";
			$currentLocres = mysqli_query( $link, $currentLoc);
			while ($row = mysqli_fetch_array($currentLocres))
			{
				$emb_tbl_id_edit=$row["id"];
				$mini_plant_name=$row["mini_plant_name"];
			}
		}

		if (isset($_GET['delete_id'])) 
		{
			$loc_id = $_GET['delete_id'];
			$delete_emb_details="delete from $bai_pro3.mini_plant_master where id = ".$loc_id." ";
			if (mysqli_query( $link, $delete_emb_details))
			{
				echo "<script>
						sweetAlert('Mini Plant Deleted Successfully','','success');
						window.location.href = \"$self_url\";
					</script>";
			}
		}
	?>
</head>
<body>
	<div class="panel panel-primary ">
		<div class="panel-heading"><strong>Mini Plant Master</strong></div>
		<div class="panel-body">
			<form  action="<?= $self_url ?>" method="POST" class="form-inline">
				<?php
					if (isset($_GET['edit_id'])) 
					{
						echo '<input type="hidden" name="mini_plant_id" class="form-control" value="'.$emb_tbl_id_edit.'">';
					}					
				?>
				<div class="form-group">
					<label>Mini Plant Name: </label>
					<input type="text" name="mini_plant_name" class="form-control" value="<?php echo $mini_plant_name; ?>" required>
				</div>

				&nbsp;&nbsp;
				<input class="btn btn-success" type="submit" name="save_mini_plant" value="Save">
			</form>
			<br><br>
			<?php
				$sql = "SELECT * FROM $bai_pro3.mini_plant_master";
				$result = $link->query($sql);
				$sno =1;
				if ($result->num_rows > 0)
				{
					echo "<table id='show_emb_tbl' class='table table-bordered'>
							<thead>
								<tr>
									<th>S.No</th>
									<th>Mini Plant Name</th>
									<th>Control</th>
								</tr>
							</thead>
							<tbody>";
					// output data of each row
					while($row = $result->fetch_assoc())
					{
						$mini_plant_name=$row["mini_plant_name"];
						$mini_plant_id=$row["id"];
						echo "<tr>
								<td>".$sno++."</td>
								<td>".$mini_plant_name."</td>
								<td>"; ?>
									<a class="btn btn-info btn-sm" href="<?= $self_url ?>&edit_id=<?php echo $mini_plant_id ?>" ><i class='fa fa-edit'></i> Edit</a>	
									<?php 
										echo "<a href='$self_url&delete_id=$mini_plant_id' class='confirm-submit btn btn-danger btn-sm' id='del$mini_plant_id'><i class='fa fa-trash'></i> Delete</a>";
									echo "</td>
							</tr>";
					}
					echo "</tbody></table>";
				}
				else
				{
					echo "No Mini Plants to Display";
				}
			?>
			<?php 
				if (isset($_POST['save_mini_plant']))
				{
					$mini_plant_id = $_POST['mini_plant_id'];
					$mini_plant_name = $_POST['mini_plant_name'];
					if ($mini_plant_id > 0)
					{
						$check_for_mini_plant = "SELECT * FROM $bai_pro3.mini_plant_master where mini_plant_name = '".$mini_plant_name."'";
						$check_for_mini_plant_result = $link->query($check_for_mini_plant);
						if (mysqli_num_rows($check_for_mini_plant_result) > 0)
						{
							echo "<script>
									sweetAlert('Mini Plant Already Exists','','error');
									window.location.href = \"$self_url\";
								</script>";
						}
						else
						{
							$update_emb_details = "UPDATE $bai_pro3.mini_plant_master SET mini_plant_name = '".$mini_plant_name."'  WHERE id = '".$mini_plant_id."';";
							if (mysqli_query( $link, $update_emb_details))
							{
								echo "<script>
										sweetAlert('Updated Mini Plant Details Successfully','','success');
										window.location.href = \"$self_url\";
									</script>";
							}
						}
					}
					else
					{
						$check_for_mini_plant = "SELECT * FROM $bai_pro3.mini_plant_master where mini_plant_name = '".$mini_plant_name."'";
						$check_for_mini_plant_result = $link->query($check_for_mini_plant);
						if (mysqli_num_rows($check_for_mini_plant_result) > 0)
						{
							echo "<script>
									sweetAlert('Mini Plant Already Exists','','error');
									window.location.href = \"$self_url\";
								</script>";
						}
						else
						{
							$save_emb_details = "INSERT INTO $bai_pro3.mini_plant_master (mini_plant_name) VALUES ('".$mini_plant_name."');";
							if (mysqli_query( $link, $save_emb_details))
							{
								echo "<script>
										sweetAlert('New Mini Plant Added Successfully','','success');
										window.location.href = \"$self_url\";
									</script>";
							}
						}
					}				
				}
			?>
		</div>
	</div>
</body>
<script>
$(document).ready(function() {
    $('#show_emb_tbl').DataTable();
} );
</script>
</html>