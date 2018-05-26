<?php
	if(isset($_GET['style_id']) && isset($_GET['schedule']) && isset($_GET['color'])&&isset($_GET['cut_id'])&&isset($_GET['operation_code'])&&isset($_GET['sewing_order'])){
		//get list of bundles for the above sewing order
		$bundles_list_qry="select group_concat(bundle_number) as bundles ";
	}
?>