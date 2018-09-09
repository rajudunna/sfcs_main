<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
<?php
	$schedule = '';
	$job_counter = 0;
	set_time_limit(30000000); 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$carton_id=$_GET["id"]; 
	$sql12="SELECT merge_status,carton_method,style_code,ref_order_num,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM brandix_bts.tbl_carton_ref 
	LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE COMBO_NO>0 and tbl_carton_ref.id='".$carton_id."' GROUP BY COMBO_NO";
	$cols_tot_tmp=array();
	$result121=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$cols_tot_tmp[]=$row121['cols'];
		$style_id=$row121['style_code'];
		$schedule_id=$row121['ref_order_num'];
		$carton_method=$row121['carton_method'];
		$merge_status=$row121["merge_status"];
		//$i_color = $row121['color'];
	}


	
	//$merge_status=2;
	if($merge_status==1)
	{
		echo '<h4>Pack Method: <span class="label label-info">'.$operation[$carton_method].'</span></h4>';
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
		$cols_tot=array();	
		$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
		$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);

		//Inserting data  into the sewing 'job log table
		$in_query = "Insert into $bai_pro3.sewing_jobs_ref ('style','schedule','log_time','bundles_count') values 
					('$style','$schedule','".date('Y-m-d H:i:s')."',0)";
		$in_result = mysqli_query($link,$in_query) or exit('Unable to insert into the sewing job ref');		
		if($in_result)
			$inserted_id = mysqli_insert_id($link);
		// Logic Ends...



		if($carton_method==1 || $carton_method==2)
		{
			$status_check=1;
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				$sql1y="SELECT size_title FROM brandix_bts.tbl_carton_ref 
				LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE 
				tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
				$resulty=mysqli_query($link, $sql1y) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
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
						$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$cols_tot[$ii]."' and size_title='".$row1y['size_title']."'";
						$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row1=mysqli_fetch_array($result1))
						{
							$input_job_quantiy_tmp=0;
							$color_code=$row1['color'];
							$size_ref=$row1['ref_size_name'];
							$size_tit=$row1['size_title'];
							$split_qty=$row1['split_qty'];
							$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
							$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
							$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' AND mini_order_num=1 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$docket_number=$row12["docket_number"]; 
								$qty=$row12["quantity"];
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
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
														$qty_new=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty_new=$qty_new-$split_qty;
													}
													
												}while($qty_new>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); $job_counter++;
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
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
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
														$qty=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty=$qty-$split_qty;
													}
													
												}while($qty>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
												mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); $job_counter++;
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
												$qty=0;
											}																				
										} 
									}while($qty>0);	
								}
							}
						}					
					}				
					$status_check=0;
				}
				// Sample
				$input_job_no=0;
				$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
				$rand=$schedule.date("ymd").$input_job_no;
				//Excess Pieces Execution
				$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
				$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row12=mysqli_fetch_array($result12)) 
				{ 
					$docket_number=$row12["docket_number"]; 
					$qty=$row12["quantity"]; 
					$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'3',$inserted_id)";
					mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
					$job_counter++;
					// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
				}
				// Excess				
				$input_job_no=0;
				$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
				$rand=$schedule.date("ymd").$input_job_no;
				//Excess Pieces Execution
				$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
				$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row12=mysqli_fetch_array($result12)) 
				{ 
					$docket_number=$row12["docket_number"]; 
					$qty=$row12["quantity"]; 
					$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2',$inserted_id)";
					mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
					$job_counter++;
					// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
				}
				unset($cols_tot);
			}
		}
		else if($carton_method==3 || $carton_method==4)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
				$sql1232="SELECT color FROM brandix_bts.tbl_carton_ref 
				LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE 
				tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY color ORDER BY color*1";
				$result12132=mysqli_query($link, $sql1232) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row12132=mysqli_fetch_array($result12132))
				{				
					$color_code=$row12132['color'];
					$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color='".$color_code."' GROUP BY size_title ORDER BY ref_size_name*1";
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
						$split_qty=$row1['split_qty'];
						$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
						$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num=1 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["docket_number"]; 
							$qty=$row12["quantity"]; 
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
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													$job_counter++;
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
													$qty_new=0;
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													$job_counter++;
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
													$qty_new=$qty_new-$split_qty;
												}
												
											}while($qty_new>0);
										}
										else
										{
											$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
											mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
											$job_counter++;
											// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
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
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													$job_counter++;
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
													$qty=0;
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													$job_counter++;
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
													$qty=$qty-$split_qty;
												}
												
											}while($qty>0);
										}
										else
										{
											$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
											mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
											$job_counter++;
											// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
											$qty=0;
										}																				
									} 
								}while($qty>0);		
							}
							
						}	
					}			
				}
				// Sample
				$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
				$rand=$schedule.date("ymd").$input_job_no;
				//Excess Pieces Execution
				$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
				$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row12=mysqli_fetch_array($result12)) 
				{ 
					$docket_number=$row12["docket_number"]; 
					$qty=$row12["quantity"]; 
					$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'3',$inserted_id)";
					mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
					$job_counter++;
					// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
				}
				// Excess
				$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
				$rand=$schedule.date("ymd").$input_job_no;
				//Excess Pieces Execution
				$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
				$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row12=mysqli_fetch_array($result12)) 
				{ 
					$docket_number=$row12["docket_number"]; 
					$qty=$row12["quantity"]; 
					$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2',$inserted_id)";
					mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
					$job_counter++;
					// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
				}
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
		$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
		$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
		echo "<h3><font face='verdana' color='green'>Generating Sewing Jobs for <br>Schedule: <span class='label label-info'>".$schedule."</span> with Pack Method: <span class='label label-info'>".$operation[$carton_method]."</span></font></h3>";



		// echo '<h4>Pack Method: <span class="label label-info">'.$operation[$carton_method].'</span></h4>';
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
		$status_sew=1;
		$cols_tot=array();
		if($carton_method==1 || $carton_method==2)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				$sql1y="SELECT size_title FROM $brandix_bts.tbl_carton_ref 
				LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE 
				tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
				$resulty=mysqli_query($link, $sql1y) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1y=mysqli_fetch_array($resulty))
				{				
					$sql129="SELECT cut_num as cut,group_concat(DISTINCT docket_number ORDER BY docket_number) as doc FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_num=1 and mini_order_ref='".$carton_id."' and color in ('".implode("','",$cols_tot)."') and size_tit='".$row1y['size_title']."' group by cut_num order by cut_num*1";
					//echo $sql129."<br>";
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
						for($iiii=0;$iiii<sizeof($docs_new);$iiii++)
						{
							if($status_sew==1)
							{
								$input_job_no=1;													
							}
							else
							{
								$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
								$input_job_no=$input_job_no_tmp;
								$input_job_no_tmpn= echo_title("$bai_pro3.packing_summary_input","MIN(CAST(input_job_no AS DECIMAL))","size_code='".$row1y['size_title']."' and acutno='".$docs_cut[$iiii]."' and order_col_des in ('".str_replace(",","','",implode(",",$cols_tot))."') and order_del_no",$schedule,$link);
							
								if($input_job_no_tmpn>0)
								{
									$input_job_no=$input_job_no_tmpn;
								}
							}
							$rand=$schedule.date("ymd").$input_job_no;
							$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') and size_title='".$row1y['size_title']."'";
							$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
							
							while($row1=mysqli_fetch_array($result1))
							{
								$input_job_quantiy_tmp=0;
								$color_code=$row1['color'];
								$size_ref=$row1['ref_size_name'];
								$size_tit=$row1['size_title'];
								$split_qty=$row1['split_qty'];
								$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
								$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link);
								
								$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' AND mini_order_num=1 and color='".$color_code."' and size='".$size_ref."' and docket_number='".$docs_new[$iiii]."' group BY cut_num order by cut_num*1";
								$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row12=mysqli_fetch_array($result12)) 
								{ 
									$docket_number=$row12["docket_number"]; 
									$qty=$row12["quantity"];
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
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															$job_counter++;
															// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
															$qty_new=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															$job_counter++;
															// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty_new=$qty_new-$split_qty;
														}
														
													}while($qty_new>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													$job_counter++;
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
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
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
															mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
															$job_counter++;
															// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
															$qty=0;
														}
														else
														{
															$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
															mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
															$job_counter++;
															// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
															$qty=$qty-$split_qty;
														}
														
													}while($qty>0);
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													$job_counter++;
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
													$qty=0;
												}
												$input_job_no++;
												$rand=$schedule.date("ymd").$input_job_no;
											} 
										}while($qty>0);	
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
				$sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=3 and color in ('".implode("','",$cols_tot)."') group by docket_number";
				$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['docket_number'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{					
						//Excess Pieces Execution
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num = 3 and docket_number='".$docs_new_o[$kkk]."'"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["docket_number"]; 
							$qty=$row12["quantity"]; 
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'3',$inserted_id)";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							$job_counter++;
							// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
						}
					}
				}
				unset($docs_new_o);
				//Excess
				$input_job_no=0;
				$sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=2 and color in ('".implode("','",$cols_tot)."') group by docket_number";
				$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['docket_number'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{					
						//Excess Pieces Execution
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num = 2 and docket_number='".$docs_new_o[$kkk]."'"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["docket_number"]; 
							$qty=$row12["quantity"]; 
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2',$inserted_id)";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							$job_counter++;
							// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
						}
					}
				}
				unset($docs_new_o);
				unset($cols_tot);
			}
		}
		else if($carton_method==3 || $carton_method==4)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				$sql129="SELECT cut_num as cut,group_concat(DISTINCT docket_number ORDER BY docket_number) as doc FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=1 and color in ('".implode("','",$cols_tot)."') group by cut_num order by size*1";
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
						//echo $input_job_no."<Br>";						
						$rand=$schedule.date("ymd").$input_job_no;	
						$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY color,size_title ORDER BY ref_size_name*1 desc";
						//echo $sql1."<br>";
						$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row1=mysqli_fetch_array($result1))
						{								
							if($status_sew==1)
							{
								$input_job_no=1;													
							}
							else
							{
								$input_job_no_tmp= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_del_no",$schedule,$link);
								$input_job_no=$input_job_no_tmp;
								$input_job_no_tmpn= echo_title("$bai_pro3.packing_summary_input","MIN(CAST(input_job_no AS DECIMAL))","acutno='".$docs_cut[$iiii]."' and order_col_des in ('".str_replace(",","','",implode(",",$cols_tot))."') and order_del_no",$schedule,$link);						
								if($input_job_no_tmpn>0)
								{
									$input_job_no=$input_job_no_tmpn;
								}
							}
							$rand=$schedule.date("ymd").$input_job_no;
							$size_ref=$row1['ref_size_name'];
							$size_tit=$row1['size_title'];
							$split_qty=$row1['split_qty'];
							$color_code=$row1['color'];
							$garments_per_carton=$row1['garments_per_carton']*$row1['no_of_cartons'];
							$destination=echo_title("$bai_pro3.bai_orders_db","UPPER(destination)","order_del_no=\"".$schedule."\" and order_col_des",$color_code,$link); 
							$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND color='".$color_code."' and size='".$size_ref."' and docket_number='".$docs_new[$iiii]."' group BY cut_num order by cut_num*1";
							//echo $sql12."<br>";
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{ 
								$docket_number=$row12["docket_number"]; 
								$qty=$row12["quantity"]; 
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
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
														$qty_new=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty_new=$qty_new-$split_qty;
													}
													
												}while($qty_new>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); $job_counter++;
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
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
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
														$qty=0;
													}
													else
													{
														$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
														mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
														$job_counter++;
														// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
														$qty=$qty-$split_qty;
													}
													
												}while($qty>0);
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,sref_id) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",$inserted_id)";
												mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); $job_counter++;
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
												$qty=0;
											}
											$input_job_no++;
											$rand=$schedule.date("ymd").$input_job_no;
										} 
									}while($qty>0);		
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
				//Sample
				$sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=3 and color in ('".implode("','",$cols_tot)."') group by docket_number";
				$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['docket_number'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						//Excess Pieces Execution
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =3 and docket_number='".$docs_new_o[$kkk]."' and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["docket_number"]; 
							$qty=$row12["quantity"]; 
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'3',$inserted_id)";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							$job_counter++;
							// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
						}
					}
				}
				unset($docs_new_o);
				//Excess
				$sql120="SELECT docket_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' and mini_order_num=2 and color in ('".implode("','",$cols_tot)."') group by docket_number";
				$result1210=mysqli_query($link, $sql120) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1210=mysqli_fetch_array($result1210))
				{
					$docs_new_o[]=$row1210['docket_number'];	
				}
				if(sizeof($docs_new_o)>0)
				{
					for($kkk=0;$kkk<sizeof($docs_new_o);$kkk++)
					{
						$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
						$rand=$schedule.date("ymd").$input_job_no;
						//Excess Pieces Execution
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =2 and docket_number='".$docs_new_o[$kkk]."' and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{ 
							$docket_number=$row12["docket_number"]; 
							$qty=$row12["quantity"]; 
							$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,sref_id) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2',$inserted_id)";
							mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
							$job_counter++;
							// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
						}
					}
				}
				unset($docs_new_o);
				unset($cols_tot);				


			}
		}
	}
	// echo "</table>";	

	//Deleting the entry from sewing jobs ref if no input job was created  --  Updating the bundle quantity after the jobs are inserted
	if($job_counter == 0){
		$delete_query = "Delete from $bai_pro3.sewing_jobs_ref where id = '$inserted_id'";
		$delete_result = mysqli_query($link,$delete_query) or exit("Probelem while inserting to sewing jos ref");
		if($delete_result){
			//Deleted Successfully
		}
	}else{
		$update_query = "Update $bai_pro3.sewing_jobs_ref set bundles_count = $job_counter where id = '$inserted_id' ";
		$update_result = mysqli_query($link,$update_query) or exit("Probelem while inserting to sewing jos ref");
		if($update_result){
			//Updated Successfully
		}
	}

	$mo_fill_url = getFullURLLevel($_GET['r'],'sewing_job_mo_fill.php',0,'N');
	$url = "$mo_fill_url&style=$style_id&schedule=$schedule&schedule_id=$schedule_id&process_name=sewing&filename=create_sewing";
	echo "<script>console.log($url);
				  sweetAlert('Data Saved Successfully','','success');
		  </script>";

	echo("<script>location.href = '$mo_fill_url&sref_id=$inserted_id&style=$style_id&schedule=$schedule&schedule_id=$schedule_id&process_name=sewing&filename=create_sewing';</script>");	

	// echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	// echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");		
?> 
</div></div>
</body>