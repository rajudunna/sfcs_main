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
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));

	$bundle_size = $_POST['bund_size'];
	$sew_no_of_cartons = $_POST['no_of_cartons'];
	$sew_pack_method = $_POST['pack_method'];
	$pack_seq_no = $_POST['seq_no'];
	$mix_jobs = $_POST['mix_jobs'];
	$schedule = $_POST['schedule'];
	$style = $_POST['style'];
	$doc_data=array();
	$sql1222="SELECT MAX(id) as id FROM $bai_pro3.`pac_stat_input` WHERE SCHEDULE='$schedule'";
	// echo $sql1.'<br>';
	$result1122=mysqli_query($link, $sql1222) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($result1122)>0)
	{
		while($row1123=mysqli_fetch_array($result1122))
		{
			$id_old=$row1123['id'];
		}
	}
	// echo "bundle_size = ".$bundle_size.", sew_no_of_cartons = ".$sew_no_of_cartons.", sew_pack_method = ".$sew_pack_method.", pack_seq_no = ".$pack_seq_no.", mix_jobs = ".$mix_jobs.", schedule = ".$schedule.", style = ".$style.", sew_pack  = ".$operation[$sew_pack_method].'<br>';
	 // echo "<table class='table table-striped table-bordered'>";
	 // echo "<thead><th>Type</th><th>Cut Number</th><th>Job Number</th><th>Color</th><th>Size</th><th>Quantity</th><th>Docket Number</th></thead>";
	$insert_to_pac_stat_input = "INSERT INTO `bai_pro3`.`pac_stat_input` (`style`, `schedule`, `no_of_cartons`, `mix_jobs`, `bundle_qty`, `pac_seq_no`, `pack_method`) VALUES ('$style', '$schedule', '$sew_no_of_cartons', '$mix_jobs', '$bundle_size', '$pack_seq_no', '$sew_pack_method'); ";
	// echo $insert_to_pac_stat_input.'<br>';
	$inert_result = mysqli_query($link, $insert_to_pac_stat_input) or exit("Failed to save sewing method Details");
	if ($inert_result)
	{
		$pac_stat_input_id = mysqli_insert_id($link);
		$date_time=date('Y-m-d h:i:s');
		echo '<h3><font face="verdana" color="green">Please wait while we Generate Sewing Jobs...</font></h3>';

		// $sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."'";
		$sql1="SELECT * FROM $bai_pro3.`tbl_pack_ref` LEFT JOIN $bai_pro3.`tbl_pack_size_ref` ON tbl_pack_ref.`id`=tbl_pack_size_ref.`parent_id` WHERE SCHEDULE='$schedule' AND seq_no='$pack_seq_no'";
		// echo $sql1.'<br>';
		$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($result1))
		{
			$size=$row1["ref_size_name"];
			$color=$row1["color"];
			$style = $row1["style"];
			$schedule = $row1["schedule"];
			// $ex_cut_status=$row1['exces_from'];
			$ex_cut_status = echo_title("$bai_pro3.excess_cuts_log","excess_cut_qty","schedule_no='".$schedule."' AND color",$color,$link);
			$order_tid = echo_title("$bai_pro3.bai_orders_db_confirm","order_tid","order_style_no = '".$style."' and order_del_no='".$schedule."' AND order_col_des",$color,$link);
			$sno = 1;
			$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name,order_sizes.size_title FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name where orders.product_schedule='$schedule' and order_sizes.ref_size_name='$size' and order_sizes.order_col_des='$color'";
			$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row22=mysqli_fetch_array($result22))
			{
				$order_qty_col_size=$row22['orderQuantity'];
				$size_code=strtolower($row22['size_name']);
				$size_tit=strtoupper($row22['size_title']);
			}
			$sql2="SELECT cut_master.cat_ref FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id WHERE cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."' AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
			$result12=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rw=mysqli_fetch_array($result12))
			{
				$cat_ref=$rw['cat_ref'];
			}
			$cut_alloc=0;$sample=0;
			$sql221="SELECT input_qty as qty from $bai_pro3.sp_sample_order_db where sizes_ref='".$size_code."' and order_tid='".$order_tid."'";
			$result1221=mysqli_query($link, $sql221) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($result1221)>0)
			{
				while($rw21=mysqli_fetch_array($result1221))
				{
					$sample=$rw21['qty'];
				}
			}
			else
			{
				$sample=0;
			}	
			$sql22="SELECT sum(allocate_".$size_code."*plies) as qty from $bai_pro3.allocate_stat_log where cat_ref='".$cat_ref."' and order_tid='".$order_tid."'";
			$result122=mysqli_query($link, $sql22) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rw2=mysqli_fetch_array($result122))
			{
				$cut_alloc+=$rw2['qty'];
			}
			
			$diff_qty=$cut_alloc-($order_qty_col_size+$sample);
			if($ex_cut_status=='1')
			{
				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size group by cut_num order by cut_master.cut_num";
			}
			else
			{
				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size group by cut_num order by cut_master.cut_num*1 desc";						
			}
			$check_status=0;
			$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($result23))
			{
				$doc_data[]=$sql_row['docket_number'];
				$cut_num=$sql_row['cut_num'];
				$color_code=$sql_row['col_code'];
				$ratio=$sql_row['quantity'];
				$cut_quantity=$sql_row['total_cut_quantity'];
				// Eiminate duplicate dockets
				$sql221="SELECT * from $bai_pro3.tbl_docket_qty where doc_no='".$sql_row['docket_number']."' and ref_size='$size'";
				$result1221=mysqli_query($link, $sql221) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result1221)>0)
				{
					while($rw21=mysqli_fetch_array($result1221))
					{
						$cut_quantity=$cut_quantity-$rw21['plan_qty'];
						
					}
				}
				if($check_id>0)
				{
					$sql2211="SELECT sum(if(type=2,plan_qty,0)) as ex,sum(if(type=3,plan_qty,0)) as sam from $bai_pro3.tbl_docket_qty where ref_size='$size' and color='".$color."' and pac_stat_input_id='$check_id' and type in (2,3)";
					$result12211=mysqli_query($link, $sql2211) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rw211=mysqli_fetch_array($result12211))
					{
						if($rw211['sam']>0 && $sample<>$rw211['sam'])
						{
							if($rw211['sam']<$sample)
							{
								$sample=$sample-$rw211['sam'];	
							}
							else
							{
								$sample=$rw211['sam']-$sample;
							}	

						}
						else
						{
							$sample=0;
						}

						/***********/

						if($rw211['ex']>0 && $diff_qty<>$rw211['ex'])
						{
							if($rw211['ex']<$diff_qty)
							{
								$diff_qty=$diff_qty-$rw211['ex'];	
							}
							else
							{
								$diff_qty=$rw211['ex']-$diff_qty;
							}	

						}
						else
						{
							$diff_qty=0;
						}
					}
				}
				//echo $cut_quantity."--".$diff_qty."--".$sample."<bR>";
				if($cut_quantity>0)
				{
					do
					{
						if($diff_qty > 0)
						{
							if($diff_qty>$cut_quantity)
							{
								// echo "<tr><td>Excess</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";

								$insertMiniOrderdata="INSERT INTO $bai_pro3.`tbl_docket_qty` (`cut_no`, `doc_no`, `size`, `plan_qty`, `fill_qty`, `type`,`pac_stat_input_id`, `color`, `ref_size`) VALUES ('$cut_num', '".$sql_row['docket_number']."', '$size_tit', '$cut_quantity', '','2','$pac_stat_input_id','$color','$size')";
								// echo "0=".$insertMiniOrderdata."<br><br>";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$diff_qty=$diff_qty-$cut_quantity;
								$cut_quantity=0;
							}
							else
							{
								// echo "<tr><td>Excess</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";

								$insertMiniOrderdata="INSERT INTO $bai_pro3.`tbl_docket_qty` (`cut_no`, `doc_no`, `size`, `plan_qty`, `fill_qty`, `type`,`pac_stat_input_id`, `color`, `ref_size`) VALUES ('$cut_num', '".$sql_row['docket_number']."', '$size_tit', '$diff_qty', '','2','$pac_stat_input_id','$color','$size')";
								// echo "1=".$insertMiniOrderdata."<br><br>"; 
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$cut_quantity=$cut_quantity-$diff_qty;
								$diff_qty=0;								
							}
						}
						else if($sample > 0)
						{
							if($sample>$cut_quantity)
							{	
								 // echo "<tr><td>Sample</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								
								$insertMiniOrderdata="INSERT INTO $bai_pro3.`tbl_docket_qty` (`cut_no`, `doc_no`, `size`, `plan_qty`, `fill_qty`, `type`, `pac_stat_input_id`, `color`, `ref_size`) VALUES ('$cut_num', '".$sql_row['docket_number']."', '$size_tit', '$cut_quantity', '','3','$pac_stat_input_id','$color','$size')";
								// echo "0=".$insertMiniOrderdata."<br><br>";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$sample=$sample-$cut_quantity;
								$cut_quantity=0;
							}
							else
							{						
								 // echo "<tr><td>Sample</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$sample."</td><td>".$sql_row['docket_number']."</td></tr>";

								$insertMiniOrderdata="INSERT INTO $bai_pro3.`tbl_docket_qty` (`cut_no`, `doc_no`, `size`, `plan_qty`, `fill_qty`, `type`,`pac_stat_input_id`, `color`, `ref_size`) VALUES ('$cut_num', '".$sql_row['docket_number']."', '$size_tit', '$sample', '','3','$pac_stat_input_id','$color','$size')";
								// echo "1=".$insertMiniOrderdata."<br><br>"; 
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$cut_quantity=$cut_quantity-$sample;
								$sample=0;	
								if($cut_quantity>0)
								{
									 // echo "<tr><td>Normal</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";

									$insertMiniOrderdata="INSERT INTO $bai_pro3.`tbl_docket_qty` (`cut_no`, `doc_no`, `size`, `plan_qty`, `fill_qty`, `type`,`pac_stat_input_id`, `color`, `ref_size`) VALUES ('$cut_num', '".$sql_row['docket_number']."', '$size_tit', '$cut_quantity', '','1','$pac_stat_input_id','$color','$size')";
									// echo "N=".$insertMiniOrderdata."<br><br>";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$cut_quantity=0;
								}						
							}						
						}
						else
						{
							 // echo "<tr><td>Normal</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";

							$insertMiniOrderdata="INSERT INTO $bai_pro3.`tbl_docket_qty` (`cut_no`, `doc_no`, `size`, `plan_qty`, `fill_qty`, `type`,`pac_stat_input_id`, `color`, `ref_size`) VALUES ('$cut_num', '".$sql_row['docket_number']."', '$size_tit', '$cut_quantity', '','1','$pac_stat_input_id','$color','$size')";
							// echo "N1=".$insertMiniOrderdata."<br><br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$cut_quantity=0;
						}
					}while($cut_quantity>0);
				}
			}
		}
		// echo "</table>";
		if($id_old>0)
		{
			$update1="update $bai_pro3.`tbl_docket_qty` set pac_stat_input_id='$pac_stat_input_id' where pac_stat_input_id='$id_old'";
			
		}
		else
		{
			$update1="update $bai_pro3.`tbl_docket_qty` set pac_stat_input_id='$pac_stat_input_id' where pac_stat_input_id in (".implode(",",$doc_data).")";
		}	
		
		//echo $update1."<br>";
		mysqli_query($link, $update1) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_main_packlist.php',0,'N')."&schedule=$schedule&seq_no=$pack_seq_no&pac_method=$sew_pack_method';</script>");
	}
?>