<body> 
<div class="panel panel-primary">
<div class="panel-heading">Mo wise Quantities Segregating</div>
<div class="panel-body">

<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	set_time_limit(30000000);
	$process_name= $_GET['process_name'];
	$style_id    = $_GET["style"]; 
	$schedule_id = $_GET["schedule_id"];
	$file_name   = $_GET['filename'];
	$schedule    = $_GET['schedule'];
	$split_proces_name=$process_name;
	$style = $_GET['style'];
	$sref_id = $_GET['sref_id'];
	$last_mo = '';
	
	$doc_no_get = $_GET['doc_no'];

	if(isset($_GET['club'])){
		$club = $_GET['club'];
	}
	if(isset($_GET['order_tid']))
	{
		$order_tid[]=$_GET['order_tid'];
	}
	if(isset($_GET['order_tid_arr']))
	{
		$order_tids=$_GET['order_tid_arr'];
		$order_tid=explode(',',$order_tids);
	}
	
	//$order_tid[] = 'JOA141S9       55881511 - PINK BOTTOM              ';
	//$order_tid[]='JJP327F8       52834608-DARKGREY-ROSECLAIRBOTTOM   ';

	$sql1216="SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref WHERE default_operation='Yes' group by category order by category*1"; 
	$result1216=mysqli_query($link, $sql1216) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($row12106=mysqli_fetch_array($result1216)) 
	{
		$category[]     = $row12106['codes'];
		$category_name[]= $row12106['category'];		
	}

	for($l=0;$l<sizeof($category_name);$l++)
	{
		if($category_name[$l]==$split_proces_name && $split_proces_name == 'cutting' && $club!='clubbing')
		{
			//$style_id=$_GET["style"]; 
			//$schedule_id=$_GET["schedule"];
			foreach($order_tid as $key=>$order_tid)
			{
				$mo_no=array();
				$moq=array();
				$ops_m_id=array();
				$ops_m_name=array();
				$size_qty=array();
				$size_tit=array();
				$ops=array();
				$opst=array();
				// $style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
				// $schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
				// $color = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
				// $order_tid='';
				$sql12="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_tid like '%$order_tid%'";
				$result129=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row121=mysqli_fetch_array($result129))
				{					
					$style = $row121['order_style_no'];
					$schedule = $row121['order_del_no'];
					$style_id=$row121['style_code'];
					$schedule_id=$row121['ref_order_num'];
					$col=trim($row121['order_col_des']);
					//$i_docket_no = $row121['doc_no'];
					for($i=0;$i<sizeof($sizes_array);$i++)
					{
						if($row121["title_size_".$sizes_array[$i].""]<>'')
						{
							$size_qty[$i]=$row121["order_s_".$sizes_array[$i].""];
							$size_tit[$i]=trim($row121["title_size_".$sizes_array[$i].""]);
						}
					}
					for($j=0;$j<sizeof($size_tit);$j++)
					{
						$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='".$size_tit[$j]."' and schedule='".$schedule."' and TRIM(color)='".$col."' order by mo_no*1"; 
						$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row1210=mysqli_fetch_array($result121)) 
						{
							$mo_no[]=$row1210['mo_no'];
							$moq[]=$row1210['mo_quantity'];
							$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($category[$l]) and MONumber='".$row1210['mo_no']."' order by OperationNumber*1"; 
							$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row1212=mysqli_fetch_array($result1212)) 
							{
								$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];
								$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
								$opst[]=$row1212['OperationNumber'];
							}
						}
					
						if(sizeof($mo_no)>0)
						{
							$ops=array_unique($opst);
							if(sizeof($mo_no)==1)
							{
								$last_mo = $mo_no[0];
								for($k=0;$k<sizeof($ops);$k++)
								{
									if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
									{	
										// $sql12="SELECT (p_".$sizes_array[$j]."*p_plies) as qty,doc_no,acutno FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."' and doc_no = '$doc_no_get' group by doc_no";	
										$sql12 = "select send_qty as qty from $brandix_bts.bundle_creation_data where 
												  docket_number = '$doc_no_get' and size_title='".$size_tit[$j]."' ";				
										$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
										while($row12=mysqli_fetch_array($result12)) 
										{
											$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, 
											`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."','$doc_no_get','".$row12['qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
											$result1=mysqli_query($link, $sql) or die("Error 2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
										}									
									}
								}
							}
							else
							{
								$bal=0;$qty_tmp=0;
								// $sql1234="SELECT (p_".$sizes_array[$j]."*p_plies) as qty,doc_no,acutno FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."'  and doc_no = '$doc_no_get' group by doc_no";
								$sql1234 = "select send_qty as qty from $brandix_bts.bundle_creation_data where 
											docket_number = '$doc_no_get' and size_title='".$size_tit[$j]."' ";
								$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row1234=mysqli_fetch_array($result1234)) 
								{
									$qty=$row1234['qty'];								
									for($kk=0;$kk<sizeof($mo_no);$kk++)
									{	
										$last_mo = $mo_no[$kk];				
										$m_fil=0;
										$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' and op_code in ($category[$l]) GROUP BY op_code ORDER BY op_code*1 LIMIT 1";
										$result12345=mysqli_query($link, $sql12345) or die("Error b".mysqli_error($GLOBALS["___mysqli_ston"])); 
										while($row12345=mysqli_fetch_array($result12345)) 
										{
											$m_fil=$row12345['qty'];
										}
										if($m_fil=='' || $m_fil==0)
										{
											$m_fil=0;
										}
										$bal=$moq[$kk]-$m_fil;
										if($bal>0)
										{	
											if($bal>$qty)
											{	
												for($jj=0;$jj<sizeof($ops);$jj++)
												{	
													if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
													{
														$qty_tmp=0;
														$qty=$qty-$qty_tmp;
														if($qty>0)
														{
															$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','$doc_no_get','".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
															$result1=mysqli_query($link, $sql) or die("Error 3 ".mysqli_error($GLOBALS["___mysqli_ston"]));
														}
													}
												}	
												$qty=0;
												
											}
											else
											{
												for($jj=0;$jj<sizeof($ops);$jj++)
												{	
													if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
													{
														$qty_tmp=0;
														$qty=$qty-$qty_tmp;
														if($qty>0)
														{
															$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','$doc_no_get','$bal', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
															$result1=mysqli_query($link, $sql) or die("Error 6 ".mysqli_error($GLOBALS["___mysqli_ston"]));
														}
													}
												}		
												$qty=$qty-$bal;
												$bal=0;
											}							
										}								
									}	
								}
								//Excess allocate to Last MO
								//$lastmo=echo_title("$bai_pro3.mo_details","MAX(mo_no)","TRIM(size)='".$size_tit[$j]."' and TRIM(color)='".$col."' and schedule",$schedule,$link);
								$bal=0;$qty_tmp=0;$qty=0;
								// $sql12341="SELECT SUM(p_".$sizes_array[$j]."*p_plies) as qty,doc_no,acutno FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."' group by order_tid";
								$sql12341 ="Select send_qty as qty from $brandix_bts.bundle_creation_data where 
											docket_number = '$doc_no_get' and size_title='".$size_tit[$j]."' ";
								$result12341=mysqli_query($link, $sql12341) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								if(mysqli_num_rows($result12341)>0)
								{
									while($row12341=mysqli_fetch_array($result12341)) 
									{
										$qty=$row12341['qty'];
										// $sql1234100="SELECT sum(bundle_quantity) as qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."' group by doc_no";
										// LEFT JOIN $bai_pro3.mo_operation_quantites moq ON moq.mo_no = mo.mo_no
										$sql1234100 = "SELECT SUM(mo_quantity) as qty 
													   FROM $bai_pro3.mo_details mo
													   WHERE TRIM(size)='".$size_tit[$j]."' and schedule='".$schedule."' 
													   and TRIM(color)='".$col."' group by color"; 
										//echo $sql1234100;
										//echo $sql1234100;
										
										$result1234100=mysqli_query($link, $sql1234100) or die("Error 7 ".mysqli_error($GLOBALS["___mysqli_ston"])); 
										while($row1234100=mysqli_fetch_array($result1234100)) 
										{
											$qty_fill=$row1234100['qty'];
										}
										
										if(($qty-$qty_fill)>0)
										{
											$qty = $qty - $qty_fill;
											for($jjj=0;$jjj<sizeof($ops);$jjj++)
											{
												if($ops_m_id[$lastmo][$ops[$jjj]]<>'')
												{
													$sql = "Update $bai_pro3.mo_operation_quantites 
															set bundle_quantity = bundle_quantity + $qty
															where mo_no = '$lastmo' and doc_no = '$doc_no_get' and op_code = $ops[$jjj]";
													/*
													$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `mo_no`, `doc_no`,`bundle_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$lastmo."', '".$row12341['doc_no']."','".$row12341['acutno']."','".($qty-$qty_fill)."', '".$ops_m_id[$lastmo][$ops[$jjj]]."', '".$ops_m_name[$lastmo][$ops[$jjj]]."')";
													*/
													$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
												}							
											}							
										}
										$qty=0;						
										$qty_fill=0;						
									}
								}
							}
							unset($mo_no);
							unset($moq);
							unset($ops_m_id);
							unset($ops_m_name);			
							unset($ops);
						}
					}
					unset($size_tit);
					unset($size_qty);
				}
			}		
			if($file_name=='layplan')
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					location.href = \"".getFullURLLevel($_GET['r'], 'cutting/controllers/lay_plan_preparation/main_interface.php',3,'N')."&color=$col&style=$style&schedule=$schedule\";
					}
				</script>";	
			}
			if($file_name=='mixjobs')
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					location.href = \"".getFullURLLevel($_GET['r'], 'cutting/controllers/schedule_club_style/mix_jobs.php',3,'N')."&color=$col&style=$style&schedule=$schedule\";
					}
				</script>";	
			}
			if($file_name=='schsplit')
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					location.href = \"".getFullURLLevel($_GET['r'], 'cutting/controllers/schedule_clubbing/schedule_split_bek.php',3,'N')."&color=$col&style=$style&schedule=$schedule\";
					}
				</script>";	
			}		
			echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
		}
		elseif($category_name[$l] == $split_proces_name && $split_proces_name == 'sewing'){
			$mo_no=array();
			$moq=array();
			$ops_m_id=array();
			$ops_m_name=array();
			$size_tit=array();
			$ops=array();
			$opst=array();
			// $style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
			// $schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
			// $sql12="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
			// $result129=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$jobs_style_query = "Select order_style_no as style from $bai_pro3.packing_summary_input where 
								TRIM(order_del_no) = '$schedule' and sref_id = '$sref_id' limit 1";
			$jobs_style_result = mysqli_query($link,$jobs_style_query);
			while($row = mysqli_fetch_array($jobs_style_result)){
				$style = $row['style'];
			}
			
			$jobs_col_query = "Select distinct(order_col_des) as color from $bai_pro3.packing_summary_input 
						   where order_del_no ='$schedule' and sref_id = '$sref_id'";
			$jobs_col_result = mysqli_query($link,$jobs_col_query);
			while($row = mysqli_fetch_array($jobs_col_result)){
				$colors[] = $row['color'];
			}

			foreach($colors as $col){
				$jobs_sizes_query = "Select distinct(size_code) as size from $bai_pro3.packing_summary_input 
									where order_col_des = '$col' and sref_id='$sref_id'";
				$jobs_size_result = mysqli_query($link,$jobs_sizes_query) or exit('Error Encounterd while getting sizes in MO');
				while($row = mysqli_fetch_array($jobs_size_result)){
					$sizes[] = $row['size'];
				}

				//while($row121=mysqli_fetch_array($result129))
				//{
					// $style_id=$row121['order_style_no'];
					// $schedule_id=$row121['order_del_no'];
					// $col=trim($row121['order_col_des']);
					// for($i=0;$i<sizeof($sizes_array);$i++)
					// {
					// 	if($row121["title_size_".$sizes_array[$i].""]<>'')
					// 	{
					// 		$size_qty[$i]=$row121["order_s_".$sizes_array[$i].""];
					// 		$size_tit[$i]=trim($row121["title_size_".$sizes_array[$i].""]);
					// 	}
					// }

				foreach($sizes as $size_code)
				{
					$qty = 0;
					$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_code' and 
							TRIM(schedule)='".trim($schedule)."' and TRIM(color)='".trim($col)."' 
							order by mo_no*1"; 
					$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo $sql121;
					while($row1210=mysqli_fetch_array($result121)) 
					{
						$mo_no[]= $row1210['mo_no'];
						$moq[]  = $row1210['mo_quantity'];
						$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($category[$l]) and MONumber='".$row1210['mo_no']."' order by OperationNumber*1"; 
						$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql1212;
						while($row1212=mysqli_fetch_array($result1212)) 
						{
							$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];					
							$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
							$opst[]=$row1212['OperationNumber'];
						}
					}
		
					if(sizeof($mo_no)>0)
					{
						$ops=array_unique($opst);
						if(sizeof($mo_no)==1)
						{
							$last_mo = $mo_no[0];
							for($k=0;$k<sizeof($ops);$k++)
							{
								if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
								{
									$sql1231="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and sref_id = '$sref_id' 
									and type_of_sewing='1' ";
									$result1231=mysqli_query($link, $sql1231) or 
												die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									//echo $sql1231.'<br/>';
									while($row1231=mysqli_fetch_array($result1231)) 
									{
										$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."', '".$row1231['tid']."','".$row1231['carton_act_qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
										//echo $sql.'<br/>';
										$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									}
								}
							}
						}
						else
						{
							$bal=0;$qty_tmp=0;
							$sql1234="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."'  and sref_id = '$sref_id' and type_of_sewing='1'";
							$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							//echo $sql1234.'<br/>';
							while($row1234=mysqli_fetch_array($result1234)) 
							{
								$qty=$row1234['carton_act_qty'];
								$bundle_no = $row1234['tid'];
								for($kk=0;$kk<sizeof($mo_no);$kk++)
								{				
									$last_mo = $mo_no[sizeof($mo_no)];	
									$m_fil=0;
									$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' and op_code IN ($ops[0]) GROUP BY op_code";
									$result12345=mysqli_query($link, $sql12345) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									while($row12345=mysqli_fetch_array($result12345)) 
									{
										$m_fil=$row12345['qty'];
									}
									if($m_fil=='' || $m_fil==0)
									{
										$m_fil=0;
									}
									$bal=$moq[$kk]-$m_fil;
									if($bal>0)
									{	
										if($bal>$qty)
										{	
											for($jj=0;$jj<sizeof($ops);$jj++)
											{	
												if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
												{
													if($qty>0)
													{
														$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) 
														VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."', '".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
														//echo 'inner -- '.$sql.'<br/>';
														$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
													}
												}
											}	
											$qty=0;
											
										}
										else
										{
											for($jj=0;$jj<sizeof($ops);$jj++)
											{	
												if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
												{
													if($qty>0)
													{
														$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."','".$bal."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
														//echo ' downer -- '.$sql.'<br/>';
														$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
													}
												}
											}		
											$qty=$qty-$bal;
											$bal=0;
										}			
									}								
								}	
								if($qty > 0){
									for($l=0;$l<sizeof($ops);$l++){	
										if($ops_m_id[$last_mo][$ops[$l]]>0){	
											$sql = "Update $bai_pro3.mo_operation_quantites set 
													bundle_quantity = bundle_quantity + $qty where mo_no = '$last_mo' and 
													ref_no = '$bundle_no' and op_code = '".$ops_m_id[$last_mo][$ops[$l]]."'";
											$result1=mysqli_query($link, $sql) or exit('Error Encountered');
										}
									}
								}	
							}
							//Excess allocate to Last MO
							$qty1 = $qty;
							//$lastmo=echo_title("$bai_pro3.mo_details","MAX(mo_no)","TRIM(size)='$size_code' and TRIM(color)='".trim($col)."' and schedule",$schedule,$link);
							$bal=0;$qty_tmp=0;$qty=0;
							$sql12341="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and type_of_sewing<>'1'";
							$result12341=mysqli_query($link, $sql12341) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							if(mysqli_num_rows($result12341)>0)
							{
								while($row12341=mysqli_fetch_array($result12341)) 
								{
									$qty=$row12341['carton_act_qty'];
									if($qty>0)
									{
										for($jjj=0;$jjj<sizeof($ops);$jjj++)
										{
											if($ops_m_id[$lastmo][$ops[$jjj]]<>'')
											{
												//echo "re inserted ";
												$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`,`ref_no`,  `bundle_quantity`, `op_code`, `op_desc`) 
												VALUES ('".date("Y-m-d H:i:s")."', '".$lastmo."', '".$row12341['tid']."','".$qty."', '".$ops_m_id[$lastmo][$ops[$jjj]]."', '".$ops_m_name[$lastmo][$ops[$jjj]]."')";
												$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											}							
										}							
									}
									$qty=0;						
								}
							}
						}
						unset($mo_no);
						unset($moq);
						unset($ops_m_id);
						unset($ops_m_name);			
						unset($ops);
					}
					//echo "<br>-----------------------------------------------------------------------<br/>";
				}
				unset($sizes);
				//unset($size_qty);
			}	
		}
		elseif($category_name[$l]==$split_proces_name && $split_proces_name == 'packing')
		{
			$pack_ref = $_GET['pack_ref'];
			$sch_id = $_GET['sch_id'];
			$sty_id = $_GET['style_id'];
			$schedule = $_GET['schedule'];
			$mo_no=array();
			$moq=array();
			$ops_m_id=array();
			$ops_m_name=array();
			$size_tit=array();
			$ops=array();
			$opst=array();
			// $style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
			//$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
			// $sql12="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
			// $result129=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
			$jobs_style_query1 = "Select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where 
								order_del_no = '$schedule' and seq_no = '$pack_ref'";
			$jobs_style_result1 = mysqli_query($link,$jobs_style_query1);
			while($row1 = mysqli_fetch_array($jobs_style_result1))
			{
				$qty1 = $row1['qty'];
			}
			if($qty1>0)
			{			
				$jobs_style_query = "Select order_style_no as style from $bai_pro3.packing_summary where 
									order_del_no = '$schedule' and seq_no = '$pack_ref' limit 1";
				$jobs_style_result = mysqli_query($link,$jobs_style_query);
				while($row = mysqli_fetch_array($jobs_style_result))
				{
					$style = $row['style'];
				}
				
				$jobs_col_query = "Select distinct(order_col_des) as color from $bai_pro3.packing_summary 
							where order_del_no ='$schedule' and seq_no = '$pack_ref'";
				$jobs_col_result = mysqli_query($link,$jobs_col_query);
				while($row = mysqli_fetch_array($jobs_col_result))
				{
					$colors[] = $row['color'];
				}

				if(sizeof($colors>0))
				{
					foreach($colors as $col)
					{
						$jobs_sizes_query = "Select distinct(size_tit) as size from $bai_pro3.packing_summary 
											where order_col_des = '$col' and seq_no = '$pack_ref'";
						$jobs_size_result = mysqli_query($link,$jobs_sizes_query) or exit('Error Encounterd while getting sizes in MO');
						while($row = mysqli_fetch_array($jobs_size_result))
						{
							$sizes[] = $row['size'];
						}

						foreach($sizes as $size_code)
						{
							$qty = 0;
							$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_code' and schedule='".$schedule."' and TRIM(color)='".trim($col)."' order by mo_no*1"; 
							$result121=mysqli_query($link, $sql121) or die("Mo Details not available.");
							// echo $sql121;
							while($row1210=mysqli_fetch_array($result121)) 
							{
								$mo_no[]= $row1210['mo_no'];
								$moq[]  = $row1210['mo_quantity'];
								$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($op_codes) and MONumber='".$row1210['mo_no']."' order by OperationNumber*1"; 
								$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.");
								//echo $sql1212;
								while($row1212=mysqli_fetch_array($result1212)) 
								{
									$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];					
									$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
									$opst[]=$row1212['OperationNumber'];
								}
							}
				
							if(sizeof($mo_no)>0)
							{
								$ops=array_unique($opst);
								if(sizeof($mo_no)==1)
								{
									$last_mo = $mo_no[0];
									for($k=0;$k<sizeof($ops);$k++)
									{
										if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
										{
											$sql1231="SELECT * FROM $bai_pro3.packing_summary WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and seq_no = '$pack_ref'";
											$result1231=mysqli_query($link, $sql1231) or 
														die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
											//echo $sql1231.'<br/>';
											while($row1231=mysqli_fetch_array($result1231)) 
											{
												$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."', '".$row1231['tid']."','".$row1231['carton_act_qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
												//echo $sql.'<br/>';
												$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											
											}
										}
									}
								}
								else
								{
									$bal=0;$qty_tmp=0;
									$sql1234="SELECT * FROM $bai_pro3.packing_summary WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."'  and seq_no = '$pack_ref'";
									$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									//echo $sql1234.'<br/>';
									while($row1234=mysqli_fetch_array($result1234)) 
									{
										$qty=$row1234['carton_act_qty'];
										$bundle_no = $row1234['tid'];
										for($kk=0;$kk<sizeof($mo_no);$kk++)
										{				
											$last_mo = $mo_no[sizeof($mo_no)];	
											$m_fil=0;
											$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' and op_code IN ($ops[0]) GROUP BY op_code";
											$result12345=mysqli_query($link, $sql12345) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
											while($row12345=mysqli_fetch_array($result12345)) 
											{
												$m_fil=$row12345['qty'];
											}
											if($m_fil=='' || $m_fil==0)
											{
												$m_fil=0;
											}
											$bal=$moq[$kk]-$m_fil;
											if($bal>0)
											{	
												if($bal>$qty)
												{	
													for($jj=0;$jj<sizeof($ops);$jj++)
													{	
														if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
														{
															if($qty>0)
															{
																$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) 
																VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."', '".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
																//echo 'inner -- '.$sql.'<br/>';
																$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
															}
														}
													}	
													$qty=0;												
												}
												else
												{
													for($jj=0;$jj<sizeof($ops);$jj++)
													{	
														if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
														{
															if($qty>0)
															{
																$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."','".$bal."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
																//echo ' downer -- '.$sql.'<br/>';
																$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
															}
														}
													}		
													$qty=$qty-$bal;
													$bal=0;
												}			
											}								
										}	
										//Excess allocate to Last MO
										if($qty > 0){
											for($l=0;$l<sizeof($ops);$l++){	
												if($ops_m_id[$last_mo][$ops[$l]]>0){	
													$sql = "Update $bai_pro3.mo_operation_quantites set 
													bundle_quantity = bundle_quantity + $qty where mo_no = '$last_mo' and 
													ref_no='".$row1234['tid']."' and op_code = '".$ops_m_id[$last_mo][$ops[$l]]."'";
													$result1=mysqli_query($link, $sql) or exit('Error Encountered');
												}
											}
										}	
									}
								}
								unset($mo_no);
								unset($moq);
								unset($ops_m_id);
								unset($ops_m_name);			
								unset($ops);
							}
							//echo "<br>-----------------------------------------------------------------------<br/>";
						}
						unset($sizes);
						//unset($size_qty);
					}
				}
			}

		}elseif($category_name[$l]==$split_proces_name && $split_proces_name == 'cutting' && $club == 'clubbing')
		{
			//$style_id=$_GET["style"]; 
			//$schedule_id=$_GET["schedule"];
			foreach($order_tid as $key=>$order_tid)
			{
				//echo "Camee";
				$mo_no=array();
				$moq=array();
				$ops_m_id=array();
				$ops_m_name=array();
				$size_qty=array();
				$size_tit=array();
				$ops=array();
				$opst=array();
				// $style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
				// $schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
				// $color = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
				// $order_tid='';
				$sql12="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_tid like '%".$order_tid."%'";
				$result129=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row121=mysqli_fetch_array($result129))
				{
					unset($dockets);
					$doc_nos = "Select doc_no from $bai_pro3.plandoc_stat_log where order_tid='$order_tid'";
					$docs_result = mysqli_query($link,$doc_nos) or exit("d to get docs");
					while($row = mysqli_fetch_array($docs_result)){
						$dockets[] = $row['doc_no'];
						//echo $row['doc_no'];
					}	
					
					for($i=0;$i<sizeof($sizes_array);$i++)
					{
						if($row121["title_size_".$sizes_array[$i].""]<>'')
						{
							$size_qty[$i]=$row121["order_s_".$sizes_array[$i].""];
							$size_tit[$i]=trim($row121["title_size_".$sizes_array[$i].""]);
						}
					}
					foreach($dockets as $key=>$doc_no_get)
					{
						$style = $row121['order_style_no'];
						$schedule = $row121['order_del_no'];
						$style_id=$row121['style_code'];
						$schedule_id=$row121['ref_order_num'];
						$col=trim($row121['order_col_des']);
						//echo $doc_no_get.'-----------------------<br>';
						//$i_docket_no = $row121['doc_no'];
						// var_dump($size_tit);
						for($j=0;$j<sizeof($size_tit);$j++)
						{
							$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='".$size_tit[$j]."' and schedule='".$schedule."' and TRIM(color)='".$col."' order by mo_no"; 
							$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row1210=mysqli_fetch_array($result121)) 
							{
								$mo_no[]=$row1210['mo_no'];
								$moq[]=$row1210['mo_quantity'];
								$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($category[$l]) and MONumber='".$row1210['mo_no']."' order by OperationNumber*1"; 
								$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row1212=mysqli_fetch_array($result1212)) 
								{
									$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];					
									$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
									$opst[]=$row1212['OperationNumber'];
								}
							}
						
							if(sizeof($mo_no)>0)
							{
								$ops=array_unique($opst);
								if(sizeof($mo_no)==1)
								{
									$last_mo = $mo_no[0];
									for($k=0;$k<sizeof($ops);$k++)
									{
										if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
										{	
											//echo "OKKK";
											$sql12="SELECT (p_".$sizes_array[$j]."*p_plies) as qty,doc_no,acutno FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."' and doc_no = '$doc_no_get' 
											group by doc_no";					
											$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
											while($row12=mysqli_fetch_array($result12)) 
											{
												$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, 
												`bundle_quantity`, `op_code`, `op_desc`) 
												VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."','".$row12['doc_no']."','".$row12['qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
												//echo "docekt = ".$doc_no_get.'== '.$row12['doc_no']."<br>";
												$result1=mysqli_query($link, $sql) or die("Error 2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
											}									
										}
									}
								}
								else
								{
									$bal=0;$qty_tmp=0;
									$sql1234="SELECT (p_".$sizes_array[$j]."*p_plies) as qty,doc_no,acutno FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."'  and doc_no = '$doc_no_get' group by doc_no";
									$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									while($row1234=mysqli_fetch_array($result1234)) 
									{
										$qty=$row1234['qty'];
										//echo $doc_no_get.'-'.$sizes_array[$j].'-'.$qty.'</br>';								
										for($kk=0;$kk<sizeof($mo_no);$kk++)
										{		
											$last_mo = $mo_no[$kk];				
											$m_fil=0;
											$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' and op_code in ($category[$l]) GROUP BY op_code ORDER BY op_code*1 LIMIT 1";
											$result12345=mysqli_query($link, $sql12345) or die("Error b".mysqli_error($GLOBALS["___mysqli_ston"])); 
											while($row12345=mysqli_fetch_array($result12345)) 
											{
												$m_fil=$row12345['qty'];
											}
											if($m_fil=='' || $m_fil==0)
											{
												$m_fil=0;
											}
											$bal=$moq[$kk]-$m_fil;
											if($bal>0)
											{	
												if($bal>$qty)
												{	
													for($jj=0;$jj<sizeof($ops);$jj++)
													{	
														if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
														{
															$qty_tmp=0;
															$qty=$qty-$qty_tmp;
															if($qty>0)
															{
																$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) 
																VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['doc_no']."','".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
																$result1=mysqli_query($link, $sql) or die("Error 3 ".mysqli_error($GLOBALS["___mysqli_ston"]));
																//echo "docekt 2 = ".$doc_no_get.'== '.$row1234['doc_no']."<br>";
															}
														}
													}	
													$qty=0;
													
												}
												else
												{
													for($jj=0;$jj<sizeof($ops);$jj++)
													{	
														if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
														{
															$qty_tmp=0;
															$qty=$qty-$qty_tmp;
															if($qty>0)
															{
																$sql="INSERT INTO $bai_pro3.mo_operation_quantites (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."', '".$row1234['doc_no']."','".$bal."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
																$result1=mysqli_query($link, $sql) or die("Error 6 ".mysqli_error($GLOBALS["___mysqli_ston"]));
																//echo "docekt 3 = ".$doc_no_get."==".$row1234['doc_no']."<br>";
															}
														}
													}		
													$qty=$qty-$bal;
													$bal=0;
												}							
											}								
										}	
									}
									//Excess allocate to Last MO
									$lastmo=echo_title("$bai_pro3.mo_details","MAX(mo_no)","TRIM(size)='".$size_tit[$j]."' and TRIM(color)='".$col."' and schedule",$schedule,$link);
									$bal=0;$qty_tmp=0;$qty=0;
									$sql12341="SELECT SUM(p_".$sizes_array[$j]."*p_plies) as qty,doc_no,acutno FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."' 
									and doc_no = $doc_no_get";
									//echo $sql12341;
									$result12341=mysqli_query($link, $sql12341) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									if(mysqli_num_rows($result12341)>0)
									{
										while($row12341=mysqli_fetch_array($result12341)) 
										{
											$qty=$row12341['qty'];
											// $sql1234100="SELECT sum(bundle_quantity) as qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE p_".$sizes_array[$j].">0 and order_tid='".$order_tid."' group by doc_no";
											// LEFT JOIN $bai_pro3.mo_operation_quantites moq ON moq.mo_no = mo.mo_no
											$sql1234100 = "SELECT SUM(mo_quantity) as qty 
														FROM $bai_pro3.mo_details mo
														WHERE TRIM(size)='".$size_tit[$j]."' and schedule='".$schedule."' 
														and TRIM(color)='".$col."' group by color"; 
											//echo $sql1234100;
											//echo $sql1234100;
											
											$result1234100=mysqli_query($link, $sql1234100) or die("Error 7 ".mysqli_error($GLOBALS["___mysqli_ston"])); 
											while($row1234100=mysqli_fetch_array($result1234100)) 
											{
												$qty_fill=$row1234100['qty'];
											}
											
											if(($qty-$qty_fill)>0)
											{
												$qty = $qty - $qty_fill;
												for($jjj=0;$jjj<sizeof($ops);$jjj++)
												{
													if($ops_m_id[$lastmo][$ops[$jjj]]<>'')
													{
														$sql = "Update $bai_pro3.mo_operation_quantites 
																set bundle_quantity = bundle_quantity + $qty
																where mo_no = '$lastmo' and doc_no = '$doc_no_get' and op_code = $ops[$jjj]";
														/*
														$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `mo_no`, `doc_no`,`bundle_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$lastmo."', '".$row12341['doc_no']."','".$row12341['acutno']."','".($qty-$qty_fill)."', '".$ops_m_id[$lastmo][$ops[$jjj]]."', '".$ops_m_name[$lastmo][$ops[$jjj]]."')";
														*/
														$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
													}							
												}							
											}
											$qty=0;						
											$qty_fill=0;						
										}
									}
								}
							
							}
						}
						
					}//Closing foreach
					unset($mo_no);
					unset($moq);
					unset($ops_m_id);
					unset($ops_m_name);			
					unset($ops);
				}
				unset($size_tit);
				unset($size_qty);
			}		
			if($file_name=='layplan')
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					location.href = \"".getFullURLLevel($_GET['r'], 'cutting/controllers/lay_plan_preparation/main_interface.php',3,'N')."&color=$col&style=$style&schedule=$schedule\";
					}
				</script>";	
			}
			if($file_name=='mixjobs')
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					location.href = \"".getFullURLLevel($_GET['r'], 'cutting/controllers/schedule_club_style/mix_jobs.php',3,'N')."&color=$col&style=$style&schedule=$schedule\";
					}
				</script>";	
			}
			if($file_name=='schsplit')
			{
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
				function Redirect() {
					location.href = \"".getFullURLLevel($_GET['r'], 'cutting/controllers/schedule_clubbing/schedule_split_bek.php',3,'N')."&color=$col&style=$style&schedule=$schedule\";
					}
				</script>";	
			}		
			echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
		}
	}
	
	if(trim($file_name )== 'create_sewing'){
		// echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
		echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");	
	}
	
?> 
</div></div>
</body>

