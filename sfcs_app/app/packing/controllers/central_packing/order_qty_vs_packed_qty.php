<head>
	<script language="javascript" type="text/javascript">
	
	var url1 = '<?= getFullURL($_GET['r'],'order_qty_vs_packed_qty.php','N'); ?>';
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

	function check_val()
	{
		//alert('dfsds');
		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		
		if(style == 'NIL' || schedule == 'NIL')
		{
			sweetAlert('Please select Style and Schedule','','warning');
			return false;
		}
		return true;	
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
<style>
	table, th, td {
		text-align: center;
	}

#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class="panel panel-primary">
	<div class="panel-heading"><b>Packing List Generation</b></div>
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
				echo "<form name=\"mini_order_report\" action=\"?r=".$_GET['r']."\" method=\"post\" >";
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
							if(str_replace(" ","",$sql_row['product_style'])==str_replace(" ","",$style))
							{
								echo "<option value=\"".$sql_row['product_style']."\" selected>".$sql_row['product_style']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['product_style']."\">".$sql_row['product_style']."</option>";
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
						$sql="select product_schedule from $brandix_bts.tbl_orders_master left join $brandix_bts.tbl_orders_style_ref on tbl_orders_style_ref.id=tbl_orders_master.ref_product_style where tbl_orders_style_ref.product_style='".$style."' group by product_schedule";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						echo "<option value=\"NIL\" selected>Select Schedule</option>";
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							if(str_replace(" ","",$sql_row['product_schedule'])==str_replace(" ","",$schedule))
							{
								echo "<option value=\"".$sql_row['product_schedule']."\" selected>".$sql_row['product_schedule']."</option>";
							}
							else
							{
								echo "<option value=\"".$sql_row['product_schedule']."\">".$sql_row['product_schedule']."</option>";
							}
						}
						echo "</select>";
						echo "</div>";
					?>
					&nbsp;&nbsp;
					<div class='col-md-3 col-sm-3 col-xs-12'>
					<input type="submit" name="submit" id="submit" class="btn btn-success " onclick="return check_val();" value="Submit" style="margin-top: 18px;">
					</div>
				</form>
		<div class="col-md-12">
			<?php
			if(isset($_POST['submit']) or $_GET['style'] and $_GET['schedule'])
			{
				if ($_GET['style'] and $_GET['schedule'])
				{
					$style=$_GET['style'];
					//$schedule=$_GET['schedule'];
					$schedule = $_GET['schedule'];
				} 
				else if ($_POST['style'] and $_POST['schedule'])
				{
					$style=$_POST['style'];
					//$schedule=$_POST['schedule'];
					$schedule = $_POST['schedule'];	
				}
				
				$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
				//echo "Style= ".$style."<br>Schedule= ".$schedule.'<br>';

				// Order Details Display Start
				{
					$col_array = array();
					$sizes_query = "SELECT order_col_des FROM $bai_pro3.`bai_orders_db` WHERE order_del_no=$schedule AND order_style_no='".$style."' and order_joins not in (1,2)";
					//echo $sizes_query;die();
					$sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
					$row_count = mysqli_num_rows($sizes_result);
					while($sizes_result1=mysqli_fetch_array($sizes_result))
					{
						$col_array[]=$sizes_result1['order_col_des'];
					}
					$psl_doc_array = array();	$tcm_doc_array = array();	$cols_orders_master_array = array();

					$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
					$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
					// echo $style."---".$schedule;


					$get_doc_cols_orders_master = "SELECT DISTINCT order_col_des  FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_orders_master` WHERE product_schedule='".$schedule."')";
					$cols_result=mysqli_query($link, $get_doc_cols_orders_master) or exit("Errror while getting docket from plandoc_stat_log");
					// echo $get_doc_cols_orders_master.'<br>';
					while ($rowsss=mysqli_fetch_array($cols_result))
					{
						$cols_orders_master_array[] = $rowsss['order_col_des'];
					}

					$get_doc_plandoc_stat_log = "SELECT doc_no from $bai_pro3.order_cat_doc_mk_mix	WHERE category IN ($in_categories) AND order_del_no='".$schedule."' and order_col_des in ('".implode("','",$cols_orders_master_array)."')";
					$plandoc_stat_result=mysqli_query($link, $get_doc_plandoc_stat_log) or exit("Errror while getting docket from plandoc_stat_log");
					// echo $get_doc_plandoc_stat_log.'<br>';
					while ($rows=mysqli_fetch_array($plandoc_stat_result))
					{
						$psl_doc_array[] = $rows['doc_no'];
					}

					$get_doc_tbl_cut_master = "SELECT distinct doc_num FROM $brandix_bts.`tbl_cut_size_master` LEFT JOIN $brandix_bts.`tbl_cut_master` ON tbl_cut_master.id=tbl_cut_size_master.parent_id WHERE parent_id IN (SELECT id FROM brandix_bts.`tbl_cut_master` WHERE product_schedule='".$schedule."')  AND color IN ('".implode("','",$cols_orders_master_array)."')";
					$cut_master_result=mysqli_query($link, $get_doc_tbl_cut_master) or exit("Errror while getting docket from tbl_cut_master");
					// echo $get_doc_tbl_cut_master.'<br>';
					while ($row=mysqli_fetch_array($cut_master_result))
					{
						$tcm_doc_array[] = $row['doc_num'];
					}
					$result=array_diff($psl_doc_array,$tcm_doc_array);
					// echo count($result);
					// var_dump($result);
					// die();
					if(count($result) > 0)
					{
						$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
						$result2=mysqli_query($link, $sizesMasterQuery) or ("Sql error778".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sizes_tmp=array();
						while($s=mysqli_fetch_array($result2))
						{
							for ($i=0; $i < sizeof($sizes_array); $i++)
							{
								if($s['size_name'] == $sizes_title[$i])
								{
									$sizes_tmp[]=$s['id'];
								}
							}
						}

						$productsQuery=echo_title("$brandix_bts.tbl_orders_master","id","ref_product_style='".$style_id."' and product_schedule",$schedule,$link);
						if($productsQuery>0 || $productsQuery!='')
						{
							$order_id=$productsQuery;
						}
						else
						{
							$insertOrdersMaster="INSERT INTO $brandix_bts.tbl_orders_master(ref_product_style, product_schedule,order_status) VALUES ('".$style_id."','".$schedule."', 'OPEN')";
							$result6=mysqli_query($link, $insertOrdersMaster) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$order_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
						}

						// difference in plandoc_stat_log and tbl_cut_master
						$layPlanQuery="SELECT plandoc_stat_log.*,cat_stat_log.category FROM $bai_pro3.plandoc_stat_log as plandoc_stat_log
						LEFT JOIN $bai_pro3.cat_stat_log as cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid
						WHERE cat_stat_log.category IN ($in_categories) AND  plandoc_stat_log.doc_no in (".implode(",",$result).")";
						$result7=mysqli_query($link, $layPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($result7) > 0)
						{
							while($l=mysqli_fetch_array($result7))
							{
								$order_tid = $l['order_tid'];
								$col_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_tid",$order_tid,$link);
								$color_code=echo_title("$bai_pro3.bai_orders_db_confirm","order_col_des","order_tid",$order_tid,$link);
								$doc_num=$l['doc_no'];
								$cut_num=$l['acutno'];
								$cut_status=$l['act_cut_status'];
								$planned_module=$l['plan_module'];
								if($planned_module==NULL)
								{
									$planned_module=0;
								}
								$request_time=$l['rm_date'];
								$issued_time=$l['date'];
								$planned_plies=$l['p_plies'];
								$actual_plies=$l['a_plies'];
								$plan_date=$l['date'];
								$cat_ref=$l['cat_ref'];
								$mk_ref=$l['mk_ref'];
								$cuttable_ref=$l['cuttable_ref'];
								//Insert data into layplan(tbl_cut_master) table
								$inserted_id_query1 = "select count(id) as id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
								$inserted_id_result1=mysqli_query($link, $inserted_id_query1) or ("Sql error1111");
								while($inserted_id_details1=mysqli_fetch_array($inserted_id_result1))
								{
									$layplan_id1=$inserted_id_details1['id'];
								}
								if($layplan_id1==0)
								{
									$insertLayPlanQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,request_time,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES	('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$request_time','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style_id,'$schedule',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
									$result8=mysqli_query($link, $insertLayPlanQuery) or ("Sql error999".mysqli_error($GLOBALS["___mysqli_ston"]));
									$inserted_id_query = "select id from $brandix_bts.tbl_cut_master where doc_num='".$doc_num."'";
									$inserted_id_result=mysqli_query($link, $inserted_id_query) or ("Sql error1111");
									while($inserted_id_details=mysqli_fetch_array($inserted_id_result))
									{
										$layplan_id=$inserted_id_details['id'];
									}
									//Insert data into layplan reference table (tbl_cut_size_master)
									for ($i=0; $i < sizeof($sizes_array); $i++)
									{
										if($l["p_".$sizes_array[$i].""]>0)
										{
										 	$insertLayplanItemsQuery="INSERT IGNORE INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."','".$layplan_id."','".$sizes_tmp[$i]."','".$l["p_".$sizes_array[$i].""]."')";
											 // echo $insertLayplanItemsQuery."</br>";
										 	$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										}
									}
								}
							}
						}
					}
					//echo "Style= ".$style."<br>Schedule= ".$schedule.'<br>';
					
					// Order Details Display Start
					
					$sewing_jobratio_sizes_query = "SELECT GROUP_CONCAT(DISTINCT size_title) AS size FROM brandix_bts.`tbl_orders_sizes_master` WHERE parent_id=$schedule_id";
					// echo $sewing_jobratio_sizes_query.'<br>';
					$sewing_jobratio_sizes_result=mysqli_query($link, $sewing_jobratio_sizes_query) or exit("Error while getting Job Ratio Details");
					while($sewing_jobratio_color_details=mysqli_fetch_array($sewing_jobratio_sizes_result)) 
					{
						$ref_size = $sewing_jobratio_color_details['size'];
						$size_main = explode(",",$ref_size);
						// var_dump($size);
					}
					$sizeofsizes=sizeof($size_main);

					$planned_qty = array();
					$ordered_qty = array();
					$pack_qty = array();

					echo "<br>
						<div class='col-md-12 table-responsive'>
							<table class=\"table table-bordered\">
								<tr class=\"info\">
									<th>Colors</th>
									<th>Details</th>";
									for ($i=0; $i < sizeof($size_main); $i++)
									{
										echo "<th>$size_main[$i]</th>";
									}	
									
									echo "<th>Total</th>
								</tr>";
					// echo sizeof($col_array);ssss
					for ($j=0; $j < sizeof($col_array); $j++)
					{
						$tot_ordered = 0;
						$tot_planned = 0;
						$pack_tot = 0;
						$pack_tot_saved=0;
						for($kk=0;$kk<sizeof($size_main);$kk++)
						//foreach ($sizes_array as $key => $value)
						{
							$plannedQty_query = "SELECT SUM(quantity*planned_plies) AS plannedQty FROM $brandix_bts.tbl_cut_size_master 
							LEFT JOIN $brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id 
							LEFT JOIN $brandix_bts.tbl_orders_sizes_master ON tbl_orders_sizes_master.parent_id=tbl_cut_master.ref_order_num
							WHERE tbl_cut_master.ref_order_num='$schedule_id' AND tbl_orders_sizes_master.order_col_des='$col_array[$j]' AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND tbl_cut_size_master.ref_size_name=tbl_orders_sizes_master.ref_size_name AND tbl_cut_size_master.color=tbl_orders_sizes_master.order_col_des";
							//echo $plannedQty_query.'<br>';
							$plannedQty_result=mysqli_query($link, $plannedQty_query) or exit("Sql Error2");
							while($planneQTYDetails=mysqli_fetch_array($plannedQty_result))
							{
								if($planneQTYDetails['plannedQty']=='')
								{
									$planned_qty[$col_array[$j]][$size_main[$kk]]=0;
								}
								else
								{
									$planned_qty[$col_array[$j]][$size_main[$kk]] = $planneQTYDetails['plannedQty'];
								}
							}
							$orderQty_query = "SELECT SUM(order_act_quantity) AS orderedQty FROM $brandix_bts.tbl_orders_sizes_master 
							WHERE parent_id='$schedule_id' AND tbl_orders_sizes_master.size_title='$size_main[$kk]' AND order_col_des = '$col_array[$j]'";
							//echo $orderQty_query.'<br>';
							$Order_qty_resut=mysqli_query($link, $orderQty_query) or exit("Sql Error2");
							while($orderQty_details=mysqli_fetch_array($Order_qty_resut))
							{
								if($orderQty_details['orderedQty']=='')
								{
									$ordered_qty[$col_array[$j]][$size_main[$kk]]=0;
								}
								else
								{
									$ordered_qty[$col_array[$j]][$size_main[$kk]] = $orderQty_details['orderedQty'];
								}
								
							}

							$getpack_saved_qty="SELECT SUM(garments_per_carton*pack_job_per_pack_method) AS qty FROM bai_pro3.`tbl_pack_size_ref` LEFT JOIN bai_pro3.`tbl_pack_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE schedule = '$schedule' AND color='$col_array[$j]' AND size_title='$size_main[$kk]'";
							// echo $getpack_saved_qty;
							$packqtyrslt=mysqli_query($link, $getpack_saved_qty) or exit("Error while getting parent id88");
							if($pack_row=mysqli_fetch_array($packqtyrslt))
							{
								if($pack_row['qty']=='')
								{
									$pack_qty_saved[$col_array[$j]][$size_main[$kk]]=0;
								}
								else
								{
									$pack_qty_saved[$col_array[$j]][$size_main[$kk]]=$pack_row['qty'];
								}
							}

							$getpackqty="SELECT SUM(carton_act_qty) AS pack_qty FROM $bai_pro3.packing_summary WHERE order_del_no='$schedule' AND size_tit='$size_main[$kk]' AND order_col_des='$col_array[$j]'";
							//echo $getpackqty;
							$packqtyrslt=mysqli_query($link, $getpackqty) or exit("Error while getting parent id");
							if($pack_row=mysqli_fetch_array($packqtyrslt))
							{
								if($pack_row['pack_qty']=='')
								{
									$pack_qty[$col_array[$j]][$size_main[$kk]]=0;
								}
								else
								{
									$pack_qty[$col_array[$j]][$size_main[$kk]]=$pack_row['pack_qty'];
								}
							}
						}
						// echo $col_array[$i];
						

						echo "<tr>
								<td rowspan=4>$col_array[$j]</td>
								<td>Order Qty</td>";
								for ($i=0; $i < sizeof($size_main); $i++)
								{ 
									echo "<td>".$ordered_qty[$col_array[$j]][$size_main[$i]]."</td>";
									$tot_ordered = $tot_ordered + $ordered_qty[$col_array[$j]][$size_main[$i]];
								}
								echo "<td>$tot_ordered</td>
							</tr>";

						echo "<tr>
								<td>Cut Plan Qty</td>";
								for ($i=0; $i < sizeof($size_main); $i++)
								{ 
									echo "<td>".$planned_qty[$col_array[$j]][$size_main[$i]]."</td>";
									$tot_planned = $tot_planned + $planned_qty[$col_array[$j]][$size_main[$i]];
								}
								echo "<td>$tot_planned</td>
							</tr>";

						echo "<tr>
								<td>Packing Saved Quantity</td>";
								for ($i=0; $i < sizeof($size_main); $i++)
								{									
									echo "<td>".$pack_qty_saved[$col_array[$j]][$size_main[$i]]."</td>";
									$pack_tot_saved = $pack_tot_saved + $pack_qty_saved[$col_array[$j]][$size_main[$i]];
								}
								echo "<td>$pack_tot_saved</td>
							</tr>";

						echo "<tr>
								<td>Pack Generated</td>";
								for ($i=0; $i < sizeof($size_main); $i++)
								{									
									echo "<td>".$pack_qty[$col_array[$j]][$size_main[$i]]."</td>";
									$pack_tot = $pack_tot + $pack_qty[$col_array[$j]][$size_main[$i]];
								}
								echo "<td>$pack_tot</td>
							</tr>";
					}
					echo "</table>
						</div>";
				}
				// Order Details Display End

				//packing method details
				$get_pack_id=" select id from $bai_pro3.tbl_pack_ref where schedule=$schedule AND style='".$style."'"; 
				// echo $get_pack_id;
				$get_pack_id_res=mysqli_query($link, $get_pack_id) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row = mysqli_fetch_row($get_pack_id_res);
				$pack_id=$row[0];

				

				$pack_meth_qry="SELECT *,parent_id,sum(garments_per_carton*pack_job_per_pack_method) as qnty,GROUP_CONCAT(size_title SEPARATOR '<br>') as size ,GROUP_CONCAT(color SEPARATOR '<br>') as color,seq_no,pack_method FROM $bai_pro3.tbl_pack_size_ref WHERE parent_id='$pack_id' GROUP BY seq_no order by seq_no";
				// echo $pack_meth_qry;
				// $sizes_result=mysqli_query($link, $sizes_query) or exit("Sql Error2 $sizes_query");
				$pack_meth_qty=mysqli_query($link, $pack_meth_qry) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($pack_meth_qty) > 0)
				{
					echo "<br><div class='col-md-12'>
							<table class=\"table table-bordered\">
								<tr class=\"info\">
									<th>Sequence<br>Number</th>
									<th>Packing Method</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Colors</th>
									<th>Sizes</th>
									<th>Controls</th></tr>";
								while($pack_result1=mysqli_fetch_array($pack_meth_qty))
								{
									// var_dump($operation);
									$seq_no=$pack_result1['seq_no'];
									$parent_id=$pack_result1['parent_id'];
									$pack_method=$pack_result1['pack_method'];
									// echo $pack_method;
									// $col_array[]=$sizes_result1['order_col_des'];
									echo "<tr><td>".$pack_result1['seq_no']."</td>";
									echo"<td>".$operation[$pack_method]."</td>";
									echo "<td>".$pack_result1['pack_description']."</td>";
									echo "<td>".$pack_result1['qnty']."</td>";
									echo "<td>".$pack_result1['color']."</td>";
									echo "<td>".$pack_result1['size']."</td>";
									$url=getFullURL($_GET['r'],'pack_jobs_generate.php','N');
									$url1=getFullURL($_GET['r'],'order_qty_vs_packed_qty.php','N');
									$url2=getFullURL($_GET['r'],'decentralized_packing_ratio.php','N');
									$statusqry="select * from $bai_pro3.pac_stat where schedule='$schedule' and pac_seq_no='$seq_no'";
									//echo $statusqry;
									$statusrslt=mysqli_query($link, $statusqry) or exit("Error while getting status");

									$pack_list_color = array();
									$pack_list_color = explode('<br>', $pack_result1['color']);
									$unique_colos = array_unique($pack_list_color);
									$mo_array = array();
									foreach ($unique_colos as $colo)
									{
										$mo_details_check="SELECT * FROM $bai_pro3.mo_details WHERE schedule = $schedule and color = '$colo'";
										// echo $mo_details_check.'<br>';
										$mo_details_result=mysqli_query($link, $mo_details_check) or exit("error while fetching mo details");
										$rowsCount = mysqli_num_rows($mo_details_result);
										if ($rowsCount == 0 || $rowsCount == '' || $rowsCount == null)
										{
											$mo_array[$colo] = 1;
										}
									}

									if (count($mo_array) > 0)
									{
										$cols_dont_have_mo = implode('<br>&#x2055;', array_keys($mo_array));
										echo"<td>
												<div class='alert alert-danger' style='color: white;'><strong>No MO Details Found for:</strong> <br>&#x2055;$cols_dont_have_mo </div>
											</td>";
									}
									else
									{
										if(mysqli_num_rows($statusrslt)==0)
										{
											echo "<td>
											<a class='btn btn-success generate_pack_job' href='$url&c_ref=$parent_id&pack_method=$pack_method&seq_no=$seq_no'>Generate Pack Job</a>
											<a class='btn btn-danger' onclick='return confirm_delete(event,this)' id='delete_single' href='$url1&option=delete&schedule1=$schedule&parent_id=$parent_id&seq_no=$seq_no&style1=$style'>Delete</a>
											</td>";
										}
										else
										{
											echo"<td><h4><span class='label label-success'>Packing List Generated</span></h4></td>";
										}
									}	
									echo "<tr>";
								}	
							
						echo "</table></div>";
				}
				$pack_qnty = $_GET['order_total'];
				$ordr_qnty = $_GET['ordr_qnty'];
				$url2=getFullURL($_GET['r'],'decentralized_packing_ratio.php','N');
				echo "<div class='col-md-12 col-sm-12 col-xs-12'>
				<a class='btn btn-success btn-sm' id='add_pack_method' href='$url2&schedule=$schedule&style=$style' >Add Packing Method</a>
				</div>";
			}

			if($_GET['option'])
			{
				$seq_no=$_GET['seq_no'];
				$parent_id=$_GET['parent_id'];
				$style=$_GET['style1'];
				$schedule=$_GET['schedule1'];

				$delete_pack_method="DELETE FROM bai_pro3.`tbl_pack_size_ref` WHERE parent_id=$parent_id AND seq_no=$seq_no;";
				$delete_result=mysqli_query($link, $delete_pack_method) or exit("Error while deleting pack method");
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					swal('Packing Method Deleted Successfully','','success');
					location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
					}
				</script>";	
			}
			?>
			<script type="text/javascript">
				$(document).ready(function() 
				{
					$(".generate_pack_job").click(function()
					{
						$("#loading-image").show();
					});
				});
			</script>
		</div>
	</div>
</div>