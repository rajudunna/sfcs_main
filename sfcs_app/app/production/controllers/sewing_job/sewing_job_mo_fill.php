<body> 
<div class="panel panel-primary">
<div class="panel-heading">Sewing Job Generation</div>
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
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	$not_condier=array(1,10,15,200);
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
					$ops_m_id[$row1210['mo_no']][]=$row1212['OperationNumber'];					
					$ops_m_name[$row1210['mo_no']][]=$row1212['OperationDescription'];
					$ops[]=$row1212['OperationNumber'];
					echo $row1210['mo_no']."---".$row1212['OperationNumber']."<br>";
				}
			}
			array_unique($ops);
			if(sizeof($mo_no)==1)
			{
				for($k=0;$k<sizeof($ops);$k++)
				{
					if($ops_m_id[$mo_no[0]][$k]<>'')
					{
						if(in_array($ops_m_id[$mo[0]][$k],$not_condier))
						{	
							$sql12="SELECT min(tid) as tid,doc_no,input_job_no,input_job_no_random,doc_no,sum(carton_act_qty) as qty FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."' group by doc_no,size_code";
							echo $sql12."<br>";						
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{
								$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$mo_no[0]."', '".$row12['qty']."','".$row12['tid']."', '".$ops_m_id[$mo_no[0]][$k]."', '".$ops_m_name[$mo_no[0]][$k]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
								//$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								echo $sql."<br>";							
							}
						}
						else
						{
							$sql1231="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."'"; 
							$result1231=mysqli_query($link, $sql1231) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row1231=mysqli_fetch_array($result1231)) 
							{
								$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row1231['doc_no']."', '".$mo_no[0]."', '".$row1231['carton_act_qty']."', '".$row1231['tid']."', '".$ops_m_id[$mo_no[0]][$k]."', '".$ops_m_name[$mo_no[0]][$k]."', '".$row1231['input_job_no']."', '".$row1231['input_job_no_random']."')";
								//$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								echo $sql."<br>";							
							}
						}
					}
				}
			}
			else
			{
				$bal=0;
				$sql1234="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit[$j]."' and order_del_no='".$schedule."' and order_col_des='".$col."' group by doc_no"; 
				$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row1234=mysqli_fetch_array($result1234)) 
				{
					$qty=$row1234['qty'];
					for($kk=0;$kk<sizeof($mo_no);$kk++)
					{	
						for($j=0;$j<sizeof($ops);$j++)
						{
							if($ops_m_id[$mo_no[$kk]][$ops[$j]]<>'')
							{
								$m_fil=echo_title("$bai_pro3.mo_operation_quantites","sum(bundle_quantity)","mo_no",$mo_no[$kk],$link);
								if($m_fil=='' || $m_fil==0)
								{
									$m_fil=0;
								}
								$bal=$moq[$kk]-$m_fil;
								if($bal>0)
								{	
									if($qty>0)
									{							
										if($bal>$qty)
										{
											$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$qty."', '".$mo_no[$kk]."','".$row12['tid']."', '".$ops_m_id[$mo_no[$kk]][0]."', '".$ops_m_name[$mo_no[$kk]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$qty=0;
										}
										else
										{
											$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$bal."', '".$mo_no[$kk]."','".$row12['tid']."', '".$ops_m_id[$mo_no[0]][0]."', '".$ops_m_name[$mo[0]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$qty=$qty-$bal;
											$bal=0;
										}
									}
								}
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
		unset($size_tit);
		unset($size_qty);
	}	
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	//echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");		
?> 
</div></div>
</body>