<?php


	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));	
	$userName = getrbac_user()['uname'];
	// $department='Embellishment';
	// getWorkstations($department,$plant_code);
	// exit;
    $jobtype='EMBJOB';
	$list=$_POST['listOfItems'];
	
	/** Function to send */
	$planned_respo=getPlanDocketJobs($list,$jobtype);
	if($planned_respo=1){
		 $url1 = getFullURLLevel($_GET['r'],'dashboards/controllers/EMS_Dashboard/embellishment_dashboard_send_operation.php',3,'N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";
	}else{
		echo "<script>swal('Error in planning')</script>";
	}
		
?>