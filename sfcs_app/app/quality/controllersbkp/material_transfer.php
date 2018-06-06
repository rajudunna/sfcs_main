<?php
//This interface is used to transfer material from one schedule to another.

//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0160",$username,1,$group_id_sfcs); 
$author_id_db=user_acl("SFCS_0160",$username,7,$group_id_sfcs);

//$author_id_db=array("kirang","baiadmn","kirang","denakas","sandeepab","nihals","gayanl","kirang","kirang");
if(in_array($username,$author_id_db))
{
	
}
else
{
	header("Location:restricted.php");
}
?>

<script>
function dodisable()
{
//enableButton();
	document.input.update.style.visibility="hidden"; 

}

function check1(x) 
{
	if(x==" ")
	{
		document.input.update.style.visibility="hidden"; 
	} 
	else 
	{
		
		document.input.update.style.visibility=""; 
	}
}
</script>

<script>
	function firstbox()
	{
		window.location.href ="material_transfer.php?style="+document.test.style.value
	}

	function secondbox()
	{
		window.location.href ="material_transfer.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value
	}

	function thirdbox()
	{
		window.location.href ="material_transfer.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
	}
</script>

<style>
	body
	{
		font-family: arial;
	}
	table
	{
		text-align:center;
	}
	td
	{
		border: 1px solid #29759c;
		white-space:nowrap;
		color:black;
		text-weight:bold;
	}
	th
	{
		background-color:#003366;
		color:white;
		text-weight:bold;
	}
</style>

<body onload="dodisable()">



<?php

if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$color=$_GET['color'];
}


//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
<div class="panel-heading">Additional Panel Input Request Form</div>
<div class="panel-body">
<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php

echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm order by order_style_no";	
//}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
?>

<?php

echo "Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and act_fg>=(order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) and output>=(order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) order by order_del_no";	
	//echo $sql;
//}

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
}

}


echo "</select>";
?>

<?php

echo "Select Color: <select name=\"color\" onchange=\"thirdbox();\" >";

//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" ";
//}

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}


echo "</select>";

$size_titles=array('XS','S','M','L','XL','XXL','XXXL','S01','S02','S03','S04','S05','S06','S07','S08','S09','S10','S11','S12','S13','S14','S15','S16','S17','S18','S19','S20','S21','S22','S23','S24','S25','S26','S27','S28','S29','S30','S31','S32','S33','S34','S35','S36','S37','S38','S39','S40','S41','S42','S43','S44','S45','S46','S47','S48','S49','S50');
echo "Size:";
echo "<select name='size'>";
echo "<option value='ALL'>All</option>";
for($i=0;$i<sizeof($size_titles);$i++){
	echo "<option value='".$size_titles[$i]."'>".$size_titles[$i]."</option>";
}
echo "</select>";

echo "<input type=\"submit\" value=\"Show\" name=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';\">";	

?>
</form>
<span id="msg" style="display:none;color:red;text-align:left;text-weight:bold;"><h4>Please Wait.. While Processing The Data..<h4></span>
</div>
</div>
</body>

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$size=$_POST['size'];
	
	$query_add="";
	if($size!='ALL'){
		$query_add=" and qms_size='$size'";
	}
	
	echo '<form name="request" method="post" action="material_transfer_process.php">';
	echo "<input type='hidden' name='style' value='$style'>";
	echo "<input type='hidden' name='schedule' value='$schedule'>";
	echo "<input type='hidden' name='color' value='$color'>";
	echo "<table alcc='table table-bordered table-striped'>";
	echo "<tr class='tblheading'>";
	echo "<th>Schedule</th>";
	echo "<th>Size</th>";
	echo "<th>Available</th>";
	echo "<th>Required Qty</th>";
	echo "</tr>";
	$sql="select (good_panels-replaced-tran_sent-resrv_dest) as available,qms_schedule,qms_size from $bai_pro3.bai_qms_day_report where qms_style=\"".$style."\" and qms_color=\"".$color."\" and (good_panels-replaced-tran_sent-resrv_dest)>0 $query_add order by qms_schedule,qms_size";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
			echo "<td>".$sql_row['qms_schedule']."</td>";
			echo "<td>".$sql_row['qms_size']."</td>";
			echo "<td>".$sql_row['available']."</td>";
			echo "<td><input type='hidden' name='source_sch[]' value='".$sql_row['qms_schedule']."'><input type='hidden' name='size[]' value='".$sql_row['qms_size']."'><input type='text' name='required[]' value='0' onchange='if(this.value<0 || this.value>".$sql_row['available'].") { this.value=0; alert(\"Please enter correct value\"); }'></td>";
		echo "</tr>";
	}
	echo '</table>';
	echo '<br/><br/><br/>';
	echo 'Module:<select name="module">';
	for($i=1;$i<=72;$i++){
		echo "<option value='$i'>$i</option>";
	}
	echo '</select>&nbsp;&nbsp;';
	echo 'Team:<select name="team">';
		echo "<option value='A'>A</option>";
		echo "<option value='B'>B</option>";
	echo '</select>&nbsp;&nbsp;';
	echo 'Reason:<select name="reason">';
		echo "<option value='1'>Panel Missing in Production</option>";
		echo "<option value='2'>Extra Shipping</option>";
	echo '</select>&nbsp;&nbsp;';
	echo '<input type="submit" name="apply" value="Submit">';
	echo '</form>';
}

?>