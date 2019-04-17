<html xmlns="http://www.w3.org/1999/xhtml">
<head>

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
window.onload = function(e){ 
	document.getElementById('update').disabled='true';
}
function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('option').style.visibility="hidden";
	document.getElementById('update').style.visibility="hidden";
}
</script>

</head>
<body onload="dodisable();" class='container' style='margin-top:10px'>
<div class='panel panel-primary'><div class='panel-heading'><h3 class='panel-title'>Re-Check Update Panel</div><div class='panel-body'>
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
<!--<h2>Re-Check Update Panel</h2>-->
<form name="apply" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url'];?>" method="post" enctype="multipart/form data">
<?php 

echo "Style: $style <br/>";
echo "Schedule: $schedule <br/>";
if($color!='0')
{
	echo "<br/>  color:".$color."<br/>";
}

// echo "<form name=\"apply\" method=\"post\" action=\"".$_GET['r']."\">";
echo "<table class='table table-bordered'>";
echo "<tr><th>Color</th><th>Size</th><th>Rejected Qty</th><th>Pass Qty</th></tr>";
$x=0;
if($color=='0')
{
	$sql="select * from $bai_pro3.disp_mix_size_2 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and fca_fail<>0 group by order_col_des,size_code";
}
else
{
	$sql="select * from $bai_pro3.disp_mix_size_2 where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and fca_fail<>0";
}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$available_qty=abs($sql_row['fca_fail']);
	$size_val=ims_sizes('',$sql_row['order_del_no'],$sql_row['order_style_no'],$sql_row['order_col_des'],strtoupper($sql_row['size_code']),$link);
	echo "<tr><td>".$sql_row['order_col_des']."</td><td>".$size_val."</td><td>".$sql_row['fca_fail']."</td><td><input type=\"text\" name=\"qty[$x]\" value=\"0\" onchange='if(this.value>$available_qty) { alert(\"Wrong Qty\"); this.value=0; } if(this.value<0) { alert(\"Wrong Qty\"); this.value=0; }'><input type=\"hidden\" name=\"size[$x]\" value=\"".$sql_row['size_code']."\">";
	if($color=='0')
	{
		echo "<input type=\"hidden\" name=\"color_new[$x]\" value=\"".$sql_row['order_col_des']."\">";
	}
	echo "</td></tr>";
	$x++;
}
echo "</table>";
echo "<input type=\"hidden\" name=\"style_new\" value=\"$style\"><input type=\"hidden\" name=\"schedule_new\" value=\"$schedule\">";
if($color!='0')
{
	echo "<input type=\"hidden\" name=\"color_new\" value=\"$color\">";
	echo "<input type=\"hidden\" name=\"color_new1\" value=\"$color\">";
}
else
{
	echo "<input type=\"hidden\" name=\"color_new1\" value=\"1\">";
}
echo '<br/><input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable';
echo "<input type=\"submit\" class='btn btn-primary' name=\"update\" value=\"Update\" id='update'>";

//echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font></h2></div>';
echo "</form>";
?>
</div></div>
</body>
</html>


<?php

if(isset($_POST['update']))
{
	$style_new=$_POST['style_new'];
	$schedule_new=$_POST['schedule_new'];
	$color_new=$_POST['color_new'];
	$color_new1=$_POST['color_new1'];
	$size=$_POST['size'];
	$qty=$_POST['qty'];
	if($color_new1=='1')
	{
		for($i=0;$i<sizeof($qty);$i++)
		{
			if($qty[$i]>0)
			{
				$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\",color=\"".$color_new[$i]."\", tran_type=2, size=\"".$size[$i]."\", pcs=".$qty[$i];
				// echo "<br/>query1=".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\",color=\"".$color_new[$i]."\", tran_type=1, size=\"".$size[$i]."\", pcs=".$qty[$i];
				// echo "<br/>query2=".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
	else
	{
		for($i=0;$i<sizeof($qty);$i++)
		{
			if($qty[$i]>0)
			{
				$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\",color=\"$color_new\",  tran_type=2, size=\"".$size[$i]."\", pcs=".$qty[$i];
				// echo "<br/>query11=".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql="insert into $bai_pro3.fca_audit_fail_db set style=\"$style_new\", schedule=\"$schedule_new\",color=\"$color_new\",  tran_type=1, size=\"".$size[$i]."\", pcs=".$qty[$i];
				// echo "<br/>query12=".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
	echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
	$url1=getFullURL($_GET['r'],'pending.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url1\"; }</script>";
}
?>