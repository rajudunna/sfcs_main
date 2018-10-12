<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$url = '/sfcs_app/app/dashboards/controllers/rms/fabric_requisition.php';
$url = base64_encode($url);
$section = $_GET['section'];
$blocks_per_sec = $_GET['blocks'];

foreach($sizes_array as $size){
    $sum.= $size." + ";
    $asum.= "a_".$size." + ";
}
$sum_str = rtrim($sum,' + ');
$asum_str = rtrim($asum,' + ');

$data = '';
$final_wip = array();
$line_breaker = 0;
if($section > 0){
    $docket_cqty = array();

    //getting all modules against to the section
    $modules_query = "SELECT sec_mods FROM bai_pro3.sections_db WHERE sec_id = '$section' order by sec_mods";
    $modules_result = mysqli_query($link,$modules_query) or exit($data.="No modules Found");
    while($row = mysqli_fetch_array($modules_result)){
        $modules_str = $row['sec_mods'];
    }
    if($modules_str != ''){
        $data.= "<table><tbody>";
        $moduleso = $modules = explode(',',$modules_str);
       
        foreach($modules as $module){
            $line_breaker = 0;
            $total_wip = 0;
            $docs_wip = '';
            $jobs_wip ='';
            $data.= "<tr rowspan=2>";
            $data.="<td rowspan=2 class='mod-td'><span class='mod-no'><b>$module</b></span></td>";

            /*  BLOCK - 1 */
            //getting the WIP OF module in a section
            $ims_wip_query = "SELECT SUM(ims_qty-ims_pro_qty) AS WIP  from $bai_pro3.ims_log
                              WHERE ims_mod_no='$module' and ims_status<>'DONE' ";
            //echo $ims_wip_query;                  
            $ims_wip_result = mysqli_query($link,$ims_wip_query) or exit($data.='Problem in ims wip');
            while($row = mysqli_fetch_array($ims_wip_result)){
                $ims_wip = $row['WIP'];
                $wip[$module]   = $ims_wip;
                //$module_smv[$module] = $row['SMV'] * $ims_wip;
            }
            if($ims_wip == '')
                $ims_wip = 0;
            else{              
                $data.="<td rowspan=2 class='wip-td'>";    
                $data.="<span class='ims-wip'><b>WIP : $ims_wip</b></span>";
                $data.="</td>";
            }

            /*  BLOCK - 2  */
            $cut_done_wip = getCutDoneJobsData($section,$module,$blocks_per_sec);
            /*
            $jobs_wip.="<td class='wip-td'>
                                <span class='pending-wip'>WIP : <span id='pending-wip-$module'>0</span></span>
                            </td>";
            */
            
            /*  BLOCK - 3 */
            $docs_wip = getCutJobsData($section,$module,$blocks_per_sec);
            
            $data.="<td rowspan=1 class='cut-td'>";
            $data.= $cut_done_wip;
            //$data.= $docs_wip;
            $data.="&nbsp;</td>";

            $data.="</tr>";

        }//modules loop ending
        
    }else{
        //This Section Has No Modules
    }
}else{
    $data = "Section Data Not Found";
}

$data.="</tbody></table>";
$section_data['data'] = $data;
echo json_encode($section_data);

?>


<?php
function  getCutDoneJobsData($section,$module,$blocks){
    global $line_breaker;
    global $sum_str; 
    global $link;
    global $url;
    global $bai_pro3,$brandix_bts;
    $status_color = 'blue';
    $docs_data = '';
    $dockets_query = "";
    $dockets_qty_job_qty_query = "SELECT GROUP_CONCAT(distinct pdsi.input_job_no_random) AS jobs,pdsi.doc_no AS doc_no,
            acutno,color_code,order_style_no as style,order_col_des as color,order_del_no as schedule
            FROM bai_pro3.plan_dashboard_input pdi
            LEFT JOIN bai_pro3.plan_doc_summ_input pdsi ON pdsi.input_job_no_random = pdi.input_job_no_random_ref
            WHERE input_module = $module AND a_plies >= p_plies and act_cut_status = 'DONE'
            GROUP BY pdsi.doc_no";
    $partial_dockets_query  = "SELECT GROUP_CONCAT(distinct psi.input_job_no_random) AS jobs,pds.order_style_no as style,
            pds.order_col_des as color,pds.doc_no as doc_no,pds.acutno as acutno,SUM(($sum_str)) as qty,pds.color_code,
            pds.order_del_no as schedule
            from $bai_pro3.plan_dash_doc_summ pds
            LEFT JOIN $bai_pro3.pac_stat_log_input_job psi ON pds.doc_no = psi.doc_no
            where module = $module and  act_cut_status = 'DONE' 
            and pds.a_plies != pds.p_plies  
            group by doc_no order by priority";
    $nfull_dockets_query = "SELECT  GROUP_CONCAT(distinct psi.input_job_no_random) AS jobs,order_style_no as style,
            order_col_des as color,pds.doc_no as doc_no,acutno as acutno,
            SUM($sum_str) as qty,color_code,order_del_no as schedule,fabric_status_new 
            from $bai_pro3.plan_dash_doc_summ pds
            LEFT JOIN $bai_pro3.pac_stat_log_input_job psi ON pds.doc_no = psi.doc_no
            where module = $module and  act_cut_status = '' 
            group by doc_no order by priority";  

    $dockets_qty_job_qty_result = mysqli_query($link,$dockets_qty_job_qty_query);
    $partial_dockets_result = mysqli_query($link,$partial_dockets_query) or exit($data.='Problem in c-partial docs');
    $nfull_dockets_result   = mysqli_query($link,$nfull_dockets_query)   or exit($data.='Problem in empty dockets');

    $no_fabric_dockets_result_array = array();
    $no_fabric_dockets_result_array = [$dockets_qty_job_qty_result,$partial_dockets_result,$nfull_dockets_result];
    foreach($no_fabric_dockets_result_array as $order=>$dockets_result){               
        while($row = mysqli_fetch_assoc($dockets_result)){     
            $style   = $row['style']; 
            $schedule= $row['schedule'];
            $color   = $row['color'];
            $doc_no  = $row['doc_no'];   
            $color_code= $row['color_code']; 
            $cut_no  = $row['acutno'];
            $cut_str = chr($color_code).'0'.$cut_no;
            $jobs    = $row['jobs'];
            /*
            $job_qty_query = "SELECT SUM(send_qty) as job_qty,SUM(recevied_qty) as scan_qty from $bai_pro3.bundle_creation_data 
                            where input_job_no_random_ref IN ($jobs) and operation_id = 100";
            $job_qty_result = mysqli_query($link,$job_qty_query);
            $jrow = mysqli_fetch_array($job_qty_result);
            */
            $job_qty_query = "SELECT SUM(carton_act_qty) as job_qty from $bai_pro3.pac_stat_log_input_job 
                            where input_job_no_random IN ($jobs)";              
            $job_qty_result = mysqli_query($link,$job_qty_query);  
           
            $cut_qty_query = "SELECT SUM(cut_quantity) as cut_qty,SUM(remaining_qty) as rem_qty from $bai_pro3.cps_log 
                            where doc_no = '$doc_no' and operation_code = 15 ";
            $cut_qty_result = mysqli_query($link,$cut_qty_query);
           
            $jrow = mysqli_fetch_array($job_qty_result);
            $crow =  mysqli_fetch_array($cut_qty_result);
        
            $job_qty = $jrow['job_qty'];
            $scan_qty= $jrow['scan_qty'];
            $doc_qty = $crow['cut_qty'];
            $rem_qty = $crow['rem_qty'];

            // if($order > 0){
            //     $doc_qty = $row['qty'];
            // }
            if($order > 1){
                $tid_query   = "SELECT GROUP_CONCAT(distinct order_tid) as tid from $bai_pro3.plandoc_stat_log 
                                where doc_no IN ('$doc_no')";
                $tids_result = mysqli_query($link,$tid_query) or exit($data.='Problem in Fabric Status'); 
                while($row = mysqli_fetch_array($tids_result)){
                    $tids = $row['tid'];
                }
                $tids == '' ? $tids = '""' : $tids = $tids; 
                $ft_status_query="SELECT min(ft_status) as f_status 
                                from $bai_pro3.bai_orders_db_confirm where order_tid in ('$tids')";
                $ft_status_result = mysqli_query($link,$ft_status_query);
                $row = mysqli_fetch_array($ft_status_result);
                $ft_status = $row['f_status'];
                $fab_status = '';
                $fab_issue_query="SELECT * from $bai_pro3.plandoc_stat_log where fabric_status!=5 
                                and doc_no IN ($doc_no) limit 1";              
                $fab_issue_result = mysqli_query($link,$fab_issue_query);
                mysqli_num_rows($fab_issue_result)>0 ? $fab_status = 0 : $fab_status = 5 ;

                $fab_issue2_query="SELECT * from $bai_pro3.plan_dashboard where fabric_status='1' 
                                and doc_no IN ($doc_no) limit 1";
                $fab_isuue2_result=mysqli_query($link, $fab_issue2_query) or exit($data.='Issue in plan dashboard');
                mysqli_num_rows($fab_isuue2_result)>0 ? $fab_status = 1 : NULL;

                $fab_request_query="SELECT * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no) limit 1";
                $fab_request_result=mysqli_query($link, $fab_request_query) or exit($data.='Issue in fabric priorities');;
                $row_count = mysqli_num_rows($fab_request_result);
                // $fab_status == 5 ? $status_color = 'yellow' : $fab_status == 1 ? $status_color = 'pink' : $row_count > 0 ?$status_color = 'green' : $fabric_status < 5 ? $flag = 1 : $status_color = 'yash'; 
                if($fab_status == 5)
                    $status_color = 'yellow';
                elseif($fab_status == 1)    
                    $status_color = 'pink';
                elseif($row_count > 0)
                    $status_color = 'green';
                elseif($fabric_status < 5){
                    switch($ft_status){
                        case "1":{ $status_color="lgreen"; break; }
                        case "0":{ $status_color="red";    break; }
                        case "2":{ $status_color="red";    break; }
                        case "3":{ $status_color="red";    break; }
                        case "4":{ $status_color="red";    break; }
                        default :{ $status_color="yash";   break; }
                    }
                }else
                    $status_color="yash";
            }else if($order == 1){
                $status_color = 'orange';
            }
        
            $line_breaker++;
            if(($line_breaker-1) == $blocks)
                goto enough;
            if($blocks <= 8){
                if($line_breaker == 5){
                    $docs_data.='<br/>';
                }
            }else if($blocks > 8){
                if($line_breaker == 9){
                    $docs_data.='<br/>';
                }  
            }  
            
            
            $tool_tip_text = "<p style=\"width : 500px\">
                                <v><c>Style</c> : $style</v><v><c>Schedule No</c> : $schedule</v>
                                <v><c>Colors</c> : $color</v><v><c>Doc no</c> : $doc_no</v>
                                <v><c>Cut No : </c> $cut_str</v>
                                <v><c>Docket Qty : </c>$doc_qty</v>
                                <v><c>Sewing  Job Qty</c> : $job_qty</v>
                                <v><c>Cut Reported Qty </c>: $rem_qty</v>
                                <p>";
            if($order == 0){                    
                $docs_data.="<span class='block'>
                                <span class='cut-block $status_color'>
                                    <span class='mytooltip'>
                                        <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                                        data-html='true'>
                                            &nbsp;&nbsp;&nbsp;
                                        </a>
                                    </span>
                                </span>
                            </span>";
            }else{
                $href= "$url&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=$doc_no";

                $docs_data.="<span class='block'>
                            <span class='cut-block $status_color'>
                                <span class='mytooltip'>
                                    <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                                     onclick=\"window.open('index.php?r=$href','yourWindowName','width=800,height=600')\"
                                     data-html='true'>
                                        &nbsp;&nbsp;&nbsp;
                                    </a>
                                </span>
                            </span>
                            </span>";  
            }   
        }  
    }   
    enough : NULL; 
    return $docs_data; 
}

function getCutJobsData($section,$module,$blocks){
    global $line_breaker;
    global $sum_str; 
    global $link;
    global $url;
    global $bai_pro3,$brandix_bts;
    $docs_data = ''; 
    $total_cut_wip = 0;
    $next_row_break = 0;
    $rblocks = $blocks;
    // Total WIP
    /*
    $total_cut_wip_query = "SELECT (SUM($sum_str)) as qty from $bai_pro3.plan_dash_doc_summ 
                             where module = '$module' and  act_cut_status = '' ";
                             
    $total_cut_wip_result = mysqli_query($link,$total_cut_wip_query) or exit($data.='Problem in cut wip');
    //echo $total_wip_query;
    while($row = mysqli_fetch_array($total_cut_wip_result)){
        $row['qty'] != 0 ? $total_cut_wip = $row['qty'] : $total_cut_wip = 0;
        $docs_data.="<td class='wip-td'>
            <span class='cut-wip'>WIP : <span id='cut-wip-$module'></span></span>
        </td>";
    }
    */
   
    //getting all dockets with the partial cut reported quantities
    $partial_dockets_query  = "SELECT order_style_no as style,GROUP_CONCAT(order_col_des) as colors,
                GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
                SUM(($sum_str)) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no
                from $bai_pro3.plan_dash_doc_summ 
                where module = $module and  act_cut_status = 'DONE' 
                and a_plies != p_plies  
                group by doc_no order by acutno";
    // $partial_cdockets_query  = "SELECT order_style_no as style,GROUP_CONCAT(order_col_des) as colors,
    //             GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
    //             SUM(($sum_str)) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no
    //             from $bai_pro3.plan_dash_doc_summ 
    //             where module = $module and  act_cut_status = 'DONE' 
    //             and a_plies != p_plies and  clubbing = '0'
    //             group by doc_no order by acutno";              
                            
    //getting all the dockets with fabric issue status no but planned
    // $nfull_dockets_queryc = "SELECT order_style_no as style,GROUP_CONCAT(order_col_des) as colors,
    //             GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
    //             SUM($sum_str) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no,fabric_status_new 
    //             from $bai_pro3.plan_dash_doc_summ 
    //             where module = $module and  act_cut_status = '' 
    //             and clubbing <> '0'
    //             group by doc_no order by priority";
            
    $nfull_dockets_query = "SELECT order_style_no as style,GROUP_CONCAT(order_col_des) as colors,
                GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
                SUM($sum_str) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no,fabric_status_new 
                from $bai_pro3.plan_dash_doc_summ 
                where module = $module and  act_cut_status = '' 
                group by doc_no order by clubbing,priority";

    $partial_dockets_result = mysqli_query($link,$partial_dockets_query) or exit($data.='Problem in c-partial docs');
    //$partial_cdockets_result= mysqli_query($link,$partial_cdockets_query)or exit($data.='Problem in partial docs');          
    //$nfull_dockets_resultc  = mysqli_query($link,$nfull_dockets_queryc)  or exit($data.='Problem in empty club dockets');
    $nfull_dockets_result   = mysqli_query($link,$nfull_dockets_query)   or exit($data.='Problem in empty dockets');

    $no_fabric_dockets_result_array = array();
    $no_fabric_dockets_result_array = [$partial_dockets_result,$partial_cdockets_result,$nfull_dockets_resultc,$nfull_dockets_result];
    foreach($no_fabric_dockets_result_array as $order=>$dockets_result){
        while($row = mysqli_fetch_array($dockets_result)){
            $doc_no     = $row['doc_no'];
            $doc_qty    = $row['qty'];
            $cut_no     = $row['acutno'];
            $color_code = $row['color_code'];
            $schedule   = $row['order_del_no'];
            $style      = $row['style'];
            $color      = str_replace(',','<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$row['colors']);
            $cut_nos    = explode(',',$cut_no);
            $color_codes= explode(',',$color_code);

            $fabric_status = $row['fabric_status_new'];
            $cut_str = '';
            $status_color = '';
            if(sizeof($cut_nos) > 1){
                foreach($cut_nos as $key=>$value)
                    $cut_str.= chr($color_codes[$key]).'0'.$value.',';
            }else{    
                $cut_str = chr($color_code).''.$cut_no;
            }
            $cut_str = rtrim($cut_str,',');

            //Calculating the rejected qty of the partial dockets and adding it to total cut wip 
            if($order < 2){
                $partial_doc_qty_query = "SELECT SUM(original_qty - (recevied_qty + rejected_qty) ) as qty 
                                from $brandix_bts.bundle_creation_data
                                where docket_number IN ($doc_no) and operation_id = '15' ";
                $partial_doc_qty_result = mysqli_query($link,$partial_doc_qty_query) or 
                                    exit($data.='Problem in partial qty');
                $row = mysqli_fetch_array($partial_doc_qty_result);
                $doc_qty = $row['qty'];  //--temporary comment
                if($doc_qty == '')
                    $doc_qty = 0;
                $total_cut_wip = $total_cut_wip + $doc_qty;
            }
          
            //We need to check the fabric status of these dockets and change colors accordingly
            if($order > 1){
                $tid_query   = "SELECT GROUP_CONCAT(distinct order_tid) as tid from $bai_pro3.plandoc_stat_log 
                                where doc_no IN ('$doc_no')";
                $tids_result = mysqli_query($link,$tid_query) or exit($data.='Problem in Fabric Status'); 
                while($row = mysqli_fetch_array($tids_result)){
                    $tids = $row['tid'];
                }
                $tids == '' ? $tids = '""' : $tids = $tids; 
                $ft_status_query="SELECT min(ft_status) as f_status 
                                  from $bai_pro3.bai_orders_db_confirm where order_tid in ('$tids')";
                $ft_status_result = mysqli_query($link,$ft_status_query);
                $row = mysqli_fetch_array($ft_status_result);
                $ft_status = $row['f_status'];
                $fab_status = '';
                $fab_issue_query="SELECT * from $bai_pro3.plandoc_stat_log where fabric_status!=5 
                                and doc_no IN ($doc_no) limit 1";              
                $fab_issue_result = mysqli_query($link,$fab_issue_query);
                mysqli_num_rows($fab_issue_result)>0 ? $fab_status = 0 : $fab_status = 5 ;

                $fab_issue2_query="SELECT * from $bai_pro3.plan_dashboard where fabric_status='1' 
                                and doc_no IN ($doc_no) limit 1";
                $fab_isuue2_result=mysqli_query($link, $fab_issue2_query) or exit($data.='Issue in plan dashboard');
                mysqli_num_rows($fab_isuue2_result)>0 ? $fab_status = 1 : NULL;

                $fab_request_query="SELECT * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no) limit 1";
                $fab_request_result=mysqli_query($link, $fab_request_query) or exit($data.='Issue in fabric priorities');;
                $row_count = mysqli_num_rows($fab_request_result);
                // $fab_status == 5 ? $status_color = 'yellow' : $fab_status == 1 ? $status_color = 'pink' : $row_count > 0 ?$status_color = 'green' : $fabric_status < 5 ? $flag = 1 : $status_color = 'yash'; 
                if($fab_status == 5)
                    $status_color = 'yellow';
                elseif($fab_status == 1)    
                    $status_color = 'pink';
                elseif($row_count > 0)
                    $status_color = 'green';
                elseif($fabric_status < 5){
                    switch($ft_status){
                        case "1":{ $status_color="lgreen"; break; }
                        case "0":{ $status_color="red";    break; }
                        case "2":{ $status_color="red";    break; }
                        case "3":{ $status_color="red";    break; }
                        case "4":{ $status_color="red";    break; }
                        default :{ $status_color="yash";   break; }
                    }
                }else
                    $status_color="yash";
            }else{
                $status_color = 'orange';
            }
            
            $line_breaker++;
            if($line_breaker > $blocks)
                goto enough;
            if($blocks <= 8){
                if($line_breaker == 5){
                    $docs_data.='&nbsp;<br/>';
                }
            }
            else if($blocks > 8){
                if($line_breaker == 9){
                    $docs_data.='&nbsp;<br/>';
                }   
            } 
            $tool_tip_text = "<p style=\"width : 500px\">
                                <v><c>Style</c> : $style</v><v><c>Schedule No</c> : $schedule</v>
                                <v><c>Colors</c> : $color</v><v><c>Doc no</c> : $doc_no</v>
                                <v><c>Cut no</c> : $cut_str</v><v><c>Qty </c>: $doc_qty</v>
                              <p>";
            $href= "$url&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=$doc_no";

            $docs_data.="<span class='block'>
                        <span class='cut-block $status_color'>
                            <span class='mytooltip'>
                                <a rel='tooltip' data-toggle='tooltip' data-placement='top' data-title='$tool_tip_text'
                                 onclick=\"window.open('index.php?r=$href','yourWindowName','width=800,height=600')\"
                                 data-html='true'>
                                    &nbsp;&nbsp;&nbsp;
                                </a>
                            </span>
                        </span>
                        </span>";           
        }
        $docs_data.= "<script>$('#cut-wip-$module').html('$total_cut_wip')</script>";
    }
    enough : NULL;
    return $docs_data;
}

