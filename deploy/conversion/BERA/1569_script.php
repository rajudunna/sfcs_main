<?php

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php'); 


/*

ids need to delete after job runs - 
cps id  -- 6191,6192
bcd ids -- 342057,342058
moq     -- 341348

*/
// $delete_query = "DELETE from bai_pro3.mo_operation_quantites where id = 341348";
// mysqli_query($link,$delete_query);

$counter = 0;
//$docs = [4295,4280,4281,4282,4283,4284,4285,4286,4287,4288,4289,4290,4291,4292,4293,4294,4296,4297];
//$docs = [4300,4301,4302,4303,4304,4305,4306,4307,4308,4309,4310,4311,4312,4313,4314,4315];
$docs = [4318];
echo "Script Started<br/>";
foreach($docs as $doc){
	 doc_size_wise_bundle_insertion($doc,1);
	 $counter++;
}
echo "<br/>$counter dockets Inserted Successfully";

$up1 = "UPDATE bai_pro3.cps_log SET reported_status='F',remaining_qty=cut_quantity WHERE doc_no IN (4318) AND operation_code = 15";
mysqli_query($link,$up1);
 
$up2 = "UPDATE brandix_bts.bundle_creation_data SET recevied_qty = original_qty WHERE docket_number IN (4318) AND operation_id = 15";
mysqli_query($link,$up2); 
echo "<br/>Updated Also Successfully";

?>