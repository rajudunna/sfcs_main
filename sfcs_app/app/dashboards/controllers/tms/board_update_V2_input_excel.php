<?php
    include ("../../../../common/config/config.php");
    include ("../../../../common/config/functions.php");
//     // Report all PHP errors (see changelog)
// error_reporting(E_ALL);

// // Report all PHP errors
// error_reporting(-1);
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
    $sql2x="select module_id from $bai_pro3.plan_modules where section_id=$section";
    $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
    $i=0;
    $mod_ary = array();$dmod_ary = array();
    while($row2x=mysqli_fetch_array($result2x)){

        array_push($mod_ary,$row2x['module_id']);
    }
    $mod = implode(", ",$mod_ary);
    $mod_qry = "SELECT DISTINCT(input_module)AS input_module FROM plan_dashboard_input WHERE 
    input_module IN ($mod) AND input_trims_status<> 4";
   
    $result_mod=mysqli_query($link, $mod_qry) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row2 = mysqli_fetch_array($result_mod)){
        // $request_time = $row2['input_trims_request_time'];
        array_push($dmod_ary,$row2['input_module']);
    }
    $imp_mod = implode(", ",$dmod_ary);
    if($imp_mod!=''){

        $doc_qry = "SELECT doc_no FROM plandoc_stat_log WHERE plan_module IN($imp_mod)";
        $doc_result =mysqli_query($link, $doc_qry) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
    
        while($row2x=mysqli_fetch_array($doc_result))
        {
            $doc_no=$row2x["doc_no"];
            // echo $doc_no;
            $count_qry = "SELECT ps.input_job_no,ps.order_style_no,ps.order_del_no,ps.order_col_des,ps.acutno,ps.doc_no,
            pd.input_trims_request_time,pd.log_time,pd.input_trims_status
            FROM $bai_pro3.packing_summary_input ps
            LEFT JOIN  plan_dashboard_input pd ON ps.input_job_no_random = pd.input_job_no_random_ref  WHERE ps.doc_no= $doc_no";
            //  echo $count_qry."<br>";

            $doc_result1=mysqli_query($link, $count_qry) ;
            while($jobsresult=mysqli_fetch_array($doc_result1)){
                $report_data_ary[$i]['style'] = $jobsresult['order_style_no'];
                $report_data_ary[$i]['schedule'] = $jobsresult['order_del_no'];
                $report_data_ary[$i]['color']=$jobsresult['order_col_des'];
                $report_data_ary[$i]['docket'] = $jobsresult['doc_no'];
                $report_data_ary[$i]['job_no'] = $jobsresult['input_job_no'];;
                $report_data_ary[$i]['req_time']=$jobsresult["input_trims_request_time"];
                $report_data_ary[$i]['issue_time']=$jobsresult["log_time"];
                $status = $jobsresult['input_trims_status'];

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
                
                if($jobsresult["input_trims_request_time"] == "0000-00-00 00:00:00")
                {
                    $trims_status="Need To Apply For Trims";
                }
                $report_data_ary[$i]['tstatus'] = $trims_status;
                $i++;
            }
            
        
        }
        $output = '';
    if(sizeof($report_data_ary)>0){
        
        $output.=' <body style="border: 1px solid #ccc"><table ><th colspan="8">Job Plan Details</th><tr><th>Style</th><th>Schedule</th><th>Color</th><th>Docket Number</th><th>Job Number</th><th>Request Time</th><th>Issue Time</th><th>status</th>';
        foreach($report_data_ary as $report){
            
            $output.='<tr><td>'.$report['style'].'</td><td>'.$report['schedule'].'</td><td>'.$report['color'].'</td><td>'.$report['docket'].'</td><td>'.$report['job_no'].'</td><td>'.$report['req_time'].'</td><td>'.$report['issue_time'].'</td><td>'.$report['tstatus'].'</td></tr>';
            // var_dump( $report_data_ary[$key] ["order_style_no"] );

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

    }else{
        $url = "board_update_V2_input.php?section_no=".$section;
        echo"<script>
            alert('No Data to Download for selected Section:".$section."');
            window.location = '".$url."';
        </script>";
    }
    
    // var_dump($report_data_ary);
    // die();
    

}
?>