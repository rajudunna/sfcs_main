
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	   ?>

<?php

$table="upload";
$table1="packing_summary";
$table2="packing_summary_tmp";

$edit_users=array("sureshn","amulyap","eswarammae","lakshmik");
//$edit_users=user_acl("SFCS_0033",$username,2,$group_id_sfcs);


$path_destrcution = getFullURLLevel($_GET['r'],'common/images/destruction_photos',1,'R');
$path_style_level = getFullURLLevel($_GET['r'],'common/images/destruction_photos_style_level',1,'R');

//These below are not part of sfcs ui they are out of ui.So manuak path
$image_path =  $_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/images',1,'R').'/';
$newname    =  $_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/images',1,'R');
$thumb_name =  $_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/images',1,'R');
?>