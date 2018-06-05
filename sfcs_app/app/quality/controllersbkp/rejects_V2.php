<!--
Core Module: Here AQL team will be update Garments Rejected status.

Description: Here AQL team will be update Garments Rejected status.

2014-01-21/kirang/Ticket #883026 / FCA Status Update Interface Modification (to display the modules based on schedule number).

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>FCA Status Update - Reject Form</title>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php  

include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
?>
<style>
body
{
	font-family: Trebuchet MS;
}
</style>
<script>
 function AcceptOnlyNumbers(event) 
{
event = (event) ? event : window.event;
var charCode = (event.which) ? event.which : event.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57)) {
return false;
}
return true;
}

</script>

<script>

function abc(value)
{
var count=0;
var iChars = "!@#$%^&*()+=-[]\\\';./{}|\":<>?abcdefghijklmnopqrstuvwxyzASDFGHJKLPOIUYTREWQZXCVBNM";
for (var i = 0; i < value.length; i++) {
    if (iChars.indexOf(value.charAt(i)) != -1) {
		count++;
		str=document.getElementById("mods").value;
		document.getElementById("mods").value=str.replace(value.charAt(i),"");
        }
    }
}

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
</head>
<body onload="dodisable();" onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">
<div class='panel panel-primary'>
	<div class='panel-heading'>Rejects Update Panel</div>
	<div class='panel-body'>
	<?php
	if(isset($_GET['style'])){
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
		$color=$_GET['color'];
		$audit_pending=$_GET['audit_pending'];
	}
?>

<?php $url = getFullURL($_GET['r'],'pending.php','N');
      $url = $url."&style=$style&schedule=$schedule&color=$color&audit_pending=$audit_pending";
?>
<div class='row'>
	<a href='<?= $url ?>' class='pull-right btn btn-danger'>Go Back</a>
</div>	

<form name="test" action="<?php echo $_GET['r']; ?>" method="post" enctype="multipart/form data">
<?php 


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


echo "<br/>Style&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; $style <br/>";
echo "Schedule:&nbsp;$schedule";
if($color!='0')
{
echo "<br/>color&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;".$color."";
}

echo "<br/><br/>";
echo "<table class='table table-bordered'>";
echo "<tr><th>Size</th><th>Available Qty</th><th>Module Qty</th><th>Module</th><th>Reject Qty</th><th>Reason Code</th></tr>";
$x=0;

if($color=='0')
{
$sql="select * from $bai_pro3.disp_mix_size where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
}
else
{
$sql="select * from $bai_pro3.disp_mix_size_2 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$qty=$sql_row['fca_audit_pending']+$sql_row['fca_fail'];
	if($qty>0)
	{
	    $size_value=ims_sizes('',$sql_row['order_del_no'],$sql_row['order_style_no'],$sql_row['order_col_des'],strtoupper($sql_row['size_code']),$link);
		echo "<tr><td>".$size_value."</td><td>$qty</td>";
		if($color=='0')
		{
		$sql2="select sum(bac_qty) as sizes,bac_no as mods from $bai_pro.bai_log_buf where delivery=\"$schedule\" and size_".$sql_row['size_code']." > 0 group by bac_no order by bac_no+0";
		}
		else
		{
		$sql2="select sum(bac_qty) as sizes,bac_no as mods from $bai_pro.bai_log_buf where delivery=\"$schedule\" and color=\"$color\" and size_".$sql_row['size_code']." > 0 group by bac_no order by bac_no+0";
		}
		$mod_exp1='';
		$mod_exp2='';
		$mod_exp2="<select name=\"m".$sql_row['size_code']."[]\" size=\"4\" multiple>";
		mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$sizeqty=$sql_row2['sizes'];
			$modno=$sql_row2['mods'];
		    $mod_exp1.=$modno."&nbsp;->&nbsp;".$sizeqty."<br/>";
			$mod_exp2.="<option value=\"".$modno."\">".$modno."</option>";			
		}
		$mod_exp2.="</select>";
		
		echo "<td>".$mod_exp1."</td>";
		echo "<td>".$mod_exp2."</td>";
		echo "<td><input type=\"text\" onkeypress=\"return AcceptOnlyNumbers(event);\" name=\"qty[$x]\" value=\"0\" onchange='if(this.value>$qty) { alert(\"Wrong Qty\"); this.value=0; } if(this.value<0) { alert(\"Wrong Qty\"); this.value=0; }'><input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['size_code']."\"></td>";
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
echo "<br/>Note: Use Ctrl Key to Select Multiple Reasons.";

echo "<br/><br/><table>";
//echo "<tr><th>Module</th></tr>";
//echo "<tr><td>Ex.: 1,34,2</td></tr>";
//echo "<tr><td><input type=\"text\" name=\"mods\" id=\"mods\" value=\"\" onkeyup=\"abc(this.value)\" onblur=\"abc(this.value)\"></td></tr>";
echo "</table>";

echo "<input type=\"hidden\" name=\"style_new\" value=\"$style\"><input type=\"hidden\" name=\"schedule_new\" value=\"$schedule\"><input type=\"hidden\" name=\"color_new\" value=\"$color\">";
echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
echo "<input type=\"submit\" id=\"update\" name=\"update\" value=\"Update\" onclick=\"javascript:button_disable();\">";

echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font></h2></div>';
echo "</form>";
}
?>
</div><!-- panel body-->
</div><!-- panel -->


</body>
</html>


<?php

if(isset($_POST['update']))
{
	$style_new=$_POST['style_new'];
	$schedule_new=$_POST['schedule_new'];
	$color_new=$_POST['color_new'];
	$size=$_POST['size'];
	//echo "size=".implode(",",$size)."<br>";
	$qty=$_POST['qty'];
	//echo "qty=".implode(",",$qty)."<br>";
	//Login User Name
	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	$username=$username_list[1];
	//Login User Name
	
	for($i=0;$i<sizeof($qty);$i++)
	{
		$m="m".$size[$i];
		//echo "m=".$m."<br>";
		//echo "size=".$size[$i]."-".implode(",",$_POST[$size[$i]])."<br>";
		$reason=$_POST[$size[$i]];
		$modss=$_POST["m".$size[$i].""];
		//echo "mods=".$modss."<br>";
				
		if($qty[$i]>0)
		{
			if($color_new=='0')
			{
			$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\", tran_type=2, size=\"".$size[$i]."\", fail_reason=\"".implode(",",$reason)."\", done_by=\"$username\", remarks=\"".implode(",",$modss)."\", pcs=-".$qty[$i];
			}
			else
			{
			$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\", color=\"$color_new\", tran_type=2, size=\"".$size[$i]."\", fail_reason=\"".implode(",",$reason)."\", done_by=\"$username\", remarks=\"".implode(",",$modss)."\", pcs=-".$qty[$i];
			}
			//echo $sql."<br>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	$url1=getFullURL($_GET['r'],'pending.php','N');
	echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";
	//echo "<script type=\"text/javascript\"> window.close(); </script>";
	
}



?>