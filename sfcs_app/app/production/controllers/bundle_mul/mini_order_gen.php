<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
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
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
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
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>


<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="page_heading"><span style="float: left"><h3>Mini Order Generation</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php
function split_values($bundle_val,$link)
{
	if(($bundle_val%2)==0)
	{
		$val=$bundle_val/2;
		$val_qty=$val."$".$val;
		return $val_qty;
	}
	else
	{
		$val=ceil($bundle_val/2);
		$val_qty=$val."$".($val-1);
		return $val_qty;
	}
}
set_time_limit(30000000);
include("dbconf.php");
include("session_track.php");
if($status == '')
{
	$mini_order_ref=$_GET['id'];
	$split_status=$_GET['split_code'];
	$split_quantity= echo_title("brandix_bts.tbl_min_ord_ref","split_qty","id",$mini_order_ref,$link);
	$bundle = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
	if($bundle>0)
	{
		echo "<h2>Mini orders Generation Completed.</h2>";
	}
	else
	{
		$data_sym="$";
		$File = "session_track.php";
		$fh = fopen($File, 'w') or die("can't open file");
		$stringData = "<?php ".$data_sym."status=\"".$mini_order_ref."\"; ?>";
		fwrite($fh, $stringData);
		fclose($fh); 
		//$mini_order_ref=356;
		$date_time=date('Y-m-d h:i:sa'); 
		$sql="select * from brandix_bts.tbl_min_ord_ref where id='".$mini_order_ref."'";
		//echo $sql."<br>";
		$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{
			$carton_qty=$row['carton_quantity'];
			$schedule_id=$row['ref_crt_schedule'];
			$style_id=$row['ref_product_style'];
			$max_bundle_qnty=$row['max_bundle_qnty'];
			$mix_bund_per_size=$row['miximum_bundles_per_size'];
			$mini_order_qnty=$row['mini_order_qnty'];
		}
		$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
		$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
		$sql1="select max(id),count(*),max(FLOOR(mini_order_num)) as mini_order from tbl_miniorder_data where mini_order_ref in(select id from tbl_min_ord_ref where ref_product_style=$style_id)";
		//echo $sql1."<br>";
		$result1=mysqli_query($link, $sql1) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row_count=mysqli_num_rows($result1);
		//echo $row_count."<br>";
		if($row_count>0)
		{
			while($row1=mysqli_fetch_array($result1))
			{
				$mini_num=$row1['mini_order']+1;
				//echo $mini_num."<br>";
			}
		}
		else
		{
			$mini_num=1;
			//echo $mini_num."<br>";
		}
		//$bundle_number=echo_title("brandix_bts.tbl_miniorder_data","max(bundle_number)","",,$link);
		$sql3="select max(bundle_number) as bundle_id from brandix_bts.tbl_miniorder_data";
		//echo $sql3."<br>";
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
		//echo $bundle_number;
		$sql2="select COALESCE(sum(order_sizes.order_quantity),0) as orderQuantity from tbl_orders_master orders left join tbl_orders_sizes_master order_sizes on orders.id=order_sizes.parent_id where orders.ref_product_style=$style_id and orders.product_schedule='$schedule'";
		//echo $sql2."<br>";
		$result2=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($result2))
		{
			$order_qty=$row2['orderQuantity'];
		}
		echo "<a href=\"mini_order_create.php\">Click Here to Back</a>";
		echo "<table class='blue' border=1px>";
		echo "<thead><th>Mini Order No</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
		//echo $order_qty."---".$mini_order_qnty."<br>";
		if(($order_qty!=$mini_order_qnty) && ($order_qty>$mini_order_qnty))
		{
			if($mini_num>1)
			{
				//$tota_mini=($order_qty/$mini_order_qnty);
				$total_mini_orders=round($order_qty/$mini_order_qnty);
				$total_mini_orders_count=$total_mini_orders+$mini_num-1;
				//$previous_min=round($tota_mini);
				$sno=$mini_num;
				$last_min_order=0;
				//echo "--O-".$order_qty."--MQ-".$mini_order_qnty."--M-".$mini_num."--E-".$tota_mini."--T-".$total_mini_orders."--L-".$last_min_order."<br>";
			}
			else
			{
				//$tota_mini=$order_qty/$mini_order_qnty;
				$total_mini_orders=round($order_qty/$mini_order_qnty);
				$total_mini_orders_count=$total_mini_orders;
				$sno=$mini_num;
				//$previous_min=round($tota_mini);
				$last_min_order=0;
				//echo "1--O-".$order_qty."--MQ-".$mini_order_qnty."--M-".$mini_num."--E-".$tota_mini."--T-".$total_mini_orders."--L-".$last_min_order."<br>";
			}
			$get_carton_detail_query="SELECT color,ref_size_name,quantity FROM tbl_carton_size_ref where parent_id in(select id from tbl_carton_ref where ref_order_num=$schedule_id and style_code=$style_id) ORDER BY color,ref_size_name";
			//echo $get_carton_detail_query."<br>";
			$result2=mysqli_query($link, $get_carton_detail_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($carton=mysqli_fetch_array($result2))
			{
				$temp_quantity=0;$sno=$mini_num;
				$diff_qty=0;$order_fill_status=0;
				$order_fill=0;$ii=1;
				$color=$carton['color'];
				$size=$carton['ref_size_name'];
				$carton_ratio=$carton['quantity'];
				$total_quantity=0;
				$order_size_quantity="select COALESCE(sum(order_sizes.order_quantity),0) as orderQuantity from tbl_orders_master orders 
				left join tbl_orders_sizes_master order_sizes on orders.id=order_sizes.parent_id 
				where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
				//echo $order_size_quantity."<br>";
				$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row22=mysqli_fetch_array($result22))
				{
					$order_qty_col_size=$row22['orderQuantity'];
				}
				
				$mini_order_quantity=$carton_ratio*$mix_bund_per_size*$max_bundle_qnty;
				//echo $carton_ratio."*".$mix_bund_per_size."*".$max_bundle_qnty."---".$mini_order_quantity."<br>";
				$sql23="SELECT cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title
				FROM tbl_cut_master cut_master LEFT JOIN tbl_cut_size_master cut_sizes ON cut_master.id=cut_sizes.parent_id left join tbl_orders_size_ref sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size";
				//echo $sql23."<br>";
				$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo "---".mysql_num_rows($result23)."<br>";
				while($sql_row=mysqli_fetch_array($result23))
				{
					//echo "Test"."<br>";
					$cut_num=$sql_row['cut_num'];
					$ratio=$sql_row['quantity'];
					$bundle_quantity=$sql_row['planned_plies'];
					//echo $cut_num."--".$ratio."--".$bundle_quantity."<br>";
					for($i=0;$i<$ratio;$i++)
					{
						$temp_quantity+=$bundle_quantity;
						$total_quantity+=$bundle_quantity;
						if($order_qty_col_size>=$total_quantity)
						{
							if($ii==$total_mini_orders)
							{
								//$sno;
							}
							if($split_status==1)
							{
								if($bundle_quantity>$split_quantity)
								{
									$quantities=split_values($bundle_quantity,$link);
									$quantity_bundle=explode("$",$quantities);		
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[1]."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
									
								
								}
								else
								{
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
								
							}
							else
							{
								echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$bundle_number++;
							}
							
							if($temp_quantity>=$mini_order_quantity)
							{
								if($ii==$total_mini_orders)
								{
									//$sno;
								}
								else
								{
									$sno++;
									$ii++;
									$temp_quantity=0;
								}
							}
							
						}
						else
						{
							if($order_fill_status==0)
							{
								$order_fill=$order_qty_col_size-($total_quantity-$bundle_quantity);
								$diff_qty=$bundle_quantity-$order_fill;
								$order_fill_status=1;
								if($order_fill==0)
								{
									$temp_full=$bundle_quantity;
								}
								$total_mini_orders_count=echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)","mini_order_ref='".$mini_order_ref."' and size='".$size."' and color",$color,$link);
								if($order_fill>0)
								{
									if($split_status==1)
									{
										if($order_fill>$split_quantity)
										{
											$quantities_fil=split_values($order_fill,$link);
											//echo $quantities_fil."<br>";
											$quantity_bundle=explode("$",$quantities_fil);		
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[1]."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											
											
											if($diff_qty>0)
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$diff_qty."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
												
											
										}
										else
										{
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$order_fill."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											if($diff_qty>0)
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$diff_qty."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
										}
										 
									}
									else
									{
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$order_fill."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											if($diff_qty>0)
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$diff_qty."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
									}
								
								}
								else
								{
									if($temp_full>0)
									{
										if($split_status==1)
										{
											if($temp_full>$split_quantity)
											{
												$quantities_fil=split_values($temp_full,$link);
												$quantity_bundle=explode("$",$quantities_fil);		
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
												//echo "3----".$i."<br>";
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
												//echo "3----".$i."<br>";		
												
											}
											else
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$temp_full."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
											
										}
										else
										{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$temp_full."','".$sql_row['docket_number']."','".$last_min_order."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
										}
										
									}
								
								}
							
							}
							else
							{
								if($split_status==1)
								{
									if($bundle_quantity>$split_quantity)
									{
										$quantities_fil=split_values($bundle_quantity,$link);
										$quantity_bundle=explode("$",$quantities_fil);		
										echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
										//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$last_min_order."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
										echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[1]."</td><td>".$sql_row['docket_number']."</td></tr>";
										//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$last_min_order."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;	
										
									}
									else
									{
										echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$last_min_order."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
									}
									
								}
								else
								{
									echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$last_min_order."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
							}
						}
					}	
				}
			}
			$last_min_order=echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
			$sql="update brandix_bts.tbl_miniorder_data set mini_order_num='".$last_min_order."' where mini_order_ref='".$mini_order_ref."' and mini_order_num=0";
			$result3=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$data_sym="$";
			$File = "session_track.php";
			$fh = fopen($File, 'w') or die("can't open file");
			$stringData = "<?php ".$data_sym."status=\"\"; ?>";
			fwrite($fh, $stringData);
			fclose($fh); 
			echo "</table>";
			
		}
		else
		{				
			if($mini_num>1)
			{
				$tota_mini=$order_qty/$mini_order_qnty;
				$total_mini_orders=ceil($tota_mini);
				$total_mini_orders_count=$total_mini_orders+$mini_num-1;
				$sno=$mini_num;
				$last_min_order=0;
				//echo "Short--O-".$order_qty."--MQ-".$mini_order_qnty."--M-".$mini_num."--E-".$tota_mini."--T-".$total_mini_orders."--L-".$last_min_order."<br>";
			}
			else
			{
				$tota_mini=$order_qty/$mini_order_qnty;
				$total_mini_orders=ceil($tota_mini);
				$total_mini_orders_count=$total_mini_orders;
				$sno=$mini_num;
				//$previous_min=round($tota_mini);
				$last_min_order=0;
				//echo "1--O-".$order_qty."--MQ-".$mini_order_qnty."--M-".$mini_num."--E-".$tota_mini."--T-".$total_mini_orders."--L-".$last_min_order."<br>";
			}
			$get_carton_detail_query="SELECT color,ref_size_name,quantity FROM tbl_carton_size_ref where parent_id in(select id from tbl_carton_ref where ref_order_num=$schedule_id and style_code=$style_id) ORDER BY color,ref_size_name";
			//echo $get_carton_detail_query."<br>";
			$result2=mysqli_query($link, $get_carton_detail_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($carton=mysqli_fetch_array($result2))
			{
				$temp_quantity=0;
				$diff_qty=0;$order_fill_status=0;
				$order_fill=0;$ii=1;
				$color=$carton['color'];
				$size=$carton['ref_size_name'];
				$carton_ratio=$carton['quantity'];
				$total_quantity=0;
				$order_size_quantity="select COALESCE(sum(order_sizes.order_quantity),0) as orderQuantity from tbl_orders_master orders 
				left join tbl_orders_sizes_master order_sizes on orders.id=order_sizes.parent_id 
				where orders.ref_product_style=$style_id and orders.product_schedule='$schedule' and order_sizes.ref_size_name=$size and order_sizes.order_col_des='$color'";
				//echo $order_size_quantity."<br>";
				$result22=mysqli_query($link, $order_size_quantity) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row22=mysqli_fetch_array($result22))
				{
					$order_qty_col_size=$row22['orderQuantity'];
				}
				$mini_order_quantity=$carton_ratio*$mix_bund_per_size*$max_bundle_qnty;
				//echo $carton_ratio."*".$mix_bund_per_size."*".$max_bundle_qnty."---".$mini_order_quantity."<br>";
				$sql23="SELECT cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,sizes.size_name as size_title
				FROM tbl_cut_master cut_master LEFT JOIN tbl_cut_size_master cut_sizes ON cut_master.id=cut_sizes.parent_id left join tbl_orders_size_ref sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id=$style_id AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.ref_size_name=$size";
				//echo $sql23."<br>";
				$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo "---".mysql_num_rows($result23)."<br>";
				while($sql_row=mysqli_fetch_array($result23))
				{
					$cut_num=$sql_row['cut_num'];
					$ratio=$sql_row['quantity'];
					$bundle_quantity=$sql_row['planned_plies'];
					//echo $cut_num."--".$ratio."--".$bundle_quantity."<br>";
					for($i=0;$i<$ratio;$i++)
					{
						$temp_quantity+=$bundle_quantity;
						$total_quantity+=$bundle_quantity;
						if($order_qty_col_size>=$total_quantity)
						{
							if($split_status==1)
							{
								if($bundle_quantity>$split_quantity)
								{
									$quantities=split_values($bundle_quantity,$link);
									$quantity_bundle=explode("$",$quantities);		
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[1]."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
									
								
								}
								else
								{
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
								
							}
							else
							{
								echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								//echo "<tr><td>".$bundle_quantity."--OFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
								$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
								$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
								$bundle_number++;
							}
							
							
							if($temp_quantity>=$mini_order_quantity)
							{
								if($ii==$total_mini_orders)
								{
									//$sno;
								}
								else
								{
									$sno++;
									$ii++;
									$temp_quantity=0;
								}
							}
							
						}
						else
						{
							if($order_fill_status==0)
							{
								$order_fill=$order_qty_col_size-($total_quantity-$bundle_quantity);
								$diff_qty=$bundle_quantity-$order_fill;
								$order_fill_status=1;
								if($order_fill==0)
								{
									$temp_full=$bundle_quantity;
								}
								$total_mini_orders_count=echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)","mini_order_ref='".$mini_order_ref."' and size='".$size."' and color",$color,$link);
								if($order_fill>0)
								{
									if($split_status==1)
									{
										if($order_fill>$split_quantity)
										{
											$quantities_fil=split_values($order_fill,$link);
											$quantity_bundle=explode("$",$quantities_fil);		
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$$quantity_bundle[0]."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$$quantity_bundle[1]."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$$quantity_bundle[1]."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											
											
											if($diff_qty>0)
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$diff_qty."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
												
											
										}
										else
										{
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$order_fill."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											if($diff_qty>0)
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$diff_qty."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
										}
										
									}
									else
									{
											echo "<tr><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$order_fill."--OLFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$total_mini_orders_count."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$order_fill."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$total_mini_orders_count."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$order_fill."','".$sql_row['docket_number']."','".$total_mini_orders_count."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											if($diff_qty>0)
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$diff_qty."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$diff_qty."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$diff_qty."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
									}
								}
								else
								{
									if($temp_full>0)
									{
										if($split_status==1)
										{
											if($temp_full>$split_quantity)
											{
												$quantities_fil=split_values($temp_full,$link);
												$quantity_bundle=explode("$",$quantities_fil);		
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
												//echo "3----".$i."<br>";
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
												//echo "3----".$i."<br>";		
												
											}
											else
											{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
												$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$temp_full."','".$sql_row['docket_number']."','".$last_min_order."')";
												$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												$bundle_number++;
											}
											
										}
										else
										{
												echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
											//echo "<tr><td>".$i."----".$temp_full."--LFill-.".$temp_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$temp_full."</td><td>".$sql_row['docket_number']."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$temp_full."','".$sql_row['docket_number']."','".$last_min_order."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
										}
									}
								}
							
							}
							else
							{
								if($split_status==1)
								{
									if($bundle_quantity>$split_quantity)
									{
										$quantities_fil=split_values($bundle_quantity,$link);
										$quantity_bundle=explode("$",$quantities_fil);		
										echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[0]."</td><td>".$sql_row['docket_number']."</td></tr>";
										//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[0]."','".$sql_row['docket_number']."','".$last_min_order."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
										echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$quantity_bundle[1]."</td><td>".$sql_row['docket_number']."</td></tr>";
										//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$quantity_bundle[1]."','".$sql_row['docket_number']."','".$last_min_order."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;	
										
									}
									else
									{
										echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
										$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$last_min_order."')";
										$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$bundle_number++;
									}
									
								}
								else
								{
									echo "<tr><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									//echo "<tr><td>".$bundle_quantity."LA-Fill-.".$total_quantity."-".$order_qty_col_size."</td><td>".$last_min_order."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$last_min_order."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$last_min_order."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
							}
						}
					}	
				}
			}
			$last_min_order=echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
			$sql="update brandix_bts.tbl_miniorder_data set mini_order_num='".$last_min_order."' where mini_order_ref='".$mini_order_ref."' and mini_order_num=0";
			$result3=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$data_sym="$";
			$File = "session_track.php";
			$fh = fopen($File, 'w') or die("can't open file");
			$stringData = "<?php ".$data_sym."status=\"\"; ?>";
			fwrite($fh, $stringData);
			fclose($fh); 
			echo "</table>";
		}
	}
}
else
{
	echo "<h2>Another User Generating Mini orders. Please try again.</h2>";
}	
?>