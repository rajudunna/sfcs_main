<?php

$is_style_schedule_exists = "select * from $bai_pro3.short_shipment_job_track where style='".$style."' and schedule='".$schedule."'";
$is_style_schedule_exists_res=mysqli_query($link, $is_style_schedule_exists) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_rowx=mysqli_fetch_array($is_style_schedule_exists_res))
{
    $exists =1;
    $date_time ="'".$sql_rowx['date_time']."'";
}

if($exists==1){

    $subject ='Short Shipment Details';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: ".$header_name." <".$header_mail.">". "\r\n";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $message = '<html><head>
    <style type=\"text/css\">

    body
    {
        font-family: arial;
        font-size:14px;
        color:black;
    }
    table
    {
        border-collapse:collapse;
        white-space:nowrap; 
    }
    th
    {
        background-color: CornflowerBlue;
        color: black;
        border: 1px solid #660000; 
        white-space:nowrap; 
        padding-left: 10px;
        padding-right: 10px;
        }

    td
    {
        background-color: WHITE;
        color: BLACK;
        border: 1px solid #660000; 
        padding: 1px;
        white-space:nowrap; 
        text-align:right;
    }

    .highlight td
    {
        background-color: green;
        color: BLACK;
        border: 1px solid #660000; 
        padding: 1px;
        white-space:nowrap; 
        text-align:right;
    }

    </style></head><body>';

    $message .='Dear All, <br><br> &nbsp;&nbsp;&nbsp;&nbsp;Short Shipment for Style - '.$style.' & Schedule - '.$schedule.' is done on '.$date_time;
    
    $sql_ref_nums="select distinct(input_job_no_random) as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
    
    $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num_check=mysqli_num_rows($sql_ref_nums_res);
    if($sql_num_check > 0) {
        $message .= '<table  border=1><tr><th>Input Job Number</th></tr>';
        
        $job_status =1;
        while($sql_rows=mysqli_fetch_array($sql_ref_nums_res))
        {
            $message .= '<tr>';
            $message .= '<td>'.$sql_rows['job_numbers'].'</td>';
            $message .= '</tr>';
        }
        $message .= '</table>';
    }
    $message .= '<br>';
    $order_tid_qry="select order_tid,color_code from $bai_pro3.bai_orders_db where order_style_no = '$style' and order_del_no = '$schedule'";
    $order_tid_res=mysqli_query($link, $order_tid_qry) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_rowr=mysqli_fetch_array($order_tid_res))
    {
        $order_tid=$sql_rowr['order_tid'];
        $color_code=$sql_rowr['color_code'];

        //Get Doc Numbers
        $sql_doc_nums="select doc_no,acutno,remarks from $bai_pro3.plandoc_stat_log where order_tid ='".$order_tid."'";
        $sql_doc_nums_res=mysqli_query($link, $sql_doc_nums) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check1=mysqli_num_rows($sql_doc_nums_res);
        if($sql_num_check1 > 0) {
            $message .= '<table border=1><tr><th>Docket Numbers</th><th>Cut Numbers</th></tr>';
            $doc_status =1;
            while($sql_rows1=mysqli_fetch_array($sql_doc_nums_res))
            {
                $acutno=$sql_rows1['acutno'];
                $remarks=$sql_rows1['remarks'];
                $doc_no=$sql_rows1['doc_no'];


                if($remarks=="Normal")
                {
                    $cut_no=chr($color_code).leading_zeros($acutno,3);
                }else if(strtolower($remarks)=="recut")
                {
                    $cut_no="R".leading_zeros($acutno,3);
                }
                else
                {
                    if($remarks=="Pilot")
                    {
                        $cut_no="Pilot";
                    }
                }

                $message .= '<tr>';
                $message .= '<td>'.$doc_no.'</td>';
                $message .= '<td>'.$cut_no.'</td>';
                $message .= '</tr>';
            }
            $message .= '</table>';
        }
    }

    if($doc_status!=1 && $job_status !=1){
        $message.='<br/>No Input Job Numbers/Docket Numbers are Generated For this Style and Schedule';
    }
    else if($doc_status==1 && $job_status !=1){
        $message.='<br/>Input Job Numbers are not yet Generated';
    }
    else if($doc_status!=1 && $job_status ==1){
        $message.='<br/>Docket Numbers are not yet Generated';
    }

    $message.='<br/>Message Sent Via:'.$plant_name;
    $message.= '</body></html>';

    $to =$short_shipment_mail;
    if(mail($to,$subject,$message,$headers))
    {
        $mail_status=1;
    }
    else
    {
        $mail_status=0;
    }
}


?>