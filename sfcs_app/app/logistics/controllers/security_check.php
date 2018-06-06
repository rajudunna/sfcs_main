<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0106",$username,1,$group_id_sfcs);
?>
<title>BEK Security Check-Out</title>
<style>
.right{
	color : #000;
	text-align : right;
	font-size : 15px;
}
</style>

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }
</script>

<script>
function checkandupdate()
{
	document.getElementById('submitbtn').style.visibility="hidden";
	//document.getElementById('process_message').style.visibility="visible";
	
}
</script>
    
<div id="process_message" style='display:none'><h2><font color="red">Please wait while updating data!!!</font></h2></div>
<div class='panel panel-primary'>
		<div class='panel-heading'>
			<b style='font-size : 13px'>Security Checkout Panel</b>
		</div>
		<div class='panel-body'>
			<form name="test" action="index.php?r=<?= $_GET['r'] ?>" method="post" enctype="multipart/form data">
				<div class="row">
					<div class="col-sm-2 right big"><label>Enter Dispatch Number : </label></div>
					<div class='col-sm-2'><input class='form-control integer' type="text" name="note_no" value=""></div>
					<div class='col-sm-1'><input class='btn btn-success' type="Submit" name="submit" Value="Submit" id="submitbtn" onclick="javascript:checkandupdate();"></div>
				</div>
			</form>
			<hr>
<?php

if(isset($_POST['submit']) or isset($_GET['note_no']))
{
	if(isset($_POST['submit']))
	{
		$note_no=$_POST['note_no'];
	}else{
		$note_no=$_GET['note_no'];
	}

	// $sql_id = "select * from disp_db where disp_note_no = '$note_no'";
	// $result = mysqli_query($link, $sql_id);
	// if(mysqli_num_rows($result)>0)
	// {
	// 	$sql="update disp_db set exit_date=\"".date("Y-m-d H:i:s")."\", status=3, dispatched_by=USER() where disp_note_no='$note_no' and exit_date ='0000-00-00 00:00:00' and status=2";
		
	// 	mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	if(mysqli_affected_rows($link)>0)
	// 	{
	// 		include( $_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'dispatch_note_email.php','N') );
	// 		echo "<h2><font color=\"green\">Successfully Updated.</font></h2>";
	// 	}
	// 	else
	// 	{
	// 		echo "<h2><font color=\"red\">Already Updated.</font></h2>";
	// 	}
		//include("dispatch_note_email.php");
		//KiranG - Disabled 20160123
		
		$url = getFullURL($_GET['r'],"dispatch_note_email.php",'N');
		// echo "$url?note_no=$note_no";
		// header("location: $url&note_no=$note_no");
		// die();
		echo "<script>
				window.location.href = '$url&note_no=$note_no';
			</script>";
	// }else{
	// 	echo '<script>sweetAlert("The Disptach Number do not Exist","","warning")</script>';
	// }
}

?>


<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dispatch_db_include.php',0,'R') ); ?>
	</div>
</div>
</div>


<script>
	document.getElementById('process_message').style.visibility="hidden";
</script>