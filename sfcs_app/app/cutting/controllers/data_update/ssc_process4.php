<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
set_time_limit(6000000);

$sql3="truncate table $bai_pro3.order_plan";
mysqli_query($link, $sql3) or exit("Sql Errorc".mysqli_error($GLOBALS["___mysqli_ston"]));
							
$sql="insert into $bai_pro3.order_plan (schedule_no, mo_status, style_no, color, size_code, order_qty, compo_no, item_des, order_yy, col_des,material_sequence ) select SCHEDULE,MO_Released_Status_Y_N,Style,GMT_Color,GMT_Size,MO_Qty,Item_Code,Item_Description,Order_YY_WO_Wastage,RM_Color_Description,SEQ_NUMBER from $m3_inputs.order_details WHERE MO_Released_Status_Y_N='Y' AND CONCAT(Style,SCHEDULE,GMT_Color) NOT IN (SELECT order_tid FROM $bai_pro3.cat_stat_log)";
// echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error1d".mysqli_error($GLOBALS["___mysqli_ston"]));

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
			$sql22="select distinct compo_no from $bai_pro3.order_plan where schedule_no=\"$sch_no\" and color=\"$color\" and style_no=\"$style\"";
			$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row22=mysqli_fetch_array($sql_result22))
			{	
				$ssc_code2=$ssc_code.$sql_row22['compo_no'];
				$compo_no=$sql_row22['compo_no'];     
				
				$sql31="select MO_Released_Status_Y_N as mo_status,Item_Description as item_des,RM_Color_Description as col_des,round(sum(Required_Qty)/sum(MO_Qty),4) as order_yy from $m3_inputs.order_details where Style=\"$style\" and Schedule=\"$sch_no\" and GMT_Color=\"$color\" and Item_Code=\"$compo_no\"";
				// echo $sql31."<br>";
				$sql_result31=mysqli_query($link, $sql31) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row31=mysqli_fetch_array($sql_result31))
				{
					$mo_status=$sql_row31['mo_status'];
					$item_des=$sql_row31['item_des'];
					$order_yy=$sql_row31['order_yy'];
					$col_des=$sql_row31['col_des'];
				}
				
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
					
				$sql33="insert ignore into $bai_pro3.cat_stat_log (order_tid2) values (\"$ssc_code2\")";
				// echo $sql33."<br>";
				mysqli_query($link, $sql33) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$item_des=str_replace('"'," ",$item_des);
				$item_des=str_replace("'"," ",$item_des);
				
				$sql49="update $bai_pro3.cat_stat_log set order_tid=\"$ssc_code\", mo_status=\"$mo_status\", compo_no=\"$compo_no\", catyy=$order_yy, fab_des=\"$item_des\", col_des=\"$col_des\",".$transaction_time." where order_tid2=\"$ssc_code2\"";
				// echo $sql49."<br>";
				mysqli_query($link, $sql49) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
				
		}		
	}		
}

$sql39="delete from $bai_pro3.order_plan";
// echo $sql39."<br>";
mysqli_query($link, $sql39) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql40="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"CMS_OS_2\")";
mysqli_query($link, $sql40) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

echo "<div class='alert alert-info alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Successfully Updated.</strong></div>";

$rurl='ssc_color_coding.php';
// echo $rurl;
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = ".$rurl."; }</script>";
$url=getFullURL($_GET['r'],'ssc_color_coding.php','N');
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
?>