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
@media print{
    @page { margin: 0;}
    body{
        font-size:22px;
    }
    .visible-print  { display: inherit !important; }
    .hidden-print   { display: none !important; }

}
</style>
<script>
function printPreview(){
    var printid = document.getElementById("printid");
    printid.style.visibility = 'hidden';
    window.print();
    printid.style.visibility = 'visible';
}
</script>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
?>
<div class="panel panel-primary">
    <div class="panel-heading"><center><button onclick="printPreview()" id="printid" style="float:left;color:blue;">Print</button><strong>Job Wise Sewing and Packing Trim Requirement Report - <?= $plant_name ?></strong></center></div>
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
        $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job_no,$link);
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
                //echo $sql."<br/>";
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
                                $mo_no = $mo_row['mo_no'];
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
                        foreach ($final_data as $key1 => $value1) {
							$op_query = "select * from $bai_pro3.schedule_oprations_master where Style= '".$style."' and description = '".$value1['color']."' and Main_OperationNumber = '".$value1['OPNO']."' and SMV > 0";
							
                            $op_sql_result = mysqli_query($link, $op_query) or die("Error".$op_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                            if(mysqli_num_rows($op_sql_result) > 0){
                                $value1['trim_type'] = 'STRIM';
                                $api_selected_valuess_strim[] = $value1;
                            }
                           
                            $op_ptrim_query = "select * from $bai_pro3.schedule_oprations_master where Style= '".$style."' and description = '".$value1['color']."' and Main_OperationNumber = '".$value1['OPNO']."' and Main_OperationNumber = 200";
                            $op_ptrim_sql_result = mysqli_query($link, $op_ptrim_query) or die("Error".$op_ptrim_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                            if(mysqli_num_rows($op_ptrim_sql_result) > 0){
                                $value1['trim_type'] = 'PTRIM';
                                $api_selected_valuess_ptrim[] = $value1;
                            }                                                 
                        }
                        if(count($api_selected_valuess_strim)>0){?>
                            <tr style="background-color: whitesmoke;"><td colspan=11><center><strong>Sewing Trims</strong></center></td></tr>
                        <?php
                            foreach($api_selected_valuess_strim as $api_selected_valuess){
                                $res_values = [];
                                $option_res_values = [];                  
                                $mfno = $api_selected_valuess['MFNO'];
                                $prno = urlencode($api_selected_valuess['PRNO']);
                                $mseq = $api_selected_valuess['MSEQ'];
                                $api_url_wastage = $host.":".$port."/m3api-rest/execute/MDBREADMI/GetMWOMATX3;returncols=WAPC,PEUN?CONO=$company_num&FACI=$plant_code&MFNO=$mfno&PRNO=$prno&MSEQ=$mseq";
                                $api_data_wastage = $obj->getCurlAuthRequest($api_url_wastage);                                 
                                $api_data_result = json_decode($api_data_wastage, true);   
                                $result_values = array_column($api_data_result['MIRecord'], 'NameValue');  
                            
                                //req without wastge
                                $reqwithoutwastage = $api_selected_valuess['CNQT']*$api_selected_valuess['size_qty'];

                                //req with wastge                               
								$reqwithwastage = $reqwithoutwastage+($reqwithoutwastage*$result_values[0][1]['Value']/100);
								
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
                                $option_des_url =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$size_res";
                            
                                $option_des_data = $obj->getCurlAuthRequest($option_des_url);                               
                                $option_des_result = json_decode($option_des_data, true);   
                                $option_des_values = array_column($option_des_result['MIRecord'], 'NameValue');
                                foreach($option_des_values as $values){                                    
                                    $option_res_values[]  = array_column($values, 'Value','Name');
                                }

                                if(trim($size_res) === trim($option_res_values[0]['OPTN'])){
                                    $option_des = $option_res_values[0]['TX30'];
                                }else{
                                    $option_des = "";
                                }
                        ?>

                        <tr>
                            <td><?= $api_selected_valuess['MTNO'] ?></td>
                            <td><?= $api_selected_valuess['ITDS'] ?></td>
                            <td><?= $color_res ?></td> 
							<td><?= $option_des ?></td>                          
							<td><center><?= $size_res; ?><center></td>
							<td><?= $z_res ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['CNQT'], 4)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".$result_values[0][1]['Value']."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$reqwithwastage, 2)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$reqwithoutwastage, 2)."</span>";?></td>
                            <td><?= $result_values[0][0]['Value'] ?></td>
                        </tr>
                        <?php }
                        }    
                        if(count($api_selected_valuess_ptrim)>0){?>
                            <tr style="background-color: whitesmoke;"><td colspan=11><center><strong>Packing Trims</strong></center></td></tr>
                        <?php
                            foreach($api_selected_valuess_ptrim as $api_selected_valuess){
                                $res_values = [];
                                $option_res_values = [];
                                $mfno = $api_selected_valuess['MFNO'];
                                $prno = urlencode($api_selected_valuess['PRNO']);
                                $mseq = $api_selected_valuess['MSEQ'];
                                $api_url_wastage = $host.":".$port."/m3api-rest/execute/MDBREADMI/GetMWOMATX3;returncols=WAPC,PEUN?CONO=$company_num&FACI=$plant_code&MFNO=$mfno&PRNO=$prno&MSEQ=$mseq";
                                $api_data_wastage = $obj->getCurlAuthRequest($api_url_wastage);                                 
								$api_data_result = json_decode($api_data_wastage, true);
								  
                                $result_values = array_column($api_data_result['MIRecord'], 'NameValue');
                                
                                //req without wastge
                                $reqwithoutwastage = $api_selected_valuess['CNQT']*$api_selected_valuess['size_qty'];

                                //req with wastge                               
								$reqwithwastage = $reqwithoutwastage+($reqwithoutwastage*$result_values[0][1]['Value']/100);
								
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
                                 $option_des_url =$host.":".$port."/m3api-rest/execute/PDS050MI/Get?CONO=$company_num&OPTN=$size_res";
                                
                                 $option_des_data = $obj->getCurlAuthRequest($option_des_url);                               
                                 $option_des_result = json_decode($option_des_data, true);   
                                 $option_des_values = array_column($option_des_result['MIRecord'], 'NameValue');
                                 foreach($option_des_values as $values){                                    
                                     $option_res_values[]  = array_column($values, 'Value','Name');
                                 }
 
                                 if(trim($size_res) === trim($option_res_values[0]['OPTN'])){
                                     $option_des = $option_res_values[0]['TX30'];
                                 }else{
                                     $option_des = "";
                                 }
								
                        ?>
                        <tr>
                            <td><?= $api_selected_valuess['MTNO'] ?></td>
                            <td><?= $api_selected_valuess['ITDS'] ?></td>
                            
							<td><?= $color_res ?></td>  
							<td><?= $option_des ?></td>                          
							<td><center><?= $size_res; ?><center></td>
							<td><?= $z_res ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$api_selected_valuess['CNQT'], 4)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".$result_values[0][1]['Value']."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$reqwithwastage, 2)."</span>"; ?></td>
                            <td><?php echo "<span style='float:right;'>".number_format((float)$reqwithoutwastage, 2)."</span>";?></td>
                            <td><?=  $result_values[0][0]['Value'] ?></td>
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
