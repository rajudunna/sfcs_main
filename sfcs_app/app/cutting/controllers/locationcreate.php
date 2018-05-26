
<title>Create Location</title>
<style type="text/css">
	.scroll
	{
		width: 100%;
		height: 300px;
		overflow-y: scroll;
	}
</style>

<?php
	error_reporting(0);
	include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$flag='';
	if (isset($_GET['edit_id'])) {
		$loc_id = $_GET['edit_id'];
		$rec = "select * from $bai_pro3.locations where loc_id = $loc_id";
		$recReply = mysqli_query( $link, $rec) or exit("Problem Fetching data from Database/".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($row=mysqli_fetch_array($recReply))
		{
			$loc_name = $row['loc_name'];
			$capacity = $row['capacity'];
		}
		$flag = ($loc_id)?'readonly':'';
	}
	$self = getFullURL($_GET['r'],'locationcreate.php','N');
    $self_url = getFullURL($_GET['r'],'locationcreate.php','N');
?>
<div class="container">
	<?php				
		if (!empty($_POST['loc_name']) || !empty($_POST['capacity'])) 
		{
			$locName = $_POST['loc_name'];
			$cap = $_POST['capacity'];

			if (isset($_GET['edit_id'])) 
			{
				$loc_id = $_GET['edit_id'];
				$currentLoc = "select capacity from $bai_pro3.locations where loc_id = ".$loc_id." ";				
				$currentLocres = mysqli_query( $link, $currentLoc);
				$res=mysqli_fetch_row($currentLocres);
				if($cap < $res[0]){?>
					<div class="alert alert-danger fa fa-thumbs-down">
						Capacity should be greatter or equal to the filled quantity
					</div>
					<script type="text/javascript">
						setTimeout(function () {
							window.location.href="<?= $self ?>";
						},1000);
					</script>

				<?php }else{
					$rec = "UPDATE locations SET loc_name = '".$locName."', capacity=".$cap." WHERE loc_id = ".$loc_id." ";
					// echo $rec;
					$recReply = mysqli_query( $link, $rec);
					if ($recReply) 
					{?>
						<div class="alert alert-success fa fa-thumbs-up">
							<strong>Success!</strong><br>Sucessfully Updated the Location!
						</div>
						<script type="text/javascript">
							setTimeout(function () {
								window.location.href="<?= $self ?>";
							},1000);
						</script>
					<?php	
					}
					else
					{	?>
						<div class="alert alert-danger fa fa-thumbs-down">
							<strong>Failed</strong> to Update the Location!
						</div>
						<script type="text/javascript">
							setTimeout(function () {
								window.location.href="<?= $self ?>";
							},1000);
						</script>
					<?php 
					}
				}
			}else{
				$InsertQuery = 'INSERT INTO '.$bai_pro3.'.`locations` (`loc_name`, `capacity`) VALUES ( "'.$locName.'" , '.$cap.') ON DUPLICATE KEY UPDATE loc_name = VALUES(loc_name), capacity = VALUES(capacity);';
				$InsertReply = mysqli_query( $link, $InsertQuery);
				if ($InsertReply) 
				{?>
					<div class="alert alert-success fa fa-thumbs-up">
						<strong>Success!</strong><br>Sucessfully Created the Location!
					</div>
					<script type="text/javascript">
						setTimeout(function () {
							window.location.href="<?= $self ?>";
						},1000);
					</script>
				<?php	
				}
				else
				{	?>
					<div class="alert alert-danger 	fa fa-thumbs-down">
						<strong>Failed</strong> to Create the Location!
					</div>
					<script type="text/javascript">
						setTimeout(function () {
							window.location.href="<?= $self ?>";
						},1000);
					</script>
				<?php 
				}
			}
			
		}

		if (isset($_GET['del_id'])) {
			$loc_id = $_GET['del_id'];
			$deleteQuery = "DELETE FROM $bai_pro3.`locations` WHERE `loc_id` = '$loc_id'";
			$deleteReply = mysqli_query( $link, $deleteQuery);
			if ($deleteReply) {?>
				<div class="alert alert-success fa fa-thumbs-up">
						<strong>Success!</strong><br>Sucessfully Deleted the Location!
					</div>
					<script type="text/javascript">
						setTimeout(function () {
							window.location.href="<?= $self ?>";
						},1000);
					</script>
			<?php	}else{	?>
				<div class="alert alert-danger fa 8-thumbs-down">
						<strong>Failed</strong> to Delete the Location!
					</div>
					<script type="text/javascript">
						setTimeout(function () {
							window.location.href="<?= $self ?>";
						},1000);
					</script>
			<?php }
		}
	?>
	<div class="panel panel-primary ">
		<div class="panel-heading"><strong>Create Location</strong></div>
		<div class="panel-body">

			<form action="#" method="POST" class="form-inline" >
				
				<div class="form-group col-md-2">
					<label>Location Name: </label>
				</div>
				<div class="form-group col-md-2">
					<input type="text" name="loc_name" class="form-control" <?php echo $flag; ?> title="Enter Location Name" value="<?php echo $loc_name; ?>" required>
				</div>
				<br><br>
				<div class="form-group col-md-2">
					<label>Capacity: </label>
				</div>
				<div class="form-group col-md-2">
					<input type="number" min="0" name="capacity" class="form-control" title="Enter Capacity" value="<?php echo $capacity; ?>" required> 
				</div>
				<br><br>
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-2">
							<input class="btn btn-primary " type="submit" name="save_btn">
							<input  class="btn btn-danger"  type="reset">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Existing Locations</strong></div>
		<div class="panel-body">
		<form action="#" method="POST" class="form-inline" ><br>
			<div class="form-group">
				<label>Search: </label>
				<input type="text" id="Input" class="form-control" onkeyup="filterFunction()" placeholder="Search for Location names">
			</div>
		</form>	
			<br><br>
			<div class="col-sm-12" style='max-height : 400px;overflow-x:scroll;overflow-y:scroll'>
				<table class='table table-hover' name='table_new' id='table_new'>
				<thead>
					<tr class='danger'>
						<th>Location Name</th>
						<th>Capacity</th>
						<th>Filled Quantity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody >
					<?php
						$selectQuery = "SELECT * FROM $bai_pro3.locations";
						$selectReply = mysqli_query( $link, $selectQuery) or exit("Problem Fetching data from Database/".mysqli_error($GLOBALS["___mysqli_ston"]));;
						$locValues =array();
						$resValues =array();
						while ($row=mysqli_fetch_array($selectReply))
						{
							$locValues['loc_id'] = $row['loc_id'];
							$locValues['loc_name'] = $row['loc_name'];
							$locValues['capacity'] = $row['capacity'];
							$locValues['filled_qty'] = $row['filled_qty'];
							array_push($resValues, $locValues);
						}
						if(count($resValues) > 0){
							for($i=0;$i<count($resValues);$i++){	?>
								<tr>
									<td> <?php echo $resValues[$i]['loc_name'];   ?> </td>
									<td> <?php echo $resValues[$i]['capacity'];   ?> </td>
									<td> <?php echo $resValues[$i]['filled_qty']; ?> </td>
									<td><a  class="fa fa-pencil-square-o" title="Edit Location" style="font-size:24px;color:blue" href="<?= $self_url ?>&edit_id=<?php echo $resValues[$i]['loc_id']?>" ></a>
										&nbsp;
								<?php if ($resValues[$i]['filled_qty'] == 0) {	?>
									<a  class="fa fa-trash" title="Delete Location" 
									onclick= ' sweetAlert({
													title: "Are you sure ??",
													text: "Delete the location", 
													icon: "warning",
													buttons: true,
													dangerMode: true,
												}).then((isConfirm)=>{
													if (isConfirm) {
														sweetAlert("Deleted!","","success");
														window.location.href = "<?= $self_url ?>&del_id=<?= $resValues[$i]['loc_id']?>";
													} else {
														sweetAlert("Cancelled","","error");
													}
												});'
													
									class="fa fa-trash-o" style="font-size:24px;color:red" href="#"></a></td>
									<?php
								}else{
									echo "</td>";
								}
								echo "</tr>";
							}
						}
					?>
				</tbody>
			</table> 
			</div>
		</div>
	</div>	
</div>
</div>
<script>
	function filterFunction() {
		var input, filter, table, tr, td, i;
		input = document.getElementById("Input");
		filter = input.value.toUpperCase();
		table = document.getElementById("table_new");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
			} else {
			tr[i].style.display = "none";
			}
		}       
		}
	}
</script>
