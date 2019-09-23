<?php
// $data = json_decode(stripslashes($_POST['data']));
$myArray = $_REQUEST['data'];
// var_dump($myArray);

foreach ($myArray as $key => $value) {
    var_dump($value['11']);die();
}
// $sql="insert into $bai_pro3.maker_details(parent_id,marker_type,marker_version,shrinkage_group,width,marker_length,marker_name,
// pattern_name,marker_eff,perimeters,remarks) values()";
// $sql="insert into $bai_pro3.maker_stat_log(cat_ref,marker_type,marker_version,shrinkage_group,width,marker_length,marker_name,
// pattern_name,marker_eff,perimeters,remarks) values()";
// foreach($myArray as $d){
//    echo $d;
// }
?>