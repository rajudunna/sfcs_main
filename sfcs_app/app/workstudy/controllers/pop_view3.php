<!--
Ticket #742482/ popup window for Down time reasons
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<link rel="stylesheet" type="text/css" href="../../../common/css/bootstrap.min.css">
<title>Downtime Reasons</title>    

		<script type="text/javascript" src="../../../common/js/TableFilter/jquery.min1.7.1.js"></script>	
		<script type="text/javascript" language="javascript" src="../../../common/js/TableFilter/tablefilter.js"></script> 
<body>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
?>

<div class="panel panel-primary">
<div class="panel-heading">Select Downtime Reason</div>
<div class="panel-body">
<?php

$dep_id=$_GET['dep_id'];
$row_id=$_GET['row_id'];

echo "<input type=\"hidden\" name=\"dep_id\" value=\"$dep_id\" id=\"dep_id\">";
echo "<input type=\"hidden\" name=\"row_id\" value=\"$row_id\" id=\"row_id\">";

echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"Confirm\" onclick=\"checkedvalue();\">";
echo '<table id="tableone" cellspacing="0" class="table table-bordered">';
	echo "<tr><th>Reason Code</th><th>Functional Dept</th><th>Responsible Dept</th><th>Reason</th><th>Select</th><tr>";

if($_GET['dep_id'])
{
	$sqll1="SELECT * FROM $bai_pro.down_reason where dep_id=$dep_id";	
}
else
{
	$sqll1="SELECT * FROM $bai_pro.down_reason where sno>=295 order by down_machine,down_problem,down_reason";
}
$sqll1="SELECT * FROM $bai_pro.down_reason where sno>=295 order by down_machine,down_problem,down_reason";
//echo $sql1;
$sql_resultl1=mysqli_query($link, $sqll1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_rowl1=mysqli_fetch_array($sql_resultl1))
{
	$machine_prob=$sql_rowl1['down_problem'];
	$machine_type=$sql_rowl1['down_machine'];
	$dep_id_ref=$sql_rowl1['dep_id'];
    $sno=$sql_rowl1['sno'];
	$machine_res=$sql_rowl1['down_reason'];
	echo "<tr><td style='text-align: center;' >$sno </td><td style='text-align: center;'>$machine_type</td><td style='text-align: center;' >$machine_prob</td><td style='text-align: center;'>$machine_res</td><td style='text-align: center;'><input type='radio' name='cat_code' id='myradio' value='$sno&$dep_id_ref'></tr>";		
}

echo '</table></div></div></body>';
?>

<script language="javascript" type="text/javascript">
	var table2_Props = {
	    col_0: "none",
		col_1: "checklist",
		col_2: "checklist",
		col_3: "checklist",
		col_4: "none",
		refresh_filters: false,
	    display_all_text: "[ALL]",
	    sort_select: true,
		fixed_headers: true, tbody_height: 600
	};
	var tf2 = setFilterGrid("tableone", table2_Props);  	
</script>
<script>
	function checkedvalue()
	{
		var st=$('input[name="cat_code"]:checked').val();
		var result=st.split("&"); 
		var x=result[0];	
		var dep_id=result[1];
		var row_id=document.getElementById('row_id').value;
		if(parseInt(x)>0)
		{
			var myVal=row_id+'$'+x+'$'+dep_id;
		 	window.opener.GetValueFromChild(myVal);
	        window.close();
		}
		
	}	
</script>