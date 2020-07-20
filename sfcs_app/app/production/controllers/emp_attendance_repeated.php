<?php 
if(isset($_GET['date']) && isset($_GET['shift']))
{
   
    $shift = $_GET['shift'];
    $date = $_GET['date'];
	if($shift != '' && $date != '')
	{		
		getshiftdata($shift,$date);
	}
}
if(isset($_GET['params1']))
{
$params1 = $_GET['params1'];
if($params1 != '')
{
    getshiftdata($params1);
}
}
function getshiftdata($params1){	
error_reporting(0);
	//include("../../../../../common/config/config_ajax.php");
	include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    $params1 = explode(",",$params1);
    $date=$params1[0];
    $shift=$params1[1];
    $get_modules = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1;";
	$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
	$count= mysqli_num_rows($modules_result);
	

    $query ="select pro_attendance_adjustment.module,pro_attendance_adjustment.id,pro_attendance_adjustment.shift,pro_attendance_adjustment.date,pro_attendance_adjustment.smo,pro_attendance_adjustment.adjustment_type,pro_attendance_adjustment.smo_minutes,pro_attendance_adjustment.smo_adjustment_min,pro_attendance_adjustment.smo_adjustment_hours,module_master.id from $bai_pro.`pro_attendance_adjustment` left join bai_pro3.module_master on module_master.module_name=pro_attendance_adjustment.module  WHERE  pro_attendance_adjustment.id NOT IN (SELECT MIN(id) FROM bai_pro.pro_attendance_adjustment WHERE module=module_master.module_name AND shift='" .$shift. "' and date='" .$date. "') AND 
    date='" .$date. "' and shift='" .$shift. "' AND smo !='0' order by pro_attendance_adjustment.id asc" ;


   $success_query = mysqli_query($link, $query) or exit("third ErrorError-2" . mysqli_error($GLOBALS["___mysqli_ston"]));
   
	$sql_num_check=mysqli_num_rows($success_query);
	if($sql_num_check > 0){
        
		while ($row = $success_query->fetch_assoc()) {
           
            $result_array[] = $row;
         // $row = mysqli_fetch_assoc($success_query); 
		}
		$json_data = json_encode($result_array);
   // }
        }
    echo $json_data;


}

?>