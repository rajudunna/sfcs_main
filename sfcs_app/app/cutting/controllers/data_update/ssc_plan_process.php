<?php
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
set_time_limit(6000000);
?>

<?php

function check_style($string)
{
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	
	$check=0;
	for ($index=0;$index<strlen($string);$index++) {
    	if(isNumber($string[$index]))
		{
			$nums .= $string[$index];
		}
     	else    
		{
			$chars .= $string[$index];
			$check=$check+1;
			if($check==2)
			{
				break;
			}
		}
       		
			
	}
	//echo "Chars: -$chars-<br>Nums: -$nums-";
	
	//New Implementation to update style ids as per the available definitions in bai_pro2
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

function isNumber($c) {
    return preg_match('/[0-9]/', $c);
}
?> 



<html>
<head>
</head>
<body>

<?php
			
	//KiranG 20171212- Added to take MO level order quantities and to avoid duplicates.
	
	$size=array("s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50"); 
	
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_tid like '%***%'";
	$resultset=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($resultset)>0)
	{
	
		//To handle T57 with Multiple combination of size ranges
		$sql="UPDATE $bai_pro3.shipment_plan SET color=CONCAT(CONVERT(stripSpeciaChars(size_code,0,0,1,0) USING utf8),'===',color) WHERE  
		schedule_no not in (select distinct order_del_no from $bai_pro3.bai_orders_db 
		where order_tid like '%***%') AND 
		CONCAT(size_code REGEXP '[[:alpha:]]+',size_code REGEXP '[[:digit:]]+')='11' AND (RIGHT(TRIM(BOTH FROM size_code),1) in ('0','1') OR CONCAT(size_code REGEXP '[[^./.]]','NEW')='1NEW') AND CONCAT(color REGEXP '[***]','NEW')<>'1NEW' AND CONCAT(color REGEXP '[^===]','NEW')<>'1NEW'";
	}
	else
	{
		//To handle T57 with Multiple combination of size ranges
		$sql="UPDATE $bai_pro3.shipment_plan SET color=CONCAT(CONVERT(stripSpeciaChars(size_code,0,0,1,0) USING utf8),'===',color) WHERE  
		CONCAT(size_code REGEXP '[[:alpha:]]+',size_code REGEXP '[[:digit:]]+')='11' AND (RIGHT(TRIM(BOTH FROM size_code),1) in ('0','1') OR CONCAT(size_code REGEXP '[[^./.]]','NEW')='1NEW') AND CONCAT(color REGEXP '[***]','NEW')<>'1NEW' AND CONCAT(color REGEXP '[^===]','NEW')<>'1NEW'";
	}
	// echo $sql.'<br>';
	// die();
	mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select distinct style_no from $bai_pro3.shipment_plan ";
	mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$style=$sql_row['style_no'];
		
		$sql1="select distinct schedule_no from $bai_pro3.shipment_plan where style_no=\"$style\" ";
		mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$sch_no=$sql_row1['schedule_no'];
			
			$sql2="select distinct color from $bai_pro3.shipment_plan where schedule_no=\"$sch_no\" and style_no=\"$style\"";
			mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				
				$color=$sql_row2['color'];
				$ssc_code=$style.$sch_no.$color;
					
					// start need to assign the flag value for new order_tids based the number of rows validation (for dynamic size enhancement) 
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
							mysqli_query($link, $sql3) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
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
							
							$sql3="update $bai_pro3.bai_orders_db set order_s_xs=0, order_s_s=0, order_s_m=0, order_s_l=0, order_s_xl=0, order_s_xxl=0, order_s_xxxl=0, order_s_s01=0, order_s_s02=0, order_s_s03=0, order_s_s04=0, order_s_s05=0, order_s_s06=0, order_s_s07=0, order_s_s08=0, order_s_s09=0, order_s_s10=0, order_s_s11=0, order_s_s12=0, order_s_s13=0, order_s_s14=0, order_s_s15=0, order_s_s16=0, order_s_s17=0, order_s_s18=0, order_s_s19=0, order_s_s20=0, order_s_s21=0, order_s_s22=0, order_s_s23=0, order_s_s24=0, order_s_s25=0, order_s_s26=0, order_s_s27=0, order_s_s28=0, order_s_s29=0, order_s_s30=0, order_s_s31=0, order_s_s32=0, order_s_s33=0, order_s_s34=0, order_s_s35=0, order_s_s36=0, order_s_s37=0, order_s_s38=0, order_s_s39=0, order_s_s40=0, order_s_s41=0, order_s_s42=0, order_s_s43=0, order_s_s44=0, order_s_s45=0, order_s_s46=0, order_s_s47=0, order_s_s48=0, order_s_s49=0, order_s_s50=0, title_size_s01=\"\", title_size_s02=\"\",title_size_s03=\"\",title_size_s04=\"\",title_size_s05=\"\",title_size_s06=\"\",title_size_s07=\"\",title_size_s08=\"\",title_size_s09=\"\",title_size_s10=\"\",title_size_s11=\"\",title_size_s12=\"\",title_size_s13=\"\",title_size_s14=\"\",title_size_s15=\"\",title_size_s16=\"\",title_size_s17=\"\",title_size_s18=\"\",title_size_s19=\"\",title_size_s20=\"\",title_size_s21=\"\",title_size_s22=\"\",title_size_s23=\"\",title_size_s24=\"\",title_size_s25=\"\",title_size_s26=\"\",title_size_s27=\"\",title_size_s28=\"\",title_size_s29=\"\",title_size_s30=\"\",title_size_s31=\"\",title_size_s32=\"\",title_size_s33=\"\",title_size_s34=\"\",title_size_s35=\"\",title_size_s36=\"\",title_size_s37=\"\",title_size_s38=\"\",title_size_s39=\"\",title_size_s40=\"\",title_size_s41=\"\",title_size_s42=\"\",title_size_s43=\"\",title_size_s44=\"\",title_size_s45=\"\",title_size_s46=\"\",title_size_s47=\"\",title_size_s48=\"\",title_size_s49=\"\",title_size_s50=\"\"
 where order_tid=\"$ssc_code\"";
							mysqli_query($link, $sql3) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
				
							
				$sql22="select distinct size_code from $bai_pro3.shipment_plan where color=\"$color\" and schedule_no=\"$sch_no\" and style_no=\"$style\" ORDER BY CONVERT(bai_pro3.stripSpeciaChars(size_code,0,1,0,0) USING utf8)*1,FIELD(size_code,'xs','s','m','l','xl','xxl','xxxl')";
				mysqli_query($link, $sql22) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row22=mysqli_fetch_array($sql_result22))
				{
					$size_code=$sql_row22['size_code'];
					$order_qty=0;
					
					$sql3="select coalesce(sum(order_qty),0) as \"order_qty\", exfact_date, cpo, buyer_div, packing_method, destination, zfeature, style_id, COALESCE(order_embl_a,0) as order_embl_a,COALESCE(order_embl_b,0) as order_embl_b,COALESCE(order_embl_c,0) as order_embl_c,COALESCE(order_embl_d,0) as order_embl_d,COALESCE(order_embl_e,0) as order_embl_e,COALESCE(order_embl_f,0) as order_embl_f,COALESCE(order_embl_g,0) as order_embl_g,COALESCE(order_embl_h,0) as order_embl_h
 from $bai_pro3.shipment_plan where style_no=\"$style\" and schedule_no=\"$sch_no\" and color=\"$color\" and size_code=\"$size_code\"";
					// echo $sql3."<br>";
					mysqli_query($link, $sql3) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row3=mysqli_fetch_array($sql_result3))
					{
						//////$order_qty=$sql_row3['order_qty'];
						
						//KiranG 20171212 - Taking Mo level order quantites.
						
						$sql3abc="select coalesce(sum(order_qty),0) as \"order_qty\"
 from $bai_pro3.order_plan where style_no=\"$style\" and schedule_no=\"$sch_no\" and color=\"$color\" and size_code=\"$size_code\"";
					// echo $sql3abc."<br>";
					$sql_result3abc=mysqli_query($link, $sql3abc) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row3abc=mysqli_fetch_array($sql_result3abc))
					{
						$order_qty=$sql_row3abc['order_qty'];
					}
						//KiranG 20171212 - Taking Mo level order quantites.
						
						$exfact_date=$sql_row3['exfact_date'];
						$cpo=$sql_row3['cpo'];
						$buyer_div=$sql_row3['buyer_div'];
						$packing_method=$sql_row3['packing_method'];
						$zfeature=$sql_row3['zfeature'];
						$destination=$sql_row3['destination'];
						$style_id=check_style($style);
						
						$order_embl_a=$sql_row3['order_embl_a'];
						$order_embl_b=$sql_row3['order_embl_b'];
						$order_embl_c=$sql_row3['order_embl_c'];
						$order_embl_d=$sql_row3['order_embl_d'];
						$order_embl_e=$sql_row3['order_embl_e'];
						$order_embl_f=$sql_row3['order_embl_f'];
						$order_embl_g=$sql_row3['order_embl_g'];
						$order_embl_h=$sql_row3['order_embl_h'];

					}
						
					
									
				if($order_qty>=0)
				{
					//echo $ssc_code;
					/*
					$flag=0;
					$sql13="select * from $bai_pro3.bai_orders_db where order_tid=\"".$ssc_code."\" and title_flag=0";
					$result11=mysql_query($sql13,$link) or exit("Sql Error".mysql_error());
					$sql_num_check=mysql_num_rows($result11);
					if($sql_num_check =='0')
					{
						$flag=1;
					}
					*/
					$sql3="insert ignore into $bai_pro3.bai_orders_db (order_tid) values (\"$ssc_code\")";
					mysqli_query($link, $sql3) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql3="update $bai_pro3.bai_orders_db set order_embl_a=$order_embl_a,order_embl_b=$order_embl_b,order_embl_c=$order_embl_c,order_embl_d=$order_embl_d,order_embl_e=$order_embl_e,order_embl_f=$order_embl_f,order_embl_g=$order_embl_g,order_embl_h=$order_embl_h where order_tid=\"$ssc_code\" and (order_embl_a+order_embl_b+order_embl_c+order_embl_d+order_embl_e+order_embl_f+order_embl_g+order_embl_h)=0";
					mysqli_query($link, $sql3) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
					// start new enhancement for dynamic size codes for M&S and CK buyer
					if($flag==1)
					//if((substr($style,0,1)!="P" && substr($style,0,1)!="K" && substr($style,0,1)!="L" && substr($style,0,1)!="O") && $flag==1)
					{			
						$sql31="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", zfeature=\"$zfeature\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_".$size[$size_ref]."=$order_qty,title_size_".$size[$size_ref]."=\"".trim($size_code)."\",order_date=\"$exfact_date\",title_flag=\"$flag\", order_po_no=\"$cpo\",co_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";//co_no added on 2017-12-23
						// echo $sql31."<br>";
						mysqli_query($link, $sql31) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
						$size_ref=$size_ref+1;
					}
					// end new enhancement for dynamic size codes for M&S and CK buyer
					else
					{
						if(substr($style,0,1)=="D")
						{
							switch (trim($size_code))
							{							
								case "1":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xs=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
					
								case "2":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
							
								
								case "3":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_m=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "4":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "5":
								{
																			
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								
								case "6":
								{
									
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
		
								case "7":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "XS":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xs=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T01":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xs=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "S":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T02":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "M":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_m=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T03":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_m=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "L":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "L.L":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "T04":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "XL":
								{
															
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T05":
								{
																			
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "XXL":
								{
									
											
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T06":
								{
									
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "XXXL":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T07":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
		
							}
						}
						else
						{
									
							switch (trim($size_code))
							{
								case "XS":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xs=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T01":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xs=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "S":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T02":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "M":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_m=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T03":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_m=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "L":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "L.L":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "T04":
								{
								
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_l=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "XL":
								{
															
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T05":
								{
																			
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "XXL":
								{
									
											
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T06":
								{
									
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								case "XXXL":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "T07":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_xxxl=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "1":
								  {
								   
								   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s01=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
								   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								   break;
								  }
								case "2":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s02=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "3":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s03=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "4":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s04=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "5":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s05=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "6":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s06=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "7":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s07=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "8":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s08=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "9":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s09=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "10":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s10=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "11":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s11=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "12":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s12=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "13":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s13=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "14":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s14=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "15":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s15=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "16":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s16=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "17":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s17=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "18":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s18=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "19":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s19=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "20":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s20=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "21":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s21=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "22":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s22=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "23":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s23=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "24":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s24=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "25":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s25=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "26":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s26=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "27":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s27=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "28":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s28=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "29":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s29=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "30":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s30=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "31":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s31=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "32":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s32=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "33":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s33=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "34":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s34=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "35":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s35=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "36":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s36=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "37":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s37=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "38":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s38=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "39":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s39=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "40":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s40=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "41":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s41=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "42":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s42=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "43":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s43=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "44":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s44=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "45":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s45=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "46":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s46=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "47":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s47=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "48":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s48=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "49":
									  {
									   
									   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s49=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									   break;
									  }
								case "50":
									  {
								   
								   $sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s50=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
								   mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								   break;
								  }

								
								//LBI
								case "12":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s12=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "14/16":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s14=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "18/20":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s18=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "22/24":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s22=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "26/28":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s26=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "30/32":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s30=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								//Date 2013-08-28
								//New M&S sizes
								
								case "8-10":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s08=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "12-14":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s12=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								case "16-18":
								{
									
									$sql3="update $bai_pro3.bai_orders_db set packing_method=\"$packing_method\",destination=\"$destination\", style_id=\"$style_id\",  order_style_no=\"$style\", order_del_no=\"$sch_no\", order_col_des=\"$color\", order_s_s16=$order_qty, order_date=\"$exfact_date\", order_po_no=\"$cpo\", order_div=\"$buyer_div\" where order_tid=\"$ssc_code\"";
									mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
									break;
								}
								
								//New M&S sizes
							}
						}
					}
				}
				
			}
			
		}
	}
}

/*
//Embellishment For Previous Entries

$sql33="select schedule,op_desc from bai_emb_db where mo_type=\"MO\"";
//SR# 63724733 - KiranG/2015-08-4: Data field test (SCHEDULE) case causing an issue to extract schedule value and subsequent query execution.a
$sql33="SELECT MAX(emb_tid), schedule,op_desc FROM bai_emb_db WHERE mo_type='MO' GROUP BY schedule"; //KiranG 2015-07-25 filter query.

$sql_result33=mysql_query($sql33,$link) or exit("Sql Error20".mysql_error());

while($sql_row33=mysql_fetch_array($sql_result33))
{
	$schedule=$sql_row33['schedule'];
	$op_desc=$sql_row33['op_desc'];
	if(strpos($op_desc," GF"))
	{
		$sql3="update $bai_pro3.bai_orders_db set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
		mysql_query($sql3,$link) or exit("Sql Error21".mysql_error());
		
		$sql31="update bai_orders_db_confirm set order_embl_e=1,order_embl_f=1,order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0 where order_del_no=\"$schedule\"";
		mysql_query($sql31,$link) or exit("Sql Error122".mysql_error());
	}
	else
	{
		if(strpos($op_desc," PF"))
		{
			$sql3="update $bai_pro3.bai_orders_db set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
			mysql_query($sql3,$link) or exit("Sql Error23".mysql_error());
			
			$sql31="update bai_orders_db_confirm set order_embl_a=1,order_embl_b=1,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
			mysql_query($sql31,$link) or exit("Sql Error24".mysql_error());
		}
		else
		{
			$sql3="update $bai_pro3.bai_orders_db set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
			mysql_query($sql3,$link) or exit("Sql Error25".mysql_error());
			
			$sql31="update bai_orders_db_confirm set order_embl_a=0,order_embl_b=0,order_embl_c=0,order_embl_d=0,order_embl_g=0,order_embl_h=0,order_embl_e=0,order_embl_f=0 where order_del_no=\"$schedule\"";
			mysql_query($sql31,$link) or exit("Sql Error26".mysql_error());
		}
	}	
}

//Embellishment For Previous Entries
*/
/*
//KIRANG-20150723 New mode of updating embellishment in single query.

$sql33="UPDATE $bai_pro3.bai_orders_db LEFT JOIN bai_emb_db ON CONCAT(order_del_no,order_col_des)=CONCAT(SCHEDULE,gmt_color) 
SET order_embl_a=IF(op_desc LIKE '%PF%',1,0),order_embl_b=IF(op_desc LIKE '%PF%',1,0),order_embl_c=0,order_embl_d=0,order_embl_e=IF(op_desc LIKE '%GF%',1,0),order_embl_f=IF(op_desc LIKE '%GF%',1,0),order_embl_g=0,order_embl_h=0

WHERE mo_type='MO'";
mysql_query($sql33,$link) or exit("Sql Error20".mysql_error());

$sql33="UPDATE bai_orders_db_confirm LEFT JOIN bai_emb_db ON CONCAT(order_del_no,order_col_des)=CONCAT(SCHEDULE,gmt_color) 
SET order_embl_a=IF(op_desc LIKE '%PF%',1,0),order_embl_b=IF(op_desc LIKE '%PF%',1,0),order_embl_c=0,order_embl_d=0,order_embl_e=IF(op_desc LIKE '%GF%',1,0),order_embl_f=IF(op_desc LIKE '%GF%',1,0),order_embl_g=0,order_embl_h=0

WHERE mo_type='MO'";
mysql_query($sql33,$link) or exit("Sql Error20".mysql_error());

//KIRANG-20150723 New mode of updating embellishment in single query.
*/
	$sql3="delete from $bai_pro3.shipment_plan";
	//mysql_query($sql3,$link) or exit("Sql Error".mysql_error());

	$sql3="insert into $bai_pro3.db_update_log (date, operation) values (\"".date("Y-m-d")."\",\"CMS_SP_2\")";
	mysqli_query($link, $sql3) or exit("Sql Error27".mysqli_error($GLOBALS["___mysqli_ston"]));
							
	echo "<h2>Successfully Updated. Please Don't close this window.</h2>";
	$url=getFullURL($_GET['r'],'ssc_color_coding.php','N');						
	echo "<script type=\"text/javascript\"> 
			setTimeout(\"Redirect()\",500); 
				function Redirect() {  
					location.href = \"$url\"; 
				}
		  </script>";
?>

</body>
</html>


	