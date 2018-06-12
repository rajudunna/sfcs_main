
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
body{
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%;
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>

<body>
<div id="page_heading"><span style="float"><h3>Sewing Jobs Generation</h3></span><span style="float: right"><b></b>&nbsp;</span></div>
<?php
set_time_limit(30000000);
// include("dbconf.php");
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include("session_track.php");
$status="";
if($status == '' || $status == '1')
{
	$mini_order_ref=$_GET['id'];
	$style_ori=$_GET['style'];
	$schedule_ori=$_GET['schedule'];
	$bundle = echo_title("$brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
	
	if($bundle>0)
	{
		echo "<h2>Carton Generation Completed.</h2>";
	}
	else
	{
		$data_sym="$";
		$File = "session_track.php";
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."status=\"".$mini_order_ref."\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh);

		$date_time=date('Y-m-d h:i:sa');
		$sql="select * from $brandix_bts.tbl_min_ord_ref where id='".$mini_order_ref."'";
		// echo $sql."<br>";
		$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			$carton_qty=$row['carton_quantity'];
			$schedule_id=$row['ref_crt_schedule'];
			$style_id=$row['ref_product_style'];
			$max_bundle_qnty=$row['max_bundle_qnty'];
			$mix_bund_per_size=$row['miximum_bundles_per_size'];
			$mini_order_qnty=$row['mini_order_qnty'];
			$carton_method=$row['carton_method'];
		}
		// echo '<br>'.$carton_method;
		$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
		$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
		$carton_id = echo_title("$brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule_id,$link);

		//$bundle_number=echo_title("$brandix_bts.tbl_miniorder_data","max(bundle_number)","",,$link);
		$sql3="select max(bundle_number) as bundle_id from $brandix_bts.tbl_miniorder_data";
		// echo $sql3."<br>";
		$result3=mysqli_query($link, $sql3) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result3)>0)
		{
			while($rows3=mysqli_fetch_array($result3))
			{
				$bundle_number=$rows3['bundle_id']+1;
			}
		}
		else
		{
			$bundle_number=1;
		}

		if($carton_method == '1' || $carton_method == '4')
		{
			// echo "<a href=\"sewing_job_create.php\">Click Here to Back</a>";
			// echo "<h3>Single Color & Single Size Carton Method</h3>";
			if ($carton_method=='4') {
				echo "<h2>Single Color & Multi Size (Non Ratio Pack) Carton Method</h2>";
			}else {
				echo "<h2>Single Color & Single Size Carton Method</h2>";
			}
			echo "<br><div class='alert alert-warning'>Data Saving under process Please wait.....</div>";
			// echo "<table class='table table-striped table-bordered'>";
			// echo "<thead><th>Carton No</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			$sql="select * from $brandix_bts.tbl_min_ord_ref where id=".$mini_order_ref."";
			// echo $sql."<br>";
			$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result))
			{
				$carton_qty=$row['carton_quantity'];
				$schedule_id=$row['ref_crt_schedule'];
				$style_id=$row['ref_product_style'];
				$max_bundle_qnty=$row['max_bundle_qnty'];
				$mix_bund_per_size=$row['miximum_bundles_per_size'];
				$mini_order_qnty=$row['mini_order_qnty'];
				$carton_method=$row['carton_method'];
			}

			$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
			$tbl_cut_master_id=echo_title("$brandix_bts.tbl_cut_master","GROUP_CONCAT(id)","ref_order_num",$schedule_id,$link);
			// echo $schedule."-".$schedule_id."-".$tbl_cut_master_id."<br>";

			$sql1="select ref_size_name as size,color FROM $brandix_bts.tbl_cut_size_master WHERE parent_id IN (".$tbl_cut_master_id.") GROUP BY ref_size_name,color";
			
			$result1=mysqli_query($link, $sql1) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				$size=$row1["size"];
				$color=$row1["color"];
				$mini_num = echo_title("$brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
				if($mini_num == 0 || $mini_num =='')
				{
					$mini_num=1;
				}
				//$ii=1;
				$sno = $mini_num;
				$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
				// echo $order_size_quantity;
				$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row22=mysqli_fetch_array($result22))
				{
					$order_qty_col_size=$row22['orderQuantity'];
					// echo "<br>Order=".$row22['orderQuantity'];
					$size_code=strtolower($row22['size_name']);
				}
				// echo $size_code."-".$order_qty."<br>";
				if($size_code!= '' && $order_qty_col_size!='' )
				{
					$order_tid=$style.$schedule.$color;
				$sql2="SELECT cut_master.cat_ref FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id WHERE cut_master.style_id='".$style_id."' AND cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."' AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
				$result12=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rw=mysqli_fetch_array($result12))
				{
					$cat_ref=$rw['cat_ref'];
				}
				
				$cut_alloc=echo_title("$bai_pro3.allocate_stat_log","SUM(allocate_".$size_code."*plies)","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);

				// echo "<br>Diff=".$cut_alloc." / ".$order_qty_col_size." / Size=".$size."<br>";

				$diff_qty=$cut_alloc-$order_qty_col_size;

				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size group by cut_num order by cut_master.cut_num";
				// echo $sql23."<br>";
				$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($result23))
				{
					$cut_num=$sql_row['cut_num'];
					$color_code=$sql_row['col_code'];
					$ratio=$sql_row['quantity'];
					$bundle_quantity=$sql_row['total_cut_quantity'];
					//echo $cut_num."-".$color_code."-".$ratio."-".$diff_qty."-".$bundle_quantity."<br>";

					$ratio1=0;
					if($cut_num==1)
					{
						$ratio1=$ratio;
					}

					$sql231="SELECT min(cut_master.cut_num) as max_cut FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size AND cut_master.planned_plies*cut_sizes.quantity >=$diff_qty";
					//echo $sql231."<br>";
					$result231=mysqli_query($link, $sql231) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row231=mysqli_fetch_array($result231))
					{
						$max_cut=$sql_row231["max_cut"];
					}

					$sql233="select max(extra_plies) as extra_plies from $bai_pro3.allocate_stat_log where order_tid in (select order_tid from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\")";
					// echo $sql233;/
					$result233=mysqli_query($link, $sql233) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row233=mysqli_fetch_array($result233))
					{
						$extra_plies=$sql_row233["extra_plies"];
					}
					if($extra_plies > 0)
					{
						$extra_plies=$extra_plies;
					}
					else
					{
						$extra_plies=0;
					}

					$sql232="SELECT min(cut_master.cut_num) as min_cut FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size AND cut_master.planned_plies*cut_sizes.quantity > ".($extra_plies*$ratio1)."";
					//echo $sql232."<br>";
					$result232=mysqli_query($link, $sql232) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row232=mysqli_fetch_array($result232))
					{
						$min_cut=$sql_row232["min_cut"];
					}
					$diff_qty=$diff_qty-($extra_plies*$ratio1);
					// echo "<br>extra_plies=".$extra_plies." / ".$sql233."<br>";

					if($cut_num==$min_cut)
					{
						$bundle_quantity=$bundle_quantity-($extra_plies*$ratio1);
						if($bundle_quantity > 0)
						{
							// echo "<tr><td>0.$cut_num/.0</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$extra_plies." / ".$ratio1." /".$extra_plies*$ratio1."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$extra_plies*$ratio1."','".$sql_row['docket_number']."',0)";
							//echo "0=".$insertMiniOrderdata."<br><br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}

					// echo "<br>Max=".$max_cut. " / Cut=".$cut_num." / Min=".$min_cut." / Diff=".$diff_qty."<br><br>";
					if($diff_qty>0)
					{
						if($bundle_quantity>=$diff_qty)
						{
							// echo "<tr><td>0.$cut_num/.1</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."',0)";
							//	echo "1=".$insertMiniOrderdata."<br><br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
							if(($bundle_quantity-$diff_qty)>0)
							{
								if($max_cut==$cut_num)
								{
									// echo "<tr><td>".$cut_num."/.2</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity. " - ".$diff_qty." - ".($bundle_quantity-$diff_qty)."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity-$diff_qty)."','".$sql_row['docket_number']."','".$sno."')";
									// echo "2=".$insertMiniOrderdata."<br><br>";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
									$diff_qty=0;
								}
								else
								{
									// echo "<tr><td>".$cut_num."/.3</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".($bundle_quantity)."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity)."','".$sql_row['docket_number']."','".$sno."')";
									// echo "3=".$insertMiniOrderdata."<br><br>";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
							}

						}
						else
						{
							// echo "<tr><td>$cut_num/.4</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','0')";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							// echo "4=".$insertMiniOrderdata."<br><br>";
							$bundle_number++;
							$diff_qty-=$bundle_quantity;
						}
					}
					else
					{
						// echo "<tr><td>".$cut_num."/.5</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
						$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
						// echo "5=".$insertMiniOrderdata."<br><br>";
						$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$bundle_number++;
					}
				}

				}
				else{
					echo "<div class='alert alert-danger'>
					<strong>INFO!</strong> No SIZE CODE for this Style and Schedule.
				  </div>";
					header('Location:'.getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N'));
				echo "<script>
							var url = '".getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N')."';
							
									window.location.href=url+'&msg='+1;
							
				</script>";
				}
				
			}

			// header("Location:mini_order_gen_cut_ss.php?id=$mini_order_ref&mode=$carton_method");

			echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mini_order_gen_cut_ss.php',0,'N')."&id=$mini_order_ref&mode=$carton_method&style=$style_ori&schedule=$schedule_ori';</script>");
		}
		if($carton_method == '2')
		{
			// echo "<a href=\"sewing_job_create.php\">Click Here to Back</a>";
			echo "<h3>Multi Color & Single Size Carton Method</h3>";
			echo "<br><div class='alert alert-warning'>Data Saving under process Please wait.....</div>";
			// echo "<table class='table table-striped table-bordered'>";
			// echo "<thead><th>Carton No</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			$sql="select * from $brandix_bts.tbl_min_ord_ref where id=".$mini_order_ref."";
			// echo $sql."<br>";
			$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result))
			{
				$carton_qty=$row['carton_quantity'];
				$schedule_id=$row['ref_crt_schedule'];
				$style_id=$row['ref_product_style'];
				$max_bundle_qnty=$row['max_bundle_qnty'];
				$mix_bund_per_size=$row['miximum_bundles_per_size'];
				$mini_order_qnty=$row['mini_order_qnty'];
				$carton_method=$row['carton_method'];
			}
			// echo $carton_qty."-".$schedule_id."-".$style_id."-".$max_bundle_qnty."-".$mix_bund_per_size."-".$mini_order_qnty."-".$carton_method."<br>";
			// die();
			$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
			$tbl_cut_master_id=echo_title("$brandix_bts.tbl_cut_master","GROUP_CONCAT(id)","ref_order_num",$schedule_id,$link);
			//echo $schedule."-".$schedule_id."-".$tbl_cut_master_id."<br>";

			$sql1="select ref_size_name as size,color FROM $brandix_bts.tbl_cut_size_master WHERE parent_id IN (".$tbl_cut_master_id.") GROUP BY ref_size_name,color";
			//echo $sql1."<br>";
			$result1=mysqli_query($link, $sql1) or die ("Error1.2=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row1=mysqli_fetch_array($result1))
			{
				$size=$row1["size"];
				$color=$row1["color"];
				$mini_num = echo_title("$brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
				if($mini_num == 0 || $mini_num =='')
				{
					$mini_num=1;
				}
				//$ii=1;
				$sno = $mini_num;
				$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id	LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name	where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
				//echo $order_size_quantity."<br>";
				$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row22=mysqli_fetch_array($result22))
				{
					$order_qty_col_size=$row22['orderQuantity'];
					$size_code=strtolower($row22['size_name']);
				}
				if($size_code!='' && $order_qty_col_size!=''){

					$order_tid=$style.$schedule.$color;
				$sql2="SELECT cut_master.cat_ref	FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id 	WHERE cut_master.style_id='".$style_id."' AND cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."'	AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
				$result12=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rw=mysqli_fetch_array($result12))
				{
					$cat_ref=$rw['cat_ref'];
				}

				$cut_alloc=echo_title("$bai_pro3.allocate_stat_log","SUM(allocate_".$size_code."*plies)","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
				$diff_qty=$cut_alloc-$order_qty_col_size;

				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size group by cut_num order by cut_master.cut_num";
				// echo $sql23."<br>";
				$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($result23))
				{
					$cut_num=$sql_row['cut_num'];
					$color_code=$sql_row['col_code'];
					$ratio=$sql_row['quantity'];
					$bundle_quantity=$sql_row['total_cut_quantity'];
					//echo $cut_num."-".$color_code."-".$ratio."-".$diff_qty."-".$bundle_quantity."<br>";

					$sql231="SELECT min(cut_master.cut_num) as max_cut FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size AND cut_master.planned_plies*cut_sizes.quantity >=$diff_qty";
					// echo $sql231."<br>";
					$result231=mysqli_query($link, $sql231) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row231=mysqli_fetch_array($result231))
					{
						$max_cut=$sql_row231["max_cut"];
					}

					$sql233="select max(extra_plies) as extra_plies from $bai_pro3.allocate_stat_log where order_tid in (select order_tid from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\")";
					$result233=mysqli_query($link, $sql233) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row233=mysqli_fetch_array($result233))
					{
						$extra_plies=$sql_row233["extra_plies"];
					}

					$sql232="SELECT min(cut_master.cut_num) as min_cut FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size AND cut_master.planned_plies*cut_sizes.quantity > ".($extra_plies*$ratio)."";
					// echo "3=".$sql232."<br>";
					$result232=mysqli_query($link, $sql232) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row232=mysqli_fetch_array($result232))
					{
						$min_cut=$sql_row232["min_cut"];
					}

					// echo "<br>extra_plies=".$extra_plies." / ".$sql233."<br>";

					if($cut_num==$min_cut)
					{
						$bundle_quantity=$bundle_quantity-($extra_plies*$ratio);
						$diff_qty=$diff_qty-($extra_plies*$ratio);
						// echo "<tr><td>5-".$max_cut."-".$cut_num."-".$min_cut."</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$extra_plies*$ratio."</td><td>".$sql_row['docket_number']."</td></tr>";
						$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$extra_plies*$ratio."','".$sql_row['docket_number']."',0)";
						$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}

					// echo "<br>Max=".$max_cut. " / ".$cut_num." / ".$min_cut." / ".$bundle_quantity."<br><br>";
					if($diff_qty>0)
					{
						if($bundle_quantity>=$diff_qty)
						{
							// echo "<tr><td>4-".$max_cut."-".$cut_num."-".$min_cut."</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."',0)";
							//echo "1=".$insertMiniOrderdata."<br><br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
							if(($bundle_quantity-$diff_qty)>0)
							{
								if($max_cut==$cut_num)
								{
									// echo "<tr><td>1-".$max_cut."-".$cut_num."-".$min_cut."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".($bundle_quantity-$diff_qty)."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity-$diff_qty)."','".$sql_row['docket_number']."','".$sno."')";
									//echo "2=".$insertMiniOrderdata."<br><br>";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
									$diff_qty=0;
								}
								else
								{
									// echo "<tr><td>2-".$max_cut."-".$cut_num."-".$min_cut."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".($bundle_quantity)."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity)."','".$sql_row['docket_number']."','".$sno."')";
									//echo "2=".$insertMiniOrderdata."<br><br>";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
							}

						}
						else
						{
							// echo "<tr><td>0-".$max_cut."-".$cut_num."-".$min_cut."</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','0')";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo "3=".$insertMiniOrderdata."<br><br>";
							$bundle_number++;
							$diff_qty-=$bundle_quantity;
						}
					}
					else
					{
						// echo "<tr><td>3-".$max_cut."-".$cut_num."-".$min_cut."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
						$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
						$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$bundle_number++;
					}
				}
				}else{
					echo "<script>
							var url = '".getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N')."';
									window.location.href=url+'&msg='+1;	
						 </script>";
				}
				
			}
			// header("Location:mini_order_gen_cut_ms.php?id=$mini_order_ref&mode=$carton_method");
			echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mini_order_gen_cut_ms.php',0,'N')."&id=$mini_order_ref&mode=$carton_method&style=$style_ori&schedule=$schedule_ori';</script>");
			// echo("<script>location.href = 'mini_order_gen_cut_ms.php?id=$mini_order_ref&mode=$carton_method';</script>");
		}

		if($carton_method == '3')
		{
			// echo "<a href=\"sewing_job_create.php\">Click Here to Back</a>";
			echo "<h3>Multi Color & Multi Size Carton Method</h3>";
			echo "<br><div class='alert alert-warning'>Data Saving under process Please wait.....</div>";
			// echo "<table class='table table-striped table-bordered'>";
			// echo "<thead><th>Carton No</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			//echo $order_size_quantity."<br>";

			$sql_sizes="SELECT * FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN(SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule_id AND style_code=$style_id) GROUP BY color,ref_size_name order by id";
			$sql_result=mysqli_query($link, $sql_sizes) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rat_con='';
			while($row=mysqli_fetch_array($sql_result))
			{
				//$col_con=$row['col_con'];
				if($rat_con=='')
				{
					$min_ratio=echo_title("$brandix_bts.tbl_carton_size_ref","min(quantity)","parent_id",$row['parent_id'],$link);
					$tmp_col_con=echo_title("$brandix_bts.tbl_carton_size_ref","group_concat(distinct color ORDER BY id  SEPARATOR '$')","parent_id",$row['parent_id'],$link);
				}
				$rat_con.=($row['quantity']/$min_ratio)."$";
			}
			$code_concat=$rat_con.$tmp_col_con;
			//$l=1;
			$get_carton_detail_query="SELECT color,ref_size_name,quantity FROM $brandix_bts.tbl_carton_size_ref where parent_id in(select id from $brandix_bts.tbl_carton_ref where ref_order_num=$schedule_id and style_code=$style_id) group by color,ref_size_name ORDER BY color,ref_size_name";
			// echo $get_carton_detail_query."<br>";

			$result2=mysqli_query($link, $get_carton_detail_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($carton=mysqli_fetch_array($result2))
			{
				$color=$carton['color'];
				$size=$carton['ref_size_name'];
				$ratio_mini=echo_title("$brandix_bts.tbl_min_ord_ref","miximum_bundles_per_size","ref_crt_schedule",$schedule_id,$link);
				$carton_ratio=$carton['quantity']*$ratio_mini;
				$size_con=echo_title("$brandix_bts.tbl_orders_size_ref","LOWER(size_name)","id",$size,$link);
				$sno=1;
				//$ii=1;
				$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id 	LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name	where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
				$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row22=mysqli_fetch_array($result22))
				{
					$order_qty_col_size=$row22['orderQuantity'];
					$size_code=strtolower($row22['size_name']);
				}
				if($size_code!='' && $order_qty_col_size!=''){
					$order_tid=$style.$schedule.$color;
				$sql2="SELECT cut_master.cat_ref FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id WHERE cut_master.style_id='".$style_id."' AND cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."'	AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
				$result12=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rw=mysqli_fetch_array($result12))
				{
					$cat_ref=$rw['cat_ref'];
				}
				//$cut_alloc=echo_title("$bai_pro3.cuttable_stat_log","cuttable_s_$size_code","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
				$cut_alloc=echo_title("$bai_pro3.allocate_stat_log","SUM(allocate_".$size_code."*plies)","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
				$diff_qty=$cut_alloc-$order_qty_col_size;
				$diff_qty_cfirm=$cut_alloc-$order_qty_col_size;
				// echo "Cut=".$cut_alloc."-".$size_code."-".$order_qty_col_size."<br><br>";
				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code	FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size order by cut_master.cut_num";
				// echo "QUE=".$sql23."<br><br>";/

				$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$temp_qty=0;
				while($sql_row=mysqli_fetch_array($result23))
				{
					$cut_num=$sql_row['cut_num'];
					$color_code=$sql_row['col_code'];
					$ratio=$sql_row['quantity'];
					$total_cut_qty=$sql_row['total_cut_quantity'];
					$bundle_quantity=$total_cut_qty;

					$sno=$sno+1;

					if($diff_qty>0)
					{
						if($bundle_quantity>=$diff_qty)
						{
							// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."',0)";
							// echo "Que0=".$insertMiniOrderdata."<br>";
							// echo $insertMiniOrderdata."<br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
							if(($bundle_quantity-$diff_qty)>0)
							{
								// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".($bundle_quantity-$diff_qty)."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity-$diff_qty)."','".$sql_row['docket_number']."','".$sno."')";
								// echo "Que1=".$insertMiniOrderdata."<br>";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							$diff_qty=0;
						}
						else
						{
							// echo "<tr><td>0</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','0')";
							// echo "Que2=".$insertMiniOrderdata."<br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
							$diff_qty-=$bundle_quantity;
						}
					}
					else
					{
							if($temp_qty>=$carton_ratio)
							{
								$sno++;
								$temp_qty=0;
							}
							$temp_qty+=$bundle_quantity;
							// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";

							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
							// echo "Que3=".$insertMiniOrderdata."<br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
					}
				}
				}else{
					echo "<script>
							var url = '".getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N')."';
									window.location.href=url+'&msg='+1;	
						 </script>";

				}
				
			}
			// header("Location:mini_order_gen_cut_mm.php?id=$mini_order_ref&mode=$carton_method");

			echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mini_order_gen_cut_mm.php',0,'N')."&id=$mini_order_ref&mode=$carton_method&style=$style_ori&schedule=$schedule_ori';</script>");
			// echo("<script>location.href = 'mini_order_gen_cut_mm.php?id=$mini_order_ref&mode=$carton_method';</script>");
		}

		if($carton_method == '5')
		{
			// echo "<a href=\"sewing_job_create.php\">Click Here to Back</a>";
			echo "<h3>Multi Color & Multi Size Carton Method</h3>";
			echo "<br><div class='alert alert-warning'>Data Saving under process Please wait.....</div>";
			// echo "<table class='table table-striped table-bordered'>";
			// echo "<thead><th>Carton No</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			//echo $order_size_quantity."<br>";

			$sql_sizes="SELECT * FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id IN(SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule_id AND style_code=$style_id) GROUP BY color,ref_size_name order by id";
			$sql_result=mysqli_query($link, $sql_sizes) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rat_con='';
			while($row=mysqli_fetch_array($sql_result))
			{
				//$col_con=$row['col_con'];
				if($rat_con=='')
				{
					$min_ratio=echo_title("$brandix_bts.tbl_carton_size_ref","min(quantity)","parent_id",$row['parent_id'],$link);
					$tmp_col_con=echo_title("$brandix_bts.tbl_carton_size_ref","group_concat(distinct color ORDER BY id  SEPARATOR '$')","parent_id",$row['parent_id'],$link);
				}
				$rat_con.=($row['quantity']/$min_ratio)."$";
			}
			$code_concat=$rat_con.$tmp_col_con;
			//$l=1;
			$get_carton_detail_query="SELECT color,ref_size_name,quantity FROM $brandix_bts.tbl_carton_size_ref where parent_id in(select id from $brandix_bts.tbl_carton_ref where ref_order_num=$schedule_id and style_code=$style_id) group by color,ref_size_name ORDER BY color,ref_size_name";
			// echo $get_carton_detail_query."<br>";

			$result2=mysqli_query($link, $get_carton_detail_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($carton=mysqli_fetch_array($result2))
			{
				$color=$carton['color'];
				$size=$carton['ref_size_name'];
				$ratio_mini=echo_title("$brandix_bts.tbl_min_ord_ref","miximum_bundles_per_size","ref_crt_schedule",$schedule_id,$link);
				$carton_ratio=$carton['quantity']*$ratio_mini;
				$size_con=echo_title("$brandix_bts.tbl_orders_size_ref","LOWER(size_name)","id",$size,$link);
				$sno=1;
				//$ii=1;
				$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id	LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name	where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
				$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row22=mysqli_fetch_array($result22))
				{
					$order_qty_col_size=$row22['orderQuantity'];
					$size_code=strtolower($row22['size_name']);
				}
				if($size_code!='' && $order_qty_col_size!='')
				{
					$order_tid=$style.$schedule.$color;
				$sql2="SELECT cut_master.cat_ref FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id WHERE cut_master.style_id='".$style_id."' AND cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."'	AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
				$result12=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rw=mysqli_fetch_array($result12))
				{
					$cat_ref=$rw['cat_ref'];
				}

				//$cut_alloc=echo_title("$bai_pro3.cuttable_stat_log","cuttable_s_$size_code","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
				$cut_alloc=echo_title("$bai_pro3.allocate_stat_log","SUM(allocate_".$size_code."*plies)","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
				$diff_qty=$cut_alloc-$order_qty_col_size;
				$diff_qty_cfirm=$cut_alloc-$order_qty_col_size;
				// echo "Cut=".$cut_alloc."-".$size_code."-".$order_qty_col_size."<br><br>";
				$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code	FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size order by cut_master.cut_num";
				// echo "QUE=".$sql23."<br><br>";

				$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$temp_qty=0;
				while($sql_row=mysqli_fetch_array($result23))
				{
					$cut_num=$sql_row['cut_num'];
					$color_code=$sql_row['col_code'];
					$ratio=$sql_row['quantity'];
					$total_cut_qty=$sql_row['total_cut_quantity'];
					$bundle_quantity=$total_cut_qty;

					$ratio1=0;
					if($cut_num==1)
					{
						$ratio1=$ratio;
					}

					$sql233="select max(extra_plies) as extra_plies from $bai_pro3.allocate_stat_log where order_tid in (select order_tid from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\")";
					$result233=mysqli_query($link, $sql233) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row233=mysqli_fetch_array($result233))
					{
						$extra_plies=$sql_row233["extra_plies"];
					}

					$sql232="SELECT min(cut_master.cut_num) as min_cut FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size AND cut_master.planned_plies*cut_sizes.quantity > ".($extra_plies*$ratio1)."";
					//echo $sql232."<br>";
					$result232=mysqli_query($link, $sql232) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row232=mysqli_fetch_array($result232))
					{
						$min_cut=$sql_row232["min_cut"];
					}
					$diff_qty=$diff_qty-($extra_plies*$ratio1);
					$sno=$sno+1;

					if($cut_num==$min_cut)
					{
						$bundle_quantity=$bundle_quantity-($extra_plies*$ratio1);
						// echo "<tr><td>0.$cut_num.1</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$extra_plies." / ".$ratio1." /".$extra_plies*$ratio1."</td><td>".$sql_row['docket_number']."</td></tr>";
						$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$extra_plies*$ratio1."','".$sql_row['docket_number']."',0)";
						$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}

					if($diff_qty>0)
					{
						if($bundle_quantity>=$diff_qty)
						{
							// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."',0)";
							// echo "Que0=".$insertMiniOrderdata."<br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
							if(($bundle_quantity-$diff_qty)>0)
							{
								// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".($bundle_quantity-$diff_qty)."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity-$diff_qty)."','".$sql_row['docket_number']."','".$sno."')";
								// echo "Que1=".$insertMiniOrderdata."<br>";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							$diff_qty=0;
						}
						else
						{
							// echo "<tr><td>0</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','0')";
							// echo "Que2=".$insertMiniOrderdata."<br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
							$diff_qty-=$bundle_quantity;
						}
					}
					else
					{
							if($temp_qty>=$carton_ratio)
							{
								$sno++;
								$temp_qty=0;
							}
							$temp_qty+=$bundle_quantity;
							// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";

							$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
							// echo "Que3=".$insertMiniOrderdata."<br>";
							$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$bundle_number++;
					}
				}

				}else{
					echo "<script>
							var url = '".getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N')."';
									window.location.href=url+'&msg='+1;	
						 </script>";
				}
				
			}
			// header("Location:mini_order_gen_cut_smr.php?id=$mini_order_ref&mode=$carton_method");
			// $url5 = getFullURL($_GET['r'],'mini_order_gen_cut_smr.php','N');
			echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mini_order_gen_cut_smr.php',0,'N')."&id=$mini_order_ref&mode=$carton_method&style=$style_ori&schedule=$schedule_ori';</script>");
			// echo("<script>location.href = '".$url5."&id=$mini_order_ref&mode=$carton_method&style=$style_ori&schedule=$schedule_ori';</script>");
		}

		if($carton_method == '-1')
		{
			// echo "<a href=\"sewing_job_create.php\">Click Here to Back</a>";
			echo "<h3>Single Color & Multi Size Carton Method</h3>";
			echo "<br><div class='alert alert-warning'>Data Saving under process Please wait.....</div>";
			// echo "<table class='table table-striped table-bordered'>";
			//$l=1;
			// echo "<thead><th>Carton No</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			$sql_sizes="SELECT parent_id,color,group_concat(quantity order by id) as qty FROM $brandix_bts.tbl_carton_size_ref WHERE parent_id
				  IN(SELECT id FROM $brandix_bts.tbl_carton_ref WHERE ref_order_num=$schedule_id AND style_code=$style_id) GROUP BY color ORDER BY color";
			$sql_result=mysqli_query($link, $sql_sizes) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($sql_result))
			{

				$mini_num = echo_title("$brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
				if($mini_num == 0 || $mini_num =='')
				{
					$mini_num=1;
					//$last_id=1;
				}
				else
				{
					//$last_id=$ii;
					$mini_num=$mini_num;
				}
				$min_ratio=echo_title("$brandix_bts.tbl_carton_size_ref","min(quantity)","parent_id",$row['parent_id'],$link);
				$tmp_ratio=explode(",",$row['qty']);
				$rat_con='';
				for($i=0;$i<sizeof($tmp_ratio);$i++)
				{
					//echo $tmp_ratio[$i]."/".$min_ratio."<br>";
					$rat_con.=($tmp_ratio[$i]/$min_ratio)."$";
				}
				$code_concat=$rat_con.$row['color'];
				$get_carton_detail_query="SELECT color,ref_size_name,quantity FROM $brandix_bts.tbl_carton_size_ref where parent_id in(select id from $brandix_bts.tbl_carton_ref where ref_order_num=$schedule_id and style_code=$style_id) and color='".$row['color']."' ORDER BY ref_size_name,color";
				$result2=mysqli_query($link, $get_carton_detail_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($carton=mysqli_fetch_array($result2))
				{
					$sno=$mini_num;
					//$ii=$last_id;
					$color=$carton['color'];
					$size=$carton['ref_size_name'];
					$size_con=echo_title("$brandix_bts.tbl_orders_size_ref","LOWER(size_name)","id",$size,$link);
					$ratio_mini=echo_title("$brandix_bts.tbl_min_ord_ref","miximum_bundles_per_size","ref_crt_schedule",$schedule_id,$link);
					$carton_ratio=$carton['quantity']*$ratio_mini;
					$order_size_quantity="SELECT COALESCE(SUM(order_sizes.order_quantity),0) AS orderQuantity,sizes.size_name FROM $brandix_bts.tbl_orders_master as orders	LEFT JOIN $brandix_bts.tbl_orders_sizes_master AS order_sizes ON orders.id=order_sizes.parent_id LEFT JOIN $brandix_bts.tbl_orders_size_ref AS sizes ON sizes.id=order_sizes.ref_size_name	where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
					// echo $order_size_quantity."<br>";
					$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row22=mysqli_fetch_array($result22))
					{
						$order_qty_col_size=$row22['orderQuantity'];
						$size_code=strtolower($row22['size_name']);
					}
					if($size_code!='' && $order_qty!=''){
						$order_tid=$style.$schedule.$color;
						$sql2="SELECT cut_master.cat_ref	FROM $brandix_bts.tbl_cut_master AS cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master AS cut_sizes ON cut_master.id=cut_sizes.parent_id	WHERE cut_master.style_id='".$style_id."' AND cut_master.product_schedule='".$schedule."' AND cut_sizes.color='".$color."' AND cut_sizes.ref_size_name='".$size."' GROUP BY cut_master.cat_ref limit 1";
						// echo "<br>SQL2=".$sql2."<br>";
						$result12=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rw=mysqli_fetch_array($result12))
						{
							$cat_ref=$rw['cat_ref'];
						}
						//$cut_alloc=echo_title("$bai_pro3.cuttable_stat_log","cuttable_s_$size_code","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
						$cut_alloc=echo_title("$bai_pro3.allocate_stat_log","SUM(allocate_".$size_code."*plies)","cat_ref='".$cat_ref."' and order_tid",$order_tid,$link);
						// echo "<BR>Cut=".$cut_alloc."<br>";
						$diff_qty=$cut_alloc-$order_qty_col_size;
						// echo "<BR>diff_qty=".$diff_qty."=".$cut_alloc."-".$order_qty_col_size."<br>";
						$diff_qty_cfirm=$cut_alloc-$order_qty_col_size;
						// echo "<BR>diff_qty=".$diff_qty_cfirm."=".$cut_allosc."-".$order_qty_col_size."<br>";
						$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title,cut_master.col_code FROM $brandix_bts.tbl_cut_master as cut_master LEFT JOIN $brandix_bts.tbl_cut_size_master as cut_sizes ON cut_master.id=cut_sizes.parent_id left join $brandix_bts.tbl_orders_size_ref as sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size order by cut_master.cut_num";
						// echo "<br>SQL23".$sql23."<br>";
						$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						$temp_qty=0;
						while($sql_row=mysqli_fetch_array($result23))
						{
							$cut_num=$sql_row['cut_num'];
							$color_code=$sql_row['col_code'];
							$ratio=$sql_row['quantity'];
							$bundle_quantity=$sql_row['planned_plies'];
							// echo "<BR>".$size."-".$ratio."-".$bundle_quantity."-".$diff_qty."<br>";
							for($i=0;$i<$ratio;$i++)
							{
								if($diff_qty>0)
								{
									if($bundle_quantity>=$diff_qty)
									{
										// echo "<tr><td>0</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."',0)";
										// echo "<br>insertMiniOrderdata=".$insertMiniOrderdata."<br>";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
										if(($bundle_quantity-$diff_qty)>0)
										{
											// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".($bundle_quantity-$diff_qty)."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".($bundle_quantity-$diff_qty)."','".$sql_row['docket_number']."','".$sno."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											$temp_qty+=$bundle_quantity-$diff_qty;
										}
										$diff_qty=0;
									}
									else
									{
										// echo "<tr><td>0</td><td>".chr($color_code).leading_zeros(0,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."',0,'".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','0')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
										$diff_qty-=$bundle_quantity;
									}
								}
								else
								{
									if($temp_qty>=$carton_ratio)
									{
										$sno++;
										$temp_qty=0;
									}
										$temp_qty+=$bundle_quantity;
										// echo "<tr><td>".$sno."</td><td>".chr($color_code).leading_zeros($cut_num,3)."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
	
										$insertMiniOrderdata="INSERT INTO $brandix_bts.tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
								}
						
							}
							echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mini_order_gen_cut_ss.php',0,'N')."&id=$mini_order_ref&mode=$carton_method&style=$style_ori&schedule=$schedule_ori';</script>");
							// echo("<script>location.href = 'mini_order_gen_cut_ss.php?id=$mini_order_ref&mode=$carton_method';</script>");
						}
					}else{
						echo "<script>
							var url = '".getFullURLLevel($_GET['r'],'sewing_job_create.php',0,'N')."';
									window.location.href=url+'&msg='+1;	
						 </script>";
					}

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
		// echo "</table>";
	}
}
else
{
	echo "<h2>Another User Generating Cartons . Please try again.</h2>";
	session_unset();
	//session_destroy();
}
?>
