<!--
Core Module: Here AQL team will be update Garments Rejected status.

Description: Here AQL team will be update Garments Rejected status.

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("header_script.php"); ?>
<style>
body
{
	font-family: Trebuchet MS;
}
</style>

<script>

function dodisable()
{
enableButton();
document.getElementById('process_message').style.visibility="hidden";
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('option').style.visibility="hidden";
	document.getElementById('update').style.visibility="hidden";
}
</script>

</head>
<body onload="dodisable();">
<h2>Rejects Update Panel</h2>

<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form data">
<?php include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");


$reason_id=array();
$reason_code=array();
$sql="select * from $bai_pro3.audit_ref where status=0 order by reason";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$reason_code[]=$sql_row['audit_ref'];
	$reason_id[]=$sql_row['reason'];
}

 
if(isset($_GET['style']))
{
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$audit_pending=$_GET['audit_pending'];

echo "Style: $style <br/>";
echo "Schedule: $schedule <br/><br/>";

echo "<table>";
echo "<tr><th>Size</th><th>Available Qty</th><th>Reject Qty</th><th>Reason Code</th></tr>";
$x=0;

$sql="select * from $bai_pro3.disp_mix_size where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$qty=$sql_row['fca_audit_pending']+$sql_row['fca_fail'];
	if($qty>0)
	{
		echo "<tr><td>".$sql_row['size_code']."</td><td>$qty</td><td><input type=\"text\" name=\"qty[$x]\" value=\"0\" onchange='if(this.value>$qty) { alert(\"Wrong Qty\"); this.value=0; } if(this.value<0) { alert(\"Wrong Qty\"); this.value=0; }'><input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['size_code']."\"></td>";
		echo "<td><select name=\"".$sql_row['size_code']."[]\" size=\"5\" multiple>";
		for($i=0;$i<sizeof($reason_id);$i++)
		{
			echo "<option value=\"".$reason_code[$i]."\">".$reason_id[$i]."</option>";
		}
		echo "</select></td>";
		echo "</tr>";
$x++;
	}
}
echo "</table>";
echo "Note: Use Ctrl Key to Select Multiple Reasons.";

echo "<br/><br/><table>";
echo "<tr><th>Module</th></tr>";
echo "<tr><td>Ex.: 1,34,2</td></tr>";
echo "<tr><td><input type=\"text\" name=\"mods\" value=\"\"></td></tr>";
echo "</table>";

echo "<input type=\"hidden\" name=\"style_new\" value=\"$style\"><input type=\"hidden\" name=\"schedule_new\" value=\"$schedule\">";
echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
echo "<input type=\"submit\" name=\"update\" value=\"Update\" onclick=\"javascript:button_disable();\">";

echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font></h2></div>';
echo "</form>";
}
?>



</body>
</html>


<?php

if(isset($_POST['update']))
{
	$style_new=$_POST['style_new'];
	$schedule_new=$_POST['schedule_new'];
	$size=$_POST['size'];
	$qty=$_POST['qty'];
	
	$remarks=$_POST['mods'];
	
	//Login User Name
	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	$username=$username_list[1];
	//Login User Name
	
	for($i=0;$i<sizeof($qty);$i++)
	{
		$reason=$_POST[$size[$i]];
				
		if($qty[$i]>0)
		{
			$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\", tran_type=2, size=\"".$size[$i]."\", fail_reason=\"".implode(",",$reason)."\", done_by=\"$username\", remarks=\"$remarks\", pcs=-".$qty[$i];
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"pending.php\"; }</script>";
}



?>