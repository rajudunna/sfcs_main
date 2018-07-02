<?php
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	
	
function week_of_year($month, $day, $year) 
{
    //Get date supplied Timestamp;
    $thisdate = mktime(0,0,0,$month,$day,$year);
    //If the 1st day of year is a monday then Day 1 is Jan 1
    if (date("D", mktime(0,0,0,1,1,$year)) == "Mon"){
        $day1=mktime (0,0,0,1,1,$year);
    } else {
        //If date supplied is in last 4 days of last year then find the monday before Jan 1 of next year
        if (date("z", mktime(0,0,0,$month,$day,$year)) >= "361"){
            $day1=strtotime("last Monday", mktime(0,0,0,1,1,$year+1));
        } else {
            $day1=strtotime("last Monday", mktime(0,0,0,1,1,$year));
        }
    }
    // Calcualte how many days have passed since Day 1
    $dayspassed=(($thisdate - $day1)/60/60/24);
    //If Day is Sunday then count that day other wise look for the next sunday
    if (date("D", mktime(0,0,0,$month,$day,$year))=="Sun"){
        $sunday = mktime(0,0,0,$month,$day,$year);
    } else {
        $sunday = strtotime("next Sunday", mktime(0,0,0,$month,$day,$year));   
    }
    // Calculate how many more days until Sunday from date supplied
    $daysleft = (($sunday - $thisdate)/60/60/24);
    // Add how many days have passed since figured Day 1
    // plus how many days are left in the week until Sunday
    // plus 1 for today
    // and divide by 7 to get what week number it is
    $thisweek = ($dayspassed + $daysleft+1)/7;
    return $thisweek;
}

function weeknumber ($y, $m, $d) {
    $wn = strftime("%U",mktime(0,0,0,$m,$d,$y));
	//echo date("W",mktime(0,0,0,$m,$d,$y));
	//echo $wn;
    $wn += 0; # wn might be a string value
    $firstdayofyear = getdate(mktime(0,0,0,1,1,$y));
	//echo $firstdayofyear["wday"];
    if ($firstdayofyear["wday"] <=6)    # if 1/1 is not a Monday, add 1
        $wn += 1;
    return ($wn);
} 

function weeknumber_v1 ($y, $m, $d) {
	GLOBAL $link;
   	$sql="select week(\"$y-$m-$d\") as week";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		 return ($sql_row['week']);
	}
} 

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

$sql3="delete from $bai_pro2.shipment_plan";
mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="SELECT Customer_Order_No AS A,MPO,CPO,Buyer_Division,Style_No,Schedule_No,Colour,Size,ZFeature,SUM(Order_Qty) as qty,Ex_Factory,MODE,Destination,Packing_Method,FOB_Price_per_piece,CM_Value,EMB_A,EMB_B,EMB_C,EMB_D,EMB_E,EMB_F,EMB_G,EMB_H FROM $m3_inputs.shipment_plan WHERE ex_factory BETWEEN \"20180101\" AND \"20180831\" AND schedule_no > 0 GROUP BY Style_No,Schedule_No,Colour,Size,Ex_Factory,Destination";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=str_pad($sql_row['Style_No'],"15"," ");
	$schedule=$sql_row['Schedule_No'];
	$color=str_pad($sql_row['Colour'],"30"," ");
	$qty=$sql_row['qty'];
	$order_date=$sql_row['Ex_Factory'];

	$order_no=$sql_row['A'];
	$cpo=$sql_row['CPO'];
	$mpo=$sql_row['MPO'];
	$division=$sql_row['Buyer_Division'];

	$date_code=substr($order_date,0,-4)."-".substr($order_date,4,-2)."-".substr($order_date,-2);

	$year=substr($order_date,0,-4);
	$month=substr($order_date,4,-2);
	$date=substr($order_date,-2);
	$date_codes = mktime(0, 0, 0, $month, $date, $year); 
	$weekcode = (int)date('W', $date_codes);

	$color=str_replace('"',"'",$color);
	$division=str_replace('"',"'",$division);

	$sql3="insert into $bai_pro2.shipment_plan(style_no, schedule_no, color, order_qty, exfact_date, week_code, cust_order, cpo, buyer_div, mpo) values("."\"$style\"".", "."\"$schedule\"".", "."\"$color\"".", ".$qty.", "."\"$date_code\"".", ".$weekcode.", "."\"$order_no\"".", "."\"$cpo\"".", "."\"$division\"".", "."\"$mpo\")";
	// echo $sql3."<br/><br/>";
	mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

$sql="select distinct style_no from $bai_pro2.shipment_plan";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['style_no'];
	
	$sql1="select distinct schedule_no from $bai_pro2.shipment_plan where style_no=\"$style\"";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$sch_no=$sql_row1['schedule_no'];
		
		$sql2="select distinct color from $bai_pro2.shipment_plan where schedule_no=\"$sch_no\" and style_no=\"$style\"";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$color=$sql_row2['color'];
			$ssc_code=$style.$sch_no.$color;
			
			$order_qty=0;
			
			$sql3="select sum(order_qty) as \"order_qty\", exfact_date, week_code, cust_order, cpo, mpo, buyer_div from $bai_pro2.shipment_plan where style_no	=\"$style\" and schedule_no=\"$sch_no\" and color=\"$color\"";
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$order_qty=$sql_row3['order_qty'];
				$exfact_date=$sql_row3['exfact_date'];
				$week_code=$sql_row3['week_code'];
				$cust_order=$sql_row3['cust_order'];
				$cpo=$sql_row3['cpo'];
				$mpo=$sql_row3['mpo'];
				$buyer_div=$sql_row3['buyer_div'];
			}			

			$old_order_qty=0;
			
			$sql3="select * from $bai_pro2.shipment_plan_summ where ssc_code=\"$ssc_code\"";
			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$old_order_qty=$sql_row3['old_order_qty'];
			}			
			
			if($order_qty>0)
			{
				
				$sql3="insert ignore into $bai_pro2.shipment_plan_summ (ssc_code) values (\"$ssc_code\")";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

				$sql3="insert ignore into $bai_pro2.ssc_code_list(ssc_code) values (\"$ssc_code\")";
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				if($order_qty>$old_order_qty)
				{
					$sql3="update  $bai_pro2.shipment_plan_summ set style_no=\"$style\", schedule_no=\"$sch_no\", color=\"$color\", order_qty=$order_qty, week_code=$week_code, exfact_date=\"$exfact_date\", cust_order=\"$cust_order\", cpo=\"$cpo\", mpo=\"$mpo\", buyer_div=\"$buyer_div\", old_order_qty=$old_order_qty where ssc_code=\"$ssc_code\"";
				}
				else
				{
					$sql3="update  $bai_pro2.shipment_plan_summ set style_no=\"$style\", schedule_no=\"$sch_no\", color=\"$color\", order_qty=$old_order_qty, week_code=$week_code, exfact_date=\"$exfact_date\", cust_order=\"$cust_order\", cpo=\"$cpo\", mpo=\"$mpo\", buyer_div=\"$buyer_div\", old_order_qty=$old_order_qty where ssc_code=\"$ssc_code\"";
				}
				
				mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
		}
		
	}
}
$new_styles=0;
$sql="select distinct style_no from $bai_pro2.shipment_plan";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style_no=$sql_row['style_no'];
	
	$sql44="select buyer_code FROM $bai_pro2.buyer_codes WHERE buyer_name in (SELECT DISTINCT order_div FROM $bai_pro3.bai_orders_db WHERE order_style_no='$style_no' )";			
	$result44=mysqli_query($link, $sql44) or exit("error1245".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row44=mysqli_fetch_array($result44))
	{
		$buyer_id_new=$sql_row44['buyer_code'];
	}
	
	$sql2="insert ignore into  $bai_pro2.movex_styles (movex_style, style_id,buyer_id) values (\"$style_no\", \"".check_style($style_no)."\",\"".$buyer_id_new."\")";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_affected_rows($link)>0)
	{
		$message.="<tr><td>$style_no</td><td>".check_style($style_no)."</td><td>".$buyer_id."</td></tr>";
		$new_styles++;	
	}		
}
// echo $message;
$sql="select * from $bai_pro2.shipment_plan where style_id is NULL";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style_no=$sql_row['style_no'];
	$tid=$sql_row['tid'];
	$sql2="update $bai_pro2.shipment_plan set style_id=(select style_id from $bai_pro2.movex_styles where movex_style=\"$style_no\") where tid=$tid";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}	


$sql="select * from $bai_pro2.shipment_plan_summ where style_id is NULL";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$ssc_code=$sql_row['ssc_code'];
	$style_no=$sql_row['style_no'];
	$sql2="update $bai_pro2.shipment_plan_summ set style_id=(select style_id from $bai_pro2.movex_styles where movex_style=\"$style_no\") where ssc_code=\"$ssc_code\"";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}


$sql="select * from $bai_pro2.shipment_plan";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$ssc_code=$sql_row['style_no'].$sql_row['schedule_no'].$sql_row['color'];
	$sql2="update $bai_pro2.shipment_plan set ssc_code=\"$ssc_code\" where tid=".$sql_row['tid'];
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if($new_styles>0)
{
	$msg="<html><body>Dear Associates,<br/><br/>Please find the below new style updates in SFS and update the details accordingly.<br/><br/><table><tr><th><u>M3 Style</u></th><th><u>System Defined Style</u></th></tr>";
	$msg.=$message;
	$msg.="</table><br/>Message Sent Via: $dns_adr1</body></html>";
	
	$to  = 'rameshk@schemaxtech.com';
	
	if(strtolower($_SERVER['SERVER_NAME'])=="bainet")
	{
		$plant_name="BAI-1";
		$to  = 'rameshk@schemaxtech.com';
	}

	if(strtolower($_SERVER['SERVER_NAME'])=="bai2net")
	{
		$plant_name="BAI-2";
		$to  = 'rameshk@schemaxtech.com';
	}
	
	
	$to  = 'rameshk@schemaxtech.com';
	$subject = 'New Style Additions';
	
	//To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$headers .= 'To: '.$to. "\r\n";
	$headers .= 'To: <rameshk@schemaxtech.com>;'. "\r\n";
	$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n";
	
	mail($to, $subject, $msg, $headers);
	
}


?>
<script language="javascript"> setTimeout("CloseWindow()",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>