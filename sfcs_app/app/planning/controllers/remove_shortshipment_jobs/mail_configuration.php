
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R'))

?>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$exists =0;
$sno=1;
var_dump($style);
var_dump($schedule);

$is_style_schedule_exists = "select * from $bai_pro3.short_shipment_job_track where style='".$style."' and schedule='".$schedule."'";
$is_style_schedule_exists_res=mysqli_query($link, $is_style_schedule_exists) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_rowx=mysqli_fetch_array($is_style_schedule_exists_res))
{
    $exists =1;
    $date_time ="'".$sql_rowx['date_time']."'";
}
if($exists==1){

    $subject ='Dear All, <br><br>Short Shipment for Schedule - '.$schedule.' is done on '.$date_time;
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $message = '<html><body>';
    $message .= '<table border=1><tr><th>S No.</th><th>Input Job Number</th><th>Docket Number</th></tr>';
    $sql_ref_nums="select distinct(input_job_no_random) as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
    var_dump($sql_ref_nums);
    $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_rows=mysqli_fetch_array($sql_doc_nums_res))
    {
        $message = '<tr>';
        $message .= '<td>'.$sno.'</td>';
        $message .= '<td>'.$sql_rows['job_numbers'].'</td>';
        $message .= '<td>'.$sql_rows['doc_numbers'].'</td>';
        $message = '</tr>';
        $sno=$sno+1;
    }

    $message.= '</table>';
    $message.= '</body></html>';
    var_dump($message);

    die();

    $message.= "".$schedule.".<br><br>";
    $to ='mounisri38@gmail.com,mounikapentakota30@gmail.com';
    if(mail($to,$subject,$message,$headers))
    {
        echo "mail sent successfully";
    }
    else
    {
        echo "mail failed";
    }
}


?>