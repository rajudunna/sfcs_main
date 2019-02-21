<?php

include($_SERVER['DOCUMENT_ROOT'].'/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/common/config/functions.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/common/config/mo_filling.php'); 


/*

ids need to delete after job runs - 
cps id  -- 6191,6192
bcd ids -- 342057,342058
moq     -- 341348

*/
$delete_query = "DELETE from bai_pro3.mo_operation_quantites where id = 341348";
mysqli_query($link,$delete_query);

$counter = 0;
$docs = [4295,4280,4281,4282,4283,4284,4285,4286,4287,4288,4289,4290,4291,4292,4293,4294,4296,4297];
echo "Script Started<br/>";
foreach($docs as $doc){
	 doc_size_wise_bundle_insertion($doc,1);
	 $counter++;
}
echo "<br/>$counter dockets Inserted Successfully";


?>