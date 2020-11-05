<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?>

<html>
<head>


<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
</head>
<body>
<div class="panel panel-primary">
<div class="panel-heading">Log Details</div>	
<div class="panel-body">
	<?php
		$mod=$_GET['module'];
		$plantcode=$_GET['plantcode'];
		$username=$_GET['username'];
		$sql66="select workstation_code from $pms.workstation where plant_code='$plantcode' and workstation_id='$mod'";
		mysqli_query($link, $sql66) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_resultx11=mysqli_query($link, $sql66) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_rowx11=mysqli_fetch_array($sql_resultx11))
		{
			$mod_name=$sql_rowx11['workstation_code'];
		}
		$date=$_GET['date'];
	?>
		<div class="btn btn-warning">
			<?="Module Code: ".$mod_name;?>
		</div>
		<?php
		$h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21);
		$h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24);
		
		
		echo "<div class='table-responsive scrollme'> <table id=\"info\" class='table'>";

		echo "<tr style='background-color:#4b6d3d;color:white'>
			<th>SNo</th>
			<th>Last Up</th>
			<th>Style</th>
			<th>Qty</th>
			<th>Shift</th>
			</tr>";

		$i=1;
		$total;
		$sql="select shift,style,good_quantity,created_at from $pts.transaction_log where plant_code='$plantcode' and resource_id='$mod' and created_at=\"$date\" order by created_at";
		// echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$shift=$sql_row['shift'];
			// $stat=$sql_row['bac_stat'];
			$style=$sql_row['style'];
			$qty=$sql_row['good_quantity'];
			$lastup=$sql_row['created_at'];

			if($qty=="")
				$qty=0;

			echo "<tr style='background-color:#ccc9cb;color:black'>
			<td>".$i."</td>
			<td>".$lastup."</td>
			<td>".$style."</td>
			<td>".$qty."</td>
			<td>".$shift."</td>
			</tr>";
			$i=$i+1;
			$total=$total+$qty;
		}	
			echo "<br/><tr style='background-color:#4b6d3d;color:white'><th colspan=2 style='text-align:right'>Total = </th><td>".$total."</td><td></td><td></td></tr>";
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

