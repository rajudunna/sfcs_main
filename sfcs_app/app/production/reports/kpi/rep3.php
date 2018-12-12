
<?php 
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
 $view_access=user_acl("SFCS_0026",$username,1,$group_id_sfcs);
 ?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',2,'R'); ?>"></script>


<div class="panel panel-primary">
<div class="panel-heading">RM Availability</div>
<div class="panel-body">

<form name="test" method="post" action="<?php echo '?r='.$_GET['r']; ?>">
<div class="row">
<div class="col-md-3 form-group">
<label>From Date: </label><input type="text" class="form-control" data-toggle='datepicker' name="fdate" size="8" id="demo1" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" >
</div>
<div class="col-md-3 form-group">
<label>To Date: </label><input type="text" class="form-control" data-toggle='datepicker' name="tdate" size="8" id="demo2" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" >
</div>
<div class="col-md-3 form-group">
<input type="submit" name="submit" value="Show" class="btn btn-primary" style="margin-top:22px;"  onclick="return verify_date()">
</div>
</div>
</form>

<?php

if(isset($_POST['submit']))
{
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	
	echo "<hr/><div class='table-responsive'><table class=\"table table-bordered\">";
	
	
	$sql="select rep_date,sum(if(parameter='A1001',value,0)) as pink, sum(if(parameter='A1002',value,0)) as logo, sum(if(parameter='A1003',value,0)) as ms from $bai_kpi.kpi_tracking where rep_date between \"$fdate\" and \"$tdate\" group by rep_date";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if($sql_row=mysqli_fetch_array($sql_result))
	{


		echo "<tr>";
	echo "<th>Date</th>";
	echo "<th>Pink %</th>";
	echo "<th>Logo %</th>";
	echo "<th>M&S %</th>";
	echo "</tr>";
		echo "<tr>";
		echo "<td>".$sql_row['rep_date']."</td>";
		echo "<td>".round($sql_row['pink'],0)."</td>";
		echo "<td>".round($sql_row['logo'],0)."</td>";
		echo "<td>".round($sql_row['ms'],0)."</td>";
		echo "</tr>";
	}
	else{
		echo "<hr><div class='alert alert-danger'>No Data Found..</div>";
	}
	echo "</table></div>";
}
?>

</div>
</div>
<script >
function verify_date()
{
	var val1 = $('#demo1').val();
	var val2 = $('#demo2').val();

	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}

// <script language="javascript" type="text/javascript">
//<![CDATA[	
	var table2_Props = 	{					
				
					display_all_text: " [ Show all ] ",
					btn_reset: true,
					bnt_reset_text: "Clear all ",
					rows_counter: true,
					rows_counter_text: "Total Rows: ",
					alternate_rows: true,
					sort_select: true,
					loader: true
				};
	setFilterGrid( "table_one",table2_Props );
//]]>		
// </script>
</script>