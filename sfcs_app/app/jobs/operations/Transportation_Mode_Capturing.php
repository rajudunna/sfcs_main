<?php 
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_app\common\config\config_jobs.php');

	$serverName="GD-SQL-UAT";
	$uid="SFCS_BIA_FF";
	$pwd="Ba@rUpr6";
	$BELMasterUAT="BELMasterUAT";
	$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>$BELMasterUAT);
?>

<?php
	$connect = odbc_connect("gd-sql-uat", "SFCS_BIA_FF", "Ba@rUpr6");

	$tsql="SELECT DeliveryMode FROM [BELMasterUAT].[m3].[PlannedPurchaseOrder] where len(DeliveryMode) > 0  group by DeliveryMode order by DeliveryMode";
	$result = odbc_exec($connect, $tsql);
	while(odbc_fetch_row($result))
	{	
		$Transport_Mode=odbc_result($result,1);	 
		$sql41="select * from $bai_pro3.transport_modes where transport_mode='".$Transport_Mode."'";
		$result41=mysqli_query($link, $sql41) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result41) == 0)
		{
			$sql1="insert $bai_pro3.transport_modes(transport_mode) values('".$Transport_Mode."')";
			mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}

?>
<?php
// ssc_porcess4

$sql3="truncate table $bai_pro3.order_plan";
$res1=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if($res1)
{
	print("Truncated order_plan table Successfully")."\n";
}
							
$sql="insert into $bai_pro3.order_plan (schedule_no, mo_status, style_no, color, size_code, order_qty, compo_no, item_des, order_yy, col_des,material_sequence ) select SCHEDULE,MO_Released_Status_Y_N,Style,GMT_Color,GMT_Size,MO_Qty,Item_Code,Item_Description,Order_YY_WO_Wastage,RM_Color_Description,SEQ_NUMBER from $m3_inputs.order_details WHERE MO_Released_Status_Y_N='Y'";
// echo $sql."<br>";
$res=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
if($res)
{
	print("Inserted into order_plan table Successfully")."\n";
}
	
// $sql="UPDATE order_plan SET color=CONCAT(CONVERT(stripSpeciaChars(size_code,0,0,1,0) USING utf8),'===',color) WHERE 
// CONCAT(size_code REGEXP '[[:alpha:]]+',size_code REGEXP '[[:digit:]]+')='11' AND (RIGHT(TRIM(BOTH FROM size_code),1) in ('0','1') OR CONCAT(size_code REGEXP '[[./.]]','NEW')='1NEW') AND CONCAT(color REGEXP '[***]','NEW')<>'1NEW' AND CONCAT(color REGEXP '[===]','NEW')<>'1NEW'";
// echo $sql."<br>";
// mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

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
	$new_style=str_pad($style,$style_total_length," ",STR_PAD_RIGHT);
	$style_len_new=strlen($new_style);
	$sql1="select distinct schedule_no from $bai_pro3.order_plan where style_no=\"$style\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$sch_no=$sql_row1['schedule_no'];
		
		$sql2="select distinct color from $bai_pro3.order_plan where schedule_no=\"$sch_no\" and style_no=\"$style\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$color=$sql_row2['color'];
			$color_len=strlen($color);
			$color_total_length=0;
			$new_color=str_pad($color,$color_total_length," ",STR_PAD_RIGHT);
			$color_len_new=strlen($new_color);

			$ssc_code=$new_style.$sch_no.$new_color;
			$sql22="select distinct compo_no,material_sequence from $bai_pro3.order_plan where color=\"$color\" and schedule_no=\"$sch_no\" and style_no=\"$style\"";
			//	echo $sql22;
			
			$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row22=mysqli_fetch_array($sql_result22))
			{	
				$ssc_code2=$ssc_code.$sql_row22['compo_no']."-".$sql_row22['material_sequence'];
				$compo_no=$sql_row22['compo_no'];	
				$material_sequence=$sql_row22['material_sequence'];
				
				$sql31="select mo_status,item_des,col_des,round((sum(order_yy*order_qty)/sum(order_qty)),4) as order_yy from $bai_pro3.order_plan where style_no=\"$style\" and schedule_no=\"$sch_no\" and color=\"$color\" and compo_no=\"$compo_no\" and material_sequence=\"$material_sequence\"";
				// echo $sql31."<br>";
				$sql_result31=mysqli_query($link, $sql31) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row31=mysqli_fetch_array($sql_result31))
				{
					$mo_status=$sql_row31['mo_status'];
					$item_des=$sql_row31['item_des'];
					$order_yy=$sql_row31['order_yy'];
					$col_des=$sql_row31['col_des'];
				}
					
				$sql3="insert ignore into $bai_pro3.cat_stat_log (order_tid2) values (\"$ssc_code2\")";
				// echo $sql3."<br>";
				mysqli_query($link, $sql3) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$item_des=str_replace('"'," ",$item_des);
				$item_des=str_replace("'"," ",$item_des);
				//echo $item_des;
				
				$sql3="update $bai_pro3.cat_stat_log set order_tid=\"$ssc_code\", mo_status=\"$mo_status\", compo_no=\"$compo_no\", catyy=$order_yy, fab_des=\"$item_des\", col_des=\"$col_des\" where order_tid2=\"$ssc_code2\"";
				// echo $sql3."<br>";
				mysqli_query($link, $sql3) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
				
		}		
	}		
}

$sql3="delete from $bai_pro3.order_plan";
mysqli_query($link, $sql3) or exit("Sql Error11".mysql_error());

$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"CMS_OS_2\")";
mysqli_query($link, $sql3) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

print("Successfully Updated")."\n";

?>


<?php
// ssc_color_coding
	$sql1="select distinct order_style_no from $bai_pro3.bai_orders_db where color_code=0";
	// echo $sql1."<br>";
	
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$style_no=$sql_row1['order_style_no'];

		$sql2="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and color_code=0";
		// echo $sql2."<br/>";
		
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sch_no=$sql_row2['order_del_no'];
			$sql32="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and order_del_no=\"$sch_no\" and color_code=0";
	
			// echo $sql32."<br/>";
			
			$sql_result32=mysqli_query($link, $sql32) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row32=mysqli_fetch_array($sql_result32))
			{
			
				$maxcolor=0;
				$sql3="select max(color_code) as maxcolor from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and order_del_no=\"$sch_no\"";
				//echo $sql3."<br/>";
				
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
				
	$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"COLOR1\")";
	$res=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res)
	{
		
		print("Data Integrated Successfully")."\n";
	}
			
	$sql33="select schedule,op_desc from $bai_pro3.bai_emb_db where mo_type=\"MO\"";
	$sql33="select MAX(emb_tid), schedule,op_desc FROM $bai_pro3.bai_emb_db WHERE mo_type='MO' GROUP BY schedule"; 

	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$schedule=$sql_row33['schedule'];
		$op_desc=$sql_row33['op_desc'];
		if(strpos($op_desc," GF"))
		{
			$sql3="update $bai_pro3.bai_orders_db set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
			$res=mysqli_query($link, $sql3) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($res)
			{
				print("Updated bai_orders_db table Successfully ")."\n";
			}
			
			$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
			$res=mysqli_query($link, $sql31) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($res)
			{
				print("Updated bai_orders_db_confirm table Successfully ")."\n";
			}
		}
		else
		{
			if(strpos($op_desc," PF"))
			{
				$sql3="update $bai_pro3.bai_orders_db set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				$res=mysqli_query($link, $sql3) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res)
				{
					print("Updated bai_orders_db table Successfully ")."\n";
				}
				
				$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				$res=mysqli_query($link, $sql31) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res)
				{
					print("Updated bai_orders_db_confirm table Successfully ")."\n";
				}
			}
			else
			{
				$sql3="update $bai_pro3.bai_orders_db set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				$res=mysqli_query($link, $sql3) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res)
				{
					print("Updated bai_orders_db table Successfully ")."\n";
				}
				
				$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				$res=mysqli_query($link, $sql31) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($res)
				{
					print("Updated bai_orders_db_confirm table Successfully ")."\n";
				}
			}
		}	
	}
	
	$myFile = "m3_process_ses_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=".(int)date("YmdH")."; ?>";
	fwrite($fh, $stringData);
	fclose($fh);
print( memory_get_usage())."\n";
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>



