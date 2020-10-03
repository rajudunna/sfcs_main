<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
set_time_limit(6000000);
/*$insert_order_details="INSERT INTO $m3_inputs.order_details SELECT * FROM $m3_inputs.order_details_original WHERE (CONCAT(TRIM(Style),TRIM(SCHEDULE),TRIM(GMT_Color)) NOT IN (SELECT CONCAT(TRIM(Style),TRIM(SCHEDULE),TRIM(GMT_Color)) FROM $m3_inputs.order_details) AND MO_Released_Status_Y_N='Y') ORDER BY TRIM(Style),TRIM(SCHEDULE),TRIM(GMT_Color)";
$res=mysqli_query($link, $insert_order_details) or exit("Sql Errorb".mysqli_error($GLOBALS["___mysqli_ston"]));
echo $insert_order_details."<br><br>";
if($res)
{
	print("Data Inserted into order_details from order_details_original ")."\n";
}
*/


$sql3="truncate table $bai_pro3.order_plan";
mysqli_query($link, $sql3) or exit("Sql Errorc".mysqli_error($GLOBALS["___mysqli_ston"]));

/*$sql="insert into $bai_pro3.order_plan (schedule_no, mo_status, style_no, color, size_code, order_qty, compo_no, item_des, order_yy, col_des,material_sequence ) select SCHEDULE,MO_Released_Status_Y_N,Style,GMT_Color,GMT_Size,MO_Qty,Item_Code,Item_Description,Order_YY_WO_Wastage,RM_Color_Description,SEQ_NUMBER from $m3_inputs.order_details WHERE MO_Released_Status_Y_N='Y' AND CONCAT(Style,SCHEDULE,GMT_Color) NOT IN (SELECT order_tid FROM bai_pro3.cat_stat_log)";
echo $sql."<br><br>";
mysqli_query($link, $sql) or exit("Sql Error1d".mysqli_error($GLOBALS["___mysqli_ston"]));
*/

$sql_orders="SELECT style,SCHEDULE,GMT_Color,CONCAT(Style,SCHEDULE,GMT_Color)as order_tids FROM `m3_inputs`.`order_details` WHERE status=0 GROUP BY style,SCHEDULE,GMT_Color";
$sql_orders_result=mysqli_query($link, $sql_orders) or exit("Sql Error44".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_orders=mysqli_fetch_array($sql_orders_result))
{ 
	
	$style_new=$sql_row_orders['style'];
	$schedule_new=$sql_row_orders['SCHEDULE'];
	$color_new=$sql_row_orders['GMT_Color'];
	$order_tid_new=$sql_row_orders['order_tids'];
	$sql_cat="SELECT * FROM $bai_pro3.`cat_stat_log` WHERE order_tid='$order_tid_new'";
    $sql_cat_result=mysqli_query($link, $sql_cat) or exit("Sql Error55".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_cat_result)==0)
	{
		$sql_order_plan="insert into $bai_pro3.order_plan (schedule_no, mo_status, style_no, color, size_code, order_qty, compo_no, item_des, order_yy, col_des,material_sequence ) select SCHEDULE,MO_Released_Status_Y_N,Style,GMT_Color,GMT_Size,MO_Qty,Item_Code,Item_Description,Order_YY_WO_Wastage,RM_Color_Description,SEQ_NUMBER from $m3_inputs.order_details WHERE style='$style_new' and schedule='$schedule_new' and GMT_Color='$color_new' ";
		$sql_cat_result=mysqli_query($link, $sql_order_plan) or exit("Sql Error66".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}

$item_des="";
$col_des="";
$sql="select distinct style_no from $bai_pro3.order_plan";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['style_no'];
	$style_len=strlen($style);
	//KiranG 2017125  //15
	$style_total_length=0;
	$mo_qty=array();
	$Required_Qty=array();
	$new_style=str_pad($style,$style_total_length," ",STR_PAD_RIGHT);
	$style_len_new=strlen($new_style);
	$sql1="select distinct schedule_no from $bai_pro3.order_plan where style_no='".$style."'";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$sch_no=$sql_row1['schedule_no'];
		
		$sql2="select distinct color from $bai_pro3.order_plan where schedule_no='".$sch_no."' and style_no='".$style."'";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$color=$sql_row2['color'];
			$color_len=strlen($color);
			$color_total_length=0;
			$new_color=str_pad($color,$color_total_length," ",STR_PAD_RIGHT);
			$color_len_new=strlen($new_color);

			$ssc_code=$new_style.$sch_no.$new_color;
			$sql22="select distinct compo_no from $bai_pro3.order_plan where schedule_no='".$sch_no."' and color='".$color."' and style_no='".$style."'";
			$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row22=mysqli_fetch_array($sql_result22))
			{	
				$ssc_code2=$ssc_code.$sql_row22['compo_no'];
				$compo_no=$sql_row22['compo_no'];					
				
				$sql31="select MO_Released_Status_Y_N as mo_status,Item_Description as item_des,RM_Color_Description as col_des from $m3_inputs.order_details where Style='".$style."' and Schedule='".$sch_no."' and GMT_Color='".$color."' and Item_Code='".$compo_no."'";
				// echo $sql31."<br>";
				$sql_result31=mysqli_query($link, $sql31) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row31=mysqli_fetch_array($sql_result31))
				{
					$mo_status=$sql_row31['mo_status'];
					$item_des=$sql_row31['item_des'];
				//	$order_yy=$sql_row31['order_yy'];
					$col_des=$sql_row31['col_des'];
				}
				$order_yy=0;
				$sql312="select MO_NUMBER,MO_Qty,Required_Qty from $m3_inputs.order_details where Style='".$style."' and Schedule='".$sch_no."' and GMT_Color='".$color."' and Item_Code='".$compo_no."'";
				// echo $sql31."<br>";
				$sql_result312=mysqli_query($link, $sql312) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row312=mysqli_fetch_array($sql_result312))
				{
					$mo_qty[$sql_row312['MO_NUMBER']]=$sql_row312['MO_Qty'];
					$Required_Qty[]=$sql_row312['Required_Qty'];
				}
				$order_yy=round(array_sum($Required_Qty)/array_sum($mo_qty),4);
				
				$sql_check="select * from $bai_pro3.cat_stat_log where order_tid2=\"$ssc_code2\"";
				$result_check=mysqli_query($link,$sql_check) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result_check) ==0)
				{
					$transaction_time="inserted_time=\"".date("Y-m-d H:i:s")."\"";
				}
				else
				{
					$transaction_time="updated_time=\"".date("Y-m-d H:i:s")."\"";
				}
					
				$sql3="insert ignore into $bai_pro3.cat_stat_log (order_tid2) values (\"$ssc_code2\")";
				echo $sql3."<br></br>";
				mysqli_query($link, $sql3) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				$inserted_cat_stat_log=mysqli_affected_rows($link);

				$item_des=str_replace('"'," ",$item_des);
				$item_des=str_replace("'"," ",$item_des);
				
				$sql3="update $bai_pro3.cat_stat_log set order_tid=\"$ssc_code\", mo_status=\"$mo_status\", compo_no=\"$compo_no\", catyy=$order_yy, fab_des=\"$item_des\", col_des=\"$col_des\",".$transaction_time." where order_tid2='".$ssc_code2."'";
				echo $sql3."<br></br>";
				mysqli_query($link, $sql3) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				if($inserted_cat_stat_log > 0)
				{
					$order_det_update="update $m3_inputs.order_details set status = 1 where Style='".$style."' and Schedule='".$sch_no."' and GMT_Color='".$color."'";
					echo $order_det_update."<br></br>";
					mysqli_query($link, $order_det_update) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				unset($mo_qty);
				unset($Required_Qty);	

				$vpo='';
				$customer_style='';
				$vpo_query="select VPO_NO,Customer_Style_No from $m3_inputs.order_details where GMT_Color=\"$color\" and Schedule=\"$sch_no\" and Style=\"$style\"";
				echo $vpo_query."<br>";
				$vpo_result=mysqli_query($link, $vpo_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($vpo_result))
				{		
					$vpo=$sql_row3['VPO_NO'];
					$customer_style=$sql_row3['Customer_Style_No'];
				}
				if($vpo!='')
				{
				
					$sql31="update $bai_pro3.bai_orders_db set vpo=\"$vpo\",customer_style_no=\"$customer_style\" where order_style_no=\"$style\" and order_del_no=\"$sch_no\" and order_col_des =\"$color\" ";//vpo updating#2635
					echo $sql31."<br><br>";
					mysqli_query($link, $sql31) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}		
		}		
	}		
 }
	
    $sql1="select distinct order_style_no from $bai_pro3.bai_orders_db where color_code=0";
    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$style_no=$sql_row1['order_style_no'];

		$sql2="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and color_code=0";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sch_no=$sql_row2['order_del_no'];
			$sql32="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and order_del_no=\"$sch_no\" and color_code=0";
			$sql_result32=mysqli_query($link, $sql32) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row32=mysqli_fetch_array($sql_result32))
			{
			
				$maxcolor=0;
				$sql3="select max(color_code) as maxcolor from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and order_del_no=\"$sch_no\"";
	
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$maxcolor=$sql_row3['maxcolor'];
				}
				
				if($maxcolor>0)
				{
					$startcolor=$maxcolor+1;	
				}
				else
				{
					$startcolor=65;
				}
				
				$order_tid=$sql_row32['order_tid'];
				//echo $order_tid;
				$sql33="update $bai_pro3.bai_orders_db set color_code=$startcolor where order_tid=\"$order_tid\"";
				// echo $sql33."<br/>";
				mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$startcolor=$startcolor+1;
			}	
		}				
	}
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");
	
?>


	