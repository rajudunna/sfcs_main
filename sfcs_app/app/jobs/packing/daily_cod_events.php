<?php 
error_reporting(0);
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$yesterday=date("Y-m-d",strtotime("-1 day")); 
$yesterday="2018-02-21"; 
$total_sch_count=0; 
$buyer_hold_count = [];
$buyer_unhold_count = [];

$hold_sch=0; 
$total_mns=0; 
$hold_mns=0; 
$sno=1; 
$note="<table>"; 
$note.="<tr><th>S#</th><th>Style</th><th>Schedule</th><th width=200>Plan Remarks</th><th width=200>Production Remarks</th><th width=200>Commitments</th></tr>"; 

$sql="select * FROM $bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$yesterday\""; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{
    $remarks = []; 
    $schedule=$sql_row['schedule_no']; 
    $style=$sql_row['style']; 
    $tid=$sql_row['ref_id']; 
    $buyer =$sql_row['buyer_division'];
   

    $remarks=explode("^",$sql_row['remarks']);
    $status=1; //Not Failed 
    $sql="select disp_note_ref FROM $bai_pro3.bai_ship_cts_ref WHERE ship_schedule='$schedule'"; 
    $sql_result1=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
    if(mysqli_num_rows($sql_result1)>0) 
    { 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $disp_note_ref=$sql_row1['disp_note_ref']; 
        } 
                 
        $sql="select exit_date FROM $bai_pro3.disp_db WHERE disp_note_no in($disp_note_ref) and status<3"; 
        $sql_result1=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if(mysqli_num_rows($sql_result1)>0) 
        { 
            $status=1; 
        } 
        else 
        { 
            $status=0; 
        } 
    } 
    $sqla="SELECT buyer_code AS buyer_div FROM $bai_pro2.buyer_codes where buyer_name='$buyer'";
    $sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error1244".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_rowa=mysqli_fetch_array($sql_resulta))
    {
        $buyer_code=$sql_rowa['buyer_div'];
    }
    $buyer_remarks[$buyer_code]=$remarks;
    if($status==1) 
    { 
 
        $total_sch_count++; 
       
        if(in_array("HOLD",strtoupper($buyer_remarks[$buyer_code]))) 
        { 
            $buyer_hold_count[$buyer_code] = $buyer_code;
        
        }else
        {
            $buyer_unhold_count[$buyer_code] = $buyer_code;
        }     

       
        $note.= "<tr><td>$sno</td><td>$style</td><td>$schedule</td><td>".$remarks[0]."</td><td>".$remarks[1]."</td><td>".$remarks[2]."</td></tr>"; 
        $sno++; 
    } 
} 
$note.="</table>"; 


$message= '<html><head><style type="text/css"> 

body 
{ 
    font-family: arial; 
    font-size:12px; 
    color:black; 
} 
table 
{ 
border-collapse:collapse; 
white-space:nowrap;  
font-size:12px; 
} 
th 
{ 
    background-color: blue; 
    color: white; 
 border: 1px solid #660000;  
white-space:nowrap;  
padding-left: 10px; 
padding-right: 10px; 
font-size:12px; 
} 

td 
{ 
     
    color: BLACK; 
 border: 1px solid #660000;  
    padding: 1px; 
white-space:nowrap;  
text-align:right; 
font-size:12px; 
} 

</style></head><body>'; 


        
// $message.="<table>";
// $message.="<tr><th colspan=2>Summary</th><th>M&S</th><th>VS</th><th>Total</th></tr>";
// $sql="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";

// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row=mysqli_fetch_array($sql_result))
// {
//     $buyer_code[]=$sql_row["buyer_div"];
//     $buyer_name[]=$sql_row["buyer_name"];
// }
if(sizeof($buyer_remarks)>0)
{
$message.="<table>"; 
$message.="<tr><th colspan=2>Summary</th>";

	foreach ($buyer_remarks as $key => $value)
	{
		$message.= "<th>".$key."</th>";
	}
    $message.="<th>Total</th></tr>"; 
    $message.="<tr><td colspan=2 >On Hold</td>";
    foreach ($buyer_remarks as $key => $value)
	{
        $message.= "<td>".sizeof($buyer_hold_count[$key])."</td>";
    }
    $total =sizeof($buyer_hold_count);
    $message.= "<td>".$total."</td>";
    //   <td><td>$hold_mns</td><td>".($hold_sch-$hold_mns)."</td></td><td>$hold_sch</td>
    $message.="</tr>"; 
    $message.="<tr ><td colspan=2>Failed to send on time</td>";
    foreach ($buyer_remarks as $key => $value)
	{
        $message.= "<td >".sizeof($buyer_unhold_count[$key])."</td>";
    }
    $total1 = sizeof($buyer_unhold_count);
    $message.= "<td>".$total1."</td>";
   
    $message.="</tr>"; 
    $message.="<tr><td colspan=2>Total Schedules</td>";
    foreach ($buyer_remarks as $key => $value)
	{
        $message.= "<td>".(sizeof($buyer_hold_count[$key])+sizeof($buyer_unhold_count[$key]))."</td>";
        
    }
		$message.= "<td>".($total1+$total)."</td>";

    $message.="</tr></table><br/><br/>"; 
}





$message.=$note; 

$message.='<br/>Message Sent Via: '.$plant_name.'';
$message.="</body></html>"; 

// echo $message;
$to  =$daily_cod_events;

$subject = 'Delivery Failures :'.$yesterday; 

// To send HTML mail, the Content-type header must be set 
$headers  = 'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
// $headers .= 'From: BEKSFCS Alert <bek_sfcs@brandix.com>'. "\r\n";
$headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";


if($total_sch_count>0) 
{ 
    if(mail($to, $subject, $message, $headers)) 
    { 
     print("mail sent successfully")."\n"; 
    } 
} 
else
{
     print("Data Not Found ,So Mail Not Sent")."\n"; 
}



//BAI KPI Track 
$sql="SELECT style,schedule,color,track_id FROM $bai_kpi.delivery_delays_track WHERE ex_fact='$yesterday'"; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $ref_id=$sql_row['track_id']; 
    $style=$sql_row['style']; 
    $schedule=$sql_row['schedule']; 
    $color=$sql_row['color']; 
     
    if($schedule>0 and strlen($style)>0 and strlen($color)>0) 
    { 
        $sql1="SELECT MAX(ims_date) as input, MAX(ims_log_date) as output FROM (SELECT ims_date,ims_log_date FROM $bai_pro3.ims_log WHERE ims_schedule=$schedule and trim(both from ims_color)=\"".trim($color)."\" UNION SELECT ims_date,ims_log_date FROM $bai_pro3.ims_log_backup WHERE ims_schedule=$schedule and trim(both from ims_color)=\"".trim($color)."\") AS t";
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $input_time=$sql_row1['input']; 
            $output_time=$sql_row1['output']; 
        } 
         
        $sql1="SELECT MAX(lastup) as lastup FROM $bai_pro3.packing_summary WHERE order_del_no=$schedule"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $fg_time=$sql_row1['lastup']; 
        } 
         
        $sql1="update $bai_kpi.delivery_delays_track set input_time='$input_time',sewing_time='$output_time',fg_time='$fg_time' where track_id=$ref_id"; 
        $sql_result=mysqli_query($link, $sql1) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if($sql_result)
        {
            print("delivery_delays_track table Updated successfully")."\n";
        }
    } 
} 

//BAI KPI Track 


?> 

<?php 
    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print( "Execution took ".$duration." milliseconds.");
?>
