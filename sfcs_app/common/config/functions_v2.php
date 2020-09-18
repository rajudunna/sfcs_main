<?php
/*
    function to get data from jn_dockets
    @params:doc_num,plant_code
    @returns:Docket information and its marker information
*/
function getJmDockets($doc_num,$plant_code){
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
    $qry_jm_dockets="SELECT jdl.`fg_color`,jdl.`plies`,jd.`jm_cut_job_id`,jd.`ratio_comp_group_id`,DATE(jdl.created_at) as created_at FROM $pps.jm_dockets jd JOIN $pps.jm_docket_lines jdl ON jdl.jm_docket_id=jd.jm_docket_id WHERE jd.plant_code='$plant_code' AND jdl.docket_line_number='$doc_num'";
    $jm_dockets_result=mysqli_query($link_new, $qry_jm_dockets) or exit("Sql Error_at_jmdockets".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_dockets_num=mysqli_num_rows($jm_dockets_result);
    /**From this above query we can get ratio compo group id */
    if($jm_dockets_num>0){
        while($sql_row1=mysqli_fetch_array($jm_dockets_result))
        {
            $fg_color=$sql_row1['fg_color'];
            $plies=$sql_row1['plies'];
            $jm_cut_job_id=$sql_row1['jm_cut_job_id'];
            $ratio_comp_group_id=$sql_row1['ratio_comp_group_id'];
            $created_at=$sql_row1['created_at'];
        }
        
        if($ratio_comp_group_id!=''){
            /**By using ratio component group we can get marker details */
            /**NOte :we can take only default_marker_version=1 details only */
            $getting_style="SELECT `master_po_details_id` FROM $pps.`lp_ratio_component_group` WHERE `ratio_wise_component_group_id`='$ratio_comp_group_id' AND `plant_code`='$plant_code'";
            $getting_style_result=mysqli_query($link_new, $getting_style) or exit("Sql Errorat_lp_markers".mysqli_error($GLOBALS["___mysqli_ston"]));
            $getting_style_result_num=mysqli_num_rows($getting_style_result);
            if($getting_style_result_num>0){
                while($sql_row1123=mysqli_fetch_array($getting_style_result))
                {
                    $master_po_details_id=$sql_row1123['master_po_details_id'];
                }
            }

            $style_info_query = "SELECT mpc.style, mp.master_po_number, mp.master_po_description 
            FROM $pps.mp_color_detail mpc 
            LEFT JOIN $pps.mp_order mp ON mpc.master_po_number = mp.master_po_number
            WHERE mpc.master_po_details_id = '$master_po_details_id' ";
            //echo $style_info_query ;
            $style_info_result=mysqli_query($link_new, $style_info_query) or exit("Sql style_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row = mysqli_fetch_array($style_info_result))
            {
                $style = $row['style'];
                $master_po = $row['master_po_number'];
                $master_po_desc = $row['master_po_description'];
            }
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

/*
    function to get schedule from mp_mo_qty
    @params:po_number,plant_code
    @returns:schdule information only
*/
function getMpMoQty($po_number,$plant_code){
    global $link_new;
    global $pps;
    $schedule='';
    $schedule_temp=array();
    $qry_mp_sub_mo_qty="SELECT master_po_details_mo_quantity_id FROM $pps.mp_sub_mo_qty WHERE po_number='$po_number' AND plant_code='$plant_code'";
    $mp_sub_mo_qty_result=mysqli_query($link_new, $qry_mp_sub_mo_qty) or exit("Sql Errorat_mp_sub_mo_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
        $mp_sub_mo_qty_num=mysqli_num_rows($mp_sub_mo_qty_result);
        /**By using above query we will get master po details mo quantity id to get schedules*/
        if($mp_sub_mo_qty_num>0){
            while($sql_row1=mysqli_fetch_array($mp_sub_mo_qty_result))
            {
                $master_po_details_mo_quantity_id = $sql_row1['master_po_details_mo_quantity_id'];
                /**So basedon master po details id's we will get schedules */
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

/*
    function to get component group id and ratio id
    @params:ratio_comp_group_id,plant_code
    @returns:fabric_category,material_item_code and master_po_details_id information only
*/
function getRatioComponentGroup($ratio_comp_group_id,$plant_code){
    global $link_new;
    global $pps;
    $fabric_category='';
    $material_item_code='';
    $master_po_details_id='';
    $master_po_details_id='';
    $qry_ratio_component_group="SELECT ratio_id,component_group_id FROM $pps.lp_ratio_component_group WHERE ratio_wise_component_group_id='$ratio_comp_group_id' AND plant_code='$plant_code'";
    //echo "</br> Qryratio".$qry_ratio_component_group;
    $ratio_component_group_result=mysqli_query($link_new, $qry_ratio_component_group) or exit("Sql Errorat_ratio_component_group".mysqli_error($GLOBALS["___mysqli_ston"]));
        $ratio_component_group_num=mysqli_num_rows($ratio_component_group_result);
        if($ratio_component_group_num>0){
            while($sql_row1=mysqli_fetch_array($ratio_component_group_result))
            {
                $ratio_id = $sql_row1['ratio_id'];
                $component_group_id = $sql_row1['component_group_id'];
                $fabric_saving = $sql_row1['fabric_saving'];
            }
            //echo "</br>Comp grp ID: ".$component_group_id;
            /**Getting fabric categoery and item code by using component group from lp_ratio_component_group */
            $qry_component_group="SELECT fabric_category,material_item_code,master_po_details_id FROM $pps.lp_component_group WHERE master_po_component_group_id='$component_group_id' AND plant_code='$plant_code'";
            //echo "</br> Com group : ".$qry_component_group;
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
                    'fabric_saving' => $fabric_saving
                );
            }
        }
}


/*
    this is function to get rm sku and rm color descript from mp_fabric
    @params:ratio_comp_group_id,plant_code
    @returns:fabric_category,material_item_code and master_po_details_id information only
*/
function getMpFabric($material_item_code,$master_po_details_id,$plant_code){
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

/*
    this is function to get sizes and size wise ratio's
    @params:ratio_id,plant_code
    @returns:size and size ratios
*/
function getSizeRatios($ratio_id,$plant_code){
    global $link_new;
    global $pps;
    $size_ratios='';
    $qry_ratio_size="SELECT size,size_ratio FROM $pps.lp_ratio_size WHERE ratio_id='$ratio_id' AND plant_code='$plant_code'";
    $qry_ratio_size_result=mysqli_query($link_new, $qry_ratio_size) or exit("Sql Errorat_size_ratios".mysqli_error($GLOBALS["___mysqli_ston"]));
        $qry_ratio_size_num=mysqli_num_rows($qry_ratio_size_result);
        if($qry_ratio_size_num>0){
            $s=0;
            while($sql_row1=mysqli_fetch_array($qry_ratio_size_result))
            {   
                $size_tit[$s] = $sql_row1['size'];
                $ratioof[$s] = $sql_row1['size_ratio'];
              $s++;
            }
            return array(
                'size_tit' => $size_tit,
                'ratioof' => $ratioof
            );
        }

}

/*
    function to get lots based on component item and style
    @params:material_item_code,plant_code
    @returns:lots
*/
function getStickerData($material_item_code,$style,$plantcode){
    global $link_new;
    global $wms;
    $lotnos=array();
    $qry_sticker_report="SELECT lot_no FROM $wms.`sticker_report` WHERE item='$material_item_code' AND plant_code='$plantcode' AND style_no='$style'";
    $sql_lotresult=mysqli_query($link_new, $qry_sticker_report) or exit("$qry_sticker_report".mysqli_error($GLOBALS["___mysqli_ston"]));
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

/*
    this is function to get docket wise allcated rolls info
    @params:doc_num,doc_type,plant_code
    @returns:docket wise allocated rolls info
*/
function getDocketInfo($doc_num,$doc_type,$plant_code){
    global $link_new;
    global $wms;
    global $pps;
    $sql1="SELECT plan_lot_ref from $pps.requested_dockets where jm_docket_line_id='$doc_num' and plant_code='$plant_code' and plan_lot_ref!=''";
    $sql_result1=mysqli_query($link_new, $sql1) or exit("Sql Error at Doscket123 roll details".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_num1=mysqli_num_rows($sql_result1);
        if($sql_num1>0){
            while($sql_row1=mysqli_fetch_array($sql_result1))
            {
                $lot_ref[]=$sql_row1['plan_lot_ref'];               
            }
               
        $lot_no=implode("','" , $lot_ref);
      
       $sql="SELECT store_in.ref2,store_in.shrinkage_width,store_in.qty_allocated,store_in.ref4,sticker_report.batch_no,store_in.ref1,store_in.lot_no,sticker_report.inv_no,store_in.tid,store_in.ref5,store_in.qty_rec,store_in.ref3,store_in.ref6,sticker_report.item from $wms.store_in left join $wms.sticker_report on store_in.lot_no=sticker_report.lot_no where store_in.lot_no in ($lot_no) and store_in.plant_code='$plant_code'";
       $sql_result=mysqli_query($link_new, $sql) or exit("$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
       $sql_num=mysqli_num_rows($sql_result);    
        if($sql_num>0){
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $roll_det[]=$sql_row['ref2'];
                $width_det[]=round($sql_row['shrinkage_width'],2);
                $leng_det[]=$sql_row['qty_allocated'];
                $batch_det[]=trim($sql_row['batch_no']);
                $shade_det[]=$sql_row['ref4'];
                $location_det[]=$sql_row['ref1'];
                $invoice_no[]=$sql_row['inv_no'];
                $locan_det[]=$sql_row['ref1'];
                $lot_det[]=$sql_row['lot_no'];
                $roll_id[]=$sql_row['tid'];
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
}

/*
    function to get style from mo_color_details
    @params:plantcode
    @returns:styles
*/
function getMpColorDetail($plantcode){
    global $link_new;
    global $pps;
    $qry_mp_color_detail="SELECT style FROM $pps.mp_color_detail WHERE plant_code='$plantcode'";
    $mp_color_detail_result=mysqli_query($link_new, $qry_mp_color_detail) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
    if($mp_color_detail_num>0){
        while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
            {
                
                $style[]=$mp_color_detail_row["style"];
            }
            
            $style=array_unique($style);
    }
    return array(
        'style' => $style
    );
}

/*
    function to get schedules from mp_mo_qty
    @params:style and plantcode
    @returns:schedules
*/
function getBulkSchedules($get_style,$plantcode){
    global $link_new;
    global $pps;
    $master_po_details_id=array();
    $qry_mp_color_detail="SELECT master_po_details_id FROM $pps.mp_color_detail WHERE plant_code='$plantcode' AND style='$get_style'";
    $mp_color_detail_result=mysqli_query($link_new, $qry_mp_color_detail) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
    if($mp_color_detail_num>0){
        while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
            {
                
                $master_po_details_id[]=$mp_color_detail_row["master_po_details_id"];
            }

        $schedule=array();
        $qry_mp_mo_qty="SELECT schedule FROM $pps.mp_mo_qty WHERE plant_code='$plantcode' AND master_po_details_id IN ('".implode("','" , $master_po_details_id)."')";
        $mp_mo_qty_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
        $mp_mo_qty_num=mysqli_num_rows($mp_mo_qty_result);
        if($mp_mo_qty_num>0){
            while($mp_mo_qty_row=mysqli_fetch_array($mp_mo_qty_result))
                {
                    
                    $schedule[]=$mp_mo_qty_row["schedule"];
                }
                
                $bulk_schedule=array_unique($schedule);
        }
    }
    return array(
        'bulk_schedule' => $bulk_schedule
    );

}

/*
    function to get bulk colors from mo_order_qty based on schedules
    @params:get_schedule and plantcode
    @returns:color_bulk
*/
function getBulkColors($get_schedule,$plantcode){
    global $link_new;
    global $pps;
    $color=array();
    $qry_mp_mo_qty="SELECT color FROM $pps.mp_mo_qty WHERE plant_code='$plantcode' AND schedule='$get_schedule'";
    $mp_color_detail_result=mysqli_query($link_new, $qry_mp_mo_qty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_color_detail_num=mysqli_num_rows($mp_color_detail_result);
    if($mp_color_detail_num>0){
        while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
            {
                
                $color[]=$mp_color_detail_row["color"];
            }
        }
        $color_bulk=array_unique($color);
        return array(
            'color_bulk' => $color_bulk
        );

}

/*
    function to get Master PO's based on schedule and color
    @params:get_schedule,color and plantcode
    @returns:master PO's
*/ 
function getMpos($get_schedule,$get_color,$plantcode){
    global $link_new;
    global $pps;
    $master_po_details_id=array();
    $qry_mmp_mo_qty="SELECT master_po_details_id FROM $pps.`mp_mo_qty` WHERE plant_code='$plantcode' AND color='$get_color' AND schedule='$get_schedule'";
    $mp_mo_qty_result=mysqli_query($link_new, $qry_mmp_mo_qty) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_mo_qty_num=mysqli_num_rows($mp_mo_qty_result);
    /**From above query we get master po details id */
    if($mp_mo_qty_num>0){
        while($mp_mo_qty_row=mysqli_fetch_array($mp_mo_qty_result))
            {
                
                $master_po_details_id[]=$mp_mo_qty_row["master_po_details_id"];
            }
        }
        $master_po_details_id=array_unique($master_po_details_id);
    /**Based master po details id we can get masetr po number */    
    $master_po_number=array();
    $qry_mp_color_details="SELECT master_po_number FROM $pps.mp_color_detail WHERE master_po_details_id IN ('".implode("','" , $master_po_details_id)."')";
    $mp_color_details_result=mysqli_query($link_new, $qry_mp_color_details) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
    $mp_color_details_num=mysqli_num_rows($mp_color_details_result);
    if($mp_color_details_num>0){
        while($mp_color_details_row=mysqli_fetch_array($mp_color_details_result))
            {
                
                $master_po_number[]=$mp_color_details_row["master_po_number"];
            }
    }
    $master_po_number=array_unique($master_po_number);

    /**So we will show master description based on masetr po number */
    $master_po_description=array();
    $qry_toget_podescri="SELECT master_po_description,master_po_number FROM $pps.mp_order WHERE master_po_number IN ('".implode("','" , $master_po_number)."')";
    $toget_podescri_result=mysqli_query($link_new, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_podescri_result);
    if($mp_color_details_num>0){
        while($toget_podescri_row=mysqli_fetch_array($toget_podescri_result))
            {
                
                $master_po_description[$toget_podescri_row["master_po_description"]]=$toget_podescri_row["master_po_number"];
            }
    }
    return array(
        'master_po_description' => $master_po_description
    );
}

/*
    function to get sub po's from master po's from sub orders
    @params:get_mpo and plantcode
    @returns:Sub PO's
*/
 function getBulkSubPo($get_mpo,$plantcode){
    global $link_new;
    global $pps;
    $sub_po_description=array();
    /**Below query to get sub po's by using master po's */
    $qry_toget_sub_order="SELECT po_description,po_number FROM $pps.mp_sub_order WHERE master_po_number='$get_mpo' AND plant_code='$plantcode'";
    $toget_sub_order_result=mysqli_query($link_new, $qry_toget_sub_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
    if($toget_podescri_num>0){
        while($toget_sub_order_row=mysqli_fetch_array($toget_sub_order_result))
            {
                
                $sub_po_description[$toget_sub_order_row["po_description"]]=$toget_sub_order_row["po_number"];
            }
    }
    return array(
        'sub_po_description' => $sub_po_description
    );

 }

/*
    Function to get savings
    @params:doc_no,plant_code
    @returns:savings
*/
function getFnSavings($doc_no,$plant_code){
    /*By using doc number ratio component group id*/
    if($doc_no!='' && $plant_code!=''){
        $result_getdata_jm_dockets=getJmDockets($doc_no,$plant_code);
        $ratio_comp_group_id=$result_getdata_jm_dockets['ratio_comp_group_id'];
    }
    
    if($ratio_comp_group_id!='' && $plant_code!=''){
        /*By using ratio component group id fabric saving value*/
        $result_getdata_ratio_component_group=getRatioComponentGroup($ratio_comp_group_id,$plant_code);
        $savings=$result_getdata_ratio_component_group['fabric_saving'];
    }

    return array(
        'savings' => $savings
    );
}


/*
    function to get cut numbers from po number
    @params:sub_po,plantcode
    @returns:cut numbers
*/
function getCutDetails($sub_po,$plantcode){
    global $link_new;
    global $pps;
    $cuts=array();
    /**By using po's we are getting*/
    $qry_cut_numbers="SELECT cut_number FROM $pps.jm_cut_job WHERE po_number='$sub_po' AND plant_code='$plantcode'";
    $toget_cut_result=mysqli_query($link_new, $qry_cut_numbers) or exit("Sql Error at cutnumbers".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_cut_num=mysqli_num_rows($toget_cut_result);
    if($toget_cut_num>0){
        while($toget_cut_row=mysqli_fetch_array($toget_cut_result))
        {
          $cuts[]=$toget_cut_row['cut_number']; 
        }
    }
    $cut_number=array_unique($cuts);
    return array(
    'cut_number' => $cut_number
    );
}

/*
    function to get job status from po number
    @params:sub_po,plantcode,type(sewing,cutjob,embjob)
    @returns:status
*/
function getJobsStatus($sub_po,$tasktype,$plantcode){
    global $link_new;
    global $pps;
    global $tms;
    $task_status='';
    
    //Qry to fetch jm_job_header_id from jm_jobs_header
    $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$sub_po' AND plant_code='$plantcode'";
    $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
    if($jm_job_header_id_result_num>0){
        while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
        {
            $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
        }
    }
    //Qry to check sewing job planned or not
    $check_job_status="SELECT task_status FROM $tms.task_header WHERE task_ref in ('".implode("','" , $jm_job_header_id)."') AND plant_code='$plantcode' AND task_type='$tasktype' AND (resource_id IS NULL OR  resource_id='')";
    $job_status_result=mysqli_query($link_new, $check_job_status) or exit("Sql Error at check_job_status".mysqli_error($GLOBALS["___mysqli_ston"]));    
    $job_status_num=mysqli_num_rows($job_status_result);
    if($job_status_num>0){
      $flag=0;
      while($task_status_row=mysqli_fetch_array($job_status_result))
      {
        $task_status=$task_status_row['task_status'];
        if($task_status=="OPEN"){
            $flag=1;
        }
      }
      if($flag==1){
          $task_status="OPEN";
      }else{
          $task_status="";
      }
    }
    return array(
        'task_status' => $task_status
    );
}



/**
 * function to get dockets
 * @param:po_number,plantcode,docket_type(norma-0,Binding-1)
 * @return:docket_number
 */
function getDocketDetails($sub_po,$plantcode,$docket_type){
    global $link_new;
    global $pps; 
    $docs=array();
    //qry to get cutjobid
    $qry_cut_numbers="SELECT jm_cut_job_id FROM $pps.jm_cut_job WHERE po_number='$sub_po' AND plant_code='$plantcode'";
    //echo "</br>Cut jobs : ".$qry_cut_numbers;
    $toget_cut_result=mysqli_query($link_new, $qry_cut_numbers) or exit("Sql Error at cutnumbers".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_cut_num=mysqli_num_rows($toget_cut_result);
      if($toget_cut_num>0){
        while($toget_cut_row=mysqli_fetch_array($toget_cut_result))
        {
          $cut_job_id[]=$toget_cut_row['jm_cut_job_id'];
        }
    }
    $cut_job_id = implode("','", $cut_job_id);
     //qry to get dockets using cut_job_id
    $qry_get_dockets="SELECT jm_docket_id From $pps.jm_dockets WHERE jm_cut_job_id in ('$cut_job_id') AND plant_code='$plantcode' order by docket_number ASC";
    $toget_dockets_result=mysqli_query($link_new, $qry_get_dockets) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_dockets_num=mysqli_num_rows($toget_dockets_result);
    if($toget_dockets_num>0){
        while($toget_docket_row=mysqli_fetch_array($toget_dockets_result))
            {
                $jm_dockets[]=$toget_docket_row['jm_docket_id']; 
            }
        
        //$jm_dockets=array_values(array_unique($jm_dockets));
        $jm_dockets = implode("','", $jm_dockets);

    }
    //qry to get dockets in through dockets id
    $qry_get_docketlines="SELECT jm_docket_line_id,docket_line_number FROM $pps.jm_docket_lines WHERE jm_docket_id IN ('$jm_dockets') AND plant_code='$plantcode' AND is_binding='$docket_type'";
    $qry_get_docketlines_result=mysqli_query($link_new, $qry_get_docketlines) or exit("Sql Error at docket lines".mysqli_error($GLOBALS["___mysqli_ston"]));
    $docketlines_num=mysqli_num_rows($qry_get_docketlines_result);
    if($docketlines_num>0){
        while($docketline_row=mysqli_fetch_array($qry_get_docketlines_result))
            {
                $docket_lines[$docketline_row["docket_line_number"]]=$docketline_row["jm_docket_line_id"]; 
            }
        }
    return array(
        'docket_lines' => $docket_lines
    );
  }


/** Function to update jobs using workstations
 * @param:inputjobs and work stations
 * @return:true/false
 * */
function updatePlanDocketJobs($list, $tasktype, $plantcode)
{
    global $link_new;
    global $pps;
    global $tms;
    global $TaskTypeEnum;
    global $TaskStatusEnum;
    
    $check_type=TaskTypeEnum::SEWINGJOB;
    $taskStatus=TaskStatusEnum::INPROGRESS;
    try
    {
        $list_db=array();
        $list_db=explode(";",$list);
    
        for($i=0;$i<sizeof($list_db);$i++)
        {
            $items=array();
            $items=explode("|",$list_db[$i]);
            /**Getting task jobs details from task jobs */
            $Qry_taskjobs = "SELECT task_header_id,task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$items[1]' AND plant_code='$plantcode' AND task_type='$tasktype'";
            $Qry_taskjobs_result = mysqli_query($link_new, $Qry_taskjobs) or exit("Sql Error at task_header_id" . mysqli_error($GLOBALS["___mysqli_ston"]));
            $taskjobs_num = mysqli_num_rows($Qry_taskjobs_result);
            if ($taskjobs_num > 0) {
                while ($taskjobs_row = mysqli_fetch_array($Qry_taskjobs_result)) {
                    $header_id = $taskjobs_row['task_header_id'];
                    $task_jobs_id = $taskjobs_row['task_jobs_id'];
                }
            }
            if ($items[0] == "allItems") {
                /**updtae resource id tasks header with work sation id's*/
                $Qry_update_taskheader="UPDATE $tms.task_header SET resource_id =NULL,task_status='OPEN' WHERE task_header_id='$header_id' AND task_type='$tasktype' AND plant_code='$plantcode'";
                $Qry_taskjobs_result=mysqli_query($link_new, $Qry_update_taskheader) or exit("Sql Error at taskheader".mysqli_error($GLOBALS["___mysqli_ston"]));

                /**Update qry for priority */
                $qryUpdateJobsPriority="UPDATE $tms.task_jobs SET priority=NULL,updated_at=NOW() WHERE task_header_id='$header_id' AND task_type='$tasktype' AND plant_code='$plantcode'";
                $UpdateJobsPriority_result=mysqli_query($link_new, $qryUpdateJobsPriority) or exit("Sql Error at TaskjObs priority Update".mysqli_error($GLOBALS["___mysqli_ston"]));

            }
            else
            {  
                /**getting max priority based on work station*/
                $qryAllHeadersModuleWise="SELECT task_header_id FROM $tms.task_header WHERE resource_id='$items[0]' AND plant_code='$plantcode'";
                $AllHeadersModuleWise_result=mysqli_query($link_new, $qryAllHeadersModuleWise) or exit("Sql Error at task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
                $headerIds=array();
                $allHeaders_num=mysqli_num_rows($AllHeadersModuleWise_result);
                if($allHeaders_num>0){
                    while($headersRrow=mysqli_fetch_array($AllHeadersModuleWise_result))
                    {
                        $headerIds[]=$headersRrow['task_header_id'];
                    }
                }
                $headers = implode("','", $headerIds);

                /**getting max priority based on header ids*/
                $qryMaxprorityJob="SELECT MAX(priority) as lastPriority FROM $tms.task_jobs WHERE task_header_id IN ('$headers') AND plant_code='$plantcode'";
                $maxProrityJob_result=mysqli_query($link_new, $qryMaxprorityJob) or exit("Sql Error at task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
                $headerIds=array();
                $maxPriority_num=mysqli_num_rows($maxProrityJob_result);
                if($maxPriority_num>0){
                    while($maxPriorityRrow=mysqli_fetch_array($maxProrityJob_result))
                    {
                        $j=$maxPriorityRrow['lastPriority'];
                    }
                }
                if(is_null($j)){
                    $j=1;
                }else{
                    $j=$j+1;
                }
                /**validate with work station mapping in task header*/
                $Qry_taskheader = "SELECT resource_id,task_type,task_ref,task_progress,short_desc,priority,planned_date_time,delivery_date_time,sla,is_active,plant_code,created_at,created_user,updated_at,updated_user,version_flag FROM $tms.task_header WHERE task_header_id='$header_id' AND plant_code='$plantcode' AND task_type='$tasktype'";
                $Qry_taskheader_result = mysqli_query($link_new, $Qry_taskheader) or exit("Sql Error at task_header" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $taskheader_num = mysqli_num_rows($Qry_taskheader_result);
                if ($taskheader_num > 0) {
                    while ($taskheader_row = mysqli_fetch_array($Qry_taskheader_result)) {
                        $resource_id = $taskheader_row['resource_id'];
                        $task_type = $taskheader_row['task_type'];
                        $task_ref = $taskheader_row['task_ref'];
                        $task_progress = $taskheader_row['task_progress'];
                        $short_desc = $taskheader_row['short_desc'];
                        $priority = $taskheader_row['priority'];
                        $planned_date_time = $taskheader_row['planned_date_time'];
                        $delivery_date_time = $taskheader_row['delivery_date_time'];
                        $sla = $taskheader_row['sla'];
                        $is_active = $taskheader_row['is_active'];
                        $plant_code = $taskheader_row['plant_code'];
                        $created_at = $taskheader_row['created_at'];
                        $created_user = $taskheader_row['created_user'];
                        $updated_at = $taskheader_row['updated_at'];
                        $updated_user = $taskheader_row['updated_user'];
                        $version_flag = $taskheader_row['version_flag'];
                    }
                }

                if(is_null($resource_id)){
                    /** */
                    /**resource id update */
                    $Qry_update_header="UPDATE $tms.task_header SET resource_id='$items[0]',task_status='$taskStatus',priority='$j' WHERE task_header_id='$header_id' AND task_type='$tasktype' AND plant_code='$plantcode'";
                    $Qry_taskheader_result=mysqli_query($link_new, $Qry_update_header) or exit("Sql Error at update task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    /**Update qry for priority */
                    $qryUpdateJobsPriority="UPDATE $tms.task_jobs SET priority=$j,updated_at=NOW() WHERE task_header_id='$header_id' AND task_type='$tasktype' AND plant_code='$plantcode'";
                    $UpdateJobsPriority_result=mysqli_query($link_new, $qryUpdateJobsPriority) or exit("Sql Error at TaskjObs priority Update".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    /**For Trims*/
                    if($tasktype == $check_type)
                    {
                        $get_task_job_id="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_header_id='$header_id' AND task_type='$tasktype' AND plant_code='$plantcode'";
                        $get_task_job_id_result=mysqli_query($link_new, $get_task_job_id) or exit("Sql Error at get_task_job_id".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($job_id_row=mysqli_fetch_array($get_task_job_id_result))
                        {
                            $task_id= $job_id_row['task_jobs_id'];
                            $jobs_trims_insert="INSERT INTO $tms.job_trims (task_job_id,plant_code,created_user,updated_user) VALUES ('".$task_id."','".$plant_code."','".$created_user."','".$created_user."')";
                            $jobs_trims_result=mysqli_query($link_new, $jobs_trims_insert) or exit("Sql Error at jobs_trims_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }

                    }    

                }elseif($resource_id!=$items[0]){

                    /**Insert new record in header for if new reource id alloacted with in cut job */
                    $select_uuid="SELECT UUID() as uuid";
                    //echo $select_uuid;
                    $uuid_result=mysqli_query($link_new, $select_uuid) or exit("Sql Error at select_uuid".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($uuid_row=mysqli_fetch_array($uuid_result))
                    {
                        $uuid=$uuid_row['uuid'];
                    
                    }

                    /**Insert new record in header for if new reource id alloacted with in cut job */
                    $Qry_insert_taskheader="INSERT INTO $tms.task_header (task_header_id,`task_type`,`task_ref`,`task_status`,`task_progress`,`resource_id`,`short_desc`,`priority`,`planned_date_time`,`delivery_date_time`,`sla`,`is_active`,`plant_code`,`created_user`,`updated_at`,`updated_user`,`version_flag`) VALUES ('".$uuid."','".$task_type."','".$task_ref."','".$taskStatus."','".$task_progress."','".$items[0]."','".$short_desc."','".$priority."','".$planned_date_time."','".$delivery_date_time."','".$sla."','".$is_active."','".$plant_code."','".$created_user."',NOW(),'".$updated_user."',1)";
                    $Qry_taskheader_result=mysqli_query($link_new, $Qry_insert_taskheader) or exit("Sql Error at insert task_header".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    /**update resource id tasks jobs with task_header*/
                    $Qry_update_taskjobs="UPDATE $tms.task_jobs SET priority=$j,task_header_id='$uuid' WHERE task_job_reference='$items[1]' AND task_type='$tasktype' AND plant_code='$plantcode'";
                    $Qry_taskjobs_result=mysqli_query($link_new, $Qry_update_taskjobs) or exit("Sql Error at update task_jobs1".mysqli_error($GLOBALS["___mysqli_ston"]));
                    
                    if($tasktype == $check_type)
                    {
                        $get_task_job_id="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_header_id='$uuid' AND task_type='$tasktype' AND plant_code='$plantcode'";
                        $get_task_job_id_result=mysqli_query($link_new, $get_task_job_id) or exit("Sql Error at get_task_job_id".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($job_id_row=mysqli_fetch_array($get_task_job_id_result))
                        {
                           $task_id= $job_id_row['task_jobs_id'];
                           $jobs_trims_insert="INSERT INTO $pps.job_trims (task_job_id,plant_code,created_user,updated_user) VALUES ('".$task_id."','".$plant_code."','".$created_user."','".$created_user."')";
                           $jobs_trims_result=mysqli_query($link_new, $jobs_trims_insert) or exit("Sql Error at jobs_trims_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
                        } 
                        
                        $qry_to_task_attributes="SELECT * FROM $tms.task_attributes WHERE task_header_id='$header_id' AND plant_code='$plantcode'";
                        $Qry_task_attributes_result=mysqli_query($link_new, $qry_to_task_attributes) or exit("Sql Error at task_attributes".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($task_attributes_row=mysqli_fetch_array($Qry_task_attributes_result))
                        {
                           $insert_query="INSERT INTO $tms.task_attributes (attribute_name,attribute_value,plant_code,updated_at,task_header_id) values('".$task_attributes_row['attribute_name']."','".$task_attributes_row['attribute_value']."','$plantcode',NOW(),'$task_id')";
                            $insert_query_result=mysqli_query($link_new, $insert_query) or exit("Sql Error at insert task_attributes".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                    }
                }
            }
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

    /** Getting work stations based on department wise
   * @param:department,plantcode
   * @return:workstation
   * */
  function getWorkstations($department,$plantcode){
    global $link_new;
    global $pms;
    /**Qry to get departmen wise id's */
    $Qry_department="SELECT `department_id` FROM $pms.`departments` WHERE department_type='$department' AND plant_code='$plantcode' AND is_active=1";
    $Qry_department_result=mysqli_query($link_new, $Qry_department) or exit("Sql Error at department ids".mysqli_error($GLOBALS["___mysqli_ston"]));
    $Qry_department_result_num=mysqli_num_rows($Qry_department_result);
    if($Qry_department_result_num>0){
        while($department_row=mysqli_fetch_array($Qry_department_result))
        {
            $department_id=$department_row['department_id'];
        }
    }
    /**Getting work station type against department*/
    $qry_workstation_type="SELECT workstation_type_id FROM $pms.workstation_type WHERE department_id='$department_id' AND plant_code='$plantcode' AND is_active=1";
    $workstation_type_result=mysqli_query($link_new, $qry_workstation_type) or exit("Sql Error at workstation type".mysqli_error($GLOBALS["___mysqli_ston"]));
    $workstationtype=array();
    $workstation_typet_num=mysqli_num_rows($workstation_type_result);
    if($workstation_typet_num>0){
        while($workstaton_type_row=mysqli_fetch_array($workstation_type_result))
        {
            $workstationtype[]=$workstaton_type_row['workstation_type_id'];
        }
    }
    $workstations = implode("','", $workstationtype);
    /**Getting work stations against workstation type*/
    $qry_workstations="SELECT workstation_id,workstation_code FROM $pms.workstation WHERE is_active=1 AND plant_code='$plantcode' AND workstation_type_id IN ('$workstations')";
    $workstations_result=mysqli_query($link_new, $qry_workstations) or exit("Sql Error at workstatsions".mysqli_error($GLOBALS["___mysqli_ston"]));
    $workstation=array();
    $workstations_result_num=mysqli_num_rows($workstations_result);
    if($workstations_result_num>0){
        while($workstations_row=mysqli_fetch_array($workstations_result))
        {
            $workstation[$workstations_row['workstation_id']]=$workstations_row['workstation_code'];
        }
    }

    return array(
        'workstation' => $workstation
    );

  }


/**
 * get workstations for plant code and section id
 */
function getWorkstationsForSectionId($plantCode, $sectionId) {
    global $link_new;
    global $pms;
    try{
        $workstationsQuery = "select workstation_id,workstation_code,workstation_description,workstation_label from $pms.workstation where plant_code='".$plantCode."' and section_id= '".$sectionId."' and is_active=1";
        // echo $workstationsQuery;
        $workstationsQueryResult = mysqli_query($link_new,$workstationsQuery) or exit('Problem in getting workstations');
        if(mysqli_num_rows($workstationsQueryResult)>0){
            $workstations= [];
            while($row = mysqli_fetch_array($workstationsQueryResult)){
                $workstationRecord = [];
                $workstationRecord["workstationId"] = $row['workstation_id'];
                $workstationRecord["workstationCode"] = $row["workstation_code"];
                $workstationRecord["workstationDesc"] = $row["workstation_description"];
                $workstationRecord["workstationLabel"] = $row["workstation_label"];
                array_push($workstations, $workstationRecord);
            }
            return $workstations;
        } else {
            return "Workstations not found";
        }
    } catch(Exception $e) {
        throw $e;
    }
}
  //function to get jobs
  /** function to get jobs which are unplanned
   * @param:po,task_type,plant_code
   * @return:jobs
   * */
function getUnplannedJobs($sub_po,$tasktype,$plantcode){
    global $link_new;
    global $pps;
    global $tms;
    global $TaskTypeEnum;
    
    $check_type=TaskTypeEnum::SEWINGJOB;
    if($check_type == $tasktype)
    {
      $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
    }
    else
    {
      $job_group_type=TaskTypeEnum::PLANNEDEMBELLISHMENTJOB;
    }    
    $jm_job_header_id=array();
    $task_header_id=array();
    $job_number=array();
   
     //Qry to fetch jm_job_header_id from jm_jobs_header
    $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$sub_po' AND plant_code='$plantcode'";
    $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
    if($jm_job_header_id_result_num>0){
        while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
        {
            $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
        }
    }
    //Qry to check sewing job planned or not
    $check_job_status="SELECT task_header_id FROM $tms.task_header WHERE task_ref in ('".implode("','" , $jm_job_header_id)."') AND plant_code='$plantcode' AND task_type='$tasktype' AND (resource_id IS NULL OR  resource_id='')";
    $job_status_result=mysqli_query($link_new, $check_job_status) or exit("Sql Error at check_job_status".mysqli_error($GLOBALS["___mysqli_ston"]));    
    $job_status_num=mysqli_num_rows($job_status_result);
    if($job_status_num>0){
      while($task_header_id_row=mysqli_fetch_array($job_status_result))
        {
            $task_header_id[]=$task_header_id_row['task_header_id'];
        }
    }    
    //Qry to fetch taskrefrence from task_job  
    $qry_toget_taskrefrence="SELECT task_job_reference FROM $tms.task_jobs WHERE task_type='$tasktype' AND plant_code='$plantcode' AND task_header_id IN ('".implode("','" , $task_header_id)."')";
   // echo $qry_toget_taskrefrence;
    $toget_taskrefrence_result=mysqli_query($link_new, $qry_toget_taskrefrence) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_taskrefrence_num=mysqli_num_rows($toget_taskrefrence_result);
    if($toget_taskrefrence_num>0){
        while($toget_taskrefrence_row=mysqli_fetch_array($toget_taskrefrence_result))
        {  
          $task_refrence[]=$toget_taskrefrence_row['task_job_reference'];
        }
    }  
    //Qry to get sewing jobs from jm_jobs_header
    $qry_toget_sewing_jobs="SELECT job_number,jm_jg_header_id FROM $pps.jm_jg_header WHERE job_group_type='$job_group_type' AND plant_code='$plantcode' AND jm_jg_header_id  IN('".implode("','" , $task_refrence)."')";
    //echo $qry_toget_sewing_jobs;
    $toget_sewing_jobs_result=mysqli_query($link_new, $qry_toget_sewing_jobs) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_sewing_jobs_num=mysqli_num_rows($toget_sewing_jobs_result);
    if($toget_sewing_jobs_num>0){
        while($toget_sewing_jobs_row=mysqli_fetch_array($toget_sewing_jobs_result))
        {
           $job_number[$toget_sewing_jobs_row['job_number']]=$toget_sewing_jobs_row['jm_jg_header_id']; 
        }
    }
    
    return array(
        'job_number' => $job_number
    );
}

/*
    function to get planned jobs from workstation
    @params:work_id,plantcode,type(sewing,cutjob,embjob)
    @returns:job_number
*/
function getPlannedJobs($work_id,$tasktype,$plantcode){
      global $link_new;
      global $pps;
      global $tms;
      global $TaskTypeEnum;
      global $TaskStatusEnum;
        
      $check_type=TaskTypeEnum::SEWINGJOB;
      if($check_type == $tasktype)
      {
        $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
      }
      else
      {
        $job_group_type=TaskTypeEnum::PLANNEDEMBELLISHMENTJOB;
      }   
      
     $taskStatus=TaskStatusEnum::INPROGRESS;
      //Qry to fetch task_header_id from task_header
      $task_header_id=array();
      $task_header_log_time=array();
      $get_task_header_id="SELECT task_header_id,updated_at FROM $tms.task_header WHERE resource_id='$work_id' AND task_status='".$taskStatus."' AND task_type='$tasktype' AND plant_code='$plantcode'";
    //   echo $get_task_header_id."<br/>";
      $task_header_id_result=mysqli_query($link_new, $get_task_header_id) or exit("Sql Error at get_task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($task_header_id_row=mysqli_fetch_array($task_header_id_result))
      {
        $task_header_id[] = $task_header_id_row['task_header_id'];
        $task_header_log_time[$task_header_id_row['task_header_id']] = $task_header_id_row['updated_at'];
      }
      //To get taskrefrence from task_jobs based on resourceid 
      $task_job_reference=array(); 
      $task_job_ids=array(); 
      $job_number=array();
      if(sizeof($task_header_id) > 0){

          $get_refrence_no="SELECT * FROM $tms.task_jobs WHERE task_header_id IN('".implode("','" , $task_header_id)."') AND plant_code='$plantcode' ORDER BY priority ASC";
         
          $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
          while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
          {
            $task_job_reference[$refrence_no_row['priority']] = $refrence_no_row['task_job_reference'];
            $task_header_ids[$refrence_no_row['task_header_id']] = $refrence_no_row['task_job_reference'];
            $task_job_ids[$refrence_no_row['task_jobs_id']] = $refrence_no_row['task_header_id'];
          }
          //Qry to get sewing jobs from jm_jobs_header
          
          foreach($task_header_ids as $key=>$value){
            $qry_toget_sewing_jobs="SELECT job_number,jm_jg_header_id FROM $pps.jm_jg_header WHERE job_group_type='$job_group_type' AND plant_code='$plantcode' AND jm_jg_header_id='$value'";
            $toget_sewing_jobs_result=mysqli_query($link_new, $qry_toget_sewing_jobs) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
            $toget_sewing_jobs_num=mysqli_num_rows($toget_sewing_jobs_result);
            if($toget_sewing_jobs_num>0){
                while($toget_sewing_jobs_row=mysqli_fetch_array($toget_sewing_jobs_result))
                {
                    $job_number[$key]= $toget_sewing_jobs_row['job_number'];
                }
            }
          }
      }
      return array(
          'job_number' => $job_number,
          'task_header_id' => $task_header_id,
           'task_job_reference' => $task_job_reference,
           'task_job_ids' => $task_job_ids,
        'task_header_log_time'=> $task_header_log_time
      );
} 

//function to get savings from fn_savings_per_cal
  /** function to get sewing jobs
   * @param:doc_no,plant_code
   * @return:savings
   * */
function fn_savings_per_cal($doc_no,$plant_code){
        //using this function  we can get ratio component group id
        if($doc_no!='' && $$plant_code!=''){
            $result_getdata_jm_dockets=getdata_jm_dockets($doc_no,$plant_code);
            $ratio_comp_group_id=$result_getdata_jm_dockets['ratio_comp_group_id'];
        }
        
        if($ratio_comp_group_id!='' && $plant_code!=''){
            $result_getdata_ratio_component_group=getdata_ratio_component_group($ratio_comp_group_id,$plant_code);
            $savings=$result_getdata_ratio_component_group['fabric_saving'];
        }

        return array(
            'savings' => $savings
        );


}

/**Function to get po description from mp sub order
@param:sub_po,plantcode
@return:cut numbers 
*/
function getPoDetaials($po_number,$plant_code){
    global $link_new;
    global $pps;
    $QryPODetails="SELECT po_description FROM $pps.mp_sub_order WHERE po_number='$po_number' AND plant_code='$plant_code'";
    $ResultPoDetails=mysqli_query($link_new, $QryPODetails) or exit("Sql Error at PO details".mysqli_error($GLOBALS["___mysqli_ston"]));
    $PoDetails_num=mysqli_num_rows($ResultPoDetails);
    if($PoDetails_num>0){
        while($PoDetails_row=mysqli_fetch_array($ResultPoDetails))
        {
            $po_description=$PoDetails_row['po_description'];
        }
    }

    return array(
        'po_description' => $po_description
    );
}

/**
 * Function to get cut number wrt cutjobid
 * @param:jm_cut_job_id
 * @return:cut_number
*/
function getCutNumber($jm_cut_job_id){
    global $link_new;
    global $pps;
    $QryCutNumbers="SELECT cut_number FROM $pps.jm_cut_job WHERE jm_cut_job_id='$jm_cut_job_id'";
    $ResultCutNumbers=mysqli_query($link_new, $QryCutNumbers) or exit("Sql Error at PO details".mysqli_error($GLOBALS["___mysqli_ston"]));
    $CutNumbers_num=mysqli_num_rows($ResultCutNumbers);
    if($CutNumbers_num>0){
        while($CutNumbers_row=mysqli_fetch_array($ResultCutNumbers))
        {
            $cut_number=$CutNumbers_row['cut_number'];
        }
    }

    return array(
        'cut_number' => $cut_number
    );
}
function getDocketInformation($docket_no, $plant_code) {
    global $pps;
    global $link_new;
    
    $style = ''; // done
    $fg_color = ''; // done
    $sub_po = ''; // done
    $sub_po_desc = ''; // done
    $master_po = ''; // done
    $master_po_desc = ''; // done
    $plies = 0; // done
    $docket_quantity = 0; // done
    $category = ''; // done
    $components = []; // done
    $cut_no = ''; // done
    $comp_group = ''; // done
    $rm_sku = ''; // done
    $requirement = ''; // done

    $length = '';
    $width = '';
    $efficiency = '';
    $marker_version = '';
    $marker_type_name = '';
    $pattern_version = '';
    $perimeter = '';
    $remark1 = '';
    $remark2 = '';
    $remark3 = '';
    $remark4 = '';
    $ratio_cg_id = '';

    $schedules = [];
    // get the docket info
    $docket_info_query = "SELECT doc_line.plies, doc_line.fg_color,doc_line.docket_line_number,
        doc.marker_version_id, doc.ratio_comp_group_id,
        cut.cut_number, cut.po_number,doc_line.jm_docket_line_id,
        ratio_cg.component_group_id as cg_id, ratio_cg.ratio_id, ratio_cg.master_po_details_id
        FROM $pps.jm_docket_lines doc_line 
        LEFT JOIN $pps.jm_dockets doc ON doc.jm_docket_id = doc_line.jm_docket_id
        LEFT JOIN $pps.jm_cut_job cut ON cut.jm_cut_job_id = doc.jm_cut_job_id
        LEFT JOIN $pps.lp_ratio_component_group ratio_cg ON ratio_cg.ratio_wise_component_group_id = doc.ratio_comp_group_id
        WHERE doc_line.plant_code = '$plant_code' AND doc_line.jm_docket_line_id='$docket_no' AND doc_line.is_active=true";
    $docket_info_result=mysqli_query($link_new, $docket_info_query) or exit("$docket_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
 
    while($row = mysqli_fetch_array($docket_info_result))
    {
        $fg_color = $row['fg_color'];
        $plies =  $row['plies'];
        $comp_group =  $row['cg_name'];
        $cut_no = $row['cut_number'];
        $ratio_comp_group_id = $row['ratio_comp_group_id'];
        $docket_line_number = $row['docket_line_number'];
        $po_number = $row['po_number'];
        $marker_version_id = $row['marker_version_id'];
        $ratio_id = $row['ratio_id'];
        $cg_id = $row['cg_id'];
        $mp_detail_id = $row['master_po_details_id'];
    }

    // get the style and master po info
    $style_info_query = "SELECT mpc.style, mp.master_po_number, mp.master_po_description 
    FROM $pps.mp_color_detail mpc 
    LEFT JOIN $pps.mp_order mp ON mpc.master_po_number = mp.master_po_number
    WHERE mpc.master_po_details_id = '$mp_detail_id' ";
    $style_info_result=mysqli_query($link_new, $style_info_query) or exit("Sql style_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
  
    while($row = mysqli_fetch_array($style_info_result))
    {
        $style = $row['style'];
        $master_po = $row['master_po_number'];
        $master_po_desc = $row['master_po_description'];
    }

    
    $sub_po_info_query = "SELECT po_number, po_description FROM $pps.mp_sub_order where po_number = '$po_number' ";
    $sub_po_info_result=mysqli_query($link_new, $sub_po_info_query) or exit("Sql sub_po_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row = mysqli_fetch_array($sub_po_info_result))
    {
        $sub_po = $row['po_number'];
        $sub_po_desc = $row['po_description'];
    }

    // get the rm sku, fabric catrgory
    $fabric_info_query = "SELECT fabric_category, material_item_code FROM $pps.lp_component_group where master_po_component_group_id = '$cg_id' ";
    $fabric_info_result=mysqli_query($link_new, $fabric_info_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row = mysqli_fetch_array($fabric_info_result))
    {
        $category = $row['fabric_category'];
        $rm_sku = $row['material_item_code'];
    }

    // get the components for the docket
    $components_query = "SELECT component_name FROM $pps.lp_product_component where component_group_id = '$cg_id' ";
    $components_result=mysqli_query($link_new, $components_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row = mysqli_fetch_array($components_result))
    {
        $components[] = $row['component_name'];
    }

    // get the docket qty
    $size_ratio_sum = 0;
    $size_ratios_query = "SELECT size, size_ratio FROM $pps.lp_ratio_size WHERE ratio_id = '$ratio_id' ";
    $size_ratios_result=mysqli_query($link_new, $size_ratios_query) or exit("Sql fabric_info_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row = mysqli_fetch_array($size_ratios_result))
    {
        $size_ratio_sum += $row['size_ratio'];
    }

    $docket_quantity = $size_ratio_sum * $plies;

    // get the marker requierement
    $markers_query="SELECT `length`,`width`,`efficiency`,`marker_version`,`marker_version_id`,`marker_type_name`,`pattern_version`,`perimeter`,`remark1`,`remark2`,`remark3`,`remark4`,`shrinkage`
    FROM $pps.`lp_markers` WHERE `ratio_wise_component_group_id`='$ratio_comp_group_id' AND default_marker_version=1 AND `plant_code`='$plant_code'";
   
    $markers_result = mysqli_query($link_new, $markers_query) or exit("Sql markers_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row11 = mysqli_fetch_array($markers_result))
    {
        $length = $sql_row11['length'];
        $width=$sql_row11['width'];
        $efficiency=$sql_row11['efficiency'];
        $marker_version=$sql_row11['marker_version'];
        $marker_type_name=$sql_row11['marker_type_name'];
        $pattern_version=$sql_row11['pattern_version'];
        $perimeter=$sql_row11['perimeter'];
        $remark1=$sql_row11['remark1'];
        $remark2=$sql_row11['remark2'];
        $remark3=$sql_row11['remark3'];
        $remark4=$sql_row11['remark4'];
        $shrinkage=$sql_row11['shrinkage'];
        $marker_version_id=$sql_row11['marker_version_id'];
    }
    $requirement = $length * $width * $docket_quantity;

    return [
        'style' => $style,
        'fg_color' => $fg_color,
        'sub_po' => $sub_po,
        'sub_po_desc' =>$sub_po_desc,
        'master_po'=> $master_po,
        'master_po_desc'=>$master_po_desc,
        'master_po_desc'=>$plies,
        'docket_quantity'=>$docket_quantity,
        'category'=>$category,
        'components'=>$components,
        'cut_no'=>$cut_no,
        'comp_group'=>$comp_group,
        'rm_sku'=>$rm_sku,
        'requirement'=>$requirement,
        'length'=>$length,
        'width'=>$width,
        'efficiency'=>$efficiency,
        'marker_version'=>$marker_version,
        'marker_type_name'=>$marker_type_name,
        'pattern_version'=>$pattern_version,
        'perimeter'=>$perimeter,
        'remark1'=>$remark1,
        'remark2'=>$remark2,
        'remark3'=>$remark3,
        'remark4'=>$remark4,
        'shrinkage'=>$shrinkage,
        'ratio_comp_group_id' => $ratio_comp_group_id,
        'marker_version_id' => $marker_version_id,
        'docket_line_number'=>$docket_line_number  
    ];

}


/**
 * to get sections for the plant code
 */
function getSections($plant_code){
    global $link_new;
    global $pms;
    $section_data=[];
    $query="select * from $pms.sections where plant_code='$plant_code'";
    $sql_res = mysqli_query($link_new, $query) or exit("Sql Error at Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $sections_rows_num = mysqli_num_rows($sql_res);
    if ($sections_rows_num > 0) {
        while ($sections_row = mysqli_fetch_array($sql_res)) {
            $section_data[] = $sections_row;
        }
    }
    return array(
        'section_data' => $section_data
    );
}

/**
 * to get operations for plant code and operation category
 */
function getOperationsForCategory($plant_code, $category)
{
    global $link_new;
    global $pms;
    $operations_data = [];
    $query = "select * from $pms.operation_mapping where plant_code='$plant_code' and operation_category = '$category' and sequence = 1 and is_active = 1 order by priority";

    $sql_res = mysqli_query($link_new, $query) or exit("Sql Error at Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $operations_rows_num = mysqli_num_rows($sql_res);
    if ($operations_rows_num > 0) {
        while ($operations_row = mysqli_fetch_array($sql_res)) {
            $operations_data[] = $operations_row;
        }
    }
    return array(
        'operations_data' => $operations_data
    );
}

/**
 * get workstations based on section and plant
 * 
 */
function getWorkstationsForSection($plant_code, $section){
    global $link_new;
    global $pms;
    $operations_data = [];
    $query = "select * from $pms.workstation where plant_code='$plant_code' and section_id = '$section'";
    $sql_res = mysqli_query($link_new, $query) or exit("Sql Error at Section details" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $workstation_rows_num = mysqli_num_rows($sql_res);
    if ($workstation_rows_num > 0) {
        while ($workstation_row = mysqli_fetch_array($sql_res)) {
            $workstation_data[] = $workstation_row;
        }
    }
    return array(
        'workstation_data' => $workstation_data
    );
}
/**
 * get planned sewing jobs(JG) for the workstation
 */
function getJobsForWorkstationIdTypeSewing($plantCode, $workstationId, $limit) {
    global $tms;
    global $link_new;
    global $taskType;
    global $taskStatus;
    try{
        $taskType = TaskTypeEnum::SEWINGJOB;
        $taskStatus = TaskStatusEnum::INPROGRESS;
        $jobsQuery = "select tj.task_jobs_id from $tms.task_header as th left join $tms.task_jobs as tj on th.task_header_id=tj.task_header_id where tj.plant_code='".$plantCode."' and th.resource_id='".$workstationId."' and tj.task_type='".$taskType."' and th.task_status = '".$taskStatus."' ORDER BY tj.`priority`";
        if ($limit) {
            $jobsQuery .= " limit 0,$limit";
        }
        $jobsQueryResult = mysqli_query($link_new,$jobsQuery) or exit('Problem in getting jobs in workstation');
        if(mysqli_num_rows($jobsQueryResult)>0){
            $jobs= [];
            while($row = mysqli_fetch_array($jobsQueryResult)){
                $jobRecord = [];
                $jobRecord["taskJobId"] = $row['task_jobs_id'];
                array_push($jobs, $jobRecord);
            }
            
            return $jobs;
        } else {
            return "Jobs not found for the workstation";
        }
    } catch(Exception $e) {
        throw $e;
    }
}
/* Function to get style,color,schedule wrt ponumber
 * @param:ponumber,plancode
 * @return:style,color,schedule
*/
function getStyleColorSchedule($ponumber,$plantcode){
    global $link_new;
    global $pps;
    $style=array();
    $color=array();
    $schedule=array();
    //To get schedule,color
    $qry_get_sch_col="SELECT schedule,color FROM $pps.`mp_sub_mo_qty` LEFT JOIN $pps.`mp_mo_qty` ON mp_sub_mo_qty.`master_po_details_mo_quantity_id`= mp_mo_qty.`master_po_details_mo_quantity_id`
    WHERE po_number='$ponumber' AND mp_sub_mo_qty.plant_code='$plantcode'";
    $qry_get_sch_col_result=mysqli_query($link_new, $qry_get_sch_col) or exit("Sql Error at qry_get_sch_col".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row=mysqli_fetch_array($qry_get_sch_col_result))
    {
      $schedule[]=$row['schedule'];
      $color[]=$row['color'];
    }
    $color_bulk=array_unique($color);
    //To get style
    $qry_get_style="SELECT style FROM $pps.`mp_mo_qty` LEFT JOIN $pps.`mp_color_detail` ON mp_color_detail.`master_po_details_id`=mp_mo_qty.`master_po_details_id` WHERE mp_mo_qty.color in ('".implode("','" , $color_bulk)."') and mp_color_detail.plant_code='$plantcode'";
    $qry_get_style_result=mysqli_query($link_new, $qry_get_style) or exit("Sql Error at qry_get_style".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row1=mysqli_fetch_array($qry_get_style_result))
    {
      $style[]=$row1['style'];
    }    
    $style_bulk=array_unique($style);
    $schedule_bulk=array_unique($schedule);
    return array(
        'style_bulk' => $style_bulk,
        'schedule_bulk' => $schedule_bulk,
        'color_bulk' => $color_bulk
    );
}
?>
