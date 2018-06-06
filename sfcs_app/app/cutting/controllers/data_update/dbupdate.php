
<?php
	// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
	// set_time_limit(2000);
?>

<script language="javascript" type="text/javascript" 
	src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',4,'R');?>">
</script>

<body>
	<?php 
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
		// include("../".getFullURLLevel($_GET['r'],'/common/config/menu_content.php',4,'R')); 
	?>
	<?php 
		error_reporting(E_ALL ^ E_NOTICE);
	?>

	<?php
		$filename = $_POST['id'];
		mysqli_query($link, "truncate shipment_plan");
		mysqli_query($link, "truncate order_plan");

		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($filename);
		$row_count = 0;
		// Loop through each line
		$url = getFullURL($_GET['r'],'upload_ac.php','N');
		foreach ($lines as $line_num => $line) {
			// Only continue if it's not a comment
			if (substr($line, 0, 2) != '--' && $line != '') {
				// Add this line to the current segment

				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					$row_count++;
					// Perform the query
			//		mysqli_query($link, $templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysqli_error($GLOBALS["___mysqli_ston"]) . '<br /><br />');

					mysqli_query($link, $templine) or 
					exit("<script>
							swal('File has no proper data to upload','','error');
							setTimeout(function(){
								location.href = '$url';
							},3000);
						</script>");
					// Reset temp variable to empty
					$templine = '';
				}
			}
		}

		$dir = '../cache/';
		foreach(glob($dir.'*.*') as $v){
			unlink($v);
		}
		if($row_count > 0){
			echo "<div class='alert alert-info alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Database UPDATED Successfully.</strong></div>";
			
			echo '<div class="panel panel-primary" style="height:150px;"><div class="panel-heading">Data Upload</div><div class="panel-body">';

			if(substr($filename,0,2)=="SP")
			{
				$url = getFullURL($_GET['r'],'ssc_plan_process.php','N');
				echo "<br/><br/><a href=$url  class='btn btn-primary' >Click here to process</a>";
			}
			else
			{
				// echo getFullURLLevel($_GET['r'],'/DB_MSSQL_Conn_TEST/CMS/ssc_plan_process.php',2,'N');
				$url=getFullURL($_GET['r'],'ssc_porcess4.php','N');
				echo "<br/><br/><a href=$url class='btn btn-primary'>click me to check Analysis Report</a>";
			}
			echo '</div></div>';
		
		}else{
			$url = getFullURL($_GET['r'],'upload_ac.php','N');
			echo "<script>
				swal('File has no proper data to upload','','error');
				setTimeout(function(){
					location.href = '$url';
				},3000);
			</script>";
		}
		

	?>
</body>




