<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
<?php

	set_time_limit(30000000); 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	// $carton_id=$_GET["id"];
	$schedule=$_GET["schedule"];
	$seq_no=$_GET["seq_no"];

	$sql12="SELECT pac_stat_input.`schedule`,pac_stat_input.`style` ,pac_stat_input.`mix_jobs`, pac_stat_input.`pack_method` AS sew_pack_method,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM bai_pro3.`tbl_pack_ref` LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` LEFT JOIN bai_pro3.`pac_stat_input` ON tbl_pack_ref.`schedule`= pac_stat_input.`schedule` AND tbl_pack_size_ref.`seq_no`=pac_stat_input.`pac_seq_no`WHERE pac_stat_input.schedule='$schedule' AND pac_stat_input.pac_seq_no='$seq_no'";

	// $sql12="SELECT merge_status,sew_pack_method,style_code,ref_order_num,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM brandix_bts.tbl_carton_ref LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE COMBO_NO>0 and tbl_carton_ref.id='".$carton_id."' GROUP BY COMBO_NO";
	$cols_tot_tmp=array();
	$result121=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$cols_tot_tmp[]=$row121['cols'];
		$sew_pack_method=$row121['sew_pack_method'];
		$merge_status=$row121["mix_jobs"];
		$schedule=$row121["schedule"];
		$style=$row121["style"];
	}

	if($merge_status==1)
	{
		echo '<h4>Pack Method: <span class="label label-info">'.$operation[$sew_pack_method].'</span></h4>';
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
		$cols_tot=array();
		if($sew_pack_method==1 || $sew_pack_method==2)
		{
			$status_check=1;
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				// Normal
					$sql1y="SELECT size_title FROM $bai_pro3.`tbl_pack_ref` LEFT JOIN $bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE SCHEDULE='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."')";
					// $sql1y="SELECT size_title FROM brandix_bts.tbl_carton_ref LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
					$resulty=mysqli_query($link, $sql1y) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1y=mysqli_fetch_array($resulty))
					{				
						$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and order_del_no",$schedule,$link);
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
							$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
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
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
															$qty_new=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty_new=$qty_new-$split_qty;
														}
														
													}while($qty_new>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
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
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
															$qty=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty=$qty-$split_qty;
														}
														
													}while($qty>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
													$qty=0;
												}																				
											} 
										}while($qty>0);	
										$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE type='1' and doc_no='".$docket_number."' AND size='".$size_tit."' and type='1'";
										mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));

									}
								}
							}					
						}				
						$status_check=0;
					}
				// Normal

				// Sample
					$input_job_no=0;
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and color in ('".implode("','",$cols_tot)."') group BY cut_no order by cut_no*1";
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{  
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\")";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
							mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						}	
					}
				// Sample

				// Excess
					$input_job_no=0;
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY cut_no order by cut_no*1";
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{ 
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\")";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
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
					$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and order_del_no",$schedule,$link);
					$sql1232="SELECT color FROM $bai_pro3.`tbl_docket_qty` LEFT JOIN $bai_pro3.pac_stat_input ON tbl_docket_qty.`pac_stat_input_id`=pac_stat_input.`id` WHERE color IN ('".implode("','",$cols_tot)."') and SCHEDULE='$schedule' and type=1 AND pac_seq_no='$seq_no' GROUP BY cut_no ";
					// $sql1232="SELECT color FROM brandix_bts.tbl_carton_ref LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY color ORDER BY color*1";
					$result12132=mysqli_query($link, $sql1232) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row12132=mysqli_fetch_array($result12132))
					{				
						$color_code=$row12132['color'];
						$sql1="SELECT * 
								FROM bai_pro3.`tbl_pack_ref` 
								LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
								LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
								WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color ='".$color_code."'";
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
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
														$qty_new=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty_new=$qty_new-$split_qty;
													}
													
												}while($qty_new>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
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
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
														$qty=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
														mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
														//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty=$qty-$split_qty;
													}
													
												}while($qty>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
												mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
												//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
												$qty=0;
											}																				
										} 
									}while($qty>0);
									$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE type='1' and doc_no='".$docket_number."' AND size='".$size_tit."'";
									mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));									
								}
								
							}	
						}			
					}
				// Normal

				// Sample
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and  pac_seq_no = $seq_no and order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\")";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
							mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				// Sample

				// Excess
					$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and order_del_no",$schedule,$link);
					$rand=$schedule.date("ymd").$input_job_no;
					//Excess Pieces Execution
					$sql12="SELECT * 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
					// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
					$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row12=mysqli_fetch_array($result12)) 
					{ 
						$docket_number=$row12["doc_no"]; 
						$qty=$row12["plan_qty"]-$row12["fill_qty"];
						if($qty>0)
						{
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\")";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
							$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
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
		echo "<h3><font face='verdana' color='green'>Generating Sewing Jobs for <br>Schedule: <span class='label label-info'>".$schedule."</span> with Pack Method: <span class='label label-info'>".$operation[$sew_pack_method]."</span></font></h3>";

		// echo '<h4>Pack Method: <span class="label label-info">'.$operation[$sew_pack_method].'</span></h4>';
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
		$status_sew=1;
		$cols_tot=array();
		if($sew_pack_method==1 || $sew_pack_method==2)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);

				// Normal
					$sql1y="SELECT size_title FROM $bai_pro3.`tbl_pack_ref` LEFT JOIN $bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE SCHEDULE='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
					// $sql1y="SELECT size_title FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
					$resulty=mysqli_query($link, $sql1y) or die ("Error1uu=".$sql1y.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1y=mysqli_fetch_array($resulty))
					{
						// $sql129="SELECT cut_num as cut,group_concat(DISTINCT docket_number ORDER BY docket_number) as doc FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_num=1 and mini_order_ref='".$carton_id."' and color in ('".implode("','",$cols_tot)."') and size_tit='".$row1y['size_title']."' group by cut_num order by cut_num*1";
						$sql129="SELECT cut_no as cut,group_concat(DISTINCT doc_no ORDER BY doc_no) as doc FROM $bai_pro3.`tbl_docket_qty` LEFT JOIN $bai_pro3.pac_stat_input ON tbl_docket_qty.`pac_stat_input_id`=pac_stat_input.`id` WHERE color IN ('".implode("','",$cols_tot)."') AND size='".$row1y['size_title']."' and SCHEDULE='$schedule' AND pac_seq_no='$seq_no' GROUP BY cut_no ";
						//echo $sql129."<br>";
						$result1219=mysqli_query($link, $sql129) or die ("Error1.1=".$sql129.mysqli_error($GLOBALS["___mysqli_ston"]));
						$temp_val='';
						while($row1219=mysqli_fetch_array($result1219))
						{
							$docs_newtmp[]=$row1219['doc'];
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
						for($iii=0;$iii<sizeof($docs_newtmp);$iii++)
						{	
							$docs_new=explode(",",$docs_newtmp[$iii]);
							$docs_cut=explode(",",$docs_cuttmp[$iii]);
							for($iiii=0;$iiii<sizeof($docs_new);$iiii++)
							{
								if($status_sew==1)
								{
									$input_job_no=1;													
								}
								else
								{
									$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1"," pac_seq_no = $seq_no and order_del_no",$schedule,$link);
									$input_job_no=$input_job_no_tmp;
									$input_job_no_tmpn= echo_title("$bai_pro3.packing_summary_input","MIN(CAST(input_job_no AS DECIMAL))","size_code='".$row1y['size_title']."' and pac_seq_no = $seq_no and acutno='".$docs_cut[$iiii]."' and order_col_des in ('".str_replace(",","','",implode(",",$cols_tot))."') and order_del_no",$schedule,$link);
								
									if($input_job_no_tmpn>0)
									{
										$input_job_no=$input_job_no_tmpn;
									}
								}
								$rand=$schedule.date("ymd").$input_job_no;
								// $sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') and size_title='".$row1y['size_title']."'";
								$sql1="SELECT * 
										FROM bai_pro3.`tbl_pack_ref` 
										LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
										LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
										WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."') and size_title='".$row1y['size_title']."'";
								$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								// echo $sql1.'<br>';
								while($row1=mysqli_fetch_array($result1))
								{
									$input_job_quantiy_tmp=0;
									$color_code=$row1['color'];
									$size_ref=$row1['ref_size_name'];
									$size_tit=$row1['size_title'];
									$split_qty=$row1['bundle_qty'];
									$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
									$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
									// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' AND mini_order_num=1 and color='".$color_code."' and size='".$size_ref."' and docket_number='".$docs_new[$iiii]."' group BY cut_num order by cut_num*1";
									$sql12="SELECT * FROM $bai_pro3.tbl_docket_qty WHERE type=1 and color='".$color_code."' and doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."'";
									// $sql12="SELECT * 
										// FROM $bai_pro3.tbl_docket_qty 
										// LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
										// LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
										// WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=1 and color='".$color_code."' and size='".$size_tit."' and doc_no='".$docs_new[$iiii]."' group BY cut_no order by cut_no*1";
									$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									// echo $sql12.'<br>';
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
																	$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
																	mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
																	//echo "<tr><td>1".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
																	$qty_new=0;
																}
																else
																{
																	$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
																	mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
																	//echo "<tr><td>2".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
																	$qty_new=$qty_new-$split_qty;
																}
																
															}while($qty_new>0);
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>3".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
															$qty_new=0;
														}
														$input_job_no++;
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
																	$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
																	mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
																	//echo "<tr><td>4".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
																	$qty=0;
																}
																else
																{
																	$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
																	mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
																	//echo "<tr><td>5".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
																	$qty=$qty-$split_qty;
																}
																
															}while($qty>0);
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>6".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
															$qty=0;
														}
														$input_job_no++;
														$rand=$schedule.date("ymd").$input_job_no;
													} 
												}while($qty>0);
												$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."' and type='1'";
												mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));		
											}
										}
									}
								}
							}
							unset($docs_new);
							unset($docs_cut);
							$status_sew=0;
						}
						unset($docs_newtmp);
						unset($docs_cuttmp);					
					}
					//Sample
					$input_job_no=0;
					// $sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=3 and color in ('".implode("','",$cols_tot)."') group by docket_number";
					$sql120="SELECT doc_no 
							FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
					$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1210=mysqli_fetch_array($result1210))
					{
						$docs_new_o[]=$row1210['doc_no'];	
					}
					if(sizeof($docs_new_o)>0)
					{
						for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
						{					
							//Excess Pieces Execution
							$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);
							$rand=$schedule.date("ymd").$input_job_no;
							// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num = 3 and docket_number='".$docs_new_o[$kkk]."'"; 
							$sql12="SELECT * 
									FROM $bai_pro3.tbl_docket_qty 
									LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
									LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
									WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=3 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1";
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$docket_number=$row12["doc_no"]; 
								$qty=$row12["plan_qty"]-$row12["fill_qty"];
								if($qty>0)
								{		
									$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\")";
									mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
									//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
									$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
									mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							}
						}
					}
					unset($docs_new_o);
				// Sample

				//Excess
					$input_job_no=0;
					// $sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=2 and color in ('".implode("','",$cols_tot)."') group by docket_number";
					$sql120="SELECT doc_no 
						FROM $bai_pro3.tbl_docket_qty 
						LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
						LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
						WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
					$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1210=mysqli_fetch_array($result1210))
					{
						$docs_new_o[]=$row1210['doc_no'];	
					}
					if(sizeof($docs_new_o)>0)
					{
						for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
						{					
							//Excess Pieces Execution
							$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);
							$rand=$schedule.date("ymd").$input_job_no;
							// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num = 2 and docket_number='".$docs_new_o[$kkk]."'";
							$sql12="SELECT * 
									FROM $bai_pro3.tbl_docket_qty 
									LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
									LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
									WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1";
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$docket_number=$row12["doc_no"]; 
								$qty=$row12["plan_qty"]-$row12["fill_qty"]; 
								if($qty>0)
								{	
									$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\")";
									mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
									//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
									$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
									mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							}
						}
					}
					unset($docs_new_o);
					unset($cols_tot);
				// Excess
			}
		}
		else if($sew_pack_method==3 || $sew_pack_method==4)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				// Normal
					// $sql129="SELECT cut_num as cut,group_concat(DISTINCT docket_number ORDER BY docket_number) as doc FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=1 and color in ('".implode("','",$cols_tot)."') group by cut_num order by size*1";
					$sql129="SELECT cut_no as cut,group_concat(DISTINCT doc_no ORDER BY doc_no) as doc FROM $bai_pro3.`tbl_docket_qty` LEFT JOIN $bai_pro3.pac_stat_input ON tbl_docket_qty.`pac_stat_input_id`=pac_stat_input.`id` WHERE color IN ('".implode("','",$cols_tot)."') and SCHEDULE='$schedule' and type=1 AND pac_seq_no='$seq_no' GROUP BY cut_no ";
					// echo "$sql129 <br>";
					$result1219=mysqli_query($link, $sql129) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					$temp_val='';
					while($row1219=mysqli_fetch_array($result1219))
					{
						$docs_newtmp[]=$row1219['doc'];
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
					
					for($iii=0;$iii<sizeof($docs_newtmp);$iii++)
					{	
						$docs_new=explode(",",$docs_newtmp[$iii]);
						$docs_cut=explode(",",$docs_cuttmp[$iii]);
						//echo $docs_newtmp[$iii]."----".$docs_cuttmp[$iii]."<br>";
						for($iiii=0;$iiii<sizeof($docs_new);$iiii++)
						{
							$rand=$schedule.date("ymd").$input_job_no;	
							// $sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY color,size_title ORDER BY ref_size_name*1 desc";
							$sql1="SELECT * 
									FROM bai_pro3.`tbl_pack_ref` 
									LEFT JOIN bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` 
									LEFT JOIN bai_pro3.pac_stat_input ON tbl_pack_ref.`schedule`=pac_stat_input.`schedule` AND pac_stat_input.`pac_seq_no`=tbl_pack_size_ref.`seq_no`
									WHERE pac_stat_input.`schedule`='$schedule' AND seq_no='$seq_no' AND color IN ('".implode("','",$cols_tot)."')";
							// echo $sql1."<br>";
							$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row1=mysqli_fetch_array($result1))
							{								
								if($status_sew==1)
								{
									$input_job_no=1;													
								}
								else
								{
									$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1"," pac_seq_no = $seq_no and order_del_no",$schedule,$link);
									$input_job_no=$input_job_no_tmp;
									$input_job_no_tmpn= echo_title("$bai_pro3.packing_summary_input","MIN(CAST(input_job_no AS DECIMAL))","acutno='".$docs_cut[$iiii]."' and order_col_des in ('".str_replace(",","','",implode(",",$cols_tot))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);						
									if($input_job_no_tmpn>0)
									{
										$input_job_no=$input_job_no_tmpn;
									}
								}
								$rand=$schedule.date("ymd").$input_job_no;
								$size_ref=$row1['ref_size_name'];
								$size_tit=$row1['size_title'];
								$split_qty=$row1['bundle_qty'];
								$color_code=$row1['color'];
								$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
								$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
								$sql12="SELECT * FROM $bai_pro3.tbl_docket_qty WHERE type='1' and doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."'";
								// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND color='".$color_code."' and size='".$size_ref."' and docket_number='".$docs_new[$iiii]."' group BY cut_num order by cut_num*1";
								// echo $sql12."<br>";
								$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row12=mysqli_fetch_array($result12)) 
								{ 
									$docket_number=$row12["doc_no"]; 
									$qty=$row12["plan_qty"]-$row12["fill_qty"];
									if($qty>0  && $garments_per_carton>0)
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
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12[/"size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
															$qty_new=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty_new=$qty_new-$split_qty;
														}
														
													}while($qty_new>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
													$qty_new=0;
												}
												$input_job_no++;
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
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
															$qty=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
															mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
															//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty=$qty-$split_qty;
														}
														
													}while($qty>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,pac_seq_no) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",\"".$seq_no."\")";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													//echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_name"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
													$qty=0;
												}
												$input_job_no++;
												$rand=$schedule.date("ymd").$input_job_no;
											} 
										}while($qty>0);
										$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docs_new[$iiii]."' AND size='".$size_tit."' and type='1'";
										mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));	
									}
									
								}
							}						
						}
						unset($docs_new);
						unset($docs_cut);
						$status_sew=0;		
					}				
					unset($docs_newtmp);
					unset($docs_cuttmp);
				// Normal

				//Sample
					$sql120="SELECT FROM $bai_pro3.tbl_docket_qty 
							LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
							LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
							WHERE schedule='$schedule' and pac_seq_no=$seq_no and type='3' and color in ('".implode("','",$cols_tot)."') group BY doc_no";
					// $sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=3 and color in ('".implode("','",$cols_tot)."') group by docket_number";
					$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1210=mysqli_fetch_array($result1210))
					{
						$docs_new_o[]=$row1210['doc_no'];	
					}
					if(sizeof($docs_new_o)>0)
					{
						for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
						{
							$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);
							$rand=$schedule.date("ymd").$input_job_no;
							//Excess Pieces Execution
							$sql12="SELECT * 
									FROM $bai_pro3.tbl_docket_qty 
									LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
									LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
									WHERE schedule='$schedule' and pac_seq_no=$seq_no and color in ('".implode("','",$cols_tot)."') and type=3 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1";
							// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and docket_number='".$docs_new_o[$kkk]."' and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$docket_number=$row12["doc_no"]; 
								$qty=$row12["plan_qty"]-$row12["fill_qty"];
								if($qty>0)	
								{			
									$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'3',\"".$seq_no."\")";
									mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
									//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
									$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='3'";
									mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								}
							}
						}
					}
					unset($docs_new_o);
				// Sample

				//Excess
					$sql120="SELECT doc_no 
						FROM $bai_pro3.tbl_docket_qty 
						LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
						LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
						WHERE schedule='$schedule' and pac_seq_no=$seq_no and type=2 and color in ('".implode("','",$cols_tot)."') group BY doc_no";
					// $sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=2 and color in ('".implode("','",$cols_tot)."') group by docket_number";
					$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1210=mysqli_fetch_array($result1210))
					{
						$docs_new_o[]=$row1210['doc_no'];	
					}
					if(sizeof($docs_new_o)>0)
					{
						for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
						{
							$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and pac_seq_no = $seq_no and  order_del_no",$schedule,$link);
							$rand=$schedule.date("ymd").$input_job_no;
							//Excess Pieces Execution
							$sql12="SELECT * 
									FROM $bai_pro3.tbl_docket_qty 
									LEFT JOIN $bai_pro3.pac_stat_input ON pac_stat_input.`id` = tbl_docket_qty.`pac_stat_input_id`
									LEFT JOIN $brandix_bts.`tbl_orders_size_ref` ON tbl_orders_size_ref.id = tbl_docket_qty.ref_size 
									WHERE schedule='$schedule' and pac_seq_no=$seq_no and color in ('".implode("','",$cols_tot)."') and type=2 and doc_no='".$docs_new_o[$kkk]."' group BY cut_no order by cut_no*1";
							// $sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and docket_number='".$docs_new_o[$kkk]."' and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$docket_number=$row12["doc_no"]; 
								$qty=$row12["plan_qty"]-$row12["fill_qty"];
								if($qty>0)
								{		
									$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no) values(\"".$docket_number."\",\"".$row12["size"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$sew_pack_method."\",\"".$row12["size_name"]."\",'2',\"".$seq_no."\")";
									mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
									//echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_name"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
									$sqlupdate="update $bai_pro3.tbl_docket_qty set fill_qty='".$qty."' WHERE doc_no='".$docket_number."' AND size='".$row12["size"]."' and type='2'";
									mysqli_query($link, $sqlupdate) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
								
								}
							}
						}
					}
					unset($docs_new_o);
					unset($cols_tot);
				// Excess			
			}
		}
	}
	echo "</table>";	
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'create_sewing_job_packlist.php',0,'N')."&style=$style&schedule=$schedule';</script>");		
?> 
</div></div>
</body>