<script>
	function printPage(printContent) { 
		var display_setting="toolbar=yes,menubar=yes,scrollbars=yes,width=1050, height=600"; 
		var printpage=window.open("","",display_setting); 
		printpage.document.open(); 
		printpage.document.write('<html><head><title>Print Page</title></head>'); 
		printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>'); 
		printpage.document.close(); 
		printpage.focus(); 
	}
</script>
<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
<title>Job Wise</title>
<body>
<?php
    include("../../../../common/config/config.php");
    include("../../../../common/config/functions.php");
    $schedule=$_GET["schedule"];
    if (isset($_GET['seq_no']))
    {
    	$seq_no = $_GET['seq_no'];
    }
    // $schedule_split=explode(",",$schedule); 
    //echo $schedule;
    error_reporting(0);
	if($schedule==''){
		echo "<script>alert('There are no schedules');
				window.close();
			</script>";
	} else {
		?>
		<br><center><a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)" class="btn btn-warning">Print</a></center><br>
		<div id="printsection">
			<style>
		        table, th, td
		        {
		            border: 1px solid black;
		            border-collapse: collapse;
		            background-color: transparent;
		        }
		        body
		        {
		            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		        }
			</style>
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Ratio Sheet (Sewing Job wise)</b></div>
				<div class="panel-body">	
					<div id="upperbody">				

						<div style="float:right"><img src="<?= $logo ?>" width="200" height="60"></div>

						<?php
							$sql="select distinct order_del_no as sch,order_tid from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
							// echo $sql."<br>";
							$result=mysqli_query($link, $sql) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row=mysqli_fetch_array($result))
							{
								$schs_array1[]=$row["sch"];
								$order_tid = $row["order_tid"];
							}

							$sql2="select distinct packing_mode as mode from $bai_pro3.packing_summary_input where order_del_no in (".$schedule.") and pac_seq_no=$seq_no";

							$result2=mysqli_query($link, $sql2) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row2=mysqli_fetch_array($result2))
							{
								$packing_mode=$row2["mode"];
							}

							$joinSch=$schedule; 
							//$sql2="select * from $bai_pro3.bai_orders_db_confirm where order_del_no = \"$joinSch\" ";
							$sql2="select order_style_no,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des from $bai_pro3.bai_orders_db_confirm where order_joins not in ('1','2') and order_del_no = \"$joinSch\" ";

							$result2=mysqli_query($link, $sql2) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row=mysqli_fetch_array($result2))
							{
								$disStyle=$row["order_style_no"];
								$disColor=$row["order_col_des"];

							}
						?>

						<div style="float:left">
							<table class='table table-bordered' style="font-size:11px;font-family:verdana;text-align:left;">
							<tr><th>Style </th><td>:</td> <td><?php echo $disStyle;?></td></tr>
							<tr><th>Schedule </th> <td>:</td> <td><?php echo $joinSch;?></td></tr>
							<tr><th>Color </th> <td>:</td> <td><?php echo $disColor;?></td></tr>
							<tr><th>Input Job Model </th> <td>:</td> <td><b><?php echo $operation[$packing_mode];?></b></td></tr>
							</table>
						</div>
					</div><br><br><br><br><br><br><br><br>
					<?php 
					//Getting sample details here  By SK-07-07-2018 == Start
					$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$disStyle\" and order_del_no=\"$joinSch\" and order_col_des=\"$disColor\"";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{

						for($s=0;$s<sizeof($sizes_code);$s++)
						{
							if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
							{
								$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
							}	
						}
					}
					$samples_qry="select * from $bai_pro3.sp_sample_order_db where order_tid='$order_tid' order by sizes_ref";
					$samples_qry_result=mysqli_query($link, $samples_qry) or exit("Sample query details".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_rows_samples = mysqli_num_rows($samples_qry_result);
					if($num_rows_samples >0){
						$samples_total = 0;	
						echo "<span><strong><u>Sample Quantites size wise:</u><strong></span><div class='row'>";
						echo "<div class='col-md-2'>";
						echo "<div class='table-responsive'>";						
						echo "<table class='table table-bordered'>"; 
						echo "<tr><thead>";						
						for($i=0;$i<sizeof($s_tit);$i++){
							echo "<th align=\"center\">".$s_tit[$sizes_code[$i]]."</th>";
						}
						echo "<th align=\"center\">Total</th></thead></tr><tr>";
						while($samples_data=mysqli_fetch_array($samples_qry_result))
						{
							$samples_total+=$samples_data['input_qty'];
							$samples_size_arry[] =$samples_data['sizes_ref'];
							$samples_input_qty_arry[] =$samples_data['input_qty'];
						}	
						for($s=0;$s<sizeof($s_tit);$s++)
						{
							$size_code = 's'.$sizes_code[$s];
							$flg = 0;
							for($ss=0;$ss<sizeof($samples_size_arry);$ss++)
							{
								if($size_code == $samples_size_arry[$ss])
								{
									echo "<td class=\"sizes\">".$samples_input_qty_arry[$ss]."</td>";
									$flg = 1;
								}			
							}	
							if($flg == 0)
							{
								echo "<td class=\"sizes\"><strong>-</strong></td>";
							}
						}		
						echo "<td class=\"sizes\">".$samples_total."</td></tr></table></div></div></div>";

					}

					?>

					<br>
					<?php
						$sql="select distinct order_del_no as sch,order_div from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
						$result=mysqli_query($link, $sql) or die("Error45 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($result))
						{
							$schs_array[]=$row["sch"];
							$division=$row["order_div"];
						}


						$size_array=array();

						for($p=0;$p<sizeof($schs_array);$p++)
						{
							for($q=0;$q<sizeof($sizes_array);$q++)
							{
								$sql6="select sum(order_s_".$sizes_array[$q].") as order_qty,title_size_".$sizes_array[$q]." as size from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schs_array[$p].") ";
								$result6=mysqli_query($link, $sql6) or die("Error35 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row6=mysqli_fetch_array($result6))
								{
									//echo $sizes_array[$q]."-".$row6["order_qty"]."<br>";
									if($row6["order_qty"] > 0)
									{
										if(!in_array($sizes_array[$q],$size_array))
										{
											$size_array[]=$sizes_array[$q];
											$orginal_size_array[]=$row6["size"];
										}
									}
								}
							}
						}

						echo "<div class='row'>";
						echo "<div class='col-md-12'>";
						echo "<div class='table-responsive'>";
						echo "<table class=\"gridtable\">"; 
						echo "<table class=\"table table-bordered\">";
						echo "<tr><thead>";
						echo "<th>Style</th>";
						echo "<th>PO#</th>";
						echo "<th>VPO#</th>";
						echo "<th>Schedule</th>";
						echo "<th>Destination</th>";
						echo "<th>Color</th>";
						echo "<th>Cut Job#</th>";
						echo "<th>Delivery Date</th>";
						echo "<th>Input Job#</th>";
						for($i=0;$i<sizeof($size_array);$i++)
						{
							echo "<th align=\"center\">".$orginal_size_array[$i]."</th>";
						}
						echo "<th>Total</th>";
						echo "</thead></tr>";

						$sql="select distinct input_job_no as job, type_of_sewing from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and pac_seq_no=$seq_no order by input_job_no*1";
						// echo $sql."<br>";
						$result=mysqli_query($link, $sql) or die("Error8-".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($result))
						{
							$type_of_sewing = $sql_row["type_of_sewing"];
							$sql1="select GROUP_CONCAT(DISTINCT acutno) AS acutno,group_concat(distinct order_del_no) as del_no,group_concat(distinct doc_no) as doc_nos from $bai_pro3.packing_summary_input where pac_seq_no=$seq_no and order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."' ";
							// echo $sql1."<br>";
							$result1=mysqli_query($link, $sql1) or die("Error88-".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row1=mysqli_fetch_array($result1))
							{
								$doc_nos_des=$sql_row1["doc_nos"];
								$acutno_ref=$sql_row1["acutno"];

								//$sql2d="select group_concat(distinct destination) as dest from plandoc_stat_log where doc_no in (".$doc_nos_des.") and acutno='".$acutno_ref."'";
								$sql2d="select group_concat(distinct destination) as dest from $bai_pro3.pac_stat_log_input_job where doc_no in (".$doc_nos_des.") and pac_seq_no=$seq_no";
								$result2d=mysqli_query($link, $sql2d) or die("Error888-".$sql2d."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row2d=mysqli_fetch_array($result2d))
								{
									$destination=$sql_row2d["dest"];
								}

								$sql2="select group_concat(distinct trim(destination)) as dest,order_style_no as style,GROUP_CONCAT(DISTINCT order_col_des separator '<br/>') as color,order_po_no as cpo,order_date,vpo from $bai_pro3.bai_orders_db where order_joins not in ('1','2') and order_del_no in (".$sql_row1["del_no"].")";
								// echo $sql2;
								$result2=mysqli_query($link, $sql2) or die("Error-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row2=mysqli_fetch_array($result2))
								{
									//$destination=$sql_row2["dest"];
									$color=$sql_row2["color"];
									$style=$sql_row2["style"];
									$po=$sql_row2["cpo"];
									$del_date=$sql_row2["order_date"];
									$vpo=$sql_row2["vpo"];
								}

								$sql_cut="select GROUP_CONCAT(DISTINCT order_col_des) AS color, GROUP_CONCAT(DISTINCT acutno) AS cut, SUM(carton_act_qty) AS totqty from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and pac_seq_no=$seq_no and input_job_no='".$sql_row["job"]."'";
								// echo $sql_cut.'<br>';
								$result_cut=mysqli_query($link, $sql_cut) or die("Error9-".$sql_cut."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_cut=mysqli_fetch_array($result_cut))
								{
									$cut_job_no=$sql_row_cut["cut"];
									$totcount1=$sql_row_cut["totqty"];
									$color=$sql_row_cut["color"];
								}

								$get_cut_no="SELECT GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno from $bai_pro3.packing_summary_input WHERE pac_seq_no=$seq_no and order_del_no = '$schedule' and input_job_no='".$sql_row["job"]."' ";
								// echo $get_cut_no.'<br>';
								$result_cut_no=mysqli_query($link, $get_cut_no) or die("Error92-".$get_cut_no."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_cut_no=mysqli_fetch_array($result_cut_no))
								{
									$total_cuts=explode(",",$sql_row_cut_no['acutno']);
									$cut_jobs_new='';
									for($ii=0;$ii<sizeof($total_cuts);$ii++)
									{
										$arr = explode("$", $total_cuts[$ii], 2);;
										// $col = $arr[0];
										$sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$arr[0]."'";
										//echo $sql4."<br>";
										$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_row4=mysqli_fetch_array($sql_result4))
										{
											$color_code=$sql_row4["color_code"];
										}
										$cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
										unset($arr);
									}
								}

								$sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$color."'";
			                    // echo $sql4."<br>";
			                    $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44".mysqli_error($GLOBALS["___mysqli_ston"]));
			                    while($sql_row4=mysqli_fetch_array($sql_result4))
			                    {
			                        $color_code=$sql_row4["color_code"];
			                    }

								// $cut_new=array();
								// $cut_new= explode(",", $cut_job_no);
								// $cut_jobs_new='';
								//  //var_dump($cut_new);
								//  //echo $color_code."<br>";die();
								// for ($i=0; $i < sizeof($cut_new); $i++)
								// {
								// 	// echo $cut_new[$i];
								// 	$cut_jobs_new .= chr($color_code).leading_zeros($cut_new[$i], 3).',';
								// }
								// // echo $cut_jobs_new;

								//Display color
								$display_colors=str_replace(',',$totcount,$color);
								//$totcount=0;
								
								$display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row["job"],$link);
								$bg_color1 = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row["job"],$link);
								echo "<tr height=20 style='height:15.0pt; background-color:$bg_color1;'>";
								echo "<td height=20 style='height:15.0pt'>".$style."</td>";
								echo "<td height=20 style='height:15.0pt'>$po</td>";
								echo "<td height=20 style='height:15.0pt'>$vpo</td>";
								echo "<td height=20 style='height:15.0pt'>".$sql_row1["del_no"]."</td>";
								echo "<td height=20 style='height:15.0pt'>$destination</td>";
								//echo "<td height=20 style='height:15.0pt'>".$display_colors." - (".$totcount1.")</td>";
								echo "<td height=20 style='height:15.0pt'>".$color."</td>";
								echo "<td height=20 style='height:15.0pt'>".substr($cut_jobs_new, 0,-1)."</td>";
								echo "<td height=20 style='height:15.0pt'>".$del_date."</td>";
								echo "<td height=20 style='height:15.0pt'>".$display."</td>";
								for($i=0;$i<sizeof($size_array);$i++)
								{
									$sql7="SELECT * FROM $bai_pro3.packing_summary_input where order_del_no in (".$sql_row1["del_no"].")  and size_code='".$orginal_size_array[$i]."' and pac_seq_no=$seq_no and input_job_no='".$sql_row["job"]."' and acutno in (".$acutno_ref.")";
									// echo $sql7."<br>";
									$result7=mysqli_query($link, $sql7) or die("Error7-".$sql7."-".mysqli_error($GLOBALS["___mysqli_ston"]));
									$rows_count=mysqli_num_rows($result7);
									if($rows_count > 0)
									{
										$sql5="SELECT round(sum(carton_act_qty),0) as qty FROM $bai_pro3.packing_summary_input where size_code='".$orginal_size_array[$i]."' and order_del_no in (".$sql_row1["del_no"].") and pac_seq_no=$seq_no and input_job_no='".$sql_row["job"]."' and acutno in (".$acutno_ref.")";
										// echo $sql5."<br>";
										$result5=mysqli_query($link, $sql5) or die("Error969-".$sql5."-".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_row5=mysqli_fetch_array($result5))
										{
											echo "<td class=xl787179 align=\"center\">".$sql_row5["qty"]."</td>";
											$total_qty1=$total_qty1+$sql_row5["qty"];
										}
									}
									else
									{
										echo "<td class=xl787179 align=\"center\">0</td>";
										$total_qty1=$total_qty1+0;
									}
								}
								echo "<td align=\"center\">".$total_qty1."</td>";
								$total_qty1=0;
								echo "</tr>";
							}
						}
						$o_total=0;
						echo "<tr>";
						echo "<th colspan=9  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;font-size:14px;\"> Total</th>";
						$sql1="SELECT ROUND(SUM(carton_act_qty),0) AS qty FROM $bai_pro3.packing_summary_input WHERE  order_del_no IN ($joinSch) and pac_seq_no=$seq_no GROUP BY old_size";
						//echo $sql1;
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error996".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$o_s=$sql_row1['qty'];
							if ($o_s!=0) {	echo "<th align=\"center\" style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">".$o_s."</th>"; }
							$o_total=$o_s+$o_total;
							//echo $o_total;
						}
						echo "<th  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">$o_total</th>";
						echo "</tr>";

						echo "</table></div></div></div></div><br>";
					?>
				</div>
		    </div>
		</div>
		<?php
	}
?>