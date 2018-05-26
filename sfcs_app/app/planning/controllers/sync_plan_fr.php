<?php 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
set_time_limit(2000);
?>


<?php
$start_date_w=time();

while((date("N",$start_date_w))!=1) {
$start_date_w=$start_date_w-(60*60*24); // define monday
}
$end_date_w=$start_date_w+(60*60*24*6); // define sunday 

//echo date("Y-m-d",$end_date_w)."<br/>";
//echo date("Y-m-d",$start_date_w);
//$start_date_w=date("Y-m-d",$start_date_w);
//$end_date_w=date("Y-m-d",$end_date_w);

$start_date_w=date("Y-m-d",($start_date_w-(60*60*24*7)));
$end_date_w=date("Y-m-d",($end_date_w+(60*60*24*6)));

?>

<?php
// include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
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

$sql="select shipment_plan_id, fastreact_plan_id, plan_sec1,plan_sec2,plan_sec3,plan_sec4,plan_sec5,plan_sec6 from $bai_pro4.shipfast_sum where shipment_plan_id in (select ship_tid from week_delivery_plan_ref where ex_factory_date_new between \"$start_date_w\" and \"$end_date_w\")";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$ship_tid=$sql_row['shipment_plan_id'];
	$fast_id=$sql_row['fastreact_plan_id'];
	$sec1=$sql_row['plan_sec1'];
	$sec2=$sql_row['plan_sec2'];
	$sec3=$sql_row['plan_sec3'];
	$sec4=$sql_row['plan_sec4'];
	$sec5=$sql_row['plan_sec5'];
	$sec6=$sql_row['plan_sec6'];
	
	$sql1="select plan_sec1,plan_sec2,plan_sec3,plan_sec4,plan_sec5,plan_sec6 from $bai_pro4.week_delivery_plan where shipment_plan_id=$ship_tid";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		if($sec1>$sql_row1['plan_sec1']) { 	}
		else
		{  $sec1=$sql_row1['plan_sec1'];    }
		
		if($sec2>$sql_row1['plan_sec2']) { 	}
		else
		{  $sec2=$sql_row1['plan_sec2'];    }
		
		if($sec3>$sql_row1['plan_sec3']) { 	}
		else
		{  $sec3=$sql_row1['plan_sec3'];    }
		
		if($sec4>$sql_row1['plan_sec4']) { 	}
		else
		{  $sec4=$sql_row1['plan_sec4'];    }
		
		if($sec5>$sql_row1['plan_sec5']) { 	}
		else
		{  $sec5=$sql_row1['plan_sec5'];    }
		
		if($sec6>$sql_row1['plan_sec6']) { 	}
		else
		{  $sec6=$sql_row1['plan_sec6'];    }

	}
	
	$sql1="update $bai_pro4.week_delivery_plan set plan_sec1=$sec1,plan_sec2=$sec2,plan_sec3=$sec3,plan_sec4=$sec4,plan_sec5=$sec5,plan_sec6=$sec6,fastreact_plan_id=$fast_id where shipment_plan_id=$ship_tid";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

echo "<h2><font color=green>Successfully Updated.</font></h2>";
$report = getFullURLLevel($_GET['r'],'report.php',0,'N');

echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",500); function Redirect() {  location.href = '$report' }</script>";

?>

