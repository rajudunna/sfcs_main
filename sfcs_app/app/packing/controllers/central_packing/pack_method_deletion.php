<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'pack_method_deletion.php','N'); ?>';
	function myFunction() {
		document.getElementById("generate").style.visibility = "hidden";
	}

	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.pack_load.style.value
	}

	function secondbox()
	{
		//alert('test');
		window.location.href =url1+"&style="+document.pack_load.style.value+"&schedule="+document.pack_load.schedule.value
	}

	
	function confirm_delete(e,t)
	{
		e.preventDefault();
		var v = sweetAlert({
			title: "Are you sure to Delete the Packing Ratio?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			buttons: ["No, Cancel It!", "Yes, I am Sure!"],
		}).then(function(isConfirm){
			if (isConfirm) {
				window.location = $(t).attr('href');
				return true;
			} else {
				sweetAlert("Request Cancelled",'','error');
				return false;
			}
		});
	}

</script>
</head>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
    $has_permission=haspermission($_GET['r']);
	error_reporting(0);
?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Pack Method Deletion</b></div>
	<div class="panel-body">
	<?php
	$check_status=0;
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
				echo "<form name=\"pack_load\" action=\"#\" method=\"post\" >";
				echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
				?>
					Style:
					<?php
						// Style
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required>";
						$sql="select style from $bai_pro3.pac_stat group by style order by style";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value='' selected>Select Style</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['style'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
						echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
					?>

					&nbsp;Schedule:
					<?php
						// Schedule
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\" required>";
						$sql="select schedule from $bai_pro3.pac_stat where style='".$style."' group by schedule order by schedule*1";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value='' selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['schedule'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['schedule']."\" selected>".$sql_row['schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['schedule']."\">".$sql_row['schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit" style="margin-top: 18px;">	
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
					$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
					$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
					$check_status = echo_title("$bai_pro3.packing_summary","count(*)","status='DONE' and order_del_no",$schedule_original,$link);			
					$query = "SELECT SUM(carton_qty) AS qty,seq_no,pack_description,pack_method,GROUP_CONCAT(DISTINCT TRIM(size_title)) AS size ,GROUP_CONCAT(DISTINCT TRIM(color)) AS color FROM bai_pro3.pac_stat 
					LEFT JOIN tbl_pack_ref ON tbl_pack_ref.schedule=pac_stat.schedule 
					LEFT JOIN tbl_pack_size_ref ON tbl_pack_ref.id=tbl_pack_size_ref.parent_id AND pac_stat.pac_seq_no=tbl_pack_size_ref.seq_no WHERE pac_stat.schedule='$schedule'	GROUP BY seq_no ORDER BY seq_no*1";
					$new_result = mysqli_query($link, $query) or exit("Sql Error366".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rowscnt=mysqli_num_rows($new_result);
					if($rowscnt > 0)
					{						
						echo "<form name=\"delete_pack\" action=\"#\" method=\"post\">";
						echo '<input type="hidden" name="style" id="style" value="'.$style.'">
                          <input type="hidden" name="schedule" id="schedule" value="'.$schedule.'">';
				
						if($check_status=='' || $check_status==NULL || $check_status==0)
						{
							?>
							<span class="label label-info">To Clear all Packing Method at a time please click Delete All </span> &nbsp;&nbsp;
							<input type="submit" name="clear" id="clear" value="Delete All" class="btn btn-danger  confirm-submit" style="margin-top: 18px;">
							<?php					
						}					
						echo "</form>";							
						echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr class='info'>
							   <th>S.No</th>
								<th>Description</th>
								<th>Packing Method</th>
								<th>Color</th>
								<th>Sizes</th>
								<th>Quantity</th>
								<th>Schedule</th>
								<th>Controlls</th></tr>";
								$i = 1;
								while($new_result1=mysqli_fetch_array($new_result))
								{
									$carton_qty_pac_stat=echo_title("$bai_pro3.pac_stat","sum(carton_qty)","schedule='".$schedule."' and pac_seq_no",$new_result1['seq_no'],$link);
								    echo "<tr><td>$i</td>";
									echo "<td>".$new_result1['pack_description']."</td>";
									echo"<td>".$operation[$new_result1['pack_method']]."</td>";
									echo"<td>".$new_result1['color']."</td>";
									echo"<td>".$new_result1['size']."</td>";
									echo"<td>".$carton_qty_pac_stat."</td>";
									echo"<td>".$schedule."</td>";
									$i++;
									$url=getFullURL($_GET['r'],'pack_method_deletion.php','N');
									if($new_result1['status'] != "DONE"){
									echo "<td><a  id='delete' class='btn btn-danger'  onclick='return confirm_delete(event,this)' href='$url&schedule=".$schedule."&seq_no=".$new_result1['seq_no']."&option=delete'>Delete</td>";
									}
									else{
										echo "<td  class='btn btn-success'>Already Scanned</td>";
									}
									echo "<tr>";
									
								}	
							
							echo "</table></div>";
					}
					else{
						echo '<script>swal("Packing List Not Generated","","warning")</script>';
					}		
				}
			}
            if($_GET['schedule'] && $_GET['seq_no'] && $_GET['option'])
			{
				$schedule = $_GET['schedule'];
				$seqno = $_GET['seq_no'];
				$ops_id=array();
				$pac_id=array();
				$pa_tids=array();
				$ops_idsql = "SELECT operation_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='PACKING'";
				$ops_id_check=mysqli_query($link,$ops_idsql);
				while($result_ops = mysqli_fetch_array($ops_id_check))
				{
					$ops_id[] = $result_ops['operation_code'];
				}
				$deletepackmethod1 = "select * FROM $bai_pro3.pac_stat WHERE pac_seq_no =$seqno and schedule = $schedule";
				$sql_result12=mysqli_query($link, $deletepackmethod1) or exit("Sql Error--1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($new_result112=mysqli_fetch_array($sql_result12))
				{
					$pac_id[]=$new_result112['id'];
				}
				$deletepackmethod2 = "select * FROM $bai_pro3.pac_stat_log WHERE  pac_stat_id in (".implode(",",$pac_id).")";
				$sql_result12=mysqli_query($link, $deletepackmethod2) or exit("Sql Error741".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($new_result112=mysqli_fetch_array($sql_result12))
				{
					$pa_tids[]=$new_result112['tid'];
				}					
				$deletepackmethod = "DELETE FROM $bai_pro3.pac_stat_log WHERE pac_stat_id in (".implode(",",$pac_id).")";
				$sql_result=mysqli_query($link, $deletepackmethod) or exit("Sql Error742".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$deletepackmethod3 = "DELETE FROM $bai_pro3.pac_stat WHERE id in (".implode(",",$pac_id).")";
				$sql_result=mysqli_query($link, $deletepackmethod3) or exit("Sql Error743".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$deletemo = "DELETE FROM $bai_pro3.mo_operation_quantites WHERE ref_no in (".implode(",",$pa_tids).") AND op_code in (".implode(",",$ops_id).")";
				$sql_result=mysqli_query($link, $deletemo) or exit("Sql Error744".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo '<script>swal("Packing List Deleted Successfully","","success")</script>';			   
			
			}
			if(isset($_POST['clear']))
			{	
				$schedule=$_POST['schedule'];
				$ops_id=array();
				$pac_id=array();
				$pa_tids=array();
				$ops_idsql = "SELECT operation_code,operation_description FROM $brandix_bts.`tbl_orders_ops_ref` WHERE category='PACKING'";
				$ops_id_check=mysqli_query($link,$ops_idsql);
				while($result_ops = mysqli_fetch_array($ops_id_check))
				{
					$ops_id[] = $result_ops['operation_code'];
				}
				$deletepackmethod1 = "select * FROM $bai_pro3.pac_stat WHERE schedule = $schedule";
				$sql_result12=mysqli_query($link, $deletepackmethod1) or exit("Sql Error745".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($new_result112=mysqli_fetch_array($sql_result12))
				{
					$pac_id[]=$new_result112['id'];
				}
				$deletepackmethod2 = "select * FROM $bai_pro3.pac_stat_log WHERE  pac_stat_id in (".implode(",",$pac_id).")";
				$sql_result12=mysqli_query($link, $deletepackmethod2) or exit("Sql Error746".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($new_result112=mysqli_fetch_array($sql_result12))
				{
					$pa_tids[]=$new_result112['tid'];
				}	
				$deletepackmethod = "DELETE FROM $bai_pro3.pac_stat_log WHERE pac_stat_id in (".implode(",",$pac_id).")";
				$sql_result=mysqli_query($link, $deletepackmethod) or exit("Sql Error747".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$deletepackmethod3 = "DELETE FROM $bai_pro3.pac_stat WHERE id in (".implode(",",$pac_id).")";
				$sql_result=mysqli_query($link, $deletepackmethod3) or exit("Sql Error748".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$deletemo = "DELETE FROM $bai_pro3.mo_operation_quantites WHERE ref_no in (".implode(",",$pa_tids).") AND op_code in (".implode(",",$ops_id).")";
				$sql_result=mysqli_query($link, $deletemo) or exit("Sql Error749".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo '<script>swal("Packing List Deleted Successfully","","success")</script>';			   
			
			}
			?> 
		</div>
	</div>
</div>