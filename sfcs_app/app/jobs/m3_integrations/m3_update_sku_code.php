<?php
$start_timestamp = microtime(true);
error_reporting(0);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include($include_path.'\sfcs_app\common\config\m3_api_calls.php');
$company_no='200';
$faci='EKG';

$mo_sql="select distinct mo_no as mo_no from $bai_pro3.mo_details where (product_sku is NULL) or product_sku ='' ";
$mo_sql_result=mysqli_query($link, $mo_sql) or die("Error123".mysqli_error($GLOBALS["___mysqli_ston"]));

while($mo_row=mysqli_fetch_array($mo_sql_result))
{
    $mo_details[]=$mo_row['mo_no'];
}
$count=0;
foreach($mo_details as $key => $value)
{
    $mo_no = $value;
    $start = microtime(true);
    $obj1 = new get_api_call(); 
    $api_url = "http://eka-mvxsod-01.brandixlk.org:22105/m3api-rest/execute/PMS100MI/SelMaterials?CONO=$company_no&FACI=$faci&MFNO=".$mo_no ;
    echo $api_url;
    $end = microtime(true);
    $dur = $end - $start;
    print($dur." seconds")."\n";
    $result = $obj1->getCurlRequest($api_url);  
    $api_data = json_decode($result, true);
    // var_dump($api_data);
    if($api_data['@type'])
    {
        continue;
    }
    $name_values = array_column($api_data['MIRecord'], 'NameValue');
    
    foreach ($name_values as $key => $value1) 
    {
        $final_data[] = array_column($value1, 'Value', 'Name');
            
    }
    //   var_dump($final_data);     
    foreach ($final_data as $key1 => $value2) 
    {
        $mfno[$value2['MFNO']]= $value2['PRNO'];
    }
    $update_qry = "update $bai_pro3.mo_details set product_sku='$mfno[$value]' where mo_no =$mo_no";
    // echo $update_qry."<br>";
    $update_qry_result = mysqli_query($link, $update_qry) or die("update_qry error".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($update_qry_result)
    {
        print('Updated Sku_code for'.$mo_no)."\n";
    }             
}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." seconds.");

  

