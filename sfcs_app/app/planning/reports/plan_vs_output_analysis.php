<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// $view_access=user_acl("SFCS_0045",$username,1,$group_id_sfcs); 
?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
	function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
		// d1 = new Date(val1);
		// d2 = new Date(val2);
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
    }
	

	</script>
	<!--<script type="text/javascript" src="<?= getFullURL($_GET['r'],'jsdatepick-calendar/jsDatePick.min.1.3.js','R')?>"></script>-->
	<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R')?>"></script>
   <link href="<?= getFullURLLevel($_GET['r'],'common/css/jsDatePick_ltr.min.css',1,'R') ?>" rel="stylesheet" type="text/css" />
       <link href="<?= getFullURL($_GET['r'],'common/css/ddcolortabs.css',3,'R') ?>" rel="stylesheet" type="text/css" />

<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />


<div class="panel panel-primary">
<div class="panel-heading">Plan Achievement Report</div>
<div class="panel-body">
<div class="form-group">
<form method="POST" action="index.php?r=<?php echo $_GET['r']; ?>">
<?php
$sdate=$_POST['dat1'];
$edate=$_POST['dat2'];
$section=$_POST['section'];
?>
<div clas="row">
<div class="col-sm-3">
Start Date: <input type="text" id="demo1" data-toggle="datepicker" class="form-control"  name="dat1" value=<?php if($sdate!="") { echo $sdate; } else { echo date("Y-m-d"); } ?> >
</div>
<div class="col-sm-3">
End Date: <input type="text" id="demo2" data-toggle="datepicker" class="form-control"  name="dat2" value=<?php if($edate!="") { echo $edate; } else { echo date("Y-m-d"); } ?> >
</div>
<div class="col-sm-3">
Section:
<?php
echo "<select name=\"section\" class=\"form-control\">";
    echo "<option value=\"0\">All</option>";
	$sql="SELECT sec_id as secid FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
	$result17=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($result17))
	{
		$sql_sec=$sql_row["secid"];
		
		echo "<option value=\"".$sql_sec."\">".$sql_sec."</option>";
			
	}
	echo "</select>";	
	?>
</div></br>
<div class="col-sm-3">
&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="btn btn-info" value="submit" onclick="return verify_date()">
</div>
</div>
</form>
</div>

<?php

if(isset($_POST['submit']))
{
	$sql_row_new1=0;
	$edate=$_POST['dat2'];
	$sdate=$_POST['dat1'];
	$section=$_POST['section'];


// Table print
$criteria="";
if($section!=0)
{
	$criteria=" and section=".$section;
}
$module_db=array();
$sql_new1="select distinct module from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" $criteria order by module*1";
$sql_result_new1=mysqli_query($link, $sql_new1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_new1=mysqli_fetch_array($sql_result_new1))
{
	$module_db[]=$sql_row_new1['module'];
}
echo "<br/><h4 style='color:#286090'><center><span class='label label-success'>Daily Plan Achievement Report</span></center></h4>";
echo "<div  class ='table-responsive'>";
echo "<div class='pull-right' id='export_excel'></div>";
echo "<table  border=1 class='table table-bordered' >";
$table.="<h2>Daily Plan Achievement Report</h2><table border=1>";

echo "<tr>";
$table.="<tr>";
echo "<th colspan=2>Section</th>";
$table.="<th colspan=2></th>";

for($i=0;$i<sizeof($module_db);$i++)
{
	echo "<th colspan=4>".$module_db[$i]."</th>";
	$table.="<th colspan=4>".$module_db[$i]."</th>";
}

echo "</tr>";
$table.="</tr>";

echo "<tr>";
$table.="<tr>";
echo "<th>Date</th><th>Day</th>";
$table.="<th>Date</th><th>Day</th>";

for($i=0;$i<sizeof($module_db);$i++)
{
	$sql_row_new1++;
	echo "<th>Style</th>";
	$table.="<th>Style</th>";
	echo "<th>Plan</th>";
	$table.="<th>Plan</th>";
	echo "<th>Actual</th>";
	$table.="<th>Actual</th>";
	echo "<th>Diff.</th>";
	$table.="<th>Diff.</th>";
}
echo "</tr>";

$table.="</tr>";


$sql222_new="select distinct date from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" order by date";
//mysql_query($sql222_new,$link) or exit("Sql Error".mysql_error());
$sql_result222_new=mysqli_query($link, $sql222_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row222_new=mysqli_fetch_array($sql_result222_new))
{
	$date=$sql_row222_new['date'];
	

	
	echo "<tr class='tblheading'>";
	$table.="<tr>";
	echo "<td class=\"new\">$date</td>";
	$table.="<td>$date</td>";
	echo "<td class=\"new\">".date("l",strtotime($date))."</td>";
	$table.='<td>'.date("l",strtotime($date))."</td>";
	
	$check=0;
	for($i=0;$i<sizeof($module_db);$i++)
	{
		$mod=$module_db[$i];
		
		if($check==0)
		{
			$bgcolor="#ffffaa";	
			$check=1;
		}
		else
		{
			$bgcolor="#99ffee";
			$check=0;
		}
		
		$sql2="select styles, coalesce(sum(plan_out),0) as \"plan_out\",  coalesce(sum(act_out),0) as \"act_out\" from $bai_pro.grand_rep where date=\"$date\" and module=$mod group by module";
		//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$plan_output=round($sql_row2['plan_out'],0);
			$act_output=round($sql_row2['act_out'],0);
			$style=$sql_row2['styles'];
		}
		echo "<td bgcolor=$bgcolor>$style</td>";
		$table.="<td bgcolor=$bgcolor>$style</td>";
		echo "<td bgcolor=$bgcolor>$plan_output</td>";
		$table.="<td bgcolor=$bgcolor>$plan_output</td>";
		echo "<td bgcolor=$bgcolor>$act_output</td>";
		$table.="<td bgcolor=$bgcolor>$act_output</td>";
		echo "<td bgcolor=$bgcolor>".($act_output-$plan_output)."</td>";
		$table.="<td bgcolor=$bgcolor>".($act_output-$plan_output)."</td>";
	}
	echo "</tr>";
	$table.="</tr>";
}
if($sql_row_new1 == 0){
     echo"<tr><td colspan=2 style='color:red'><b><center>No Data Found</center></b></td></tr>";
}
echo "</table>";
$table.="</table>";
 echo "</div>";
 
 echo "<div id='div-1a'> 
<form  name='input' action= ".getFullURL($_GET['r'],'plan_vs_output_analysis_excel.php','R')." method='post'>
<input type='hidden' name='table' value='<?php echo $table; ?>'>
<input type='submit' name='submit1' value='Export to Excel' class='btn btn-info'>
</form>
</div>";
}


?>

</div>
</div>

<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>

<style>
	th{
		text-align:center;
	}
</style>
<script>
$('#export_excel').html($('#div-1a'));
</script>


