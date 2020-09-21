<?php
function exception($sql_result)
{
	throw new Exception($sql_result);
}
?>
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/global_error_function.php',4,'R'));
	$main_url=getFullURL($_GET['r'],'delete_deallocation.php','R');
    $id=$_GET['id'];
	$plant_code=$_GET['plant_code'];
    $username=$_GET['username'];
try
{
    $is_requested="SELECT doc_no FROM $wms.material_deallocation_track WHERE id=$id and plant_code='".$plant_code."'";
    $is_requested_result=mysqli_query($link, $is_requested) or die(exception($is_requested));
    while($sql_row1=mysqli_fetch_array($is_requested_result))
    {
        $delete_qry="DELETE FROM $wms.material_deallocation_track WHERE id=$id and plant_code='".$plant_code."'";
        $delete_qry_result=mysqli_query($link, $delete_qry) or die(exception($delete_qry));
        echo "<script>swal('Error','Deleted Successfully','error')</script>";
        $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
        echo "<script>setTimeout(function(){
                    location.href='$url' 
                },2000);
                </script>";
        exit();
    }
}
catch(Exception $e) 
{
  $msg=$e->getMessage();
  log_statement('error',$msg,$main_url,__LINE__);
}
?>