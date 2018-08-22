<body> 
<div class="panel panel-primary">
<div class="panel-heading">Mo wise Quantities Segregating</div>
<div class="panel-body">
<?php

	set_time_limit(30000000); 
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$style_id=$_GET["style"]; 
	$schedule_id=$_GET["schedule"];
	$mo_no=array();
	$moq=array();
	$ops_m_id=array();
	$ops_m_name=array();
	$size_qty=array();
	$size_tit=array();
	$ops=array();
	$opst=array();
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	//$not_condier=array(1,10,15,200);
	$sql12="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
	$result129=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result129))
	{
		$style_id=$row121['style_code'];
		$schedule_id=$row121['ref_order_num'];
		$col=trim($row121['order_col_des']);
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
				$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE MONumber='".$row1210['mo_no']."' order by OperationNumber*1"; 
				$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row1212=mysqli_fetch_array($result1212)) 
				{
					$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];					
					$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
					$opst[]=$row1212['OperationNumber'];
				}
			}
			$ops=array_unique($opst);
			if(sizeof($mo_no)==1)
			{
				for($k=0;$k<sizeof($ops);$k++)
				{
					if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
					{
						/*	
						if(in_array($ops_m_id[$mo[0]][$k],$not_condier))
						{	
							$sql12="SELECT min(tid) as tid,doc_no,input_job_no,input_job_no_random,doc_no,sum(carton_act_qty) as qty FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."' group by doc_no,size_code";
							echo $sql12."<br>";						
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{
								$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$mo_no[0]."','".$row12['tid']."', '".$row12['qty']."', '".$ops_m_id[$mo_no[0]][$k]."', '".$ops_m_name[$mo_no[0]][$k]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
								$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}
						else
						{
							*/
							$sql1231="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."'"; 
							$result1231=mysqli_query($link, $sql1231) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row1231=mysqli_fetch_array($result1231)) 
							{
								$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row1231['doc_no']."', '".$mo_no[0]."', '".$row1231['tid']."', '".$row1231['carton_act_qty']."', '".$ops_m_id[$mo_no[0]][$k]."', '".$ops_m_name[$mo_no[0]][$k]."', '".$row1231['input_job_no']."', '".$row1231['input_job_no_random']."')";
								$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						//}
					}
				}
			}
			else
			{
				$bal=0;$qty_tmp=0;
				$sql1234="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."' and type_of_sewing='1'";
				$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row1234=mysqli_fetch_array($result1234)) 
				{
					$qty=$row1234['carton_act_qty'];
					
					for($kk=0;$kk<sizeof($mo_no);$kk++)
					{						
						$m_fil=0;
						$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' GROUP BY op_code ORDER BY op_code*1 LIMIT 1";
						//echo $sql12345."<br>";
						//echo $row1234['tid']."--".$qty."<br>";
						$result12345=mysqli_query($link, $sql12345) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12345=mysqli_fetch_array($result12345)) 
						{
							$m_fil=$row12345['qty'];
						}
						//$m_fil=echo_title("$bai_pro3.mo_operation_quantites","sum(bundle_quantity)","mo_no",$mo_no[$kk],$link);
						if($m_fil=='' || $m_fil==0)
						{
							$m_fil=0;
						}
						//echo "MO NUmber".$mo_no[$kk]."<br>";
						//echo "Main=".$moq[$kk]."Fill==".$qty."Bal==".$qty_tmp."Upto==".$m_fil."<br>";
						$bal=$moq[$kk]-$m_fil;
						if($bal>0)
						{	
							if($bal>$qty)
							{	
								for($jj=0;$jj<sizeof($ops);$jj++)
								{	
									if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
									{
										// $qty_tmp=echo_title("$bai_pro3.mo_operation_quantites","sum(bundle_quantity)","op_code='".$ops[$jj]."' and bundle_no",$row1234['tid'],$link);
										// if($qty_tmp=='' || $qty_tmp==0)
										// {
											// $qty_tmp=0;
										// }
										$qty_tmp=0;
										$qty=$qty-$qty_tmp;
										if($qty>0)
										{
											$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row1234['doc_no']."', '".$mo_no[$kk]."' , '".$row1234['tid']."', '".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."', '".$row1234['input_job_no']."', '".$row1234['input_job_no_random']."')";
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											//echo $sql."<br>";
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
										// $qty_tmp=echo_title("$bai_pro3.mo_operation_quantites","sum(bundle_quantity)","op_code='".$ops[$jj]."' and bundle_no",$row1234['tid'],$link);
										// if($qty_tmp=='' || $qty_tmp==0)
										// {
											// $qty_tmp=0;
										// }
										$qty_tmp=0;
										$qty=$qty-$qty_tmp;
										if($qty>0)
										{
											$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row1234['doc_no']."', '".$mo_no[$kk]."', '".$row1234['tid']."', '".$bal."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."', '".$row1234['input_job_no']."', '".$row1234['input_job_no_random']."')";
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											//echo $sql."<br>";
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
				$sql12341="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."' and type_of_sewing<>'1'";
				//echo $sql12341."<br>";	
				$result12341=mysqli_query($link, $sql12341) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if(mysqli_num_rows($result12341)>0)
				{
					while($row12341=mysqli_fetch_array($result12341)) 
					{
						$qty=$row12341['carton_act_qty'];
						//echo $qty."<br>";
						if($qty>0)
						{
							for($jjj=0;$jjj<sizeof($ops);$jjj++)
							{
								if($ops_m_id[$lastmo][$ops[$jjj]]<>'')
								{
									$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12341['doc_no']."', '".$lastmo."', '".$row12341['tid']."', '".$qty."', '".$ops_m_id[$lastmo][$ops[$jjj]]."', '".$ops_m_name[$lastmo][$ops[$jjj]]."', '".$row12341['input_job_no']."', '".$row12341['input_job_no_random']."')";
									$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									//echo "Excess---".$sql."<br>";
									
								}							
							}							
						}
						$qty=0;						
					}
				}
			}
			//die();			
			unset($mo_no);
			unset($moq);
			unset($ops_m_id);
			unset($ops_m_name);			
			unset($ops);
		}
		//die();
		unset($size_tit);
		unset($size_qty);
	}	
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");		
?> 
</div></div>
</body>