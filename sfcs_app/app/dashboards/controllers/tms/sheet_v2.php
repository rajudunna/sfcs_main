<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<style>
body{
    padding-right: 10px;
    padding-left: 10px;
    font-size:18;
}
table, th, td {
    border: 1px solid black;
}
@media print{
    @page { margin: 0; }
    .visible-print  { display: inherit !important; }
    .hidden-print   { display: none !important; }
}
</style>
<div class="panel panel-primary">
    <div class="panel-heading"><center><strong>Job Wise Sewing and Packing Trim Requirement Report - KOGGALA</strong></center></div>
    <div class="panel-body">       
<?php
//error_reporting(0);
//include("header.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 

$plant_code = 'EKG';
$company_num = '200';

$schedule=$_GET['schedule'];
$style=$_GET['style'];
$input_job_no=$_GET['input_job'];


// $sql="select operation_code from $brandix_bts.tbl_orders_ops_ref where category='Sewing'";	 
// $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
// $row=mysqli_fetch_array($sql_result);


$colors=[];
$sql="select order_col_des from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' group by order_col_des";	 
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
while($row=mysqli_fetch_array($sql_result))
{
	$colors[]=$row['order_col_des'];
}

if(count($colors)>0){
    foreach($colors as $key=>$color){ 
        $size_code=array();
        $size_code_qty=array();
        unset($size_code);
        unset($size_code_qty);
        $sql="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and order_col_des='".$color."' and input_job_no='".$input_job_no."'";
        $sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
        $colorrows = mysqli_num_rows($sql_result);
        while($row=mysqli_fetch_array($sql_result))
        {
            $size_code[]=strtoupper($row['size_code']);
            $size_code_qty[]=$row['carton_act_qty'];
        }
        $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color[$ii],$input_job_no,$link);
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
                <div style="border:1px solid black; float:right;margin-right: 20px;"><b><center>Company :- Brandix Group of Companies<center></b></div>
            </div>
            <br>
            <div class="row">
                <div style="float:left; padding-left: 20px;">
                    <table width=100%>
                        <tbody>
                            <tr><td><b>Size:</b></td>
                                <?php for($i=0;$i<sizeof($size_code);$i++){?>
                                <td><?=$size_code[$i];?></td>
                                <?php } ?>
                            </tr>
                            <tr><td><b>Quantity:</b></td>
                                <?php for($i=0;$i<sizeof($size_code_qty);$i++){?>
                                <td><?=$size_code_qty[$i];?></td>
                                <?php } ?>
                            </tr>                        
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <?php
                $sql="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job_no."'  group by order_col_des,size_code";
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
                
                        $mo_sql="select * from $bai_pro3.mo_details where style='".$style."' and schedule='".$schedule."' and color='".$color."' and size='".$size_name."'  ";
                        $mo_sql_result=mysqli_query($link, $mo_sql) or die("Error".$mo_sql.mysqli_error($GLOBALS["___mysqli_ston"]));
                        $mo_numrows=mysqli_num_rows($mo_sql_result);
                        if($mo_numrows>0){
                            while($mo_row=mysqli_fetch_array($mo_sql_result))
                            {
                                $mo_no = $mo_row['mo_no'];
                                $api_url = "http://eka-mvxsod-01.brandixlk.org:22105/m3api-rest/execute/PMS100MI/SelMaterials?CONO=$company_num&FACI=$plant_code&MFNO=".$mo_no ;
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
                    <table width=100%>
                        <thead style="background-color: lightgrey;">
                            <tr>
                                <th>Item Code(SKU)</th>
                                <th>Item Description</th>
                                <th>Colour</th>
                                <th>Size</th>
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
                            $op_query = "select * from $brandix_bts.tbl_style_ops_master where style= '".$style."' and color = '".$value1['color']."' and operation_order = '".$value1['OPNO']."' and m3_smv > 0";
                            $op_sql_result = mysqli_query($link, $op_query) or die("Error".$op_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                            if(mysqli_num_rows($op_sql_result) > 0){
                                $value1['trim_type'] = 'STRIM';
                                $api_selected_valuess = $value1;
                            }
                            
                            $op_ptrim_query = "select * from $brandix_bts.tbl_style_ops_master where style= '".$style."' and color = '".$value1['color']."' and operation_order = '".$value1['OPNO']."' and operation_order = 200";
                            $op_ptrim_sql_result = mysqli_query($link, $op_ptrim_query) or die("Error".$op_ptrim_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                            if(mysqli_num_rows($op_ptrim_sql_result) > 0){
                                $value1['trim_type'] = 'PTRIM';
                                $api_selected_valuess = $value1;
                            }
                            if($api_selected_valuess){ $slno++;?>
                            <tr>
                                <td><?= $api_selected_valuess['MTNO'] ?></td>
                                <td><?= $api_selected_valuess['ITDS'] ?></td>
                                <td><?= $api_selected_valuess['color'] ?></td>
                                <td><?= $api_selected_valuess['size'] ?></td>
                                <td><?= $api_selected_valuess['MTNO'] ?></td>
                                <td><?= $api_selected_valuess['MTNO'] ?></td>
                                <td><?= $api_selected_valuess['REQT'] ?></td>
                                <td><?= $api_selected_valuess['MTNO'] ?></td>
                                <td><?= $api_selected_valuess['PEUN'] ?></td>

                            </tr>
                            <?php 
                            }
                        }?>     
                    </tbody>   
                    </table>
                    <hr style="border:1px solid black;">
                    <br> 
                    <?php
                }else{?>
                    <tr>   
                        <td colspan=14><center><strong>No Records Found</strong></center></td>
                    </tr>
                <?php }    
            }
        }
    }
}

?>
</div>
</div>