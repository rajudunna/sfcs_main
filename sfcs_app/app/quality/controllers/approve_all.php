
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>FCA Status Update - Approve All Form</title>
<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
?>





<style>
body
{
	font-family: Trebuchet MS;
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
</head>
<body onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">
<?php 

$style=$_GET['style'];
$schedule=$_GET['schedule'];
$audit_pending=$_GET['audit_pending'];
$color=$_GET['color'];
$recheck=$_GET['recheck'];

	

$size=array();
$qty=array();
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
	$size[]=$sql_row['size_code'];
	$qty[]=$sql_row['fca_audit_pending']+$sql_row['fca_fail'];
}

if(array_sum($qty)==($audit_pending+$recheck))
{
	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			if($color=='0')
			{
			$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style\", schedule=\"$schedule\",size=\"".$size[$i]."\",pcs=".$qty[$i].", tran_type=1, done_by=\"$username\"";
			}
			else
			{
			$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style\", schedule=\"$schedule\",color=\"$color\",size=\"".$size[$i]."\",pcs=".$qty[$i].", tran_type=1, done_by=\"$username\"";
			}
			mysqli_query($link, $sql) or exit("Sql Error".$sql);
		}
	}
	echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
}
else
{
	echo "<h2><font color=\"red\">Qty Mismatched.</font></h2>";
}


$url1=getFullURL($_GET['r'],'pending.php','N');
	echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";
?>



</body>
</html>