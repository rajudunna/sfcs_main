
<?php //include("menu_content.php"); The conents were not used here?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'session_track.php',0,'R') );    ?>
<?php 

// $view_access=user_acl("SFCS_0243",$username,1,$group_id_sfcs);
?>

<script type="text/javascript">
	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

	function pop_check(){
		var sch=document.getElementById('schedule').value;
		if(sch == '' )
		{
		sweetAlert('Please enter Schedule Number','','warning');
		return false;
		}
		else
		{
			return true;
		}
	}
		
</script>



<div class="panel panel-primary">
	<div class="panel-heading">Delete Packing List</div>
	<div class = "panel-body">
		<form method="post" name="input" action="index.php?r=<?php echo $_GET['r']; ?>">
		<div class="row">
		<div class="col-md-3">
		<label>Enter Schedule Number: </label>
		<input type="text" id="schedule" name="schedule"  onkeypress="return validateQty(event);" required value="" class="form-control textbox" />
		</div>
		<input type="submit" id="submit" style="margin-top:22px;" name="submit" class="btn btn-danger confirm-submit"  onclick='return pop_check()' value="Delete">
		</div>
		</form>



		<?php

		if(isset($_POST['submit']))
		{
			
			$schedule=$_POST['schedule'];
			$count = 0;
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqlii_error());
			//$resultant_array = [];
			$$total_order_qtys = 0;
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				foreach ($sizes_array as $key => $value)
				{
					$order = 'order_s_'.$sizes_array[$key];
					$total_order_qtys += $sql_row[$order];
				} 
				

			}
						
			$sql="select tid as \"tid_db\", coalesce(carton_act_qty,0) as \"tot_carton_qty\" from $bai_pro3.packing_summary where order_del_no in ($schedule)";
			$tid_db=array();
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
			$count=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$tid_db[]=$sql_row['tid_db'];
				$tot_carton_qty=$sql_row['tot_carton_qty'];
			}
			
			$sql="select * from $bai_pro3.packing_summary where order_del_no in ($schedule) and status=\"DONE\"";
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
			$done_count=mysqli_num_rows($sql_result);
			
			echo "<div class='col-md-6 col-sm-offset-3'><table class='table table-bordered' style='width:365px;'>";
			echo "<tr><td style='width:185px;'><b>Carton Qty</b></td><td>".$tot_carton_qty."</td></tr>";
			echo "<tr><td><b>Order Qty</b></td><td>".$total_order_qtys."</td></tr>";
			echo "<tr><td><b>Scanned</b></td><td>".$done_count."</td></tr>";
			echo "</table></div>";
			
			if(($total_order_qtys!=$tot_carton_qty or $total_order_qtys==$tot_carton_qty) and $tot_carton_qty!=0 and $done_count==0)
			{
				$sql="insert ignore into $bai_pro3.pac_stat_log_deleted select * from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
				mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
				
				$sql="delete from $bai_pro3.pac_stat_log where tid in (".implode(",",$tid_db).")";
				mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
				
				$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL, ratio_packing_method='' where order_del_no in ($schedule)";
				mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
				
				$sql="update $bai_pro3.bai_orders_db set carton_id=0, carton_print_status=NULL, ratio_packing_method='' where order_del_no in ($schedule)";
				mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
				
				//echo "<h2><font color=green>Successfully Done</font></h2>";
				echo "<table class='table table-bordered'><tr class='success'><td align='center'>Successfully Done</td></tr></table>";
			}
			else
			{
				if($tot_carton_qty==0 and $done_count==0)
				{
					$sql="update $bai_pro3.bai_orders_db_confirm set carton_id=0, carton_print_status=NULL where order_del_no in ($schedule)";
					mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
					
					$sql="update $bai_pro3.bai_orders_db set carton_id=0, carton_print_status=NULL where order_del_no in ($schedule)";
					mysqli_query($link,$sql) or exit("Sql Error".mysqli_error());
				}
				echo "<table class='table table-bordered'><tr class='danger'><td align='center'>Some thing was wrong!! <br> Packing List Not Generated or Packing List Already Deleted</td></tr></table>";
			}
			
				
		}

		?>
	</div>
</div>
