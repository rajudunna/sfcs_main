<?php

//Ticket #941086 / Date : 2014-03-21 / Due to color changing from yellow to green due to removing the job from fabric_priorities

// include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R')); 

$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
$tasktype = TaskTypeEnum::SEWINGJOB;

	$list=$_POST['listOfItems'];
	$list_db=array();
	$list_db=explode(";",$list);

	$x=1;
	for($i=0;$i<sizeof($list_db);$i++)
	{
		$items=array();
		$items=explode("|",$list_db[$i]);
        
        /**Getting task jobs details from task jobs */
        $Qry_taskjobs="SELECT task_header_id FROM $tms.task_jobs WHERE task_job_reference='$items[1]' AND plant_code='$plant_code' AND task_type='$tasktype'";
        $Qry_taskjobs_result=mysqli_query($link_new, $Qry_taskjobs) or exit("Sql Error at task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
        $taskjobs_num=mysqli_num_rows($Qry_taskjobs_result);
        if($taskjobs_num>0){
            while($taskjobs_row=mysqli_fetch_array($Qry_taskjobs_result))
            {
                $header_id=$taskjobs_row['task_header_id'];
            }
        }

        $Qry_resource_id="SELECT resource_id FROM $tms.task_header WHERE task_header_id='$header_id' AND plant_code='$plant_code' AND task_type='$tasktype'";
        $Qry_resource_id_result=mysqli_query($link_new, $Qry_resource_id) or exit("Sql Error at resource_id".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resource_id_num=mysqli_num_rows($Qry_resource_id_result);
        if($resource_id_num>0){
            while($taskjobs_row=mysqli_fetch_array($Qry_resource_id_result))
                {
                    $resource_id=$taskjobs_row['resource_id'];
                }
        }

        if($resource_id_num>0)
        {
            if($resource_id != $items[0])
            {
                $insert_log_query="INSERT INTO $pps.jobs_movement_track (doc_no, input_job_no_random, input_job_no,  from_module, to_module, username, log_time,plant_code,created_user,updated_user) VALUES('".$doc_no."', '".$items[1]."', '".$input_job_no."', '".$original_module."', '".$items[0]."', '".$userName."', NOW(),'".$plant_code."','".$username."','".$username."')";
                mysqli_query($link_new, $insert_log_query) or die("Error while saving the track details1".$insert_log_query);
            }
        }
        else
        {
            $insert_log_query="INSERT INTO $pps.jobs_movement_track (doc_no, input_job_no_random, input_job_no, from_module, to_module, username, log_time,plant_code,created_user,updated_user) VALUES('".$items[2]."','".$items[1]."', '".$input_job_no1."', 'No Module', '".$items[0]."', '".$userName."', NOW(),'".$plant_code."','".$username."','".$username."')";
            mysqli_query($link_new, $insert_log_query) or die("Error while saving the track details2".$insert_log_query);
        }

        //update seq sewing jobs

        if(strlen($items[1])>0){
            $update_taskjobs="update $tms.task_jobs SET priority=$x,updated_at=NOW(),updated_user='$username' WHERE task_job_reference='$items[1]' AND plant_code='$plant_code' AND task_type='$tasktype'";
            mysqli_query($link_new, $update_taskjobs) or die("Error while saving the track details3 == ".$update_taskjobs);
        }
    
        $x++;
		
	}
	
	echo "<script>swal('Successfully updated','','success')</script>";
		$url =getFullURL($_GET['r'],'input_job_seq_move.php','N');
		echo"<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1); 
		function Redirect() {  
			location.href = '$url'; 
		}</script>";

?>