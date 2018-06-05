<?php
set_time_limit(2000);
?>
<?php include("../../dbconf.php"); ?>
<?php include("functions2.php"); 
$module=$_GET['module'];
$sp_id=$_GET['sp_id'];
?>

<html>
<head>
<title>POP - IMS Input Track Panel</title>
<?php include("header_scripts.php"); ?>



<style>

a {text-decoration: none;}

.atip
{
	color:black;
}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
{
	border-bottom: 3px solid white;
	padding-bottom: 5px;
	padding-top: 5px;
}

</style>


</head>

<body>


<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
sweetAlert("Function Disabled!","","warning");
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
sweetAlert("Function Disabled!","","warning");
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("sweetAlert('Function Disabled!','','warning');return false")

// --> 
</script>

<?php

	$sql1="SELECT distinct ims_doc_no FROM bai_pro3.ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\"";
	// echo $sql1;
	// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result1);
	
/*	$sql1="SELECT distinct ims_doc_no FROM recut_ims_log WHERE ims_mod_no=$module AND ims_status <> \"DONE\"";
	mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	$sql_num_check=$sql_num_check+mysql_num_rows($sql_result1); */
	
	$diff=2-$sql_num_check;
	$url1=getFullURL($_GET['r'],'pop.php','N');
	$url2=getFullURLLevel($_GET['r'],'ims.php',1,'N');
	if($diff>2)
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1&module=$module&sp_id=$sp_id\"; }</script>";
	}
	else
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url2&module=$module&sp_id=$sp_id\"; }</script>";
	}

?>


</body>
</html>