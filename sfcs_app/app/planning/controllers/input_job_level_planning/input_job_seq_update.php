<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');

    $input_jobs = json_decode($_POST['input_jobs']);
    $jobsorder = $_POST['jobsorder'];
    $jobsorder = explode(",", $jobsorder);

    // var_dump();
    if(count($jobsorder) === count($input_jobs)){
        for($i=0; $i<count($input_jobs); $i++){
            $sql = "UPDATE plan_dashboard_input SET input_priority = \"$jobsorder[$i]\" WHERE input_job_no_random_ref= \"$input_jobs[$i]\" ";
            // echo  $sql.'<br>';
            $sql_result = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            var_dump($sql_result);
        }
    }

?>