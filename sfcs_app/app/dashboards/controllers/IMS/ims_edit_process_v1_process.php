<?php
error_reporting(0);
 include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); ?> 


<?php 
if(isset($_POST['Update'])) 
{ 
    $tid=$_POST['tid']; 
    $mod=$_POST['mod']; 
    $allow_qty=$_POST['allow_qty']; 
    $qty=$_POST['qty']; 
    $current_mod=$_POST['current_mod']; 
    $remarks=$_POST['remarks']; 
    $time=$_POST['time']; 

    if($qty>0 and $qty==$allow_qty and $current_mod!=$mod and $mod!=0 and $mod>0) //ERROR CORRECTION 2011 
    { 

    $sql33="insert ignore into $bai_pro3.ims_log_bc (tid, ims_mod_no) select tid, ims_mod_no from ims_log where tid=$tid"; 
    mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
     
    $sql33="update $bai_pro3.ims_log set ims_mod_no=$mod where tid=$tid"; 
    mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
     
    $sql33="update $bai_pro3.ims_log_backup set ims_mod_no=$mod where tid=$tid"; 
    mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
     
    } 
    else 
    { 
        if($qty>0 and $qty<$allow_qty and $current_mod!=$mod and $mod!=0 and $mod>0) //ERROR CORRECTION 2011 
        { 
            $date=date("Y-m-d"); 
           // $rand_track=rand(1, 1000000)+date("isu"); 
             
            $sql="select ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_style, ims_schedule, ims_color, ims_size,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,operation_id,rand_track from $bai_pro3.ims_log where tid=$tid"; 
            mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row=mysqli_fetch_array($sql_result)) 
            { 
                $sql33="insert into $bai_pro3.ims_log (ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_style, ims_schedule, ims_color, ims_date, ims_qty, ims_remarks, ims_size,bai_pro_ref,input_job_rand_no_ref,input_job_no_ref,pac_tid,operation_id,rand_track) values (".$sql_row['ims_cid'].", ".$sql_row['ims_doc_no'].", ".$mod.", \"".$sql_row['ims_shift']."\", \"".$sql_row['ims_style']."\", ".$sql_row['ims_schedule'].", \"".$sql_row['ims_color']."\",  \"$date\", $qty, \"$remarks\",\"".$sql_row['ims_size']."\",\"".$sql_row['bai_pro_ref']."\",\"".$sql_row['input_job_rand_no_ref']."\",\"".$sql_row['input_job_no_ref']."\",\"".$sql_row['pac_tid']."\",\"".$sql_row['operation_id']."\",\"".$sql_row['rand_track']."\")";
//echo $sql33; 
                 mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            } 
             
            /*$sql33="insert into ims_log (ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_style, ims_schedule, ims_color, rand_track, ims_date, ims_qty, ims_remarks) values (select ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_style, ims_schedule, ims_color, \"$rand_track\", \"$date\", $qty, \"$remarks\"  from ims_log where tid=$tid)"; 
echo $sql33; 
            mysql_query($sql33,$link) or exit("Sql Error".mysql_error()); */ 
             
            $sql="select * from $bai_pro3.ims_log where tid=$tid"; 
            mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row=mysqli_fetch_array($sql_result)) 
            { 
                $ims_qty=$sql_row['ims_qty']; 
                $produced=$sql_row['ims_pro_qty']; 
            } 
             
            $new_qty=$ims_qty-$qty; 
            $sql33="update $bai_pro3.ims_log set ims_qty=$new_qty where tid=$tid"; 
            mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
             
            if($new_qty==$produced) 
            { 
                $sql33="update $bai_pro3.ims_log set ims_status=\"DONE\" where tid=$tid"; 
                mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            } 
        } 
    } 
     
    //echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"transaction_log.php\"; }</script>"; 
    echo "<script type=\"text/javascript\"> window.close(); </script>"; 
} 


if(isset($_POST['request'])) 
{ 

$date=$_POST['date']; 
$rem=$_POST['rem']; 
$tid=$_POST['tid']; 
$module=$_POST['module']; 

if(strlen($date>0) and strlen($rem)>0) 
{ 
    $sql="select rand_track from $bai_pro3.ims_log where tid=$tid"; 
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $rand_track=$sql_row['rand_track']; 
    } 
     
    $sql="select * from $bai_pro3.ims_exceptions where ims_rand_track=\"$rand_track\""; 
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $count=mysqli_num_rows($sql_result); 
     
    if($count>0) 
    { 
        echo "<strong>You have entered wrong information.</strong>"; 
        echo "<script type=\"text/javascript\"> window.close(); </script>"; 
    } 
    else 
    { 
        $sql="insert into $bai_pro3.ims_exceptions(ims_tid, ims_rand_track,req_date,req_remarks,module) values ($tid,\"$rand_track\",\"$date $time:00:00\",\"$rem\",$module)"; 
        mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
         
        // echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"../ims/ims.php?module=$module\"; }</script>"; 
    } 
     
         
} 
else 
{ 
        echo "<strong>You have entered wrong information.</strong>"; 
        echo "<script type=\"text/javascript\"> window.close(); </script>"; 
} 
     
} 

?> 