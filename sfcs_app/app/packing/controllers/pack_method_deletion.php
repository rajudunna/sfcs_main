<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'pack_method_deletion.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.mini_order_report.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
	}

</script>
</head>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Pack Method Deletion</b></div>
	<div class="panel-body">
	<?php
	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
	    $schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
				echo "<form name=\"mini_order_report\" action=\"#\" method=\"post\" >";
				echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required>";
						$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value='' selected>Select Style</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
						echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
					?>

					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  required>";
						$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value='' selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit" style="margin-top: 18px;">
					<input type="submit" name="clear" value="Delete All" class="btn btn-success" style="margin-top: 18px;">
                 </div>
				</form>
		<div class="col-md-12">
			<?php
			if(isset($_POST['submit']))
			{	
				if($_POST['style'] && $_POST['schedule'])
				{
					$style=$_POST['style'];
				   $schedule=$_POST['schedule'];
				   $c_ref = echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule,$link);
				   $schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);	
				   $style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link);
				   $query = "SELECT * FROM $bai_pro3.pac_stat_log WHERE style = '$style' AND SCHEDULE = '$schedule_original'";
				   //echo $query;
				   $new_result = mysqli_query($link, $query) or exit("Sql Error366".mysqli_error($GLOBALS["___mysqli_ston"]));

				echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr>
									<th>S.No</th>
									<th>Packing Method</th>
									<th>Color</th>
									<th>Carton Quantity</th>
									<th>Schedule</th>
									<th>Controlls</th></tr>";
								while($new_result1=mysqli_fetch_array($new_result))
								{
								
									$seq_no1[]=$pack_result1['seq_no'];
									$packmetod=$new_result1['pack_method'];
									$staus=$new_result1['status'];
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><td>".$new_result1['seq_no']."</td>";
									echo"<td>".$operation[$packmetod]."</td>";
									echo"<td>".$new_result1['color']."</td>";
									echo"<td>".$new_result1['carton_act_qty']."</td>";
									echo"<td>".$new_result1['schedule']."</td>";
									$url=getFullURL($_GET['r'],'pack_method_deletion.php','N');
									if($staus != "done"){
									echo "<td><a href=$url&pack_method='".$new_result1['pack_method']."'&seq_no='".$new_result1['seq_no']."'&tid='".$new_result1['tid']."'>Delete</td>";
									}
									else{
										echo "<td>Already Scanned</td>";
	
									}
									echo "<tr>";
									
								}	
							
							echo "</table></div>";
									
							
				}
				
				
				
			}
            if($_GET['pack_method'] && $_GET['seq_no'] && $_GET['tid'])
				{
				 $packmethod = $_GET['pack_method'];
				 //echo $packmethod;
				 $seqno = $_GET['seq_no'];
				 $tid = $_GET['tid'];
				 $op_code = "SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_name = 'Carton Packing'";
				 $op_code_result=mysqli_query($link, $op_code) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                 $row = mysqli_fetch_row($op_code_result);
				 $deletepackmethod = "DELETE FROM $bai_pro3.pac_stat_log WHERE seq_no = $seqno and pack_method =  $packmethod";
				 echo $deletepackmethod;
				 $sql_result=mysqli_query($link, $deletepackmethod) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(! $sql_result ) {
				    die('Could not delete data: ' . mysql_error());
							  }
				 $deletemo = "DELETE FROM $bai_pro3.mo_operation_quantites WHERE mo_no = $tid AND op_code = $row[0];";
				 $sql_result=mysqli_query($link, $deletemo) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				 if(! $sql_result ) {
					 die('Could not delete data: ' . mysql_error());
								}
					   echo '<script>swal("Packing List Deleted Sucessfully","","warning")</script>';
			    }
			  
				


				if(isset($_POST['clear']))
			{	
				if(isset($_POST['style'])  && isset($_POST['schedule']) && $_POST['style'] != '' && $_POST['schedule'] != '')
				{
				   $style=$_POST['style'];
				   $schedule=$_POST['schedule'];
				// echo $_POST['style']."----". $_POST['schedule'];
				$c_ref = echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule,$link);
				$schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
				$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link);
				$query = "SELECT * FROM $bai_pro3.pac_stat_log WHERE style = '$style' AND SCHEDULE = '$schedule_original'";
				$new_result = mysqli_query($link, $query) or exit("Sql Error366".mysqli_error($GLOBALS["___mysqli_ston"]));
				//$pack_meth_qry="SELECT s.seq_no,s.pack_method,s.pack_description FROM $bai_pro3.tbl_pack_ref p LEFT JOIN $bai_pro3.tbl_pack_size_ref s ON s.`parent_id`=p.`id` 
				//WHERE p.ref_order_num=$schedule GROUP BY s.pack_method";
				//$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($pack_result1=mysqli_fetch_array($new_result))
								{
									 $seqno[] =  $pack_result1['seq_no'];
									 $packmethod[] =  $pack_result1['pack_method'];
									 $tid[] =  $pack_result1['tid'];
									 //$schedule[] =  $pack_result1['schedule'];
								 
								}	
				$sqno = implode(",",$seqno);
				$packmethod =  implode(",",$packmethod);
				$otid =  implode(",",$tid);
				echo $otid;
				$op_code = "SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_name = 'Carton Packing'";
				 $op_code_result=mysqli_query($link, $op_code) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                 $row = mysqli_fetch_row($op_code_result);
				$deletepackmethod1 = "DELETE FROM $bai_pro3.pac_stat_log WHERE seq_no in ($sqno) and pack_method in ($packmethod)";
				//echo $deletepackmethod1;
				die();
			    $sql_result=mysqli_query($link, $deletepackmethod1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(! $sql_result ) {
				 die('Could not delete data: ' . mysql_error());
				 }
				$deletemo = "DELETE FROM $bai_pro3.mo_operation_quantites WHERE mo_no in ($otid) AND op_code = $row[0];";
				$sql_result=mysqli_query($link, $deletemo) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(! $sql_result ) {
					die('Could not delete data: ' . mysql_error());
							   }
				echo '<script>swal("Packing List Deleted Sucessfully","","warning")</script>';			   
			
			 }	
				 		

			}
			?> 
		</div>
	</div>
</div>