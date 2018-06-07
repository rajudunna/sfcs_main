<?php 

$start_timestamp = microtime(true);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');

?> 
<?php  
function leading_zeros($value, $places){

    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    return $output;
}

//TEMP Table 

//include("packing_dashboard_prepare.php"); //AUTO 
//NEW ADD 2011-07-14 
$sql1="truncate bai_pro3.packing_dashboard_alert_temp"; 
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql1="insert into bai_pro3.packing_dashboard_alert_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from bai_pro3.packing_dashboard";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 


?> 

<?php 

$message='<html> 
<head> 



<style type="text/css"> 
body 
{ 
    background-color: WHITE; 
    font-size: 10pt; 
    color: BLACK; 
    font-style: normal; 
    font-family: Trebuchet MS; 
    text-decoration: none; 
} 

th 
{ 
    color: black; 
border: 1px solid #660000; 
    padding: 5px; 
white-space:nowrap;  

} 

td 
{ 
    background-color: WHITE; 
    color: BLACK; 
border: 1px solid #660000; 
    padding: 1px; 
white-space:nowrap;  
} 



table 
{ 
border-collapse:collapse; 
white-space:nowrap;  
} 


</style> 





</head> 
<body>'; 
?> 
<?php 
$message.= "Dear All, <br/>Please find below Carton Scanning Issues and Carton Pending Summary details. Your quick action is highly appreciated."; 


/* 
$message.="<h2>Carton Scanning Issues</h2>"; 
$message.= "<table>"; 
$message.= "<tr><th>Module</th><th>Style</th><th>Schedule</th><th>Color</th><th>Job</th><th>Carton ID</th><th>Size</th><th>Carton Qty</th></tr>"; 

        $sql1="SELECT * FROM packing_issues order by ims_mod_no"; 
        $sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error()); 
        while($sql_row1=mysql_fetch_array($sql_result1)) 
        { 
            $sqlx="select acutno,color_code from live_pro_table_ref2 where doc_no=".$sql_row1['doc_no']; 
            $sql_resultx=mysql_query($sqlx,$link) or exit("Sql Error".mysql_error()); 
            while($sql_rowx=mysql_fetch_array($sql_resultx)) 
            { 
                $job=chr($sql_rowx['color_code']).leading_zeros($sql_rowx['acutno'],3); 
            } 
            $message.= "<tr><td>$sql_row1[ims_mod_no]</td><td>$sql_row1[ims_style]</td><td>$sql_row1[ims_schedule]</td><td>$sql_row1[ims_color]</td><td>$job</td><td>$sql_row1[tid]</td><td>$sql_row1[size_code]</td><td>$sql_row1[carton_act_qty]</td></tr>"; 
            $message.= "</tr>"; 

        } 
$message.= "</table>"; 
*/ 
?> 

<?php 
$message.= "<h2>Section Wise Carton Pending List</h2>"; 
$message.= "<table>"; 
$message.= "<tr><th>Point Person</th><th>Section</th><th>Pending</th><th>Remarks</th></tr>"; 

$embl_dels=array(); 
//to track emblishment schedules 
$sqlx="select distinct order_del_no as \"order_del_no\" from bai_pro3.bai_orders_db where (order_embl_a+order_embl_b+order_embl_c+order_embl_d+order_embl_e+order_embl_f+order_embl_g+order_embl_h)>0 and order_del_no<>\"\""; 
// echo $sqlx; 
//$sqlx="SELECT group_concat(DISTINCT schedule_no) as \"order_del_no\" FROM bai_pro4.shipment_plan_ref WHERE ship_tid IN (SELECT shipment_plan_id FROM bai_pro4.week_delivery_plan WHERE rev_emb_status<>\"\")"; 
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
{ 
    $embl_dels[]=$sql_rowx['order_del_no']; 
} 
//to track emblishment schedules 


$packing_team_heads=array("","","Ramakrishna","","Divya Mohan"); 
$packing_team_heads_rows=array("","","2","","2"); 
$i=2; 
$sec_db_order=array(1,2,3,4,5); 

for($j=0; $j<sizeof($sec_db_order); $j++) 
{ 

$sqlx="select * from bai_pro3.sections_db where sec_id=".$sec_db_order[$j]; 
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
{ 
    $section=$sql_rowx['sec_id']; 
    $section_head=$sql_rowx['sec_head']; 
    $section_mods=$sql_rowx['sec_mods']; 
     
     
    if(sizeof($section_mods)>0) 
    { 
        $y=0; 
        $sql1="SELECT * FROM bai_pro3.packing_dashboard_alert_temp WHERE ims_mod_no in ($section_mods) ORDER BY lastup"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_num_check=mysqli_num_rows($sql_result1); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
                     
            $ims_doc_no=$sql_row1['doc_no']; 
            $ims_size=$sql_row1['size_code']; 
            $ims_tid_qty=$sql_row1['carton_act_qty']; 
             
            //$sqla="select sum(bac_qty) as qty from bai_pro.bai_log_buf where ims_doc_no=$ims_doc_no and size_$ims_size > 0"; 
            $sqla="select sum(ims_pro_qty) as qty from bai_pro3.ims_log where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
            $sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowa=mysqli_fetch_array($sql_resulta)) 
            { 
                $output_qty=$sql_rowa["qty"];     
            } 
             
            $sqla1="select sum(ims_pro_qty) as qty from bai_pro3.ims_log_backup where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
            //echo $sqla1; 
			$sql_resulta1=mysqli_query($link, $sqla1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowa1=mysqli_fetch_array($sql_resulta1)) 
            { 
                $output_qty1=$sql_rowa1["qty"];     
            } 
             
            $sqlb="select sum(carton_act_qty) as qty from bai_pro3.pac_stat_log where doc_no=$ims_doc_no and size_code=\"".$ims_size."\" and status=\"DONE\""; 
			$sql_resultb=mysqli_query($link, $sqlb) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowb=mysqli_fetch_array($sql_resultb)) 
            { 
                $packing_qty=$sql_rowb["qty"];     
            } 
             
            if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty) 
            { 
                $y=$y+1; 
            } 
        }     
         
        $embl_carts=0; 
        $sql11="SELECT * FROM bai_pro3.packing_dashboard_alert_temp WHERE ims_mod_no in ($section_mods) and ims_schedule in (".implode(",",$embl_dels).") ORDER BY lastup"; 
        $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        //$embl_carts=mysql_num_rows($sql_result11); 
        while($sql_row11=mysqli_fetch_array($sql_result11)) 
        { 
                     
            $ims_doc_no1=$sql_row11['doc_no']; 
            $ims_size1=$sql_row11['size_code']; 
            $ims_tid_qty1=$sql_row1['carton_act_qty']; 
             
            //$sqla="select sum(bac_qty) as qty from bai_pro.bai_log_buf where ims_doc_no=$ims_doc_no and size_$ims_size > 0"; 
            $sqla="select sum(ims_pro_qty) as qty from bai_pro3.ims_log where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
            $sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowa=mysqli_fetch_array($sql_resulta)) 
            { 
                $output_qty2=$sql_rowa["qty"];     
            } 
             
            $sqla1="select sum(ims_pro_qty) as qty from bai_pro3.ims_log_backup where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
            //echo $sqla1; 
            $sql_resulta1=mysqli_query($link, $sqla1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowa1=mysqli_fetch_array($sql_resulta1)) 
            { 
                $output_qty12=$sql_rowa1["qty"];     
            } 
             
            $sqlb="select sum(carton_act_qty) as qty from bai_pro3.pac_stat_log where doc_no=$ims_doc_no and size_code=\"".$ims_size."\" and status=\"DONE\""; 
            $sql_resultb=mysqli_query($link, $sqlb) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowb=mysqli_fetch_array($sql_resultb)) 
            { 
                $packing_qty2=$sql_rowb["qty"];     
            } 
             
            if((($output_qty2+$output_qty12)-$packing_qty2) >= $ims_tid_qty1) 
            { 
                $embl_carts=$embl_carts+1; 
            } 
        }     
         
        /*if($i<6) 
        { 
            if($i%2==0) 
            { 
                $message.= "<tr><td rowspan=2>".$packing_team_heads[$i]."</td><td>".$section."</td><td>$y</td><td>$embl_carts</td>"; 
                $i++; 
            } 
            else 
            { 
                $message.= "<tr><td>$section</td><td>$y</td><td>$embl_carts</td>"; 
                $i++; 
            } 
        } 
        else 
        { 
            if($i%3==0) 
            { 
                $message.= "<tr><td rowspan=3>".$packing_team_heads[$i]."</td><td>$section</td><td>$y</td><td>$embl_carts</td>"; 
                $i++; 
            } 
            else 
            { 
                $message.= "<tr><td>$section</td><td>$y</td><td>$embl_carts</td>"; 
                $i++; 
            }     
        }*/ 
        if($i%2==0) 
        { 
            $message.= "<tr><td rowspan=".$packing_team_heads_rows[$i].">".$packing_team_heads[$i]."</td><td>".$section."</td><td>$y</td><td>$embl_carts</td>"; 
            $i++; 
        } 
        else 
        { 
            $message.= "<tr><td>$section</td><td>$y</td><td>$embl_carts</td>"; 
            $i++; 
        }     
     
        $message.= "</tr>"; 
        $y=0; 
    } 
} 
     
} 
$message.= "</table><br/><br/>Message Sent Via: http://beknet</body> 
</html>"; 
// echo $message; 

     $to  =$pop_pending_list_mail; 
     
    // subject 
    $subject = 'Alert - Carton Issues'; 
     
    // To send HTML mail, the Content-type header must be set 
    $headers  = 'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
     
   
    $headers .= $header_from. "\r\n"; 
	
	
     
    // Mail it 
    if(mail($to, $subject, $message, $headers)) 
    { 
        print("mail sent successfully")."\n"; 
    } 
     
    //MAIL 

    $end_timestamp = microtime(true);
    $duration = $end_timestamp - $start_timestamp;
    print("Execution took ".$duration." milliseconds.")."\n";
?>