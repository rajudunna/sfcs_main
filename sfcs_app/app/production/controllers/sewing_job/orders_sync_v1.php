
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Orders Re-Sync</title>
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
	/* font-family:Arial, Helvetica, sans-serif; font-size:88%; */
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



<script language="javascript" type="text/javascript">
function firstbox()
{
	
	window.location.href ="mini_order_report.php?style="+document.mini_order_report.style.value
}

function secondbox()
{

}

function check_sch()
{
	var sch=document.getElementById('sch').value;
	if(sch=='NIL')
	{
		sweetAlert('Please select Schedule','','warning');
		return false;
	}
	return true;
}
function check_val()
{
	
	var style=document.bundle_operation.style.value;
	var c_block=document.bundle_operation.c_block.value;
	var schedule=document.bundle_operation.schedule.value;
	var barcode=document.bundle_operation.barcode.value;

		if(style==0 || c_block=='NIL' || schedule=='NIL' || barcode=='NIL')
		{
			sweetAlert('Please select the values','','warning');
			return false;
		}

}

function check_val_2()
{
	

	var count=document.barcode_mapping_2.count_qty.value;

	var check_exist=0;
	for(i=0;i<5;i++)
	{
		var qty=document.getElementById("qty["+i+"]").value;
		if(qty!=0)
	    {
			var check_exist=1;
		}
	}
	if(check_exist==0)
	{
		sweetAlert('Please fill the values','','warning');
		return false;
	}
	
}
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('txtPhn');
//comparing pressed keycodes
if ((keycode < 48 || keycode > 57) && (keycode<46 || keycode>47))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}
</script>


	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Orders Re-Synchronization</strong></div>
		<div class="panel-body">

			<?php
				include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
				include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
				$has_permission=haspermission($_GET['r']);

				if(isset($_POST['schedule'])>0)
				{
					$schedule=$_POST['schedule'];
				}
				else
				{
					$schedule='';
				}
			?>

			<form name="mini_order_report" class="form-inline" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">

				Schedule Number:
				<?php
					echo "<select id=\"sch\" name=\"sch\" class='form-control' onchange=\"secondbox();\">";
					echo "<option value=\"NIL\" selected>NIL</option>";
					$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master group by schedule";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['schedule'])==str_replace(" ","",$schedule))
						{
							echo "<option value=\"".$sql_row['schedule']."\" selected>".$sql_row['schedule']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['schedule']."\">".$sql_row['schedule']."</option>";
						}

					}
					echo "</select>";
				?>
				&nbsp;&nbsp;<input type="submit" class="btn btn-success" onclick="return check_sch();" value="Sync" name="show"><br>

			<form>
					<?php
					if(isset($_POST['show']))
					{
						$scheudle_no=$_POST['sch'];
						if ($scheudle_no =='NIL')
						{
							echo '';
						}else{

							$bai_orders_db_confirm='';$bai_orders_db='';$plandoc_stat_log='';
							for($j=0;$j<sizeof($sizes_array);$j++)
							{
								$bai_orders_db_confirm.="bai_orders_db_confirm.order_s_".$sizes_array[$j]."+";
								$bai_orders_db.="bai_orders_db.order_s_".$sizes_array[$j]."+";
								$plandoc_stat_log.="plandoc_stat_log.p_".$sizes_array[$j]."+";

							}
							$query=substr($bai_orders_db_confirm,0,-1);
							$query1=substr($bai_orders_db,0,-1);
							$query2=substr($plandoc_stat_log,0,-1);

							$sql="SELECT bai_orders_db_confirm.*,$query AS confirm_order_quantity,bai_orders_db.order_tid,$query1 AS order_quantity,plandoc_stat_log.order_tid,SUM(($query2)*plandoc_stat_log.p_plies) AS plan_quantity,bai_orders_db_confirm.bts_status FROM $bai_pro3.bai_orders_db_confirm as  bai_orders_db_confirm	LEFT JOIN $bai_pro3.bai_orders_db  as bai_orders_db ON bai_orders_db.order_tid=bai_orders_db_confirm.order_tid	LEFT JOIN $bai_pro3.plandoc_stat_log as plandoc_stat_log ON plandoc_stat_log.order_tid=bai_orders_db_confirm.order_tid WHERE bai_orders_db_confirm.order_joins not in (1,2) and bai_orders_db_confirm.order_del_no='".$scheudle_no."' AND plandoc_stat_log.order_tid=bai_orders_db_confirm.order_tid	GROUP BY bai_orders_db_confirm.order_tid,bai_orders_db_confirm.order_col_des";
							$result=mysqli_query($link, $sql) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $result_3."ads";
							$check1=mysqli_num_rows($result);
							$sizesMasterQuery="select id,upper(size_name) as size_name from $brandix_bts.tbl_orders_size_ref order by size_name";
							//$db->setQuery($sizesMasterQuery);
							$result2=mysqli_query($link, $sizesMasterQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
							//$sizesResult=$db->loadAssocList();

							$check=mysqli_num_rows($result2);
							if($check>0 || $check!='')
							{
								while($s=mysqli_fetch_array($result2))
								{

							
									if($s['size_name']=='S01')
									{
										$s01_id=$s['id'];
									}
									if($s['size_name']=='S02')
									{
										$s02_id=$s['id'];
									}
									if($s['size_name']=='S03')
									{
										$s03_id=$s['id'];
									}
									if($s['size_name']=='S04')
									{
										$s04_id=$s['id'];
									}
									if($s['size_name']=='S05')
									{
										$s05_id=$s['id'];
									}
									if($s['size_name']=='S06')
									{
										$s06_id=$s['id'];
									}
									if($s['size_name']=='S07')
									{
										$s07_id=$s['id'];
									}
									if($s['size_name']=='S08')
									{
										$s08_id=$s['id'];
									}
									if($s['size_name']=='S09')
									{
										$s09_id=$s['id'];
									}
									if($s['size_name']=='S10')
									{
										$s10_id=$s['id'];
									}
									if($s['size_name']=='S11')
									{
										$s11_id=$s['id'];
									}
									if($s['size_name']=='S12')
									{
										$s12_id=$s['id'];
									}
									if($s['size_name']=='S13')
									{
										$s13_id=$s['id'];
									}
									if($s['size_name']=='S14')
									{
										$s14_id=$s['id'];
									}
									if($s['size_name']=='S15')
									{
										$s15_id=$s['id'];
									}
									if($s['size_name']=='S16')
									{
										$s16_id=$s['id'];
									}
									if($s['size_name']=='S17')
									{
										$s17_id=$s['id'];
									}
									if($s['size_name']=='S18')
									{
										$s18_id=$s['id'];
									}
									if($s['size_name']=='S19')
									{
										$s19_id=$s['id'];
									}
									if($s['size_name']=='S20')
									{
										$s20_id=$s['id'];
									}
									if($s['size_name']=='S21')
									{
										$s21_id=$s['id'];
									}
									if($s['size_name']=='S22')
									{
										$s22_id=$s['id'];
									}
									if($s['size_name']=='S23')
									{
										$s23_id=$s['id'];
									}
									if($s['size_name']=='S24')
									{
										$s24_id=$s['id'];
									}
									if($s['size_name']=='S25')
									{
										$s25_id=$s['id'];
									}
									if($s['size_name']=='S26')
									{
										$s26_id=$s['id'];
									}
									if($s['size_name']=='S27')
									{
										$s27_id=$s['id'];
									}
									if($s['size_name']=='S28')
									{
										$s28_id=$s['id'];
									}
									if($s['size_name']=='S29')
									{
										$s29_id=$s['id'];
									}
									if($s['size_name']=='S30')
									{
										$s30_id=$s['id'];
									}
									if($s['size_name']=='S31')
									{
										$s31_id=$s['id'];
									}
									if($s['size_name']=='S32')
									{
										$s32_id=$s['id'];
									}
									if($s['size_name']=='S33')
									{
										$s33_id=$s['id'];
									}
									if($s['size_name']=='S34')
									{
										$s34_id=$s['id'];
									}
									if($s['size_name']=='S35')
									{
										$s35_id=$s['id'];
									}
									if($s['size_name']=='S36')
									{
										$s36_id=$s['id'];
									}
									if($s['size_name']=='S37')
									{
										$s37_id=$s['id'];
									}
									if($s['size_name']=='S38')
									{
										$s38_id=$s['id'];
									}
									if($s['size_name']=='S39')
									{
										$s39_id=$s['id'];
									}
									if($s['size_name']=='S40')
									{
										$s40_id=$s['id'];
									}
									if($s['size_name']=='S41')
									{
										$s41_id=$s['id'];
									}
									if($s['size_name']=='S42')
									{
										$s42_id=$s['id'];
									}
									if($s['size_name']=='S43')
									{
										$s43_id=$s['id'];
									}
									if($s['size_name']=='S44')
									{
										$s44_id=$s['id'];
									}
									if($s['size_name']=='S45')
									{
										$s45_id=$s['id'];
									}
									if($s['size_name']=='S46')
									{
										$s46_id=$s['id'];
									}
									if($s['size_name']=='S47')
									{
										$s47_id=$s['id'];
									}
									if($s['size_name']=='S48')
									{
										$s48_id=$s['id'];
									}
									if($s['size_name']=='S49')
									{
										$s49_id=$s['id'];
									}
									if($s['size_name']=='S50')
									{
										$s50_id=$s['id'];
									}
								}
							}
							else
							{
								echo "Sorry No sizes found in masters....Please add sizes first ";
							}
							//echo $check."----".$check1."<br>";
							if($check1>0)
							{
								while($r=mysqli_fetch_array($result))
								{
									$order_tid=$r['order_tid'];
									$style_code=$r['order_style_no'];
									$product_schedule=$r['order_del_no'];
									$c_block=$r['zfeature'];
									$col_code=$r['color_code'];
									$color_code=$r['order_col_des'];
									$bts_status=$r['bts_status'];
									//get Style code from product Master
									$productsQuery=echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style_code,$link);
									if($productsQuery>0)
									{
										$style_id=$productsQuery;
									}
									else
									{
										$insertStyleCode="INSERT IGNORE INTO $brandix_bts.`tbl_orders_style_ref`(`product_style`) VALUES ('$style_code')";
										$result3=mysqli_query($link, $insertStyleCode) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$style_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
										$default_operations="SELECT id FROM $brandix_bts.tbl_orders_ops_ref where default_operation='YES'";
										$result4=mysqli_query($link, $default_operations) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$check2=mysqli_num_rows($result4);
										if($check2>0 || $check2!='')
										{
											while($d=mysqli_fetch_array($result4))
											{
												$insert_query="INSERT INTO $brandix_bts.`tbl_style_ops_master`(`parent_id`, `operation_name`) VALUES (".$style_id.",".$d['id'].")";
												$result5=mysqli_query($link, $insert_query) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												//echo $insert_query."</br>";
											}
										}

									}
									$productsQuery=echo_title("$brandix_bts.tbl_orders_master","id","ref_product_style='".$style_id."' and product_schedule",$product_schedule,$link);
									if($productsQuery>0 || $productsQuery!='')
									{
										$order_id=$productsQuery;
									}
									else
									{
										$check_emb=echo_title("$bai_pro3.bai_orders_db_confirm","sum(order_embl_a+order_embl_b)","order_del_no",$product_schedule,$link);
										if($check_emb>0)
										{
											$insertOrdersMaster="INSERT INTO $brandix_bts.`tbl_orders_master`(`ref_product_style`, `product_schedule`,`order_status`,`emb_status`) VALUES ('".$style_id."','".$product_schedule."', 'OPEN','1')";
										}
										else
										{
											$insertOrdersMaster="INSERT INTO $brandix_bts.`tbl_orders_master`(`ref_product_style`, `product_schedule`,`order_status`,`emb_status`) VALUES ('".$style_id."','".$product_schedule."', 'OPEN','0')";
										}
										$order_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
									}
									//check whether color existed or not
									$color_query=echo_title("$brandix_bts.tbl_orders_sizes_master","count(*)","parent_id='".$order_id."' and order_col_des",$color_code,$link);
									//echo $color_query."1<br>";
									if($color_query>0)
									{
										$layPlanQuery="SELECT plandoc_stat_log.*,cat_stat_log.category FROM $bai_pro3.plandoc_stat_log as plandoc_stat_log
										LEFT JOIN $bai_pro3.cat_stat_log as cat_stat_log ON `plandoc_stat_log`.`cat_ref` = `cat_stat_log`.`tid`
										WHERE cat_stat_log.category IN ('BODY','FRONT') AND plandoc_stat_log.order_tid='$order_tid'";
										//echo $layPlanQuery."<br>";
										$result7=mysqli_query($link, $layPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($l=mysqli_fetch_array($result7))
										{
											$doc_num=$l['doc_no'];
											$cut_num=$l['acutno'];
											//$tid=$l['tid'];
											$cut_status=$l['act_cut_status'];
											$planned_module=$l['plan_module'];
											if($planned_module==NULL)
											{
												$planned_module=0;
											}
											$request_time=$l['rm_date'];
											$issued_time=$l['date'];
											$planned_plies=$l['p_plies'];
											$actual_plies=$l['a_plies'];
											$plan_date=$l['date'];
											$cat_ref=$l['cat_ref'];
											$mk_ref=$l['mk_ref'];
											$cuttable_ref=$l['cuttable_ref'];
											//Insert data into layplan(tbl_cut_master) table
											$insertLayPlanQuery="INSERT ignore INTO $brandix_bts.tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,request_time,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref) VALUES
											('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$request_time','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style_id,'$product_schedule',$cat_ref,$cuttable_ref,$mk_ref)";
											//echo $insertLayPlanQuery."</br>";
											$result8=mysqli_query($link, $insertLayPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$layplan_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
											if($layplan_id>0)
											{
												//Insert data into layplan reference table ($brandix_bts.tbl_cut_size_master)
												// for ($i=0; $i < sizeof($sizes_array); $i++)
												// {
												// 	$p_s='p_'.$sizes_array[$i].'';
												// 	// var_dump($p_s);
												// 	if($l[$p_s]>0)
												// 	{
												// 	 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$temp[$i].",".$l[$p_s].")";
												// 	 $result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												// 	}
												// }

												if($l['p_xs']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xs_id.",".$l['p_xs'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());
													//echo $insertLayplanItemsQuery."</br>";
												}
												if($l['p_s']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s_id.",".$l['p_s'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

												}
												if($l['p_m']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$m_id.",".$l['p_m'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

												}
												if($l['p_l']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$l_id.",".$l['p_l'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

												}
												if($l['p_xl']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xl_id.",".$l['p_xl'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

												}
												if($l['p_xxl']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xxl_id.",".$l['p_xxl'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

												}
												if($l['p_xxxl']>0)
												{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xxxl_id.",".$l['p_xxxl'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

												}
												if($l['p_s01']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s01_id.",".$l['p_s01'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s02']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s02_id.",".$l['p_s02'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s03']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s03_id.",".$l['p_s03'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s04']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s04_id.",".$l['p_s04'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s05']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s05_id.",".$l['p_s05'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s06']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s06_id.",".$l['p_s06'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s07']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s07_id.",".$l['p_s07'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s08']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s08_id.",".$l['p_s08'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s09']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s09_id.",".$l['p_s09'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s10']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s10_id.",".$l['p_s10'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s11']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s11_id.",".$l['p_s11'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s12']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s12_id.",".$l['p_s12'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s13']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s13_id.",".$l['p_s13'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s14']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s14_id.",".$l['p_s14'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s15']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s15_id.",".$l['p_s15'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s16']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s16_id.",".$l['p_s16'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s17']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s17_id.",".$l['p_s17'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s18']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s18_id.",".$l['p_s18'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s19']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s19_id.",".$l['p_s19'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s20']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s20_id.",".$l['p_s20'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s21']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s21_id.",".$l['p_s21'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s22']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s22_id.",".$l['p_s22'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s23']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s23_id.",".$l['p_s23'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s24']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s24_id.",".$l['p_s24'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s25']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s25_id.",".$l['p_s25'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s26']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s26_id.",".$l['p_s26'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s27']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s27_id.",".$l['p_s27'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s28']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s28_id.",".$l['p_s28'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s29']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s29_id.",".$l['p_s29'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s30']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s30_id.",".$l['p_s30'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s31']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s31_id.",".$l['p_s31'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s32']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s32_id.",".$l['p_s32'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s33']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s33_id.",".$l['p_s33'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s34']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s34_id.",".$l['p_s34'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s35']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s35_id.",".$l['p_s35'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s36']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s36_id.",".$l['p_s36'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s37']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s37_id.",".$l['p_s37'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s38']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s38_id.",".$l['p_s38'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s39']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s39_id.",".$l['p_s39'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s40']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s40_id.",".$l['p_s40'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s41']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s41_id.",".$l['p_s41'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s42']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s42_id.",".$l['p_s42'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s43']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s43_id.",".$l['p_s43'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s44']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s44_id.",".$l['p_s44'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s45']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s45_id.",".$l['p_s45'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s46']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s46_id.",".$l['p_s46'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s47']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s47_id.",".$l['p_s47'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s48']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s48_id.",".$l['p_s48'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s49']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s49_id.",".$l['p_s49'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
												if($l['p_s50']>0)
													{
													$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s50_id.",".$l['p_s50'].")";
													$result9=mysql_query($insertLayplanItemsQuery,$link) or ("Sql error".mysql_error());

													}
											}
										}
									}
									else
									{
										//echo $style_code."---".$product_schedule."--".$color_code."<br>";
										// $order_s[]=0;
										for ($i=0; $i < sizeof($sizes_array); $i++)
										{
											$orderS="order_s_".$sizes_array[$i]."";
											$oldOrderS="old_order_s_".$sizes_array[$i]."";
											$test= 'title_size_'.$sizes_array[$i].'';
											if($r[$orderS]>0)
											{
												$temp1[]='$title_size_'.$sizes_array[$i];
												$temp1[$i]=$r[$test];
												$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$temp[$i],'".$temp1[$i]."',".$r[$orderS].",".$r[$oldOrderS].",'".$color_code."')";
												// echo $insertSizesQuery;
												// die();
												$result6=mysqli_query($link, $insertSizesQuery) or ("Sql:$insertSizesQuery<br> error:".mysqli_error($GLOBALS["___mysqli_ston"]));
												$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$temp1[$i]."', '".$color_code."', '".$r[$orderS]."', '0', '".$c_block."', '".$r['order_date']."')";
												// echo $insertSizesQuery."</br>".$sql11;
											}
										}

										if($r['order_s_xs']>0)
										{
											$title_size_xs=$r['title_size_xs'];
											//$old_order_s_xs=$r['old_order_s_xs'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$xs_id,'".$title_size_xs."',".$r['order_s_xs'].",".$r['old_order_s_xs'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_xs."', '".$color_code."', '".$r['order_s_xs']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo "XS\t".$insertSizesQuery."</br>";
										}
										if($r['order_s_s']>0)
										{
											$title_size_s=$r['title_size_s'];
											//$old_order_s_s=$r['old_order_s_s'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s_id,'".$title_size_s."',".$r['order_s_s'].",".$r['old_order_s_s'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s."', '".$color_code."', '".$r['order_s_s']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo $insertSizesQuery."</br>";
										}
										if($r['order_s_m']>0)
										{
											$title_size_m=$r['title_size_m'];
											//$old_order_s_m=$r['old_order_s_m'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$m_id,'".$title_size_m."',".$r['order_s_m'].",".$r['old_order_s_m'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_m."', '".$color_code."', '".$r['order_s_m']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo $insertSizesQuery."</br>";
										}
										if($r['order_s_l']>0)
										{
											$title_size_l=$r['title_size_l'];
											//$old_order_s_l=$r['old_order_s_l'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$l_id,'".$title_size_l."',".$r['order_s_l'].",".$r['old_order_s_l'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_l."', '".$color_code."', '".$r['order_s_l']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo $insertSizesQuery."</br>";
										}
										if($r['order_s_xl']>0)
										{
											$title_size_xl=$r['title_size_xl'];
											//$old_order_s_xl=$r['old_order_s_xl'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$xl_id,'".$title_size_xl."',".$r['order_s_xl'].",".$r['old_order_s_xl'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_xl."', '".$color_code."', '".$r['order_s_xl']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo $insertSizesQuery."</br>";
										}
										if($r['order_s_xxl']>0)
										{
											$title_size_xxl=$r['title_size_xxl'];
											//$old_order_s_xxl=$r['old_order_s_xxl'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$xxl_id,'".$title_size_xxl."',".$r['order_s_xxl'].",".$r['old_order_s_xxl'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_xxl."', '".$color_code."', '".$r['order_s_xxl']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo $insertSizesQuery."</br>";
										}
										if($r['order_s_xxxl']>0)
										{
											$title_size_xxxl=$r['title_size_xxxl'];
											//$old_title_size_xxxl=$r['old_title_size_xxxl'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$xxl_id,'".$title_size_xxxl."',".$r['order_s_xxxl'].",".$r['old_order_s_xxxl'].",'".$color_code."')";
											$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_xxxl."', '".$color_code."', '".$r['order_s_xxxl']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
											//echo $insertSizesQuery."</br>";
										}
										if($r['order_s_s01']>0)
										{
										$title_size_s01=$r['title_size_s01'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s01_id,'".$title_size_s01."',".$r['order_s_s01'].",".$r['old_order_s_s01'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s01."','".$color_code."', '".$r['order_s_s01']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s02']>0)
										{
										$title_size_s02=$r['title_size_s02'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s02_id,'".$title_size_s02."',".$r['order_s_s02'].",".$r['old_order_s_s02'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s02."','".$color_code."', '".$r['order_s_s02']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s03']>0)
										{
										$title_size_s03=$r['title_size_s03'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s03_id,'".$title_size_s03."',".$r['order_s_s03'].",".$r['old_order_s_s03'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s03."','".$color_code."', '".$r['order_s_s03']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s04']>0)
										{
										$title_size_s04=$r['title_size_s04'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s04_id,'".$title_size_s04."',".$r['order_s_s04'].",".$r['old_order_s_s04'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s04."','".$color_code."', '".$r['order_s_s04']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s05']>0)
										{
										$title_size_s05=$r['title_size_s05'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s05_id,'".$title_size_s05."',".$r['order_s_s05'].",".$r['old_order_s_s05'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s05."','".$color_code."', '".$r['order_s_s05']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s06']>0)
										{
										$title_size_s06=$r['title_size_s06'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s06_id,'".$title_size_s06."',".$r['order_s_s06'].",".$r['old_order_s_s06'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s06."','".$color_code."', '".$r['order_s_s06']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s07']>0)
										{
										$title_size_s07=$r['title_size_s07'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s07_id,'".$title_size_s07."',".$r['order_s_s07'].",".$r['old_order_s_s07'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s07."','".$color_code."', '".$r['order_s_s07']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s08']>0)
										{
										$title_size_s08=$r['title_size_s08'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s08_id,'".$title_size_s08."',".$r['order_s_s08'].",".$r['old_order_s_s08'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s08."','".$color_code."', '".$r['order_s_s08']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s09']>0)
										{
										$title_size_s09=$r['title_size_s09'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s09_id,'".$title_size_s09."',".$r['order_s_s09'].",".$r['old_order_s_s09'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s09."','".$color_code."', '".$r['order_s_s09']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s10']>0)
										{
										$title_size_s10=$r['title_size_s10'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s10_id,'".$title_size_s10."',".$r['order_s_s10'].",".$r['old_order_s_s10'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s10."','".$color_code."', '".$r['order_s_s10']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s11']>0)
										{
										$title_size_s11=$r['title_size_s11'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s11_id,'".$title_size_s11."',".$r['order_s_s11'].",".$r['old_order_s_s11'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s11."','".$color_code."', '".$r['order_s_s11']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s12']>0)
										{
										$title_size_s12=$r['title_size_s12'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s12_id,'".$title_size_s12."',".$r['order_s_s12'].",".$r['old_order_s_s12'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s12."','".$color_code."', '".$r['order_s_s12']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s13']>0)
										{
										$title_size_s13=$r['title_size_s13'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s13_id,'".$title_size_s13."',".$r['order_s_s13'].",".$r['old_order_s_s13'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s13."','".$color_code."', '".$r['order_s_s13']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s14']>0)
										{
										$title_size_s14=$r['title_size_s14'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s14_id,'".$title_size_s14."',".$r['order_s_s14'].",".$r['old_order_s_s14'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s14."','".$color_code."', '".$r['order_s_s14']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s15']>0)
										{
										$title_size_s15=$r['title_size_s15'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s15_id,'".$title_size_s15."',".$r['order_s_s15'].",".$r['old_order_s_s15'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s15."','".$color_code."', '".$r['order_s_s15']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s16']>0)
										{
										$title_size_s16=$r['title_size_s16'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s16_id,'".$title_size_s16."',".$r['order_s_s16'].",".$r['old_order_s_s16'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s16."','".$color_code."', '".$r['order_s_s16']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s17']>0)
										{
										$title_size_s17=$r['title_size_s17'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s17_id,'".$title_size_s17."',".$r['order_s_s17'].",".$r['old_order_s_s17'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s17."','".$color_code."', '".$r['order_s_s17']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s18']>0)
										{
										$title_size_s18=$r['title_size_s18'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s18_id,'".$title_size_s18."',".$r['order_s_s18'].",".$r['old_order_s_s18'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s18."','".$color_code."', '".$r['order_s_s18']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s19']>0)
										{
										$title_size_s19=$r['title_size_s19'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s19_id,'".$title_size_s19."',".$r['order_s_s19'].",".$r['old_order_s_s19'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s19."','".$color_code."', '".$r['order_s_s19']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s20']>0)
										{
										$title_size_s20=$r['title_size_s20'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s20_id,'".$title_size_s20."',".$r['order_s_s20'].",".$r['old_order_s_s20'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s20."','".$color_code."', '".$r['order_s_s20']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s21']>0)
										{
										$title_size_s21=$r['title_size_s21'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s21_id,'".$title_size_s21."',".$r['order_s_s21'].",".$r['old_order_s_s21'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s21."','".$color_code."', '".$r['order_s_s21']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s22']>0)
										{
										$title_size_s22=$r['title_size_s22'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s22_id,'".$title_size_s22."',".$r['order_s_s22'].",".$r['old_order_s_s22'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s22."','".$color_code."', '".$r['order_s_s22']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s23']>0)
										{
										$title_size_s23=$r['title_size_s23'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s23_id,'".$title_size_s23."',".$r['order_s_s23'].",".$r['old_order_s_s23'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s23."','".$color_code."', '".$r['order_s_s23']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s24']>0)
										{
										$title_size_s24=$r['title_size_s24'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s24_id,'".$title_size_s24."',".$r['order_s_s24'].",".$r['old_order_s_s24'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s24."','".$color_code."', '".$r['order_s_s24']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s25']>0)
										{
										$title_size_s25=$r['title_size_s25'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s25_id,'".$title_size_s25."',".$r['order_s_s25'].",".$r['old_order_s_s25'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s25."','".$color_code."', '".$r['order_s_s25']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s26']>0)
										{
										$title_size_s26=$r['title_size_s26'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s26_id,'".$title_size_s26."',".$r['order_s_s26'].",".$r['old_order_s_s26'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s26."','".$color_code."', '".$r['order_s_s26']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s27']>0)
										{
										$title_size_s27=$r['title_size_s27'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s27_id,'".$title_size_s27."',".$r['order_s_s27'].",".$r['old_order_s_s27'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s27."','".$color_code."', '".$r['order_s_s27']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s28']>0)
										{
										$title_size_s28=$r['title_size_s28'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s28_id,'".$title_size_s28."',".$r['order_s_s28'].",".$r['old_order_s_s28'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s28."','".$color_code."', '".$r['order_s_s28']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s29']>0)
										{
										$title_size_s29=$r['title_size_s29'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s29_id,'".$title_size_s29."',".$r['order_s_s29'].",".$r['old_order_s_s29'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s29."','".$color_code."', '".$r['order_s_s29']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s30']>0)
										{
										$title_size_s30=$r['title_size_s30'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s30_id,'".$title_size_s30."',".$r['order_s_s30'].",".$r['old_order_s_s30'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s30."','".$color_code."', '".$r['order_s_s30']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s31']>0)
										{
										$title_size_s31=$r['title_size_s31'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s31_id,'".$title_size_s31."',".$r['order_s_s31'].",".$r['old_order_s_s31'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s31."','".$color_code."', '".$r['order_s_s31']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s32']>0)
										{
										$title_size_s32=$r['title_size_s32'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s32_id,'".$title_size_s32."',".$r['order_s_s32'].",".$r['old_order_s_s32'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s32."','".$color_code."', '".$r['order_s_s32']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s33']>0)
										{
										$title_size_s33=$r['title_size_s33'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s33_id,'".$title_size_s33."',".$r['order_s_s33'].",".$r['old_order_s_s33'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s33."','".$color_code."', '".$r['order_s_s33']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s34']>0)
										{
										$title_size_s34=$r['title_size_s34'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s34_id,'".$title_size_s34."',".$r['order_s_s34'].",".$r['old_order_s_s34'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s34."','".$color_code."', '".$r['order_s_s34']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s35']>0)
										{
										$title_size_s35=$r['title_size_s35'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s35_id,'".$title_size_s35."',".$r['order_s_s35'].",".$r['old_order_s_s35'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s35."','".$color_code."', '".$r['order_s_s35']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s36']>0)
										{
										$title_size_s36=$r['title_size_s36'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s36_id,'".$title_size_s36."',".$r['order_s_s36'].",".$r['old_order_s_s36'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s36."','".$color_code."', '".$r['order_s_s36']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s37']>0)
										{
										$title_size_s37=$r['title_size_s37'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s37_id,'".$title_size_s37."',".$r['order_s_s37'].",".$r['old_order_s_s37'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s37."','".$color_code."', '".$r['order_s_s37']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s38']>0)
										{
										$title_size_s38=$r['title_size_s38'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s38_id,'".$title_size_s38."',".$r['order_s_s38'].",".$r['old_order_s_s38'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s38."','".$color_code."', '".$r['order_s_s38']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s39']>0)
										{
										$title_size_s39=$r['title_size_s39'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s39_id,'".$title_size_s39."',".$r['order_s_s39'].",".$r['old_order_s_s39'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s39."','".$color_code."', '".$r['order_s_s39']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s40']>0)
										{
										$title_size_s40=$r['title_size_s40'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s40_id,'".$title_size_s40."',".$r['order_s_s40'].",".$r['old_order_s_s40'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s40."','".$color_code."', '".$r['order_s_s40']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s41']>0)
										{
										$title_size_s41=$r['title_size_s41'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s41_id,'".$title_size_s41."',".$r['order_s_s41'].",".$r['old_order_s_s41'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s41."','".$color_code."', '".$r['order_s_s41']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s42']>0)
										{
										$title_size_s42=$r['title_size_s42'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s42_id,'".$title_size_s42."',".$r['order_s_s42'].",".$r['old_order_s_s42'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s42."','".$color_code."', '".$r['order_s_s42']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s43']>0)
										{
										$title_size_s43=$r['title_size_s43'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s43_id,'".$title_size_s43."',".$r['order_s_s43'].",".$r['old_order_s_s43'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s43."','".$color_code."', '".$r['order_s_s43']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s44']>0)
										{
										$title_size_s44=$r['title_size_s44'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s44_id,'".$title_size_s44."',".$r['order_s_s44'].",".$r['old_order_s_s44'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s44."','".$color_code."', '".$r['order_s_s44']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s45']>0)
										{
										$title_size_s45=$r['title_size_s45'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s45_id,'".$title_size_s45."',".$r['order_s_s45'].",".$r['old_order_s_s45'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s45."','".$color_code."', '".$r['order_s_s45']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s46']>0)
										{
										$title_size_s46=$r['title_size_s46'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s46_id,'".$title_size_s46."',".$r['order_s_s46'].",".$r['old_order_s_s46'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s46."','".$color_code."', '".$r['order_s_s46']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s47']>0)
										{
										$title_size_s47=$r['title_size_s47'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s47_id,'".$title_size_s47."',".$r['order_s_s47'].",".$r['old_order_s_s47'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s47."','".$color_code."', '".$r['order_s_s47']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s48']>0)
										{
										$title_size_s48=$r['title_size_s48'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s48_id,'".$title_size_s48."',".$r['order_s_s48'].",".$r['old_order_s_s48'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s48."','".$color_code."', '".$r['order_s_s48']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s49']>0)
										{
										$title_size_s49=$r['title_size_s49'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s49_id,'".$title_size_s49."',".$r['order_s_s49'].",".$r['old_order_s_s49'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s49."','".$color_code."', '".$r['order_s_s49']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									if($r['order_s_s50']>0)
										{
										$title_size_s50=$r['title_size_s50'];
										$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s50_id,'".$title_size_s50."',".$r['order_s_s50'].",".$r['old_order_s_s50'].",'".$color_code."')";
										$result6=mysqli_query($link, $insertSizesQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s50."','".$color_code."', '".$r['order_s_s50']."', '0', '".$c_block."', '".$r['order_date']."')";
										//$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}

										if($r['order_s_s30']>0)
										{
											$title_size_s30=$r['title_size_s30'];
											//$old_title_size_s30=$r['old_title_size_s30'];
											$insertSizesQuery="INSERT INTO $brandix_bts.tbl_orders_sizes_master(`parent_id`, `ref_size_name`, `size_title`, `order_quantity`, `order_act_quantity`,order_col_des) VALUES ($order_id,$s30_id,'".$title_size_s30."',".$r['order_s_s30'].",".$r['old_order_s_s30'].",'".$color_code."')";
											//$result6=mysql_query($insertSizesQuery,$link) or ("Sql error".mysql_error());
											$sql11="insert ignore into `bai3_finishing`.`order_db` (`style_no`, `schedule_no`, `size_code`, `color`, `order_qty`, `output`, `c_block`, `ex_date`) values ('".$style_code."', '".$product_schedule."', '".$title_size_s30."', '".$color_code."', '".$r['order_s_s30']."', '0', '".$c_block."', '".$r['order_date']."')";
											////$result11=mysql_query($sql11,$link) or ("Sql error".mysql_error());
										}
									$layPlanQuery="SELECT plandoc_stat_log.*,cat_stat_log.category FROM $bai_pro3.plandoc_stat_log as plandoc_stat_log LEFT JOIN $bai_pro3.cat_stat_log as cat_stat_log ON `plandoc_stat_log`.`cat_ref` = `cat_stat_log`.`tid` WHERE cat_stat_log.category IN ('BODY','FRONT') AND  plandoc_stat_log.order_tid='$order_tid'";
									//echo $layPlanQuery."<br>";
									$result7=mysqli_query($link, $layPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($l=mysqli_fetch_array($result7))
									{
										$doc_num=$l['doc_no'];
										$cut_num=$l['acutno'];
										//$tid=$l['tid'];
										$cut_status=$l['act_cut_status'];
										$planned_module=$l['plan_module'];
										if($planned_module==NULL)
										{
											$planned_module=0;
										}
										$request_time=$l['rm_date'];
										$issued_time=$l['date'];
										$planned_plies=$l['p_plies'];
										$actual_plies=$l['a_plies'];
										$plan_date=$l['date'];
										$cat_ref=$l['cat_ref'];
										$mk_ref=$l['mk_ref'];
										$cuttable_ref=$l['cuttable_ref'];
										//Insert data into layplan(tbl_cut_master) table
										$insertLayPlanQuery="INSERT ignore INTO tbl_cut_master(doc_num,ref_order_num,cut_num,cut_status,planned_module,request_time,issued_time,planned_plies,actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code) VALUES
										('$doc_num',$order_id,$cut_num,'$cut_status','$planned_module','$request_time','$issued_time',$planned_plies,$actual_plies,'$plan_date',$style_id,'$product_schedule',$cat_ref,$cuttable_ref,$mk_ref,$col_code)";
										//echo $insertLayPlanQuery."</br>";
										$result8=mysqli_query($link, $insertLayPlanQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
										$layplan_id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
											//Insert data into layplan reference table ($brandix_bts.tbl_cut_size_master)

										if($layplan_id>0)
										{

											// for ($i=0; $i < sizeof($sizes_array); $i++)
											// {
											// 	$p_s='p_'.$sizes_array[$i].'';
											// 	// var_dump($p_s);
											// 	if($l[$p_s]>0)
											// 	{
											// 	 $insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$temp[$i].",".$l[$p_s].")";
											// 	 $result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											// 	}
											// }


											if($l['p_xs']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xs_id.",".$l['p_xs'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
												//echo $insertLayplanItemsQuery."</br>";
											}
											if($l['p_s']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s_id.",".$l['p_s'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											}
											if($l['p_m']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$m_id.",".$l['p_m'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											}
											if($l['p_l']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$l_id.",".$l['p_l'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											}
											if($l['p_xl']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xl_id.",".$l['p_xl'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											}
											if($l['p_xxl']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xxl_id.",".$l['p_xxl'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											}
											if($l['p_xxxl']>0)
											{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$xxxl_id.",".$l['p_xxxl'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

											}
											if($l['p_s01']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s01_id.",".$l['p_s01'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s02']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s02_id.",".$l['p_s02'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s03']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s03_id.",".$l['p_s03'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s04']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s04_id.",".$l['p_s04'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s05']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s05_id.",".$l['p_s05'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s06']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s06_id.",".$l['p_s06'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s07']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s07_id.",".$l['p_s07'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s08']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s08_id.",".$l['p_s08'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s09']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s09_id.",".$l['p_s09'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s10']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s10_id.",".$l['p_s10'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s11']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s11_id.",".$l['p_s11'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s12']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s12_id.",".$l['p_s12'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s13']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s13_id.",".$l['p_s13'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s14']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s14_id.",".$l['p_s14'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s15']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s15_id.",".$l['p_s15'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s16']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s16_id.",".$l['p_s16'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s17']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s17_id.",".$l['p_s17'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s18']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s18_id.",".$l['p_s18'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s19']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s19_id.",".$l['p_s19'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s20']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s20_id.",".$l['p_s20'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s21']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s21_id.",".$l['p_s21'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s22']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s22_id.",".$l['p_s22'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s23']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s23_id.",".$l['p_s23'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s24']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s24_id.",".$l['p_s24'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s25']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s25_id.",".$l['p_s25'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s26']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s26_id.",".$l['p_s26'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s27']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s27_id.",".$l['p_s27'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s28']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s28_id.",".$l['p_s28'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s29']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s29_id.",".$l['p_s29'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s30']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s30_id.",".$l['p_s30'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s31']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s31_id.",".$l['p_s31'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s32']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s32_id.",".$l['p_s32'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s33']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s33_id.",".$l['p_s33'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s34']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s34_id.",".$l['p_s34'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s35']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s35_id.",".$l['p_s35'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s36']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s36_id.",".$l['p_s36'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s37']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s37_id.",".$l['p_s37'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s38']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s38_id.",".$l['p_s38'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s39']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s39_id.",".$l['p_s39'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s40']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s40_id.",".$l['p_s40'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s41']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s41_id.",".$l['p_s41'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s42']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s42_id.",".$l['p_s42'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s43']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s43_id.",".$l['p_s43'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s44']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s44_id.",".$l['p_s44'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s45']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s45_id.",".$l['p_s45'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s46']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s46_id.",".$l['p_s46'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s47']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s47_id.",".$l['p_s47'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s48']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s48_id.",".$l['p_s48'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s49']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s49_id.",".$l['p_s49'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
											if($l['p_s50']>0)
												{
												$insertLayplanItemsQuery="INSERT INTO $brandix_bts.tbl_cut_size_master(color,parent_id,ref_size_name,quantity) VALUES ('".$color_code."',".$layplan_id.",".$s50_id.",".$l['p_s50'].")";
												$result9=mysqli_query($link, $insertLayplanItemsQuery) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

												}
										}
									}
									}

								}
								echo "<br><center><div class='alert alert-success'><strong>Success! </strong> Synchronization Completed</div></center>";
							}
							else
							{
							echo "<br><center><div class='alert alert-info fade in'><strong>Info!</strong>We didn't Find Any New Lay plan.</div></center>";
							}
						}
					}
					?>
				</form>
				</th></tr>
			</table>
		</form>
	</div>
</div>
