<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/lib/mpdf7/vendor/autoload.php';
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php'); 


$body = "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    font-size: small;
}
body
{
    font-family: Calibri;
    font-size: 12px;
}
.tabletop-detials{
    width:60%;
}
.companyinfo{
    margin-left:65%;
    width: 100%; 
}


</style>"; 
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'setAutoBottomMargin' => 'stretch',
]);

$header = array (
    'odd' => array (
        'C' => array (
            'content' => '<strong>Job Wise Sewing and Packing Trim Requirement Report - '.$plant_name.'</strong>',
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'Calibri',
            'color'=>'#000000'
        ),
        'line' => 0,
    ),
    'even' => array ()
);

$company_num = $company_no;
$host= $api_hostname;
$port= $api_port_no;

$schedule=$_GET['schedule'];
$style=$_GET['style'];
$input_job_no=$_GET['input_job'];

$colors=[];
$sql="select fg_color from $pps.jm_product_logical_bundle where feature_value='".$schedule."' group by fg_color";	 
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result))
{
	$colors[]=$row['fg_color'];
}
if(count($colors)>0){
    foreach($colors as $key=>$color){ 
        $api_selected_valuess_strim = [];
        $api_selected_valuess_ptrim = [];
        $size_code=array();
        $size_code_qty=array();
        unset($size_code);
        unset($size_code_qty);
        $tasktype=TaskTypeEnum::PLANNEDSEWINGJOB;
        $get_jm_jg_header="SELECT jm_jg_header_id FROM $pps.jm_jg_header WHERE job_number='$input_job_no' AND job_group_type='$tasktype' AND plant_code='$plant_code'";
        $header_result=mysqli_query($link, $get_jm_jg_header) or die("Error".$get_jm_jg_header.mysqli_error($GLOBALS["___mysqli_ston"]));
        while($header_row=mysqli_fetch_array($header_result))
        {
           $jm_jg_header_id=$header_row['jm_jg_header_id'];
        }    
        $sql="SELECT sum(jm_job_bundles.quantity) as quantity,jm_job_bundles.size as size FROM $pps.`jm_job_bundles` LEFT JOIN $pps.`jm_product_logical_bundle` ON jm_job_bundles.`jm_pplb_id`=jm_product_logical_bundle.jm_pplb_id WHERE jm_jg_header_id='".$jm_jg_header_id."' AND feature_value='".$schedule."' AND jm_job_bundles.fg_color='".$color."' AND jm_job_bundles.plant_code='$plant_code' group by size";
        $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
        $colorrows = mysqli_num_rows($sql_result);
        while($row=mysqli_fetch_array($sql_result))
        {
            $size_code[]=strtoupper($row['size']);
            $size_code_qty[]=$row['quantity'];
        }
        
        $limit=40; 
        $limit1=40; 
        $size_count = count($size_code);
        if($colorrows >0){            
            $body.= '<table class="companyinfo">
                        <tbody>
                            <tr><td><strong><center>Company :- Brandix Group of Companies<center></strong></tr>
                        </tbody>
                    </table>
                    <table class="tabletop-detials">
                        <tbody>
                            <tr><td style="width:20%"><b>Style No:</b></td><td>'.$style.'</td></tr>
                            <tr><td><b>Schedule No:</b></td><td>'.$schedule.'</td></tr>
                            <tr><td><b>Color:</b></td><td>'.$color.'</td></tr>
                            <tr><td><b>Job No:</b></td><td>'.$input_job_no.'</td></tr>
                        </tbody>
                    </table>
                    <br>
                    <table width=100%>
                        <tbody>';
                         $j=0;
                        for($k=0;$k<=$size_count;$k++) 
                        {                         
                            $body.='<tr><td style="width:10%"><b>Size:</b></td>';
                                    for($i=$j;$i<$limit;$i++){
                                        if($size_code[$i]){
                                            $body.='<td>'.$size_code[$i].'</td>';
                                        }
                                    }
                                    $body.='</tr><tr><td><b>Quantity:</b></td>';
                                    for($i=$j;$i<$limit;$i++){
                                        if($size_code_qty[$i]){
                                            $body.='<td>'.$size_code_qty[$i].'</td>';
                                        }
                                    $j++; 
                                    } 
                                    $body.='</tr>';
                            $limit = $limit+$limit1;
                            if($limit>= ($size_count+$limit1)){
                                break;
                            }
                            
                        }          
                        $body.='</tbody>
                    </table>
            <br>';
            $tasktype=TaskTypeEnum::PLANNEDSEWINGJOB;
            $get_jm_jg_header="SELECT jm_jg_header_id FROM $pps.jm_jg_header WHERE job_number='$input_job_no' AND job_group_type='$tasktype' AND plant_code='$plant_code'";
            $header_result=mysqli_query($link, $get_jm_jg_header) or die("Error".$get_jm_jg_header.mysqli_error($GLOBALS["___mysqli_ston"]));
            while($header_row=mysqli_fetch_array($header_result))
            {
                $jm_jg_header_id=$header_row['jm_jg_header_id'];
            }    
            $sql="SELECT sum(jm_job_bundles.quantity) as quantity,jm_job_bundles.size as size,jm_job_bundles.fg_color as fg_color FROM $pps.`jm_job_bundles` LEFT JOIN $pps.`jm_product_logical_bundle` ON jm_job_bundles.`jm_pplb_id`=jm_product_logical_bundle.jm_pplb_id WHERE jm_jg_header_id='".$jm_jg_header_id."' AND feature_value='".$schedule."' AND jm_job_bundles.fg_color='".$color."' AND jm_job_bundles.plant_code='$plant_code' group by size";
            $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
            //echo mysqli_num_rows($sql_result)."<br>";
            if(mysqli_num_rows($sql_result) > 0){
                $final_data = [];
                while($row=mysqli_fetch_array($sql_result))
                {
                    $color = $row['fg_color'];
                    $size_name = $row['size'];
                    $size_qty = $row['quantity'];
                    
                    $mo_sql="SELECT oms_mo_details.mo_number as mo_no FROM $oms.`oms_mo_details` LEFT JOIN $oms.`oms_products_info` ON oms_mo_details.mo_number=oms_products_info.`mo_number` WHERE style='".$style."' AND SCHEDULE='".$schedule."' AND color_desc='".$color."' AND size_name='".$size_name."'";
                    $mo_sql_result=mysqli_query($link, $mo_sql) or die("Error".$mo_sql.mysqli_error($GLOBALS["___mysqli_ston"]));
                    $mo_numrows=mysqli_num_rows($mo_sql_result);
                    
                    if($mo_numrows>0){
                        while($mo_row=mysqli_fetch_array($mo_sql_result))
                        {
                            $mo_no = trim($mo_row['mo_no']);
                            $api_url = $host.":".$port."/m3api-rest/execute/PMS100MI/SelMaterials;returncols=MTNO,ITDS,CNQT,MSEQ,PRNO,MFNO,OPNO?CONO=$company_num&FACI=$plant_code&MFNO=".$mo_no;
                            
                            $api_data = $obj->getCurlAuthRequest($api_url);
                            
                            $api_data = json_decode($api_data, true);  
                            
                            $name_values = array_column($api_data['MIRecord'], 'NameValue');
                            foreach ($name_values as $key => $value2) {
                                $value2[] = ['Name' => 'color', 'Value' => $color];
                                $value2[] = ['Name' => 'size', 'Value' => $size_name];
                                $value2[] = ['Name' => 'size_qty', 'Value' => $size_qty];
                                $final_data[] = array_column($value2, 'Value', 'Name');
                            }
                        }      
                    }
                }
                $body.='<table width="100%">
                <thead style="background-color: whitesmoke;">
                    <tr>
                        <th>Item Code(SKU)</th>
                        <th>Item Description</th>
                        <th>Color</th>
                        <th>Color Description</th>
                        <th>Size</th>
                        <th>Z Code</th>
                        <th>Per Piece Consumption</th>  
                        <th>Wastage %</th>  
                        <th>Req.-With Wastage</th> 
                        <th>Req.-Without Wastage</th>
                        <th>UOM</th>                
                    </tr>
                </thead>
                <tbody>';
                if(count($final_data) >0){
                    $checkingitemcode_strim = [];
                    $checkingitemcode_ptrim = [];
                    foreach ($final_data as $key1 => $value1) {
                        $op_query = "SELECT * FROM $oms.oms_mo_operations LEFT JOIN $oms.oms_products_info ON  oms_products_info.mo_number=oms_mo_operations.mo_number WHERE style='".$style."' AND color_desc='".$value1['color']."' AND operation_code=".$value1['OPNO']." AND SMV > 0";
                        $op_sql_result = mysqli_query($link, $op_query) or die("Error".$op_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($op_sql_result) > 0){
                            $value1['trim_type'] = 'STRIM';
                            //call the api to get the wastage
                            $mfno = trim($value1['MFNO']);
                            $prno = urlencode($value1['PRNO']);
                            $mseq = $value1['MSEQ'];

                            $api_url_wastage = $host.":".$port."/m3api-rest/execute/PMS100MI/GetMatLine;returncols=WAPC,PEUN?CONO=$company_num&FACI=$plant_code&MFNO=$mfno&PRNO=$prno&MSEQ=$mseq";
                            $api_data_wastage = $obj->getCurlAuthRequest($api_url_wastage);                                 
                            $api_data_result = json_decode($api_data_wastage, true);
                              
                            $result_values = array_column($api_data_result['MIRecord'], 'NameValue');

                            if(!in_array($value1['MTNO'],$checkingitemcode_strim)){
                                $value1['UOM'] = $result_values[0][0]['Value'];
                                $value1['WITH_WASTAGE'] = ($value1['size_qty']*$value1['CNQT'])+($value1['size_qty']*$value1['CNQT']*$result_values[0][1]['Value']/100);
                                $value1['WITH_OUT_WASTAGE'] = ($value1['size_qty']*$value1['CNQT']);
                                $api_selected_valuess_strim[$value1['MTNO']] = $value1;
                                array_push($checkingitemcode_strim,$value1['MTNO']);
                            }else{
                                $api_selected_valuess_strim[$value1['MTNO']]['CNQT']+=$value1['CNQT'];
                                $api_selected_valuess_strim[$value1['MTNO']]['size_qty']+=$value1['size_qty'];
                                $api_selected_valuess_strim[$value1['MTNO']]['WITH_WASTAGE']+=($value1['size_qty']*$value1['CNQT'])+($value1['size_qty']*$value1['CNQT']*$result_values[0][1]['Value']/100);
                                    $api_selected_valuess_strim[$value1['MTNO']]['WITH_OUT_WASTAGE']+=($value1['size_qty']*$value1['CNQT']);
                            }
                        }
                       
                        $op_ptrim_query = "SELECT * FROM $oms.oms_mo_operations LEFT JOIN $oms.oms_products_info ON  oms_products_info.mo_number=oms_mo_operations.mo_number WHERE style='".$style."' AND color_desc='".$value1['color']."' AND operation_code=200";
                        $op_ptrim_sql_result = mysqli_query($link, $op_ptrim_query) or die("Error".$op_ptrim_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($op_ptrim_sql_result) > 0){
                            $value1['trim_type'] = 'PTRIM';                                
                            //call the api to get the wastage
                            $mfno = trim($value1['MFNO']);
                            $prno = urlencode($value1['PRNO']);
                            $mseq = $value1['MSEQ'];

                            $api_url_wastage = $host.":".$port."/m3api-rest/execute/PMS100MI/GetMatLine;returncols=WAPC,PEUN?CONO=$company_num&FACI=$plant_code&MFNO=$mfno&PRNO=$prno&MSEQ=$mseq";
                            $api_data_wastage = $obj->getCurlAuthRequest($api_url_wastage);                                 
                            $api_data_result = json_decode($api_data_wastage, true);
                              
                            $result_values = array_column($api_data_result['MIRecord'], 'NameValue');

                            if(!in_array($value1['MTNO'],$checkingitemcode_ptrim)){
                                $value1['WITH_WASTAGE'] = ($value1['size_qty']*$value1['CNQT'])+($value1['size_qty']*$value1['CNQT']*$result_values[0][1]['Value']/100);
                                $value1['WITH_OUT_WASTAGE'] = ($value1['size_qty']*$value1['CNQT']);
                                $value1['UOM'] = $result_values[0][0]['Value'];
                                $api_selected_valuess_ptrim[$value1['MTNO']] = $value1;
                                array_push($checkingitemcode_ptrim,$value1['MTNO']);
                            }else{
                                $api_selected_valuess_ptrim[$value1['MTNO']]['CNQT']+=$value1['CNQT'];
                                $api_selected_valuess_ptrim[$value1['MTNO']]['size_qty']+=$value1['size_qty'];
                                $api_selected_valuess_ptrim[$value1['MTNO']]['WITH_WASTAGE']+=($value1['size_qty']*$value1['CNQT'])+($value1['size_qty']*$value1['CNQT']*$result_values[0][1]['Value']/100);
                                $api_selected_valuess_ptrim[$value1['MTNO']]['WITH_OUT_WASTAGE']+=($value1['size_qty']*$value1['CNQT']);
                            }
                        }                                                 
                    }
                    
                    if(count($api_selected_valuess_strim)>0){
                        $body.='<tr style="background-color: whitesmoke;"><td colspan=11><center><strong>Sewing Trims</strong></center></td></tr>';
                        foreach($api_selected_valuess_strim as $api_selected_valuess){
                            $res_values = [];
                            $option_res_values_col = [];
                            $option_res_values_size = [];
                            $option_res_values_zcode = [];     
                        
                            //req without wastge
                            $api_selected_valuess['CNQT'] = $api_selected_valuess['WITH_OUT_WASTAGE']/$api_selected_valuess['size_qty'];
                            
                            //wastage calculation
                            $api_selected_valuess['WASTAGE'] =  (($api_selected_valuess['WITH_WASTAGE']-$api_selected_valuess['WITH_OUT_WASTAGE'])*100)/$api_selected_valuess['WITH_OUT_WASTAGE'];
                            
                            /* To Get color,size,z code  */
                            $ITNO = urlencode($api_selected_valuess['MTNO']);
                            $color_size_url = $host.":".$port."/m3api-rest/execute/MDBREADMI/GetMITMAHX1?CONO=$company_num&ITNO=$ITNO";
                            
                            $color_size_data = $obj->getCurlAuthRequest($color_size_url);                               
                            $color_size_result = json_decode($color_size_data, true);   
                            $color_size_values = array_column($color_size_result['MIRecord'], 'NameValue');
                            foreach($color_size_values as $values){
                                
                                $res_values[]  = array_column($values, 'Value','Name');
                            }                                
                            $color_res =  $res_values[0]['OPTY'];
                            $size_res = $res_values[0]['OPTX'];
                            $z_res = $res_values[0]['OPTZ'];
                            
                            /* To Get Option Description */
                            // for color description
                            if(trim($color_res)){
                                $option_des_url_col =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$color_res";
                        
                                $option_des_data_col = $obj->getCurlAuthRequest($option_des_url_col);                               
                                $option_des_result_col = json_decode($option_des_data_col, true);   
                                $option_des_values_col = array_column($option_des_result_col['MIRecord'], 'NameValue');
                                foreach($option_des_values_col as $values){                                    
                                    $option_res_values_col[]  = array_column($values, 'Value','Name');
                                }

                                if(trim($color_res) === trim($option_res_values_col[0]['OPTN'])){
                                    $option_des_col = $option_res_values_col[0]['TX30'];
                                }else{
                                    $option_des_col = "";
                                }
                            }else{
                                $option_des_col = "";
                            }
                            

                            // for size description
                            if(trim($size_res)){
                                $option_des_url_size =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$size_res";
                        
                                $option_des_data_size = $obj->getCurlAuthRequest($option_des_url_size);
                                $option_des_result_size = json_decode($option_des_data_size, true);   
                                $option_des_values_size = array_column($option_des_result_size['MIRecord'], 'NameValue');
                                foreach($option_des_values_size as $values){                                    
                                    $option_res_values_size[]  = array_column($values, 'Value','Name');
                                }

                                if(trim($size_res) === trim($option_res_values_size[0]['OPTN'])){
                                    $option_des_size = $option_res_values_size[0]['TX30'];
                                }else{
                                    $option_des_size = "";
                                }
                            }else{
                                $option_des_size = "";
                            }
                            

                            // for z-code description
                            if(trim($z_res)){
                                $option_des_url_zcode =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$z_res";
                                $option_des_data_zcode = $obj->getCurlAuthRequest($option_des_url_zcode);
                                $option_des_result_zcode = json_decode($option_des_data_zcode, true);   
                                $option_des_values_zcode = array_column($option_des_result_zcode['MIRecord'], 'NameValue');
                                foreach($option_des_values_zcode as $values){                                    
                                    $option_res_values_zcode[]  = array_column($values, 'Value','Name');
                                }

                                if(trim($z_res) === trim($option_res_values_zcode[0]['OPTN'])){
                                    $option_des_zcode = $option_res_values_zcode[0]['TX30'];
                                }else{
                                    $option_des_zcode = "";
                                }
                            }else{
                                $option_des_zcode = "";
                            }  
                            
                            $body.='<tr>
                            <td>'.$api_selected_valuess['MTNO'].'</td>
                            <td>'.$api_selected_valuess['ITDS'].'</td>
                            <td>'.$color_res.'</td> 
							<td>'.$option_des_col.'</td>                          
							<td><center>'.$option_des_size.'<center></td>
							<td>'.$option_des_zcode.'</td>
                            <td><span style="float:right;">'.number_format((float)$api_selected_valuess['CNQT'], 4).'</span></td>
                            <td><span style="float:right;">'.$api_selected_valuess['WASTAGE'].'</span></td>
                            <td><span style="float:right;">'.number_format((float)$api_selected_valuess['WITH_WASTAGE'], 2).'</span></td>
                            <td><span style="float:right;">'.number_format((float)$api_selected_valuess['WITH_OUT_WASTAGE'], 2).'</span></td>
                            <td>'.$api_selected_valuess['UOM'].'</td>
                        </tr>';
                            }
                        }    
                        if(count($api_selected_valuess_ptrim)>0){
                            $body.='<tr style="background-color: whitesmoke;"><td colspan=11><center><strong>Packing Trims</strong></center></td></tr>';
                            foreach($api_selected_valuess_ptrim as $api_selected_valuess){
                                $res_values = [];
                                $option_res_values_col = [];
                                $option_res_values_size = [];
                                $option_res_values_zcode = [];
                                
                                $api_selected_valuess['CNQT'] = $api_selected_valuess['WITH_OUT_WASTAGE']/$api_selected_valuess['size_qty'];
                            
                                //wastage calculation
                                $api_selected_valuess['WASTAGE'] =  (($api_selected_valuess['WITH_WASTAGE']-$api_selected_valuess['WITH_OUT_WASTAGE'])*100)/$api_selected_valuess['WITH_OUT_WASTAGE'];
								
								/* To Get color,size,z code  */
								$ITNO = urlencode($api_selected_valuess['MTNO']);
								$color_size_url = $host.":".$port."/m3api-rest/execute/MDBREADMI/GetMITMAHX1?CONO=$company_num&ITNO=$ITNO";
								
                                $color_size_data = $obj->getCurlAuthRequest($color_size_url);                               
                                $color_size_result = json_decode($color_size_data, true);   
								$color_size_values = array_column($color_size_result['MIRecord'], 'NameValue');
								foreach($color_size_values as $values){
									
									$res_values[]  = array_column($values, 'Value','Name');
                                }
								$color_res =  $res_values[0]['OPTY'];
                                $size_res = $res_values[0]['OPTX'];
                                $z_res = $res_values[0]['OPTZ'];

                                 /* To Get Option Description */
                                // for color description
                                if(trim($color_res)){
                                    $option_des_url_col =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$color_res";
                            
                                    $option_des_data_col = $obj->getCurlAuthRequest($option_des_url_col);                               
                                    $option_des_result_col = json_decode($option_des_data_col, true);   
                                    $option_des_values_col = array_column($option_des_result_col['MIRecord'], 'NameValue');
                                    foreach($option_des_values_col as $values){                                    
                                        $option_res_values_col[]  = array_column($values, 'Value','Name');
                                    }

                                    if(trim($color_res) === trim($option_res_values_col[0]['OPTN'])){
                                        $option_des_col = $option_res_values_col[0]['TX30'];
                                    }else{
                                        $option_des_col = "";
                                    }
                                }else{
                                    $option_des_col = "";
                                }

                                // for size description
                                if(trim($size_res)){
                                    $option_des_url_size =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$size_res";
                            
                                    $option_des_data_size = $obj->getCurlAuthRequest($option_des_url_size);
                                    $option_des_result_size = json_decode($option_des_data_size, true);   
                                    $option_des_values_size = array_column($option_des_result_size['MIRecord'], 'NameValue');
                                    foreach($option_des_values_size as $values){                                    
                                        $option_res_values_size[]  = array_column($values, 'Value','Name');
                                    }

                                    if(trim($size_res) === trim($option_res_values_size[0]['OPTN'])){
                                        $option_des_size = $option_res_values_size[0]['TX30'];
                                    }else{
                                        $option_des_size = "";
                                    }
                                }else{
                                    $option_des_size = "";
                                }
                                
                                // for z-code description
                                if(trim($z_res)){
                                    $option_des_url_zcode =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$z_res";
                                    $option_des_data_zcode = $obj->getCurlAuthRequest($option_des_url_zcode);
                                    $option_des_result_zcode = json_decode($option_des_data_zcode, true);   
                                    $option_des_values_zcode = array_column($option_des_result_zcode['MIRecord'], 'NameValue');
                                    foreach($option_des_values_zcode as $values){                                    
                                        $option_res_values_zcode[]  = array_column($values, 'Value','Name');
                                    }
    
                                    if(trim($z_res) === trim($option_res_values_zcode[0]['OPTN'])){
                                        $option_des_zcode = $option_res_values_zcode[0]['TX30'];
                                    }else{
                                        $option_des_zcode = "";
                                    }
                                }else{
                                    $option_des_zcode = "";
                                }
								
                                $body.='<tr>
                                <td>'.$api_selected_valuess['MTNO'].'</td>
                                <td>'.$api_selected_valuess['ITDS'].'</td>
                                <td>'.$color_res.'</td> 
                                <td>'.$option_des_col.'</td>                          
                                <td><center>'.$option_des_size.'<center></td>
                                <td>'.$option_des_zcode.'</td>
                                <td><span style="float:right;">'.number_format((float)$api_selected_valuess['CNQT'], 4).'</span></td>
                                <td><span style="float:right;">'.$api_selected_valuess['WASTAGE'].'</span></td>
                                <td><span style="float:right;">'.number_format((float)$api_selected_valuess['WITH_WASTAGE'], 2).'</span></td>
                                <td><span style="float:right;">'.number_format((float)$api_selected_valuess['WITH_OUT_WASTAGE'], 2).'</span></td>
                                <td>'.$api_selected_valuess['UOM'].'</td>
                            </tr>';
                         }
                        }      
                        $body.='<br>';
                }else{
                    $body.= '<tr>   
                        <td colspan=14><center><strong>No Records Found</strong></center></td>
                    </tr>';
                }                 
                $body.= '</tbody>   
                </table>                
                <hr style="border:1px solid black;">
                <br>';
                
            }
        }
    }
}

$mpdf->setHeader($header);
$mpdf->setFooter('<br/><table style="width:100%;border-style: none;">
<tbody>
	<tr>
      <td style="border-style: none;"><hr width=195><center><strong>Prepared By(Name/EPF No)</strong><center></td>
      <td style="padding-left:50px;border-style: none;"><hr width=190><center><strong>Issuer Name/EPF No</strong></center></td>
      <td style="padding-left:50px;border-style: none;"><hr width=180><center><strong>Receiver Name/EPF No</strong></center></td>
    </tr>
</tbody>
</table>
<br/>
<table style="width:100%;border-style: none;" >
<tbody >
	<tr >
      <td style="padding-left:30px;border-style: none;"><hr width=195><center><strong>Signature & Date</strong><center></td>
      <td style="padding-left:50px;border-style: none;"><hr width=170><center><strong>Signature & Date</strong></center></td>
      <td style="padding-left:50px;border-style: none;"><hr width=180><center><strong>Signature & Date</strong></center></td>
    </tr>
    </tbody>
</table>');
$bom_sheet = "$PDF_SERVER_IP/sfcs_app/common/lib/mpdf7/vendor/mpdf/mpdf/".$plant_code."_tms_bom_sheet.pdf";
$mpdf->WriteHTML($body);
error_reporting(E_ALL);
$filename='./vendor/mpdf/mpdf/'.$plant_code.'_tms_bom_sheet.pdf';
$mpdf->Output($filename,'F');
echo "<script>window.location.href =  '".$bom_sheet."';</script>";
exit();
?>
