<head>
    <link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
    <title></title>
</head>
<style>
table, th, td {
    border: 1px solid black;
    font-size: small;
}
body
{
    font-family: Calibri;
    font-size: 11px;
}
</style>
<script>
function printPreview(){
    var style = document.getElementById('style').value;
    var schedule = document.getElementById('schedule').value;
    var input_job = document.getElementById('input_job_no').value;
    
    var url = 'bom_sheet_print.php?schedule='+schedule+'&style='+style+'&input_job='+input_job;
    newwindow=window.open(url,'Job Wise Sewing and Packing Trim Requirement Report','height=500,width=800');
    if (window.focus) {newwindow.focus()}
    return false;
}
</script>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
?>
<div class="panel panel-primary">
    <div class="panel-heading"><center><button onclick="return printPreview()" id="printid" style="float:left;color:blue;">Print</button><strong>Job Wise Sewing and Packing Trim Requirement Report - <?= $plant_name ?></strong></center></div>
    <div class="panel-body">
<?php
//error_reporting(0);
//include("header.php");
$plant_code = $global_facility_code;
$company_num = $company_no;
$host= $api_hostname;
$port= $api_port_no;

$schedule=$_GET['schedule'];
$style=$_GET['style'];
$input_job_no=$_GET['input_job'];

echo "<input type='hidden' id='style' value='".$_GET['style']."'>
<input type='hidden' id='schedule' value='".$_GET['schedule']."'>
<input type='hidden' id='input_job_no' value='".$_GET['input_job']."'>";

$colors=[];
$sql="select order_col_des from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' group by order_col_des";
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result))
{
    $colors[]=$row['order_col_des'];
}
if(count($colors)>0){
    foreach($colors as $key=>$color){ 
        $api_selected_valuess_strim = [];
        $api_selected_valuess_ptrim = [];
        $size_code=array();
        $size_code_qty=array();
        unset($size_code);
        unset($size_code_qty);
        $sql="select size_code,sum(carton_act_qty) as carton_act_qty from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and order_col_des='".$color."' and input_job_no='".$input_job_no."' group by size_code";
        $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
        $colorrows = mysqli_num_rows($sql_result);
        while($row=mysqli_fetch_array($sql_result))
        {
            $size_code[]=strtoupper($row['size_code']);
            $size_code_qty[]=$row['carton_act_qty'];
        }
        
        $limit=40; 
        $limit1=40; 
        $size_count = count($size_code);         
        if($colorrows >0){
            ?>
            <div class="row">
                <div style="float:left; padding-left: 20px;">
                    <table width=100%>
                        <tbody>
                            <tr><td><b>Style No:</b></td><td><?=$style?></td></tr>
                            <tr><td><b>Schedule No:</b></td><td><?=$schedule?></td></tr>
                            <tr><td><b>Color:</b></td><td><?=$color?></td></tr>
                            <tr><td><b>Job No:</b></td><td><?=$input_job_no?></td></tr>
                        </tbody>
                    </table>
                </div>
                <div style="border:1px solid black; float:right;margin-right: 20px;"><strong><center>Company :- Brandix Group of Companies<center></strong></div>
            </div>
            <br>
            <div class="row">
                <div style="float:left; padding-left: 20px;">
                    <table width=100%>
                        <tbody>
                        <?php
                         $j=0;
                        for($k=0;$k<=$size_count;$k++) 
                        { ?>                          
                            <tr><td><b>Size:</b></td>
                                <?php for($i=$j;$i<$limit;$i++){if($size_code[$i]){
                                echo '<td>'.$size_code[$i].'</td>';}
                                 } ?>
                            </tr>
                            <tr><td><b>Quantity:</b></td>
                                <?php for($i=$j;$i<$limit;$i++){if($size_code_qty[$i]){
                                     echo '<td>'.$size_code_qty[$i].'</td>';
                                }
                            $j++; } ?>
                            </tr>
                        <?php 
                            $limit = $limit+$limit1;
                            if($limit>= ($size_count+$limit1)){
                                break;
                            }
                            
                        }  ?>           
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <?php
                $sql="select order_col_des,size_code,SUM(carton_act_qty) as carton_act_qty from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job_no."' and order_col_des='".$color."' group by size_code";
                $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
                //echo mysqli_num_rows($sql_result)."<br>";
                if(mysqli_num_rows($sql_result) > 0){
                    $final_data = [];
                    while($row=mysqli_fetch_array($sql_result))
                    {
                        $color = $row['order_col_des'];
                        $size_name = $row['size_code'];
                        $size_qty = $row['carton_act_qty'];
                
                        $mo_sql="select * from $bai_pro3.mo_details where style='".$style."' and schedule='".$schedule."' and color='".$color."' and size='".$size_name."'";
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
                    }?>
                    <table width="100%">
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
                        <tbody>
                    <?php
                    if(count($final_data) >0){
                        $checkingitemcode_strim = [];
                        $checkingitemcode_ptrim = [];
                        foreach ($final_data as $key1 => $value1) {
                            if($value1['OPNO'] != 200){
                                $op_query = "select * from $bai_pro3.schedule_oprations_master where Style= '".$style."' and description = '".$value1['color']."' and Main_OperationNumber = ".$value1['OPNO']." and SMV > 0";
                                $op_sql_result = mysqli_query($link, $op_query) or die("Error".$op_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                                if(mysqli_num_rows($op_sql_result) > 0){
                                    $value1['trim_type'] = 'STRIM';
                                    //call the api to get the wastage
                                    $mfno = trim($value1['MFNO']);
                                    $prno = urlencode($value1['PRNO']);
                                    $mseq = $value1['MSEQ'];

                                    $api_url_wastage = $host.":".$port."/m3api-rest/execute/MDBREADMI/GetMWOMATX3;returncols=WAPC,PEUN?CONO=$company_num&FACI=$plant_code&MFNO=$mfno&PRNO=$prno&MSEQ=$mseq";
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
                            }
                            if($value1['OPNO'] == 200){
                                $op_ptrim_query = "select * from $bai_pro3.schedule_oprations_master where Style= '".$style."' and description = '".$value1['color']."' and Main_OperationNumber = 200";
                                $op_ptrim_sql_result = mysqli_query($link, $op_ptrim_query) or die("Error".$op_ptrim_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                                if(mysqli_num_rows($op_ptrim_sql_result) > 0){
                                    $value1['trim_type'] = 'PTRIM';                                
                                    //call the api to get the wastage
                                    $mfno = trim($value1['MFNO']);
                                    $prno = urlencode($value1['PRNO']);
                                    $mseq = $value1['MSEQ'];

                                    $api_url_wastage = $host.":".$port."/m3api-rest/execute/MDBREADMI/GetMWOMATX3;returncols=WAPC,PEUN?CONO=$company_num&FACI=$plant_code&MFNO=$mfno&PRNO=$prno&MSEQ=$mseq";
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
                                                                             
                        }
                        
                        if(count($api_selected_valuess_strim)>0){?>
                            <tr style="background-color: whitesmoke;"><td colspan=11><center><strong>Sewing Trims</strong></center></td></tr>
                        <?php
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
                               
                        ?>

                        <tr>
                            <td><?= $api_selected_valuess['MTNO'] ?></td>
                            <td><?= $api_selected_valuess['ITDS'] ?></td>
                            <td><?= $color_res ?></td> 
                            <td><?= $option_des_col ?></td>                          
                            <td><center><?= $option_des_size ?><center></td>
                            <td><?= $option_des_zcode ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['CNQT'], 4)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".$api_selected_valuess['WASTAGE']."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['WITH_WASTAGE'], 2)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['WITH_OUT_WASTAGE'], 2)."</span>";?></td>
                            <td><?= $api_selected_valuess['UOM'] ?></td>
                        </tr>
                        <?php }
                        }    
                        if(count($api_selected_valuess_ptrim)>0){?>
                            <tr style="background-color: whitesmoke;"><td colspan=11><center><strong>Packing Trims</strong></center></td></tr>
                        <?php
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
                                
                        ?>
                        <tr>
                            <td><?= $api_selected_valuess['MTNO'] ?></td>
                            <td><?= $api_selected_valuess['ITDS'] ?></td>
                            <td><?= $color_res ?></td>  
                            <td><?= $option_des_col ?></td>                          
                            <td><center><?= $option_des_size ?><center></td>
                            <td><?= $option_des_zcode ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['CNQT'], 4)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".$api_selected_valuess['WASTAGE']."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['WITH_WASTAGE'], 2)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['WITH_OUT_WASTAGE'], 2)."</span>";?></td>
                            <td><?=  $api_selected_valuess['UOM'] ?></td>
                        </tr>
                        <?php }
                        }                        
                        ?>    
                    <br> 
                    <?php
                }else{?>
                    <tr>   
                        <td colspan=14><center><strong>No Records Found</strong></center></td>
                    </tr>
                <?php }?>                 
                    </tbody>   
                </table>                
                <hr style="border:1px solid black;">
                <br>
            <?php
            }
        }
    }
}

?>
</div>
</div>
