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

<div class="panel panel-primary"><div class="panel-heading">Pack Jobs Split</div><div class="panel-body">
<?php
    // if($username=="hasithada" or $username=="" or $username=="sfcsproject1" or $username=="chathurikap")
    // if(in_array($update,$has_permission))
    // {
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
    // }else{
        // echo "<br><div class='alert alert-danger'>You are Not Authorized to Split Sewing Jobs</div>";
    // }

if(isset($_POST['submit']))
{
    $schedule=$_POST['schedule'];
    // $unconditional_remove=$_POST['unconditional_remove'];
    $sql="SELECT DISTINCT carton_no,style,pac_seq_no,pack_method FROM bai_pro3.`pac_stat_log` WHERE schedule='$schedule' order by carton_no";
    // echo $sql;
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount=mysqli_num_rows($sql_result);
    if ($rowcount>0) 
    {
	    echo "<div style='width:1000px;'>";
	    echo "<span style='color:black;text-weight:bold;'>Select Carton Number You want To Split: </span><br><br>";
	    while($sql_row=mysqli_fetch_array($sql_result))
	    {
            $style=$sql_row['style'];
			$carton_no=$sql_row['carton_no'];
			$seq_no=$sql_row['pac_seq_no'];
			$pack_method=$sql_row['pack_method'];
	        $split_jobs = getFullURL($_GET['r'],'split_jobs.php','N');
	        echo "<a href='$split_jobs&schedule=$schedule&style=$style&seq_no=$seq_no&packmethod=$pack_method&cartonno=$carton_no' class='btn btn-warning'>Carton:".$carton_no."-".$operation[$pack_method]."</a>"."";
	    }
	    echo "</div>";
    } else {
    	echo '<div class="alert alert-danger">
			  <strong>Warning!</strong> No Cartons Available for this Schedule Number.
			</div>';
    }
}
?>
</div>
</div>