<?php
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');	

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

if($ops_code != '')
{
    $sql_delete="DELETE FROM [SAH].[dbo].[BEL_Daily_N] where date='".$date."' and Facility='".$plant_prod_code."'";
    echo $sql_delete."<br>";
    odbc_exec($connect, $sql_delete);
    $sah_total=0;
    set_time_limit(6000000);
    $i=0;	
    $sql="SELECT assigned_module AS Module,DATE(date_time) AS date,style,schedule,color,size_title,ROUND(sfcs_smv,4) AS SMV,SUM(recevied_qty) AS qty,ROUND(SUM(recevied_qty*sfcs_smv/60),4) AS SAH FROM brandix_bts.bundle_creation_data_temp WHERE DATE(date_time)=\"".$date."\" AND operation_id='".$ops_code."' GROUP BY style,schedule,color,size_title,sfcs_smv,assigned_module ORDER BY style,schedule,color,size_title,sfcs_smv,assigned_module";
    echo $sql."<br>";
    $result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($result))
    {
        $i+=1;
        $module=$sql_row["Module"];
        $production_date=$sql_row["date"];
        $style=$sql_row["style"];
        $schedule=$sql_row["schedule"];
        $color=$sql_row["color"];
        $size=$sql_row["size_title"];
        $smv=$sql_row["SMV"];
        $qty=$sql_row["qty"];
        $sah=$sql_row["SAH"];
        $sah_total=$sah_total+$sah;

        $sql_insert="INSERT INTO [SAH].[dbo].[BEL_Daily_N] VALUES('".$plant_prod_code."','".$module."','".$date."','".$style."','".$schedule."','".$schedule."','".$color."','".$size."','".$qty."','".$smv."','".$sah."')";
        echo $sql_insert."<br>";
        odbc_exec($connect, $sql_insert);       

        echo $i."=".$plant_prod_code."-".$plant_prod_code."SOT".$module."-".$module."-".$size."-".$style."-".$schedule."-".$color."-".$size."-".$smv."-".$qty."-".$sah."<br>";
    }   

    echo "SAH Total=".$sah_total."<br>";
}
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>
<!-- <script language="javascript"> setTimeout("CloseWindow()",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script> -->