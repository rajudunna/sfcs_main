<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<?php
error_reporting(0);
// class get_api_call {
function getCurlRequest($url){
	$basic_auth=base64_encode('BEL_SFCS:brandix@321');
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_PORT => "22105",
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Authorization: Basic ".$basic_auth,
			"Cache-Control: no-cache",
			"Content-Type: application/json"
			// "Postman-Token: df10b2f5-8494-4d56-a7b0-d41c05016563"
			),
		));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

        if ($err) 
        {
            return "cURL Error #:" . $err;
        } 
        else
        {
            return $response;
        }
	}
// }
//include("header.php");
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_jobs.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 

$plant_code = 'EKG';
$company_num = '200';

$schedule=$_GET['schedule'];
$style=$_GET['style'];
$input_job_no=$_GET['input_job'];

$color=array();
$sql="select * from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' and input_job_no='".$input_job_no."'  group by order_col_des";
$sql_result=mysqli_query($link, $sql) or die("Error".$sql.mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result) > 0){?>
<div class="panel panel-primary">
    <div class="panel-heading"><center>Job Wise
  Sewing and Packing Trim Requirement Report - KOGGALA</center></div>
    <div class="panel-body">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Style</th>
            <th>Schedule</th>
            <th>Color</th>
            <th>Size</th>
            <th>Size Qty</th>
            <th>MO NO</th>
            <th>Product Type</th>
            <th>Material Seq</th>
            <th>Material Item Code</th>
            <th>Consumption</th>
            <th>OP Code</th>
            <th>Finish Good SKU</th>
            <th>Final Qty</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
<?php
$slno = 0;
    while($row=mysqli_fetch_array($sql_result))
    {
        $color = $row['order_col_des'];
        $size_name = $row['size_code'];
        $size_qty = $row['carton_act_qty'];
        $all_data[]=$row;

        $mo_sql="select * from $bai_pro3.mo_details where style='".$style."' and schedule='".$schedule."' and color='".$color."' and size='".$size_name."'  ";
        // echo $mo_sql;
        $mo_sql_result=mysqli_query($link, $mo_sql) or die("Error".$mo_sql.mysqli_error($GLOBALS["___mysqli_ston"]));

        while($mo_row=mysqli_fetch_array($mo_sql_result))
        {
            // $mo_details = ['1991686', '1991678'];
            foreach($mo_details as $key => $value){
                // $mo_no = $mo_row['mo_no'];
                $mo_no = $value;
                // $mo_data[] = $mo_row;
                $api_url = "http://eka-mvxsod-01.brandixlk.org:22105/m3api-rest/execute/PMS100MI/SelMaterials?CONO=$company_num&FACI=$plant_code&MFNO=".$mo_no ;
                $api_data = getCurlRequest($api_url);
                $api_data = json_decode($api_data, true);
                $name_values = array_column($api_data['MIRecord'], 'NameValue');

                foreach ($name_values as $key => $value2) {
                    $final_data[] = array_column($value2, 'Value', 'Name');
                }
                foreach ($final_data as $key1 => $value1) {

                    $op_query = "select * from $brandix_bts.tbl_style_ops_master where style= '".$style."' and color = '".$color."' and operation_order = '".$value1['OPNO']."' and m3_smv > 0";
                    
                    $op_sql_result = mysqli_query($link, $op_query) or die("Error".$op_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($op_sql_result) > 0){
                        $value1['trim_type'] = 'STRIM';
                        $api_selected_values[] = $value1;
                    }
                    $op_ptrim_query = "select * from $brandix_bts.tbl_style_ops_master where style= '".$style."' and color = '".$color."' and operation_order = '".$value1['OPNO']."' and operation_order = 200";

                    $op_ptrim_sql_result = mysqli_query($link, $op_ptrim_query) or die("Error".$op_ptrim_query.mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($op_ptrim_sql_result) > 0){
                        $value1['trim_type'] = 'PTRIM';
                        $api_selected_values[] = $value1;
                    }
                }
                if(sizeof($api_selected_values) > 0){
                    foreach($api_selected_values as $key3 => $value3){ $slno++;?>
                        <tr>
                            
                            <td><?= $slno ?></td>
                            <td><?= $style?></td>
                            <td><?= $schedule ?></td>
                            <td><?= $color ?></td>
                            <td><?= $size_name?></td>
                            <td><?= $size_qty?></td>
                            <td><?= $mo_no?></td>
                            <td><?= $value3['trim_type']?></td>
                            <td><?= $value3['MSEQ']?></td>
                            <td><?= $value3['MTNO']?></td>
                            <td><?= $value3['CNQT']?></td>
                            <td><?= $value3['OPNO']?></td>
                            <td><?= $value3['PRNO']?></td>
                            <td><?= number_format($value3['CNQT'] * $size_qty, 4, '.', '') ?></td>
                        </tr>
            <?php   }
                }
            }
        }
        
    }
    // var_dump($mo_data);

}
?>
</tbody>
</table>
</div>
</div>
</div>

