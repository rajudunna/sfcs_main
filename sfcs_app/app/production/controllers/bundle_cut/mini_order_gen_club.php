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
set_time_limit(30000000);
include("dbconf.php");
include("session_track.php");
if($status == '' || $status == '1')
{
	$mini_order_ref=$_GET['id'];
	$data_sym="$";
	$File = "session_track.php";
	$fh = fopen($File, 'w') or die("can't open file");
	$stringData = "<?php ".$data_sym."status=\"".$mini_order_ref."\"; ?>";
	fwrite($fh, $stringData);
	fclose($fh); 
	
	$date_time=date('Y-m-d h:i:s'); 
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
		$carton_method=$row['carton_method'];
	}
	$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	
	$sch_check="J".$schedule;
	$check_club = echo_title("bai_pro3.bai_orders_db_confirm","count(*)","order_joins",$sch_check,$link);
	if($check_club>0)
	{
		//$carton_id = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule_id,$link);
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
		$mini_num = echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
		if($mini_num == 0 || $mini_num =='')
		{
			$mini_num=1;
		}
			$table="bai_pro3.mix_temp_desti";
			$tabl1e="bai_pro3.plandoc_stat_log";
			$bai_orders_db_confirm="bai_pro3.bai_orders_db_confirm";
			echo "<a href=\"mini_order_create.php\">Click Here to Back</a>";
			echo "<h3>Single Cut as Mini order</h3>";
			echo "<table class='blue' border=1px>";
			echo "<thead><th>Mini Order Number</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			$sno = $mini_num;
			$sql="select * from brandix_bts.tbl_cut_master where product_schedule='".$schedule."'";
			$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rows=mysqli_fetch_array($result))
			{
				$doc_no = $rows['doc_num'];
				$sql="select * from $table1 where org_doc_no='".$doc_no."'";
				$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result))
				{
					$temp_doc=$row['doc_no'];
					$style_id = echo_title("brandix_bts.tbl_cut_master","style_id","doc_num",$temp_doc,$link);
					$sch_id = echo_title("brandix_bts.tbl_cut_master","ref_order_num","doc_num",$temp_doc,$link);
					//$color = echo_title("brandix_bts.t","ref_order_num","doc_num",$temp_doc,$link);
					$mini_order_ref1 = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule='".$sch_id."' and ref_product_style",$style_id,$link);
					if($mini_order_ref1==0 || $mini_order_ref1=='')
					{
						$mini_order_ref=$mini_order_ref1;
					}
					else
					{
						$sql5="insert into `brandix_bts`.`tbl_min_ord_ref` (`ref_product_style`, `ref_crt_schedule`, `carton_quantity`, `max_bundle_qnty`, `miximum_bundles_per_size`, `mini_order_qnty`,`carton_method`) values ('".$style_id."', '".$sch_id."', 0, 0, 0, 0,1)";
						//echo $sql."<br>";
						$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$mini_order_ref=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					}
					$bundles=0;
					$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","docket_number",$temp_doc,$link);
					if($bundles>0)
					{
						//echo "<h2>Mini orders Generated already for -".$color."</h2>";
					}
					else
					{
						$sql23="select * from $table1 left join $bai_orders_db_confirm on $bai_orders_db_confirm.order_tid=$table1.order_tid where $table1.doc_no='".$temp_doc."'";
						$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($result23))
						{						
							$cut_num=$rows['cut_num'];
							$color_code=$rows['col_code'];
							//$ratio=$sql_row['quantity'];
							//$bundle_quantity=$sql_row['planned_plies'];
							//$size=$sql_row['size_id'];
							for($s=0;$s<sizeof($sizes_code);$s++)
							{
								if($sql_row["p_s".$sizes_code[$s].""]>0)
								{
									$color=$sql_row['order_col_des'];
									$size_tit = echo_title("bai_pro3.bai_orders_db_confirm","title_size_s".$sizes_code[$s]."","ordet_tid",$sql_row['order_tid'],$link);
									$size = echo_title("brandix_bts.tbl_orders_sizes_master","ref_size_name","parent_id='".$sch_id."' and order_col_dess='".$sql_row['order_col_des']."' and size_title",$size_tit,$link);
									$tot_qty=$sql_row["p_s".$sizes_code[$s].""];
									$bundle_quantity=$sql_row['org_plies'];
									do
									{										
										if($tot_qty>$bundle_quantity)
										{
											echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$size_tit."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$temp_doc."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$temp_doc."','".$sno."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											$tot_qty=$tot_qty-$bundle_quantity;
										}
										else
										{
											echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$size_tit."</td><td>".$bundle_number."</td><td>".$tot_qty."</td><td>".$temp_doc."</td></tr>";
											$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$tot_qty."','".$temp_doc."','".$sno."')";
											$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$bundle_number++;
											//$tot_qty=$tot_qty-$bundle_quantity;
										}
									}
									while($tot_qty>0)
									
								}							
							}
							
						}
						
					}	
						
				}	
				$sno++;	
			}
	}
	else
	{
	
		$carton_id = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num",$schedule_id,$link);
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
		$mini_num = echo_title("brandix_bts.tbl_miniorder_data","max(mini_order_num)+1","mini_order_ref",$mini_order_ref,$link);
		if($mini_num == 0 || $mini_num =='')
		{
			$mini_num=1;
		}
		
		if($carton_method == '1')
		{
			$sno = $mini_num;
			echo "<a href=\"mini_order_create.php\">Click Here to Back</a>";
			echo "<h3>Single Cut as Mini order</h3>";
			echo "<table class='blue' border=1px>";
			echo "<thead><th>Mini Order Number</th><th>Cut Number</th><th>Color</th><th>Size</th><th>Bundle Number</th><th>Quantity</th><th>Docket Number</th></thead>";
			$get_carton_detail_query="SELECT order_col_des FROM tbl_orders_sizes_master where parent_id='".$schedule_id."' GROUP BY order_col_des";
			//echo $get_carton_detail_query."<br>";
			$l=1;
			$result=mysqli_query($link, $get_carton_detail_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo mysql_num_rows($result)."<br>";
			while($row=mysqli_fetch_array($result))
			{
				$color=$row['order_col_des'];
				$bundle = echo_title("brandix_bts.tbl_miniorder_data","count(*)","color='".$color."' and mini_order_ref",$mini_order_ref,$link);
				if($bundle>0)
				{
					echo "<h2>Mini orders Generated already for -".$color."</h2>";
				}
				else
				{
		
					$sql2="SELECT cut_master.id,cut_master.cut_num,cut_master.doc_num FROM tbl_cut_master cut_master LEFT JOIN tbl_cut_size_master cut_sizes ON cut_master.id=cut_sizes.parent_id left join tbl_orders_size_ref sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id='$style_id' AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' GROUP BY cut_master.cut_num ORDER BY cut_master.cut_num";
					$result2=mysqli_query($link, $sql2) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($result2))
					{
						$bundles=0;
						$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","docket_number",$sql_row2['doc_num'],$link);
						if($bundles>0)
						{
							//echo "<h2>Mini orders Generated already for -".$color."</h2>";
						}
						else
						{
							$sql23="SELECT cut_master.cat_ref,cut_master.cut_num,cut_sizes.id,`cut_master`.`planned_plies`,cut_master.actual_plies,cut_sizes.quantity,cut_master.planned_plies*cut_sizes.quantity AS total_cut_quantity,cut_master.doc_num as docket_number,cut_sizes.ref_size_name as size_id,sizes.size_name AS size_title,cut_master.col_code
							FROM tbl_cut_master cut_master LEFT JOIN tbl_cut_size_master cut_sizes ON cut_master.id=cut_sizes.parent_id left join tbl_orders_size_ref sizes on sizes.id=cut_sizes.ref_size_name WHERE cut_master.style_id='$style_id' AND cut_master.product_schedule='$schedule' AND cut_sizes.color='$color' and cut_sizes.parent_id='".$sql_row2['id']."' order by cut_master.cut_num";
							$result23=mysqli_query($link, $sql23) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row=mysqli_fetch_array($result23))
							{						
								$cut_num=$sql_row['cut_num'];
								$color_code=$sql_row['col_code'];
								$ratio=$sql_row['quantity'];
								$bundle_quantity=$sql_row['planned_plies'];
								$size=$sql_row['size_id'];
								for($i=0;$i<$ratio;$i++)
								{		
									echo "<tr><td>".$sno."</td><td>".$cut_num."</td><td>".$color."</td><td>".$sql_row['size_title']."</td><td>".$bundle_number."</td><td>".$bundle_quantity."</td><td>".$sql_row['docket_number']."</td></tr>";
									$insertMiniOrderdata="INSERT INTO tbl_miniorder_data(date_time,mini_order_ref,mini_order_num,cut_num,color,size,bundle_number,quantity,docket_number,mini_order_priority) VALUES ('".$date_time."','".$mini_order_ref."','".$sno."','".$cut_num."','".$color."','".$size."','".$bundle_number."','".$bundle_quantity."','".$sql_row['docket_number']."','".$sno."')";
									$result3=mysqli_query($link, $insertMiniOrderdata) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									$bundle_number++;
								}
								
							}
							$sno++;	
						}	
					}
				}
			}
		
		}
	}
	echo "</table>";
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
	echo "<h2>Another User Generating Cartons . Please try again.</h2>";
}	
?>