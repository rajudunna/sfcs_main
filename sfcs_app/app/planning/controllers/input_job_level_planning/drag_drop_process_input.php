
<?php

	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
	$plant_code = $_SESSION['plantCode'];
    $username =  $_SESSION['userName'];	
    $tasktype = TaskTypeEnum::SEWINGJOB;
	$list=$_POST['listOfItems'];
	
	/** Function to update jobs using workstations
	   * @param:inputjobs and work stations
	   * @return:true/false
   * */
	$planned_response=updatePlanDocketJobs($list,$tasktype,$plant_code);
	if($planned_response==1){
		echo "<script>swal(Job Planned Successfully','info');</script>";
		 $url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/IPS/tms_dashboard_input_v22.php',3,'N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";
	}else{
		echo "<script>swal(Error in planning','danger');</script>";
	}
		
?>

