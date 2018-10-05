<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

$section = $_GET['section'];

foreach($sizes_array as $size){
    $sum.= $size." + ";
    $asum.= "a_".$size." + ";
}
$sum_str = rtrim($sum,' + ');
$asum_str = rtrim($asum,' + ');
$data = '';
$docs_data = '';
$final_wip = array();
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
            $total_wip = 0;
            $docs_wip = '';
            $jobs_wip ='';
            $data.= "<tr>";
            $data.="<td class='mod-td'><span class='mod-no'><b>$module</b></span></td>";
            $data.="<td class='wip-td'>";

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
            $data.="<span class='ims-wip'>WIP : $ims_wip</span>";
            $data.="</td>";


            /*  BLOCK - 2  */
            $jobs_wip.="<td class='wip-td'>
                                <span class='pending-wip'>WIP : <span id='pending-wip-$module'>0</span></span>
                            </td>";
            /*  BLOCK - 3 */
            $docs_wip = getCutJobsData($module);
           
            $data.= $jobs_wip;
            $data.= $docs_wip;
            $data.="</tr>";
        }//modules loop ending

        /* MAIN CODE FOR BLOCK 2 */
        // //Sorting the modules according to SMV's
        // $new_module_smv = $module_smv;
        // array_multisort($new_module_smv);
        // $new_module_smv = array_unique($new_module_smv);
        // foreach($new_module_smv as $value){
        //     foreach($module_smv as $key => $value1){
        //         if($value == $value1){
        //             $sorted_modules[] = $key;
        //         }
        //     }
        // }

        /* Calcualting middle WIP   */
        //gettingt the op code with IPS
        $ips_id_query = "SELECT operation_code as op_code from $brandix_bts.tbl_ims_ops where appilication = 'IPS' ";
        $ips_id_result = mysqli_query($link,$ips_id_query);
        $row = mysqli_fetch_array($ips_id_result);
        $ips_id = $row['op_code'];
        //$ips_id = 129;

        //getting all planned jobs for all the modules within the sec 
        $all_jobs_query = "SELECT input_job_no_random_ref as job,input_module FROM $bai_pro3.plan_dashboard_input 
                           WHERE input_module IN ($modules_str)"; 
        $all_jobs_result = mysqli_query($link,$all_jobs_query) or exit($data.='Problem in All Jobs');
        while($row = mysqli_fetch_array($all_jobs_result)){
            $input_jobs[] = $row['job'];
            $mod = $row['input_module'];
            $ij_module[$row['job']] = $mod;
            $input_jobs_per_mod[$mod][] = $mod;
        }
        $jobs_str = implode(',',$input_jobs);
    
        if($jobs_str != ''){
            //Getting actual Quantity required per job
            $job_quantity_query = "SELECT SUM(carton_act_qty) as qty,input_job_no_random as job 
                                   from $bai_pro3.pac_stat_log_input_job
                                   where input_job_no_random IN ($jobs_str) group by input_job_no_random";  
            $job_quantity_result = mysqli_query($link,$job_quantity_query) or exit($data.='Total Job Qty Problem');
            while($row = mysqli_fetch_array($job_quantity_result)){
                $job = $row['job'];
                $job_quantity[$job] = $row['qty'];
            }

            //getting the already line in qtys for the planned jobs within the sec
            $linein_qty_job_query = "SELECT SUM(recevied_qty) as line_in_qty,input_job_no_random_ref as job
                                    from $brandix_bts.bundle_creation_data 
                                    where input_job_no_random_ref IN ($jobs_str) and operation_id = '$ips_id'
                                    group by input_job_no_random_ref";
            $linein_qty_job_result = mysqli_query($link,$linein_qty_job_query) or exit($data.=$all_jobs_query.'Problem in Line In Qtys');
            while($row = mysqli_fetch_array($linein_qty_job_result)){
                $job = $row['job'];
                $line_in[$job] = $row['line_in_qty'];
            }
    
            //getting all dockets for planned jobs along with cut reported qtys
            $dockets_query = "SELECT distinct(psl.doc_no) as doc_no,GROUP_CONCAT(distinct input_job_no_random) as jobs,order_tid
                              from $bai_pro3.pac_stat_log_input_job psl
                              Left join $bai_pro3.plandoc_stat_log pd ON pd.doc_no = psl.doc_no  
                              where input_job_no_random IN ($jobs_str) group by psl.doc_no";
                              //and pd.act_cut_status = 'DONE' ";                 
            $docekt_result = mysqli_query($link,$dockets_query) or exit($data.='Problem in getting cut reported dockets');
            while($row = mysqli_fetch_array($docekt_result)){
                
                $all_dockets[]     = $row['doc_no'];
                $doc_no            = $row['doc_no'];
                $jobs_per_docket[$doc_no] = $row['jobs'];

                $order_tid = $row['order_tid'];
                //getting the PRE OP'S CODE  ///////////////////////////////////////////////////////////////////////////
                $style_schedule_query = "SELECT order_del_no,order_style_no,order_col_des from $bai_pro3.bai_orders_db where 
                                         order_tid = '$order_tid' "; 
                $style_schedule_result = mysqli_query($link,$style_schedule_query) or exit($data.='Problem in sty,sch details');
                $row = mysqli_fetch_array($style_schedule_result);                         
                $style   = $row['order_style_no']!= '' ? $style   = $row['order_style_no']: $style = '0';
                $schedule= $row['order_del_no']  != '' ? $schedule= $row['order_del_no']  : $schedule = '0' ;
                $color   = $row['order_col_des'] != '' ? $color   = $row['order_col_des'] : $color = '0' ;

                $previous_op_query = "SELECT operation_code from $brandix_bts.tbl_style_ops_master where style='$style' 
                                      AND color = '$color' AND operation_order < $ips_id 
                                      and operation_code NOT IN  (10,200)
                                      ORDER BY operation_order DESC LIMIT 1";
                $previous_op_result = mysqli_query($link,$previous_op_query) or exit($data.='Previous op query ');
                $row = mysqli_fetch_array($previous_op_result);
                $pre_op_id = $row['operation_code'];                      

                ////////////////////////////////////////////////////////////////////////////////////////////////////////
                $cdoc_cqty_query  = "SELECT SUM(recevied_qty) as qty from $brandix_bts.bundle_creation_data
                                    where docket_number = '$doc_no' and operation_id = '$ips_id'";
                $cdoc_cqty_result = mysqli_query($link,$cdoc_cqty_query) or exit($data.='Problem in getting con qty per doc');
                $row = mysqli_fetch_array($cdoc_cqty_result);
                $docket_ccqty[$doc_no] = $row['qty'];                    
                $cdoc_qty_query  = "SELECT SUM(recevied_qty) as qty from $brandix_bts.bundle_creation_data
                                    where docket_number = '$doc_no' and operation_id = '$pre_op_id'";
                // $cdoc_qty_query  = "SELECT SUM( a_plies * ($asum_str) ) as qty from $bai_pro3.plandoc_stat_log 
                //                     where doc_no = '$doc_no' ";//and act_cut_status = 'DONE' ";
                $cdoc_qty_result = mysqli_query($link,$cdoc_qty_query) or exit($data.='Problem in getting cut qty per docket');
                $row = mysqli_fetch_array($cdoc_qty_result);
                $docket_cqty[$doc_no] = $row['qty'] - $docket_ccqty[$doc_no];
            }

            //getting smvs for each docket
            $smvs_query = "SELECT MAX(smv) as smv,docket_number as doc FROM $brandix_bts.bundle_creation_data bcd
                           LEFT JOIN $brandix_bts.tbl_style_ops_master som ON som.schedule = bcd.schedule 
                           AND som.style=bcd.style where recevied_qty > 0 GROUP BY docket_number";
            $smvs_result = mysqli_query($link,$smvs_query) or exit($data.='Problem in SMVs');
            while($row = mysqli_fetch_array($smvs_result)){
                $doc = $row['doc'];
                $smv[$doc] = $row['smv'];
            }
        
            foreach($all_dockets as $docket){ 
                if($docket_cqty <= 0)
                    continue;
                unset($modules);
                $jobs = explode(',',$jobs_per_docket[$docket]);
                if(sizeof($jobs) == 0)
                    continue;
                else{
                    foreach($jobs as $job){
                        $module = $ij_module[$job]; 
                        if($module == $pre_mod) 
                            continue;
                        $modules[$module] = $wip[$module] * $smv[$docket];
                        $pre_mod = $module;
                    }
                
                    //Sorting the modules according to SMV's
                    $new_modules = $modules;
                    array_multisort($new_modules);
                    $new_modules = array_unique($new_modules);
                    foreach($new_modules as $value){
                        foreach($modules as $key => $value1){
                            if($value == $value1){
                                $sorted_modules[] = $key;
                            }
                        }
                    }
                    foreach($sorted_modules as $module){
                        foreach($jobs as $job){
                            if($ij_module[$job] == $module){
                                $available = $docket_cqty[$docket];
                                if($available <= 0)
                                    goto  next_docket;   
                                $need = $job_quantity[$job] - $line_in[$job];
                                if($need > $available){
                                    $final_wip[$module]+= $available;
                                    $docket_cqty[$docket] = 0;
                                    $job_quantity[$job]-=$available;  
                                }else{
                                    $final_wip[$module]+= $need;
                                    $job_quantity[$job] = 0;
                                    $docket_cqty[$docket]-=$need;
                                }
                            }
                        }
                    }
                }    
                next_docket : NULL;
            }
            foreach($moduleso as $module)
            {
                $data.= "<script>$('#pending-wip-$module').html(".$final_wip[$module].")</script>";
            }
        
            /*
            foreach($sorted_modules as $key => $sorted_module){
                //echo "<hr><br>INSIDE -------- $sorted_module<br/>";
                $summing_qty = 0;
                //var_dump($input_jobs_per_mod[$sorted_module]);echo "-- JOBS <br/>";
                foreach($input_jobs_per_mod[$sorted_module] as $job){
                    //getting the total job qty of a job and its associated docket numbers
                    $job_quantity_query = "SELECT SUM(carton_act_qty) as qty,GROUP_CONCAT(DISTINCT psl.doc_no) as docs
                                            from $bai_pro3.pac_stat_log_input_job psi 
                                            LEFT JOIN $bai_pro3.plandoc_stat_log psl ON psl.doc_no = psi.doc_no
                                            where input_job_no_random = '$job' ";   
                    $job_quantity_result = mysqli_query($link,$job_quantity_query) or exit($data.='Total Job Qty Problem');
                    $row = mysqli_fetch_array($job_quantity_result);
                    $job_quantity[$job] = $row['qty'];
                    $doc_str            = $row['docs'];
                    $docs = explode(',',$doc_str);
                    $need_to_fill_qty = $job_quantity[$job] - $line_in[$job];
                    foreach($docs as $doc){
                        $incmg_doc_qty = $docket_cqty[$doc];
                        if($incmg_doc_qty == 0 || $incmg_doc_qty == '')
                            continue;
                        if($need_to_fill_qty > 0){
                            if($need_to_fill_qty > $incmg_doc_qty){
                                $need_to_fill_qty -= $incmg_doc_qty;
                                $summing_qty += $incmg_doc_qty;
                                $docket_cqty[$doc] = 0;
                            }else{
                                $docket_cqty[$doc] -= $need_to_fill_qty;
                                $summing_qty += $need_to_fill_qty;
                                $need_to_fill_qty = 0;
                            }
                        }
                    }
                    $wip[$sorted_module] = $summing_qty;
                    $final_qty = $wip[$sorted_module];
                    $data.= "<script>$('#pending-wip-$sorted_module').html($final_qty)</script>";
                } 
            }
            */
        }
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
function getCutJobsData($module){

    global $sum_str; 
    global $link;
    global $bai_pro3,$brandix_bts;
    $docs_data = ''; 
    $total_cut_wip = 0;

    // Total WIP
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
   
    //getting all dockets with the partial cut reported quantities
    $partial_dockets_query  = "SELECT GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
                SUM(($sum_str)) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no
                from $bai_pro3.plan_dash_doc_summ 
                where module = $module and  act_cut_status = 'DONE' 
                and a_plies != p_plies and  clubbing <> '0'
                group by order_del_no,clubbing,acutno order by acutno";
    $partial_cdockets_query  = "SELECT GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
                SUM(($sum_str)) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no
                from $bai_pro3.plan_dash_doc_summ 
                where module = $module and  act_cut_status = 'DONE' 
                and a_plies != p_plies and  clubbing = '0'
                group by doc_no order by acutno";              
    //echo $partial_dockets_query; 
                            
    //getting all the dockets with fabric issue status no but planned
    $nfull_dockets_queryc = "SELECT GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
                SUM($sum_str) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no,fabric_status_new 
                from $bai_pro3.plan_dash_doc_summ 
                where module = $module and  act_cut_status = '' 
                and clubbing <> '0'
                group by order_del_no,clubbing,acutno order by order_del_no,acutno,color_code";
            
    $nfull_dockets_query = "SELECT GROUP_CONCAT(doc_no) as doc_no,GROUP_CONCAT(acutno) as acutno,
                SUM($sum_str) as qty,GROUP_CONCAT(color_code) as color_code,order_del_no,fabric_status_new 
                from $bai_pro3.plan_dash_doc_summ 
                where module = $module and  act_cut_status = '' 
                and clubbing = '0'
                group by order_del_no,doc_no order by order_del_no,acutno,color_code";

    $partial_dockets_result = mysqli_query($link,$partial_dockets_query) or exit($data.='Problem in c-partial docs');
    $partial_cdockets_result = mysqli_query($link,$partial_cdockets_query) or exit($data.='Problem in partial docs');          
    $nfull_dockets_resultc = mysqli_query($link,$nfull_dockets_queryc) or exit($data.='Problem in empty club dockets');
    $nfull_dockets_result = mysqli_query($link,$nfull_dockets_query) or exit($data.='Problem in empty dockets');

    $no_fabric_dockets_result_array = array();
    $no_fabric_dockets_result_array = [$partial_dockets_result,$partial_cdockets_result,$nfull_dockets_resultc,$nfull_dockets_result];
    foreach($no_fabric_dockets_result_array as $order=>$dockets_result){
        while($row = mysqli_fetch_array($dockets_result)){
            $doc_no     = $row['doc_no'];
            $doc_qty    = $row['qty'];
            $cut_no     = $row['acutno'];
            $color_code = $row['color_code'];
            $schedule   = $row['order_del_no'];
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
                $partial_doc_qty_query = "SELECT SUM(original_qty - recevied_qty + rejected_qty) as qty 
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
            $tool_tip_text = "Schedule No : $schedule <br/>Doc no : $doc_no <br/> Cut no : $cut_str <br/> Qty : $doc_qty";

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


            $docs_data.="<td class='cut-td'>&nbsp;";
            $docs_data.="<span><span class='block cut-block $status_color'>
                    <span class='mytooltip'>
                        <a href='#' data-toggle='tooltip' data-placement='top' title='$tool_tip_text' data-html='true'>
                            &nbsp;&nbsp;&nbsp;
                        </a>
                    </span>
                </span></span>";
            $docs_data.="</td>";
        }
        $docs_data.= "<script>$('#cut-wip-$module').html('$total_cut_wip')</script>";
    }
    return $docs_data;
}