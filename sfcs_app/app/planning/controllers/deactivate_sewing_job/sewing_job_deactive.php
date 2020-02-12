<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));

$mail_status=0;
$username = getrbac_user()['uname'];
$module=$_GET['module']; 
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Deactivate Sewing Jobs</div>
<div class = "panel-body">
    <form name="main" action="<?php echo getFullURLLevel($_GET['r'],'sewing_job_deactive.php','0','N'); ?>" method="post">
        <div class="row">
            <?php
                echo "<div class='col-sm-2'><label>Module<span style='color:red;'> *</span></label>
                <select class='form-control' name=\"module\" id=\"module\" onchange=\"secondbox();\" id='module' required>";
                $sql="select distinct ims_mod_no from $bai_pro3.ims_log";	
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sql_num_check=mysqli_num_rows($sql_result);
                echo "<option value='' disabled>Select Module</option>";
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                    if(str_replace(" ","",$sql_row['ims_mod_no'])==str_replace(" ","",$module)){
                            echo "<option value=\"".$sql_row['ims_mod_no']."\" selected>".$sql_row['ims_mod_no']."</option>";
                        }
                    else{
                        echo "<option value=\"".$sql_row['ims_mod_no']."\">".$sql_row['ims_mod_no']."</option>";
                    }
                }
                echo "</select>
                </div>";
            ?>
            <div class="col-md-2"><br/>
                <input class="btn btn-primary" type="submit" value="Submit" name="submit">
            </div>
        </div>
    </form>

<?php
    include('sewing_job_list.php');
?>
</div>
</div>
<script>
$(document).ready(function() {
    $('#deactive_sewing_job').DataTable();
} );

function confirm_reverse(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Remove?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        console.log(isConfirm);
        if (isConfirm) {
            window.location = $(t).attr('href');
            return true;
        } else {
            sweetAlert("Request Cancelled",'','error');
            return false;
        }
        });
    }
</script>
<style>
table th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
table tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}
</style>