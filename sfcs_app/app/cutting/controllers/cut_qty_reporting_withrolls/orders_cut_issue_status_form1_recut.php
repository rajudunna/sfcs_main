<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
?>


<!-- <style>
body
{
	font-family:arial;
	font-size:14px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align:left;
	vertical-align:top;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:14px;
}


</style> -->

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',2,'R'); ?>"></script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->

<script>

function validate(x,y)
{
	if(x<0 || x>y) { alert("Please enter correct plies <="+y); return 1010;  }
}

</script>

<div class="panel panel-primary">
	<div class="panel-heading">Recut Status Reporting</div>
	<div class="panel-body">
<body onload="javascript:dodisable();">



<?php
$doc_no=$_GET['doc_no'];




$sql="select * from $bai_pro3.recut_v2 where doc_no=$doc_no";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$doc_no=$sql_row['doc_no'];
	$doc_acutno=$sql_row['acutno'];
	$a_plies=$sql_row['p_plies'];
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		$a_s[$sizes_code[$s]]=$sql_row["a_s".$sizes_code[$s].""]*$a_plies;
		//echo $sql_row["a_s".$sizes_code[$s].""]*$a_plies."<br>";
	}
	$remarks=$sql_row['remarks'];
	$act_cut_status=$sql_row['act_cut_status'];
	$act_cut_issue_status=$sql_row['act_cut_issue_status'];
	$maker_ref=$sql_row['mk_ref'];
	$act_plies=$sql_row['p_plies'];
	$tran_order_tid=$sql_row['order_tid'];
	$print_status=$sql_row['print_status'];
	$plies=$sql_row['a_plies'];
	
	$sql33="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
	$color_code=$sql_row33['color_code']; //Color Code
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row33["title_size_s".$sizes_code[$s].""]<>'')
		{
			$s_tit[$sizes_code[$s]]=$sql_row33["title_size_s".$sizes_code[$s].""];
			//echo $sql_row["title_size_s".$sizes_code[$s].""]."<br>";
		}	
	}
}
echo "<table class='table table-bordered'>";
echo "<tr>";
echo "<th>Doc ID</th><th>Cut No</th>";
//echo sizeof($s_tit)."<br>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
			
	}
	echo "<th>Total</th><th>Cut Status</th><th>Cut Issue Status</th><th>Remarks</th></tr>";
	echo "<tr>";
	
	echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo "<td>".$a_s[$sizes_code[$s]]."</td>";
			
	}
	
	echo "<td>".array_sum($a_s)."</td>";
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
	
$sql="select * from $bai_pro3.act_cut_status_recut_v2 where doc_no=$doc_no";
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


<h2 align="center"><b>Input Entry Form</b></h2>
<FORM method="post" name="input" action="<?= getFullURL($_GET['r'],'orders_cut_issue_status_form1_process_recut.php','N'); ?>" onsubmit="return checkOnSubmit()">
<input type="hidden" name="doc_no" value="<?php echo $doc_no; ?>">




<?php
if($print_status==NULL)
{
	echo "<script>sweetAlert('Docket is yet to generate. Please contact your cutting head.','','error')</script>";
}
else
{
	

echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">";
echo "<table class='table table-bordered'>";
$table_q="SELECT * FROM $bai_pro3.`tbl_cutting_table` WHERE STATUS='active'";
$table_result=mysqli_query($link, $table_q) or exit("Error getting Table Details");
while($tables=mysqli_fetch_array($table_result))
{
	$table_name[]=$tables['tbl_name'];
	$table_id[]=$tables['tbl_id'];
}

echo "<tr><td>Date</td><td>:</td><td><input type=\"hidden\" name=\"date\" value=".date("Y-m-d").">".date("Y-m-d")."</td></tr>";
//echo "<tr><td>Section</td><td>:</td><td><input type=\"text\" name=\"section\" value=\"0\"></td></tr>";
echo "<tr><td>Section</td><td>:</td><td><div class='row col-md-4'><select name=\"section\" class='form-control' id='table'>
<option value=\"0\">Select Table</option>";
for($i = 0; $i < sizeof($table_name); $i++)
{
	echo "<option value='".$table_id[$i]."' style='background-color:#FFFFAA;'>".$table_name[$i]."</option>";
}
echo "</select></div></td></tr>";
//echo "<tr><td>Shift</td><td>:</td><td><input type=\"text\" name=\"shift\" value=\"NIL\"></td></tr>";
echo "<tr><td>Shift</td><td>:</td><td><div class='row col-md-4'><select name=\"shift\" class='form-control' id='team'>
<option value=\"\">Select Shift</option>";
foreach($shifts_array as $key=>$shift){
	echo "<option value='$shift'>$shift</option>";
}
	echo "</select></div></td></tr>";

$team_query="SELECT * FROM $bai_pro3.tbl_leader_name";
$team_result=mysqli_query($link, $team_query) or exit("Error getting Team Details");
echo "<tr>
			<td>Team Leader</td><td>:</td>
		<td><div class='col-sm-4'><select name=\"leader_name\" class='form-control'>";
echo "<option value='' selected disabled>Select Team</option>";
while($row=mysqli_fetch_array($team_result))
{
	echo "<option value='".$row['emp_name']."'>".$row['emp_name']."</option>";
}
echo "</select></div>
	</td></tr>";		
echo "<tr><td>Doc Req</td><td>:</td><td>".($act_plies*$mklength)."</td></tr>";
echo "<tr><td>Plies</td><td>:</td><td><input type=\"hidden\" name=\"old_plies\" value=\"$old_plies\"><div class='row col-md-4'><input type=\"text\" class='form-control' name=\"plies\" value=\"$plies_check\" onchange=\"if(validate(this.value,$plies_check)==1010) { this.value=0; }\"></div></td></tr>";
echo "<tr><td>Fab_received</td><td>:</td><td><input type=\"hidden\" name=\"old_fab_rec\" value=\"$fab_received\"><div class='row col-md-4'><input type=\"text\" class='form-control' name=\"fab_rec\" value=\"0\"></div></td></tr>";
echo "<tr><td>Fab_returned</td><td>:</td><td><input type=\"hidden\" name=\"old_fab_ret\" value=\"$fab_returned\"><div class='row col-md-4'><input type=\"text\" class='form-control' name=\"fab_ret\" value=\"0\"></div></td></tr>";
echo "<tr><td>Damages</td><td>:</td><td><input type=\"hidden\" name=\"old_damages\" value=\"$fab_damages\"><div class='row col-md-4'><input type=\"text\" class='form-control' name=\"damages\" value=\"0\"></div></td></tr>";
echo "<tr><td>Shortages</td><td>:</td><td><input type=\"hidden\" name=\"old_shortages\" value=\"$fab_shortages\"><div class='row col-md-4'><input type=\"text\" class='form-control' name=\"shortages\" value=\"0\"></div></td></tr>";
//echo "<tr><td>remarks</td><td>:</td><td><input type=\"text\" name=\"remarks\" value=\"NIL\"></td></tr>";

echo "<input type=\"hidden\" name=\"remarks\" value=\"$fab_remarks\">";

echo "</table>";
// <input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable 
echo '<INPUT TYPE = "submit" Name = "Update" class="btn btn-primary btn-sm" VALUE = "Update" id="add">
</form>
<br/>
<div id="msg" style="display:none;" class="alert alert-danger" role="alert">Please wait while updating database...</div>';
}
?>





</body>
</div>
</div>
<script>
	function checkOnSubmit(){
		var table = document.getElementById('table').value;
		var team = document.getElementById('team').value;
		console.log(team);
		if(table == 0 || team == ""){
			sweetAlert('Please select the section and shift','','error');
			return false;
		}else{
			document.getElementById('add').style.display='none'; 
			document.getElementById('msg').style.display='';
		}
	}
</script>
