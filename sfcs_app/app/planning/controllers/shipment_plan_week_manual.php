	<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
set_time_limit(0);
?>

<?php
	function week_of_year($month, $day, $year) {
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
?>


<?php

/*
$serverName = $host_adr4;

$uid = $host_adr4_un;
$pwd = $host_adr4_pw;
$connectionInfo = array( "UID"=>$uid,
                         "PWD"=>$pwd,
                         "Database"=>"MovexData");


$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
} 
*/
?>


<html>
<head>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',1,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',1,'R'); ?>" type="text/css" media="all" />
</head>
<body>
<?php
// include(include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php")); 
set_time_limit(0);
/* $sql3="TRUNCATE TABLE shipment_plan";
mysql_query($sql3,$link) or exit("Sql Error".mysql_error()); */

$sql3="update $bai_pro4.shipment_plan set cw_check=0"; // This is to track current week shipment plan entries available in db to avoid revised exfact and easy filter for week plan.
mysqli_query($link, $sql3) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
$style_code[]=array();
$schedule_code[]=array();
$color_code[]=array();
$ii=0;
$sql1="select style,schedule_no,color from $bai_pro4.job_shipment_plan_man_up group by style,schedule_no,color";
//echo $sql1;
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$style_code[$ii]=$sql_row1['style'];
	$schedule_code[$ii]=$sql_row1['schedule_no'];
	$color_code[$ii]=$sql_row1['color'];
	$ii++;
}
echo sizeof($style_code)."---".sizeof($schedule_code)."---".sizeof($color_code)."<br>";
for($k=0;$k<sizeof($color_code);$k++)
{
	$i=1;
	//echo $k."-32-"."<br>";
	$sql2="select SIZE as size_name from $bai_pro4.job_shipment_plan_man_up where style='".$style_code[$k]."' and schedule_no='".$schedule_code[$k]."' and color='".$color_code[$k]."' GROUP BY SIZE";
	// echo $sql2."--2<br>";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		//echo $sql_row2['size_name']."--1<br>";
		//$size_code=$sql_row2['size'];
		//echo $size_code."--11<br>";
		$sql="select *,SUM(ORD_QTY) AS ORD_QTYS from $bai_pro4.job_shipment_plan_man_up where style='".$style_code[$k]."' and schedule_no='".$schedule_code[$k]."' and color='".$color_code[$k]."' and size='".$sql_row2['size_name']."'";
		//echo $sql."--3<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			
			$ORDER_NO=$sql_row['ORDER_NO'];
			$DELIVERY_NO=$sql_row['DELIVERY_NO'];
			$DEL_STATUS=$sql_row['DEL_STATUS'];
			$MPO=$sql_row['MPO'];
			$CPO=$sql_row['CPO'];
			$BUYER=$sql_row['BUYER'];
			$PRODUCT=$sql_row['PRODUCT'];
			$BUYER_DIVISION=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $sql_row['BUYER_DIVISION']);
			$STYLE=$sql_row['STYLE'];
			$SCHEDULE_NO=$sql_row['SCHEDULE_NO'];
			$COLOR=$sql_row['COLOR'];
			
			$Z_FEATURE=$sql_row['Z_FEATURE'];
			$ORD_QTY=(float)$sql_row['ORD_QTYS'];
			$EX_FACTORY_DATE=$sql_row['EX_FACTORY_DATE'];
			$MODE=$sql_row['MODE'];
			$DESTINATION=$sql_row['DESTINATION'];
			$PACKING_METHOD=$sql_row['PACKING_METHOD'];
			$FOB_PRICE_PER_PIECE=(float)$sql_row['FOB_PRICE_PER_PIECE'];
			$CM_VALUE=(float)$sql_row['CM_VALUE'];
					
			$order_embl_a=(($sql_row['A']=="A")?1:0);
			$order_embl_b=(($sql_row['B']=="B")?1:0);
			$order_embl_c=(($sql_row['C']=="C")?1:0);
			$order_embl_d=(($sql_row['D']=="D")?1:0);
			$order_embl_e=(($sql_row['E']=="E")?1:0);
			$order_embl_f=(($sql_row['F']=="F")?1:0);
			$order_embl_g=(($sql_row['G']=="G")?1:0);
			$order_embl_h=(($sql_row['H']=="H")?1:0);

			$date_code=substr($EX_FACTORY_DATE,0,-4)."-".substr($EX_FACTORY_DATE,4,-2)."-".substr($EX_FACTORY_DATE,-2);
			$ssc_code=$STYLE.$SCHEDULE_NO.$COLOR."-".$EX_FACTORY_DATE;
			$ssc_code_new=$STYLE.$SCHEDULE_NO.$COLOR;
			
			$year=substr($EX_FACTORY_DATE,0,-4);
			$month=substr($EX_FACTORY_DATE,4,-2);
			$date=substr($EX_FACTORY_DATE,-2);
			$weekcode=week_of_year($month,$date,$year);

			if($i>9)
			{
				$size_code="size_s".$i;
			}
			else
			{
				$size_code="size_s0".$i;
			}
			$i++;
			
			$sql3="insert ignore into $bai_pro4.shipment_plan (ssc_code_week_plan) values(\"$ssc_code_new".$size_code.$DELIVERY_NO."\")";
			// echo $sql3."<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error3=".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql3="update $bai_pro4.shipment_plan set order_no=\"$ORDER_NO\",delivery_no=\"$DELIVERY_NO\",del_status=\"$DEL_STATUS\",mpo=\"$MPO\",cpo="."'".str_replace('"',' ',$CPO)."'".",buyer="."'".str_replace('"',' ',$BUYER)."'".",product="."'".str_replace('"',' ',$PRODUCT)."'".",buyer_division=\"$BUYER_DIVISION\",style=\"$STYLE\",schedule_no=\"$SCHEDULE_NO\",color=\"$COLOR\",size=\"$size_code\",z_feature=\"$Z_FEATURE\",ord_qty=$ORD_QTY,ex_factory_date=\"$date_code\",mode=\"$MODE\",destination=\"$DESTINATION\",packing_method=\"$PACKING_METHOD\",fob_price_per_piece=$FOB_PRICE_PER_PIECE,cm_value=$CM_VALUE,ssc_code=\"$ssc_code\",week_code=$weekcode,ssc_code_new=\"$ssc_code_new\",order_embl_a=$order_embl_a,order_embl_b=$order_embl_b,order_embl_c=$order_embl_c,order_embl_d=$order_embl_d,order_embl_e=$order_embl_e,order_embl_f=$order_embl_f,order_embl_g=$order_embl_g,order_embl_h=$order_embl_h, cw_check=1 where ssc_code_week_plan=\"$ssc_code_new".$size_code.$DELIVERY_NO."\"";
			echo $sql3."<br/>";
			mysqli_query($link, $sql3) or exit("Sql Error4=".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}	
}
	

/* Free statement and connection resources. */
/*sqlsrv_free_stmt( $sql_result); */
/* sqlsrv_close( $conn); */

// echo "Please wait while processing data!!";
$url2=getFullURL($_GET['r'],'plan_process_week.php','N');
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url2\"; }</script>";

//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = \"$dns_adr3/projects/beta/visionair/delivery_schedules/week_delivery_plan_cache_truncate.php\"; }</script>";

?>
</body>
</html>
