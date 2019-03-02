
<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php'); 


$counter = 0;
$docs = [11112,11113,11114,11115,11116,11117,11118,11119,11120,11122,11123,11124,11125,11126,11127,11128,11129,11130,11753];
echo "Script Started<br/>";
foreach($docs as $doc){
     doc_size_wise_bundle_insertion($doc);
	 $counter++;
}
echo "<br/>$counter dockets Inserted Successfully";
$update_query = "UPDATE bai_pro3.plandoc_stat_log set act_cut_status = '' 
				 where doc_no IN (11112,11113,11114,11115,11116,11117,11118,11119,11120,11122,11123,11124,11125,11126,11127,11128,11129,11130,11753)";
mysqli_query($link,$update_query);			 
echo "<br/>Revereted Cuts Also";
?>



