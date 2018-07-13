<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
<div class="panel-body">
<?php 
	set_time_limit(30000000); 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$carton_id=$_GET["id"]; 
	$sql12="SELECT carton_method,style_code,ref_order_num,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM brandix_bts.tbl_carton_ref 
	LEFT JOIN brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id WHERE COMBO_NO>0 and tbl_carton_ref.id='".$carton_id."' GROUP BY COMBO_NO";
	$cols_tot_tmp=array();
	$result121=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$cols_tot_tmp[]=$row121['cols'];
		$style_id=$row121['style_code'];
		$schedule_id=$row121['ref_order_num'];
		$carton_method=$row121['carton_method'];
	}
	echo '<h4>Pack Method: <span class="label label-info">'.$operation[$carton_method].'</span></h4>';
	// echo "<table class='table table-striped table-bordered'>";
	// echo "<thead><th>Docket Number</th><th>Color</th><th>Size</th><th>Size Title</th><th>Input Job Number</th><th>Rand No Number</th><th>Quantity</th></thead>";
	
	$cols_tot=array();	
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
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
						$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$carton_id."' AND mini_order_num > 0 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
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
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
													$qty_new=0;
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
													$qty_new=$qty_new-$split_qty;
												}
												
											}while($qty_new>0);
										}
										else
										{
											$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
											mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
													$qty=0;
												}
												else
												{
													$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
													mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
													// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
													$qty=$qty-$split_qty;
												}
												
											}while($qty>0);
										}
										else
										{
											$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
											mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
			$input_job_no=0;
			$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
			$rand=$schedule.date("ymd").$input_job_no;
			//Excess Pieces Execution
			$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =0 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
			$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row12=mysqli_fetch_array($result12)) 
			{ 
				$docket_number=$row12["docket_number"]; 
				$qty=$row12["quantity"]; 
				$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2')";
				mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
					$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num > 0 and color='".$color_code."' and size='".$size_ref."' group BY cut_num order by cut_num*1"; 
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
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
												$qty_new=0;
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
												$qty_new=$qty_new-$split_qty;
											}
											
										}while($qty_new>0);
									}
									else
									{
										$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty_new."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
										mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
												$qty=0;
											}
											else
											{
												$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$split_qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
												mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
												// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$split_qty."</td></tr>";
												$qty=$qty-$split_qty;
											}
											
										}while($qty>0);
									}
									else
									{
										$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size) values(\"".$docket_number."\",\"".$size_tit."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\")";
										mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
										// echo "<tr><td>".$docket_number."</td><td>".$color_code."</td><td>".$row12["size_ref"]."</td><td>".$size_tit."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
										$qty=0;
									}																				
								} 
							}while($qty>0);		
						}
						
					}	
				}			
			}
			$input_job_no= echo_title("$bai_pro3.packing_summary_input","MAX(CAST(input_job_no AS DECIMAL))+1","order_col_des in ('".str_replace(",","','",implode(",",$cols_tot_tmp))."') and order_del_no",$schedule,$link);
			$rand=$schedule.date("ymd").$input_job_no;
			//Excess Pieces Execution
			$sql12="SELECT * FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref=".$carton_id." AND mini_order_num =0 and color in ('".implode("','",$cols_tot)."') order by cut_num*1"; 
			$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row12=mysqli_fetch_array($result12)) 
			{ 
				$docket_number=$row12["docket_number"]; 
				$qty=$row12["quantity"]; 
				$sql1q="insert into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing) values(\"".$docket_number."\",\"".$row12["size_tit"]."\",\"".$qty."\",\"".$input_job_no."\",\"".$rand."\",\"".$destination."\",\"".$carton_method."\",\"".$row12["size_ref"]."\",'2')";
				mysqli_query($link, $sql1q) or die("Error---3".mysqli_error($GLOBALS["___mysqli_ston"])); 
				// echo "<tr><td>".$docket_number."</td><td>".$row12["color"]."</td><td>".$row12["size_ref"]."</td><td>".$row12["size_tit"]."</td><td>".$input_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
			}
			unset($cols_tot);
		}
	}
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");		
?> 
</div></div>
</body>