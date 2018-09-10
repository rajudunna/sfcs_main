<?php
$start_timestamp = microtime(true);
include("m3_process_ses_track.php");
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
error_reporting(0);
$time_diff=(int)date("YmdH")-$log_time;

set_time_limit(6000000);

function check_style($string)
{
	global $link;
	global $bai_pro2;
	$check=0;
	for ($index=0;$index<strlen($string);$index++) {
    	if(isNumber($string[$index]))
		{
			$nums = $string[$index];
		}
     	else    
		{
			$chars = $string[$index];
			$check=$check+1;
			if($check==2)
			{
				break;
			}
		} 			
	}

	$sql3="select style_id from $bai_pro2.movex_styles where movex_style=\"$string\"";
	$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		$style_id_new=$sql_row3['style_id'];
	}
	
	if(strlen($style_id_new)>0)
	{
		return $style_id_new;
	}
	else
	{
		return $nums;
	}	
}

function isNumber($c) 
{
    return preg_match('/[0-9]/', $c);
}
?> 


<?php
$sql39="truncate $bai_pro3.shipment_plan";
	mysqli_query($link, $sql39) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$sql3="select style,schedule,GMT_Color from  $m3_inputs.order_details where MO_Released_Status_Y_N='Y'";
	$result=mysqli_query($link, $sql3) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
// echo $sql3."<br>";
	while($sql_row44=mysqli_fetch_array($result))
	{
		$style=$sql_row44['style'];
		$style_total_length=0;
		$new_style=str_pad($style,$style_total_length," ",STR_PAD_RIGHT);
		$sch_no=$sql_row44['schedule'];
		$color=$sql_row44['GMT_Color'];
		$color_len=strlen($color);
		$color_total_length=0;
		$new_color=str_pad($color,$color_total_length," ",STR_PAD_RIGHT);
		$color_len_new=strlen($new_color);
		$ssc_code=$new_style.$sch_no.$new_color;
	
		$sql23="insert into $bai_pro3.shipment_plan (style_no, schedule_no, color, order_qty, exfact_date, cpo, buyer_div, size_code,packing_method,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination) select TRIM(BOTH FROM Style_No), TRIM(BOTH FROM Schedule_No), TRIM(BOTH FROM Colour), Order_Qty, Ex_Factory, Customer_Order_No, Buyer_Division, Size, Packing_Method,EMB_A,EMB_B,EMB_C,EMB_D,EMB_E,EMB_F,EMB_G,EMB_H,Destination from $m3_inputs.shipment_plan where style_no=\"".$sql_row44['style']."\" and Schedule_No=\"".$sql_row44['schedule']."\" and colour=\"".$sql_row44['GMT_Color']."\"  and TRIM(BOTH FROM Schedule_No) not in (select distinct order_del_no from $bai_pro3.bai_orders_db_confirm)";
		$result23=mysqli_query($link, $sql23) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}
	
				
	// $sql3="truncate $bai_pro3.shipment_plan";
	// mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// $sql3="insert into $bai_pro3.shipment_plan (style_no, schedule_no, color, order_qty, exfact_date, cpo, buyer_div, size_code,packing_method,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination) 
	// select TRIM(BOTH FROM Style_No), TRIM(BOTH FROM Schedule_No), TRIM(BOTH FROM Colour), Order_Qty, Ex_Factory, Customer_Order_No, Buyer_Division, Size, Packing_Method,EMB_A,EMB_B,EMB_C,EMB_D,EMB_E,EMB_F,EMB_G,EMB_H,Destination from $m3_inputs.shipment_plan where TRIM(BOTH FROM Schedule_No) not in (select distinct order_del_no from $bai_pro3.bai_orders_db_confirm)";
	// // echo $sql3."<br>";
	// $res=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// if($res)
	// {
	// 	print("M3 to SFCS Sync Successfully Completed")."\n";
	// }

	$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"CMS_SP_1\")";
	$res1=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res1)
	{
		print("Please wait for furthur process")."\n";
	}

	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"ssc_plan_process.php\"; }</script>";
?>
<?php
	$username="ber_databasesvc";
	$username_val="orderdetail_plan_".$username.date("YmdHis");
	$sql="CREATE TEMPORARY TABLE temp_pool_db.$username_val ENGINE=MyISAM select DISTINCT MO_NUMBER,TRIM(BOTH FROM Style) as Style,TRIM(BOTH FROM SCHEDULE) as SCHEDULE,TRIM(BOTH FROM GMT_Color) as GMT_Color,GMT_Size,MO_Qty FROM $m3_inputs.order_details WHERE MO_Released_Status_Y_N='Y'";
	// echo $sql."<br>";
	$res=mysqli_query($link, $sql) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res)
	{
		echo "temperory table created";
	}
			
	$size=array("s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50"); 
	
	// $sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_tid like '%***%'";
	// $resultset=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select distinct style_no from $bai_pro3.shipment_plan";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=str_pad($sql_row['style_no'],"15"," ");
		
		$sql1="select distinct schedule_no from $bai_pro3.shipment_plan where style_no=\"$style\" ";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$sch_no=$sql_row1['schedule_no'];
			
			$sql2="select distinct color from $bai_pro3.shipment_plan where schedule_no=\"$sch_no\" and style_no=\"$style\"";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$color=str_pad($sql_row2['color'],"30"," ");
				$ssc_code=$style.$sch_no.$color;
				// echo $ssc_code."<br>";
				$style_id=check_style($style);
				// echo "<br><br>".$style." Len=".strlen($style_id)."<br><br>";
				if(strlen($style_id)==0)
				{
					$style_id=$style;
				}
				$sql44="select buyer_code FROM $bai_pro2.buyer_codes WHERE buyer_name in (SELECT DISTINCT order_div FROM bai_pro3.bai_orders_db WHERE order_style_no='$style' )";
			
				$result44=mysqli_query($link, $sql44) or exit("error1245".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row44=mysqli_fetch_array($result44))
				{
					$buyer_id_new=$sql_row44['buyer_code'];
				}
				
				$sql22="insert ignore into $bai_pro2.movex_styles (movex_style, style_id,buyer_id) values (\"".$style."\", \"".$style_id."\",\"".$buyer_id_new."\")";
				mysqli_query($link, $sql22) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$size_ref=0;	
				$flag=0;
				$sql13="select order_tid from $bai_pro3.bai_orders_db where order_tid=\"".$ssc_code."\" and title_flag=0";
				$result11=mysqli_query($link, $sql13) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($result11);
				if($sql_num_check==0)
				{
					$flag=1;
				}
				
				// end need to assign the flag value for new order_tids based the number of rows validation (for dynamic size enhancement) 
				$old_order_qty_xs=0;
				$old_order_qty_s=0;
				$old_order_qty_m=0;
				$old_order_qty_l=0;
				$old_order_qty_xl=0;
				$old_order_qty_xxl=0;
				$old_order_qty_xxxl=0;
				$old_order_qty_s01=0;
				$old_order_qty_s02=0;
				$old_order_qty_s03=0;
				$old_order_qty_s04=0;
				$old_order_qty_s05=0;
				$old_order_qty_s06=0;
				$old_order_qty_s07=0;
				$old_order_qty_s08=0;
				$old_order_qty_s09=0;
				$old_order_qty_s10=0;
				$old_order_qty_s11=0;
				$old_order_qty_s12=0;
				$old_order_qty_s13=0;
				$old_order_qty_s14=0;
				$old_order_qty_s15=0;
				$old_order_qty_s16=0;
				$old_order_qty_s17=0;
				$old_order_qty_s18=0;
				$old_order_qty_s19=0;
				$old_order_qty_s20=0;
				$old_order_qty_s21=0;
				$old_order_qty_s22=0;
				$old_order_qty_s23=0;
				$old_order_qty_s24=0;
				$old_order_qty_s25=0;
				$old_order_qty_s26=0;
				$old_order_qty_s27=0;
				$old_order_qty_s28=0;
				$old_order_qty_s29=0;
				$old_order_qty_s30=0;
				$old_order_qty_s31=0;
				$old_order_qty_s32=0;
				$old_order_qty_s33=0;
				$old_order_qty_s34=0;
				$old_order_qty_s35=0;
				$old_order_qty_s36=0;
				$old_order_qty_s37=0;
				$old_order_qty_s38=0;
				$old_order_qty_s39=0;
				$old_order_qty_s40=0;
				$old_order_qty_s41=0;
				$old_order_qty_s42=0;
				$old_order_qty_s43=0;
				$old_order_qty_s44=0;
				$old_order_qty_s45=0;
				$old_order_qty_s46=0;
				$old_order_qty_s47=0;
				$old_order_qty_s48=0;
				$old_order_qty_s49=0;
				$old_order_qty_s50=0;
				
				$sql3="select * from $bai_pro3.bai_orders_db where order_tid=\"$ssc_code\"";
				$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row3=mysqli_fetch_array($sql_result3))
				{
					$old_order_qty_xs=$sql_row3['order_s_xs'];
					$old_order_qty_s=$sql_row3['order_s_s'];
					$old_order_qty_m=$sql_row3['order_s_m'];
					$old_order_qty_l=$sql_row3['order_s_l'];
					$old_order_qty_xl=$sql_row3['order_s_xl'];
					$old_order_qty_xxl=$sql_row3['order_s_xxl'];
					$old_order_qty_xxxl=$sql_row3['order_s_xxxl'];
					$old_order_qty_s01=$sql_row3['order_s_s01'];
					$old_order_qty_s02=$sql_row3['order_s_s02'];
					$old_order_qty_s03=$sql_row3['order_s_s03'];
					$old_order_qty_s04=$sql_row3['order_s_s04'];
					$old_order_qty_s05=$sql_row3['order_s_s05'];
					$old_order_qty_s06=$sql_row3['order_s_s06'];
					$old_order_qty_s07=$sql_row3['order_s_s07'];
					$old_order_qty_s08=$sql_row3['order_s_s08'];
					$old_order_qty_s09=$sql_row3['order_s_s09'];
					$old_order_qty_s10=$sql_row3['order_s_s10'];
					$old_order_qty_s11=$sql_row3['order_s_s11'];
					$old_order_qty_s12=$sql_row3['order_s_s12'];
					$old_order_qty_s13=$sql_row3['order_s_s13'];
					$old_order_qty_s14=$sql_row3['order_s_s14'];
					$old_order_qty_s15=$sql_row3['order_s_s15'];
					$old_order_qty_s16=$sql_row3['order_s_s16'];
					$old_order_qty_s17=$sql_row3['order_s_s17'];
					$old_order_qty_s18=$sql_row3['order_s_s18'];
					$old_order_qty_s19=$sql_row3['order_s_s19'];
					$old_order_qty_s20=$sql_row3['order_s_s20'];
					$old_order_qty_s21=$sql_row3['order_s_s21'];
					$old_order_qty_s22=$sql_row3['order_s_s22'];
					$old_order_qty_s23=$sql_row3['order_s_s23'];
					$old_order_qty_s24=$sql_row3['order_s_s24'];
					$old_order_qty_s25=$sql_row3['order_s_s25'];
					$old_order_qty_s26=$sql_row3['order_s_s26'];
					$old_order_qty_s27=$sql_row3['order_s_s27'];
					$old_order_qty_s28=$sql_row3['order_s_s28'];
					$old_order_qty_s29=$sql_row3['order_s_s29'];
					$old_order_qty_s30=$sql_row3['order_s_s30'];
					$old_order_qty_s31=$sql_row3['order_s_s31'];
					$old_order_qty_s32=$sql_row3['order_s_s32'];
					$old_order_qty_s33=$sql_row3['order_s_s33'];
					$old_order_qty_s34=$sql_row3['order_s_s34'];
					$old_order_qty_s35=$sql_row3['order_s_s35'];
					$old_order_qty_s36=$sql_row3['order_s_s36'];
					$old_order_qty_s37=$sql_row3['order_s_s37'];
					$old_order_qty_s38=$sql_row3['order_s_s38'];
					$old_order_qty_s39=$sql_row3['order_s_s39'];
					$old_order_qty_s40=$sql_row3['order_s_s40'];
					$old_order_qty_s41=$sql_row3['order_s_s41'];
					$old_order_qty_s42=$sql_row3['order_s_s42'];
					$old_order_qty_s43=$sql_row3['order_s_s43'];
					$old_order_qty_s44=$sql_row3['order_s_s44'];
					$old_order_qty_s45=$sql_row3['order_s_s45'];
					$old_order_qty_s46=$sql_row3['order_s_s46'];
					$old_order_qty_s47=$sql_row3['order_s_s47'];
					$old_order_qty_s48=$sql_row3['order_s_s48'];
					$old_order_qty_s49=$sql_row3['order_s_s49'];
					$old_order_qty_s50=$sql_row3['order_s_s50'];					
				}
							
				$sql3="update $bai_pro3.bai_orders_db set old_order_s_xs=$old_order_qty_xs,  old_order_s_s=$old_order_qty_s, old_order_s_m=$old_order_qty_m, old_order_s_l=$old_order_qty_l, old_order_s_xl=$old_order_qty_xl, old_order_s_xxl=$old_order_qty_xxl, old_order_s_xxxl=$old_order_qty_xxxl, old_order_s_s01=$old_order_qty_s01, old_order_s_s02=$old_order_qty_s02, old_order_s_s03=$old_order_qty_s03, old_order_s_s04=$old_order_qty_s04, old_order_s_s05=$old_order_qty_s05, old_order_s_s06=$old_order_qty_s06, old_order_s_s07=$old_order_qty_s07, old_order_s_s08=$old_order_qty_s08, old_order_s_s09=$old_order_qty_s09, old_order_s_s10=$old_order_qty_s10, old_order_s_s11=$old_order_qty_s11, old_order_s_s12=$old_order_qty_s12, old_order_s_s13=$old_order_qty_s13, old_order_s_s14=$old_order_qty_s14, old_order_s_s15=$old_order_qty_s15, old_order_s_s16=$old_order_qty_s16, old_order_s_s17=$old_order_qty_s17, old_order_s_s18=$old_order_qty_s18, old_order_s_s19=$old_order_qty_s19, old_order_s_s20=$old_order_qty_s20, old_order_s_s21=$old_order_qty_s21, old_order_s_s22=$old_order_qty_s22, old_order_s_s23=$old_order_qty_s23, old_order_s_s24=$old_order_qty_s24, old_order_s_s25=$old_order_qty_s25, old_order_s_s26=$old_order_qty_s26, old_order_s_s27=$old_order_qty_s27, old_order_s_s28=$old_order_qty_s28, old_order_s_s29=$old_order_qty_s29, old_order_s_s30=$old_order_qty_s30, old_order_s_s31=$old_order_qty_s31, old_order_s_s32=$old_order_qty_s32, old_order_s_s33=$old_order_qty_s33, old_order_s_s34=$old_order_qty_s34, old_order_s_s35=$old_order_qty_s35, old_order_s_s36=$old_order_qty_s36, old_order_s_s37=$old_order_qty_s37, old_order_s_s38=$old_order_qty_s38, old_order_s_s39=$old_order_qty_s39, old_order_s_s40=$old_order_qty_s40, old_order_s_s41=$old_order_qty_s41, old_order_s_s42=$old_order_qty_s42, old_order_s_s43=$old_order_qty_s43, old_order_s_s44=$old_order_qty_s44, old_order_s_s45=$old_order_qty_s45, old_order_s_s46=$old_order_qty_s46, old_order_s_s47=$old_order_qty_s47, old_order_s_s48=$old_order_qty_s48, old_order_s_s49=$old_order_qty_s49, old_order_s_s50=$old_order_qty_s50  where order_tid=\"$ssc_code\"";
				mysqli_query($link, $sql3) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
							
				$sql3="update $bai_pro3.bai_orders_db set order_s_xs=0, order_s_s=0, order_s_m=0, order_s_l=0, order_s_xl=0, order_s_xxl=0, order_s_xxxl=0, order_s_s01=0, order_s_s02=0, order_s_s03=0, order_s_s04=0, order_s_s05=0, order_s_s06=0, order_s_s07=0, order_s_s08=0, order_s_s09=0, order_s_s10=0, order_s_s11=0, order_s_s12=0, order_s_s13=0, order_s_s14=0, order_s_s15=0, order_s_s16=0, order_s_s17=0, order_s_s18=0, order_s_s19=0, order_s_s20=0, order_s_s21=0, order_s_s22=0, order_s_s23=0, order_s_s24=0, order_s_s25=0, order_s_s26=0, order_s_s27=0, order_s_s28=0, order_s_s29=0, order_s_s30=0, order_s_s31=0, order_s_s32=0, order_s_s33=0, order_s_s34=0, order_s_s35=0, order_s_s36=0, order_s_s37=0, order_s_s38=0, order_s_s39=0, order_s_s40=0, order_s_s41=0, order_s_s42=0, order_s_s43=0, order_s_s44=0, order_s_s45=0, order_s_s46=0, order_s_s47=0, order_s_s48=0, order_s_s49=0, order_s_s50=0, title_size_s01=\"\", title_size_s02=\"\",title_size_s03=\"\",title_size_s04=\"\",title_size_s05=\"\",title_size_s06=\"\",title_size_s07=\"\",title_size_s08=\"\",title_size_s09=\"\",title_size_s10=\"\",title_size_s11=\"\",title_size_s12=\"\",title_size_s13=\"\",title_size_s14=\"\",title_size_s15=\"\",title_size_s16=\"\",title_size_s17=\"\",title_size_s18=\"\",title_size_s19=\"\",title_size_s20=\"\",title_size_s21=\"\",title_size_s22=\"\",title_size_s23=\"\",title_size_s24=\"\",title_size_s25=\"\",title_size_s26=\"\",title_size_s27=\"\",title_size_s28=\"\",title_size_s29=\"\",title_size_s30=\"\",title_size_s31=\"\",title_size_s32=\"\",title_size_s33=\"\",title_size_s34=\"\",title_size_s35=\"\",title_size_s36=\"\",title_size_s37=\"\",title_size_s38=\"\",title_size_s39=\"\",title_size_s40=\"\",title_size_s41=\"\",title_size_s42=\"\",title_size_s43=\"\",title_size_s44=\"\",title_size_s45=\"\",title_size_s46=\"\",title_size_s47=\"\",title_size_s48=\"\",title_size_s49=\"\",title_size_s50=\"\" where order_tid=\"$ssc_code\"";
				mysqli_query($link, $sql3) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));				
							
				$sql22="select distinct size_code from $bai_pro3.shipment_plan where color=\"$color\" and schedule_no=\"$sch_no\" and style_no=\"$style\" ORDER BY CONVERT(bai_pro3.stripSpeciaChars(size_code,0,1,0,0) USING utf8)*1,FIELD(size_code,'xs','s','m','l','xl','xxl','xxxl')";
				$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row22=mysqli_fetch_array($sql_result22))
				{
					$size_code=$sql_row22['size_code'];
					$order_qty=0;
					
					$sql3="select coalesce(sum(order_qty),0) as \"order_qty\", exfact_date, cpo, buyer_div, packing_method, destination, zfeature, style_id, COALESCE(order_embl_a,0) as order_embl_a,COALESCE(order_embl_b,0) as order_embl_b,COALESCE(order_embl_c,0) as order_embl_c,COALESCE(order_embl_d,0) as order_embl_d,COALESCE(order_embl_e,0) as order_embl_e,COALESCE(order_embl_f,0) as order_embl_f,COALESCE(order_embl_g,0) as order_embl_g,COALESCE(order_embl_h,0) as order_embl_h from $bai_pro3.shipment_plan where style_no=\"".trim($style)."\" and schedule_no=\"".$sch_no."\" and color=\"".trim($color)."\" and size_code=\"$size_code\"";
					
					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row3=mysqli_fetch_array($sql_result3))
					{		
						$exfact_date=$sql_row3['exfact_date'];
						$cpo=$sql_row3['cpo'];
						$buyer_div=$sql_row3['buyer_div'];
						$packing_method=$sql_row3['packing_method'];
						$zfeature=$sql_row3['zfeature'];
						$destination=$sql_row3['destination'];
						$order_qty=$sql_row3['order_qty'];
						
						$order_embl_a=$sql_row3['order_embl_a'];
						$order_embl_b=$sql_row3['order_embl_b'];
						$order_embl_c=$sql_row3['order_embl_c'];
						$order_embl_d=$sql_row3['order_embl_d'];
						$order_embl_e=$sql_row3['order_embl_e'];
						$order_embl_f=$sql_row3['order_embl_f'];
						$order_embl_g=$sql_row3['order_embl_g'];
						$order_embl_h=$sql_row3['order_embl_h'];

					}
					// echo $ssc_code."-".$order_qty."<br>";	
					// if($order_qty>=0)
					{
						$sql3="insert ignore into $bai_pro3.bai_orders_db (order_tid) values (\"$ssc_code\")";

						mysqli_query($link, $sql3) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql3="update $bai_pro3.bai_orders_db set order_embl_a=$order_embl_a,order_embl_b=$order_embl_b,order_embl_c=$order_embl_c,order_embl_d=$order_embl_d,order_embl_e=$order_embl_e,order_embl_f=$order_embl_f,order_embl_g=$order_embl_g,order_embl_h=$order_embl_h where order_tid=\"$ssc_code\" and (order_embl_a+order_embl_b+order_embl_c+order_embl_d+order_embl_e+order_embl_f+order_embl_g+order_embl_h)=0";
						mysqli_query($link, $sql3) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
						if($flag==1)
						{	
							$vpo='';
							$vpo_query="select VPO_NO from $m3_inputs.order_details where GMT_Color=\"$color\" and Schedule=\"$sch_no\" and Style=\"$style\"";
							// echo $vpo_no."<br>";
							$vpo_result=mysqli_query($link, $vpo_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row3=mysqli_fetch_array($vpo_result))
							{		
								$vpo=$sql_row3['VPO_NO'];
							}
							$sql31="update $bai_pro3.bai_orders_db set vpo=\"$vpo\", packing_method=\"$packing_method\",destination=\"$destination\", zfeature=\"$zfeature\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_".$size[$size_ref]."=$order_qty,title_size_".$size[$size_ref]."=\"".trim($size_code)."\",order_date=\"$exfact_date\",title_flag=\"$flag\", order_po_no=\"$cpo\",co_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";//co_no added on 2017-12-23
							// echo $sql31."<br>";
							mysqli_query($link, $sql31) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
							$size_ref=$size_ref+1;
						}
					}
				
				}
			}
		}
	}
	// $sql3="delete from $bai_pro3.shipment_plan";
	// mysqli_query($link,$sql3) or exit("Sql Error".mysql_error());

	$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"CMS_SP_2\")";
	mysqli_query($link, $sql3) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
	// echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"ssc_color_coding.php\"; }</script>";
?>
<?php	

		$sql1="select distinct order_style_no from $bai_pro3.bai_orders_db where color_code=0";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$style_no=$sql_row1['order_style_no'];
			//echo $style_no."<br/>";
			
			$sql2="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style_no\" and color_code=0";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$sch_no=$sql_row2['order_del_no'];
				//echo $sch_no."<br/>";


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
							
							mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
							$startcolor=$startcolor+1;
					}
					
	
			}
					
		}
				
	$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"COLOR1\")";
	// echo $sql3;
	mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
		//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"test.php\"; }</script>";
		
		
	//Embellishment For Previous Entries

	// $sql33="select schedule,op_desc from bai_pro3.bai_emb_db where mo_type=\"MO\"";
	//SR# 63724733 - KiranG/2015-08-4: Data field test (SCHEDULE) case causing an issue to extract schedule value and subsequent query execution.
	$sql33="select MAX(emb_tid), schedule,op_desc FROM $bai_pro3.bai_emb_db WHERE mo_type='MO' GROUP BY schedule"; //KiranG 2015-07-25 filter query.

	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$schedule=$sql_row33['schedule'];
		$op_desc=$sql_row33['op_desc'];
		if(strpos($op_desc," GF"))
		{
			$sql3="update $bai_pro3.bai_orders_db set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
			// echo $sql3;
			$res = mysqli_query($link, $sql3) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));

			$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
			// echo $sql31;
			mysqli_query($link, $sql31) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
		else
		{
			if(strpos($op_desc," PF"))
			{
				$sql3="update $bai_pro3.bai_orders_db set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				// echo $sql3;
				mysqli_query($link, $sql3) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));

				$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				// echo $sql31;
				mysqli_query($link, $sql31) or exit("Sql Error24".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
			else
			{
				$sql3="update $bai_pro3.bai_orders_db set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				// echo $sql3;
				mysqli_query($link, $sql3) or exit("Sql Error25".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql31="update $bai_pro3.bai_orders_db_confirm set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
				// echo $sql31;
				mysqli_query($link, $sql31) or exit("Sql Error26".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
		}	
	}
	
	$myFile = "m3_process_ses_track.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "<?php $"."log_time=".(int)date("YmdH")."; ?>";
	fwrite($fh, $stringData);
	fclose($fh);

	//Embellishment For Previous Entries

	// echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
	$end_timestamp = microtime(true);
	$duration = $end_timestamp - $start_timestamp;
	print("Execution took ".$duration." milliseconds.");		
?>


