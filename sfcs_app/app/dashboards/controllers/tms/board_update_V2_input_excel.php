<?php
    // include (getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    // include (getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include ("../../../../common/config/config.php");
    include ("../../../../common/config/functions.php");
    ?>
    <style>
    table, th, td {
    border: 1px solid black;
    }
    th{
        background-color: #7488c1;
        color: white;
    }
    </style>
    <?php
 if(isset($_POST['export_excel'])){
    $section=$_POST["section"];

    $report_data_ary = array();
    $sql2x="select * from $bai_pro3.trims_dashboard where section=$section";
    //and DATE(plan_time)>=\"2013-01-09\"
    // echo $sql2x;
    $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
    $i=0;

    while($row2x=mysqli_fetch_array($result2x))
    {
        $doc_no=$row2x["doc_ref"];
        $sql11x="select order_tid,acutno from $bai_pro3.plandoc_stat_log where doc_no=\"".$doc_no."\"";
        // echo $sql11x;
        $sql_result11x=mysqli_query($link, $sql11x) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row11x=mysqli_fetch_array($sql_result11x))
        {
            $order_tidx=$row11x["order_tid"];
            $cut_nosx=$row11x["acutno"];
        }
        $sql21x="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tidx."\"";
        // echo $sql21x;

        $sql_result21x=mysqli_query($link, $sql21x) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row21x=mysqli_fetch_array($sql_result21x))
        {
            $stylex=$row21x["order_style_no"];
            $schedulex=$row21x["order_del_no"];
            $colorx=$row21x["order_col_des"];
            $buyerx=$row21x["order_div"];
            $color_codex=$row21x["color_code"];
        }
        
        $zeros="00";
        
        if($cut_nosx > 9)
        {
            $zeros="0";
        }
        $report_data_ary[$i]['style']=$stylex;
        $report_data_ary[$i]['schedule'] = $schedulex;
        $report_data_ary[$i]['color']=$colorx;
        $report_data_ary[$i]['docket'] = $doc_no;
        $report_data_ary[$i]['job_no'] = chr($color_codex).$zeros.$cut_nosx;
        $report_data_ary[$i]['req_time']=$row2x["trims_req_time"];
        $report_data_ary[$i]['issue_time']=$row2x["trims_issued_time"];
        $trims_status="";	
        
        if($status == 0)
        {
            $trims_status="Trims Applied";
        }
        
        if($status == 1)
        {
            $trims_status="Stock In Pool";
        }
        
        if($status == 2)
        {
            $trims_status="Trims Issued";
        }
        
        if($row2x["trims_req_time"] == "0000-00-00 00:00:00")
        {
            $trims_status="Need To Apply For Trims";
        }
        $report_data_ary[$i]['tstatus'] = $trims_status;
    }
    // var_dump($report_data_ary);
    $output = '';
    if(sizeof($report_data_ary)>0){
        
        $output.=' <body style="border: 1px solid #ccc"><table ><th colspan="8">Job Plan Details</th><tr><th>Style</th><th>Schedule</th><th>Color</th><th>Docket Number</th><th>Job Number</th><th>Request Time</th><th>Issue Time</th><th>status</th>';
        foreach($report_data_ary as $report){

            $output.='<tr><td>'.$report['style'].'</td><td>'.$report['schedule'].'</td><td>'.$report['color'].'</td><td>'.$report['docket'].'</td><td>'.$report['job_no'].'</td><td>'.$report['req_time'].'</td><td>'.$report['issue_time'].'</td><td>'.$report['tstatus'].'</td></tr>';

        }
        $output.='</table></body>';
        header("Content-Type: application/xls");
        // header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: attachment; filename= Job Loading plan.xls ");
        echo $output;
    }else{
        $url = "board_update_V2_input.php?section_no=".$section;
        echo"<script>
            alert('No Data to Download for selected Section:".$section."');
            window.location = '".$url."';
        </script>";
    }



}
?>