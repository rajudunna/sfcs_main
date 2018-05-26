
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R') );  ?>
<?php //include('../'.getFullURLLevel($_GET['r'],'menu_content.php',1,'R') ); this file is not being used here ?>
<?php $view_access=user_acl("SFCS_0243",$username,1,$group_id_sfcs); ?>


<script>
	function numbersOnly()
	{
	   var charCode = event.keyCode;
        if (charCode > 47 && charCode < 58)
            return true;
        else
            return false;
	}
</script>
<div class="panel panel-primary">
	<div class="panel-heading">Delete Ratio Mapping</div>
		<div class="panel-body">
		<?php
			echo '<form name="input" class="form-inline" method="post" action="'.getFullURL($_GET['r'],'delete_ratio_mapping.php','N').'"">
			<div class="form-group"><label>Schedule No:</label>&nbsp;&nbsp;<input type="text" name="schedule" value="" onkeypress="return numbersOnly(event)" class="form-control" required/></div>&nbsp;&nbsp; <input type="submit" name="submit" value="Delete Ratio Mapping" class="btn btn-danger">';
			echo '</form><br>';
		?>
		<?php
		if(isset($_POST['submit']))
		{
			$schedule=$_POST['schedule'];
				
			$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule)";
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($link));
			$row_count=mysqli_num_rows($sql_result);
			
			echo "<span class='label label-success'>Packing List Rows:".$row_count."</span><br/>";
			echo "<br>";
			if($row_count==0)
			{
				$sql="delete from $bai_pro3.ratio_input_update where schedule='$schedule'";
				mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
				//echo $sql."<br/>";
				$sql1="update $bai_pro3.bai_orders_db_confirm set carton_id='',ratio_packing_method='' where order_del_no='$schedule'";
				//echo $sql1."<br/>";
				mysqli_query($link,$sql1) or exit("Sql Error".mysqli_error());
				$sql2="update bai_pro3.bai_orders_db set carton_id='',ratio_packing_method='' where order_del_no='$schedule'";
				//echo $sql2."<br/>";
				mysqli_query($link,$sql2) or exit("Sql Error".mysqli_error());
				
				//echo "<h2><font color=green>Ratio Mapping Deleted For This Schedule ".$schedule." Successfully..</font></h2>";
				echo "<script>
						swal('Deleted','Ratio Mapping Deleted For This Schedule $schedule Successfully','success');
					 </script>";
				// echo "<table class='table table-bordered'><tr class='success'><td align='center'>Ratio Mapping Deleted For This Schedule ".$schedule." Successfully..</td></tr></table>";
			}
			else
			{
				echo "<script>
						swal('Deleted','Packing List Already Generated For This Schedule $schedule !','error');
					 </script>";
				//echo "<table class='table table-bordered'><tr class='danger'><td align='center'>Packing List Already Generated For This Schedule ".$schedule." !!</td></tr></table>";
			}
		}

		?>
		</div>
	</div>
</div>