<!DOCTYPE html>
<html>
<head>
	<title>Eligible Cartons</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
		
		if (isset($_POST['vpo']))
		{
			$vpo = $_POST['vpo'];
		}
		else
		{
			$vpo = $_POST['vpo'];
		}
	?>
</head>
<body>
	<div class="panel panel-primary">
		<div class="panel-heading">Eligible Cartons</div>
		<div class="panel-body">
			<form class="form-inline" action="<?php $_GET['r'] ?>" method="POST">
				<label>Select VPO: </label>
				<select name="vpo" id="vpo" class="form-control" required="true">
					<option value="">Please Select</option>
					<?php
						$sql="SELECT distinct vpo from $bai_pro3.mo_details";
						$sql_result=mysqli_query($link, $sql) or exit("error while fetching VPO numbers");
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['vpo'])==str_replace(" ","",$vpo))
							{
								echo "<option value=\"".$sql_row['vpo']."\" selected>".$sql_row['vpo']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['vpo']."\">".$sql_row['vpo']."</option>";
							}
						}
					?>
				</select>
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success">
			</form>
			<?php
				if (isset($_POST['submit']))
				{
					$vpo = $_POST['vpo'];
					$mo_no_query = "SELECT style, schedule FROM $bai_pro3.mo_details WHERE vpo = $vpo";
					// echo $mo_no_query;
					$mo_result=mysqli_query($link, $mo_no_query) or exit("Error while getting schedules");
					
					if (mysqli_num_rows($mo_result) > 0)
					{
						$style = $mo_result['style'];
						$schedule = $mo_result['schedule'];

						$get_pack_id="SELECT id from $bai_pro3.tbl_pack_ref where schedule=$schedule AND style='".$style."'"; 
						// echo $get_pack_id;
						$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("error while getting parent_id");
						$row = mysqli_fetch_row($get_pack_id_res);
						$pack_id=$row[0];

						$pack_meth_qry="SELECT * FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id='$pack_id' GROUP BY seq_no ORDER BY seq_no";
						// echo $pack_meth_qry;
						$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("error while fetching pack methods");
						if (mysqli_num_rows($pack_meth_qty) > 0)
						{
							while($pack_result1=mysqli_fetch_array($pack_meth_qty))
							{
								$pack_method=$pack_result1['pack_method'];
								$pack_description=$pack_result1['pack_description'];

								echo "<br>
									<div class='col-md-12'>
										<div class=\"panel panel-primary\">
											<div class=\"panel-heading\">".$operation[$pack_method]." --- ".$pack_description."</div>
											<div class=\"panel-body\">
												<table class='table table-bordered'>
													<thead>
														<tr class='info'>
															<th>Completed</th>
															<th>Eligible</th>
															<th>Pending</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<a class='btn btn-success btn-xs'>1</a>
																<a class='btn btn-success btn-xs'>2</a>
																<a class='btn btn-success btn-xs'>3</a>
																<a class='btn btn-success btn-xs'>4</a>
																<a class='btn btn-success btn-xs'>5</a>
															</td>
															<td>
																<a class='btn btn-primary btn-xs'>1</a>
																<a class='btn btn-primary btn-xs'>2</a>
																<a class='btn btn-primary btn-xs'>3</a>
																<a class='btn btn-primary btn-xs'>4</a>
																<a class='btn btn-primary btn-xs'>5</a>
															</td>
															<td>
																<a class='btn btn-warning btn-xs'>1</a>
																<a class='btn btn-warning btn-xs'>2</a>
																<a class='btn btn-warning btn-xs'>3</a>
																<a class='btn btn-warning btn-xs'>4</a>
																<a class='btn btn-warning btn-xs'>5</a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>";								
							}
						}
					}
					else
					{
						echo "<script>sweetAlert('No Schedule Numbers available with this VPO - ".$vpo."','','warning')</script>";
					}					
				}
			?>
		</div>
	</div>
</body>
</html>