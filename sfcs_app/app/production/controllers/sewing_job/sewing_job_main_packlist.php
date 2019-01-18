<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
	<style>
		#loading-image
		{
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

	<div class="ajax-loader" id="loading-image">
	    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
	</div>
<?php

	set_time_limit(30000000); 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/mo_filling.php',4,'R'));
	// $carton_id=$_GET["id"];
	$schedule=$_GET["schedule"];
	$seq_no=$_GET["seq_no"];
	$carton_method=$_GET['pac_method'];
	if($carton_method==1)
	{
		$sql123="SELECT pac_stat_input.`schedule`,pac_stat_input.`style` ,pac_stat_input.`mix_jobs`, pac_stat_input.`pack_method` AS sew_pack_method,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM bai_pro3.`tbl_pack_ref` LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` LEFT JOIN bai_pro3.`pac_stat_input` ON tbl_pack_ref.`schedule`= pac_stat_input.`schedule` AND tbl_pack_size_ref.`seq_no`=pac_stat_input.`pac_seq_no`WHERE pac_stat_input.schedule='$schedule' AND pac_stat_input.pac_seq_no='$seq_no' GROUP BY COLOR order by ref_size_name";
	}
	elseif($carton_method==2)
	{		
		$sql123="SELECT pac_stat_input.`schedule`,pac_stat_input.`style` ,pac_stat_input.`mix_jobs`, pac_stat_input.`pack_method` AS sew_pack_method,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM bai_pro3.`tbl_pack_ref` LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` LEFT JOIN bai_pro3.`pac_stat_input` ON tbl_pack_ref.`schedule`= pac_stat_input.`schedule` AND tbl_pack_size_ref.`seq_no`=pac_stat_input.`pac_seq_no`WHERE pac_stat_input.schedule='$schedule' AND pac_stat_input.pac_seq_no='$seq_no' order by ref_size_name";		
	}
	elseif($carton_method==3)
	{
		$sql123="SELECT pac_stat_input.`schedule`,pac_stat_input.`style` ,pac_stat_input.`mix_jobs`, pac_stat_input.`pack_method` AS sew_pack_method,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM bai_pro3.`tbl_pack_ref` LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` LEFT JOIN bai_pro3.`pac_stat_input` ON tbl_pack_ref.`schedule`= pac_stat_input.`schedule` AND tbl_pack_size_ref.`seq_no`=pac_stat_input.`pac_seq_no`WHERE pac_stat_input.schedule='$schedule' AND pac_stat_input.pac_seq_no='$seq_no'";
	}
	elseif($carton_method==4)
	{
		$sql123="SELECT pac_stat_input.`schedule`,pac_stat_input.`style` ,pac_stat_input.`mix_jobs`, pac_stat_input.`pack_method` AS sew_pack_method,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM bai_pro3.`tbl_pack_ref` LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` LEFT JOIN bai_pro3.`pac_stat_input` ON tbl_pack_ref.`schedule`= pac_stat_input.`schedule` AND tbl_pack_size_ref.`seq_no`=pac_stat_input.`pac_seq_no`WHERE pac_stat_input.schedule='$schedule' AND pac_stat_input.pac_seq_no='$seq_no' group by color";
	}
	//echo $sql123."<br>";
	$cols_tot_tmp=array();
	$result121=mysqli_query($link, $sql123) or die ("Error11.1=".$sql123.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$cols_tot_tmp[]=$row121['cols'];
		$sew_pack_method=$row121['sew_pack_method'];
		$merge_status=$row121["mix_jobs"];
		$schedule=$row121["schedule"];
		$style=$row121["style"];
	}
	$in_query = "Insert into $bai_pro3.sewing_jobs_ref (style,schedule,log_time,bundles_count) values 
					('$style','".$schedule."-".$carton_method."','".date('Y-m-d H:i:s')."',0)";	
	$in_result = mysqli_query($link,$in_query) or exit('Unable to insert into the sewing job ref');		
	if($in_result)
		$inserted_id = mysqli_insert_id($link);
	$qty_tmp=0;

	if($merge_status==1)
	{
		echo '<h4>Pack Method: <span class="label label-info">'.$operation[$sew_pack_method].'</span></h4>';
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
		$cols_tot=array();
		if($sew_pack_method==1 || $sew_pack_method==2)
		{
			$status_check=1;
			$input_job_no_tmp_new= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
			if ($input_job_no_tmp_new == '' or $input_job_no_tmp_new == null or $input_job_no_tmp_new == 0)
			{
				$status_check=1;
			}
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				// Normal
					$sql1y="SELECT size_title FROM $bai_pro3.`tbl_pack_ref` LEFT JOIN $bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE SCHEDULE='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."') order by ref_size_name*1";
					// $sql1y="SELECT size_title FROM brandix_bts.tbl_carton_ref LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
					$resulty=mysqli_query($link, $sql1y) or die ("Error1.51=".$sql1y.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1y=mysqli_fetch_array($resulty))
					{				
						$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
						for($ii=0;$ii<sizeof($cols_tot);$ii++)
						{			
							if($status_check=='1')
							{
								$input_job_no=1;
							}
							else
							{
								$input_job_no=$input_job_no_tmp;
							}
							$rand=$schedule.date("ymd").$input_job_no;
							$sql1="SELECT * 
									FROM bai_pro3.`tbl_pack_ref` 
									LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
									LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
									WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."') and size_title='".$row1y['size_title']."'";
							// $sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$cols_tot[$ii]."' and size_title='".$row1y['size_title']."'";
							$result1=mysqli_query($link, $sql1) or die ("Error145.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row1=mysqli_fetch_array($result1))
							{
								$input_job_quantiy_tmp=0;
								$color_code=$row1['color'];
								$size_ref=$row1['ref_size_name'];
								$size_tit=$row1['size_title'];
								$split_qty=$row1['bundle_qty'];
								$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
								$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
								// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' AND mini_order_num=1 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1";
								$sql12="SELECT * 
										FROM $bai_pro3.tbl_docket_qty 
										LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
										LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
										WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=1 and color='".$color_code."' and size='".$size_tit."' and doc_no='".$docs_new[$iiii]."' group BY cut_no order by cut_no*1";
								$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row12=mysqli_fetch_array($result12)) 
								{ 
									$qty_tmp=0;
									$docket_number=$row12["doc_no"]; 
									$qty=$row12["plan_qty"]-$row12["fill_qty"];
									if($qty>0 && $garments_per_carton>0)
									{												
										do
										{	
											if(($garments_per_carton-$input_job_quantiy_tmp)<=$qty)
											{
												$qty_new=$garments_per_carton-$input_job_quantiy_tmp;
												$qty=$qty-$qty_new;
												if($split_qty>0)
												{	
													do
													{
														if($qty_new<=$split_qty)
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
															$qty_tmp=$qty_tmp+$qty_new;
															$qty_new=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty_tmp=$qty_tmp+$split_qty;
															$qty_new=$qty_new-$split_qty;
														}
														
													}while($qty_new>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
													$qty_tmp=$qty_tmp+$qty_new;
													$qty_new=0;
												}
												$input_job_no++;
												$rand=$schedule.date("ymd").$input_job_no;
												$input_job_quantiy_tmp=0;
											}
											else
											{
												$input_job_quantiy_tmp+=$qty;
												if($split_qty>0)
												{	
													do
													{
														if($qty<=$split_qty)
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
															$qty_tmp=$qty_tmp+$qty;
															$qty=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
															mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty_tmp=$qty_tmp+$split_qty;
															$qty=$qty-$split_qty;
														}
														
													}while($qty>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
													$qty_tmp=$qty_tmp+$qty;
													$qty=0;
												}																				
											} 
										}while($qty>0);	
										$garments_per_carton=$garments_per_carton-$qty_tmp;												
										$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty_tmp) WHERE type='1' and doc_no='".$docket_number."' AND size='".$size_tit."' and type='1'";
										mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
										$qty_tmp=0;

									}
								}
							}					
						}				
						$status_check=0;
					}
				// Normal

				// Sample
					$input_job_no=0;
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and color in ('".implode("','",$cols_tot)."') group BY cut_no order by cut_no*1,ref_size*1";
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{  
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\",'$inserted_id')";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
							mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						}	
					}
				// Sample

				// Excess
					$input_job_no=0;
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and  order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY cut_no order by cut_no*1,ref_size*1";
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{ 
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\",'$inserted_id')";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
							mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				// Excess
				unset($cols_tot);
			}
		}
		else if($sew_pack_method==3 || $sew_pack_method==4)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				// Normal
					$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
					$sql1232="SELECT color FROM $bai_pro3.`tbl_docket_qty` LEFT JOIN $bai_pro3.pac_stat_input ON tbl_docket_qty.`pac_stat_input_id`=pac_stat_input.`id` WHERE color IN ('".implode("','",$cols_tot)."') and SCHEDULE='$schedule' and type=1 AND pac_seq_no='$seq_no' GROUP BY cut_no ";
					// $sql1232="SELECT color FROM brandix_bts.tbl_carton_ref LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY color ORDER BY color*1";
					$result12132=mysqli_query($link, $sql1232) or die ("Error1.781=".$sql1232.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row12132=mysqli_fetch_array($result12132))
					{				
						$color_code=$row12132['color'];
						$sql1="SELECT * 
								FROM bai_pro3.`tbl_pack_ref` 
								LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
								LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
								WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color ='".$color_code."' order by ref_size_name*1";
						// $sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$color_code."' GROUP BY size_title ORDER BY ref_size_name*1";
						$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row1=mysqli_fetch_array($result1))
						{
							if($kk==0)
							{
								$input_job_no=1;
							}
							else
							{
								$input_job_no=$input_job_no_tmp;
							}
							$rand=$schedule.date("ymd").$input_job_no;	
							$input_job_quantiy_tmp=0;
							$size_ref=$row1['ref_size_name'];
							$size_tit=$row1['size_title'];
							$split_qty=$row1['bundle_qty'];
							$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
							$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
							// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num=1 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1";
							$sql12="SELECT * 
									FROM $bai_pro3.tbl_docket_qty 
									LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
									LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
									WHERE schedule='$schedule' and pac_seq_no=$seq_no and color='".$color_code."' and size='".$size_tit."' and doc_no='".$docs_new[$iiii]."' and type='1' group BY cut_no order by cut_no*1";
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$qty_tmp=0;
								$docket_number=$row12["doc_no"]; 
								$qty=$row12["plan_qty"]-$row12["fill_qty"];
								if($qty>0  && $garments_per_carton>0)
								{
									do
									{	
										if(($garments_per_carton-$input_job_quantiy_tmp)<=$qty)
										{
											$qty_new=$garments_per_carton-$input_job_quantiy_tmp;
											$qty=$qty-$qty_new;
											if($split_qty>0)
											{	
												do
												{
													if($qty_new<=$split_qty)
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
														$qty_tmp=$qty_tmp+$qty_new;
														$qty_new=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty_tmp=$qty_tmp+$split_qty;
														$qty_new=$qty_new-$split_qty;
													}
													
												}while($qty_new>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
												$qty_tmp=$qty_tmp+$qty_new;
												$qty_new=0;
											}
											$input_job_no++;
											$rand=$schedule.date("ymd").$input_job_no;
											$input_job_quantiy_tmp=0;
										}
										else
										{
											$input_job_quantiy_tmp+=$qty;
											if($split_qty>0)
											{	
												do
												{
													if($qty<=$split_qty)
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
														$qty_tmp=$qty_tmp+$qty;
														$qty=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
														mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty_tmp=$qty_tmp+$split_qty;
														$qty=$qty-$split_qty;
													}
													
												}while($qty>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id')";
												mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
												//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
												$qty_tmp=$qty_tmp+$qty;
												$qty=0;
											}																				
										} 
									}while($qty>0);
									$garments_per_carton=$garments_per_carton-$qty_tmp;												
									$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty_tmp) WHERE type='1' and doc_no='".$docket_number."' AND size='".$size_tit."'";
									mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
									$qty_tmp=0;									
								}
								
							}	
						}			
					}
				// Normal

				// Sample
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and color in ('".implode("','",$cols_tot)."') group BY doc_no order by ref_size*1";
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\",'$inserted_id')";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
							mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				// Sample

				// Excess
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY doc_no order by ref_size*1";
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\",'$inserted_id')";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
							mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				// Excess
				unset($cols_tot);
			}
		}
	}
	else if($merge_status==2)
	{
		$docs_new=array();
		$docs_new_o=array();
		$docs_cut=array();
		$docs_newtmp=array();
		$docs_cuttmp=array();
		echo "<h3><font face='verdana' color='green'>Generating Sewing Jobs with Pack Method: <span class='label label-info'>".$operation[$sew_pack_method]."</span></font></h3>";
		// $url2=getFullURL($_GET['r'],'create_sewing_job_packlist.php','N');
		// echo "<a class='btn btn-warning	pull-right' style='padding-top: 0px;' href='$url2&style=$style&schedule=$schedule' >Go Back</a>";
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
		$input_job_no_tmp_new= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
		if ($input_job_no_tmp_new == '' or $input_job_no_tmp_new == null or $input_job_no_tmp_new == 0)
		{
			$status_sew=1;
		}		
		$cols_tot=array();
		if($sew_pack_method==1 || $sew_pack_method==2)
		{
			//echo sizeof($cols_tot_tmp)."<br>";
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				//echo $cols_tot_tmp[$kk]."<br>";
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				// Normal
				$sql1y="SELECT size_title FROM $bai_pro3.`tbl_pack_ref` LEFT JOIN $bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE SCHEDULE='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
				//echo $sql1y."<br>";
				$resulty=mysqli_query($link, $sql1y) or die ("Error1uu=".$sql1y.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1y=mysqli_fetch_array($resulty))
				{
					for($ik=0;$ik<sizeof($cols_tot);$ik++)
					{						
						$sql129="SELECT cut_no as cut,group_concat(DISTINCT doc_no ORDER BY doc_no) as doc FROM $bai_pro3.`tbl_docket_qty` LEFT JOIN $bai_pro3.pac_stat_input ON tbl_docket_qty.`pac_stat_input_id`=pac_stat_input.`id` WHERE color='".$cols_tot[$ik]."' AND size='".$row1y['size_title']."' and SCHEDULE='$schedule' AND pac_seq_no='$seq_no' GROUP BY cut_no ";
						//echo $sql129."<br>";
						$result1219=mysqli_query($link, $sql129) or die ("Error1.1=".$sql129.mysqli_error($GLOBALS["___mysqli_ston"]));
						$temp_val='';
						while($row1219=mysqli_fetch_array($result1219))
						{
							$docs_new[]=$row1219['doc'];
							$docs_cut[]=$row1219['cut'];
							$temp_val .= $row1219['cut'].",";
							if(sizeof(explode(",",$row1219['doc']))>1)
							{
								for($j=1;$j<sizeof(explode(",",$row1219['doc']));$j++)
								{
									$temp_val .= $row1219['cut'].",";
								}
							}
							$docs_cuttmp[]=substr($temp_val,0,-1);
							$temp_val='';
						}
						$sql12="SELECT * 
						FROM bai_pro3.`tbl_pack_ref` 
						LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
						LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
						WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color='".$cols_tot[$ik]."' and size_title='".$row1y['size_title']."'";
						$result12=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql1.'<br>';
						$qty_update=0;
						while($row12=mysqli_fetch_array($result12))
						{
							$color_code=$row12['color'];
							$size_ref=$row12['ref_size_name'];
							$size_tit=$row12['size_title'];
							$split_qty=$row12['bundle_qty'];
							$garments_per_carton_full_tmp=$row12['garments_per_carton']*$row12['pack_job_per_pack_method'];
							$garments_per_carton_tmp=$row12['garments_per_carton']*$row12['no_of_cartons'];
							$limit_sewing_job_tmp=ceil($row12['pack_job_per_pack_method']/$row12['no_of_cartons']);				
						}
						$destination=echo_title("$bai_pro3.bai_orders_db_confirm","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);						
						//echo $limit_sewing_job_tmp."<br>";
						for($ij=1;$ij<=$limit_sewing_job_tmp;$ij++)
						{
							if($garments_per_carton_full_tmp>0)
							{
								if(($garments_per_carton_full_tmp-$garments_per_carton_tmp)>0)
								{	
									$garments_per_cartons[$ij]=$garments_per_carton_tmp;
									$garments_per_carton_full_tmp=$garments_per_carton_full_tmp-$garments_per_carton_tmp;
									
								}
								else
								{
									$garments_per_cartons[$ij]=$garments_per_carton_full_tmp;
									$garments_per_carton_full_tmp=0;
								}
							}								
						}
						if($status_sew==1)
						{
							$input_job_no=1;
							$job_counter= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(barcode_sequence AS DECIMAL))+1","input_job_no='1' and order_del_no",$schedule,$link);	
							if($job_counter==0)
							{
								$job_counter=1;
							}
						}
						else
						{
							$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
							$input_job_no=$input_job_no_tmp;
							$job_counter=1;
							$input_job_no_tmpn= echo_title("$bai_pro3.packing_summary_input","MIN(CAST(input_job_no AS DECIMAL))","size_code='".$row1y['size_title']."' and pac_seq_no = $seq_no and order_col_des in ('".str_replace(",","','",implode(",",$cols_tot))."') and order_del_no",$schedule,$link);
							if($input_job_no_tmpn>0)
							{
								$job_counter_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(barcode_sequence AS DECIMAL))+1","input_job_no='".$input_job_no_tmpn."' and order_del_no",$schedule,$link);
								$input_job_no=$input_job_no_tmpn;
								$job_counter = $job_counter_tmp;
							}
						}
						$rand=$schedule.date("ymd").$input_job_no;
						for($iii=1;$iii<=$limit_sewing_job_tmp;$iii++)
						{	
							$garments_per_carton=$garments_per_cartons[$iii];
							for($iiii=0;$iiii<sizeof($docs_new);$iiii++)
							{						
								$qty_update=0;							
								$qty_tmp=0;									
								$sql12="SELECT * FROM $bai_pro3.tbl_docket_qty LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size  WHERE type=1 and color='".$color_code."' and doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."'";
								//echo $sql12."<br>";
								$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								if (mysqli_num_rows($result12) > 0)
								{
									while($row12=mysqli_fetch_array($result12)) 
									{ 
										$docket_number=$row12["doc_no"]; 
										$qty=$row12["plan_qty"]-$row12["fill_qty"];
										if($qty>0 && $garments_per_carton>0)
										{
											do
											{	
												if($garments_per_carton<=$qty)
												{
													$qty_new=$garments_per_carton;
													$qty=$qty-$qty_new;
													if($split_qty>0)
													{	
														do
														{
															if($qty_new<=$split_qty)
															{
																$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
																mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
																// echo "<tr><td>1 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."===".$garments_per_carton."</td></tr>";
																$qty_tmp=$qty_tmp+$qty_new;
																$qty_new=0;
																$job_counter++;
															}
															else
															{
																$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
																mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
																// echo "<tr><td>2 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."===".$garments_per_carton."</td></tr>";
																$qty_tmp=$qty_tmp+$split_qty;
																$qty_new=$qty_new-$split_qty;
																$job_counter++;
															}
															
														}while($qty_new>0);
														$garments_per_carton=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														// echo "<tr><td>3 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."===".$garments_per_carton."</td></tr>";
														$qty_tmp=$qty_tmp+$qty_new;
														$qty_new=0;
														$garments_per_carton=0;
													}
													$qty=0;
													$input_job_no++;
													$job_counter=1;
													$rand=$schedule.date("ymd").$input_job_no;
													$input_job_quantiy_tmp=0;
												}
												else
												{
													if($split_qty>0)
													{	
														do
														{
															if($qty<=$split_qty)
															{
																$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
																mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
																// echo "<tr><td>4 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."===".$garments_per_carton."</td></tr>";
																$garments_per_carton=$garments_per_carton-$qty;
																$qty_tmp=$qty_tmp+$qty;
																$qty=0;
																$job_counter++;
															}
															else
															{
																$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
																mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
																// echo "<tr><td>5 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."===".$garments_per_carton."</td></tr>";
																$qty_tmp=$qty_tmp+$split_qty;
																$garments_per_carton=$garments_per_carton-$split_qty;
																$qty=$qty-$split_qty;
																$job_counter++;
															}
															
														}while($qty>0);
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
														mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
														// echo "<tr><td>6 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."===".$garments_per_carton."</td></tr>";
														$qty_tmp=$qty_tmp+$qty;
														$garments_per_carton=$garments_per_carton-$qty;
														$qty=0;
														$job_counter++;
													}													
													$input_job_no++;
													$job_counter=1;
													$rand=$schedule.date("ymd").$input_job_no;
												}		
											}while($qty>0 && $garments_per_carton>0);
											
											$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty_tmp) WHERE doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."' and type='1'";
											$qty_tmp=0;
											mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));		
										}
									}
								}
							}														
						}
						unset($docs_new);
						unset($docs_cut);
					}
					$status_sew=0;
				}
				//Sample
				$input_job_no=0;
				$sql120="SELECT doc_no 
						FROM $bai_pro3.tbl_docket_qty 
						LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
						LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
						WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
				$result1210=mysqli_query($link, $sql120) or die ("Error1.12=".$sql120.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['doc_no'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{					
						//Excess Pieces Execution
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and  order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						$sql12="SELECT * 
								FROM $bai_pro3.tbl_docket_qty 
								LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
								LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
								WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1, ref_size*1";
						$job_counter=1;
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["doc_no"]; 
							$qty=$row12["plan_qty"]-$row12["fill_qty"];
							if($qty>0)
							{		
								$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\",'$inserted_id','$job_counter')";
								mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
								// echo "<tr><td>sample = ".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
								$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
								mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								$job_counter++;
							}
						}
					}
				}
				unset($docs_new_o);
				
				//Excess
				$input_job_no=0;
				$sql120="SELECT doc_no 
					FROM $bai_pro3.tbl_docket_qty 
					LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
					LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
					WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
				$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql120.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['doc_no'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					$job_counter=1;
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{					
						//Excess Pieces Execution
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and  order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						$sql12="SELECT * 
								FROM $bai_pro3.tbl_docket_qty 
								LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
								LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
								WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1, ref_size*1";
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["doc_no"]; 
							$qty=$row12["plan_qty"]-$row12["fill_qty"]; 
							if($qty>0)
							{	
								$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\",'$inserted_id','$job_counter')";
								mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
								// echo "<tr><td>excess = ".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
								$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
								mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								$job_counter++;
							}
						}
					}
				}
				unset($docs_new_o);
				unset($cols_tot);					
			}
		}
		else if($sew_pack_method==3 || $sew_pack_method==4)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				for($ik=0;$ik<sizeof($cols_tot);$ik++)
				{	
					$sql1="SELECT * 
					FROM bai_pro3.`tbl_pack_ref` 
					LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
					LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
					WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color='".$cols_tot[$ik]."' ORDER BY ref_size_name*1";
					// echo $sql1."<br>";
					$result1=mysqli_query($link, $sql1) or die ("Error17.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1=mysqli_fetch_array($result1))
					{
						$color_code=$row1['color'];
						$size_ref=$row1['ref_size_name'];
						$size_tit=$row1['size_title'];
						$split_qty=$row1['bundle_qty'];
						$garments_per_carton_full_tmp=$row1['garments_per_carton']*$row1['pack_job_per_pack_method'];
						$garments_per_carton_tmp=$row1['garments_per_carton']*$row1['no_of_cartons'];
						$limit_sewing_job_tmp=ceil($row1['pack_job_per_pack_method']/$row1['no_of_cartons']);	
						$sql129="SELECT cut_no as cut,group_concat(DISTINCT doc_no ORDER BY doc_no) as doc FROM $bai_pro3.`tbl_docket_qty` LEFT JOIN $bai_pro3.pac_stat_input ON tbl_docket_qty.`pac_stat_input_id`=pac_stat_input.`id` WHERE color='".$cols_tot[$ik]."' AND size='".$row1['size_title']."' and SCHEDULE='$schedule' and type=1 AND pac_seq_no='$seq_no' GROUP BY cut_no ";
						// echo "$sql129 <br>";
						$result1219=mysqli_query($link, $sql129) or die ("Error1.741=".$sql129.mysqli_error($GLOBALS["___mysqli_ston"]));
						$temp_val='';
						while($row1219=mysqli_fetch_array($result1219))
						{
							$docs_new[]=$row1219['doc'];
							$docs_cut[]=$row1219['cut'];
						}								
						for($ij=1;$ij<=$limit_sewing_job_tmp;$ij++)
						{
							if($garments_per_carton_full_tmp>0)
							{
								if(($garments_per_carton_full_tmp-$garments_per_carton_tmp)>0)
								{	
									$garments_per_cartons[$ij]=$garments_per_carton_tmp;
									$garments_per_carton_full_tmp=$garments_per_carton_full_tmp-$garments_per_carton_tmp;
									
								}
								else
								{
									$garments_per_cartons[$ij]=$garments_per_carton_full_tmp;
									$garments_per_carton_full_tmp=0;
								}
							}								
						}
						$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
						if($status_sew==1)
						{
							$input_job_no=1;
							$job_counter= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(barcode_sequence AS DECIMAL))+1","input_job_no='1' and order_del_no",$schedule,$link);	
							if($job_counter==0)
							{
								$job_counter=1;
							}
						}
						else
						{
							$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
							$job_counter=1;
							$input_job_no=$input_job_no_tmp;
							$input_job_no_tmpn= echo_title("$bai_pro3.packing_summary_input","MIN(CAST(input_job_no AS DECIMAL))","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);
							if($input_job_no_tmpn>0)
							{
								$job_counter_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(barcode_sequence AS DECIMAL))+1","input_job_no='".$input_job_no_tmpn."' and order_del_no",$schedule,$link);
								$input_job_no=$input_job_no_tmpn;
								$job_counter=$job_counter_tmp;
							}
						}
						$rand=$schedule.date("ymd").$input_job_no;
						for($iii=1;$iii<=$limit_sewing_job_tmp;$iii++)
						{
							$garments_per_carton=$garments_per_cartons[$iii];
							for($iiii=0;$iiii<sizeof($docs_new);$iiii++)
							{								
								$sql12="SELECT * FROM $bai_pro3.tbl_docket_qty LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size  WHERE type='1' and doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."'";
								// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND color='".$color_code."' and size='".$size_ref."' and docket_number='".$docs_new[$iiii]."' group BY cut_num order by cut_num*1";
								$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row12=mysqli_fetch_array($result12)) 
								{
									$qty_tmp=0;
									$docket_number=$row12["doc_no"]; 
									$qty=$row12["plan_qty"]-$row12["fill_qty"];
									if($qty>0 && $garments_per_carton>0)
									{
										do
										{	
											if($garments_per_carton<=$qty)
											{
												$qty_new=$garments_per_carton;
												$qty=$qty-$qty_new;
												if($split_qty>0)
												{	
													do
													{
														if($qty_new<=$split_qty)
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															// echo "<tr><td>1 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."===".$garments_per_carton."</td></tr>";
															$qty_tmp=$qty_tmp+$qty_new;
															$qty_new=0;
															$job_counter++;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															// echo "<tr><td>2 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."===".$garments_per_carton."</td></tr>";
															$qty_tmp=$qty_tmp+$split_qty;
															$qty_new=$qty_new-$split_qty;
															$job_counter++;
														}
														
													}while($qty_new>0);
													$garments_per_carton=0;
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence)  values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													// echo "<tr><td>3 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."===".$garments_per_carton."</td></tr>";
													$qty_tmp=$qty_tmp+$qty_new;
													$qty_new=0;
													$garments_per_carton=0;
													$job_counter++;
												}
												$qty=0;
												$input_job_no++;
												$job_counter=1;
												$rand=$schedule.date("ymd").$input_job_no;
												$input_job_quantiy_tmp=0;
											}
											else
											{
												if($split_qty>0)
												{	
													do
													{
														if($qty<=$split_qty)
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															// echo "<tr><td>4 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."===".$garments_per_carton."</td></tr>";
															$garments_per_carton=$garments_per_carton-$qty;
															$qty_tmp=$qty_tmp+$qty;
															$job_counter++;
															$qty=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
															mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
															// echo "<tr><td>5 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."===".$garments_per_carton."</td></tr>";
															$qty_tmp=$qty_tmp+$split_qty;
															$garments_per_carton=$garments_per_carton-$split_qty;
															$qty=$qty-$split_qty;
															$job_counter++;
														}
														
													}while($qty>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\",'$inserted_id','$job_counter')";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													// echo "<tr><td>6 - ".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."===".$garments_per_carton."</td></tr>";
													$qty_tmp=$qty_tmp+$qty;
													$job_counter++;
													$garments_per_carton=$garments_per_carton-$qty;
													$qty=0;
												}													
												$input_job_no++;
												$job_counter=1;
												$rand=$schedule.date("ymd").$input_job_no;
											}		
										}while($qty>0 && $garments_per_carton>0);
										$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty_tmp) WHERE doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."' and type='1'";
										$qty_tmp=0;
										mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));		
									}
								}
							}
						}
						unset($docs_new);
						unset($docs_cut);
					}
				}				
				$status_sew=0;
				//Sample
				$sql120="SELECT doc_no FROM $bai_pro3.tbl_docket_qty 
						LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
						LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
						WHERE schedule='$schedule' and pac_seq_no=$seq_no and type='3' and color in ('".implode("','",$cols_tot)."') group BY doc_no";
				$result1210=mysqli_query($link, $sql120) or die ("Error14.1=".$sql120.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['doc_no'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					$job_counter=1;	
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and  order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						//Excess Pieces Execution
						$sql12="SELECT * 
								FROM $bai_pro3.tbl_docket_qty 
								LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
								LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
								WHERE schedule='$schedule' and pac_seq_no=$seq_no and color in ('".implode("','",$cols_tot)."') and type=3 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1, ref_size*1";
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["doc_no"]; 
							$qty=$row12["plan_qty"]-$row12["fill_qty"];
							if($qty>0)	
							{			
								$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\",'$inserted_id','$job_counter')";
								mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
								// echo "<tr><td>sample -  ".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
								$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
								mysqli_query($link, $sqlupdate) or die ("Error1.174=".$sqlupdate.mysqli_error($GLOBALS["___mysqli_ston"]));
								$job_counter++;
							}
						}
					}
				}
				unset($docs_new_o);
				//Excess
				$sql120="SELECT doc_no 
					FROM $bai_pro3.tbl_docket_qty 
					LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
					LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
					WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
				$result1210=mysqli_query($link, $sql120) or die ("Error15.1=".$sql120.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['doc_no'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					$job_counter=1;
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and  order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						//Excess Pieces Execution
						$sql12="SELECT * 
								FROM $bai_pro3.tbl_docket_qty 
								LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
								LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
								WHERE schedule='$schedule' and pac_seq_no=$seq_no and color in ('".implode("','",$cols_tot)."') and type=2 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1, ref_size*1";
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["doc_no"]; 
							$qty=$row12["plan_qty"]-$row12["fill_qty"];
							if($qty>0)
							{		
								$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id,barcode_sequence) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\",'$inserted_id','$job_counter')";
								mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
								// echo "<tr><td>excess = ".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
								$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty=(fill_qty+$qty) WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
								mysqli_query($link, $sqlupdate) or die ("Error41.1=".$sqlupdate.mysqli_error($GLOBALS["___mysqli_ston"]));							
							}
						}
					}
				}
				unset($docs_new_o);
				unset($cols_tot);
			}
		}
	}
	$job_counter=echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no='$schedule' and sref_id",$inserted_id,$link);
	//Deleting the entry from sewing jobs ref if no input job was created  --  Updating the bundle quantity after the jobs are inserted
	if($job_counter == 0){
		$delete_query = "Delete from $bai_pro3.sewing_jobs_ref where id = '$inserted_id'";
		$delete_result = mysqli_query($link,$delete_query) or exit("Problem while deleting from sewing jos ref");
		if($delete_result){
			//Deleted Successfully
		}
	}else{
		$update_query = "Update $bai_pro3.sewing_jobs_ref set bundles_count = $job_counter where id = '$inserted_id' ";
		$update_result = mysqli_query($link,$update_query) or exit("Problem while inserting to sewing jos ref");
		if($update_result){
			//Updated Successfully
		}
	}

	//----------MO FILL Function Calling  -----
	$inserted = insertMOQuantitiesSewing($schedule,$inserted_id);
	if($inserted){
		//Inserted Successfully
	}
	echo "</table>";	
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'create_sewing_job_packlist.php',0,'N')."&style=$style&schedule=$schedule';</script>");		
?> 
</div></div>
</body>