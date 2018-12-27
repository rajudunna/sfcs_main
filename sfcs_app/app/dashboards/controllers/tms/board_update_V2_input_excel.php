
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
        $sqlx1="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=$section";
		$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
		{
			$section_display_name=$sql_rowx1['section_display_name'];
        }

        $report_data_ary = array();
        $sql2x="select module_id from $bai_pro3.plan_modules where section_id=$section";
        $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
        $i=0;
        $mod_ary = array();$dmod_ary = array();
        while($row2x=mysqli_fetch_array($result2x)){

            array_push($mod_ary,$row2x['module_id']);
        }
        $mod = implode(", ",$mod_ary);
        $mod_qry = "SELECT input_job_no_random_ref as input_job_random FROM plan_dashboard_input WHERE 
        input_module IN ($mod)";
        $doc_result=mysqli_query($link, $mod_qry) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row2x=mysqli_fetch_array($doc_result))
            {
                $job_ref_no=$row2x["input_job_random"];
            
			
			   
                $count_qry = "SELECT ps.input_job_no,pd.input_module,ps.order_style_no,ps.order_del_no,ps.order_col_des,ps.acutno,ps.doc_no,pd.input_trims_request_time,pd.log_time,pd.input_trims_status FROM $bai_pro3.packing_summary_input ps, plan_dashboard_input pd where ps.input_job_no_random = pd.input_job_no_random_ref  and pd.input_job_no_random_ref= $job_ref_no group by ps.input_job_no_random ";
                //  echo $count_qry."<br>";
                $doc_result1=mysqli_query($link, $count_qry) ;
                while($jobsresult=mysqli_fetch_array($doc_result1)){
                    $report_data_ary[$i]['style'] = $jobsresult['order_style_no'];
                    $report_data_ary[$i]['schedule'] = $jobsresult['order_del_no'];
                    $report_data_ary[$i]['color']=$jobsresult['order_col_des'];
                    $report_data_ary[$i]['module']=$jobsresult['input_module'];
                    $report_data_ary[$i]['docket'] = $jobsresult['doc_no'];
                    $report_data_ary[$i]['job_no'] = $jobsresult['input_job_no'];;
                    $report_data_ary[$i]['req_time']=$jobsresult["input_trims_request_time"];
                    $report_data_ary[$i]['issue_time']=$jobsresult["log_time"];
                    $status = $jobsresult['input_trims_status'];
                $sql2="SELECT min(st_status) as st_status,order_style_no,order_del_no,input_job_no FROM $temp_pool_db.plan_doc_summ_input_tms_$username WHERE input_job_no_random='$job_ref_no'";	
				$result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($result2))
				{
					$trims_status1=$row2['st_status'];
					$style1=$row2['order_style_no'];
					$schedule1=$row2['order_del_no'];
					$input_job_no1=$row2['input_job_no'];
				}
                    $trims_status="";	
                    
                   
                    
                    if($status == 1)
                    {
                        $trims_status="Preparing Material";
                    }
                    
                    else if($status == 2)
                    {
                        $trims_status="Material ready for Production";
                    }
                    else if($status == 3)
                    {
                        $trims_status="Partially Issued";
                    }
                    else if($status == 4)
					{
						$trims_status="Trims already issue to module"; 
					}
					else
					{
						if($trims_status1=="NULL" || $trims_status1=="" || $trims_status1=="(NULL)")
						{
							$trims_status="Material Status Not Updated in FSP";
						}			
						else if($trims_status1 == 0 || $trims_status1 == 9)
						{
							$trims_status="Material Not Avaiable and Not preparing from W/H";
						}			
						else if($trims_status1 == 1)
						{
							$trims_status="Material Avaiable and Not preparing from W/H";
						}			
						else
						{
							$trims_status="Material Not Avaiable and Not preparing from W/H";
						}
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
        if(sizeof($report_data_ary)>=0){
            
            $output.=' <body style="border: 1px solid #ccc"><table ><th colspan="8">Job Plan Details</th><tr><th>Style</th><th>Schedule</th><th>Color</th><th>Module</th><th>Docket Number</th><th>Job Number</th><th>Request Time</th><th>Issue Time</th><th>status</th>';
            foreach($report_data_ary as $report){
                
                $output.='<tr><td>'.$report['style'].'</td><td>'.$report['schedule'].'</td><td>'.$report['color'].'</td><td>'.$report['module'].'</td><td>'.$report['docket'].'</td><td>'.$report['job_no'].'</td><td>'.$report['req_time'].'</td><td>'.$report['issue_time'].'</td><td>'.$report['tstatus'].'</td></tr>';

            }
            $output.='</table></body>';
            header("Content-Type: application/xls");
            // header("Content-type: application/vnd.ms-excel; name='excel'");
            header("Content-Disposition: attachment; filename= Job Loading plan.xls ");
            echo $output;
        }else{
            $url = "board_update_V2_input.php?section_no=".$section;
            echo"<script>
                alert('No Data to Download for selected Section:".$section_display_name."');
                window.location = '".$url."';
            </script>";
        }
    }
?>