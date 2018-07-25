<?php
	$sidemenus = [
		'workorders' => [
			'Add Excess Quantity(By color | By Schedule)',
			'Add Sample Quantity',
			'Clubbing(by color | by Schedule)',
			'Manage Layplan',
			'Prepare Packing',
			'Generate Jobs',
			'Manage Packing List [delete]',
			'Check-In Cartons',
			'Audit [delete]',
			'Reserve for dispatch',
			'Security Checkout',
			'Destroy',
		]
	];

	foreach ($sidemenus as $key => $value) {
		if($key == 'workorders'){
			foreach ($value as $key1 => $value1) {
				echo '<li class=""><a href="#">'.$value1.'</a>';
			}
		}	
		
	}

?>
