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
    $get_modules = "SELECT * FROM $bai_pro.`pro_attendance_adjustment` where shift='" .$shift. "' and date='" .$date. "'  and smo!='0' group by module ORDER BY module*1;";
	$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
	$count= mysqli_num_rows($modules_result);
	
    while($module_row=mysqli_fetch_array($modules_result))
    {
        $modules_array[]=$module_row['module'];
        //$id=$module_row['id'];
      
    }

    $modules = implode("','", $modules_array);
   

  $query="SELECT *,(SELECT id FROM $bai_pro3.module_master WHERE module_name =pro_attendance_adjustment.module) as id FROM  $bai_pro.`pro_attendance_adjustment` WHERE id NOT IN (SELECT MIN(id) FROM $bai_pro.pro_attendance_adjustment WHERE shift='" .$shift. "' AND date='" .$date. "' AND  module IN('$modules') GROUP BY module ) AND date='" .$date. "' AND shift='" .$shift. "' AND module IN ('$modules') AND smo !='0' ORDER BY id ASC";
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