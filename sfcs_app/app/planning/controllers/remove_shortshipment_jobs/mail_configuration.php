
<?php
var_dump($_SERVER['DOCUMENT_ROOT']);
var_dump($_GET['r']);
var_dump(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));

// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R'))

?>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$exists =0;
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
    $message .= '<table border=1>';
    $sql_ref_nums="select distinct(input_job_no_random) as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
    $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_ref_nums_res);
    if($sql_num_check > 0) {
        $message .= '<tr><th>Input Job Number</th></tr>';
        
        while($sql_rows=mysqli_fetch_array($sql_ref_nums_res))
        {
            $message = '<tr>';
            $message .= '<td>'.$sql_rows['job_numbers'].'</td>';
            $message = '</tr>';
        }
    }
    $sql_dco_nums="select distinct(doc_no) as doc_nos from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
    $sql_dco_nums_res=mysqli_query($link, $sql_dco_nums) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check1=mysqli_num_rows($sql_dco_nums_res);
    if($sql_num_check > 0) {
        $message .= '<tr><th>Docket Numbers</th></tr>';
    
        while($sql_rows1=mysqli_fetch_array($sql_doc_nums_res))
        {
            $message = '<tr>';
            $message .= '<td>'.$sql_rows['doc_nos'].'</td>';
            $message = '</tr>';
        }
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