<body>
<?php
set_time_limit(30000000);
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include("session_track.php");
    echo '<div class="panel panel-primary">
    			<div class="panel-body">';
	$status="";
	if($status == '' || $status == '1')
	{	
		$carton_id=$_GET['id'];
		$data_sym="$";
		$File = "session_track.php";
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."status=\"".$mini_order_ref."\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh);

		$date_time=date('Y-m-d h:i:s');
		echo '<h3><font face="verdana" color="green">Please wait while we Generate Sewing Jobs...</font></h3>';
		// echo "<br><div class='alert alert-warning'>Data Saving under process Please wait.....</div>";
		// echo "<table class='table table-striped table-bordered'>";
		// echo "<thead><th>Type</th><th>Cut Number</th><th>Job Number</th><th>Color</th><th>Size</th><th>Quantity</th><th>Docket Number</th></thead>";
		$sql1="SELECT * FROM $brandix_bts.tbl_carton_ref LEFT JOIN $brandix_bts.tbl_carton_size_ref ON tbl_carton_size_ref.parent_id=tbl_carton_ref.id where tbl_carton_ref.id='".$carton_id."'";
		$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($result1))
		{
			$size=$row1["ref_size_name"];
			$color=$row1["color"];
			$combo_code=$row1["combo_no"];
			$style_id=$row1['style_code'];
			$schedule_id=$row1['ref_order_num'];
			// $ex_cut_status=$row1['exces_from'];
			$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
			$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
			$ex_cut_status = echo_title("$bai_pro3.excess_cuts_log","excess_cut_qty","schedule_no='".$schedule."' AND color",$color,$link);
			$sno = 1;
			$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name,order_sizes.size_title FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name where orders.product_schedule='$schedule' and order_sizes.ref_size_name='$size' and order_sizes.order_col_des='$color'";
			$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row22=mysqli_fetch_array($result22))
			{
				$order_qty_col_size=$row22['orderQuantity'];
				$size_code=strtolower($row22['size_name']);
				$size_tit=strtoupper($row22['size_title']);
			}
			$order_tid=$style.$schedule.$color;
			$sql2="SELECT cut_master.cat_ref FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id WHERE cut_master.style_id='".$style_id."' AND cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."' AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
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
				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size group by cut_num order by cut_master.cut_num";
			}
			else
			{
				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size group by cut_num order by cut_master.cut_num*1 desc";						
			}
			$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($result23))
			{
				$cut_num=$sql_row['cut_num'];
				$color_code=$sql_row['col_code'];
				$ratio=$sql_row['quantity'];
				$cut_quantity=$sql_row['total_cut_quantity'];
				if($cut_quantity>0)
				{
					do
					{
						if($sample > 0)
						{
							if($sample>$cut_quantity)
							{	
								// echo "<tr><td>Sample</td><td>$cut_num</td><td>".chr($color_code).leading_zeros(0,$cut_num)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,quantity,docket_number,size_ref,size_tit,combo_code) VALUES ('".$date_time."','".$carton_id."',3,'".$cut_num."','".$color."','".$size."','".$cut_quantity."','".$sql_row['docket_number']."','".$size_code."','".$size_tit."','".$combo_code."')";
								//echo "0=".$insertMiniOrderdata."<br><br>";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$sample=$sample-$cut_quantity;
								$cut_quantity=0;
							}
							else
							{							
								// echo "<tr><td>Sample</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,quantity,docket_number,size_ref,size_tit,combo_code) VALUES ('".$date_time."','".$carton_id."',3,'".$cut_num."','".$color."','".$size."','".$sample."','".$sql_row['docket_number']."','".$size_code."','".$size_tit."','".$combo_code."')";
								//echo "1=".$insertMiniOrderdata."<br><br>"; 
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$cut_quantity=$cut_quantity-$sample;
								$sample=0;							
							}						
						}
						else if($diff_qty > 0)
						{
							if($diff_qty>$cut_quantity)
							{	
								// echo "<tr><td>Excess</td><td>$cut_num</td><td>".chr($color_code).leading_zeros(0,$cut_num)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,quantity,docket_number,size_ref,size_tit,combo_code) VALUES ('".$date_time."','".$carton_id."',2,'".$cut_num."','".$color."','".$size."','".$cut_quantity."','".$sql_row['docket_number']."','".$size_code."','".$size_tit."','".$combo_code."')";
								//echo "0=".$insertMiniOrderdata."<br><br>";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$diff_qty=$diff_qty-$cut_quantity;
								$cut_quantity=0;
							}
							else
							{							
								// echo "<tr><td>Excess</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,quantity,docket_number,size_ref,size_tit,combo_code) VALUES ('".$date_time."','".$carton_id."',2,'".$cut_num."','".$color."','".$size."','".$diff_qty."','".$sql_row['docket_number']."','".$size_code."','".$size_tit."','".$combo_code."')";
								//echo "1=".$insertMiniOrderdata."<br><br>"; 
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$cut_quantity=$cut_quantity-$diff_qty;
								$diff_qty=0;
								if($cut_quantity>0)
								{
									// echo "<tr><td>Normal</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,quantity,docket_number,size_ref,size_tit,combo_code) VALUES ('".$date_time."','".$carton_id."',1,'".$cut_num."','".$color."','".$size."','".$cut_quantity."','".$sql_row['docket_number']."','".$size_code."','".$size_tit."','".$combo_code."')";
									//echo "N=".$insertMiniOrderdata."<br><br>";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$cut_quantity=0;
								}
							}						
						}
						else
						{
							// echo "<tr><td>Normal</td><td>$cut_num</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$size_tit."</td><td>".$cut_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,quantity,docket_number,size_ref,size_tit,combo_code) VALUES ('".$date_time."','".$carton_id."',1,'".$cut_num."','".$color."','".$size."','".$cut_quantity."','".$sql_row['docket_number']."','".$size_code."','".$size_tit."','".$combo_code."')";
							//echo "N1=".$insertMiniOrderdata."<br><br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$cut_quantity=0;
						}
					}while($cut_quantity>0);
				}
			}
		}
		// echo "</table>";
		
		$data_sym="$";
		$File = "session_track.php";
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."status=\"\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh);
		echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_generate.php',0,'N')."&id=$carton_id';</script>");
	}
	else
	{
		echo "<h2>Another User Generating Cartons . Please try again.</h2>";
		session_unset();
	}
	echo "</div></div>";
?>
