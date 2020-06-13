<?php

//function to get data from jn_dockets
function getdata_jm_dockets($doc_num,$plant_code){
    $qry_jm_dockets="SELECT `style`,`fg_color`,`plies`,`jm_cut_job_id`,`ratio_comp_group_id` FROM $pps.jm_dockets WHERE plant_code='$plant_code' AND docket_number=$doc_num";
    $jm_dockets_result=mysqli_query($link_v2, $qry_jm_dockets) or exit("Sql Errorat_jmdockets".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_dockets_num=mysqli_num_rows($jm_dockets_result);
    if($jm_dockets_num>0){
        while($sql_row1=mysqli_fetch_array($jm_dockets_result))
        {
            $style = $sql_row1['style'];
            $fg_color=$sql_row1['fg_color'];
            $plies=$sql_row1['plies'];
            $jm_cut_job_id=$sql_row1['jm_cut_job_id'];
            $ratio_comp_group_id=$sql_row1['ratio_comp_group_id'];
        }

        if($ratio_comp_group_id!=''){
            //getting marker length from lp_markers
            $qry_lp_markers="SELECT `length`,`width`,`efficiency`,`marker_version`,`marker_type_name`,`pattern_version`,`perimeter`,`remark1`,`remark2`,`remark3`,`remark4` FROM $pps.`lp_markers` WHERE `ratio_wise_component_group_id`='' AND default_marker_version=1 AND `plant_code`='$plant_code'";
            $lp_markers_result=mysqli_query($link_v2, $qry_lp_markers) or exit("Sql Errorat_jmdockets".mysqli_error($GLOBALS["___mysqli_ston"]));
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
        'remark4' => $remark4
        );
    }
}


//function to get schedule from mp_mo_qty
function getdata_mp_mo_qty($po_number,$plant_code){
    $qry_mp_sub_mo_qty="SELECT GROUP_CONCAT(master_po_details_mo_quantity_id) AS master_po_details_mo_quantity_id FROM $pps.mp_sub_mo_qty WHERE po_number='$po_number' AND plant_code='$plant_code'";
    $mp_sub_mo_qty_result=mysqli_query($link_v2, $qry_mp_sub_mo_qty) or exit("Sql Errorat_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
        $mp_sub_mo_qty_num=mysqli_num_rows($mp_sub_mo_qty_result);
        if($mp_sub_mo_qty_num>0){
            while($sql_row1=mysqli_fetch_array($mp_sub_mo_qty_result))
            {
                $master_po_details_mo_quantity_id = $sql_row1['master_po_details_mo_quantity_id'];
            }
            //qry to get schedules wrt master_po_details_mo_quantity_id from mp_mo_qty
            $qry_mp_mo_qty="SELECT GROUP_CONCAT(SCHEDULE) AS SCHEDULE FROM $pps.mp_mo_qty WHERE `master_po_details_mo_quantity_id` IN ('$master_po_details_mo_quantity_id') AND plant_code='$plant_code'";
            $qry_mp_mo_qty_result=mysqli_query($link_v2, $qry_mp_mo_qty) or exit("Sql Errorat_mp_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                $qry_mp_mo_qty_num=mysqli_num_rows($qry_mp_mo_qty_result);
                if($qry_mp_mo_qty_num>0){
                    while($sql_row1=mysqli_fetch_array($qry_mp_mo_qty_result))
                    {
                        $SCHEDULE = $sql_row1['SCHEDULE'];
                    }
                    return $SCHEDULE;
                }
        }
}



//function to get component group id and ratio id
function getdata_ratio_component_group($ratio_comp_group_id,$plant_code){
    $qry_ratio_component_group="SELECT ratio_id,component_group_id FROM $pps.lp_ratio_component_group WHERE ratio_wise_component_group_id='$ratio_comp_group_id' AND plant_code='$plant_code'";
    $ratio_component_group_result=mysqli_query($link_v2, $qry_ratio_component_group) or exit("Sql Errorat_ratio_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
        $ratio_component_group_num=mysqli_num_rows($ratio_component_group_result);
        if($ratio_component_group_num>0){
            while($sql_row1=mysqli_fetch_array($ratio_component_group_result))
            {
                $ratio_id = $sql_row1['ratio_id'];
                $component_group_id = $sql_row1['component_group_id'];
            }
            //qry to get category  amd material item code and po details id
            $qry_component_group="SELECT fabric_category,material_item_code,master_po_details_id FROM $pps.lp_component_group WHERE master_po_component_group_id='$component_group_id' AND plant_code='$plant_code'";
            $qry_component_group_result=mysqli_query($link_v2, $qry_component_group) or exit("Sql Errorat_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
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
    $qry_mp_fabric="SELECT rm_description,rm_color FROM $pps.mp_fabric WHERE master_po_details_id='$master_po_details_id' AND rm_sku='$material_item_code' AND plant_code='$plant_code'";
        $qry_mp_fabric_result=mysqli_query($link_v2, $qry_mp_fabric) or exit("Sql Errorat_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
        $mp_fabric_num=mysqli_num_rows($qry_mp_fabric_result);
        if($mp_fabric_num>0){
            while($sql_row1=mysqli_fetch_array($qry_mp_fabric_result))
            {
                $rm_description = $sql_row1['rm_description'];
                $rm_color = $sql_row1['rm_color'];
            }
            return array(
                'rm_description' => $rm_description,
                'rm_color' => $rm_color
            );
        }
}

//this is function to get size wise ratio's
function getdata_size_ratios($ratio_id,$plant_code){
    $qry_ratio_size="SELECT SUM(size_ratio) AS size_ratios FROM $pps.lp_ratio_size WHERE ratio_id='' AND plant_code=''";
    $qry_ratio_size_result=mysqli_query($link_v2, $qry_ratio_size) or exit("Sql Errorat_size_ratios".mysqli_error($GLOBALS["___mysqli_ston"]));
        $qry_ratio_size_num=mysqli_num_rows($qry_ratio_size_result);
        if($qry_ratio_size_num>0){
            while($sql_row1=mysqli_fetch_array($qry_ratio_size_result))
            {
                $size_ratios = $sql_row1['size_ratios'];
            }

            return array(
                'size_ratios' => $size_ratios
            );
        }

}


?>