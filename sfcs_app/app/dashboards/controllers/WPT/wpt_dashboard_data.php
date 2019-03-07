<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$url = '/sfcs_app/app/dashboards/controllers/rms/fabric_requisition.php';
$url = base64_encode($url);
$section = $_GET['section'];
$blocks_per_sec = $_GET['blocks'];
/*
foreach($sizes_array as $size){
    $sum.= $size." + ";
    $asum.= "a_".$size." + ";
}
$sum_str = rtrim($sum,' + ');
$asum_str = rtrim($asum,' + ');
*/
$data = '';
$jquery_data = '';
$final_wip = array();
$line_breaker = 0;
if($section > 0){
    $docket_cqty = array();

    //getting all modules against to the section
    $modules_query = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$section GROUP BY section ORDER BY section + 0";
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

            $wip_color = '';
            if($ims_wip == '')
                $ims_wip = 0;
            if($ims_wip <= 216)
                $wip_color = 'gloss-red';
            elseif($ims_wip >= 751)  
                $wip_color = 'gloss-black';
            else
                $wip_color = 'gloss-green';

            if($ims_wip == '')
                $ims_wip = 0;
            else{              
                $data.="<td rowspan=2 class='wip-td'>";    
                $data.="<span class='ims-wip $wip_color'><b>WIP : $ims_wip</b></span>";
                $data.="</td>";
            }

            /*  BLOCK - 2  */
            $module1 = str_replace(".","-",$module);
            $data.="<td rowspan=2 class='wip-td' id='cut-wip-td-$module1'>";
            $data.="    <span class='cut-wip blue'><b>CWIP : <span id='cut-wip-$module1'></span></b></span>";
            $data.="</td>";	
            
            /*  BLOCK - 3 */
            $docs_wip = getCutDoneJobsData($section,$module,$blocks_per_sec,$ims_wip);
            $data.="<td rowspan=1 class='cut-td'>";
            $data.= $docs_wip;
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
$section_data['java_scripts'] = $jquery_data;
echo json_encode($section_data);

?>


<?php
function  getCutDoneJobsData($section,$module,$blocks,$ims_wip){
    global $line_breaker;
    global $sum_str; 
    global $link;
    global $url;
    global $bai_pro3,$brandix_bts;
    global $jquery_data;
    $dockets = array();
    $cutting_op_code = 15;
    $temp_line_breaker = 0;
    $ips_op_code = 0;
    $docs_data = '';
    $break_me_at = 6;
    $cut_wip = 0; 
    //adjusting line breaker
    if($ims_wip == 0){
        $break_me_at = 11;
    }
    $ips_op_code_query = "SELECT operation_code FROM brandix_bts.tbl_ims_ops WHERE appilication = 'IPS'";
    $ips_op_code_result = mysqli_query($link,$ips_op_code_query);
    $ips_op_code = mysqli_fetch_array($link,$ips_op_code_result)['operation_code'];

    $dockets_cqty_query = "SELECT GROUP_CONCAT(distinct pdsi.input_job_no_random) AS jobs,GROUP_CONCAT(distinct pdsi.doc_no AS doc_no),
            acutno,color_code,order_style_no as style,order_col_des as color,order_del_no as schedule,act_cut_status,ft_status
            FROM bai_pro3.plan_dashboard_input pdi
            LEFT JOIN bai_pro3.plan_doc_summ_input pdsi ON pdsi.input_job_no_random = pdi.input_job_no_random_ref
            WHERE input_module = $module 
            AND act_cut_status='DONE' 
            group by input_module";
    $dockets_qty_job_qty_query = "SELECT GROUP_CONCAT(distinct pdsi.input_job_no_random) AS jobs,pdsi.doc_no AS doc_no,
            acutno,a_plies,p_plies,color_code,order_style_no as style,order_col_des as color,order_del_no as schedule,act_cut_status,ft_status
            FROM bai_pro3.plan_dashboard_input pdi
            LEFT JOIN bai_pro3.plan_doc_summ_input pdsi ON pdsi.input_job_no_random = pdi.input_job_no_random_ref
            WHERE input_module = $module 
            AND ( (a_plies = p_plies and act_cut_status='') OR (a_plies < p_plies AND act_cut_status='DONE') ) 
            group by doc_no order by input_priority ASC";   
    /*             
    $partial_dockets_query  = "SELECT GROUP_CONCAT(distinct psi.input_job_no_random) AS jobs,pds.order_style_no as style,
            pds.order_col_des as color,pds.doc_no as doc_no,pds.acutno as acutno,pds.color_code,
            pds.order_del_no as schedule,fabric_status,ft_status
            from $bai_pro3.plan_dash_doc_summ pds
            LEFT JOIN $bai_pro3.pac_stat_log_input_job psi ON pds.doc_no = psi.doc_no
            where module = $module  
            and pds.a_plies != pds.p_plies and act_cut_status = 'DONE' 
            group by doc_no order by priority";
    $nfull_dockets_query = "SELECT  GROUP_CONCAT(distinct psi.input_job_no_random) AS jobs,order_style_no as style,
            order_col_des as color,pds.doc_no as doc_no,acutno as acutno,
            color_code,order_del_no as schedule,fabric_status,ft_status 
            from $bai_pro3.plan_dash_doc_summ pds
            LEFT JOIN $bai_pro3.pac_stat_log_input_job psi ON pds.doc_no = psi.doc_no
            where module = $module and  act_cut_status = '' 
            group by doc_no order by priority";  
    */
    $dockets_cqty_result        = mysqli_query($link,$dockets_cqty_query);
    $dockets_qty_job_qty_result = mysqli_query($link,$dockets_qty_job_qty_query);
    //$partial_dockets_result = mysqli_query($link,$partial_dockets_query) or exit($data.='Problem in c-partial docs');
    //$nfull_dockets_result   = mysqli_query($link,$nfull_dockets_query)   or exit($data.='Problem in empty dockets');

    $dockets_result_array = array();
    $dockets_result_array = [$dockets_cqty_result,$dockets_qty_job_qty_result];
    foreach($dockets_result_array as $order=>$dockets_result){  
        if($cut_wip == 0 && $ims_wip == 0)
            $break_me_at = 13;
        else if($cut_wip == 0)   
            $break_me_at = 10; 
        else 
            $break_me_at = 6;       

        while($row = mysqli_fetch_assoc($dockets_result)){     
            $style   = $row['style']; 
            $schedule= $row['schedule'];
            $color   = $row['color'];
            $doc_no  = $row['doc_no'];   
            $color_code= $row['color_code']; 
            $cut_no  = $row['acutno'];
            $cut_str = chr($color_code).'0'.$cut_no;
            $jobs    = $row['jobs'];
            $cut_status    = $row['act_cut_status'];
            $fabric_status = $row['fabric_status'];
            $ft_status     = $row['ft_status'];
            $aplies = $row['a_plies'];
            $pplies = $row['p_plies'];

            // if($order == 1){
            //     $dockets[] = $doc_no;
            // }
            // if($order > 1){
            //     if(in_array($doc_no,$dockets))
            //         continue;
            // }
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
                            where doc_no IN ($doc_no) and operation_code = $cutting_op_code ";
            $cut_qty_result = mysqli_query($link,$cut_qty_query);
            
            $scanned_qty_query = "SELECT SUM(recevied_qty+rejected_qty-(replace_in+recut_in)) as scan_qty 
                            from $brandix_bts.bundle_creation_data  where input_job_no_random IN ($jobs) and operation_id = $ips_op_code";
            $scanned_qty_result = mysqli_query($link,$scanned_qty_query); 
            
            $cut_report_query = "SELECT SUM(recevied_qty) as rep_qty from 
                                $brandix_bts.bundle_creation_data 
                                where docket_number IN ($doc_no) and  operation_id = $cutting_op_code";
            $cut_report_result = mysqli_query($link,$cut_report_query);
            
            $jrow  = mysqli_fetch_array($job_qty_result);
            $crow  = mysqli_fetch_array($cut_qty_result);
            $crrow = mysqli_fetch_array($cut_report_result);
            $scrow = mysqli_fetch_array($scanned_qty_result);
            
            $job_qty  = $jrow['job_qty'];
            $scan_qty = $scrow['scan_qty'];
            $cut_rep_qty = $crrow['rep_qty'];
            $doc_qty = $crow['cut_qty'];
            $rem_qty = $crow['rem_qty'];
            $plan_qty= $crrow['plan_qty'];
            $status_color = '';
            
            if($order == 0){
                //$cut_wip += $job_qty;
                $cut_wip = $cut_rep_qty - $scan_qty;
                if($cut_wip < 0)
                    $cut_wip = 0;
                else if($cut_wip > $job_qty)
                    $cut_wip = $job_qty;
                continue;
            }

            if($order == 1){
                if($aplies < $pplies && $cut_status == 'DONE'){
                    $status_color = 'orange';
                }else if($order == 1 || $order == 3){
                    if($cut_status == '') $cut_status = 0; else $cut_status = 5;

                    $fabric_status_query="select * from $bai_pro3.plandoc_stat_log where fabric_status<>'5' 
                                        and doc_no in ($doc_no)";
                    $fabric_status_query_result  =mysqli_query($link, $fabric_status_query) or exit($docs_data.='Fabric Status error');
                    if(mysqli_num_rows($fabric_status_query_result) > 0) $fabric_status = 0; else $fabric_status = 5;
                    
                    $fabric_query ="select * from $bai_pro3.plan_dashboard where fabric_status='1' and doc_no in ($doc_no)";
                    $fabric_result=mysqli_query($link, $fabric_query) or exit($docs_data.='Fabric Status Error');
                    if(mysqli_num_rows($fabric_result)>0)
                        $fabric_status = 1;
                                                
                    $priorities_query="select * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no)";
                    $priorities_result=mysqli_query($link, $priorities_query) or exit($docs_data.='Fabric Priorities Error');
                    if(mysqli_num_rows($priorities_result)>0) $fabric_req = 5;	else $fabric_req = 0;
            
                    if($cut_status == 5)
                        $status_color = 'blue';
                    elseif($fabric_status == 5)
                        $status_color = 'yellow';
                    elseif($fabric_status == 1)    
                        $status_color = 'pink';
                    elseif($fabric_req == 5)
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
                    }else{
                        $status_color = 'yash';
                    }

                    if($status_color == 'yellow' || $status_color == 'blue'){
                        if( ($plan_qty > $cut_rep_qty ) && $cut_rep_qty != 0){
                            $status_color='orange';
                        }
                    }

                }else if($order == 2){
                    $status_color = 'orange';
                }
            


                $line_breaker++;
                $temp_line_breaker++; //remove for 4,8 divisions
                if(($line_breaker-1) == $blocks)
                    goto enough;
                if($blocks <= 8){
                    if($line_breaker == $break_me_at){
                        $docs_data.='&nbsp;<br/>';
                    }
                }else if($blocks > 8){
                    if($temp_line_breaker == $break_me_at){
                        $temp_line_breaker = 1; //remove for 4,8 divisions
                        $docs_data.='&nbsp;<br/>';
                    }  
                }  
            

                $tool_tip_text = "<p style=\"width : 500px\">
                                    <v><c>Style</c> : $style</v><v><c>Schedule No</c> : $schedule</v>
                                    <v><c>Colors</c> : $color</v><v><c>Doc no</c> : $doc_no</v>
                                    <v><c>Cut No : </c> $cut_str</v>
                                    <v><c>Docket Qty : </c>$doc_qty</v>
                                    <v><c>Sewing  Job Qty</c> : $job_qty</v>
                                    <v><c>Cut Remaining Qty </c>: $rem_qty</v>
                                </p>";
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
    $module1 = str_replace(".","-",$module);
    if($cut_wip == 0 || $cut_wip == '')
        $jquery_data.= "<script>$('#cut-wip-td-$module1').remove()</script>"; 
    else
        $jquery_data.= "<script>$('#cut-wip-$module1').html('$cut_wip')</script>"; 

    return $docs_data; 
}

