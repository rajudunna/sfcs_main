<!DOCTYPE html>
<html>
<head>
	<title>Emblishment Table Master</title>
	<?php 
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
		$self_url = getFullURL($_GET['r'],'emb_table_master.php','N');
		if (isset($_GET['edit_id'])) 
		{
			$loc_id = $_GET['edit_id'];
			$currentLoc = "select * from $bai_pro3.tbl_emb_table where emb_table_id = ".$loc_id." ";
			$currentLocres = mysqli_query( $link, $currentLoc);
			while ($row = mysqli_fetch_array($currentLocres))
			{
				$emb_tbl_id_edit=$row["emb_table_id"];
				$emb_tbl_name_edit=$row["emb_table_name"];
				$cut_tbl_name_edit=$row["cut_table_name"];
				$status_edit=$row["emb_table_status"];
			}
		}

		if (isset($_GET['delete_id'])) 
		{
			// echo "string";
			$loc_id = $_GET['delete_id'];
			// echo $loc_id;
			$dalete_emb_details="delete from $bai_pro3.tbl_emb_table where emb_table_id = ".$loc_id." ";
			// echo $delete;
			$delete_emb_result = mysqli_query( $link, $dalete_emb_details);
			if ($delete_emb_result == 1 or $delete_emb_result == '1')
			{
				echo "<script>
						sweetAlert('Emblishment Table Deleted Successfully','','success');
						window.location.href = \"$self_url\";
					</script>";
			}
		}
	?>
</head>
<body>
	<div class="panel panel-primary ">
		<div class="panel-heading"><strong>Emblishment Table Master</strong></div>
		<div class="panel-body">
			<form  action="<?= $self_url ?>" method="POST" class="form-inline">
				<?php
					if (isset($_GET['edit_id'])) 
					{
						echo '<input type="hidden" name="emb_table_id" class="form-control" value="'.$emb_tbl_id_edit.'">';
					}					
				?>
				<div class="form-group">
					<label>Emblishment Table: </label>
					<input type="text" name="emb_table_name" class="form-control" value="<?php echo $emb_tbl_name_edit; ?>" required>
				</div>
				&nbsp;&nbsp;
				<div class="form-group">
					<label>Cutting Table: </label>
					<select required class="form-control" name="cut_table" id="cut_table">
						<option value="">Please Select</option>
						<?php 
							$get_cut_table_qury = "SELECT tbl_name FROM bai_pro3.`tbl_cutting_table` WHERE status='active';";
							$get_cut_table_result = mysqli_query( $link, $get_cut_table_qury);
							while ($row = mysqli_fetch_array($get_cut_table_result))
							{
								if ($cut_tbl_name_edit == $row['tbl_name'])
								{
									$selected = 'selected';
								}
								else
								{
									$selected = '';
								}
								
								echo "<option value='".$row['tbl_name']."' $selected>".$row['tbl_name']."</option>";
							}
						?>
					</select>
				</div>
				&nbsp;&nbsp;
				<div class="form-group">
					<label>Status: </label>
					<select required class="form-control" name="emb_status" id="emb_status">
						<option value="">Please Select</option>
						<?php 
							if (isset($_GET['edit_id']))
							{
								if ($status_edit == 'active')
								{
									echo '
										<option value="active" selected >Active</option>
										<option value="inactive">In Active</option>
									';
								}
								else if ($status_edit == 'inactive')
								{
									echo '
										<option value="active">Active</option>
										<option value="inactive" selected >In Active</option>
									';
								}
							}
							else
							{
								echo '
									<option value="active">Active</option>
									<option value="inactive">In Active</option>
								';
							}
						?>
					</select>
				</div>
				&nbsp;&nbsp;
				<input class="btn btn-success" type="submit" name="save_emb_table">
			</form>
			<br><br>
			<?php
				$sql = "SELECT * FROM $bai_pro3.`tbl_emb_table`";
				$result = $link->query($sql);
				$sno =1;
				$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
				$url1=getFullURL($_GET['r'],'delete_cutting_table.php','N');
				if ($result->num_rows > 0)
				{
					echo "<form name ='delete'>";
					echo "<table id='show_emb_tbl' class='table table-bordered'>
							<thead>
								<tr>
									<th>S.No</th>
									<th>Emblishment Table Name</th>
									<th>Cutting Table Name</th>
									<th>Status</th>
									<th>Control</th>
								</tr>
							</thead>
							<tbody>";
					// output data of each row
					while($row = $result->fetch_assoc())
					{
						$emb_table_id=$row["emb_table_id"];
						$emb_tbl_name=$row["emb_table_name"];
						$cut_tbl_name=$row["cut_table_name"];
						$status=$row["emb_table_status"];
						echo "<tr>
								<td>".$sno++."</td>
								<td>".$emb_tbl_name."</td>
								<td>".$cut_tbl_name."</td>
								<td>".ucwords($status)."</td>
								<td>"; ?>
									<a class="btn btn-info btn-sm" href="<?= $self_url ?>&edit_id=<?php echo $emb_table_id ?>" ><i class='fa fa-edit'></i> Edit</a>	
									<?php 
										echo "<a href='$self_url&delete_id=$emb_table_id' class='confirm-submit btn btn-danger btn-sm' id='del$emb_table_id'><i class='fa fa-trash'></i> Delete</a>";
									echo "</td>
							</tr>";
					}
					echo "</tbody></table>";
				}
				else
				{
					echo "0 results";
				}
			?>
			<?php 
				if (isset($_POST['save_emb_table']))
				{
					$emb_table_id = $_POST['emb_table_id'];
					$emb_table_name = $_POST['emb_table_name'];
					$cut_table = $_POST['cut_table'];
					$emb_status = $_POST['emb_status'];
					if ($emb_table_id > 0)
					{
						// echo "not null";
						$update_emb_details = "UPDATE `bai_pro3`.`tbl_emb_table` SET `emb_table_name` = '".$emb_table_name."' , `cut_table_name` = '".$cut_table."' , `emb_table_status` = '".$emb_status."' WHERE `emb_table_id` = '".$emb_table_id."';";
						$update_emb_result = mysqli_query( $link, $update_emb_details);
						if ($update_emb_result == 1 or $update_emb_result == '1')
						{
							echo "<script>
									sweetAlert('Updated Emblishment Table Successfully','','success');
									window.location.href = \"$self_url\";
								</script>";
						}
					}
					else
					{
						// echo "null";
						$save_emb_details = "INSERT INTO `bai_pro3`.`tbl_emb_table` (`emb_table_name`, `cut_table_name`, `emb_table_status`) VALUES ('".$emb_table_name."', '".$cut_table."', '".$emb_status."');";
						$save_emb_result = mysqli_query( $link, $save_emb_details);
						if ($save_emb_result == 1 or $save_emb_result == '1')
						{
							echo "<script>
									sweetAlert('New Emblishment Table Added Successfully','','success');
									window.location.href = \"$self_url\";
								</script>";
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