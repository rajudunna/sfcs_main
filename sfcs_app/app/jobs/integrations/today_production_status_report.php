<?php
error_reporting(0);
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');
include('../../../common/config/config.php');
if($_GET['plantCode']){
    $plant_code = $_GET['plantCode'];
}else{
    $plant_code = $argv[1];
}
$username = $_SESSION['userName'];
$plant_code = 'AIP';
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
$select_ops="select operation_code from $pms.operation_mapping where operation_category='SEWING' and plant_code='$plant_code' and is_active=true order by priority DESC limit 1";
// echo $select_ops;
$result_ops=mysqli_query($link, $select_ops) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_ops=mysqli_fetch_array($result_ops))
{
    $ops_code=$sql_row_ops["operation_code"];
}
$plant_prefix='';
$select_prefix="select parent_workstation_id from $pms.operation_mapping where operation_code=$ops_code and plant_code=$plant_code and is_active=true";
$result_prefix=mysqli_query($link, $select_prefix) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($result_prefix) > 0)
{
    while($sql_row_prefix=mysqli_fetch_array($result_prefix))
    {
        $plant_prefix=$sql_row_prefix["parent_workstation_id"];
    }
}

if($ops_code != '')
{
    $data_result.='<table border=1><tr><th>Sno</th><th>Plant Code</th><th>Team</th><th>Module</th><th>Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Qty</th><th>SMV</th><th>SAH</th></tr>';
    $sah_total=0;
    set_time_limit(6000000);
    $i=0;	
    $sql="SELECT resource_id AS Module,DATE(updated_at) AS date,style,schedule,color,size,SUM(good_quantity) AS qty FROM $pts.transaction_log WHERE DATE(updated_at)=\"".$date."\" AND operation_id='".$ops_code."' GROUP BY DATE(updated_at),style,schedule,color,size,assigned_module ORDER BY DATE(updated_at),assigned_module*1,style,schedule,color,size";
    // echo $sql."<br>";
    $result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($result))
    {
        $i+=1;
        $mod=$sql_row['Module'];
        $get_module="select workstation_description from $pms.workstation where workstation_id='.$mod.'";
        $result_ops=mysqli_query($link, $get_module) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row_ops=mysqli_fetch_array($result_ops))
        {
            $module1=$sql_row_ops["workstation_description"];
        }
        $module=$plant_prefix.$module1;
        $production_date=$sql_row["date"];
        $style=$sql_row["style"];
        $schedule=$sql_row["schedule"];
        $color=$sql_row["color"];
        $size=$sql_row["size"];
        // change smv since we dont have smv in 2.0
        $smv=0;
        $qty=$sql_row["qty"];
        // change smh since we dont have smh in 2.0
        $sah=0;
        $sah_total=$sah_total+$sah;

        $sql_delete="DELETE FROM [$prod_status_database].[dbo].[BEL_Daily_N] WHERE Date='".$production_date."' and Facility='".$plant_prod_code."' and Team='".$module."' and style='".$style."' and schedule='".$schedule."' and colour='".$color."' and Size='".$size."'";
        // echo $sql_delete.";<br>";
        odbc_exec($connect, $sql_delete);  

        $sql_insert="INSERT INTO [$prod_status_database].[dbo].[BEL_Daily_N] VALUES('".$plant_prod_code."','".$module."','".$production_date."','".$style."','".$schedule."','".$schedule."','".$color."','".$size."','".$qty."','".$smv."','".$sah."')";
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