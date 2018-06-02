<?php

include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf2.php',1,'R'));
?>

<html>
<head>

<script language="javascript" type="text/javascript" src="../datetimepicker_css.js"></script>

<script language="javascript" type="text/javascript" src="../styles/dropdowntabs.js"></script>
</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Log Details</div>	
<div class="panel-body">
	<?php
		$mod=$_GET['module'];
		$date=$_GET['date'];
	?>
		<div class="btn btn-warning">
			<?="Module Code: ".$mod;?>
		</div>
		<?php
		$h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
		$h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24);
		
		
		echo "<div class='table-responsive scrollme'> <table id=\"info\" class='table'>";

		echo "<tr style='background-color:#4b6d3d;color:white'>
			<th>SNo</th>
			<th>Last Up</th>
			<th>Style</th>
			<th>Stat</th>
			<th>Qty</th>
			<th>Shift</th>
			<th>Remarks</th>
			</tr>";

		$i=1;
		$total;
		$sql="select * from bai_log where bac_no=$mod and bac_date=\"$date\" order by bac_lastup";
		// echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$shift=$sql_row['bac_shift'];
			$stat=$sql_row['bac_stat'];
			$style=$sql_row['bac_style'];
			$qty=$sql_row['bac_Qty'];
			$remarks=$sql_row['bac_remarks'];
			$lastup=$sql_row['bac_lastup'];

			if($qty=="")
				$qty=0;

			echo "<tr style='background-color:#ccc9cb;color:black'>
			<td>".$i."</td>
			<td>".$lastup."</td>
			<td>".$style."</td>
			<td>".$stat."</td>
			<td>".$qty."</td>
			<td>".$shift."</td>
			<td>".$remarks."</td>
			</tr>";
			$i=$i+1;
			$total=$total+$qty;
		}	
			echo "<br/><tr style='background-color:#4b6d3d;color:white'><th colspan=4 style='text-align:right'>Total = </th><td>".$total."</td><td></td><td></td></tr>";
		echo "</div></table>";

	?>

</div>
</div>
<style>
#info {

}
</style>
</body>
</html>

