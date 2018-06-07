<?php 
$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

$yesterday=date("Y-m-d",strtotime("-1 day")); 
//$yesterday="2012-03-04"; 
$total_sch_count=0; 
$hold_sch=0; 
$total_mns=0; 
$hold_mns=0; 
$sno=1; 
$note="<table>"; 
$note.="<tr><th>S#</th><th>Style</th><th>Schedule</th><th width=200>Plan Remarks</th><th width=200>Production Remarks</th><th width=200>Commitments</th></tr>"; 
$sql="select style,schedule_no,ref_id FROM bai_pro4.week_delivery_plan_ref WHERE ex_factory_date_new=\"$yesterday\""; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $schedule=$sql_row['schedule_no']; 
    $style=$sql_row['style']; 
    $tid=$sql_row['ref_id']; 
     
    $status=1; //Not Failed 
    $sql="select disp_note_ref FROM bai_pro3.bai_ship_cts_ref WHERE ship_schedule='$schedule'"; 
    $sql_result1=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
    if(mysqli_num_rows($sql_result1)>0) 
    { 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $disp_note_ref=$sql_row1['disp_note_ref']; 
        } 
                 
        $sql="select exit_date FROM bai_pro3.disp_db WHERE disp_note_no in($disp_note_ref) and status<3"; 
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
     
    if($status==1) 
    { 
        $remarks=array(); 
        $sql="select remarks FROM bai_pro4.week_delivery_plan WHERE ref_id=$tid"; 
        $sql_result1=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $remarks=explode("^",$sql_row1['remarks']); 
        } 
        $total_sch_count++; 
        if(strtoupper($remarks[0])=="HOLD") 
        { 
            $hold_sch++; 
             
            if(strtoupper(substr($style,0,1))=="M") 
            { 
                $hold_mns++; 
            } 
        }     
         
        if(strtoupper(substr($style,0,1))=="M") 
        { 
            $total_mns++; 
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


        
$message.="<table>";
$message.="<tr><th colspan=2>Summary</th><th>M&S</th><th>VS</th><th>Total</th></tr>";
// $sql='SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code';

// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_row=mysqli_fetch_array($sql_result))
// {
//     $buyer_code[]=$sql_row["buyer_div"];
//     $buyer_name[]=$sql_row["buyer_name"];
// }

// $message.="<table>"; 
// $message.="<tr><th colspan=2>Summary</th>";
// for($i=0;$i<sizeof($buyer_name);$i++)
// {
//     $message.="<th>".$buyer_code[$i]."</th>";
// }
// $message.="<th>Total</th></tr>"; 

$message.="<tr><td>On Hold</td><td><td>$hold_mns</td><td>".($hold_sch-$hold_mns)."</td></td><td>$hold_sch</td></tr>"; 
$message.="<tr bgcolor=yellow><td>Failed to send on time</td><td></td><td>".($total_mns-$hold_mns)."</td><td>".(($total_sch_count-$hold_sch)-($total_mns-$hold_mns))."</td><td>".($total_sch_count-$hold_sch)."</td></tr>"; 
$message.="<tr><td>Total Schedules</td><td></td><td>$total_mns</td><td>".($total_sch_count-$total_mns)."</td><td>$total_sch_count</td></tr>"; 
$message.="</table><br/><br/>"; 

$message.=$note; 

$message.='<br/>Message Sent Via: '.$plant_name.'';
$message.="</body></html>"; 

// echo $message;

$to  =$daily_cod_events;
$subject = 'Delivery Failures :'.$yesterday; 

// To send HTML mail, the Content-type header must be set 
$headers  = 'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

// Additional headers 
$headers .= 'To:'.$to. "\r\n"; 
//$headers .= 'To:  <brandixalerts@schemaxtech.com>'. "\r\n"; 
// $headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n"; 
$headers .= $header_from. "\r\n"; 

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
$sql="SELECT style,schedule,color,track_id FROM bai_kpi.delivery_delays_track WHERE ex_fact='$yesterday'"; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $ref_id=$sql_row['track_id']; 
    $style=$sql_row['style']; 
    $schedule=$sql_row['schedule']; 
    $color=$sql_row['color']; 
     
    if($schedule>0 and strlen($style)>0 and strlen($color)>0) 
    { 
        $sql1="SELECT MAX(ims_date) as input, MAX(ims_log_date) as output FROM (SELECT ims_date,ims_log_date FROM bai_pro3.ims_log WHERE ims_schedule=$schedule and trim(both from ims_color)=\"".trim($color)."\" UNION SELECT ims_date,ims_log_date FROM bai_pro3.ims_log_backup WHERE ims_schedule=$schedule and trim(both from ims_color)=\"".trim($color)."\") AS t";
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $input_time=$sql_row1['input']; 
            $output_time=$sql_row1['output']; 
        } 
         
        $sql1="SELECT MAX(lastup) as lastup FROM bai_pro3.packing_summary WHERE order_del_no=$schedule"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $fg_time=$sql_row1['lastup']; 
        } 
         
        $sql1="update bai_kpi.delivery_delays_track set input_time='$input_time',sewing_time='$output_time',fg_time='$fg_time' where track_id=$ref_id"; 
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
