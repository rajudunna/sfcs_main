
<?php 
include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include("..".getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
 $view_access=user_acl("SFCS_0026",$username,1,$group_id_sfcs);
 ?>

<!-- <LINK href="../style.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',2,'R'); ?>"></script>
<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->


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
<input type="submit" name="submit" value="Show" class="btn btn-primary" style="margin-top:22px;">
</div>
</div>
</form>

<?php

if(isset($_POST['submit']))
{
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	
	echo "<hr/><div class='table-responsive'><table class=\"table table-bordered\">";
	echo "<tr>";
	echo "<th>Date</th>";
	echo "<th>Pink %</th>";
	echo "<th>Logo %</th>";
	echo "<th>M&S %</th>";
	echo "</tr>";
	
	$sql="select rep_date,sum(if(parameter='A1001',value,0)) as pink, sum(if(parameter='A1002',value,0)) as logo, sum(if(parameter='A1003',value,0)) as ms from $bai_kpi.kpi_tracking where rep_date between \"$fdate\" and \"$tdate\" group by rep_date";
	// echo $sql;

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['rep_date']."</td>";
		echo "<td>".round($sql_row['pink'],0)."</td>";
		echo "<td>".round($sql_row['logo'],0)."</td>";
		echo "<td>".round($sql_row['ms'],0)."</td>";
		echo "</tr>";
	}
	
	echo "</table></div>";
}
?>

</div>
</div>