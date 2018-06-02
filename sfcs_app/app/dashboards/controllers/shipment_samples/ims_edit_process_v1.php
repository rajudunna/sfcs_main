<?php  
$tid=$_GET['tid'];
$module=$_GET['module'];
?>

<?php include("../../../../common/config/config.php"); ?>

<html>
<head>
<title>IMS EDIT PANEL</title>

<script>
function dodisable()
{
enableButton();


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

function check(x,y)
{
	if(x<0)
	{
		alert("You cant enter a value less than 0");
		return 1010; 
	}
	if((x>y))
	{
		alert("Please enter correct Qty");
		return 1010; 
	}	
}

</script>


<script src="../../common/js/jquery-1.4.2.min.js"></script>
<script src="../../common/js/jquery-ui-1.8.1.custom.min.js"></script>
<script src="../../common/js/cal.js"></script>
<link href="../../common/js/calendar.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="../../../../common/js/dropdowntabs.js"></script>
<link rel="stylesheet" href="../../../../common/css/ddcolortabs.css" type="text/css" media="all" />

<script type="text/javascript">
	$(function() {
		$("#date").simpleDatepicker({startdate: '2010-01-01', enddate: '2020' });
	});
</script>

<style>

body{
	font-family: arial;
}
</style>
<?php //include("../header_scripts.php"); ?>

</head>
<body onload="dodisable();">
<?php //include("../menu_content.php"); ?>

<div style="float:left; padding:20px; border-right:solid 2px black;">
<h2>Job Transfer Panel</h2>
<table>
<form name="test" action="ims_edit_process_v1_process.php" method="post">
<tr><td>TID</td><td>:</td><td> <?php echo $tid; ?><input type="hidden" name="tid" value="<?php echo $tid; ?>" size="15"></td> </tr>
<?php

$sql="select * from $bai_pro3.ims_log where tid=$tid";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	echo "<tr><td>Style</td><td>:</td><td>".$sql_row['ims_style']."</td></tr>";
	echo "<tr><td>Schedule</td><td>:</td><td>".$sql_row['ims_schedule']."</td></tr>";
	echo "<tr><td>Color</td><td>:</td><td>".$sql_row['ims_color']."</td></tr>";
	echo "<tr><td>Current Module</td><td>:</td><td>".$sql_row['ims_mod_no'].'<input type="hidden" name="current_mod" value="'.$sql_row['ims_mod_no'].'"  size="15">'."</td></tr>";
	echo "<tr><td>Size</td><td>:</td><td>".strtoupper(substr($sql_row['ims_size'],2))."</td></tr>";
	echo "<tr><td>Input Qty</td><td>:</td><td>".$sql_row['ims_qty']."</td></tr>";
	echo "<tr><td>Produced Qty</td><td>:</td><td>".$sql_row['ims_pro_qty']."</td></tr>";
	
	$allowed_qty=$sql_row['ims_qty']-$sql_row['ims_pro_qty'];
	echo "<tr><td>Balance Qty</td><td>:</td><td>".$allowed_qty."</td></tr>";
}

?>
<tr><td>Max Allowed Qty</td><td>:</td><td> <?php echo $allowed_qty; ?> <input type="hidden" name="allow_qty" value="<?php echo $allowed_qty; ?>"  size="15"></td></tr>
<tr><td>Enter New Qty</td><td>:</td><td> <input type="text" name="qty" value="0"  onchange="if(check(this.value, <?php echo $allowed_qty; ?>)==1010){ this.value=0;}" size="15"></td></tr>
<tr><td>Enter New Module No</td><td>:</td><td><select name="mod">
<option value="All" <?php  if($module=="All") { echo "selected"; }?>>All</option>
<?php

$sql="SELECT GROUP_CONCAT(sec_mods) as mods FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
//echo $sql;
$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($result7))
{
	$sql_mod=$sql_row["mods"];
}

$sql_mods=explode(",",$sql_mod);

for($i=0;$i<sizeof($sql_mods);$i++)
{
	if($sql_mods[$i]==$module)
	{
		echo "<option value=\"".$sql_mods[$i]."\" selected>".$sql_mods[$i]."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_mods[$i]."\">".$sql_mods[$i]."</option>";
	}	
}


?>
</select></td><!--<td> <input type="text" name="mod" value=""  size="15"></td>--></tr>
<tr><td>Remarks</td><td>:</td><td> <input type="text" name="remarks" value="nil"></td></tr>
<?php
echo "<tr><td><input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable</td><td></td><td><INPUT TYPE = \"Submit\" Name = \"Update\" VALUE = \"Update\"></td></tr>";
 ?>
</form>
</table>
</div>

<div style="float:left; padding:20px;">
<h2>Request for New Entry</h2>
<br/>
<font color="red">(*)values are Compulsory.</font> 
<br/>
<form name="test" action="ims_edit_process_v1_process.php" method="post">
<table>
<tr><td>Expected Date of Completion <font color="red">(*)</font></td><td>:</td><td><input type="text" id="date" size="10" name="date" value="<?php echo date("Y-m-d"); ?>">

Time:<select name="time">
<?php
$time=date("H");
for($i=6; $i<=23; $i++)
{
	if($time==$i)
	{
		echo "<option value=$i selected>$i:00</option>";
	}
	else
	{
		echo "<option value=$i>$i:00</option>";
	}
	
}

?>

</select>


<input type="hidden" value="<?php echo $module; ?>" name="module"><input type="hidden" value="<?php echo $tid; ?>" name="tid"></td></tr>
<tr><td>Remarks <font color="red">(*)</font></td><td>:</td><td><input type="text" name="rem" size="30"></td></tr>
<tr><td></td><td></td><td><input type="submit" name="request" value="Request"></td></tr>

</table>
</form>
</div>
</body>

</html>

