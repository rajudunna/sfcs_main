<?php
include"sah_data/data.php";
	$total_data = array(
		array(
			'n1' => $sah_today,
			'n2' => $avg
		 ),	
	);	
	echo $_GET['jsonp'].'('. json_encode($total_data) . ')';  
	//echo $sah_today;
?>