<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/mo_filling.php',4,'R')); 
?>
<body> 
<!-- <div class="panel panel-primary">
<div class="panel-heading">Packing List Generation</div>
<div class="panel-body"> -->
<h3><font face="verdana" color="green">Please wait...</font></h3>
<?php
	$carton_id=$_GET['c_ref'];
	$seq_no=$_GET['seq_no'];
	$carton_method=$_GET['pack_method'];
	$cols_tot_tmp=array();
	$order_status=0;$k_val=0;
	$gremnts_per_carton=array();
	$order_qty=array();
	$sizes=array();
	$plan_qty=array();
	$pack_qty=array();
	$eligible_to_qty=array();
	$require_qty=array();
	$no_of_cartons_fl=array();
	$no_of_cartons_ce=array();
	$cols_tot=array();
	$cols_tot_tmp=array();
	$cols_size_tmp=array();
	$min_carto_fl=0;
	$min_carto_ce=0;
	$seq_new=0;
	$garments_per_carton=0;
	$lay_plan_qty=0;
	$to_be_fill=0;
	$bal=0;
	$carton_job_no=0;
	$status_generation=0;
	$carton_qty=array();
	$carton_qty_tot=array();
	if($carton_method==1)
	{
		$sql123="SELECT pack_method,style,schedule,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM $bai_pro3.tbl_pack_ref 
		LEFT JOIN $bai_pro3.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE tbl_pack_size_ref.seq_no='".$seq_no."' and tbl_pack_ref.id='".$carton_id."' group by COLOR,size_title order by ref_size_name";
	}
	elseif($carton_method==2)
	{
		$sql123="SELECT pack_method,style,schedule,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM $bai_pro3.tbl_pack_ref 
		LEFT JOIN $bai_pro3.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE tbl_pack_size_ref.seq_no='".$seq_no."' and tbl_pack_ref.id='".$carton_id."' group by size_title order by ref_size_name";
	}
	elseif($carton_method==3)
	{
		$sql123="SELECT pack_method,style,schedule,GROUP_CONCAT(DISTINCT COLOR) AS cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM $bai_pro3.tbl_pack_ref 
		LEFT JOIN $bai_pro3.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE tbl_pack_size_ref.seq_no='".$seq_no."' and tbl_pack_ref.id='".$carton_id."'";
	}
	elseif($carton_method==4)
	{
		$sql123="SELECT pack_method,style,schedule,color as cols,GROUP_CONCAT(DISTINCT size_title order by ref_size_name*1) AS size_tit FROM $bai_pro3.tbl_pack_ref 
		LEFT JOIN $bai_pro3.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE tbl_pack_size_ref.seq_no='".$seq_no."' and tbl_pack_ref.id='".$carton_id."' group by color";
	}
	$result123=mysqli_query($link, $sql123) or die ("Error1.11=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row123=mysqli_fetch_array($result123))
	{
		$cols_tot_tmp[]=$row123['cols'];
		$cols_size_tmp[]=$row123['size_tit'];
		$style=$row123['style'];
		$schedule=$row123['schedule'];
	}
	$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
	$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule_id,$link);
	$sql123="SELECT * FROM $bai_pro3.tbl_pack_ref LEFT JOIN $bai_pro3.tbl_pack_size_ref ON tbl_pack_size_ref.parent_id=tbl_pack_ref.id WHERE $bai_pro3.tbl_pack_size_ref.pack_method='".$carton_method."' AND tbl_pack_size_ref.seq_no='".$seq_no."' and tbl_pack_size_ref.parent_id='".$carton_id."'";
	$result123=mysqli_query($link, $sql123) or die ("Error1.2=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row123=mysqli_fetch_array($result123))
	{
		$gremnts_per_carton[$row123['color']][$row123['size_title']]=$row123['garments_per_carton'];
		$sizes[$row123['color']][$row123['size_title']]=echo_title("$brandix_bts.tbl_orders_size_ref","size_name","id",$row123['ref_size_name'],$link);
		
		//Order		
		$order_qty[$row123['color']][$row123['size_title']]=echo_title("$brandix_bts.tbl_orders_sizes_master","order_act_quantity","size_title='".$row123['size_title']."' and order_col_des='".$row123['color']."' and parent_id",$schedule_id,$link);
		
		//Plan
		$sql1231="SELECT SUM(quantity*planned_plies) AS plan_qty FROM $brandix_bts.tbl_cut_size_master LEFT JOIN $brandix_bts.tbl_cut_master ON tbl_cut_size_master.parent_id=tbl_cut_master.id 
		WHERE product_schedule='".$schedule."' AND color='".$row123['color']."' AND ref_size_name='".$row123['ref_size_name']."'";
		$result1231=mysqli_query($link, $sql1231) or die ("Error1.13=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1231=mysqli_fetch_array($result1231))
		{
			$plan_qty[$row123['color']][$row123['size_title']]=$row1231['plan_qty'];
		}
		
		//Pack	
		$k_val=echo_title("$bai_pro3.packing_summary","sum(carton_act_qty)","size_tit='".$row123['size_title']."' and order_col_des='".$row123['color']."' and order_del_no",$schedule,$link);
		if($k_val=='' || $k_val=="")
		{
			$k_val=0;
		}			
		$pack_qty[$row123['color']][$row123['size_title']]=$k_val;
		
		//Eligible to fill
		$eligible_to_qty[$row123['color']][$row123['size_title']]=$plan_qty[$row123['color']][$row123['size_title']]-$pack_qty[$row123['color']][$row123['size_title']];
		
		//Required Quantity
		$require_qty[$row123['color']][$row123['size_title']]=$row123['garments_per_carton']*$row123['cartons_per_pack_job']*$row123['pack_job_per_pack_method'];
		if($eligible_to_qty[$row123['color']][$row123['size_title']]<$require_qty[$row123['color']][$row123['size_title']])
		{
			$require_qty[$row123['color']][$row123['size_title']]=$eligible_to_qty[$row123['color']][$row123['size_title']];
		}
		
	}
	// echo '<h3><font face="verdana" color="green">Please wait while we Generate Packing List...</font></h3>';
	// echo '<h4>Pack Method: <span class="label label-info">'.$operation[$carton_method].'</span></h4>';
	// echo "<table class='table table-striped table-bordered'>";
	// echo "<thead><th>Schedule</th><th>Parent No</th><th>Color</th><th>Size</th><th>Size Title</th><th>Carton Number</th><th>Quantity</th></thead>";	
	// packing List Generation
	if($carton_method==1 or $carton_method==2)
	{
		for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
		{
			$cols_tot=explode(",",$cols_tot_tmp[$kk]);
			$cols_size=explode(",",$cols_size_tmp[$kk]);
			for($ik=0;$ik<sizeof($cols_size);$ik++)	
			{		
				$min_carto_fl=0;
				$min_carto_ce=0;
				$order_status=0;
				for($iii=0;$iii<sizeof($cols_tot);$iii++)
				{
					if($require_qty[$cols_tot[$iii]][$cols_size[$ik]]>0 && $gremnts_per_carton[$cols_tot[$iii]][$cols_size[$ik]]>0)
					{
						// Check weather plan quantity is less than the order quantity or not	
						if($plan_qty[$cols_tot[$iii]][$cols_size[$ik]]<$order_qty[$cols_tot[$iii]][$cols_size[$ik]])
						{
							$order_status=1;
							$no_of_cartons_fl[]=floor($require_qty[$cols_tot[$iii]][$cols_size[$ik]]/$gremnts_per_carton[$cols_tot[$iii]][$cols_size[$ik]]);
						}
						else
						{										
							$no_of_cartons_ce[]=ceil($require_qty[$cols_tot[$iii]][$cols_size[$ik]]/$gremnts_per_carton[$cols_tot[$iii]][$cols_size[$ik]]);	
						}
					}
				}
				$min_carto_fl=min($no_of_cartons_fl);
				$min_carto_ce=min($no_of_cartons_ce);
				$cartons_to_create=0;
				if($order_status==0)
				{
					$cartons_to_create=$min_carto_ce;
				}
				else
				{
					$cartons_to_create=$min_carto_fl;
				}
				// Find Max of the carton no with in the schedule and pack Method
				$tmp_cart=0;
				$sql1235="select MAX(carton_no)+1 as cart_no from $bai_pro3.pac_stat where pac_seq_no='".$seq_no."' and schedule='".$schedule."'";
				$result1235=mysqli_query($link, $sql1235) or die ("Error1.2=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row1235=mysqli_fetch_array($result1235))
				{
					$tmp_cart=$row1235['cart_no'];
					if($tmp_cart==NULL || $tmp_cart=='' || $tmp_cart==0)
					{
						$tmp_cart=1;						
					}
					else
					{
						$cartons_to_create=($tmp_cart-1)+$cartons_to_create;
					}		
				}
				$act_carton=0;
				$bal=0;
				for($iii=0;$iii<sizeof($cols_tot);$iii++)
				{
					if($require_qty[$cols_tot[$iii]][$cols_size[$ik]]>0 && $gremnts_per_carton[$cols_tot[$iii]][$cols_size[$ik]]>0)
					{
						$to_be_fill=$require_qty[$cols_tot[$iii]][$cols_size[$ik]];
						$garments_per_carton=$gremnts_per_carton[$cols_tot[$iii]][$cols_size[$ik]];
						$act_carton=$act_carton+$garments_per_carton;
						for($iiii=$tmp_cart;$iiii<=$cartons_to_create;$iiii++)
						{						
							$bal=$to_be_fill;
							$to_be_fill=$to_be_fill-$garments_per_carton;
							if($to_be_fill>=0)
							{
								$carton_qty[$cols_tot[$iii]][$cols_size[$ik]]=$garments_per_carton;
								$carton_qty_tot[$iiii]+=$garments_per_carton;
								$bal=0;
								$status_generation=1;
							}
							else if($bal>0)
							{
								$carton_qty[$cols_tot[$iii]][$cols_size[$ik]]=$bal;
								$carton_qty_tot[$iiii]+=$bal;
								$bal=0;
								$status_generation=1;
							}
						}
					}
				}
				$carton_mode='';
				// Parent Table Filling
				for($iii=$tmp_cart;$iii<=$cartons_to_create;$iii++)
				{
					if($carton_qty_tot[$iii]==$act_carton)
					{
						$carton_mode='F';
					}
					else
					{
						$carton_mode='P';
					}		
					$sql1q="INSERT INTO `$bai_pro3`.`pac_stat` (`style`, `schedule`, `pac_seq_no`, `carton_no`, `carton_mode`, `carton_qty`) VALUES ('$style', '$schedule', '$seq_no', '$iii', '$carton_mode', '$carton_qty_tot[$iii]')";
					mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$parent_id[$iii]=mysqli_insert_id($link);
				}
				// Child Table Filling
				for($ii=0;$ii<sizeof($cols_tot);$ii++)
				{							
					if($carton_qty[$cols_tot[$ii]][$cols_size[$ik]]>0)
					{
						for($iii=$tmp_cart;$iii<=$cartons_to_create;$iii++)
						{
							$sql1q="INSERT INTO `$bai_pro3`.`pac_stat_log` (`size_code`, `carton_act_qty`, `status`, `style`, `schedule`, `color`,`size_tit`, `pac_stat_id`) VALUES ('".$sizes[$cols_tot[$ii]][$cols_size[$ik]]."', '".$carton_qty[$cols_tot[$ii]][$cols_size[$ik]]."', NULL, '".$style."', '".$schedule."', '".$cols_tot[$ii]."','".$cols_size[$ik]."','".$parent_id[$iii]."')";
							mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$schedule."</td><td>".$parent_id[$iii]."</td><td>".$cols_tot[$ii]."</td><td>".$sizes[$cols_tot[$ii]][$cols_size[$ik]]."</td><td>".$cols_size[$ik]."</td><td>".$iii."</td><td>".$carton_qty[$cols_tot[$ii]][$cols_size[$ik]]."</td></tr>";
						}
					}
				}							
			}
			unset($cols_tot);
			unset($cols_size);
			unset($carton_qty);
			unset($carton_qty_tot);	
		}			
	}
	else if($carton_method==3 or $carton_method==4)
	{
		for($kk=0;$kk<sizeof($cols_tot_tmp);$kk++)
		{
			$cols_tot=explode(",",$cols_tot_tmp[$kk]);
			$cols_size=explode(",",$cols_size_tmp[$kk]);
			$min_carto_fl=0;
			$min_carto_ce=0;
			$order_status=0;
			for($iii=0;$iii<sizeof($cols_tot);$iii++)
			{
				for($iiii=0;$iiii<sizeof($cols_size);$iiii++)
				{
					if($require_qty[$cols_tot[$iii]][$cols_size[$iiii]]>0 && $gremnts_per_carton[$cols_tot[$iii]][$cols_size[$iiii]]>0)
					{
						// Check weather plan quantity is less than the order quantity or not	
						if($plan_qty[$cols_tot[$iii]][$cols_size[$iiii]]<$order_qty[$cols_tot[$iii]][$cols_size[$iiii]])
						{
							$order_status=1;
							$no_of_cartons_fl[]=floor($require_qty[$cols_tot[$iii]][$cols_size[$iiii]]/$gremnts_per_carton[$cols_tot[$iii]][$cols_size[$iiii]]);
						}
						else
						{										
							$no_of_cartons_ce[]=ceil($require_qty[$cols_tot[$iii]][$cols_size[$iiii]]/$gremnts_per_carton[$cols_tot[$iii]][$cols_size[$iiii]]);	
						}
					}
				}
			}
			$min_carto_fl=min($no_of_cartons_fl);
			$min_carto_ce=min($no_of_cartons_ce);
			$cartons_to_create=0;
			if($order_status==0)
			{
				$cartons_to_create=$min_carto_ce;
			}
			else
			{
				$cartons_to_create=$min_carto_fl;
			}
			// Find Max of the carton no with in the schedule and pack Method
			$tmp_cart=0;
			$sql1235="select MAX(carton_no)+1 as cart_no from $bai_pro3.pac_stat where pac_seq_no='".$seq_no."' and schedule='".$schedule."'";
			$result1235=mysqli_query($link, $sql1235) or die ("Error1.2=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1235=mysqli_fetch_array($result1235))
			{
				$tmp_cart=$row1235['cart_no'];
				if($tmp_cart==NULL || $tmp_cart=='' || $tmp_cart==0)
				{
					$tmp_cart=1;						
				}
				else
				{
					$cartons_to_create=($tmp_cart-1)+$cartons_to_create;
				}		
			}
			$act_carton=0;
			$bal=0;
			for($iii=0;$iii<sizeof($cols_tot);$iii++)
			{
				for($iiii=0;$iiii<sizeof($cols_size);$iiii++)
				{
					if($require_qty[$cols_tot[$iii]][$cols_size[$iiii]]>0 && $gremnts_per_carton[$cols_tot[$iii]][$cols_size[$iiii]]>0)
					{
						$to_be_fill=$require_qty[$cols_tot[$iii]][$cols_size[$iiii]];
						$garments_per_carton=$gremnts_per_carton[$cols_tot[$iii]][$cols_size[$iiii]];
						$act_carton=$act_carton+$garments_per_carton;
						for($iiiii=$tmp_cart;$iiiii<=$cartons_to_create;$iiiii++)
						{						
							$bal=$to_be_fill;
							$to_be_fill=$to_be_fill-$garments_per_carton;
							if($to_be_fill>=0)
							{
								$carton_qty[$cols_tot[$iii]][$cols_size[$iiii]]=$garments_per_carton;
								$carton_qty_tot[$iiiii]+=$garments_per_carton;
								$bal=0;
								$status_generation=1;
							}
							else if($bal>0)
							{
								$carton_qty[$cols_tot[$iii]][$cols_size[$iiii]]=$bal;
								$carton_qty_tot[$iiiii]+=$bal;
								$bal=0;
								$status_generation=1;
							}
						}
					}
				}
			}
			$carton_mode='';
			// Parent Table Filling
			for($iiiii=$tmp_cart;$iiiii<=$cartons_to_create;$iiiii++)
			{
				if($carton_qty_tot[$iiiii]==$act_carton)
				{
					$carton_mode='F';
				}
				else
				{
					$carton_mode='P';
				}		
				$sql1q="INSERT INTO `$bai_pro3`.`pac_stat` (`style`, `schedule`, `pac_seq_no`, `carton_no`, `carton_mode`, `carton_qty`) VALUES ('$style', '$schedule', '$seq_no', '$iiiii', '$carton_mode', '$carton_qty_tot[$iiiii]')";
				mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$parent_id[$iiiii]=mysqli_insert_id($link);
			}
			// Child Table Filling
			for($ii=0;$ii<sizeof($cols_tot);$ii++)
			{							
				for($iiii=0;$iiii<sizeof($cols_size);$iiii++)
				{
					if($carton_qty[$cols_tot[$ii]][$cols_size[$iiii]]>0)
					{
						for($iiiii=$tmp_cart;$iiiii<=$cartons_to_create;$iiiii++)
						{
							$sql1q="INSERT INTO `$bai_pro3`.`pac_stat_log` (`size_code`, `carton_act_qty`, `status`, `style`, `schedule`, `color`,`size_tit`, `pac_stat_id`) VALUES ('".$sizes[$cols_tot[$ii]][$cols_size[$iiii]]."', '".$carton_qty[$cols_tot[$ii]][$cols_size[$iiii]]."', NULL, '".$style."', '".$schedule."','".$cols_tot[$ii]."','".$cols_size[$iiii]."','".$parent_id[$iiiii]."')";
							//echo $sql1q."<br>";
							mysqli_query($link, $sql1q) or die("Error---1".mysqli_error($GLOBALS["___mysqli_ston"])); 
							//echo "<tr><td>".$schedule."</td><td>".$parent_no[$iiiii]."</td><td>".$cols_tot[$ii]."</td><td>".$sizes[$cols_tot[$ii]][$cols_size[$iiii]]."</td><td>".$cols_size[$iiii]."</td><td>".$iiiii."</td><td>".$carton_qty[$cols_tot[$ii]][$cols_size[$iiii]]."</td></tr>";
						}
					}
				}
			}
			unset($cols_tot);
			unset($cols_size);
			unset($carton_qty);
			unset($carton_qty_tot);				
		}
	}
	//echo "</table>";
	if($status_generation==0)
	{
		echo "<script>sweetAlert('Packing List Not Generated.','Eligible Quantity Not available.','warning');</script>";
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",75);
					function Redirect() {
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
	}
	else
	{		
		$result=insertMOQuantitiesPacking($schedule,$seq_no);
		if($result==1)
		{
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
					function Redirect() {
						sweetAlert('Packing List Generated.','','success');
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
		}
		else
		{
			echo "<script>sweetAlert('Mo Sharing not completed.','Please delete and Re-Generate','warning');</script>";
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",75);
					function Redirect() {
						location.href = \"".getFullURLLevel($_GET['r'], "order_qty_vs_packed_qty.php", "0", "N")."&style=$style&schedule=$schedule\";
						}
					</script>";
		}
	}
?> 
<!-- </div> -->
</div>
</body>