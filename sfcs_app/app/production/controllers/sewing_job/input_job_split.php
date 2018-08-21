<?php 
    // include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
    // //require_once('phplogin/auth.php');
    // include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php");
    // include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
    // include("../../../common/config/dbconf.php");
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
?>

<title>Sewing Job Split</title>
<?php
    include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R'));
?>

<div class="panel panel-primary"><div class="panel-heading">Sewing Jobs Split</div><div class="panel-body">
<?php
    // if($username=="hasithada" or $username=="" or $username=="sfcsproject1" or $username=="chathurikap")
    if(in_array($update,$has_permission))
    {
        ?>
        <form name="input" method="post" action="?r=<?= $_GET['r'] ?>">
            <div class="row">
                <div class="col-md-4">       
                <?php
                    echo '<label>Enter Schedule No : </label>
                    <input type="text" class="integer form-control" required name="schedule" value="">
                </div><br/>
                    <div clas="col-md-4"><input type="submit" name="submit" value="Split" class="btn btn-success"></div>
            </div>
        </form><br/>'; 
    }else{
        echo "<br><div class='alert alert-danger'>You are Not Authorized to Split Sewing Jobs</div>";
    }

if(isset($_POST['submit']))
{
    $schedule=$_POST['schedule'];
    // $unconditional_remove=$_POST['unconditional_remove'];
    $sql="SELECT input_job_no,input_job_no_random, order_del_no, order_col_des FROM $bai_pro3.packing_summary_input WHERE input_job_no_random LIKE '$schedule%' group by input_job_no ORDER BY input_job_no*1 ";
    // echo $sql;
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount=mysqli_num_rows($sql_result);
    if ($rowcount>0) 
    {
	    echo "<div style='width:1000px;'>";
	    echo "<span style='color:black;text-weight:bold;'>Select Sewing Job Number You want To Split: </span><br><br>";
	    while($sql_row=mysqli_fetch_array($sql_result))
	    {
            $order_del_no=$sql_row['order_del_no'];
            $order_col_des=$sql_row['order_col_des'];
	        $input_job_no=$sql_row['input_job_no'];
	        $input_job_no_ran=$sql_row['input_job_no_random'];
            $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$order_del_no,$order_col_des,$input_job_no,$link);
	        $split_jobs = getFullURL($_GET['r'],'split_jobs.php','N');
	        echo "<a href='$split_jobs&sch=$schedule&job=$input_job_no&rand_no=$input_job_no_ran' class='btn btn-warning'>".$display."</a>"."";
	    }
	    echo "</div>";
    } else {
    	echo '<div class="alert alert-danger">
			  <strong>Warning!</strong> No Sewing Jobs Available for this Schedule Number.
			</div>';
    }
}
?>
</div>
</div>