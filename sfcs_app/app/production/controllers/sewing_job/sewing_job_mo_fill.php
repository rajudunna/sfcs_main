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
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link); 
	$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule_id,$link);
	$not_condier=array(1,10,15,200);
	$sql12="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
	$result121=mysqli_query($link, $sql12) or die ("Error1.1=".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row121=mysqli_fetch_array($result121))
	{
		$style_id=$row121['style_code'];
		$schedule_id=$row121['ref_order_num'];
		$col=$row121['order_col_des'];
		for($i=0;$i<sizeof($sizes_array);$i++)
		{
			if($row121["title_size_".$sizes_array[$i].""]<>'')
			{
				$size_qty[$i]=$row121["order_s_".$sizes_array[$i].""];
				$size_tit[$i]=$row121["title_size_".$sizes_array[$i].""];
			}
		}
		for($j=0;$j<sizeof($size_tit);$j++)
		{
			$sql121="SELECT * FROM $bai_pro3.mo_details WHERE size='".$size_tit[$j]."' and schedule='".$schedule."' and color='".$col."' order by MONumber*1"; 
			$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($row121=mysqli_fetch_array($result121)) 
			{
				$mo[]=$row121['mo_no'];
				$moq[]=$row121['mo_quantity'];
				$sql1212="SELECT * FROM $bai_pro3.schedule_oprations_master WHERE MONumber='".$row121['mo_no']."'"; 
				$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row1212=mysqli_fetch_array($result1212)) 
				{
					$ops_m_id[$row121['mo_no']][]=$row1212['OperationNumber'];					
					$ops_m_name[$row121['mo_no']][]=$row1212['OperationDescription'];					
				}	
			}
			if(sizeof($mo)==1)
			{
				for($k=0;$k<sizeof($ops_m_id);$k++)
				{
					if(in_array($ops_m_id[$k],$not_condier))
					{	
						$sql12="SELECT *,input_job_no,input_job_random,doc_no,sum(carton_act_qty) as qty FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit."' and order_del_no='".$schedule."' and order_col_des='".$col."' group by doc_no"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{
							$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$row12['qty']."', '".$mo[0]."','".$row12['tid']."', '".$ops_m_id[$mo[0]][0]."', '".$ops_m_name[$mo[0]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
							$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));					
						}
					}
					else
					{
						$sql12="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit."' and order_del_no='".$schedule."' and order_col_des='".$col."'"; 
						$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						while($row12=mysqli_fetch_array($result12)) 
						{
							$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$row12['carton_act_qty']."', '".$mo[0]."','".$row12['tid']."', '".$ops_m_id[$mo[0]][0]."', '".$ops_m_name[$mo[0]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
							$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));					
						}
					}	
				}
			}
			else
			{
				$sql12="SELECT *,input_job_no,input_job_random,doc_no,sum(carton_act_qty) as qty FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit."' and order_del_no='".$schedule."' and order_col_des='".$col."' group by doc_no"; 
				$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($row12=mysqli_fetch_array($result12)) 
				{
					for($kk=0;$kk<sizeof($mo);$kk++)
					{	
						if($moq[$kk]>$row12['qty'])
						{
							$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$row12['qty']."', '".$mo[0]."','".$row12['tid']."', '".$ops_m_id[$mo[0]][0]."', '".$ops_m_name[$mo[0]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
							$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}	
				}				
				for($kk=0;$kk<sizeof($mo);$kk++)
				{
					for($k=0;$k<sizeof($ops_m_id);$k++)
					{
						if(in_array($ops_m_id[$k],$not_condier))
						{	
							$sql12="SELECT *,input_job_no,input_job_random,doc_no,sum(carton_act_qty) as qty FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit."' and order_del_no='".$schedule."' and order_col_des='".$col."' group by doc_no"; 
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{
								
								$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$row12['qty']."', '".$mo[0]."','".$row12['tid']."', '".$ops_m_id[$mo[0]][0]."', '".$ops_m_name[$mo[0]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
								$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));					
							}
						}
						else
						{
							$sql12="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='".$size_tit."' and order_del_no='".$schedule."' and order_col_des='".$col."'"; 
							$result12=mysqli_query($link, $sql12) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row12=mysqli_fetch_array($result12)) 
							{
								$sql="INSERT INTO `bai_pro3`.`mo_operation_quantites` (`date_time`, `doc_no`, `mo_no`, `bundle_no`, `bundle_quantity`, `op_code`, `op_desc`, `input_job_no`, `input_job_random`) VALUES ('".date("Y-m-d H:i:s")."', '".$row12['doc_no']."', '".$row12['carton_act_qty']."', '".$mo[0]."','".$row12['tid']."', '".$ops_m_id[$mo[0]][0]."', '".$ops_m_name[$mo[0]][0]."', '".$row12['input_job_no']."', '".$row12['input_job_no_random']."')";
								$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));					
							}
						}	
					}
				}
			}
			unset($mo);
			unset($moq);
			unset($ops_m_id);
			unset($ops_m_name);			
		}
		unset($size_tit);
		unset($size_qty);
	}
	
	echo "<script>sweetAlert('Data Saved Successfully','','success')</script>";
	echo("<script>location.href = '".getFullURLLevel($_GET['r'],'sewing_job_create_original.php',0,'N')."&style=$style_id&schedule=$schedule_id';</script>");		
?> 
</div></div>
</body>