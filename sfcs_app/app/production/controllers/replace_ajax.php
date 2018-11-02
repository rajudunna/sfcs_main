<?php
    // include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    if(isset($_POST['input_job'])){
        $job_no = $_POST['input_job'];
        
        $mod_ary = array();
        $get_modules = "SELECT distinct(SUBSTRING_INDEX(remarks, '-', 1)) as remarks FROM bai_pro3.bai_qms_db WHERE input_job_no='$job_no'";
       
        $res_qry =mysqli_query($link,$get_modules);
        // $i=0;
        while($result1 = mysqli_fetch_array($res_qry))
        {
            // $i++;
            if($result1['remarks']!=''){
             array_push($mod_ary,$result1['remarks']);
                // $mod_ary[$i]=$result1['remarks'];
            }
        }
        echo json_encode($mod_ary);die();
        
        
        }else if(isset($_POST['style'])){

        $status='';$doc_ref='';$input_job_no='';$destination='';$pack_mode =''; $o_size ='';$doc_type='';$type_sewing=''; $operations_ary = array(); $operations_list_ary = array();$remarks_in ='';$bundle_ary = array();
        if($_POST['style']!='' && $_POST['schedule']!='')
        {
            $style = $_POST['style'];$schedule = $_POST['schedule'];$color = $_POST['color'];$job_no = $_POST['job_no'];$module = $_POST['mod_no'];
            // $opid = $_POST['operations'];
            $doc_ary = $_POST['docs'];
            $size_ary = $_POST['size'];
            $qty_ary = $_POST['rep_qty'];
            $shift_ary = $_POST['shifts'];
            // $bundle_ary = $_POST['bundles'];
             
           // var_dump($color);var_dump($doc_ary);var_dump($size_ary);var_dump($qty_ary);var_dump($bundle_ary);
           // echo  sizeof($size_ary);
                     
            for($i=0;$i<sizeof($size_ary);$i++)
            {
                $sql_tid="select order_tid from $bai_pro3.bai_orders_db where order_del_no='".$schedule."' and order_col_des='".$color[$i]."'";
                $sql_result_tid=mysqli_query($link, $sql_tid) or exit("Sql Error6 $sql_tid".mysqli_error($GLOBALS["___mysqli_ston"]));
                 while($sql_row_tid=mysqli_fetch_array($sql_result_tid))
					{
						$order_tid=$sql_row_tid["order_tid"];
                    }  
            $sql23="select title_size_$size_ary[$i] as size_val,title_flag from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid' and order_style_no='$style' and order_del_no='$schedule' and order_col_des='".$color[$i]."'";
            $sql_result_size=mysqli_query($link, $sql23) or exit("Sql Error6 $sql_tid".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row_tid=mysqli_fetch_array($sql_result_size))
               {
                   $size_tit=$sql_row_tid["order_tid"];
               } 
            
                $remarks_in = $module."-".$shift_ary[$i];
                /* Replace Panels  with qms_tran_type 2*/
                $insert_qry = "insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,qms_remarks,bundle_no,log_user,log_date,issued_by,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,location_id,input_job_no,operation_id)
                VALUES('$style','$schedule','$color[$i]','','','','','','$size_ary[$i]','$qty_ary[$i]','2','$remarks_in','','$doc_ary[$i]','','$job_no','')";
               $res_qry =mysqli_query($link,$insert_qry) or exit("erro1");

                /* Replace Panels with qms_tran_type 1 */
                $qty_1 = ($qty_ary[$i]*-1);
               
                $insert_qry_1 = "insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,qms_remarks,bundle_no,log_user,log_date,issued_by,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,location_id,input_job_no,operation_id)
                VALUES('$style','$schedule','$color[$i]','','','','','','$size_ary[$i]','$qty_1','1','$remarks_in','','$doc_ary[$i]','','$job_no','')";
                // echo $insert_qry_1."2<br>";
               $res_qry_1 =mysqli_query($link,$insert_qry_1) or exit("erro2");

                /* Replace Panels with qms_tran_type 3 */

                $insert_qry_3 = "insert into $bai_pro3.bai_qms_db(qms_style,qms_schedule,qms_color,qms_remarks,bundle_no,log_user,log_date,issued_by,qms_size,qms_qty,qms_tran_type,remarks,ref1,doc_no,location_id,input_job_no,operation_id)
                VALUES('$style','$schedule','$color[$i]','','','','','','$size_ary[$i]','$qty_1','3','$remarks_in','','$doc_ary[$i]','','$job_no','')";
                // echo $insert_qry_3."3<br>";
                $res_qry_3 =mysqli_query($link,$insert_qry_3) or exit("erro3");
                
                $barcode_qry = "select max(barcode_sequence) from bai_pro3.pac_stat_log_input_job";
                $res_barcodeseq = mysqli_query($link,$barcode_qry);
                
                $row_res = mysqli_fetch_row($res_barcodeseq);
                $barcode_sequence = $row_res[0];
               
                /* Get data of sewing job for this input_job,size,doc_no */

                $get_job_data = "select * from bai_pro3.pac_stat_log_input_job WHERE input_job_no_random = '$job_no' AND old_size='$size_ary[$i]' AND doc_no='$doc_ary[$i]' "; 
                
               $res_get_job_data =mysqli_query($link,$get_job_data) or exit("erro3");
              
                while($result1 = mysqli_fetch_array($res_get_job_data))
                {
                    // $doc_ref = $result1['doc_ref'];
                    $status = $result1['status'];$input_job_no = $result1['input_job_no'];$destination = $result1['destination'];$pack_mode = $result1['packing_mode'];
                    $size_code = $result1['size_code'];$doc_type=$result1['doc_type'];$type_sewing = $result1['type_of_sewing'];
                    //$barcode_sequence = (int)$result1['barcode_sequence']+1;
                    $sref_id = $result1['sref_id'];$pac_seq_no=$result1['pac_seq_no'];
                }
               $barcode_sequence = (int)$barcode_sequence+1;
                // echo $status."--".$input_job."--".$destination."--".$pack_mode."--".$o_size."--".$doc_type."--".$type_sewing."-".$barcode_sequence."<br>";die();
                
                $insert_packing = "insert into $bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size,doc_type,type_of_sewing,sref_id,pac_seq_no,barcode_sequence)VALUES('$doc_ary[$i]','$size_code','$qty_ary[$i]','$status','','$input_job_no','$job_no','$destination','$pack_mode','$size_ary[$i]','$doc_type','$type_sewing','$sref_id','$pac_seq_no','$barcode_sequence')";

                $res_get_job_data =mysqli_query($link,$insert_packing) or exit("erro4");
                if($res_get_job_data){
                    $bundle_no = mysqli_insert_id($link); 
                }
                
                //$result = mysqli_query($link,"SELECT MAX(tid) FROM $bai_pro3.pac_stat_log_input_job");
               // $row = mysqli_fetch_row($result);
               // $bundle_no = $row[0];
                // echo $bundle_no."bundle number<br>";
                // $cut_qry = "SELECT cut_number FROM brandix_bts.bundle_creation_data WHERE style='$style' AND SCHEDULE='$schedule' AND color='$color[$i]' AND docket_number='$doc_ary[$i]' ";
                // echo $cut_qry;die();
                // $cut_result = mysqli_query($link,$cut_qry);
                // $row_cut = mysqli_fetch_row($cut_result);
                // $cut_no = $row_cut[0];
                $cut_no = $doc_ary[$i];

                /* get distinct operations from bundlecreationdata */
                $flag = 1;
                $get_operations = "SELECT DISTINCT operation_id
                FROM brandix_bts.bundle_creation_data bcd LEFT JOIN brandix_bts.`tbl_orders_ops_ref` ops ON ops.`operation_code`= bcd.`operation_id`
                WHERE style='$style' AND SCHEDULE='$schedule' AND color='$color[$i]' AND category = 'sewing'  ORDER BY operation_id";
                // echo $get_operations."<br>";
                $res_get_operations =mysqli_query($link,$get_operations) or exit("erro5");
                $previous = array();$cps_operation ='';
                while($resop = mysqli_fetch_array($res_get_operations))
                 {
                    
                     $opid = $resop['operation_id'];

                    $insert_bundle =" SELECT *  FROM brandix_bts.bundle_creation_data WHERE style='$style' AND SCHEDULE='$schedule' AND color='$color[$i]' AND operation_id = '$opid' AND size_title='$size_ary[$i]'  LIMIT  0,1 ";
                    // echo $insert_bundle."<br>";

                    $res_bundle_data = mysqli_query($link,$insert_bundle) or exit("erro6");
                    while($res_bundle_data_ary = mysqli_fetch_array($res_bundle_data) ){
                        $o_size = $res_bundle_data_ary['size_id'];$sfcs_smv = $res_bundle_data_ary['sfcs_smv'];
                        $op_code = $res_bundle_data_ary['operation_id'];$operation_sequence = $res_bundle_data_ary['operation_sequence'];$operation_dependency = $res_bundle_data_ary['ops_dependency'];
                        $sewing_order_status = $res_bundle_data_ary['sewing_order_status'];
                        $is_sewing_order= $res_bundle_data_ary['is_sewing_order'];
                        $sewing_order = $res_bundle_data_ary['sewing_order'];$remarks = $res_bundle_data_ary['remarks'];
                        $input_job = $res_bundle_data_ary['input_job_no'];

                        $bundle_insert ="insert into $brandix_bts.bundle_creation_data (date_time,cut_number,style,SCHEDULE,color,size_id,size_title,sfcs_smv,bundle_number,original_qty,send_qty,recevied_qty,missing_qty,rejected_qty,left_over,operation_id,operation_sequence,ops_dependency,docket_number,bundle_status,split_status,sewing_order_status,is_sewing_order,sewing_order,assigned_module,remarks,scanned_date,shift,scanned_user,sync_status,shade,input_job_no,input_job_no_random_ref,mapped_color,barcode_sequence,barcode_number,cancel_qty) 
                       VALUES(NOW(),'$cut_no','$style','$schedule','$color[$i]','$o_size','$size_ary[$i]','$sfcs_smv','$bundle_no','$qty_ary[$i]','$qty_ary[$i]','0','0','0','0','$op_code','$operation_sequence','$operation_dependency','$doc_ary[$i]','OPEN','','$sewing_order_status','$is_sewing_order','$sewing_order','$module','$remarks','','$shift_ary[$i]','','','','$input_job','$job_no','$color[$i]','$barcode_sequence','$bundle_no','')";
                    //   echo $bundle_insert."7<br>";
                     $res_gen_bundles =mysqli_query($link,$bundle_insert) or exit("erro6");

                    }
                    if($flag == 1){
                        
                        $opidqry = "SELECT operation_code FROM brandix_bts.tbl_style_ops_master WHERE style = '$style' AND color='$color[$i]' ORDER BY operation_code";
                        $res_get_tblopid =mysqli_query($link,$opidqry) or exit("erro6.11");
                        while($rescpsopid = mysqli_fetch_array($res_get_tblopid)){
                                array_push($previous,$rescpsopid['operation_code']);
                        }
                        $key = array_search($opid,$previous);

                        $qty = (int)$qty_ary[$i];
                        $cps_operation = $previous[$key-1];
                        $cpslog_update = "UPDATE $bai_pro3.cps_log SET remaining_qty= remaining_qty+$qty WHERE doc_no='$doc_ary[$i]' AND size_title='$size_ary[$i]' AND operation_code='$cps_operation'";
                       
                        $cps_execute = mysqli_query($link,$cpslog_update) or exit("erro6.1");
                    }
                   
                    $flag++;
                 }

                /** Get MO Operations */
                
                $get_operations_list = "SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
                WHERE default_operation='Yes' and trim(category) = 'sewing' ";
                //    echo $get_operations_list."8<br>";
                 $res_oplist =mysqli_query($link,$get_operations_list) or exit("erro7");
                 while($res_data = mysqli_fetch_array($res_oplist))
                {
                    $list_codes = $res_data['codes'];
                }
                // $list_codes = explode(',',$list_codes);

                // echo $list_codes."op codes list";
                $get_mo_details ="SELECT md.id as mid,md.mo_no as mo_no,md.rejected_quantity as rej_qty,md.status as rstatus,md.op_code as opcode,md.op_desc as opdes,m.size as sizeid FROM $bai_pro3.mo_operation_quantites md 
                LEFT JOIN $bai_pro3.mo_details m ON m.mo_no = md.mo_no 
                WHERE  style='$style' AND schedule='$schedule' AND color='$color[$i]' AND m.size='$size_ary[$i]' AND rejected_quantity  >0 and op_code in ($list_codes) GROUP BY op_code ORDER BY md.mo_no DESC" ;
                //  echo $get_mo_details."10<br>";
             
                $res_mo =mysqli_query($link,$get_mo_details) or exit("error8");
                // var_dump($res_mo);
                $bal_qty = $qty_ary[$i];
                while($res_data = mysqli_fetch_array($res_mo))
                {
                    $rej_qty = $res_data['rej_qty']; $mo_no = $res_data['mo_no'];
                    $rstatus = $res_data['rstatus'];$opcode = $res_data['opcode'];
                    $op_desc = $res_data['opdes'];
                    // $input_job = $res_data['inputjob'];
                    $sizeid= $res_data['sizeid'];$mid = $res_data['mid'];
                    if($bal_qty>0){
                        if($bal_qty >= $rej_qty){
                            $insert_data = "insert into bai_pro3.mo_operation_quantites(date_time,mo_no,ref_no,bundle_quantity,good_quantity,rejected_quantity,status,op_code,op_desc)
                            VALUES(NOW(),'$mo_no','$bundle_no','$rej_qty','0','0','$status','$opcode','$op_desc')";
                            // echo $insert_data."11<br>";
                            $res_insmo =mysqli_query($link,$insert_data) or exit("error9");
                            $bal_qty = $qty_ary[$i]-$rej_qty;
                            $update_data = "update bai_pro3.mo_operation_quantites set bundle_quantity='0' where id='$mid' ";
                            // echo $update_data."12<br>";
                            $res_update =mysqli_query($link,$update_data) or exit("error10");
                            continue;
                        }else{
                            $insert_data = "insert into bai_pro3.mo_operation_quantites(date_time,mo_no,ref_no,bundle_quantity,good_quantity,rejected_quantity,status,op_code,op_desc)
                            VALUES(NOW(),'$mo_no','$bundle_no','$bal_qty','0','0','$status','$opcode','$op_desc')";
                            // echo $insert_data."13<br>";
                            $res_insmo =mysqli_query($link,$insert_data)or exit("error11");
                            $update_qty = $rej_qty-$bal_qty;
                            $update_data = "update bai_pro3.mo_operation_quantites set bundle_quantity='$update_qty' where id='$mid' ";
                            // echo $update_data."14<br>";
                            $res_update =mysqli_query($link,$update_data) or exit("error12");
                            continue;
                        }
                    }
                    
                }
             }
             echo "success";
        }

    }




?>