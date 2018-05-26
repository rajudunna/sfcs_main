<?php
$url1 = getFullURLLevel($_GET['r'],'controllers/mrn_request_form_v2.php',1,'N');
$url2 = getFullURLLevel($_GET['r'],'controllers/mrn_form_log.php',1,'N');
echo "<div><strong>MRN Navigator: </strong><a href='".$url1."' class='btn btn-info'> New Request</a> | ";
echo "<a href='".$url2."' class='btn btn-warning'>MR Log</a> | </div><br/>";
?>