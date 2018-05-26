<?php


//CR#394 / kirang / 2015-11-25 / Need to show summary of batches and update the log time for fully filled batches. Total Batches || Updated Batches || Pending Batches || Passed Batches || Failed Batches

?>
<?php


	$sqla="select * from $bai_rm_pj1.supplier_performance_track where DATE(grn_date) between \"".$sdate."\" AND \"".$edate."\"";
	$sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	$total_batches=mysqli_num_rows($sql_resulta);
	
	$sql1b="select * from $bai_rm_pj1.supplier_performance_track where DATE(grn_date) between \"".$sdate."\" AND \"".$edate."\" AND LENGTH(srdfs)>0 AND LENGTH(srtfs)>0 AND LENGTH(srdfsw)>0 AND LENGTH(reldat)>0 AND LENGTH(quality)>0 AND LENGTH(rms)>0 AND LENGTH(const)>0 AND LENGTH(syp)>0 AND LENGTH(qty_insp_act)>0 AND LENGTH(defects)>0 AND LENGTH(skew_cat_ref)>0 AND LENGTH(sup_test_rep)>0 AND LENGTH(inspec_per_rep)>0 AND LENGTH(cc_rep)>0 AND LENGTH(fab_tech)>0";
	$sql_result1b=mysqli_query($link, $sql1b) or exit("Sql Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	$total_batches_updated=mysqli_num_rows($sql_result1b);
	
	$sql2c="select * from $bai_rm_pj1.supplier_performance_track where DATE(grn_date) between \"".$sdate."\" AND \"".$edate."\" AND impact=\"Yes\"";
	$sql_result2c=mysqli_query($link, $sql2c) or exit("Sql Error".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
	$total_batches_fail=mysqli_num_rows($sql_result2c);
	
	$table_1="";
	$table_1.="<h4>Total Batches : <b>".$total_batches."</b> || ";
	
	$table_1.="Updated Batches : <b>".$total_batches_updated."</b> || ";
	
	$table_1.="Pending Batches : <b>".($total_batches-$total_batches_updated)."</b> || ";
	
	$table_1.="Passed Batches : <b>".($total_batches-$total_batches_fail)."</b> || ";
	
	$table_1.="Failed Batches : <b>".$total_batches_fail."</b></h4>";

	echo $table_1;


?>