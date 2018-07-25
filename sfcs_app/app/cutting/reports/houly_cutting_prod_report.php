<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
//$url1 = getURL(getBASE($_GET['r'])['base'].'/'.csr_view_V2.php)['url'];

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R'));

?>
	
</head>
<body>
<div class="panel panel-primary">
	<div class="panel-heading">Hourly Cutting Production Report</div>
	<div class="panel-body">
		<form method="post" class="form-inline" name="input" action="index.php?r=<?php echo $_GET['r']; ?>">
			<div class="form-group">
				<label for="date">Enter Date:</label>
				<input type="text" data-toggle="datepicker" id="from_date" class="form-control" name="from_date" size=12 value="<?php if($from_date=="") {echo  date("Y-m-d"); } else {echo $from_date;}?>"> 
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Show</button>
		</form>
	
<?php

if(isset($_POST['submit']))
{
	$from_date=$_POST['from_date'];
	$total_hours = $plant_end_time - $plant_start_time;
	list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
	$hour_start = $hour + 1;
	?>
	<hr>
	<div class="panel panel-info">
		<div class="panel-heading"><center><h4><strong>Hourly Cutting Production Report for <?php echo $from_date;?></strong></h4></center></div>
			<style type="text/css">
				table, tr, th, td {
					text-align:center;
					color:black;
					border: 1px solid black;
					border-collapse: collapse;
				}
			</style>
			
		<?php
<<<<<<< HEAD
		echo "<div class=\"table-responsive\"><table class='table'><tr class='danger'><th rowspan=2>Cutting<br>Section</th><th colspan=$total_hours>Time</th><th rowspan=2>Cut Qty</th><th rowspan=2>Yards</th><th rowspan=2># of Docket</th></tr>";
=======
		echo "<table class='table'><tr class='table table-bordered'><th rowspan=2>Cutting<br>Section</th><th colspan=$total_hours>Time</th><th rowspan=2>Cut Qty</th><th rowspan=2>Yards</th><th rowspan=2># of Docket</th></tr>";
>>>>>>> dac8a1b08e794889b945c7e5c0531bf06a70cc63
	   	echo "<tr class='warning'>";
	   	$query='';
	   	for ($i=0; $i < $total_hours; $i++)
		{
			$hour1=$hour++ + 1;
			$to_hour = $hour1.":".$minutes;
			$query.= "IF((TIME(log_time) BETWEEN TIME('".($hour-1).":30:00') AND TIME('".$hour.":30:00')),SUM(tot_cut_qty),0) AS 
			".$hour."_val,";
			echo "<th>$to_hour</th>";
			$hour_end = $hour1;
		}
		echo "</tr>";
		// echo "<table class='table'><tr class='danger'><th rowspan=2>Section</th><th colspan=11>Time</th><th rowspan=2>Cut Qty</th><th rowspan=2>Yards</th><th rowspan=2># of Docket</th></tr>";
		// echo "<tr class='warning'><th>8.30 am</th><th>9.30 am</th><th>10.30 am</th><th>11.30 am</th><th>12.30 pm</th><th>1.30 pm</th><th>2.30 pm</th><th>3.30 pm</th><th>4.30 pm</th><th>5.30 pm</th><th>6.30 pm</th></tr>";
		// Section A Start
		$grand_tot_no_of_doc=$grand_tot_cut_qty=0;
		$cutting_tbl_query= "SELECT tbl_id FROM $bai_pro3.tbl_cutting_table order by tbl_id*1";
		$cutting_tbl_result=mysqli_query($link, $cutting_tbl_query) or exit("Sql Error1.2022");
		while($tbl_id=mysqli_fetch_array($cutting_tbl_result))
		{
			$tbl_id=$tbl_id['tbl_id'];
			$sql2="SELECT $query ROUND((SUM(fab_received)-(SUM(damages)+SUM(shortages))),2) AS tot_fab,COUNT(doc_no)  AS doc_count FROM $bai_pro3.cut_dept_report WHERE date= \"$from_date\" and section=$tbl_id";
			 // echo '<br>'.$sql2;
			// $sql2="SELECT * FROM $bai_pro3.cut_dept_report WHERE date= \"$from_date\" and section=$tbl_id";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<tr><td>".$tbl_id."</td>";
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$total_qty = 0;
				for ($val=$hour_start; $val <= $hour_end; $val++)
				{ 
					$row = $sql_row2[$val.'_val'];
					$total_qty = $total_qty + $row;
					echo "<td>$row</td>";
				}
				
				$doc_count=$sql_row2['doc_count'];
				$tot_fab=$sql_row2['tot_fab'];
				if ($tot_fab == "")
				{
					$tot_fab=0;
				}
				echo "<td>".$total_qty."</td><td>".$tot_fab."</td><td>".$doc_count."</td>";
			}
			echo "</tr>";
			$grand_tot_cut_qty=$grand_tot_cut_qty+$total_qty;
			$grand_tot_no_of_doc=$grand_tot_no_of_doc+$doc_count;
			$tot_yards=$tot_yards+$tot_fab;
		}

		// Section A End
		echo "<tr class='danger'><th>Total:</th><th colspan=$total_hours></th><th>$grand_tot_cut_qty</th><th>$tot_yards</th><th>$grand_tot_no_of_doc</th></tr>";
		echo "</table></div>
	</div>";
}
		?>
		<div class="panel-body">
			</div>
		</div>
	</div>
</div>

</body>

</html>