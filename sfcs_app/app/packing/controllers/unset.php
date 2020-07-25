
<html>
	<head>
		<style>
			body
			{
				font-family: Trebuchet MS;
			}
		</style>
	</head>
	<body>
		<?php 
			include(getFullURLLevel($_GET['r'], 'common/config/config.php', 3, 'R')); 
			$plantcode=$_SESSION['plantCode']; 
			$ship_tid=$_GET['ship_tid'];
			$sql="delete from $pps.ship_stat_log where plant_code='$plantcode' and ship_up_date='$ship_tid'";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo "<h2><font color=\"green\">Successfully Updated!</font></h2>";
			echo "<script>sweetAlert('Successfully','Updated','success');</script>";
			$url = getFullURL($_GET['r'],'test.php','N');
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = \"$url\"; }</script>";
		?>
	</body>
</html>