<?php
//function to get data from jn_dockets
function getdata_jm_dockets($doc_num,$plant_code){
    global $link_new;
    global $pps;
    $style='';
    $fg_color='';
    $plies='';
    $jm_cut_job_id='';
    $ratio_comp_group_id='';
    $length='';
    $width='';
    $efficiency='';
    $marker_version='';
    $marker_type_name='';
    $pattern_version='';
    $perimeter='';
    $remark1='';
    $remark2='';
    $remark3='';
    $remark4='';
    $created_at='';
    $qry_jm_dockets="SELECT `style`,`fg_color`,`plies`,`jm_cut_job_id`,`ratio_comp_group_id`,DATE(created_at) as created_at FROM $pps.jm_dockets WHERE plant_code='$plant_code' AND docket_number=$doc_num";
    $jm_dockets_result=mysqli_query($link_new, $qry_jm_dockets) or exit("Sql Error_at_jmdockets".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_dockets_num=mysqli_num_rows($jm_dockets_result);
    if($jm_dockets_num>0){
        while($sql_row1=mysqli_fetch_array($jm_dockets_result))
        {
            $style = $sql_row1['style'];
            $fg_color=$sql_row1['fg_color'];
            $plies=$sql_row1['plies'];
            $jm_cut_job_id=$sql_row1['jm_cut_job_id'];
            $ratio_comp_group_id=$sql_row1['ratio_comp_group_id'];
            $created_at=$sql_row1['created_at'];
        }
        
        if($ratio_comp_group_id!=''){
            //getting marker length from lp_markers
            $qry_lp_markers="SELECT `length`,`width`,`efficiency`,`marker_version`,`marker_type_name`,`pattern_version`,`perimeter`,`remark1`,`remark2`,`remark3`,`remark4` FROM $pps.`lp_markers` WHERE `ratio_wise_component_group_id`='$ratio_comp_group_id' AND default_marker_version=1 AND `plant_code`='$plant_code'";
            $lp_markers_result=mysqli_query($link_new, $qry_lp_markers) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
            $lp_markers_num=mysqli_num_rows($lp_markers_result);
            if($lp_markers_num>0){
                while($sql_row1=mysqli_fetch_array($lp_markers_result))
                {
                    $length = $sql_row1['length'];
                    $width=$sql_row1['width'];
                    $efficiency=$sql_row1['efficiency'];
                    $marker_version=$sql_row1['marker_version'];
                    $marker_type_name=$sql_row1['marker_type_name'];
                    $pattern_version=$sql_row1['pattern_version'];
                    $perimeter=$sql_row1['perimeter'];
                    $remark1=$sql_row1['remark1'];
                    $remark2=$sql_row1['remark2'];
                    $remark3=$sql_row1['remark3'];
                    $remark4=$sql_row1['remark4'];
                }

            }
        }

        return array(
        'style' => $style,
        'fg_color' => $fg_color,
        'plies' => $plies,
        'jm_cut_job_id' => $jm_cut_job_id,
        'ratio_comp_group_id' => $ratio_comp_group_id,
        'length' => $length,
        'width' => $width,
        'efficiency' => $efficiency,
        'marker_version' => $marker_version,
        'marker_type_name' => $marker_type_name,
        'pattern_version' => $pattern_version,
        'perimeter' => $perimeter,
        'remark1' => $remark1,
        'remark2' => $remark2,
        'remark3' => $remark3,
        'remark4' => $remark4,
        'created_at' => $created_at
        );
    }
}


//function to get schedule from mp_mo_qty
function getdata_mp_mo_qty($po_number,$plant_code){
    global $link_new;
    global $pps;
    $schedule='';
    $schedule_temp=array();
    $qry_mp_sub_mo_qty="SELECT master_po_details_mo_quantity_id FROM $pps.mp_sub_mo_qty WHERE po_number='$po_number' AND plant_code='$plant_code'";
    $mp_sub_mo_qty_result=mysqli_query($link_new, $qry_mp_sub_mo_qty) or exit("Sql Errorat_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
        $mp_sub_mo_qty_num=mysqli_num_rows($mp_sub_mo_qty_result);
        if($mp_sub_mo_qty_num>0){
            while($sql_row1=mysqli_fetch_array($mp_sub_mo_qty_result))
            {
                $master_po_details_mo_quantity_id = $sql_row1['master_po_details_mo_quantity_id'];
            
                //qry to get schedules wrt master_po_details_mo_quantity_id from mp_mo_qty
                $qry_mp_mo_qty="SELECT schedule FROM $pps.mp_mo_qty WHERE `master_po_details_mo_quantity_id`='$master_po_details_mo_quantity_id' AND plant_code='$plant_code'";
                $qry_mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Errorat_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $qry_mp_mo_qty_num=mysqli_num_rows($qry_mp_mo_qty_result);
                    if($qry_mp_mo_qty_num>0){
                        while($sql_row1=mysqli_fetch_array($qry_mp_mo_qty_result))
                        {
                            $schedule_temp[] = $sql_row1['schedule'];
                        }
                    
                    }
            }    
                $schedule=array_values(array_unique($schedule_temp));
                return array(
                    'schedule' => $schedule);
        }
}



//function to get component group id and ratio id
function getdata_ratio_component_group($ratio_comp_group_id,$plant_code){
    global $link_new;
    global $pps;
    $fabric_category='';
    $material_item_code='';
    $master_po_details_id='';
    $master_po_details_id='';
    $qry_ratio_component_group="SELECT ratio_id,component_group_id FROM $pps.lp_ratio_component_group WHERE ratio_wise_component_group_id='$ratio_comp_group_id' AND plant_code='$plant_code'";
    $ratio_component_group_result=mysqli_query($link_new, $qry_ratio_component_group) or exit("Sql Errorat_ratio_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
        $ratio_component_group_num=mysqli_num_rows($ratio_component_group_result);
        if($ratio_component_group_num>0){
            while($sql_row1=mysqli_fetch_array($ratio_component_group_result))
            {
                $ratio_id = $sql_row1['ratio_id'];
                $component_group_id = $sql_row1['component_group_id'];
            }
            //qry to get category  amd material item code and po details id
            $qry_component_group="SELECT fabric_category,material_item_code,master_po_details_id FROM $pps.lp_component_group WHERE master_po_component_group_id='$component_group_id' AND plant_code='$plant_code'";
            $qry_component_group_result=mysqli_query($link_new, $qry_component_group) or exit("Sql Errorat_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
            $component_group_num=mysqli_num_rows($qry_component_group_result);
            if($component_group_num>0){
                while($sql_row1=mysqli_fetch_array($qry_component_group_result))
                {
                    $fabric_category = $sql_row1['fabric_category'];
                    $material_item_code = $sql_row1['material_item_code'];
                    $master_po_details_id = $sql_row1['master_po_details_id'];

                }

                return array(
                    'fabric_category' => $fabric_category,
                    'material_item_code' => $material_item_code,
                    'master_po_details_id' => $master_po_details_id,
                    'master_po_details_id' => $master_po_details_id
                );
            }
        }
}


//this is function to get rm sku and rm color descript from mp_fabric
function getdata_mp_fabric($material_item_code,$master_po_details_id,$plant_code){
    global $link_new;
    global $pps;
    $rm_description='';
    $rm_color='';
    $qry_mp_fabric="SELECT rm_description,rm_color,consumption FROM $pps.mp_fabric WHERE master_po_details_id='$master_po_details_id' AND rm_sku='$material_item_code' AND plant_code='$plant_code'";
        $qry_mp_fabric_result=mysqli_query($link_new, $qry_mp_fabric) or exit("Sql Errorat_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
        $mp_fabric_num=mysqli_num_rows($qry_mp_fabric_result);
        if($mp_fabric_num>0){
            while($sql_row1=mysqli_fetch_array($qry_mp_fabric_result))
            {
                $rm_description = $sql_row1['rm_description'];
                $rm_color = $sql_row1['rm_color'];
                $consumption = $sql_row1['consumption'];
                $wastage = $sql_row1['wastage'];

            }
            return array(
                'rm_description' => $rm_description,
                'rm_color' => $rm_color,
                'consumption' => $consumption,
                'wastage' => $wastage

            );
        }
}

//this is function to get size wise ratio's
function getdata_size_ratios($ratio_id,$plant_code){
    global $link_new;
    global $pps;
    $size_ratios='';
    $qry_ratio_size="SELECT size,size_ratio FROM $pps.lp_ratio_size WHERE ratio_id='$ratio_id' AND plant_code='$plant_code'";
    //echo $qry_ratio_size;
    $qry_ratio_size_result=mysqli_query($link_new, $qry_ratio_size) or exit("Sql Errorat_size_ratios".mysqli_error($GLOBALS["___mysqli_ston"]));
        $qry_ratio_size_num=mysqli_num_rows($qry_ratio_size_result);
        if($qry_ratio_size_num>0){
            $s=0;
            while($sql_row1=mysqli_fetch_array($qry_ratio_size_result))
            {   

                // echo "</br>Test".$i."-".$sql_row1['size']."</br>";
                $size_tit[$s] = $sql_row1['size'];
                $ratioof[$s] = $sql_row1['size_ratio'];
              $s++;
            }
            //var_dump($ratioof);
            return array(
                'size_tit' => $size_tit,
                'ratioof' => $ratioof
            );
        }

}

//function to get lots based on component item and style
function getdata_stickerdata($material_item_code,$style){
    global $link_new;
    global $bai_rm_pj1;
    $lotnos=array();
    $qry_sticker_report="SELECT lot_no FROM $bai_rm_pj1.`sticker_report` WHERE item='$material_item_code' AND style_no='$style'";
    $sql_lotresult=mysqli_query($link_new, $qry_sticker_report) or exit("lot numbers Sql Error ".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sticker_report_num=mysqli_num_rows($sql_lotresult);
        if($sticker_report_num>0){
            while($sql_lotrow=mysqli_fetch_array($sql_lotresult))
            {
                $lotnos[]=$sql_lotrow['lot_no'];
            }
        }
		
        
        return array(
            'lotnos' => $lotnos
        );
}

//function for docket_ref
function getdata_docketinfo($doc_num,$doc_type){
    global $link_new;
    global $bai_rm_pj1;
    //$sql="select * from $bai_rm_pj1.docket_ref where doc_no=\"B".$bindid."\" and doc_type='binding'  group by roll_id order by batch_no,ref4 asc";
    $sql="SELECT `fabric_cad_allocation`.`tran_pin` AS `tran_pin`,`fabric_cad_allocation`.`doc_no` AS `doc_no`,`fabric_cad_allocation`.`roll_id` AS `roll_id`,`fabric_cad_allocation`.`roll_width` AS `roll_width`,`fabric_cad_allocation`.`plies` AS `plies`,`fabric_cad_allocation`.`mk_len` AS `mk_len`,`fabric_cad_allocation`.`doc_type` AS `doc_type`,`fabric_cad_allocation`.`log_time` AS `log_time`,`fabric_cad_allocation`.`allocated_qty` AS `allocated_qty`,`store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no`  AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`inv_no` AS `inv_no`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`barcode_number` AS `barcode_number` FROM ($bai_rm_pj1.`fabric_cad_allocation` LEFT JOIN $bai_rm_pj1.`store_in` ON  (`fabric_cad_allocation`.`roll_id` = `store_in`.`tid`) LEFT JOIN $bai_rm_pj1.`sticker_report` ON (`store_in`.`lot_no`=`sticker_report`.`lot_no`)) where doc_no='$doc_num' and doc_type='binding'  group by roll_id order by batch_no,ref4 asc";
    //echo $sql;
    $sql_result=mysqli_query($link_new, $sql) or exit("Sql Error at Doscket roll details".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num=mysqli_num_rows($sql_result);
        if($sql_num>0){
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $roll_det[]=$sql_row['ref2'];
                $width_det[]=round($sql_row['roll_width'],2);
                $leng_det[]=$sql_row['allocated_qty'];
                $batch_det[]=trim($sql_row['batch_no']);
                $shade_det[]=$sql_row['ref4'];
                $location_det[]=$sql_row['ref1'];
                $invoice_no[]=$sql_row['inv_no'];
                $locan_det[]=$sql_row['ref1'];
                $lot_det[]=$sql_row['lot_no'];
                $roll_id[]=$sql_row['roll_id'];
                $ctex_len[]=$sql_row['ref5'];
                $tkt_len[]=$sql_row['qty_rec'];
                $ctex_width[]=$sql_row['ref3'];
                $tkt_width[]=$sql_row['ref6'];
                $item_name[] = $sql_row['item'];
            }
        }
        
        return array(
            'roll_det' => $roll_det,
            'width_det' => $width_det,
            'leng_det' => $leng_det,
            'batch_det' => $batch_det,
            'shade_det' => $shade_det,
            'location_det' => $location_det,
            'invoice_no' => $invoice_no,
            'locan_det' => $locan_det,
            'lot_det' => $lot_det,
            'roll_id' => $roll_id,
            'ctex_len' => $ctex_len,
            'tkt_len' => $tkt_len,
            'ctex_width' => $ctex_width,
            'tkt_width' => $tkt_width,
            'item_name' => $item_name
        );
}


?>