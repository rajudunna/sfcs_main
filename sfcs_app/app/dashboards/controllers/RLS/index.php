<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
$view_access=user_acl("SFCS_0207",$username,1,$group_id_sfcs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="refresh" content="600">
<title></title>
<meta name="" content="">
<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
</head>
<style>
body
{
	font-family:Arial;
}
</style>

<?php

 echo "<div id='msg' class='alert alert-info' role='alert'>Please wait while preparing report...</div>";

	ob_end_flush();
	flush();
	usleep(10);
?>
<div class="panel panel-primary">
<div class="panel-heading">Rework Live Status<a href="<?= getFullURL($_GET['r'],'rls.htm','R');?>" target="_blank" class="btn btn-warning btn-xs pull-right">? </a></div>
<div class="panel-body">
<!-- <table align="center">
<tr><th><h4><img src="1.jpg"></img>Need To update</h4></th><th></th><th></th><th></th><th></th><th><h4><img src="2.png"></img>0 Output</h4></th><th></th><th></th><th></th><th></th><th><h4><img src="3.png"></img>Idle Line</h4></th><th></th><th></th><th></th><th></th><th><h4><img src="4.jpg"></img>Rework > 2%</h4></th><th></th><th></th><th></th><th></th><th><h4><img src="5.jpg"></img> 0% < Rework < 2%</h4></th><th></th><th></th><th></th><th></th><th><h4><img src="6.png"></img>Rework = 0%</h4></th></tr>
</table>
<hr> -->
<table align="center">
<tr>
</tr>
<?php

include"section_1.php";

include"section_2.php";

include"section_3.php";

//include"section_4.php";

//include"section_5.php";

//include"section_6.php";

//include"section_7.php";

//include"section_8.php";
?>
</table>

<script>
	document.getElementById("msg").style.display="none";
</script>

</div>
</div>
