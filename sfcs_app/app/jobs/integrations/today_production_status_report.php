<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	
$data_result='';
$connect = odbc_connect("$prod_status_driver_name;Server=$prod_status_server_name;Database=$prod_status_database;", $prod_status_username,$prod_status_password);

if(isset($_GET["date"]))
{
    $date=$_GET["date"];
}
else
{
    $date=date("Y-m-d");
}

$select_ops="select * from brandix_bts.tbl_ims_ops where appilication='IMS_OUT'";
$result_ops=mysqli_query($link, $select_ops) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_ops=mysqli_fetch_array($result_ops))
{
    $ops_code=$sql_row_ops["operation_code"];
}

$plant_prefix='';
$select_prefix="select * from $brandix_bts.tbl_orders_ops_ref where operation_name='Sewing out'";
$result_prefix=mysqli_query($link, $select_prefix) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($result_prefix) > 0)
{
    while($sql_row_prefix=mysqli_fetch_array($result_prefix))
    {
        $plant_prefix=$sql_row_prefix["parent_work_center_id"];
    }
}

if($ops_code != '')
{
    $data_result.='<table border=1><tr><th>Sno</th><th>Plant Code</th><th>Team</th><th>Module</th><th>Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Qty</th><th>SMV</th><th>SAH</th></tr>';
    $sah_total=0;
    set_time_limit(6000000);
    $i=0;	
    $sql="SELECT assigned_module AS Module,DATE(date_time) AS date,style,schedule,color,size_title,ROUND(sfcs_smv,4) AS SMV,SUM(recevied_qty) AS qty,ROUND(SUM(recevied_qty*sfcs_smv/60),4) AS SAH FROM brandix_bts.bundle_creation_data_temp WHERE DATE(date_time)=\"".$date."\" AND operation_id='".$ops_code."' GROUP BY DATE(date_time),style,schedule,color,size_title,sfcs_smv,assigned_module ORDER BY DATE(date_time),assigned_module*1,style,schedule,color,size_title,sfcs_smv";
    // echo $sql."<br>";
    $result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($result))
    {
        $i+=1;
        $module=$plant_prefix.$sql_row["Module"];
        $production_date=$sql_row["date"];
        $style=$sql_row["style"];
        $schedule=$sql_row["schedule"];
        $color=$sql_row["color"];
        $size=$sql_row["size_title"];
        $smv=$sql_row["SMV"];
        $qty=$sql_row["qty"];
        $sah=$sql_row["SAH"];
        $sah_total=$sah_total+$sah;

        $sql_delete="DELETE FROM [SAH].[dbo].[BEL_Daily_N] WHERE Date='".$production_date."' and Facility='".$plant_prod_code."' and Team='".$module."' and style='".$style."' and schedule='".$schedule."' and colour='".$color."' and Size='".$size."'";
        // echo $sql_delete.";<br>";
        odbc_exec($connect, $sql_delete);  

        $sql_insert="INSERT INTO [SAH].[dbo].[BEL_Daily_N] VALUES('".$plant_prod_code."','".$module."','".$production_date."','".$style."','".$schedule."','".$schedule."','".$color."','".$size."','".$qty."','".$smv."','".$sah."')";
        // echo $sql_insert.";<br><br>";
        odbc_exec($connect, $sql_insert);  

        $data_result.="<tr><th>".$i."</th><th>".$plant_prod_code."</th><th>".$plant_prod_code."SOT".$module."</th><th>".$module."</th><th>".$production_date."</th><th>".$style."</th><th>".$schedule."</th><th>".$color."</th><th>".$size."</th><th>".$qty."</th><th>".$smv."</th><th>".$sah."</th></tr>";     
            
    }   
    $data_result.="</table>";
    // echo "SAH Total=".$sah_total."<br>";
}
// echo $data_result."<br>";
$include_path=getenv('config_job_path');
$directory = $include_path.'\sfcs_app\app\jobs\integrations\\'.$facility_code;
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
}
$date = $date;
$current_date =  $date;
$file_name_string = $date.'_bel_sah_log.html';
$my_file = $include_path.'\sfcs_app\app\jobs\integrations\\'.$facility_code.'\\'.$file_name_string;
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
$file_data_request = $data_result;
fwrite($handle,"\n".$file_data_request); 

fclose($handle);  

$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>