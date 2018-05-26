
<?php 

$tran_id=$_GET['ref_tid'];

?>
	


<body >


<div class="panel panel-primary">
	<div class="panel-heading"><b>Remarks Log</b></div>
	<div class="panel-body">
	<?php 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));



$sql="select * from $bai_rm_pj2.remarks_log where tid=\"$tran_id\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$row1=mysqli_num_rows($sql_result);
//echo "no of rows=".$row1;
if($row1>0)
{
	echo '<div class="table-responsive" >
	<table class="table table-bordered">';
	echo "<tr class='success'><th>Tid</th><th>Remarks</th><th>Username</th><th>Date</th><th>Remarks Level</th></tr>";
	while($sql_row=mysqli_fetch_array($sql_result))
	{
	echo "<tr>";
	echo "<td>".$sql_row['tid']."</td>";
		if($sql_row['remarks']=='0' || $sql_row['remarks']=='')
		{
		echo "<td>No Remarks</td>";
		}
		else
		{
		echo "<td>".$sql_row['remarks']."</td>";
		}
	echo "<td>".$sql_row['username']."</td>";	
	echo "<td>".$sql_row['date']."</td>";
	echo "<td>".$sql_row['level']."</td>";
	echo "</tr>";
	}
echo "</table></div>";
}
else
{
	echo "<div class='alert alert-info'><strong>Info!</strong>Remarks were not updated for this schedule</div>";
}

?>


</div>
</div>
</html>

