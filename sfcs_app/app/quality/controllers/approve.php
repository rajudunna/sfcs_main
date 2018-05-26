<!--
Core Module: Here AQL team will be update Garments Approve status.

Description: Here AQL team will be update Garments Approve status.

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>FCA Status Update - Approve Form</title>
<?php include("header_script.php"); 
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
?>



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
<div style='background-color:#398fe5;margin-right:600pt;'><h4><center>Approve Some Update Panel</center></h4></div>



<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form data">
<?php 
if(isset($_GET['style']))
{
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$color=$_GET['color'];
$audit_pending=$_GET['audit_pending'];

echo "Style&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;".$style;
echo "<br/> Schedule:&nbsp;".$schedule ;

if($color!='0')
{
echo "<br/>color&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;".$color;
}
echo "<br/><br/><table width=40% class='table table-bordered'>";
echo "<tr><th>Size</th><th>Available<br/>Qty</th><th>Approve<br/> Qty</th>";

echo "</tr>";
$x=0;

if($color=='0')
{
$sql="select * from $bai_pro3.disp_mix_size where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
}
else
{
$sql="select * from $bai_pro3.disp_mix_size_2 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
}
//echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$qty=$sql_row['fca_audit_pending']+$sql_row['fca_fail'];
	$size_value=ims_sizes('',$sql_row['order_del_no'],$sql_row['order_style_no'],$sql_row['order_col_des'],strtoupper($sql_row['size_code']),$link);
	if($qty>0)
	{
		echo "<tr><td>".$size_value."</td><td>$qty</td><td><input type=\"text\" name=\"qty[$x]\" value=\"0\" size=\"10\" onchange='if(this.value>$qty) { alert(\"Wrong Qty\"); this.value=0; } if(this.value<0) { alert(\"Wrong Qty\"); this.value=0; }'><input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['size_code']."\"></td>";
		echo "</tr>";
		$x++;
	}
}
echo "</table>";
echo "<input type=\"hidden\" name=\"style_new\" value=\"$style\"><input type=\"hidden\" name=\"schedule_new\" value=\"$schedule\"><input type=\"hidden\" name=\"color_new\" value=\"$color\">";
echo '<br/><input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
echo "<input type=\"submit\" id=\"update\" name=\"update\" value=\"Update\" onclick=\"javascript:button_disable();\">";

echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font></h2></div>';
echo "</form>";
}
?>



</body>
</html>


<?php

if(isset($_POST['update']))
{
	//Login User Name
	$username_list=explode('\\',$_SERVER['REMOTE_USER']);
	$username=$username_list[1];
	//Login User Name
	
	$style_new=$_POST['style_new'];
	$schedule_new=$_POST['schedule_new'];
	$color_new=$_POST['color_new'];
	$size=$_POST['size'];
	$qty=$_POST['qty'];
	echo sizeof($qty)."size<br>";
	echo "<br/>color=".$color_new;
	 
	/*if($color_new=='0')
	{
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			$sql="insert into fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\", tran_type=1, size=\"".$size[$i]."\", done_by=\"$username\", pcs=".$qty[$i];
			echo "<br/>query1=".$sql;
			mysql_query($sql,$link) or exit("Sql Error".$sql);
		}
	}
	}
	else
	{
	for($i1=0;$i1<sizeof($qty);$i1++)
	{
		echo "<br>".$i1."-".$qty[$i1]."-".sizeof($qty)."<br>";
		if($qty[$i1]>0)
		{
			$sql1="insert into fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\",color=\"$color_new\", tran_type=1, size=\"".$size[$i1]."\", done_by=\"$username\", pcs=\"".$qty[$i1]."\"";
			echo "<br/>query2=".$sql1;
			mysql_query($sql1,$link) or exit("Sql Error2".$sql1."-".mysql_error());
		}
	}
	}*/
	if($color_new=='0')
	{
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			$sql="insert into $bai_pro3.fca_audit_fail_db (style,schedule,tran_type,size,done_by,pcs) values (\"".$style_new."\",\"".$schedule_new."\",1,\"".$size[$i]."\",\"".$username."\",\"".$qty[$i]."\")";
			echo "<br/>query1=".$sql;
			mysqli_query($link, $sql) or exit("Sql Error".$sql);
		}
	}
	}
	else
	{
	for($i1=0;$i1<sizeof($qty);$i1++)
	{
		echo "<br>".$i1."-".$qty[$i1]."-".sizeof($qty)."<br>";
		if($qty[$i1]>0)
		{
			$sql1="insert into $bai_pro3.fca_audit_fail_db (style,schedule,tran_type,size,done_by,pcs,color) values (\"".$style_new."\",\"".$schedule_new."\",1,\"".$size[$i1]."\",\"".$username."\",\"".$qty[$i1]."\",\"".$color_new."\")";
			//$sql1="insert into fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\",color=\"$color_new\", tran_type=1, size=\"".$size[$i1]."\", done_by=\"$username\", pcs=\"".$qty[$i1]."\"";
			echo "<br/>query2=".$sql1;
			mysqli_query($link, $sql1) or exit("Sql Error2".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	}
	echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"pending.php\"; }</script>";
	echo "<script type=\"text/javascript\"> window.close(); </script>";
}



?>