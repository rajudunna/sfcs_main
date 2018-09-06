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
						echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" >";
						$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Style</option>";
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
						echo "<select class='form-control' name=\"schedule\" id=\"schedule\"  >";
						$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql_num_check=mysqli_num_rows($sql_result);
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
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
					<input type="submit" name="clear" value="Delete All" class="btn btn-success">
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
				// echo $_POST['style']."----". $_POST['schedule'];
				$pack_meth_qry="SELECT s.seq_no,s.pack_method,s.pack_description FROM $bai_pro3.tbl_pack_ref p LEFT JOIN $bai_pro3.tbl_pack_size_ref s ON s.`parent_id`=p.`id` 
				WHERE p.ref_order_num=$schedule GROUP BY s.pack_method";
				//echo $pack_meth_qry;
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									 $seqno[] =  $pack_result1['seq_no'];
									 $packmethod[] =  $pack_result1['pack_method'];
									 $packdescription[] = $pack_result1['pack_description'];
								 
								}	
								$sqno = implode(",",$seqno);
								$packmethod =  implode(",",$packmethod);
								//$desc =  implode(",",$packdescription);
								//echo $desc;
								$c_ref = echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule,$link);
							    $schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
							    //echo $schedule_original;
				$query = "SELECT seq_no, pack_method,schedule FROM $bai_pro3.pac_stat_log WHERE seq_no in ($sqno) AND pack_method in ($packmethod)";
				//echo $query;
				$new_result = mysqli_query($link, $query) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

				echo "<br><div class='col-md-12'>
				
							<table class=\"table table-bordered\">
								<tr>
									<th>Seq.No</th>
									<th>Packing Method</th>
									<th>Schedule</th>
									<th>Controlls</th></tr>";
								while($new_result1=mysqli_fetch_array($new_result))
								{
								
									$seq_no1[]=$pack_result1['seq_no'];
									$pack_method1[]=$pack_result1['pack_method'];
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><td>".$new_result1['seq_no']."</td>";
									echo"<td>".$new_result1['pack_method']."</td>";
									echo"<td>".$new_result1['schedule']."</td>";
                                    $url=getFullURL($_GET['r'],'pack_method_deletion.php','N');
									echo "<td><a href=$url&pack_method='".$new_result1['pack_method']."'&seq_no='".$new_result1['seq_no']."'>Delete</td>";
									echo "<tr>";
									
								}	
							
							echo "</table></div>";
							
				}
				
				
			}
            if($_GET['pack_method'] && $_GET['seq_no'])
				{
				 $packmethod = $_GET['pack_method'];
				 $seqno = $_GET['seq_no'];
				 //echo $seqno;
				 $deletepackmethod = "DELETE FROM $bai_pro3.pac_stat_log WHERE seq_no = $seqno and pack_method =  $packmethod";
			   // echo $deletepackmethod;
			     $sql_result=mysqli_query($link, $deletepackmethod) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                 if(! $sql_result ) {
				     die('Could not delete data: ' . mysql_error());
			                     }
			          echo "Deleted data successfully\n";
			    }
			  
				


				if(isset($_POST['clear']))
			{	
				if($_POST['style'] && $_POST['schedule'])
				{
					$style=$_POST['style'];
				   $schedule=$_POST['schedule'];
				// echo $_POST['style']."----". $_POST['schedule'];
				$pack_meth_qry="SELECT s.seq_no,s.pack_method,s.pack_description FROM $bai_pro3.tbl_pack_ref p LEFT JOIN $bai_pro3.tbl_pack_size_ref s ON s.`parent_id`=p.`id` 
				WHERE p.ref_order_num=$schedule GROUP BY s.pack_method";
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									 $seqno[] =  $pack_result1['seq_no'];
									 $packmethod[] =  $pack_result1['pack_method'];
									 $packdescription = $pack_result1['pack_description'];
								 
								}	
								$sqno = implode(",",$seqno);
								$packmethod =  implode(",",$packmethod);
								$c_ref = echo_title("$bai_pro3.tbl_pack_ref","id","ref_order_num",$schedule,$link);
							    $schedule_original = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
								$deletepackmethod1 = "DELETE FROM $bai_pro3.pac_stat_log WHERE seq_no in ($sqno) and pack_method in ($packmethod)";
								 echo $deletepackmethod1;
								 die();
								  //$sql_result=mysqli_query($link, $deletepackmethod) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								  if(! $sql_result ) {
									  die('Could not delete data: ' . mysql_error());
												  }
									   echo "Deleted data successfully\n";
				  }	
				  {
					  echo "Please select style and schedule";
				  }			

			}
			?> 
		</div>
	</div>
</div>