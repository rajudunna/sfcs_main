<body> 
<div class="panel panel-primary">
<div class="panel-heading">Packing List Generation</div>
<div class="panel-body">
<?php
	$carton_id=$_POST['c_ref'];
	$seq_no=$_POST['seq_no'];
	$sql123="SELECT pack_method,style_code,ref_order_num,GROUP_CONCAT(DISTINCT COLOR) AS cols FROM brandix_bts.tbl_pack_ref 
	LEFT JOIN brandix_bts.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE tbl_pack_ref.seq_no='".$seq_no."' and tbl_pack_ref.id='".$carton_id."' GROUP BY COMBO_NO";
	$cols_tot_tmp=array();
	$result123=mysqli_query($link, $sql123) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row123=mysqli_fetch_array($result123))
	{
		$cols_tot_tmp[]=$row123['cols'];
		$style_id=$row123['style_code'];
		$schedule_id=$row123['ref_order_num'];
		$carton_method=$row123['pack_method'];
	}
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	$sql123="SELECT * FROM brandix_bts.tbl_pack_ref 
	LEFT JOIN brandix_bts.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE brandix_bts.tbl_pack_size_ref='".$carton_method."' AND tbl_pack_size_ref.seq_no='".$seq_no."' and tbl_pack_size_ref.parent_id='".$carton_id."'";
	$cols_tot_tmp=array();
	$order_status=0;	
	$result123=mysqli_query($link, $sql123) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row123=mysqli_fetch_array($result123))
	{
		//Order
		$col_new=$row123['color'];
		$col_new_sizes=$row123['size_title'];
		$Seq_no=$row123['Seq_no'];
		$order_qty[$row123['color']][$row123['size_title']]=echo_title("$brandix_bts.tbl_orders_sizes_master","order_act_quantity","size_title='".$row123['size_title']."' and order_col_des='".color."' and parent_id",$schedule_id,$link);
		
		//Plan
		$sql1231="SELECT SUM(quantity*planned_plies) AS plan_qty FROM brandix_bts.tbl_cut_size_master LEFT JOIN brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id 
		WHERE product_schedule='$schedule' AND color='$row123['color']' AND ref_size_name='$row123['ref_size_name']'";
		$result1231=mysqli_query($link, $sql1231) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1231=mysqli_fetch_array($result1231))
		{
			$plan_qty[$row123['color']][$row123['size_title']]=$row1231['plan_qty'];
		}
		
		//Pack		
		$pack_qty[$row123['color']][$row123['size_title']]=echo_title("$bai_pro3.pac_stat_log","sum(carton_act_qty)","size_tit='".$row123['size_title']."' and color='".color."' and schedule",$schedule,$link);
		$elgible[$row123['color']][$row123['size_title']]=$plan_qty[$row123['color']][$row123['size_title']]-$pack_qty[$row123['color']][$row123['size_title']];
		
		//Over all Quantity
		$over_all=$pack_qty[$row123['color']][$row123['size_title']]+($row123['garments_per_carton']*$row123['cartons_per_pack_job']*$row123['pack_job_per_pack_method']);
		
		//Eligible to fill
		$eligible_to_qty[$row123['color']][$row123['size_title']]=$plan_qty[$row123['color']][$row123['size_title']]-$pack_qty[$row123['color']][$row123['size_title']];
		
		//Required Quantity
		$require_qty[$row123['color']][$row123['size_title']]=$row123['garments_per_carton']*$row123['cartons_per_pack_job']*$row123['pack_job_per_pack_method'];
		
		if($plan_qty[$row123['color']][$row123['size_title']]<$order_qty[$row123['color']][$row123['size_title']])
		{
			$order_status=1;
			$no_of_cartons_ceil[$row123['color']][$row123['size_title']]=ceil($eligible_to_qty[$row123['color']][$row123['size_title']]%$require_qty[$row123['color']][$row123['size_title']]);
		}
		else
		{	
			$no_of_cartons[$row123['color']][$row123['size_title']]=round($eligible_to_qty[$row123['color']][$row123['size_title']]%$require_qty[$row123['color']][$row123['size_title']]);			
		}		
	}
	echo '<h4>Pack Method: <span class="label label-info">'.$operation[$carton_method].'</span></h4>';
	$cols_tot=array();	
	
	if($pac_status=='' || $pac_status==0)
	{
		echo "<table class='table table-striped table-bordered'>";
		echo "<thead><th>Schedule</th><th>Seq No</th><th>Color</th><th>Size</th><th>Size Title</th><th>Carton Number</th><th>Carton Rand No </th><th>Quantity</th></thead>";
		//packing List Generation
		if($carton_method==1 or $carton_method==2)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				$sql1y="SELECT size_title, FROM $brandix_bts.tbl_pack_ref 
				LEFT JOIN brandix_bts.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE 
				tbl_pack_ref.id='".$carton_id."' and color in ('".implode("','",$cols_tot)."') GROUP BY size_title ORDER BY ref_size_name*1";
				$resulty=mysqli_query($link, $sql1y) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1y=mysqli_fetch_array($resulty))
				{				
					for($ii=0;$ii<sizeof($cols_tot);$ii++)
					{							
						$sql1212="SELECT input_job_no,order_col_des,size_code FROM $bai_pro3.packing_summary_input WHERE type_of_sewing=1 and order_del_no='".$schedule."' and order_col_des='".$cols_tot[$ii]."' and size_code='".$row1y["size_title"]."' group  BY input_job_no,order_col_des,size_code order by input_job_no*1";
						$result1212=mysqli_query($link, $sql1212) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row1212=mysqli_fetch_array($result1212)) 
						{ 
							if($row1212["input_job_no"]=='1')
							{
								$carton_job_no=1;
							}
							else if($ii<>'0')
							{
								$carton_job_no=echo_title("$bai_pro3.pac_stat_log","MIN(carton_no)","input_job_number='".$row1212["input_job_no"]."' and schedule",$schedule,$link);
								if($carton_job_no==0 || $carton_job_no=='')
								{
									$carton_job_no=echo_title("$bai_pro3.pac_stat_log","MAX(carton_no)+1","schedule",$schedule,$link);
								}						
							}
							else if($ii=='0')
							{
								$carton_job_no=echo_title("$bai_pro3.pac_stat_log","MAX(carton_no)+1","schedule",$schedule,$link);
							}
							$rand=$schedule.date("ymd").$carton_job_no;
							$color_code=$row1212['order_col_des'];
							$size_ref=$row1212['old_size'];
							$size_tit=$row1212['size_code'];
							$garments_per_carton=echo_title("$brandix_bts.tbl_pack_size_ref","garments_per_carton","color='".$color_code."' and size_title='".$size_tit."' and parent_id",$carton_id,$link);
							$carton_job_quantiy_tmp=0;
							$sql12="SELECT * FROM $bai_pro3.packing_summary_input WHERE type_of_sewing=1 and order_del_no='".$schedule."' and order_col_des='".$color_code."' and size_code='".$size_tit."' and input_job_no='".$row1212['input_job_no']."' ORDER BY input_job_no*1";
							$result125=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row125=mysqli_fetch_array($result125)) 
							{ 
								$destination=$row125["destination"];
								$docket_number=$row125["doc_no"];
								$old_size=$row125["old_size"];
								$qty=$row125["carton_act_qty"];
								if($qty>0 && $garments_per_carton>0)
								{												
									do
									{	
										if(($garments_per_carton-$carton_job_quantiy_tmp)<=$qty)
										{
											$qty_new=$garments_per_carton-$carton_job_quantiy_tmp;
											$qty=$qty-$qty_new;
											$sql1q="INSERT INTO `bai_pro3`.`pac_stat_log` (`doc_no`, `size_code`, `carton_no`, `carton_mode`, `carton_act_qty`, `status`, `lastup`, `remarks`, `doc_no_ref`, `container`, `disp_carton_no`, `disp_id`, `audit_status`, `scan_date`, `scan_user`, `input_job_random`, `input_job_number`, `order_tid`, `module`, `style`, `schedule`, `color`) VALUES ('".$docket_number."', '".$old_size."', '".$carton_job_no."', 'F', '".$qty_new."', NULL, NULL, NULL, '".$rand."', '1', NULL, NULL, NULL, NULL, NULL, '".$row125["input_job_no_random"]."', '".$row125["input_job_no"]."', '".$row125["order_style_no"].$row125["order_del_no"].$row125["order_col_des"]."', '', '".$row125["order_style_no"]."', '".$row125["order_del_no"]."', '".$row125["order_col_des"]."')";
											mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
											// echo "<tr><td>".$row125['input_job_no']."</td><td>".$docket_number."</td><td>".$color_code."</td><td>".$old_size."</td><td>".$size_tit."</td><td>".$carton_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
											$qty_new=0;
											$carton_job_no++;
											$rand=$schedule.date("ymd").$carton_job_no;
											$carton_job_quantiy_tmp=0;
										}
										else
										{
											$carton_job_quantiy_tmp+=$qty;
											$sql1q="INSERT INTO `bai_pro3`.`pac_stat_log` (`doc_no`, `size_code`, `carton_no`, `carton_mode`, `carton_act_qty`, `status`, `lastup`, `remarks`, `doc_no_ref`, `container`, `disp_carton_no`, `disp_id`, `audit_status`, `scan_date`, `scan_user`, `input_job_random`, `input_job_number`, `order_tid`, `module`, `style`, `schedule`, `color`) VALUES ('".$docket_number."', '".$old_size."', '".$carton_job_no."', 'F', '".$qty."', NULL, NULL, NULL, '".$rand."', '1', NULL, NULL, NULL, NULL, NULL, '".$row125["input_job_no_random"]."', '".$row125["input_job_no"]."', '".$row125["order_style_no"].$row125["order_del_no"].$row125["order_col_des"]."', '', '".$row125["order_style_no"]."', '".$row125["order_del_no"]."', '".$row125["order_col_des"]."')";
											 mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
											// echo "<tr><td>".$row125['input_job_no']."</td><td>".$docket_number."</td><td>".$color_code."</td><td>".$old_size."</td><td>".$size_tit."</td><td>".$carton_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
											$qty=0;
										} 
										
									}while($qty>0);	
								}
							}
						}	
					}				
				}			
			}
		}
		else if($carton_method==3 or $carton_method==4)
		{
			for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
			{
				$cols_tot=explode(",",$cols_tot_tmp[$kk]);
				for($ii=0;$ii<sizeof($cols_tot);$ii++)
				{			
					$sql1212="SELECT input_job_no,order_col_des,size_code FROM $bai_pro3.packing_summary_input WHERE type_of_sewing=1 and order_del_no='".$schedule."' and order_col_des='".$cols_tot[$ii]."' group by input_job_no,order_col_des,size_code order by input_job_no*1";
					$result1212=mysqli_query($link, $sql1212) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($row1212=mysqli_fetch_array($result1212)) 
					{ 
						if($row1212["input_job_no"]=='1')
						{
							$carton_job_no=1;
						}
						else
						{
							$carton_job_no=echo_title("$bai_pro3.pac_stat_log","MIN(carton_no)","input_job_number='".$row1212["input_job_no"]."' and schedule",$schedule,$link);
							if($carton_job_no==0 || $carton_job_no=='')
							{
								$carton_job_no=echo_title("$bai_pro3.pac_stat_log","MAX(carton_no)+1","schedule",$schedule,$link);
							}
						}
						$rand=$schedule.date("ymd").$carton_job_no;
						$color_code=$row1212['order_col_des'];
						$size_ref=$row1212['old_size'];
						$size_tit=$row1212['size_code'];
						$garments_per_carton=echo_title("$brandix_bts.tbl_pack_size_ref","garments_per_carton","color='".$color_code."' and size_title='".$size_tit."' and parent_id",$carton_id,$link);
						$carton_job_quantiy_tmp=0;
						$sql12="SELECT * FROM $bai_pro3.packing_summary_input WHERE type_of_sewing=1 and order_del_no='".$schedule."' and order_col_des='".$color_code."' and size_code='".$size_tit."' and input_job_no='".$row1212['input_job_no']."' ORDER BY input_job_no*1";
						$result125=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row125=mysqli_fetch_array($result125)) 
						{ 
							$destination=$row125["destination"];
							$docket_number=$row125["doc_no"];
							$old_size=$row125["old_size"];
							$qty=$row125["carton_act_qty"];
							if($qty>0 && $garments_per_carton>0)
							{												
								do
								{	
									if(($garments_per_carton-$carton_job_quantiy_tmp)<=$qty)
									{
										$qty_new=$garments_per_carton-$carton_job_quantiy_tmp;
										$qty=$qty-$qty_new;
										$sql1q="INSERT INTO `bai_pro3`.`pac_stat_log` (`doc_no`, `size_code`, `carton_no`, `carton_mode`, `carton_act_qty`, `status`, `lastup`, `remarks`, `doc_no_ref`, `container`, `disp_carton_no`, `disp_id`, `audit_status`, `scan_date`, `scan_user`, `input_job_random`, `input_job_number`, `order_tid`, `module`, `style`, `schedule`, `color`) VALUES ('".$docket_number."', '".$old_size."', '".$carton_job_no."', 'F', '".$qty_new."', NULL, NULL, NULL, '".$rand."', '1', NULL, NULL, NULL, NULL, NULL, '".$row125["input_job_no_random"]."', '".$row125["input_job_no"]."', '".$row125["order_style_no"].$row125["order_del_no"].$row125["order_col_des"]."', '', '".$row125["order_style_no"]."', '".$row125["order_del_no"]."', '".$row125["order_col_des"]."')";
										mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
										// echo "<tr><td>".$row125['input_job_no']."</td><td>".$docket_number."</td><td>".$color_code."</td><td>".$old_size."</td><td>".$size_tit."</td><td>".$carton_job_no."</td><td>".$rand."</td><td>".$qty_new."</td></tr>";
										$qty_new=0;
										$carton_job_no++;
										$rand=$schedule.date("ymd").$carton_job_no;
										$carton_job_quantiy_tmp=0;
									}
									else
									{
										$carton_job_quantiy_tmp+=$qty;
										$sql1q="INSERT INTO `bai_pro3`.`pac_stat_log` (`doc_no`, `size_code`, `carton_no`, `carton_mode`, `carton_act_qty`, `status`, `lastup`, `remarks`, `doc_no_ref`, `container`, `disp_carton_no`, `disp_id`, `audit_status`, `scan_date`, `scan_user`, `input_job_random`, `input_job_number`, `order_tid`, `module`, `style`, `schedule`, `color`) VALUES ('".$docket_number."', '".$old_size."', '".$carton_job_no."', 'F', '".$qty."', NULL, NULL, NULL, '".$rand."', '1', NULL, NULL, NULL, NULL, NULL, '".$row125["input_job_no_random"]."', '".$row125["input_job_no"]."', '".$row125["order_style_no"].$row125["order_del_no"].$row125["order_col_des"]."', '', '".$row125["order_style_no"]."', '".$row125["order_del_no"]."', '".$row125["order_col_des"]."')";
										 mysqli_query($link, $sql1q) or die("Error---2".mysqli_error($GLOBALS["___mysqli_ston"])); 
										// echo "<tr><td>".$row125['input_job_no']."</td><td>".$docket_number."</td><td>".$color_code."</td><td>".$old_size."</td><td>".$size_tit."</td><td>".$carton_job_no."</td><td>".$rand."</td><td>".$qty."</td></tr>";
										$qty=0;
									} 
									
								}while($qty>0);	
							}
						}
					}	
				}
				unset($cols_tot);
			}
		}
		// echo "</table>";
		echo "<script>sweetAlert('Packing List Generated','','success');</script>";
		$url5 = getFullURLLevel($_GET['r'],'pac_gen_sewing_job.php',0,'N');
		echo "<script>location.href = '".$url5."';</script>";
	}
	else
	{
		echo "<script>sweetAlert('Packing list Already generated','','warning');</script>";
	}		
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");		
?> 
</div></div>
</body>