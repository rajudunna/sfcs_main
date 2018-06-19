<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',2,'R'); ?>"></script>

<script>

function validate(x,y)
{
	if(x<0 || x>y) { alert("Please enter correct plies <="+y); return 1010;  }
}

</script>
</head>

<body onload="javascript:dodisable();">
<div class="panel panel-primary">
<div class="panel-heading">Cut status Reporting</div>
<div class="panel-body">

<table>

<?php
$doc_no=$_GET['doc_no'];

// echo "<h1><font color=red>Cut Status Reporting</font></h1>";

echo "<table border=1>";
echo "<tr>";
echo "<th>Doc ID</th><th>Cut No</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>Total</th><th>CUT STAT</th><th>CUT ISSUE STAT</th><th>Remarks</th>";

echo "</tr>";

$sql="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$doc_no=$sql_row['doc_no'];
	$doc_acutno=$sql_row['acutno'];
	$a_plies=$sql_row['p_plies'];
	$a_xs=$sql_row['a_xs']*$a_plies;
	$a_s=$sql_row['a_s']*$a_plies;
	$a_m=$sql_row['a_m']*$a_plies;
	$a_l=$sql_row['a_l']*$a_plies;
	$a_xl=$sql_row['a_xl']*$a_plies;
	$a_xxl=$sql_row['a_xxl']*$a_plies;
	$a_xxxl=$sql_row['a_xxxl']*$a_plies;
	$remarks=$sql_row['remarks'];
	$act_cut_status=$sql_row['act_cut_status'];
	$act_cut_issue_status=$sql_row['act_cut_issue_status'];
	$maker_ref=$sql_row['mk_ref'];
	$act_plies=$sql_row['p_plies'];
	$tran_order_tid=$sql_row['order_tid'];
	$print_status=$sql_row['print_status'];
	$plies=$sql_row['a_plies'];
	
	$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
$color_code=$sql_row33['color_code']; //Color Code
	
}

//Binding Consumption / YY Calculation //Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.
	
	$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$tran_order_tid\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$bind_con=$sql_row2['binding_con']*(($sql_row['a_xs']+$sql_row['a_s']+$sql_row['a_m']+$sql_row['a_l']+$sql_row['a_xl']+$sql_row['a_xxl']+$sql_row['a_xxxl']+$sql_row['a_s01']+$sql_row['a_s02']+$sql_row['a_s03']+$sql_row['a_s04']+$sql_row['a_s05']+$sql_row['a_s06']+$sql_row['a_s07']+$sql_row['a_s08']+$sql_row['a_s09']+$sql_row['a_s10']+$sql_row['a_s11']+$sql_row['a_s12']+$sql_row['a_s13']+$sql_row['a_s14']+$sql_row['a_s15']+$sql_row['a_s16']+$sql_row['a_s17']+$sql_row['a_s18']+$sql_row['a_s19']+$sql_row['a_s20']+$sql_row['a_s21']+$sql_row['a_s22']+$sql_row['a_s23']+$sql_row['a_s24']+$sql_row['a_s25']+$sql_row['a_s26']+$sql_row['a_s27']+$sql_row['a_s28']+$sql_row['a_s29']+$sql_row['a_s30']+$sql_row['a_s31']+$sql_row['a_s32']+$sql_row['a_s33']+$sql_row['a_s34']+$sql_row['a_s35']+$sql_row['a_s36']+$sql_row['a_s37']+$sql_row['a_s38']+$sql_row['a_s39']+$sql_row['a_s40']+$sql_row['a_s41']+$sql_row['a_s42']+$sql_row['a_s43']+$sql_row['a_s44']+$sql_row['a_s45']+$sql_row['a_s46']+$sql_row['a_s47']+$sql_row['a_s48']+$sql_row['a_s49']+$sql_row['a_s50'])*$act_plies);
	}
	
	//Binding Consumption / YY Calculation //Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.

		
	echo "<tr>";
	
	echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td><td>$a_xs</td><td>$a_s</td><td>$a_m</td><td>$a_l</td><td>$a_xl</td><td>$a_xxl</td><td>$a_xxxl</td>";
	echo "<td>".($a_xs+$a_s+$a_m+$a_l+$a_xl+$a_xxl+$a_xxxl)."</td>";
	echo "<td>$act_cut_status</td><td>$act_cut_issue_status</td><td>$remarks</td>";

	echo "</tr>";
}
echo "</table>";

$sql="select mklength from $bai_pro3.maker_stat_log where tid=$maker_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$mklength=$sql_row['mklength'];
}


$fab_received=0;
$fab_returned=0;
$fab_damages=0;
$fab_shortages=0;
$fab_remarks="";
	
$sql="select * from $bai_pro3.act_cut_status where doc_no=$doc_no";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$fab_received=$sql_row['fab_received'];
	$fab_returned=$sql_row['fab_returned'];
	$fab_damages=$sql_row['damages'];
	$fab_shortages=$sql_row['shortages'];
	$fab_remarks=$sql_row['remarks'];
}


$plies_check=0;
if($act_cut_status=="DONE" and $plies<=$act_plies)
{
	$plies_check=($act_plies-$plies);
}
else
{
	$plies_check=$act_plies;
}

if($act_cut_status=="DONE")
{
	$old_plies=$plies;
}
else
{
	$old_plies=0;
}

?>


<h2>Input Entry Form</h2>
<FORM method="post" name="input" action="<?= getFullURLLevel($_GET['r'],'orders_cut_issue_status_form1_process.php',0,'N'); ?>">
<input type="hidden" name="doc_no" value="<?php echo $doc_no; ?>">


<table>


<?php
if($print_status==NULL)
{
	echo "Docket is yet to generate. Please contact your cutting head.";
}
else
{
	

echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";
echo "<table>";


echo "<tr><td>Date</td><td>:</td><td><input type=\"hidden\" name=\"date\" value=".date("Y-m-d").">".date("Y-m-d")."</td></tr>";
//echo "<tr><td>Section</td><td>:</td><td><input type=\"text\" name=\"section\" value=\"0\"></td></tr>";
echo "<tr><td>Section</td><td>:</td><td><select name=\"section\">
<option value=\"0\">SELECT SECTION</option>
<option value=\"1\">Section - 1</option>
<option value=\"2\">Section - 2</option>
<option value=\"3\">Section - 3</option>
<option value=\"4\">Section - 4</option>
</select></td></tr>";
//echo "<tr><td>Shift</td><td>:</td><td><input type=\"text\" name=\"shift\" value=\"NIL\"></td></tr>";
echo "<tr><td>Shift</td><td>:</td><td><select name=\"shift\">
<option value=\"\">SELECT TEAM</option>
<option value=\"A\">A</option>
<option value=\"B\">B</option>
</select></td></tr>";
echo "<tr><td>Doc Req</td><td>:</td><td>".(($act_plies*$mklength)+$bind_con)."</td></tr>";
echo "<tr><td>Plies</td><td>:</td><td><input type=\"hidden\" name=\"old_plies\" value=\"$old_plies\"><input type=\"text\" name=\"plies\" value=\"$plies_check\" onchange=\"if(validate(this.value,$plies_check)==1010) { this.value=0; }\"></td></tr>";
echo "<tr><td>Fab_received</td><td>:</td><td><input type=\"hidden\" name=\"old_fab_rec\" value=\"$fab_received\"><input type=\"text\" name=\"fab_rec\" value=\"0\"></td></tr>";
echo "<tr><td>Fab_returned</td><td>:</td><td><input type=\"hidden\" name=\"old_fab_ret\" value=\"$fab_returned\"><input type=\"text\" name=\"fab_ret\" value=\"0\">&nbsp; to <select name=\"ret_to\"><option value=\"0\">Cutting</option><option value=\"1\">RM</option></select></td></tr>";
echo "<tr><td>Damages</td><td>:</td><td><input type=\"hidden\" name=\"old_damages\" value=\"$fab_damages\"><input type=\"text\" name=\"damages\" value=\"0\"></td></tr>";
echo "<tr><td>Shortages</td><td>:</td><td><input type=\"hidden\" name=\"old_shortages\" value=\"$fab_shortages\"><input type=\"text\" name=\"shortages\" value=\"0\"></td></tr>";
echo "<tr><td>Bundle Locaiton</td><td>:</td><td><select name=\"bun_loc\">";
echo "<option value='' style='background-color:#FF5500;'></option>";
/* echo "<option value='1-T1-A' style='background-color:#66EEEE;'>1-T1-A</option>
<option value='1-T2-A' style='background-color:#66EEEE;'>1-T2-A</option>
<option value='1-T3-A' style='background-color:#66EEEE;'>1-T3-A</option>
<option value='1-T4-A' style='background-color:#66EEEE;'>1-T4-A</option>
<option value='1-T5-A' style='background-color:#66EEEE;'>1-T5-A</option>
<option value='1-T6-A' style='background-color:#66EEEE;'>1-T6-A</option>
<option value='1-T7-A' style='background-color:#66EEEE;'>1-T7-A</option>
<option value='1-T8-A' style='background-color:#66EEEE;'>1-T8-A</option>
<option value='1-T9-A' style='background-color:#66EEEE;'>1-T9-A</option>
<option value='1-T10-A' style='background-color:#66EEEE;'>1-T10-A</option>
<option value='1-T11-A' style='background-color:#66EEEE;'>1-T11-A</option>
<option value='1-T12-A' style='background-color:#66EEEE;'>1-T12-A</option>
<option value='1-T1-B' style='background-color:#66EEEE;'>1-T1-B</option>
<option value='1-T2-B' style='background-color:#66EEEE;'>1-T2-B</option>
<option value='1-T3-B' style='background-color:#66EEEE;'>1-T3-B</option>
<option value='1-T4-B' style='background-color:#66EEEE;'>1-T4-B</option>
<option value='1-T5-B' style='background-color:#66EEEE;'>1-T5-B</option>
<option value='1-T6-B' style='background-color:#66EEEE;'>1-T6-B</option>
<option value='1-T7-B' style='background-color:#66EEEE;'>1-T7-B</option>
<option value='1-T8-B' style='background-color:#66EEEE;'>1-T8-B</option>
<option value='1-T9-B' style='background-color:#66EEEE;'>1-T9-B</option>
<option value='1-T10-B' style='background-color:#66EEEE;'>1-T10-B</option>
<option value='1-T11-B' style='background-color:#66EEEE;'>1-T11-B</option>
<option value='1-T12-B' style='background-color:#66EEEE;'>1-T12-B</option>
<option value='1-T1-C' style='background-color:#66EEEE;'>1-T1-C</option>
<option value='1-T2-C' style='background-color:#66EEEE;'>1-T2-C</option>
<option value='1-T3-C' style='background-color:#66EEEE;'>1-T3-C</option>
<option value='1-T4-C' style='background-color:#66EEEE;'>1-T4-C</option>
<option value='1-T5-C' style='background-color:#66EEEE;'>1-T5-C</option>
<option value='1-T6-C' style='background-color:#66EEEE;'>1-T6-C</option>
<option value='1-T7-C' style='background-color:#66EEEE;'>1-T7-C</option>
<option value='1-T8-C' style='background-color:#66EEEE;'>1-T8-C</option>
<option value='1-T9-C' style='background-color:#66EEEE;'>1-T9-C</option>
<option value='1-T10-C' style='background-color:#66EEEE;'>1-T10-C</option>
<option value='1-T11-C' style='background-color:#66EEEE;'>1-T11-C</option>
<option value='1-T12-C' style='background-color:#66EEEE;'>1-T12-C</option>
<option value='2-T1-A' style='background-color:#00FF77;'>2-T1-A</option>
<option value='2-T2-A' style='background-color:#00FF77;'>2-T2-A</option>
<option value='2-T3-A' style='background-color:#00FF77;'>2-T3-A</option>
<option value='2-T4-A' style='background-color:#00FF77;'>2-T4-A</option>
<option value='2-T5-A' style='background-color:#00FF77;'>2-T5-A</option>
<option value='2-T6-A' style='background-color:#00FF77;'>2-T6-A</option>
<option value='2-T7-A' style='background-color:#00FF77;'>2-T7-A</option>
<option value='2-T8-A' style='background-color:#00FF77;'>2-T8-A</option>
<option value='2-T9-A' style='background-color:#00FF77;'>2-T9-A</option>
<option value='2-T10-A' style='background-color:#00FF77;'>2-T10-A</option>
<option value='2-T11-A' style='background-color:#00FF77;'>2-T11-A</option>
<option value='2-T12-A' style='background-color:#00FF77;'>2-T12-A</option>
<option value='2-T1-B' style='background-color:#00FF77;'>2-T1-B</option>
<option value='2-T2-B' style='background-color:#00FF77;'>2-T2-B</option>
<option value='2-T3-B' style='background-color:#00FF77;'>2-T3-B</option>
<option value='2-T4-B' style='background-color:#00FF77;'>2-T4-B</option>
<option value='2-T5-B' style='background-color:#00FF77;'>2-T5-B</option>
<option value='2-T6-B' style='background-color:#00FF77;'>2-T6-B</option>
<option value='2-T7-B' style='background-color:#00FF77;'>2-T7-B</option>
<option value='2-T8-B' style='background-color:#00FF77;'>2-T8-B</option>
<option value='2-T9-B' style='background-color:#00FF77;'>2-T9-B</option>
<option value='2-T10-B' style='background-color:#00FF77;'>2-T10-B</option>
<option value='2-T11-B' style='background-color:#00FF77;'>2-T11-B</option>
<option value='2-T12-B' style='background-color:#00FF77;'>2-T12-B</option>
<option value='2-T1-C' style='background-color:#00FF77;'>2-T1-C</option>
<option value='2-T2-C' style='background-color:#00FF77;'>2-T2-C</option>
<option value='2-T3-C' style='background-color:#00FF77;'>2-T3-C</option>
<option value='2-T4-C' style='background-color:#00FF77;'>2-T4-C</option>
<option value='2-T5-C' style='background-color:#00FF77;'>2-T5-C</option>
<option value='2-T6-C' style='background-color:#00FF77;'>2-T6-C</option>
<option value='2-T7-C' style='background-color:#00FF77;'>2-T7-C</option>
<option value='2-T8-C' style='background-color:#00FF77;'>2-T8-C</option>
<option value='2-T9-C' style='background-color:#00FF77;'>2-T9-C</option>
<option value='2-T10-C' style='background-color:#00FF77;'>2-T10-C</option>
<option value='2-T11-C' style='background-color:#00FF77;'>2-T11-C</option>
<option value='2-T12-C' style='background-color:#00FF77;'>2-T12-C</option>"; */
echo "<option value='3-T1-A' style='background-color:#FFFFAA;'>3-T1-A</option>
<option value='3-T2-A' style='background-color:#FFFFAA;'>3-T2-A</option>
<option value='3-T3-A' style='background-color:#FFFFAA;'>3-T3-A</option>
<option value='3-T4-A' style='background-color:#FFFFAA;'>3-T4-A</option>
<option value='3-T5-A' style='background-color:#FFFFAA;'>3-T5-A</option>
<option value='3-T6-A' style='background-color:#FFFFAA;'>3-T6-A</option>
<option value='3-T7-A' style='background-color:#FFFFAA;'>3-T7-A</option>
<option value='3-T8-A' style='background-color:#FFFFAA;'>3-T8-A</option>
<option value='3-T9-A' style='background-color:#FFFFAA;'>3-T9-A</option>
<option value='3-T10-A' style='background-color:#FFFFAA;'>3-T10-A</option>
<option value='3-T1-B' style='background-color:#FFFFAA;'>3-T1-B</option>
<option value='3-T2-B' style='background-color:#FFFFAA;'>3-T2-B</option>
<option value='3-T3-B' style='background-color:#FFFFAA;'>3-T3-B</option>
<option value='3-T4-B' style='background-color:#FFFFAA;'>3-T4-B</option>
<option value='3-T5-B' style='background-color:#FFFFAA;'>3-T5-B</option>
<option value='3-T6-B' style='background-color:#FFFFAA;'>3-T6-B</option>
<option value='3-T7-B' style='background-color:#FFFFAA;'>3-T7-B</option>
<option value='3-T8-B' style='background-color:#FFFFAA;'>3-T8-B</option>
<option value='3-T9-B' style='background-color:#FFFFAA;'>3-T9-B</option>
<option value='3-T10-B' style='background-color:#FFFFAA;'>3-T10-B</option>
<option value='3-T1-C' style='background-color:#FFFFAA;'>3-T1-C</option>
<option value='3-T2-C' style='background-color:#FFFFAA;'>3-T2-C</option>
<option value='3-T3-C' style='background-color:#FFFFAA;'>3-T3-C</option>
<option value='3-T4-C' style='background-color:#FFFFAA;'>3-T4-C</option>
<option value='3-T5-C' style='background-color:#FFFFAA;'>3-T5-C</option>
<option value='3-T6-C' style='background-color:#FFFFAA;'>3-T6-C</option>
<option value='3-T7-C' style='background-color:#FFFFAA;'>3-T7-C</option>
<option value='3-T8-C' style='background-color:#FFFFAA;'>3-T8-C</option>
<option value='3-T9-C' style='background-color:#FFFFAA;'>3-T9-C</option>
<option value='3-T10-C' style='background-color:#FFFFAA;'>3-T10-C</option>
<option value='3-T1-D' style='background-color:#FFFFAA;'>3-T1-D</option>
<option value='3-T2-D' style='background-color:#FFFFAA;'>3-T2-D</option>
<option value='3-T3-D' style='background-color:#FFFFAA;'>3-T3-D</option>
<option value='3-T4-D' style='background-color:#FFFFAA;'>3-T4-D</option>
<option value='3-T5-D' style='background-color:#FFFFAA;'>3-T5-D</option>
<option value='3-T6-D' style='background-color:#FFFFAA;'>3-T6-D</option>
<option value='3-T7-D' style='background-color:#FFFFAA;'>3-T7-D</option>
<option value='3-T8-D' style='background-color:#FFFFAA;'>3-T8-D</option>
<option value='3-T9-D' style='background-color:#FFFFAA;'>3-T9-D</option>
<option value='3-T10-D' style='background-color:#FFFFAA;'>3-T10-D</option>
</select>
</td></tr>";
//echo "<tr><td>remarks</td><td>:</td><td><input type=\"text\" name=\"remarks\" value=\"NIL\"></td></tr>";

echo "<tr><td><input type=\"hidden\" name=\"remarks\" value=\"$fab_remarks\"><input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable</td><td></td><td><INPUT TYPE = \"Submit\" Name = \"Update\" VALUE = \"Update\"></td></tr>";

echo "</table>";
}
?>

</table>
</form>

</div></div>
</body>
</html>
