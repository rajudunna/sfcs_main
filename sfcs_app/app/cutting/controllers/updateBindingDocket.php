<?php 
include("../../../common/config/config_ajax.php");
$plantcode=$_SESSION['plantCode'];
if(isset($_GET['parentId']))
{
    $doc1=$_GET['parentId'];
    $printqry="select status from $pps.binding_consumption where id='$doc1' and plant_code='".$plant_code."'";
    $sql_result_print=mysqli_query($link, $printqry) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result_print))
    {
        $printstatus=$sql_row['status'];
    }

    if($printstatus!='Close')
    {

        $query = "UPDATE $pps.binding_consumption set status = 'Close',status_at= '".date("Y-m-d H:i:s")."',updated_user= '".$username."',updated_at=NOW() where id = $doc1 and plant_code='".$plant_code."'";
        $update_query = mysqli_query($link,$query);
    }
}
?>