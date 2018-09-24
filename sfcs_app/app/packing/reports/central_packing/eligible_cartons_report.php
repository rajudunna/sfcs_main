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
						$sql="select * from $bai_pro3.pac_stat group by style order by style*1";
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
					$mo_no_query = "SELECT mo_no FROM $bai_pro3.pac_stat WHERE vpo = $vpo";
					// echo $mo_no_query;
					$mo_details=mysqli_query($link, $mo_no_query) or exit("Error while getting MO Details");
					
					if (mysqli_num_rows($mo_details) > 0)
					{

					}
					else
					{
						echo "<script>sweetAlert('No MO Numbers available with this VPo - ".$vpo."','','warning')</script>";
					}					
				}
			?>
		</div>
	</div>
</body>
</html>